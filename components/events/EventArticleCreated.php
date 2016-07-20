<?php

namespace app\components\events;

use app\models\User;
use yii\base\Event;

/**
 * @property User $user
 * @property string $username
 * @property string $articleTitle
 * @property string $articleShortBody
 * @property string $articleMoreLink
 */
class EventArticleCreated extends Event
{
    public $user;
    public $username;
    public $articleTitle;
    public $articleShortBody;
    public $articleMoreLink;
}
