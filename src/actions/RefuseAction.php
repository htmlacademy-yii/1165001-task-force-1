<?php

namespace TaskForce\actions;

class RefuseAction extends ActionsInterface
{
    protected $actionName = 'Отказаться';
    protected $actionSlug = 'refuse_action';

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
        return $currentUserId === $workerId;
    }
}
