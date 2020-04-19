<?php
    namespace TaskForce\Actions;

    class Task {
        // константы: действия, статусы, роли
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

        // свойства для хранения: id исполнителя, id заказчика, срок завершения, активный статус
        public $executorId;
        public $clientId;
        public $dueDate;
        public $activeStatus;

        public function __construct($data){
            $this->executorId = $data['executor_id'];
            $this->clientId = $data['client_id'];
            $this->dueDate = $data['due_date'];
            $this->activeStatus = $data['active_status'];
        }

        // список действий
        public function getActionsList(){
            return self::ACTIONS;
        }

        // список статусов
        public function getStatusesList(){
            return self::STATUSES;
        }

        // метод для возврата статуса, в который перейдет задача для указанного действия
        public function statusSwitcher($action){
            switch ($action){
                case self::ACTIONS['cancel']:
                    return self::STATUSES['canceled'];
                break;

                case self::ACTIONS['accept']:
                    return self::STATUSES['in_progress'];
                break;

                case self::ACTIONS['complete']:
                    return self::STATUSES['completed'];
                break;

                case self::ACTIONS['reject']:
                    return self::STATUSES['failed'];
                break;

                default:
                    return false;
                break;
            }
        }
    }