<?php

/**
 * @var $model \app\models\form\ImportDb
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Импорт файлов';
?>

<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
    ],
]); ?>

<p>
    Файл должен содержать папки "db1", "db2", вместе или по-отдельности.
</p>

<?= $form->field($model, 'file')->fileInput()->label(false) ?>

<?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>
