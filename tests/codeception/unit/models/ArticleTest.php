<?php

namespace tests\codeception\unit\models;

use app\models\Article;
use app\models\NotificationDatabase;
use app\models\User;
use Codeception\Specify;
use yii\codeception\TestCase;

class ArticleTest extends TestCase
{
    use Specify;

    public function testCreatingArticleAddsNotificationsToDatabase()
    {
        $user = User::findOne(['username' => 'user1']);
        $i = random_int(100000, 999999);
        $model = new Article([
            'author_id' => $user->id,
            'title' => "test - {$i}",
            'body' => "test - {$i}",
        ]);
        $this->specify('when new article is created, database notification should be sent to all users', function () use ($model) {
            expect('article should be successfully saved', $model->save());
            $users_count = User::find()->count();
            $notifications_count = NotificationDatabase::find()
                ->where(['like', 'body', '"' . $model->title . '"'])
                ->count();
            expect('should have same amount of notifications created as there are users in db', $users_count)->equals($notifications_count);
        });
    }

}
