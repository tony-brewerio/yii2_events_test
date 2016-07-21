<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\events\EventArticleCreated;
use app\components\events\EventUserRegistered;
use app\models\NotificationTemplate;
use app\models\User;
use yii\console\Controller;

/**
 * This command generates sample data.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DataGenController extends Controller
{

    /**
     * Add some basic templates, like registration or notification about new articles
     */
    public function actionTemplates()
    {
        $this->syncTemplate([
            'event' => EventUserRegistered::className(),
            'target_mode' => NotificationTemplate::TARGET_MODE_EVENT_USER,
            'notify_database' => false,
            'notify_email' => true,
            'title' => 'Добро пожаловать на сайт, {{ username }}',
            'body' =>
                'Уважаемый {{ username }}.' . PHP_EOL .
                'Благодарим Вас за регистрацию на нашем сайте.',
        ]);
        $this->syncTemplate([
            'event' => EventUserRegistered::className(),
            'target_mode' => NotificationTemplate::TARGET_MODE_SPECIFIC_USER,
            'target_id' => User::findByUsername('admin')->primaryKey,
            'notify_database' => true,
            'notify_email' => true,
            'title' => 'На сайте новый пользователь - {{ username }}',
            'body' => 'На сайте зарегистрировался новый пользователь - {{ username }}.',
        ]);
        $this->syncTemplate([
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
        ]);
    }

    protected function syncTemplate($attrs)
    {
        $user = NotificationTemplate::findOne(['title' => $attrs['title']]) ?: new NotificationTemplate();
        $user->attributes = $attrs;
        var_dump($user->save(false));
    }

    /**
     * Generate a bunch of users and a single admin
     */
    public function actionUsers()
    {
        $this->syncUser([
            'username' => 'admin', 'email' => "admin@example.com",
            'password' => 'admin', 'admin' => true
        ]);
        for ($i = 0; $i < 10; $i++) {
            $this->syncUser([
                'username' => "user{$i}", 'email' => "user{$i}@example.com",
                'password' => "user{$i}", 'admin' => false
            ]);
        }
    }

    protected function syncUser($attrs)
    {
        $user = User::findOne(['username' => $attrs['username']]) ?: new User();
        $user->scenario = User::SCENARIO_DATAGEN;
        $user->attributes = $attrs;
        $user->save(false);
    }
}
