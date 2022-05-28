<?php

namespace app\models\form;

use app\models\Fish;
use app\models\FishCatch;
use app\models\Product;
use app\models\ProductDesignate;
use app\models\ProductType;
use app\models\Regime;
use app\models\Region;
use yii\base\Model;

class ImportCsv extends Model
{
    public $table;

    public $file;

    /**
     * @return array
     */
    public static function getTables()
    {
        return [
            Fish::class => Fish::tableName(),
            FishCatch::class => FishCatch::tableName(),
            Product::class => Product::tableName(),
            ProductDesignate::class => ProductDesignate::tableName(),
            ProductType::class => ProductType::tableName(),
            Regime::class => Regime::tableName(),
            Region::class => Region::tableName(),
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['table', 'required'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
            ['table', 'in', 'range' => array_keys(self::getTables())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'table' => 'Таблица',
            'file' => 'Файл',
        ];
    }

    public function process()
    {
        //todo
        print_r($this->file);exit;
    }
}