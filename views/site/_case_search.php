<?php

/**
 * @var $model \app\models\TestCaseItemSearch
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\date\DatePicker;

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'action' => '/' . Yii::$app->request->pathInfo,
]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'date_start')->widget(DatePicker::classname(), [
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ]
        ]); ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'date_end')->widget(DatePicker::classname(), [
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ]
        ]); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'region') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'regime') ?>
    </div>
</div>

<?= $form->field($model, 'fish')->widget(Select2::classname(), [
    'data' => $model->getFishSelect(),
    'theme' => Select2::THEME_BOOTSTRAP,
    'showToggleAll' => false,
    'options' => [
        'placeholder' => '',
        'multiple' => true,
    ],
]); ?>

<?= Html::submitButton('Применить', ['class' => 'btn btn-primary']) ?>
<?= Html::a('Сбросить', $form->action, ['class' => 'btn btn-light ml-2']) ?>

<?php ActiveForm::end(); ?>

<br/>