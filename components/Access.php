<?php

namespace app\components;

use Yii;
use yii\filters\AccessControl;

class Access
{

    public static function onlyAdmins()
    {
        return [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->user->identity->admin;
                    }
                ],
            ],
        ];
    }

    public static function isAdmin()
    {
        return static::isAuthenticated() && Yii::$app->user->identity->admin;
    }

    public static function isAuthenticated()
    {
        return !Yii::$app->user->isGuest;
    }

}
