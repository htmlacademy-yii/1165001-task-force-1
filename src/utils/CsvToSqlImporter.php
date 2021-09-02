<?php
    namespace TaskForce\utils;

    use TaskForce\exceptions\FileFormatException;
    use TaskForce\exceptions\SourceFileException;
    use TaskForce\exceptions\RuntimeException;
    use TaskForce\exceptions\DatabaseException;

    class CsvToSqlImporter
    {
        private $filename;
        private $columns;
        private $dependencies;
        private $fileObject;

        private $result = [];

        /**
         * CsvToSqlImporter конструктор
         *
         * @param string $filename
         * @param array $columns
         * @param array $dependencies
         */
        public function __construct(string $filename, array $columns, array $dependencies)
        {
            $this->filename = $filename;
            $this->columns = $columns;
            $this->dependencies = $dependencies;
        }

        /**
         * Выполнение конвертации из CSV в SQL
         *
         * @throws DatabaseException
         * @throws FileFormatException
         * @throws RuntimeException
         * @throws SourceFileException
         */
        public function convert(): void
        {
            $link = DbHandler::connect();
            $query = array();

            // проверки
            if (!$this->validateColumns($this->columns)) {
                throw new FileFormatException('Заданы неверные заголовки столбцов');
            }

            if (!file_exists($this->filename)) {
                throw new SourceFileException('Файл не существует');
            }

            try {
                $this->fileObject = new \SplFileObject($this->filename);
            } catch (RuntimeException $exception) {
                throw new SourceFileException('Не удалось открыть файл на чтение');
            }

            if ($this->getHeaderData() !== $this->columns) {
                throw new FileFormatException('Исходный файл не содержит необходимых столбцов');
            }

            // обработка
            $table_name = str_replace('.csv', '', basename($this->filename));
            $database_name = DbHandler::getDatabaseName();

            // проверка на существование таблицы
            $table_exists = $link->query("SHOW TABLES FROM {$database_name} LIKE '{$table_name}'")->num_rows;
            if (!$table_exists){
                throw new DatabaseException("Таблицы {$database_name} не существует");
            }

            // проходимся по каждой строке
            foreach ($this->getNextLine() as $line) {
                // пропуск полностью пустых строк
                $filledLine = false;
                foreach ($line as $item){
                    if ($item != ''){
                        $filledLine = true;
                    }
                }

                if (!$filledLine){
                    continue;
                }

                $prev_value = null;
                $query_parts = array();

                // проходимся по каждому полю
                foreach ($this->columns as $index => $col_name){
                    $value = isset($line[$index]) ? $link->real_escape_string($line[$index]) : null;

                    // если поле зависимо от другой таблицы - генерируем случайное значение
                    if (isset($this->dependencies[$col_name])){
                        $dependency_dataset = $this->dependencies[$col_name];
                        $rows_count = $this->getTotalRows($_SERVER['DOCUMENT_ROOT'].'/data/'.$dependency_dataset);
                        $value = rand(1, $rows_count);

                        // отбраковка повторений
                        if ($value === $prev_value){
                            while ($value === $prev_value) {
                                $value = rand(1, $rows_count);
                            }
                        }
                    }

                    // составляем тело запроса
                    $query_parts[] = "{$col_name} = '{$value}'";

                    $prev_value = $value;
                }

                // пропускаем, если тело пустое
                if (empty($query_parts)){
                    continue;
                }

                // создаем запрос и добавляем в массив с другими запросами
                $query_parts = implode(', ', $query_parts);
                $query[] = "INSERT INTO {$table_name} SET {$query_parts}";
            }

            if (empty($query)){
                throw new DatabaseException("Отсутствуют данные для импорта в таблицу {$table_name}");
            }

            // подготавливаем запрос
            $query = implode(';', $query);

            // сохраняем файл
            $filepath = $_SERVER['DOCUMENT_ROOT']."/dumps/{$table_name}.sql";
            unlink($filepath);

            try {
                $file = new \SplFileObject($filepath, 'w');
                $file->fwrite($query);
            } catch (RuntimeException $exception) {
                throw new SourceFileException('Не удалось сохранить файл');
            }

        }

        /**
         * Получение данных из файла
         *
         * @return array
         */
        public function getData(): array {
            return $this->result;
        }

        /**
         * Получение общего количества строк в файле
         *
         * @param string $file
         * @param bool $skip_first_line
         * @return int
         * @throws SourceFileException
         */
        public function getTotalRows(string $file, bool $skip_first_line = true){
            try {
                $file = new \SplFileObject($file);
            } catch (RuntimeException $exception) {
                throw new SourceFileException('Не удалось открыть файл на чтение');
            }

            $lines = 0;

            $prevFileObject = $this->fileObject;
            $this->fileObject = $file;
            foreach ($this->getNextLine() as $line) {
                // пропуск пустых строк
                if (!$line[0]){
                    continue;
                }
                $lines++;
            }

            $this->fileObject = $prevFileObject;

            if ($lines === 0){
                throw new FileFormatException('Файл пустой');
            }

            return $skip_first_line ? $lines - 1 : $lines;
        }

        /**
         * Получение массива с колонками
         *
         * @return array|null
         */
        private function getHeaderData():? array {
            $this->fileObject->rewind();
            return $this->fileObject->fgetcsv();
        }

        /**
         * Итерирование на следующую строку
         *
         * @return iterable|null
         */
        private function getNextLine():? iterable {
            $result = null;

            while (!$this->fileObject->eof()) {
                yield $this->fileObject->fgetcsv();
            }

            return $result;
        }

        /**
         * Проверка корректности колонок
         *
         * @param array $columns
         * @return bool
         */
        private function validateColumns(array $columns): bool
        {
            $result = true;

            if (count($columns)) {
                foreach ($columns as $column) {
                    if (!is_string($column)) {
                        $result = false;
                    }
                }
            } else {
                $result = false;
            }

            return $result;
        }
    }
