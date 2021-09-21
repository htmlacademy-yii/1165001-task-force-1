<?php
    namespace frontend\controllers;

    use frontend\models\Users;
    use frontend\models\Categories;
    use frontend\models\form\UserFilterForm;
    use frontend\models\UsersSearch;

    use Yii;
    use yii\db\Query;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\web\Response;
    use yii\data\Pagination;

    class UsersController extends Controller
    {
        public function actionIndex()
        {
            $model = new UserFilterForm();
            $categories = Categories::find()->joinWith('tasks')->andWhere(['not', ['tasks.id' => null]])->all();

            // если фильтрация
            if ($model->load(Yii::$app->request->get())) {
                $UsersSearch = new UsersSearch();
                $users = $UsersSearch->filter(Yii::$app->request->get());
            } else {
            // если просто открытие страницы
                $users = Users::find()->where(['role' => 2])
                    ->joinWith('tasks0')
                    ->joinWith('opinions')
                    ->joinWith('usersSpecialties');
            }

            // сортировка
            switch (Yii::$app->request->get('sort')) {
                case 'rating';
                    $users = $users->orderBy(['rating' => SORT_DESC]);
                break;

                case 'orders';
                    $users = $users->select(['users.*', '(SELECT COUNT(id) FROM tasks WHERE tasks.executor_id = users.id) AS tasks_count'])->groupBy('users.id');
                    $users = $users->orderBy(['tasks_count' => SORT_DESC]);
                break;

                case 'popular';
                    $users = $users->select(['users.*', '(SELECT COUNT(*) FROM opinions WHERE opinions.receiver_id = users.id) AS reviews_count'])->groupBy('users.id');
                    $users = $users->orderBy(['reviews_count' => SORT_DESC]);
                break;

                default:
                    $users = $users->orderBy(['dt_add' => SORT_DESC]);
                break;
            }

            $users = $users->distinct();
            
            $pagination = new Pagination(['totalCount' => $users->count(), 'pageSize' => 5]);
            $pagination->pageSizeParam = false;
            $pagination->forcePageParam = false;
            
            $users = $users->distinct()->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();

            $users = array_map(function($user){
                $user->last_online = date('d.m.Y в H:i:s', strtotime($user->last_online));
                return $user;
            }, $users);

            return $this->render(
                'index',
                [
                    'model' => $model,
                    'users' => $users,
                    'categories' => $categories,
                    'pagination' => $pagination,
                ]
            );
        }
    }