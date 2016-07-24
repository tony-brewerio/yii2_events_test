<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
$users = [];
$users[] = [
    'username' => 'admin', 'email' => "admin@example.com",
    'password_hash' => \Yii::$app->security->generatePasswordHash('admin', 8), 'admin' => true
];
for ($i = 0; $i < 10; $i++) {
    $users[] = [
        'username' => "user{$i}", 'email' => "user{$i}@example.com",
        'password_hash' => \Yii::$app->security->generatePasswordHash("user{$i}", 8), 'admin' => false
    ];
}
return $users;
