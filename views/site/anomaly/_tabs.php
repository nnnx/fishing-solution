<?php

use yii\bootstrap4\Nav;

echo Nav::widget([
    'options' => ['class' => 'nav nav-tabs'],
    'items' => [
        [
            'label' => \app\models\AnomalyFish::caseName(),
            'url' => ['site/index']
        ],
        [
            'label' => \app\models\AnomalyOwner::caseName(),
            'url' => ['site/owner'],
        ],
        [
            'label' => \app\models\AnomalyCatch::caseName(),
            'url' => ['site/catch'],
        ],
    ],
]);