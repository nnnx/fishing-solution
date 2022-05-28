<?php

namespace app\models;

use yii\data\ActiveDataProvider;

/**
 * AnomalyOwnerSearch represents the model behind the search form of `app\models\AnomalyOwner`.
 */
class AnomalyOwnerSearch extends AnomalyOwner
{
    /** @var string */
    public $date_start;

    /** @var string */
    public $date_end;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['date_start', 'date_end'], 'safe'],
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
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AnomalyOwner::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        $query->andFilterWhere([
            'id' => $this->id,
            'db1' => $this->db1,
            'db2' => $this->db2,
            'id_own' => $this->id_own,
            'cluster_nr' => $this->cluster_nr,
        ]);

        if ($this->date_start) {
            $query->andWhere(['>=', 'date', date('Y-m-d', strtotime($this->date_start))]);
        }
        if ($this->date_end) {
            $query->andWhere(['<=', 'date', date('Y-m-d', strtotime($this->date_end))]);
        }

        return $dataProvider;
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
}
