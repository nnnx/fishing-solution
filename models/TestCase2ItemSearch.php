<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * TestCaseItemSearch represents the model behind the search form of `app\models\TestCase2Item`.
 */
class TestCase2ItemSearch extends TestCase2Item
{

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TestCaseItem::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'volume' => $this->volume,
            'score' => $this->score,
        ]);

        $query->andFilterWhere(['ilike', 'region', $this->region]);
        $query->andFilterWhere(['ilike', 'ves_id', $this->ves_id]);

        return $dataProvider;
    }
}
