<?php
namespace frontend\models;

use frontend\models\form\UserFilterForm;
use taskforce\models\Task;
use yii\db\Expression;

class UsersSearch extends UserFilterForm
{    
    /**
     * Фильтрация списка пользователей
     *
     * @param  mixed $params
     * @return object
     */
    public function filter($params)
    {
        $params = $params['UserFilterForm'];

        $categories = $params['category'];
        $params['category'] = array();
        foreach ($categories as $cat_id => $checked){
            if ((bool) $checked) {
                $params['category'][] = $cat_id;
            }
        }

        $query = Users::find()->where(['role' => 2])
            ->joinWith('tasks0')
            ->joinWith('opinions')
            ->joinWith('usersSpecialties');

        $this->load($params, '');

        if (!empty($this->category)) {
            $query->andWhere(['IN', 'users_specialty.category_id', $this->category]);
        }

        if ($this->user_is_free) {
            $query->andWhere(['not', ['tasks.state' => 'process']]);
        }

        if ($this->user_is_online) {
            $query->andWhere([
                '>',
                'users.last_online',
                new Expression('DATE_SUB(NOW(), INTERVAL 30 MINUTE)')
            ]);
        }

        if ($this->user_has_reviews) {
            $query->andWhere(['not', ['opinions.receiver_id' => null]]);
        }

        if ($this->user_is_favorite) {
            $query->leftJoin('favorite', 'users.id = favorite.liked')->andWhere(['not', ['favorite.liked' => null]]);
        }

        if ($this->user_name) {
            $query->andWhere(['like', 'users.name', $this->user_name]);
        }

        if (!$this->validate()) {
            return $query;
        }
    
        return $query;
    }
}
