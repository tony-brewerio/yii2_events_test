<?php

namespace app\controllers;

use app\components\Access;
use app\models\NotificationDatabase;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;

class NotificationDatabaseTargetedController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'mark-as-viewed' => ['post'],
                ],
            ],
            'access' => Access::onlyAuthenticated(),
        ];
    }

    /**
     * Displays listView of database notifications targeted at current user
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => NotificationDatabase::find()
                ->where(['target_id' => \Yii::$app->user->getId()])
                ->orderBy('id desc'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionMarkAsViewed($id)
    {
        $model = NotificationDatabase::findOne([
            'id' => $id,
            'target_id' => \Yii::$app->user->getId(),
        ]);
        $model->viewed = true;
        $model->save();
        return $this->renderAjax('_item', [
            'model' => $model,
        ]);
    }

}
