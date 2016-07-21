<?php

namespace app\components;

use app\components\events\EventBase;
use app\models\NotificationTemplate;
use app\models\User;

class EventsChannelEmail implements EventsChannel
{

    public function send(User $sender, User $target, EventBase $event, NotificationTemplate $template)
    {
        // todo
    }

}
