<?php

namespace app\models;

use yii\data\ActiveDataProvider;

/**
 * AnomalyFishSearch represents the model behind the search form of `app\models\AnomalyFish`.
 */
class AnomalyFishSearch extends AnomalyFish
{
    /** @var string */
    public $date_start;

    /** @var string */
    public $date_end;

    /** @var string[] */
    public $fish_names;

    /** @var array */
    protected $chartData = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['fish_names', 'date_start', 'date_end'], 'safe'],
            ['date_end', 'dateRangeValidate'],
        ]);
    }

    /**
     * @param $attr
     * @return void
     */
    public function dateRangeValidate($attr)
    {
        if ($this->date_start && $this->date_end) {
            if (strtotime($this->date_end) < strtotime($this->date_start)) {
                $this->addError($attr, 'Дата конца не может быть раньше даты начала');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'date_start' => 'Дата с',
            'date_end' => 'Дата по',
            'fish_names' => 'Рыбы',
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AnomalyFish::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        $query->andFilterWhere([
            'id' => $this->id,
            'db1' => $this->db1,
            'db2' => $this->db2,
            'fish_name' => $this->fish_names,
            'cluster_nr' => $this->cluster_nr,
        ]);

        if ($this->date_start) {
            $query->andWhere(['>=', 'date', date('Y-m-d', strtotime($this->date_start))]);
        }
        if ($this->date_end) {
            $query->andWhere(['<=', 'date', date('Y-m-d', strtotime($this->date_end))]);
        }

        $chartQuery = clone $query;
        $this->chartData = $chartQuery->select(['cluster_nr AS category', 'ROUND(AVG(mean_error)) AS value'])
            ->groupBy('cluster_nr')
            ->asArray()
            ->all();

        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getFishSelect()
    {
        $items = AnomalyFish::find()
            ->select('fish_name')
            ->orderBy(['fish_name' => SORT_ASC])
            ->asArray()
            ->distinct()
            ->column();
        return array_combine($items, $items);
    }

    /**
     * @return array|false
     */
    public function getClusteSelect()
    {
        $items = AnomalyFish::find()
            ->select('cluster_nr')
            ->orderBy(['cluster_nr' => SORT_ASC])
            ->asArray()
            ->distinct()
            ->column();
        return array_combine($items, $items);
    }

    /**
     * @return array
     */
    public function getChartData()
    {
        return $this->chartData;
    }

    public function getChartFishTopDiff()
    {
        return AnomalyFish::find()
            ->select([
                'round(avg(diff_db1_db2)) as value',
                'fish_name as category',
            ])
            ->groupBy('fish_name')
            ->asArray()
            ->all();
    }
}
