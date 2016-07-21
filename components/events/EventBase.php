<?php

namespace app\components\events;

use app\models\User;
use yii\base\Event;

/**
 * @property User $user
 * @property string $targetUsername
 */
class EventBase extends Event
{
    public $user;
    public $targetUsername;

    public function templateVarsNames()
    {
        $names = [];
        foreach ((new \ReflectionClass(static::className()))->getProperties() as $property) {
            // only properties defined on actual event class or base are visible to the user and used in templates
            // user property is an excpetion that is not allowed so to not accidentally leak password hash
            $declaredOnEvent = $property->getDeclaringClass()->getName() == static::className();
            $declaredOnBase = $property->getDeclaringClass()->getName() == EventBase::className();
            if (($declaredOnEvent || $declaredOnBase) && $property->name != 'user') {
                $names[] = $property->getName();
            }
        }
        return $names;
    }

    public function templateVars()
    {
        $vars = [];
        foreach ($this->templateVarsNames() as $name) {
            $vars[$name] = $this->$name;
        }
        return $vars;
    }
}
