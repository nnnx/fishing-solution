<?php

use yii\db\Migration;

/**
 * Class m220528_163147_anomaly
 */
class m220528_163147_anomaly extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('anomaly_owner', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->comment('Дата'),
            'db1' => $this->float(3)->comment('Значение 1 базы'),
            'db2' => $this->float(3)->comment('Значение 2 базы'),
            'diff_db1_db2' => $this->float(3)->defaultValue(0)->comment('Разница, тонны'),
            'id_own' => $this->string(255)->comment('Владелец'),
            'cluster_nr' => $this->integer()->comment('Номер кластера'),
            'mean_error' => $this->integer()->comment('Средняя ошибка'),
        ]);

        $this->createIndex('ix_anomaly_owner__date', 'anomaly_owner', 'date');

        $this->createTable('anomaly_fish', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->comment('Дата'),
            'db1' => $this->integer()->comment('Значение 1 базы'),
            'db2' => $this->integer()->comment('Значение 2 базы'),
            'diff_db1_db2' => $this->integer()->defaultValue(0)->comment('Разница'),
            'fish_name' => $this->string(255)->comment('Рыба'),
            'cluster_nr' => $this->integer()->comment('Номер кластера'),
            'mean_error' => $this->integer()->comment('Средняя ошибка'),
        ]);

        $this->createIndex('ix_anomaly_fish__date', 'anomaly_fish', 'date');
        $this->createIndex('ix_anomaly_fish__fish_name', 'anomaly_fish', 'fish_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220528_163147_anomaly cannot be reverted.\n";

        return false;
    }
}
