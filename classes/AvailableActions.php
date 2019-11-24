<?php
    class AvailableActions {
        // константы: действия, статусы, роли
        private $actions = array('authentication', 'publish_task', 'task_response', 'task_complete', 'task_reject', 'task_cancel', 'start_task', 'send_notif', 'send_message');
        private $statuses = array('new', 'in_progress', 'completed', 'canceled', 'failed');
        private $roles = array('executor', 'client');

        // свойства для хранения: id исполнителя, id заказчика, срок завершения, активный статус
        public $executor_id;
        public $client_id;
        public $due_date;
        public $active_status;

        public function __construct($data){
            $this->executor_id = $data['executor_id'];
            $this->client_id = $data['client_id'];
            $this->due_date = $data['due_date'];
            $this->active_status = $data['active_status'];
        }

        // список действий
        public function ActionsList(){
            return $this->actions;
        }

        // список статусов
        public function StatusesList(){
            return $this->statuses;
        }

        // метод для возврата статуса, в который перейдет задача для указанного действия
        public function StatusHandler(){

        }
    }

    $data = array(
        'executor_id' => '123',
        'client_id' => '321',
        'due_date' => '30.11.2019',
        'active_status' => 'статус'
    );

    $AvailableActions = new AvailableActions($data);

    var_dump($AvailableActions->ActionsList());