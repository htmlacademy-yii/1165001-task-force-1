<?php
    namespace frontend\models\form;

    use Yii;
    use yii\base\Model;
    use frontend\models\Users;

    class UserRegisterForm extends Model
    {
        public $email;
        public $name;
        public $city;
        public $password;

        public function rules(): array
        {
            return [
                ['name', 'trim'],
                ['name', 'required', 'message' => 'Поле обязательное для заполнения'],
                ['name', 'string', 'min' => 2, 'max' => 255],

                ['email', 'trim'],
                ['email', 'required',  'message' => 'Поле обязательное для заполнения'],
                ['email', 'email'],
                ['email', 'string', 'max' => 255],
                ['email', 'unique', 'targetClass' => '\frontend\models\Users', 'message' => 'Введенный E-mail уже используется.'],

                ['city', 'required', 'message' => 'Поле обязательное для заполнения'],

                ['password', 'required', 'message' => 'Поле обязательное для заполнения'],
                ['password', 'string', 'min' => 8, 'tooShort' => 'Пароль должен быть больше 8 символов'],
            ];
        }

        public function attributeLabels(): array
        {
            return [
                'email' => 'Электронная почта',
                'name' => 'Ваше имя',
                'city' => 'Город проживания',
                'password' => 'Пароль',
            ];
        }

        /**
         * Регистрация пользователя
         *
         * @return array|bool
         * @throws \yii\base\Exception
         */
        public function signup()
        {
            if (!$this->validate()) {
                return null;
            }

            $user = new Users();

            $user->email = $this->email;
            $user->name = $this->name;
            $user->city = $this->city;
            $user->password = Yii::$app->security->generatePasswordHash($this->password);

            return $user->save();
        }
    }