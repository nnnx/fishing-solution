<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $id_ves Id судна
 * @property string $date Дата
 * @property int $designate_id Назначение
 * @property int $type_id Тип
 * @property float|null $prod_volume Объем
 * @property float|null $prod_board_volume Итоговый объем на борту
 *
 * @property ProductDesignate $designate
 * @property ProductType $type
 */
class Product extends \yii\db\ActiveRecord implements ImportableInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ves', 'date', 'designate_id', 'type_id'], 'required'],
            [['id_ves', 'designate_id', 'type_id'], 'default', 'value' => null],
            [['id_ves', 'designate_id', 'type_id'], 'integer'],
            [['date'], 'safe'],
            [['prod_volume', 'prod_board_volume'], 'number'],
            [['designate_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductDesignate::className(), 'targetAttribute' => ['designate_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ves' => 'Id судна',
            'date' => 'Дата',
            'designate_id' => 'Назначение',
            'type_id' => 'Тип',
            'prod_volume' => 'Объем',
            'prod_board_volume' => 'Итоговый объем на борту',
        ];
    }

    /**
     * Gets query for [[Designate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDesignate()
    {
        return $this->hasOne(ProductDesignate::className(), ['id' => 'designate_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'type_id']);
    }

    /**
     * @inheritdoc
     */
    public function columns()
    {
        return [
            'id_ves' => 'id_ves',
            'date' => 'date',
            'id_prod_designate' => 'designate_id',
            'id_prod_type' => 'type_id',
            'prod_volume' => 'prod_volume',
            'prod_board_volume' => 'prod_board_volume',
        ];
    }
}