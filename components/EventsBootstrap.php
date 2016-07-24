<?php

namespace app\components;

use app\components\events\EventArticleCreated;
use app\components\events\EventUserRegistered;
use app\models\Article;
use app\models\User;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\StringHelper;

class EventsBootstrap implements BootstrapInterface
{

    /**
     * Convert Yii native events to ours.
     */
    public function bootstrap($app)
    {
        $this->connectUserRegistered();
        $this->connectArticleCreated();
    }

    private function connectUserRegistered()
    {
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, function ($event) {
            if ($event->sender instanceof User) {
                Yii::$app->events->fire(new EventUserRegistered([
                    'user' => $event->sender,
                    'username' => $event->sender->username,
                ]));
            }
        });
    }

    private function connectArticleCreated()
    {
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, function ($event) {
            if ($event->sender instanceof Article) {
                Yii::$app->events->fire(new EventArticleCreated([
                    'user' => $event->sender->author,
                    'username' => $event->sender->author->username,
                    'articleTitle' => $event->sender->title,
                    'articleShortBody' => StringHelper::truncateWords($event->sender->body, 40),
                    'articleMoreLink' => Html::a(Html::encode('читать далее'), ['view', 'id' => $event->sender->id]),
                ]));
            }
        });
    }

}
