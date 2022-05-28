<?php

/**
 * @var yii\web\View $this
 * @var app\models\AnomalyFishSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\grid\GridView;

$this->title = 'Результаты аномалий: ' . $searchModel::caseName();
?>

<h1>Результаты аномалий</h1>

<?= $this->render('_tabs') ?>

<br/>

<?= $this->render('_catch_search', ['model' => $searchModel]) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $searchModel->gridColumns(),
    'summary' => false,
    'tableOptions' => [
        'class' => 'table table-bordered'
    ],
    'rowOptions' => function ($model) {
        return ['class' => 'tr-cluster tr-cluster-' . $model->cluster_nr];
    },
]); ?>
