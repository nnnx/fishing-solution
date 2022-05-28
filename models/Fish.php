<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fish".
 *
 * @property int $id
 * @property string $name Название
 *
 * @property FishCatch[] $fishCatches
 * @property ProductType[] $productTypes
 */
class Fish extends \yii\db\ActiveRecord implements ImportableInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fish';
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
        return $this->hasMany(FishCatch::className(), ['fish_id' => 'id']);
    }

    /**
     * Gets query for [[ProductTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypes()
    {
        return $this->hasMany(ProductType::className(), ['fish_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function columns()
    {
        return [
            'id_fish' => 'id',
            'fish' => 'name',
        ];
    }
}