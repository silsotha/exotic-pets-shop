<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('feed')->insert([
            [
                'name'             => 'Сверчки домовые',
                'feed_type'        => 'живой корм',
                'unit'             => 'шт',
                'quantity_in_stock'=> 500,
                'min_stock_level'  => 100,
            ],
            [
                'name'             => 'Мыши замороженные',
                'feed_type'        => 'замороженный',
                'unit'             => 'шт',
                'quantity_in_stock'=> 50,
                'min_stock_level'  => 10,
            ],
            [
                'name'             => 'Гранулы для попугаев',
                'feed_type'        => 'сухой',
                'unit'             => 'кг',
                'quantity_in_stock'=> 15,
                'min_stock_level'  => 3,
            ],
            [
                'name'             => 'Мотыль замороженный',
                'feed_type'        => 'замороженный',
                'unit'             => 'кг',
                'quantity_in_stock'=> 5,
                'min_stock_level'  => 1,
            ],
            [
                'name'             => 'Зофобас (личинки)',
                'feed_type'        => 'живой корм',
                'unit'             => 'шт',
                'quantity_in_stock'=> 300,
                'min_stock_level'  => 50,
            ],
        ]);
    }
}