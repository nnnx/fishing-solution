<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "regime".
 *
 * @property int $id
 * @property string $name Название
 *
 * @property FishCatch[] $fishCatches
 */
class Regime extends \yii\db\ActiveRecord implements ImportableInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regime';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
        ];
    }

    /**
     * Gets query for [[FishCatches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFishCatches()
    {
        return $this->hasMany(FishCatch::className(), ['regime_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function columns()
    {
        return [
            'id_regime' => 'id',
            'regime' => 'name',
        ];
    }
}