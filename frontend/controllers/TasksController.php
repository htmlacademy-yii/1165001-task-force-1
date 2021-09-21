<?php
    namespace frontend\controllers;

    use frontend\models\form\TaskFilterForm;
    use frontend\models\Tasks;
    use frontend\models\Categories;
    use frontend\models\TasksSearch;
    
    use Yii;
    use yii\db\Query;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\web\Response;
    use yii\data\Pagination;

    class TasksController extends Controller
    {
        public function actionIndex()
        {
            $model = new TaskFilterForm();
            $categories = Categories::find()->joinWith('tasks')->andWhere(['not', ['tasks.id' => null]])->all();

            // если фильтрация
            if ($model->load(Yii::$app->request->get())) {
                $TasksSearch = new TasksSearch();
                $tasks = $TasksSearch->filter(Yii::$app->request->get());
            } else {
            // если просто открытие страницы
                $tasks = Tasks::find()->joinWith('category');
            }

            // сортировка
            switch (Yii::$app->request->get('sort')) {
                case 'rating';
                    $tasks = $tasks->orderBy(['rating' => SORT_DESC]);
                break;

                case 'orders';
                    $tasks = $tasks->select(['users.*', '(SELECT COUNT(id) FROM tasks WHERE tasks.executor_id = users.id) AS tasks_count'])->groupBy('users.id');
                    $tasks = $tasks->orderBy(['tasks_count' => SORT_DESC]);
                break;

                case 'popular';
                    $tasks = $tasks->select(['users.*', '(SELECT COUNT(*) FROM opinions WHERE opinions.receiver_id = users.id) AS reviews_count'])->groupBy('users.id');
                    $tasks = $tasks->orderBy(['reviews_count' => SORT_DESC]);
                break;

                default:
                    $tasks = $tasks->orderBy(['dt_add' => SORT_DESC]);
                break;
            }

            $pagination = new Pagination(['totalCount' => $tasks->count(), 'pageSize' => 5]);
            $pagination->pageSizeParam = false;
            $pagination->forcePageParam = false;

            $tasks = $tasks->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();

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
                ]
            );
        }
    }