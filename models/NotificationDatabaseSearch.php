<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NotificationDatabase;

/**
 * NotificationDatabaseSearch represents the model behind the search form about `app\models\NotificationDatabase`.
 */
class NotificationDatabaseSearch extends NotificationDatabase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sender_id', 'target_id', 'viewed'], 'integer'],
            [['title', 'body', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = NotificationDatabase::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sender_id' => $this->sender_id,
            'target_id' => $this->target_id,
            'viewed' => $this->viewed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
