<?php

namespace app\components\events;

use app\models\User;
use yii\base\Event;

/**
 * @property User $user
 */
class EventBase extends Event
{
    public $user;

    public function templateVarsNames()
    {
        $names = [];
        foreach ((new \ReflectionClass(static::className()))->getProperties() as $property) {
            // only properties defined on actual event class are visible to the user and used in templates
            if ($property->getDeclaringClass()->getName() == static::className()) {
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
