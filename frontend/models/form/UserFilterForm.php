<?php
    namespace frontend\models\form;

    use yii\base\Model;

    class UserFilterForm extends Model
    {
        public $category;

        public $user_is_free;
        public $user_is_online;
        public $user_has_reviews;
        public $user_is_favorite;

        public $user_name;

        public function rules(): array
        {
            return [
                [['category', 'user_name'], 'safe'],
                [['user_is_free', 'user_is_online', 'user_has_reviews', 'user_is_favorite'], 'boolean'],
            ];
        }

        public function attributeLabels(): array
        {
            return [
                'category' => 'Категории',

                'user_is_free' => 'Сейчас свободен',
                'user_is_online' => 'Сейчас онлайн',
                'user_has_reviews' => 'Есть отзывы',
                'user_is_favorite' => 'В избранном',

                'user_name' => 'Поиск по имени',
            ];
        }
    }