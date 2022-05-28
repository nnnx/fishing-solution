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
    <div class="row">
        <div class="col-md-4">
            <h4>Распределение по кластерам</h4>
            <div id="chartdiv" style="height: 250px;"></div>
        </div>
        <div class="col-md-4">
            <h4>Распределение по рыбам</h4>
            <div id="chartdiv2" style="height: 250px;"></div>
        </div>
    </div>
</div>

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

        //second
        var root = am5.Root.new("chartdiv2");
        root.setThemes([
            am5themes_Animated.new(root)
        ]);
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelX: "none",
            wheelY: "none"
        }));
        var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
            maxDeviation: 0,
            categoryField: "category",
            tooltip: am5.Tooltip.new(root, {themeTags: ["axis"]})
        }));
        var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
            maxDeviation: 0,
            min: 0,
            extraMax: 0.1,
            renderer: am5xy.AxisRendererX.new(root, {})
        }));
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            name: "Series 1",
            xAxis: xAxis,
            yAxis: yAxis,
            valueXField: "value",
            categoryYField: "network",
            tooltip: am5.Tooltip.new(root, {
                pointerOrientation: "left",
                labelText: "{valueX}"
            })
        }));
        var data = <?=json_encode($searchModel->getChartData())?>;
        yAxis.data.setAll(data);
        series.data.setAll(data);
    });
</script>
<?php JSRegister::end() ?>

