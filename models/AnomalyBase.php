<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;

abstract class AnomalyBase extends \yii\db\ActiveRecord
{
    /** @var string */
    protected $importFilename;

    /**
     * название разрера
     * @return string
     */
    abstract static function caseName();

    /**
     * массив колонок для GridView
     * @return array
     */
    abstract public function gridColumns();

    /**
     * импорт результатов из csv
     * @return void
     * @throws Exception
     */
    public function import()
    {
        if (!$this->importFilename) {
            throw new Exception('Не указано имя файла');
        }
        $path = Yii::getAlias('@app/results/' . $this->importFilename);
        if (!file_exists($path)) {
            throw new Exception('Файл не найден: ' . $path);
        }
        Yii::$app->db->createCommand()->truncateTable(self::tableName());
        $handle = fopen($path, "r");
        $columns = fgetcsv($handle, 0, ',');
        $data = [];
        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $data[] = $row;
            if (count($data) == 100) {
                Yii::$app->db->createCommand()->batchInsert(self::tableName(), $columns, $data)->execute();
                $data = [];
            }
        }
        if (count($data)) {
            Yii::$app->db->createCommand()->batchInsert(self::tableName(), $columns, $data);
        }
    }
}