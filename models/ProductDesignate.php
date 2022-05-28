<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_designate".
 *
 * @property int $id
 * @property string $name Название
 *
 * @property Product[] $products
 */
class ProductDesignate extends \yii\db\ActiveRecord implements ImportableInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_designate';
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
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['designate_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function columns()
    {
        return [
            'id_prod_designate' => 'id',
            'prod_designate' => 'name',
        ];
    }
}