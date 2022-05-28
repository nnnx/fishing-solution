<?php

namespace app\models;

interface ImportableInterface
{
    /**
     * @return array
     */
    public function columns();
}
