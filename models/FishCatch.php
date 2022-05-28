<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fish_catch".
 *
 * @property int $id
 * @property int $id_ves Id судна
 * @property string $date Дата
 * @property int $region_id Регион
 * @property int $fish_id Рыба
 * @property float|null $catch_volume Объем улова
 * @property int $regime_id Вид ловли
 * @property int $permit Разрешение
 * @property int $company_id Компания
 *
 * @property Fish $fish
 * @property Regime $regime
 * @property Region $region
 */
class FishCatch extends \yii\db\ActiveRecord implements ImportableInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fish_catch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ves', 'date', 'region_id', 'fish_id', 'regime_id', 'permit', 'company_id'], 'required'],
            [['id_ves', 'region_id', 'fish_id', 'regime_id', 'permit', 'company_id'], 'default', 'value' => null],
            [['id_ves', 'region_id', 'fish_id', 'regime_id', 'permit', 'company_id'], 'integer'],
            [['date'], 'safe'],
            [['catch_volume'], 'number'],
            [['fish_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fish::className(), 'targetAttribute' => ['fish_id' => 'id']],
            [['regime_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regime::className(), 'targetAttribute' => ['regime_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
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
            'region_id' => 'Регион',
            'fish_id' => 'Рыба',
            'catch_volume' => 'Объем улова',
            'regime_id' => 'Вид ловли',
            'permit' => 'Разрешение',
            'company_id' => 'Компания',
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
     * Gets query for [[Regime]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegime()
    {
        return $this->hasOne(Regime::className(), ['id' => 'regime_id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @inheritdoc
     */
    public function columns()
    {
        return [
            'id_ves' => 'id_ves',
            'date' => 'date',
            'id_region' => 'region_id',
            'id_fish' => 'fish_id',
            'catch_volume' => 'catch_volume',
            'id_regime' => 'regime_id',
            'permit' => 'permit',
            'id_own' => 'company_id',
        ];
    }
}