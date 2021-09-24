<?php
    namespace frontend\controllers;

    use frontend\models\form\TaskFilterForm;
    use frontend\models\Categories;
    use frontend\models\TasksSearch;
    
    use Yii;
    use yii\web\Controller;
    use yii\data\Pagination;

    class TasksController extends Controller
    {
        public function actionIndex()
        {
            $model = new TaskFilterForm();
            $categories = Categories::find()->joinWith('tasks')->andWhere(['not', ['tasks.id' => null]])->all();

            $tasksSearch = new TasksSearch();
            $tasks = $tasksSearch->filter(Yii::$app->request->get());

            $pagination = new Pagination(['totalCount' => $tasks->count(), 'pageSize' => 5]);
            $pagination->pageSizeParam = false;
            $pagination->forcePageParam = false;

            $tasks = $tasks->offset($pagination->offset)->limit($pagination->limit)->all();

            $selected = [
                'categories' => Yii::$app->request->get('TaskFilterForm')['category'],
                'additionals' => [
                    'task_is_free' => Yii::$app->request->get('TaskFilterForm')['task_is_free'],
                    'task_is_remote' => Yii::$app->request->get('TaskFilterForm')['task_is_remote'],
                ],
                'period' => Yii::$app->request->get('TaskFilterForm')['period']
            ];

            $tasks = array_map(function($task){
                $task->dt_add = date('d.m.Y в H:i:s', strtotime($task->dt_add));
                return $task;
            }, $tasks);

            return $this->render(
                'index',
                [
                    'model' => $model,
                    'tasks' => $tasks,
                    'categories' => $categories,
                    'pagination' => $pagination,
                    'selected' => $selected
                ]
            );
        }
    }