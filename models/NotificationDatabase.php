<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notification_database".
 *
 * @property integer $id
 * @property integer $sender_id
 * @property integer $target_id
 * @property string $title
 * @property string $body
 * @property integer $viewed
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $target
 * @property User $sender
 */
class NotificationDatabase extends ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_database';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender_id', 'target_id'], 'integer'],
            [['target_id', 'title', 'body'], 'required'],
            [['body'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            ['viewed', 'boolean'],
            ['viewed', 'default', 'value' => false],
            [['target_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['target_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => 'Sender ID',
            'target_id' => 'Target ID',
            'title' => 'Title',
            'body' => 'Body',
            'viewed' => 'Viewed',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarget()
    {
        return $this->hasOne(User::className(), ['id' => 'target_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }
}
