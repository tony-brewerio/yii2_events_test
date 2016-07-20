<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NotificationTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event')->dropDownList($model->eventsOptions()) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sender_id')->dropDownList(User::options(), ['prompt' => '']) ?>

    <?= $form->field($model, 'target_mode')->dropDownList($model->targetModeOptions()) ?>

    <?= $form->field($model, 'target_id')->dropDownList(User::options(), ['prompt' => '']) ?>

    <?= $form->field($model, 'notify_database')->checkbox() ?>

    <?= $form->field($model, 'notify_email')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
