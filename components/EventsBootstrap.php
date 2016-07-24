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

class EventsBootstrap implements BootstrapInterface
{

    /**
     * Convert Yii native events to ours.
     */
    public function bootstrap($app)
    {
        static $already;
        if (!$already) {
            $this->connectUserRegistered();
            $this->connectArticleCreated();
            $already = true;
        }
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
                EventArticleCreated::fire($event->sender);
            }
        });
    }

}
