<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_case_item".
 *
 * @property int $id
 * @property string|null $date Дата
 * @property string|null $region Регион
 * @property string|null $fish Рыба
 * @property float|null $volume Объем
 * @property string|null $regime Вид ловли
 * @property int|null $score
 */
class TestCaseItem extends ResultCaseBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_case_item';
    }

    public static function caseName()
    {
        return 'По разнице объема';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['volume'], 'number'],
            [['score'], 'default', 'value' => null],
            [['score'], 'integer'],
            [['region', 'fish', 'regime'], 'string', 'max' => 255],
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
            'region' => 'Регион',
            'fish' => 'Рыба',
            'volume' => 'Объем',
            'regime' => 'Вид ловли',
            'score' => 'Score',
        ];
    }

    public function gridColumns()
    {
        return [
            ['class' => 'yii\grid\SerialColumn'],
            'date:date',
            'region',
            'fish',
            'volume',
            'regime',
            'score',
        ];
    }
}
