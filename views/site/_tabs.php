<?php

use yii\bootstrap4\Nav;

echo Nav::widget([
    'options' => ['class' => 'nav nav-tabs'],
    'items' => [
        [
            'label' => \app\models\TestCaseItem::caseName(),
            'url' => ['site/index']
        ],
        [
            'label' => \app\models\TestCase2Item::caseName(),
            'url' => ['site/case2'],
        ],
        [
            'label' => \app\models\TestCase3Item::caseName(),
            'url' => ['site/case3'],
        ],
    ],
]);