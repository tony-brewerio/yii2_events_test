<?php

use app\components\events\EventArticleCreated;
use app\models\NotificationTemplate;

return [
    [
        'event' => EventArticleCreated::className(),
        'target_mode' => NotificationTemplate::TARGET_MODE_ALL,
        'title' => 'На сайте новая статья, {{ targetUsername }}',
        'notify_database' => true,
        'notify_email' => false,
        'body' =>
            'Уважаемый {{ targetUsername }}.' . PHP_EOL .
            'На сайте добавлена новая статья "{{ articleTitle }}", которую разместил {{ username }}.' . PHP_EOL .
            '{{ articleShortBody }}...' . PHP_EOL .
            '{{ articleMoreLink | raw }}',
    ],
];
