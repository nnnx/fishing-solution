<?php

/**
 * @var $model \app\models\AnomalyOwnerSearch
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'action' => '/' . Yii::$app->request->pathInfo,
]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'date_start')->widget(DatePicker::class, [
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ]
        ]); ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'date_end')->widget(DatePicker::class, [
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ]
        ]); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'db1') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'db2') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'cluster_nr')->dropDownList($model->getClusteSelect(), [
            'prompt' => 'Все',
        ]) ?>
    </div>
</div>

<?= Html::submitButton('Применить', ['class' => 'btn btn-primary']) ?>
<?= Html::a('Сбросить', $form->action, ['class' => 'btn btn-light ml-2']) ?>

<?php ActiveForm::end(); ?>

<br/>