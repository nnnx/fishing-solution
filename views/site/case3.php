<?php

/**
 * @var yii\web\View $this
 * @var app\models\TestCase3ItemSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\grid\GridView;

$this->title = 'Результаты аномалий: ' . $searchModel::caseName();
?>

<h1>Результаты аномалий</h1>

<?= $this->render('_tabs') ?>

<br/>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $searchModel->gridColumns(),
    'summary' => false,
]); ?>
