<?php

namespace app\models;

use app\components\events\EventBase;
use Twig_Environment;
use Twig_Loader_Array;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notification_template".
 *
 * @property integer $id
 * @property string $event
 * @property string $title
 * @property string $body
 * @property integer $sender_id
 * @property string $target_mode
 * @property integer $target_id
 * @property boolean $notify_database
 * @property boolean $notify_email
 *
 * @property User $target
 * @property User $sender
 */
class NotificationTemplate extends ActiveRecord
{
    const TARGET_MODE_ALL = 'all';
    const TARGET_MODE_SPECIFIC_USER = 'specific_user';
    const TARGET_MODE_EVENT_USER = 'event_user';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_template';
    }

    public function eventsOptions()
    {
        $options = [];
        foreach (Yii::$app->events->events as $className) {
            $options[$className] = (new \ReflectionClass($className))->getShortName();
        }
        return $options;
    }

    public function targetModeOptions()
    {
        return [
            static::TARGET_MODE_ALL => 'All active users',
            static::TARGET_MODE_SPECIFIC_USER => 'User selected as target',
            static::TARGET_MODE_EVENT_USER => 'User related to event',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event', 'title', 'body', 'target_mode', 'notify_database', 'notify_email'], 'required'],
            ['event', 'in', 'range' => array_keys($this->eventsOptions())],
            ['target_mode', 'default', 'value' => static::TARGET_MODE_ALL],
            ['target_mode', 'in', 'range' => array_keys($this->targetModeOptions())],
            ['body', 'string'],
            ['title', 'string', 'max' => 255],
            [['notify_database', 'notify_email'], 'default', 'value' => false],
            [['notify_database', 'notify_email'], 'boolean'],
            [['sender_id', 'target_id'], 'integer'],
            [['target_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['target_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_id' => 'id']],
            // twig
            [['title', 'body'], 'validateTemplate', 'when' => function ($model, $attr) {
                return !($this->hasErrors('event') || $this->hasErrors($attr));
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event' => 'Event',
            'title' => 'Title',
            'body' => 'Body',
            'sender_id' => 'Sender',
            'target_mode' => 'Target Mode',
            'target_id' => 'Target',
            'notify_database' => 'Notify Database',
            'notify_email' => 'Notify Email',
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

    /**
     * @return Twig_Environment
     */
    public function twig()
    {
        return new Twig_Environment(
            new Twig_Loader_Array(['title' => $this->title, 'body' => $this->body]), ['strict_variables' => true]
        );
    }

    /**
     * Render title + body using variables from the event.
     * Uses Twig template engine since simple string replacement can only get you so far.
     *
     * @param EventBase $event
     * @return array
     */
    public function render(EventBase $event)
    {
        $twig = $this->twig();
        $vars = $event->templateVars();
        return [
            'title' => $twig->render('title', $vars),
            'body' => $twig->render('body', $vars),
        ];
    }

    /**
     * Validate renderable property by rendering a sample event.
     */
    public function validateTemplate($attr, $params)
    {
        $event = (new \ReflectionClass($this->event))->newInstance();
        $vars = $event->templateVars();
        try {
            $this->twig()->render($attr, $vars);
        } catch (\Twig_Error $error) {
            $this->addError($attr, 'Ошибка в коде шаблона: ' . $error->getMessage());
        }
    }

}
