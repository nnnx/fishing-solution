<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;

class ImportDb extends Model
{
    /** @var \yii\web\UploadedFile|null */
    public $file;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => ['zip']],
        ];
    }

    /**
     * @return bool
     */
    public function process()
    {
        try {
            $zip = new \ZipArchive();
            $zip->open($this->file->tempName);
            $dir = Yii::getAlias('@app/web/uploads/');
            FileHelper::createDirectory($dir);
            $zip->extractTo($dir);
            $zip->close();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}