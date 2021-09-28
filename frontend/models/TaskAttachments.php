<?php

namespace frontend\models;

use Yii;

/**
 * 
 *
 * @property int $id
 * @property int $task_id
 * @property string $file_type
 * @property string $file_name
 * @property string $file_path
 *
 * @property TaskAttachments[] $TaskAttachments
 */
class TaskAttachments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_attachments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['file_type', 'file_name', 'file_src'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'file_type' => 'File type',
            'file_name' => 'File name',
            'file_src' => 'File path',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasOne(Tasks::className(), ['task_id' => 'id']);
    }
}
