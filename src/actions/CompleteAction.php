<?php
    namespace TaskForce\actions;

    class CompleteAction extends ActionsInterface
    {
        public $actionName, $actionSlug;

        public function __construct()
        {
            $this->actionName = 'Завершить';
            $this->actionSlug = 'complete_action';
        }

        /**
         * @return string
         */
        public function getActionName(){
            return $this->actionName;
        }

        /**
         * @return string
         */
        public function getActionSlug(){
            return $this->actionSlug;
        }

        /**
         * @param $customerID
         * @param $workerID
         * @param $currentUserID
         * @return bool
         */
        public function checkUserAccess($customerID, $workerID, $currentUserID){
            return $currentUserID === $customerID;
        }
    }
