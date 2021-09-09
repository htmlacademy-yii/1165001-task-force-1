<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $sender_id
 * @property int $addressee_id
 * @property string $content
 * @property string|null $created_at
 *
 * @property Users $addressee
 * @property Users $sender
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender_id', 'addressee_id', 'content'], 'required'],
            [['sender_id', 'addressee_id'], 'integer'],
            [['content'], 'string'],
            [['created_at'], 'safe'],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['sender_id' => 'id']],
            [['addressee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['addressee_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => 'Sender ID',
            'addressee_id' => 'Addressee ID',
            'content' => 'Content',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Addressee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddressee()
    {
        return $this->hasOne(Users::className(), ['id' => 'addressee_id']);
    }

    /**
     * Gets query for [[Sender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(Users::className(), ['id' => 'sender_id']);
    }
}
