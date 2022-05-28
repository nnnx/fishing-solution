<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "anomaly_catch".
 *
 * @property int $id
 * @property string|null $date Дата
 * @property int|null $db1_id_ves Номер судна БД1
 * @property int|null $db1_id_own Номер владельца БД1
 * @property string|null $db1_fish Рыба БД1
 * @property float|null $db1_catch_volume Объём улова БД1
 * @property int|null $db2_id_ves Номер судна БД2
 * @property int|null $db2_id_own Номер владельца БД2
 * @property string|null $db2_fish Рыба БД2
 * @property float|null $db2_max_vol_per_day Объём улова БД2
 * @property float|null $diff_db1_db2 Разница
 * @property int|null $cluster_nr Номер кластера
 * @property int|null $mean_error Средняя разница
 */
class AnomalyCatch extends AnomalyBase
{
    protected $importFilename = 'per_row_anomaly.csv';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anomaly_catch';
    }

    public static function caseName()
    {
        return 'По максимальному значению вылова в день';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['db1_id_ves', 'db1_id_own', 'db2_id_ves', 'db2_id_own', 'cluster_nr', 'mean_error'], 'default', 'value' => null],
            [['db1_id_ves', 'db1_id_own', 'db2_id_ves', 'db2_id_own', 'cluster_nr', 'mean_error'], 'integer'],
            [['db1_catch_volume', 'db2_max_vol_per_day', 'diff_db1_db2'], 'number'],
            [['db1_fish', 'db2_fish'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'db1_id_ves' => 'Номер судна БД1',
            'db1_id_own' => 'Номер владельца БД1',
            'db1_fish' => 'Рыба БД1',
            'db1_catch_volume' => 'Объём улова БД1',
            'db2_id_ves' => 'Номер судна БД2',
            'db2_id_own' => 'Номер владельца БД2',
            'db2_fish' => 'Рыба БД2',
            'db2_max_vol_per_day' => 'Объём улова БД2',
            'diff_db1_db2' => 'Разница',
            'cluster_nr' => 'Номер кластера',
            'mean_error' => 'Средняя разница',
        ];
    }

    public function gridColumns()
    {
        return [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'date',
                'format' => 'date',
                'headerOptions' => ['style' => 'width:110px'],
            ],
            [
                'format' => 'raw',
                'header' => 'Номер судна/<br/>владельца БД1',
                'content' => function ($model) {
                    return $model->db1_id_ves . '<br/>' . $model->db1_id_own;
                },
            ],
            'db1_fish',
            'db1_catch_volume',
            [
                'format' => 'raw',
                'header' => 'Номер судна/<br/>владельца БД2',
                'content' => function ($model) {
                    return $model->db2_id_ves . '<br/>' . $model->db2_id_own;
                },
            ],
            [
                'attribute' => 'db2_fish',
                'content' => function ($model) {
                    if ($model->db2_fish != $model->db1_fish) {
                        return Html::tag('span', $model->db2_fish, ['class' => 'text-danger']);
                    }
                    return $model->db2_fish;
                },
            ],
            'db2_max_vol_per_day',
            'diff_db1_db2',
            [
                'attribute' => 'cluster_nr',
                'headerOptions' => ['style' => 'width:95px'],
            ],
            [
                'attribute' => 'mean_error',
                'headerOptions' => ['style' => 'width:95px'],
            ],
        ];
    }
}
