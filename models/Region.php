<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $id
 * @property string $name Название
 *
 * @property FishCatch[] $fishCatches
 */
class Region extends \yii\db\ActiveRecord implements ImportableInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region';
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
        return $this->hasMany(FishCatch::className(), ['region_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function columns()
    {
        return [
            'id_region' => 'id',
            'region' => 'name',
        ];
    }
}