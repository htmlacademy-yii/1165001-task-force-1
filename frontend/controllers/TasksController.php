<?php
    namespace frontend\controllers;
    use frontend\models\Tasks;
    use Yii;
    use yii\db\Query;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\web\Response;

    class TasksController extends Controller
    {
        public function actionIndex()
        {
            $tasks = new Query();
            $tasks->select(['tasks.*', 'categories.name as category_name'])->from('tasks')
                ->join('LEFT JOIN', 'categories', 'tasks.category_id = categories.id')
                ->orderBy(['dt_add' => SORT_DESC]);
            $tasks = $tasks->all();

            $tasks = array_map(function($task){
                $task = (object) $task;
                $task->dt_add = date('d.m.Y в H:i:s', strtotime($task->dt_add));
                return $task;
            }, $tasks);

            return $this->render('index', ['tasks' => $tasks]);
        }
    }