<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_case2_item".
 *
 * @property int $id
 * @property int|null $ves_id Ид судна
 * @property string|null $date Дата
 * @property string|null $region Регион
 * @property float|null $volume Объем
 * @property int|null $score
 */
class TestCase2Item extends ResultCaseBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_case2_item';
    }

    public static function caseName()
    {
        return 'По отсутствию продаж';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ves_id', 'score'], 'default', 'value' => null],
            [['ves_id', 'score'], 'integer'],
            [['date'], 'safe'],
            [['volume'], 'number'],
            [['region'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ves_id' => 'Ид судна',
            'date' => 'Дата',
            'region' => 'Регион',
            'volume' => 'Объем',
            'score' => 'Score',
        ];
    }

    public function gridColumns()
    {
        return [
            ['class' => 'yii\grid\SerialColumn'],
            'ves_id',
            'date:date',
            'region',
            'volume',
            'score',
        ];
    }
}
