<?php

namespace app\components\events;

/**
 * @property string $username
 * @property string $articleTitle
 * @property string $articleShortBody
 * @property string $articleMoreLink
 */
class EventArticleCreated extends EventBase
{
    public $username;
    public $articleTitle;
    public $articleShortBody;
    public $articleMoreLink;
}
