<?php
    namespace TaskForce\actions;

    class RefuseAction extends ActionsInterface
    {
        public $actionName, $actionSlug;

        public function __construct()
        {
            $this->actionName = 'Отказаться';
            $this->actionSlug = 'refuse_action';
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
            return $currentUserID === $workerID;
        }
    }
