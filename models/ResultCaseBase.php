<?php

namespace app\models;

abstract class ResultCaseBase extends \yii\db\ActiveRecord
{
    abstract static function caseName();

    abstract public function gridColumns();
}