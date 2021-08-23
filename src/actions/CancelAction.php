<?php
    namespace TaskForce\actions;

    class CancelAction extends ActionsInterface
    {
        public $actionName, $actionSlug;

        public function __construct()
        {
            $this->actionName = 'Отменить';
            $this->actionSlug = 'cancel_action';
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
         * @param $customerId
         * @param $workerId
         * @param $currentUserID
         * @return bool
         */
        public function checkUserAccess($customerID, $workerID, $currentUserID){
            return $currentUserID === $customerID;
        }
    }
