<?php

namespace TaskForce\actions;

abstract class ActionsInterface
{
    public function getPublicName()
    {
    }

    public function getInnerName()
    {
    }

    public function checkUserAccess($customerId, $workerId, $currentUserId)
    {
    }
}
