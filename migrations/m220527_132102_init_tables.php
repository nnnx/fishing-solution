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
        $this->createTable('ref_fish', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Название'),
        ]);

        $this->createTable('ref_product_designate', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Название'),
        ]);

        $this->createTable('ref_product_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Название'),
            'fish_id' => $this->integer()->comment('Рыба'),
            'name_full' => $this->string(255)->comment('Полное название'),
        ]);

        $this->addForeignKey('fk_ref_product_type__fish_id', 'ref_product_type', 'fish_id', 'ref_fish', 'id', 'CASCADE');

        $this->createTable('ref_regime', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Название'),
        ]);

        $this->createTable('ref_region', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Название'),
        ]);

        $this->createTable('catch', [
            'id' => $this->primaryKey(),
            'id_ves' => $this->integer(255)->notNull()->comment('Id судна'),
            'date' => $this->date()->notNull()->comment('Дата'),
            'region_id' => $this->integer()->notNull()->comment('Регион'),
            'fish_id' => $this->integer()->notNull()->comment('Рыба'),
            'catch_volume_id' => $this->float(3)->defaultValue(0)->comment('Объем улова'),
            'regime_id' => $this->integer()->notNull()->comment('Вид ловли'),
            'permit' => $this->integer()->notNull()->comment('Разрешение'),
            'company_id' => $this->integer()->notNull()->comment('Компания'),
        ]);

        $this->addForeignKey('fk_catch__region_id', 'catch', 'region_id', 'ref_region', 'id', 'CASCADE');
        $this->addForeignKey('fk_catch__fish_id', 'catch', 'fish_id', 'ref_fish', 'id', 'CASCADE');
        $this->addForeignKey('fk_catch__regime_id', 'catch', 'regime_id', 'ref_regime', 'id', 'CASCADE');

        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'id_ves' => $this->integer(255)->notNull()->comment('Id судна'),
            'date' => $this->date()->notNull()->comment('Дата'),
            'designate_id' => $this->integer()->notNull()->comment('Назначение'),
            'type_id' => $this->integer()->notNull()->comment('Тип'),
            'prod_volume' => $this->float(3)->defaultValue(0)->comment('Объем'),
            'prod_board_volume' => $this->float(3)->defaultValue(0)->comment('Объем платы'),
        ]);

        $this->addForeignKey('fk_product__designate_id', 'product', 'designate_id', 'ref_product_designate', 'id', 'CASCADE');
        $this->addForeignKey('fk_product__type_id', 'product', 'type_id', 'ref_product_type', 'id', 'CASCADE');
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