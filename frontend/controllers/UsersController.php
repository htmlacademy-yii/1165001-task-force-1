<?php
    namespace frontend\controllers;

    use frontend\models\Categories;
    use frontend\models\Users;
    use frontend\models\form\UserFilterForm;
    use frontend\models\UsersSearch;

    use Yii;
    use yii\web\Controller;
    use yii\data\Pagination;
    use yii\web\NotFoundHttpException;

    class UsersController extends Controller
    {
        public function actionIndex()
        {
            $model = new UserFilterForm();
            $categories = Categories::find()->joinWith('tasks')->andWhere(['not', ['tasks.id' => null]])->all();

            $usersSearch = new UsersSearch();
            $users = $usersSearch->filter(Yii::$app->request->get());

            $pagination = new Pagination(['totalCount' => $users->count(), 'pageSize' => 5]);
            $pagination->pageSizeParam = false;
            $pagination->forcePageParam = false;

            $selected = [
                'categories' => Yii::$app->request->get('UserFilterForm')['category'],
                'additionals' => [
                    'user_is_free' => Yii::$app->request->get('UserFilterForm')['user_is_free'],
                    'user_is_online' => Yii::$app->request->get('UserFilterForm')['user_is_online'],
                    'user_has_reviews' => Yii::$app->request->get('UserFilterForm')['user_has_reviews'],
                    'user_is_favorite' => Yii::$app->request->get('UserFilterForm')['user_is_favorite'],
                ],
                'sort' => Yii::$app->request->get('sort')
            ];
            
            $users = $users->offset($pagination->offset)->limit($pagination->limit)->all();

            return $this->render(
                'index',
                [
                    'model' => $model,
                    'users' => $users,
                    'categories' => $categories,
                    'pagination' => $pagination,
                    'selected' => $selected
                ]
            );
        }

        public function actionDetail($id)
        {
            $user = Users::find()
                ->joinWith('city0')
                ->joinWith('opinions')
                ->joinWith('portfolios')
                ->where(['users.id' => $id])
                ->one();

            if (!$user) {
                throw new NotFoundHttpException("Пользователь с ID {$id} не найден");
            }

            $tasks_count = \Yii::t(
                'app',
                '{n, plural, =0{# заказов} =1{# заказ} one{# заказ} few{# заказов} many{# заказов} other{# заказы}}',
                ['n' => count($user->tasks0)]
            );

            $opinions_count = \Yii::t(
                'app',
                '{n, plural, =0{# отзывов} =1{# отзыв} one{# отзыв} few{# отзывов} many{# отзывов} other{# отзыва}}',
                ['n' => count($user->opinions0)]
            );

            return $this->render(
                'detail',
                [
                    'user' => $user,
                    'tasks_count' => $tasks_count,
                    'opinions_count' => $opinions_count,
                ]
            );
        }
    }