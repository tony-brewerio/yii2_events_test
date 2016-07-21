<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\NotificationDatabase */

$formatter = \Yii::$app->formatter;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Notification Databases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-database-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sender_id',
            'target_id',
            'title',
            [
                'label' => 'Body',
                'value' => nl2br($model->body),
                'format' => 'html',
            ],
            'viewed',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
