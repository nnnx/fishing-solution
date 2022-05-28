<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anomaly_owner".
 *
 * @property int $id
 * @property string|null $date Дата
 * @property float|null $db1 Значение 1 базы
 * @property float|null $db2 Значение 2 базы
 * @property float|null $diff_db1_db2 Разница, тонны
 * @property string|null $id_own Владелец
 * @property int|null $cluster_nr Номер кластера
 * @property int|null $mean_error Средняя ошибка
 */
class AnomalyOwner extends AnomalyBase
{
    protected $importFilename = 'id_owner_anomaly.csv';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anomaly_owner';
    }

    /**
     * {@inheritdoc}
     */
    public static function caseName()
    {
        return 'В разрезе владельца';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['db1', 'db2', 'diff_db1_db2'], 'number'],
            [['cluster_nr', 'mean_error'], 'default', 'value' => null],
            [['cluster_nr', 'mean_error'], 'integer'],
            [['id_own'], 'string', 'max' => 255],
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
            'diff_db1_db2' => 'Разница, тонны',
            'id_own' => 'Владелец',
            'cluster_nr' => 'Номер кластера',
            'mean_error' => 'Средняя ошибка',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function gridColumns()
    {
        return [
            ['class' => 'yii\grid\SerialColumn'],
            'date:date',
            'db1',
            'db2',
            'diff_db1_db2',
            'id_own',
            'cluster_nr',
            'mean_error',
        ];
    }
}
