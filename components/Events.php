<?php

namespace app\components;

use app\models\NotificationTemplate;
use Yii;
use yii\base\Component;
use yii\base\Event;

class Events extends Component
{
    /**
     * @var string[]
     */
    public $events;

    public function init()
    {
        $templates = $this->loadTemplates();
        foreach ($templates as $template) {
            $this->on($template->event, [$this, 'onEvent'], ['template' => $template]);
        }
    }

    public function fire(Event $event)
    {
        $name = explode('\\', $event::className());
        $name = preg_replace('/^Event/', '', $name[count($name) - 1]);
        $this->trigger($name);
    }

    public function onEvent($event)
    {
        Yii::info("triggered event {$event->name}", 'events');
        $template = $event->data['template'];
        switch ($template->target_mode) {
            case NotificationTemplate::TARGET_MODE_EVENT_USER:
                Yii::info("sending event {$event->name} to event user {$event->user->username}", 'events');
                break;
            case NotificationTemplate::TARGET_MODE_SPECIFIC_USER:
                Yii::info("sending event {$event->name} to specific user {$template->target->username}", 'events');
                break;
            case NotificationTemplate::TARGET_MODE_ALL:
                Yii::info("sending event {$event->name} to all users", 'events');
                break;
        }
    }

    /**
     * Avoid loading templates every single time we need to use events.
     * Instead of dependency, we use short expiration time.
     *
     * @return NotificationTemplate[]
     */
    private function loadTemplates()
    {
        return NotificationTemplate::getDb()->cache(function ($db) {
            return NotificationTemplate::find()->all($db);
        }, 10);
    }
}
