<?php

/**
 * @var yii\web\View $this
 * @var app\models\AnomalyFishSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\grid\GridView;
use richardfan\widget\JSRegister;

$this->title = 'Результаты аномалий: ' . $searchModel::caseName();
?>

<h1>Результаты аномалий</h1>

<?= $this->render('_tabs') ?>

<br/>

<?= $this->render('_fish_search', ['model' => $searchModel]) ?>

<div class="d-none">
    <div id="chartdiv" style="height: 250px;"></div>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $searchModel->gridColumns(),
    'summary' => false,
]); ?>

<?php JSRegister::begin() ?>
<script>
    am5.ready(function () {
        var root = am5.Root.new("chartdiv");
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        var chart = root.container.children.push(
            am5percent.PieChart.new(root, {
                endAngle: 270
            })
        );
        var series = chart.series.push(
            am5percent.PieSeries.new(root, {
                valueField: "value",
                categoryField: "category",
                endAngle: 270,
                tooltip: am5.Tooltip.new(root, {
                    labelText: "Кластер {category}: [bold]{value}[/] тонн"
                })
            })
        );
        series.states.create("hidden", {
            endAngle: -90
        });
        series.data.setAll(<?=json_encode($searchModel->getChartData())?>);
        series.appear(1000, 100);
    });
</script>
<?php JSRegister::end() ?>

