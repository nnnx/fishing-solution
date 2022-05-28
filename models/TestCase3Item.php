<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_case3_item".
 *
 * @property int $id
 * @property string|null $company_id Компания
 * @property string|null $region Регион
 * @property string|null $some_field Foo
 * @property string|null $some_info Bar
 * @property string|null $extra_info Baz
 * @property int|null $score
 */
class TestCase3Item extends ResultCaseBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_case3_item';
    }

    public static function caseName()
    {
        return 'Lorem ipsum dolor sit amet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['score'], 'default', 'value' => null],
            [['score'], 'integer'],
            [['company_id', 'region', 'some_field', 'some_info', 'extra_info'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Компания',
            'region' => 'Регион',
            'some_field' => 'Foo',
            'some_info' => 'Bar',
            'extra_info' => 'Baz',
            'score' => 'Score',
        ];
    }

    public function gridColumns()
    {
        return [];
    }
}
