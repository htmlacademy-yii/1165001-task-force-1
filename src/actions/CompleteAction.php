<?php

namespace TaskForce\actions;

class CompleteAction extends ActionsInterface
{
    protected $actionName = 'Завершить';
    protected $actionSlug = 'complete_action';

    /**
     * @return string
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @return string
     */
    public function getActionSlug()
    {
        return $this->actionSlug;
    }

    /**
     * @param $customerId
     * @param $workerId
     * @param $currentUserId
     * @return bool
     */
    public function checkUserAccess($customerId, $workerId, $currentUserId)
    {
        return $currentUserId === $customerId;
    }
}
