<?php
    namespace frontend\models\form;

    use yii\base\Model;

    class TaskFilterForm extends Model
    {
        public $category;

        public $task_is_free;
        public $task_is_remote;

        public $period;

        public $task_name;

        public function rules(): array
        {
            return [
                [['category', 'task_name', 'period'], 'safe'],
                [['task_is_free', 'task_is_remote'], 'boolean'],
            ];
        }

        public function attributeLabels(): array
        {
            return [
                'category' => 'Категории',

                'task_is_free' => 'Без откликов',
                'task_is_remote' => 'Удаленная работа',

                'period' => 'Период',

                'task_name' => 'Поиск по названию',
            ];
        }
    }