<?php

namespace app\components\events;

use app\models\User;
use yii\base\Model;

/**
 * @property User $user
 * @property string $username
 */
class EventUserRegistered extends Model
{
    public $user;
    public $username;
}
