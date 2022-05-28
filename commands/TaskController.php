<?php

namespace app\commands;

use app\models\AnomalyBase;
use yii\console\Controller;
use yii\console\ExitCode;

class TaskController extends Controller
{
    /**
     * записать результы обработки из csv
     * @return int
     */
    public function actionImportResults()
    {
        $classes = [
            \app\models\AnomalyFish::class,
            \app\models\AnomalyOwner::class,
            \app\models\AnomalyCatch::class,
        ];

        foreach ($classes as $class) {
            /** @var AnomalyBase $model */
            $model = new $class;
            $model->import();
        }

        return ExitCode::OK;
    }
}
