<?php

namespace TaskForce\models;

class User
{
    const ROLE_CUSTOMER = 1;
    const ROLE_WORKER = 2;

    /**
     * @var string[]
     */
    const ROLES = [
        self::ROLE_CUSTOMER => 'Заказчик',
        self::ROLE_WORKER => 'Исполнитель',
    ];

    /**
     * @return array|string[]
     */
    public static function getRoles(): array
    {
        return self::ROLES;
    }

    /**
     * @param int $roleId
     * @return string
     */
    public static function getRoleName(int $roleId): string
    {
        return self::ROLES[$roleId] ?? '#N/A';
    }
}
