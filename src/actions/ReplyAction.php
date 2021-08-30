<?php

namespace TaskForce\actions;

class ReplyAction extends ActionsInterface
{
    protected $actionName = 'Откликнуться';
    protected $actionSlug = 'reply_action';

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
        return $currentUserId !== $customerId && $currentUserId !== $workerId;
    }
}
