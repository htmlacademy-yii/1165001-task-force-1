<?php
    namespace frontend\controllers;

    use frontend\models\Categories;
    use frontend\models\form\UserFilterForm;
    use frontend\models\UsersSearch;

    use Yii;
    use yii\web\Controller;
    use yii\data\Pagination;

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
                    'selected' => $selected
                ]
            );
        }
    }