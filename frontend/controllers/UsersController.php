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
            $users = Users::findAll(['role' => 2]);
            return $this->render('index', ['users' => $users]);
        }
    }