<?php

namespace app\components;

use app\components\events\EventBase;
use app\models\NotificationDatabase;
use app\models\NotificationTemplate;
use app\models\User;
use Yii;

class EventsChannelDatabase implements EventsChannel
{

    public function send(User $sender, User $target, EventBase $event, NotificationTemplate $template)
    {
        $notification = new NotificationDatabase([
            'sender_id' => $sender ? $sender->id : null,
            'target_id' => $target->id,
        ]);
        $notification->attributes = $template->render($event);
        if (!$notification->save()) {
            Yii::warning(
                "sending event {$event->name} to user {$target->username} on channel database failed: " .
                json_encode($notification->getErrors(), JSON_UNESCAPED_UNICODE),
                'events'
            );
        }
    }

}
