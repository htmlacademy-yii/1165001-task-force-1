<?php
    namespace TaskForce\utils;

    use TaskForce\exceptions\RuntimeException;

    class DbHandler
    {
        static private $host = 'localhost';
        static private $user = 'root';
        static private $password = '';
        static private $database = 'taskforce';

        static public function connect(){
            try {
                $link = new \mysqli(
                    self::$host,
                    self::$user,
                    self::$password,
                    self::$database
                );
            } catch(RuntimeException $exception){
                throw new RuntimeException('Не удалось подключиться к БД');
            }

            return $link;
        }

        static function getDatabaseName(){
            return self::$database;
        }
    }
