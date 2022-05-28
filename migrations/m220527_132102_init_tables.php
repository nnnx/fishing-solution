<?php

use yii\db\Migration;

/**
 * Class m220527_132102_init_tables
 */
class m220527_132102_init_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('fish', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Название'),
        ]);

        $this->createTable('product_designate', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Название'),
        ]);

        $this->createTable('product_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Название'),
            'fish_id' => $this->integer()->comment('Рыба'),
            'name_full' => $this->string(255)->comment('Полное название'),
        ]);

        $this->addForeignKey('fk_product_type__fish_id', 'product_type', 'fish_id', 'fish', 'id', 'CASCADE');

        $this->createTable('regime', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Название'),
        ]);

        $this->createTable('region', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Название'),
        ]);

        $this->createTable('fish_catch', [
            'id' => $this->primaryKey(),
            'id_ves' => $this->integer(255)->notNull()->comment('Id судна'),
            'date' => $this->date()->notNull()->comment('Дата'),
            'region_id' => $this->integer()->notNull()->comment('Регион'),
            'fish_id' => $this->integer()->notNull()->comment('Рыба'),
            'catch_volume' => $this->float(3)->defaultValue(0)->comment('Объем улова'),
            'regime_id' => $this->integer()->notNull()->comment('Вид ловли'),
            'permit' => $this->integer()->notNull()->comment('Разрешение'),
            'company_id' => $this->integer()->notNull()->comment('Компания'),
        ]);

        $this->addForeignKey('fk_fish_catch__region_id', 'fish_catch', 'region_id', 'region', 'id', 'CASCADE');
        $this->addForeignKey('fk_fish_catch__fish_id', 'fish_catch', 'fish_id', 'fish', 'id', 'CASCADE');
        $this->addForeignKey('fk_fish_catch__regime_id', 'fish_catch', 'regime_id', 'regime', 'id', 'CASCADE');

        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'id_ves' => $this->integer(255)->notNull()->comment('Id судна'),
            'date' => $this->date()->notNull()->comment('Дата'),
            'designate_id' => $this->integer()->notNull()->comment('Назначение'),
            'type_id' => $this->integer()->notNull()->comment('Тип'),
            'prod_volume' => $this->float(3)->defaultValue(0)->comment('Объем'),
            'prod_board_volume' => $this->float(3)->defaultValue(0)->comment('Итоговый объем на борту'),
        ]);

        $this->addForeignKey('fk_product__designate_id', 'product', 'designate_id', 'product_designate', 'id', 'CASCADE');
        $this->addForeignKey('fk_product__type_id', 'product', 'type_id', 'product_type', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220527_132102_init_tables cannot be reverted.\n";

        return true;
    }
}