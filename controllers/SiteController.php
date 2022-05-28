<?php

namespace app\controllers;

use app\models\AnomalyCatchSearch;
use app\models\AnomalyFishSearch;
use app\models\AnomalyOwnerSearch;
use Yii;
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
}
