<?php

namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password_repeat'], 'required'],
            [['username', 'email'], 'unique', 'targetClass' => User::className()],
            ['email', 'email'],
            ['password', 'compare'],
        ];
    }
}
