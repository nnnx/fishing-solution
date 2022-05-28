<?php

namespace app\controllers;

use app\models\TestCase2ItemSearch;
use app\models\TestCase3ItemSearch;
use app\models\TestCaseItemSearch;
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
        $searchModel = new TestCaseItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCase2()
    {
        $searchModel = new TestCase2ItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('case2', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCase3()
    {
        $searchModel = new TestCase3ItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('case3', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
