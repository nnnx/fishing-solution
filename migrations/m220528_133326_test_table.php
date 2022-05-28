<?php

use yii\db\Migration;

/**
 * Class m220528_133326_test_table
 */
class m220528_133326_test_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('test_case_item', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->comment('Дата'),
            'region' => $this->string(255)->comment('Регион'),
            'fish' => $this->string(255)->comment('Рыба'),
            'volume' => $this->float(3)->defaultValue(0)->comment('Объем'),
            'regime' => $this->string(255)->comment('Вид ловли'),
            'score' => $this->integer(),
        ]);

        $this->createTable('test_case2_item', [
            'id' => $this->primaryKey(),
            'ves_id' => $this->integer()->comment('Ид судна'),
            'date' => $this->date()->comment('Дата'),
            'region' => $this->string(255)->comment('Регион'),
            'volume' => $this->float(3)->defaultValue(0)->comment('Объем'),
            'score' => $this->integer(),
        ]);

        $this->createTable('test_case3_item', [
            'id' => $this->primaryKey(),
            'company_id' => $this->string(255)->comment('Компания'),
            'region' => $this->string(255)->comment('Регион'),
            'some_field' => $this->string(255)->comment('Foo'),
            'some_info' => $this->string(255)->comment('Bar'),
            'extra_info' => $this->string(255)->comment('Baz'),
            'score' => $this->integer(),
        ]);

        $regimes = [
            'не определен',
            'промышленный лов',
            'научные исследования',
            'прибрежное рыболовство',
            'промысел для РФ по международным договорам',
            'добыча (вылов) ВБР, ОДУ которых не установлен',
        ];

        $fish = [
            'Не определен',
            'макруронус',
            'Рыбы и морепродукты',
            'Рыбы',
            'сельди',
            'сардины',
            'шпрот (килька)',
            'хамса',
            'нототении',
            'лещи',
            'клыкачи',
            'карповые',
            'окунеобразные',
            'тунцы',
            'камбалы',
            'палтусы',
            'тресковые',
            'прочие  морские рыбы',
            'пресноводные',
            'крупный частик',
            'Беспозвоночные',
            'ракообразные',
            'дрепана',
            'крабы',
            'креветки и шримсы',
            'моллюски',
            'кальмары',
            'муксун',
            'иглокожие',
        ];

        $regions = [
            'Бирма',
            'Бенин',
            'Бельгия',
            'Барбадос',
            'Бангладеш',
            'Аргентина',
            'БМ',
            'Ангола (НРА)',
            'Алжир (Эль-Джезаир)',
            'Австралия',
            'порт РФ',
            'Рачжин (Наджин)КНДР/',
            'Хабаровск/ДВ/',
            'Владив.торговый порт/ДВ/',
            'Мысовой/ДВ/',
            'П-Камч.торговый порт/ДВ/',
            'Северо-Эвенск/ДВ/',
            'Северодвинск/СБ/',
            'Сидими/ДВ/',
            'Пластун/ДВ/',
            'Эгвекинот/ДВ/',
            'Бухта Лаврова/ДВ/',
            'Малая Кема/ДВ/',
        ];

        for ($i = 0; $i < 1000; $i++) {
            $this->insert('test_case_item', [
                'date' => date('Y-m-d', rand(1622192208, 1653728208)),
                'region' => $regions[array_rand($regions)],
                'fish' => $fish[array_rand($fish)],
                'volume' => rand(10, 50000),
                'regime' => $regimes[array_rand($regimes)],
                'score' => rand(0, 100),
            ]);

            $this->insert('test_case2_item', [
                'ves_id' => rand(123123, 7897899),
                'date' => date('Y-m-d', rand(1622192208, 1653728208)),
                'region' => $regions[array_rand($regions)],
                'volume' => rand(10, 50000),
                'score' => rand(0, 100),
            ]);

            $this->insert('test_case3_item', [
                'company_id' => rand(1234, 745899),
                'region' => $regions[array_rand($regions)],
                'some_field' => '-',
                'some_info' => '-',
                'score' => rand(0, 100),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220528_113323_test_table cannot be reverted.\n";

        return false;
    }
}
