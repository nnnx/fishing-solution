<?php

/**
 * @var yii\web\View $this
 * @var app\models\TestCaseItemSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\grid\GridView;
use yii\bootstrap4\LinkPager;

$this->title = 'Результаты аномалий: ' . $searchModel::caseName();
?>

<h1>Результаты аномалий</h1>

<?= $this->render('_tabs') ?>

<br/>

<?= $this->render('_case_search', ['model' => $searchModel]) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $searchModel->gridColumns(),
    'summary' => false,
]); ?>
