<?php

namespace app\components;

use app\components\events\EventBase;
use app\models\NotificationTemplate;
use app\models\User;
use yii\base\Exception;

class EventsChannelEmail implements EventsChannel
{

    public function send(User $sender, User $target, EventBase $event, NotificationTemplate $template)
    {
        try {
            $rendered = $template->render($event);
            \Yii::$app->mailer->compose()
                ->setFrom($sender ? $sender->email : \Yii::$app->params['adminEmail'])
                ->setTo($target->email)
                ->setSubject($rendered['title'])
                ->setHtmlBody(nl2br($rendered['body']))
                ->send();
        } catch (Exception $e) {
            \Yii::warning(
                "sending event {$event->name} to user {$target->username} on channel email failed: " .
                $e->getMessage(),
                'events'
            );
        }
    }

}
