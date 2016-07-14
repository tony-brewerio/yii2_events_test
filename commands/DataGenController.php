<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

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
     * Generate a bunch of users and a single admin
     */
    public function actionUsers()
    {
        $this->syncUser(['username' => 'admin', 'password' => 'admin', 'admin' => true]);
        for ($i = 0; $i < 10; $i++) {
            $this->syncUser(['username' => "user{$i}", 'password' => "user{$i}", 'admin' => false]);
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
