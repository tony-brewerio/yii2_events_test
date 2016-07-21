<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NotificationDatabaseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-database-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sender_id') ?>

    <?= $form->field($model, 'target_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'body') ?>

    <?php // echo $form->field($model, 'viewed') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
