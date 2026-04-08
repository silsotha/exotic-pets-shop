<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpeciesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('species')->insert([
            [
                'name'           => 'Пантеровый хамелеон',
                'class'          => 'рептилии',
                'habitat'        => 'Мадагаскар',
                'temp_min'       => 24,
                'temp_max'       => 32,
                'humidity_min'   => 60,
                'humidity_max'   => 80,
                'quarantine_days'=> 30,
            ],
            [
                'name'           => 'Голубой древесный питон',
                'class'          => 'рептилии',
                'habitat'        => 'Новая Гвинея',
                'temp_min'       => 27,
                'temp_max'       => 32,
                'humidity_min'   => 70,
                'humidity_max'   => 90,
                'quarantine_days'=> 45,
            ],
            [
                'name'           => 'Аксолотль',
                'class'          => 'амфибии',
                'habitat'        => 'Мексика',
                'temp_min'       => 14,
                'temp_max'       => 20,
                'humidity_min'   => 80,
                'humidity_max'   => 100,
                'quarantine_days'=> 21,
            ],
            [
                'name'           => 'Гиацинтовый ара',
                'class'          => 'птицы',
                'habitat'        => 'Южная Америка',
                'temp_min'       => 20,
                'temp_max'       => 28,
                'humidity_min'   => 50,
                'humidity_max'   => 70,
                'quarantine_days'=> 30,
            ],
            [
                'name'           => 'Сахарный поссум',
                'class'          => 'млекопитающие',
                'habitat'        => 'Австралия',
                'temp_min'       => 18,
                'temp_max'       => 26,
                'humidity_min'   => 40,
                'humidity_max'   => 60,
                'quarantine_days'=> 14,
            ],
            [
                'name'           => 'Палочник гигантский',
                'class'          => 'насекомые',
                'habitat'        => 'Юго-Восточная Азия',
                'temp_min'       => 22,
                'temp_max'       => 28,
                'humidity_min'   => 70,
                'humidity_max'   => 85,
                'quarantine_days'=> 14,
            ],
        ]);
    }
}