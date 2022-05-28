<?php

/**
 * @var $model \app\models\TestCase2ItemSearch
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
        <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ]
        ]); ?>
    </div>
    <div class="col-md-9">
        <?= $form->field($model, 'region') ?>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'ves_id') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'volume') ?>
    </div>
</div>

<?= Html::submitButton('Применить', ['class' => 'btn btn-primary']) ?>
<?= Html::a('Сбросить', $form->action, ['class' => 'btn btn-light ml-2']) ?>

<?php ActiveForm::end(); ?>

<br/>