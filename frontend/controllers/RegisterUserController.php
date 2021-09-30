<?php
    namespace frontend\controllers;

    use frontend\models\Cities;
    use frontend\models\form\UserRegisterForm;

    use Yii;
    use yii\web\Controller;

    class RegisterUserController extends Controller
    {
        public function actionIndex()
        {
            $model = new UserRegisterForm();
            if ($model->load(Yii::$app->request->post()) && $model->signup()){
                return $this->goHome();
            }

            $cities = array();
            $cities_raw = Cities::find()->all();
            foreach ($cities_raw as $city){
                $cities[$city->id] = $city->city;
            }

            return $this->render('index', [
                'model' => $model,
                'cities' => $cities,
                'errors' => $model->errors
            ]);
        }
    }