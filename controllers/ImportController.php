<?php

namespace app\controllers;

use app\models\form\ImportCsv;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class ImportController extends Controller
{
    public function actionIndex()
    {
        $model = new ImportCsv();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $errors = ActiveForm::validate($model);
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $errors;
            }
            $model->process();
            return $this->redirect(['index']);
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}