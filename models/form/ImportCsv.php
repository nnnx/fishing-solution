<?php

namespace app\models\form;

use Yii;
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
    /** @var string */
    public $modelClass;

    /** @var \yii\web\UploadedFile|null */
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
            ['modelClass', 'required'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => ['csv']],
            ['modelClass', 'in', 'range' => array_keys(self::getTables())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'modelClass' => 'Таблица',
            'file' => 'Файл',
        ];
    }

    /**
     * @return bool
     */
    public function process()
    {
        try {
            $model = new $this->modelClass;
            $columnsMap = $model->columns();
            $handle = fopen($this->file->tempName, "r");
            $header = fgets($handle);
            $separator = strpos($header, ';') === false ? ',' : ';';
            $keys = explode($separator, $header);
            $keys = array_map(function ($value) use ($columnsMap) {
                $key = str_replace('"', '', $value);
                return $columnsMap[$key] ?? $key;
            }, $keys);
            $data = [];
            while (($row = fgetcsv($handle, 0, $separator)) !== false) {
                $item = array_combine($keys, $row);
                $item = array_filter($item, function ($k) use ($columnsMap) {
                    return in_array($k, $columnsMap);
                }, ARRAY_FILTER_USE_KEY);
                $data[] = $item;
                if (count($data) == 50) {
                    $this->insert($model::tableName(), $columnsMap, $data);
                    $data = [];
                }
            }
            fclose($handle);
            if (count($data)) {
                $this->insert($model::tableName(), $columnsMap, $data);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function insert($table, $columns, $data)
    {
        //todo
        //Yii::$app->db->createCommand()->batchInsert($table, array_values($columns), $data);
    }
}