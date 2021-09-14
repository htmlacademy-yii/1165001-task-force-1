<?php
    namespace frontend\controllers;
    use frontend\models\Users;
    use Yii;
    use yii\db\Query;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\web\Response;

    class UsersController extends Controller
    {
        public function actionIndex()
        {
            $users = Users::find()->where(['role' => 2])
                ->joinWith('tasks')
                ->joinWith('opinions')
                ->joinWith('usersSpecialties')
                ->orderBy(['dt_add' => SORT_DESC])
                ->all();

            $users = array_map(function($user){
                $user->last_online = date('d.m.Y в H:i:s', strtotime($user->last_online));
                return $user;
            }, $users);

            return $this->render('index', ['users' => $users]);
        }
    }