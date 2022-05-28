<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_type".
 *
 * @property int $id
 * @property string $name Название
 * @property int|null $fish_id Рыба
 * @property string|null $name_full Полное название
 *
 * @property Fish $fish
 * @property Product[] $products
 */
class ProductType extends \yii\db\ActiveRecord implements ImportableInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['fish_id'], 'default', 'value' => null],
            [['fish_id'], 'integer'],
            [['name', 'name_full'], 'string', 'max' => 255],
            [['fish_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fish::className(), 'targetAttribute' => ['fish_id' => 'id']],
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
            'fish_id' => 'Рыба',
            'name_full' => 'Полное название',
        ];
    }

    /**
     * Gets query for [[Fish]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFish()
    {
        return $this->hasOne(Fish::className(), ['id' => 'fish_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['type_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function columns()
    {
        return [
            'id_prod_type' => 'id',
            'prod_type' => 'name',
            'id_fish' => 'fish_id',
            'prod_type_full' => 'name_full',
        ];
    }
}