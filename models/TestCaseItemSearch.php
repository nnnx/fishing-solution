<?php

namespace app\models;

use yii\data\ActiveDataProvider;

/**
 * TestCaseItemSearch represents the model behind the search form of `app\models\TestCaseItem`.
 */
class TestCaseItemSearch extends TestCaseItem
{
    public $date_start;
    public $date_end;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'score'], 'integer'],
            [['date', 'region', 'fish', 'regime'], 'safe'],
            [['volume'], 'number'],
            ['date_end', 'dateRangeValidate'],
        ];
    }

    public function dateRangeValidate($attr)
    {
        if ($this->date_start && $this->date_end) {
            if (strtotime($this->date_end) < strtotime($this->date_start)) {
                $this->addError($attr, 'Дата конца не может быть раньше даты начала');
            }
        }
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['date_start'] = 'Дата с';
        $labels['date_end'] = 'Дата по';

        return $labels;
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

        $query->andFilterWhere(['ilike', 'region', $this->region])
            ->andFilterWhere(['ilike', 'fish', $this->fish])
            ->andFilterWhere(['ilike', 'regime', $this->regime]);

        if ($this->date_start) {
            $query->andWhere(['>=', 'date', date('Y-m-d', strtotime($this->date_start))]);
        }
        if ($this->date_end) {
            $query->andWhere(['<=', 'date', date('Y-m-d', strtotime($this->date_end))]);
        }

        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getFishSelect()
    {
        $items = self::find()
            ->select('fish')
            ->orderBy(['fish' => SORT_ASC])
            ->asArray()
            ->distinct()
            ->column();

        return array_combine($items, $items);
    }
}
