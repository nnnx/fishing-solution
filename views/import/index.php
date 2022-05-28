<?php

/**
 * @var $model \app\models\form\ImportCsv
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Импорт';
?>

<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => [
        'enctype' => 'multipart/form-data',
    ],
]); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'table')->dropDownList($model::getTables(), [
            'prompt' => '',
        ]) ?>
    </div>
</div>


<?= $form->field($model, 'file')->fileInput() ?>

<?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>
