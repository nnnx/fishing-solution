<?php

namespace app\models;

use yii\data\ActiveDataProvider;

/**
 * AnomalyCatchSearch represents the model behind the search form of `app\models\AnomalyCatch`.
 */
class AnomalyCatchSearch extends AnomalyCatch
{
    /** @var string */
    public $date_start;

    /** @var string */
    public $date_end;

    /** @var string[] */
    public $fish1_names;

    /** @var string[] */
    public $fish2_names;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['fish1_names', 'fish2_names', 'date_start', 'date_end'], 'safe'],
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
            'fish1_names' => 'Рыбы БД1',
            'fish2_names' => 'Рыбы БД2',
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AnomalyCatch::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        $query->andFilterWhere([
            'id' => $this->id,
            'db1_id_ves' => $this->db1_id_ves,
            'db1_id_own' => $this->db1_id_own,
            'db1_fish' => $this->fish1_names,
            'db1_catch_volume' => $this->db1_catch_volume,
            'db2_id_ves' => $this->db2_id_ves,
            'db2_id_own' => $this->db2_id_own,
            'db2_fish' => $this->fish2_names,
            'db2_max_vol_per_day' => $this->db2_max_vol_per_day,
            'diff_db1_db2' => $this->diff_db1_db2,
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
     * @return array
     */
    public function getFish1Select()
    {
        $items = AnomalyCatch::find()
            ->select('db1_fish')
            ->orderBy(['db1_fish' => SORT_ASC])
            ->asArray()
            ->distinct()
            ->column();
        return array_combine($items, $items);
    }

    /**
     * @return array
     */
    public function getFish2Select()
    {
        $items = AnomalyCatch::find()
            ->select('db2_fish')
            ->orderBy(['db2_fish' => SORT_ASC])
            ->asArray()
            ->distinct()
            ->column();
        return array_combine($items, $items);
    }

    public function getClusteSelect()
    {
        $items = AnomalyCatch::find()
            ->select('cluster_nr')
            ->orderBy(['cluster_nr' => SORT_ASC])
            ->asArray()
            ->distinct()
            ->column();
        return array_combine($items, $items);
    }
}
