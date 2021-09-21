<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string|null $dt_add
 * @property string|null $last_online
 * @property int $city
 * @property string|null $full_address
 * @property string|null $birthday
 * @property string|null $about
 * @property string|null $avatar_src
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $over_messenger
 * @property float|null $rating
 * @property int|null $role
 *
 * @property Cities $city0
 * @property Messages[] $messages
 * @property Messages[] $messages0
 * @property Opinions[] $opinions
 * @property Opinions[] $opinions0
 * @property Portfolio[] $portfolios
 * @property Profiles[] $profiles
 * @property Replies[] $replies
 * @property Replies[] $replies0
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UserSettings $userSettings
 * @property UsersSpecialty[] $usersSpecialties
 * @property UsersSpecialty[] $executors
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'password', 'city'], 'required'],
            [['dt_add', 'last_online', 'birthday'], 'safe'],
            [['city', 'role'], 'integer'],
            [['about'], 'string'],
            [['rating'], 'number'],
            [['email'], 'string', 'max' => 64],
            [['name', 'password', 'avatar_src', 'skype', 'over_messenger'], 'string', 'max' => 128],
            [['full_address'], 'string', 'max' => 256],
            [['phone'], 'string', 'max' => 20],
            [['city'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'E-mail',
            'name' => 'Имя',
            'password' => 'Пароль',
            'dt_add' => 'Дата регистрации',
            'last_online' => 'Был онлайн',
            'city' => 'Город',
            'full_address' => 'Адрес',
            'birthday' => 'День рождения',
            'about' => 'Информация',
            'avatar_src' => 'Аватар',
            'phone' => 'Телефон',
            'skype' => 'Скайп',
            'over_messenger' => 'Мессенджер',
            'rating' => 'Рейтинг',
            'role' => 'Роль',
        ];
    }

    /**
     * Gets query for [[City0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity0()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[Messages0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Messages::className(), ['addressee_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinions::className(), ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions0()
    {
        return $this->hasMany(Opinions::className(), ['receiver_id' => 'id']);
    }

    /**
     * Gets query for [[Portfolios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolios()
    {
        return $this->hasMany(Portfolio::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profiles::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[Replies0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies0()
    {
        return $this->hasMany(Replies::className(), ['receiver_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[UserSettings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSettings()
    {
        return $this->hasOne(UserSettings::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersSpecialties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersSpecialties()
    {
        return $this->hasMany(UsersSpecialty::className(), ['user_id' => 'id']);
    }
}
