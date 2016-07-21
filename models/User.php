<?php

namespace app\models;

use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property string $password_hash
 * @property boolean admin
 */
class User extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_DATAGEN = 'datagen';

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('access token authentication is not supported');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public static function options()
    {
        return ArrayHelper::map(
            static::find()
                ->select(['id', 'username'])
                ->orderBy(['username' => 'asc'])
                ->all(),
            'id', 'username'
        );
    }

    public function rules()
    {
        $rules = [
            [['username', 'email'], 'required'],
            [['username', 'email'], 'unique'],
            ['email', 'email'],
        ];
        $rules[] = ['admin', 'boolean', 'on' => static::SCENARIO_DATAGEN];
        $rules[] = ['password', 'safe', 'on' => static::SCENARIO_DATAGEN];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        throw new NotSupportedException('access token authentication is not supported');
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException('access token authentication is not supported');
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }


}
