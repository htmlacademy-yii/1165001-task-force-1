<?php
namespace frontend\models;

use frontend\models\form\TaskFilterForm;
use taskforce\models\Task;
use yii\db\Expression;

class TasksSearch extends TaskFilterForm
{    
    /**
     * Фильтрация списка заданий
     *
     * @param  mixed $params
     * @return object
     */
    public function filter($params)
    {
        $params = $params['TaskFilterForm'];

        $categories = $params['category'];
        $params['category'] = array();
        foreach ($categories as $cat_id => $checked){
            if ((bool) $checked) {
                $params['category'][] = $cat_id;
            }
        }

        $query = Tasks::find()->joinWith('category');

        $this->load($params, '');

        // фильтрация
        if (!empty($this->category)) {
            $query->andWhere(['IN', 'tasks.category_id', $this->category]);
        }

        if ($this->task_is_free) {
            $query->andWhere(['tasks.executor_id' => null]);
        }

        if ($this->task_is_remote) {
            $query->andWhere(['tasks.remote' => 1]);
        }

        if ($this->period) {
            $query->andWhere([
                '>',
                'tasks.dt_add',
                new Expression("DATE_SUB(NOW(), INTERVAL 1 {$this->period})")
            ]);
        }

        if ($this->task_name) {
            $query->andWhere(['like', 'tasks.name', $this->task_name]);
        }

        // валидация
        if (!$this->validate()) {
            return $query;
        }

        // убираем дубли
        $query = $query->distinct();
    
        return $query;
    }
}
