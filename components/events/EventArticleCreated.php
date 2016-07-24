<?php

namespace app\components\events;

use app\models\Article;
use Yii;
use yii\helpers\Html;
use yii\helpers\StringHelper;

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

    public static function fire(Article $article)
    {
        Yii::$app->events->fire(new EventArticleCreated([
            'user' => $article->author,
            'username' => $article->author->username,
            'articleTitle' => $article->title,
            'articleShortBody' => StringHelper::truncateWords($article->body, 40),
            'articleMoreLink' => Html::a(Html::encode('читать далее'), ['/article/view', 'id' => $article->id]),
        ]));
    }
}
