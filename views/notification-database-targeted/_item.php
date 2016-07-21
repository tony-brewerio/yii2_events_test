<?php
use yii\helpers\Html;
use yii\helpers\Url;

$formatter = \Yii::$app->formatter;

/** @var \app\models\NotificationDatabase $model */
?>
<div class="alert alert-<?= $model->viewed ? 'success' : 'warning' ?>" role="alert">
    <h4><?= Html::encode($model->title) ?></h4>
    <?php if ($model->sender_id): ?>
        <div class="small">
            <?= $formatter->asDatetime($model->created_at) ?>
            от пользователя
            <?= Html::encode($model->sender->username) ?>
        </div>
    <?php else: ?>
        <div class="small"><?= $formatter->asDatetime($model->created_at) ?></div>
    <?php endif ?>
    <div>
        <?= $formatter->asHtml(nl2br($model->body)) ?>
    </div>
    <?php if (!$model->viewed): ?>
        <hr>
        <div>
            <?= Html::button('Прочитано', [
                'class' => 'notification-viewed-button',
                'data-url' => Url::to(['/notification-database-targeted/mark-as-viewed', 'id' => $model->id]),
            ]) ?>
        </div>
    <?php endif ?>
</div>
