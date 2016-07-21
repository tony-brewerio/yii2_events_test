<?php

namespace app\components;

use app\components\events\EventBase;
use app\models\NotificationTemplate;
use app\models\User;
use Yii;
use yii\base\Component;
use yii\base\Event;

class Events extends Component
{
    /**
     * @var string[]
     */
    public $events;

    /**
     * @var EventsChannelDatabase
     */
    public $channelDatabase;

    /**
     * @var EventsChannelEmail
     */
    public $channelEmail;

    public function init()
    {
        $this->channelDatabase = new EventsChannelDatabase();
        $this->channelEmail = new EventsChannelEmail();
        $templates = $this->loadTemplates();
        foreach ($templates as $template) {
            $this->on($template->event, [$this, 'onEvent'], ['template' => $template]);
        }
    }

    public function eventsVariables()
    {
        $eventsVariables = [];
        foreach ($this->events as $className) {
            $eventsVariables[$className] = (new $className)->templateVarsNames();
        }
        return $eventsVariables;
    }

    public function fire(Event $event)
    {
        $this->trigger($event::className(), $event);
    }

    public function onEvent(EventBase $event)
    {
        Yii::info("triggered event {$event->name}", 'events');
        /** @var $template NotificationTemplate */
        $template = $event->data['template'];
        $sender = $template->sender ?: $event->user;
        switch ($template->target_mode) {
            case NotificationTemplate::TARGET_MODE_EVENT_USER:
                Yii::info("sending event {$event->name} to event user {$event->user->username}", 'events');
                $this->sendToChannels($sender, $event->user, $event, $template);
                break;
            case NotificationTemplate::TARGET_MODE_SPECIFIC_USER:
                Yii::info("sending event {$event->name} to specific user {$template->target->username}", 'events');
                $this->sendToChannels($sender, $template->target, $event, $template);
                break;
            case NotificationTemplate::TARGET_MODE_ALL:
                Yii::info("sending event {$event->name} to all users", 'events');
                // this is as inefficient as it gets, should use some kinda queue for this
                /** @var User $user */
                foreach (User::find()->all() as $user) {
                    $this->sendToChannels($sender, $user, $event, $template);
                }
                break;
        }
    }

    public function sendToChannels(User $sender, User $target, EventBase $event, NotificationTemplate $template)
    {
        $event->targetUsername = $target->username;
        if ($template->notify_database) {
            $this->channelDatabase->send($sender, $target, $event, $template);
        }
        if ($template->notify_email) {
            $this->channelEmail->send($sender, $target, $event, $template);
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
//        return NotificationTemplate::getDb()->cache(function ($db) {
        return NotificationTemplate::find()->all();
//        }, 10);
    }
}
