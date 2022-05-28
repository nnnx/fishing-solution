<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anomaly_fish".
 *
 * @property int $id
 * @property string|null $date Дата
 * @property int|null $db1 Значение 1 базы
 * @property int|null $db2 Значение 2 базы
 * @property int|null $diff_db1_db2 Разница
 * @property string|null $fish_name Рыба
 * @property int|null $cluster_nr Номер кластера
 * @property int|null $mean_error Средняя ошибка
 */
class AnomalyFish extends AnomalyBase
{
    protected $importFilename = 'fish_anomaly.csv';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anomaly_fish';
    }

    public static function caseName()
    {
        return 'В разрере рыб';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['db1', 'db2', 'diff_db1_db2', 'cluster_nr', 'mean_error'], 'default', 'value' => null],
            [['db1', 'db2', 'diff_db1_db2', 'cluster_nr', 'mean_error'], 'integer'],
            [['fish_name'], 'string', 'max' => 255],
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
            'db1' => 'Значение 1 базы',
            'db2' => 'Значение 2 базы',
            'diff_db1_db2' => 'Разница',
            'fish_name' => 'Рыба',
            'cluster_nr' => 'Номер кластера',
            'mean_error' => 'Средняя ошибка',
        ];
    }

    public function gridColumns()
    {
        return [
            ['class' => 'yii\grid\SerialColumn'],
            'date:date',
            'db1',
            'db2',
            'diff_db1_db2',
            'fish_name',
            'cluster_nr',
            'mean_error',
        ];
    }
}
