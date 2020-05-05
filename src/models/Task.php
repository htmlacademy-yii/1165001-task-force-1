<?php
    namespace TaskForce\models;

    class Task
    {
        /**
         * Набор констант: действия, статусы, роли
         */
        const STATUS_NEW = 1;
        const STATUS_CANCELLED = 2;
        const STATUS_IN_PROGRESS = 3;
        const STATUS_COMPLETED = 4;
        const STATUS_FAILED = 5;

        const ACTION_CANCEL = 1;
        const ACTION_REPLY = 2;
        const ACTION_COMPLETE = 3;
        const ACTION_REFUSE = 4;

        /**
         * Русификация статусов
         *
         * @var string[]
         */
        const STATUSES = [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELLED => 'Отменено',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_COMPLETED => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];

        /**
         * @var array[]
         */
        const ACTIONS = [
            self::ACTION_CANCEL => [
                'name' => 'Отменить',
                'statuses' => [self::STATUS_NEW],
                'roles' => [User::ROLE_CUSTOMER],
                'statusAfterAction' => self::STATUS_CANCELLED,
            ],
            self::ACTION_REPLY => [
                'name' => 'Откликнуться',
                'statuses' => [self::STATUS_NEW],
                'roles' => [User::ROLE_WORKER],
                'statusAfterAction' => self::STATUS_IN_PROGRESS,
            ],
            self::ACTION_COMPLETE => [
                'name' => 'Завершить',
                'statuses' => [self::STATUS_IN_PROGRESS],
                'roles' => [User::ROLE_CUSTOMER],
                'statusAfterAction' => self::STATUS_COMPLETED,
            ],
            self::ACTION_REFUSE => [
                'name' => 'Отказаться',
                'statuses' => [self::STATUS_IN_PROGRESS],
                'roles' => [User::ROLE_WORKER],
                'statusAfterAction' => self::STATUS_FAILED,
            ],
        ];


        /**
         * Свойства для хранения
         * id заказчика, id исполнителя,
         * активный статус
         */

        /**
         * @var int
         */
        protected $customerId;

        /**
         * @var int
         */
        protected $workerId;

        /**
         * @var int
         */
        protected $statusId;


        /**
         * Task constructor.
         *
         * @param int $customerId
         * @param int $workerId
         * @param int $statusId
         */
        public function __construct(int $customerId, int $workerId, int $statusId = self::STATUS_NEW)
        {
            $this->customerId = $customerId;
            $this->workerId = $workerId;
            $this->statusId = $statusId;
        }

        /**
         * @return int
         */
        public function getStatusId(): int
        {
            return $this->statusId;
        }

        /**
         * Возвращает статус по заданному id, либо текущий если id не задан
         *
         * @param int|null $statusId
         * @return string
         */
        public function getStatusName(int $statusId = null)
        {
            $statusId = $statusId ? $statusId : $this->statusId;
            return self::STATUSES[$statusId] ?? '#N/A';
        }

        /**
         * Карта статусов, statusId => statusName
         *
         * @return array|string[]
         */
        public static function getStatuses(): array
        {
            return self::STATUSES;
        }

        /**
         * Карта действий, actionId => actionName
         *
         * @return array
         */
        public static function getAllActions(): array
        {
            $actions = [];

            foreach (self::ACTIONS as $k => $v) {
                $actions[$k] = $v['name'];
            }

            return $actions;
        }

        /**
         * Имя статуса, в который перейдёт задание после выполнения конкретного действия
         *
         * @param int $actionId
         * @return string
         */
        public static function getStatusAfterAction(int $actionId): string
        {
            $statusId = self::ACTIONS[$actionId]['statusAfterAction'] ?? 0;
            return self::STATUSES[$statusId] ?? '#N/A';
        }

        /**
         * Возвращаем массив доступных действий (actionIds) для текущего
         * статуса Задачи. Если определен параметр $roleId, то
         * выборка дополнительно ограничивается заданной ролью
         *
         * @param int|null $roleId
         * @return array
         */
        public function getAvailableActions(int $roleId = null): array
        {
            $actionIds = [];

            foreach (self::ACTIONS as $k => $v) {
                if (!is_null($roleId) && !in_array($roleId, $v['roles'])){
                    continue;
                }

                if (in_array($this->statusId, $v['statuses'])){
                    $actionIds[] = $k;
                }
            }

            return $actionIds;
        }


        /**
         * Доступные действия (actionIds) для указанного статуса
         *
         * @param int $statusId
         * @return array|string[]
         */
        public static function getActionsByStatusId(int $statusId): array
        {
            $actionIds = [];

            foreach (self::ACTIONS as $k => $v) {
                if (in_array($statusId, $v['statuses'])){
                    $actionIds[] = $k;
                }
            }

            return $actionIds;
        }

        /*
         * Action Cancel
         */
        public function cancel()
        {
            $this->statusId = self::STATUS_CANCELLED;
        }

        /*
         * Action Reply
         */
        public function reply()
        {
            $this->statusId = self::STATUS_IN_PROGRESS;
        }

        /*
         * Action Complete
         */
        public function complete()
        {
            $this->statusId = self::STATUS_COMPLETED;
        }

        /*
         * Action Refuse
         */
        public function refuse()
        {
            $this->statusId = self::STATUS_FAILED;
        }
    }