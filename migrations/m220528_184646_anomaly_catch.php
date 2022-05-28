<?php

use yii\db\Migration;

/**
 * Class m220528_184646_anomaly_catch
 */
class m220528_184646_anomaly_catch extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('anomaly_catch', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->comment('Дата'),
            'db1_id_ves' => $this->integer()->comment('Номер судна БД1'),
            'db1_id_own' => $this->integer()->comment('Номер владельца БД1'),
            'db1_fish' => $this->string(255)->comment('Рыба БД1'),
            'db1_catch_volume' => $this->float(3)->comment('Объём улова БД1'),
            'db2_id_ves' => $this->integer()->comment('Номер судна БД2'),
            'db2_id_own' => $this->integer()->comment('Номер владельца БД2'),
            'db2_fish' => $this->string(255)->comment('Рыба БД2'),
            'db2_max_vol_per_day' => $this->float(3)->comment('Объём улова БД2'),
            'diff_db1_db2' => $this->float(3)->comment('Разница'),
            'cluster_nr' => $this->integer()->comment('Номер кластера'),
            'mean_error' => $this->integer()->comment('Средняя разница'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220528_184646_anomaly_catch cannot be reverted.\n";

        return false;
    }
}
