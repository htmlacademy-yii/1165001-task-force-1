<?php
    namespace TaskForce\Actions;

    class Task {
        /**
         * Свойства для хранения:
         * id исполнителя, id заказчика,
         * срок завершения, активный статус
         */
        public $executorId;
        public $clientId;
        public $dueDate;
        public $activeStatus;

        /**
         * Набор констант: действия, статусы, роли
         */
        const ACTIONS = [
            'publish' => 'Опубликовать',
            'cancel' => 'Отменить',
            'accept' => 'Принять',
            'complete' => 'Завершить',
            'reject' => 'Отказаться',
            'respond' => 'Откликнуться'
        ];

        const STATUSES = [
            'new' => 'Новое',
            'canceled' => 'Отменено',
            'in_progress' => 'В работе',
            'completed' => 'Выполнено',
            'failed' => 'Провалено'
        ];

        const ROLES = [
            'client' => 'Заказчик',
            'executor' => 'Исполнитель',
        ];

        /**
         * Task constructor.
         * @param $data
         */
        public function __construct($data){
            $this->executorId = $data['executor_id'];
            $this->clientId = $data['client_id'];
            $this->dueDate = $data['due_date'];
            $this->activeStatus = $data['active_status'];
        }

        /**
         * Метод, возвращающий список действий.
         *
         * @return array
         */
        public function getActionsList(){
            $actionsList = self::ACTIONS;
            return $actionsList;
        }

        /**
         * Метод, возвращающий список статусов.
         *
         * @return array
         */
        public function getStatusesList(){
            $statusesList = self::STATUSES;
            return $statusesList;
        }

        /**
         * Метод для возврата статуса, в который перейдет задача для указанного действия.
         *
         * @param $action
         * @return bool|mixed
         */
        public function statusSwitcher($action){
            switch ($action){
                case self::ACTIONS['publish']:
                    $returnedStatus = self::STATUSES['new'];
                break;

                case self::ACTIONS['cancel']:
                    $returnedStatus = self::STATUSES['canceled'];
                break;

                case self::ACTIONS['accept']:
                    $returnedStatus = self::STATUSES['in_progress'];
                break;

                case self::ACTIONS['complete']:
                    $returnedStatus = self::STATUSES['completed'];
                break;

                case self::ACTIONS['reject']:
                    $returnedStatus = self::STATUSES['failed'];
                break;

                default:
                    $returnedStatus = null;
                break;
            }

            return $returnedStatus;
        }
    }