<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'name'           => 'ООО «ЭкзотикТрейд»',
                'contact_person' => 'Иванов Сергей Петрович',
                'phone'          => '+7 (495) 123-45-67',
                'email'          => 'info@exotictrade.ru',
                'license_number' => 'ЛИЦ-2021-00145',
            ],
            [
                'name'           => 'ИП Смирнова А.В.',
                'contact_person' => 'Смирнова Анна Васильевна',
                'phone'          => '+7 (812) 987-65-43',
                'email'          => 'smirnova.pets@mail.ru',
                'license_number' => 'ЛИЦ-2020-00089',
            ],
            [
                'name'           => 'Reptile House Ltd.',
                'contact_person' => 'Джон Уилсон',
                'phone'          => '+44 20 7946 0958',
                'email'          => 'supply@reptilehouse.co.uk',
                'license_number' => 'UK-CITES-774412',
            ],
        ]);
    }
}