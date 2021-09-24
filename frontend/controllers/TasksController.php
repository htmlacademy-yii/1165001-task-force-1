<?php
    namespace frontend\controllers;

    use frontend\models\form\TaskFilterForm;
    use frontend\models\Tasks;
    use frontend\models\Categories;
    use frontend\models\TasksSearch;
    
    use Yii;
    use yii\web\Controller;
    use yii\data\Pagination;
    use yii\web\NotFoundHttpException;

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

        public function actionDetail($id)
        {
            $task = Tasks::find($id)
                ->joinWith('customer')
                ->joinWith('replies')
                ->joinWith('taskAttachments')
                ->where(['tasks.id' => $id])
                ->one();

            if (!$task) {
                throw new NotFoundHttpException("Задание с ID {$id} не найдено");
            }

            $task->dt_add = Yii::$app->formatter->format($task->dt_add, 'relativeTime');

            $customer_tasks_count =
                \Yii::t(
                    'app',
                    '{n, plural, =0{# заданий} =1{# задание} one{# задание} few{# заданий} many{# заданий} other{# задания}}',
                    ['n' => count($task->customer->tasks)]
                );

            $customer = (object) [
                'tasks_count' => $customer_tasks_count,
                'registrated' => $task->customer->dt_add
            ];
            
            $customer->registrated = Yii::$app->formatter->format($customer->registrated, 'relativeTime');
            $customer->registrated = str_replace(' назад', '', $customer->registrated);

            return $this->render(
                'detail',
                [
                    'task' => $task,
                    'customer' => $customer,
                ]
            );
        }
    }