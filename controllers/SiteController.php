<?php

namespace app\controllers;

use app\models\AnomalyBase;
use app\models\AnomalyCatchSearch;
use app\models\AnomalyFishSearch;
use app\models\AnomalyOwnerSearch;
use Yii;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new AnomalyFishSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('anomaly/fish', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOwner()
    {
        $searchModel = new AnomalyOwnerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('anomaly/owner', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCatch()
    {
        $searchModel = new AnomalyCatchSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('anomaly/catch', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCalc()
    {
        $path = Yii::getAlias('@app/web/uploads/');
        if (file_exists($path . 'db1') && file_exists($path . 'db1')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://python:5000');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            $resp = curl_exec($ch);
            curl_close($ch);
            if ($resp == '1') {
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
                Yii::$app->session->setFlash('success', 'Успешно сохранено');
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось расчитать');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Сначала нужно загрузить файлы бд');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
