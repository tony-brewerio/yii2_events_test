<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\NotificationDatabase */

$this->title = 'Create Notification Database';
$this->params['breadcrumbs'][] = ['label' => 'Notification Databases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-database-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
