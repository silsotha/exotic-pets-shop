<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Sale;
use App\Models\Species;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        /* виды животных */

        $python = Species::updateOrCreate(
            ['name' => 'Королевский питон'],
            [
                'class' => 'рептилии',
                'habitat' => 'Сухой террариум с укрытием, тёплой зоной и поилкой.',
                'description' => "Спокойная неядовитая змея, часто подходит начинающим владельцам.\nВажно поддерживать стабильную температуру и не тревожить животное во время линьки.",
                'care_level' => 'beginner',
                'temp_min' => 26,
                'temp_max' => 32,
                'humidity_min' => 50,
                'humidity_max' => 65,
                'quarantine_days' => 14,
            ]
        );

        $gecko = Species::updateOrCreate(
            ['name' => 'Эублефар'],
            [
                'class' => 'рептилии',
                'habitat' => 'Горизонтальный террариум с сухой и влажной зонами.',
                'description' => "Небольшая ящерица с относительно простым уходом.\nНуждается в укрытиях, кальциевых добавках и контроле температуры.",
                'care_level' => 'beginner',
                'temp_min' => 24,
                'temp_max' => 31,
                'humidity_min' => 35,
                'humidity_max' => 50,
                'quarantine_days' => 10,
            ]
        );

        $chameleon = Species::updateOrCreate(
            ['name' => 'Йеменский хамелеон'],
            [
                'class' => 'рептилии',
                'habitat' => 'Вертикальный террариум с ветками, живыми растениями и вентиляцией.',
                'description' => "Требовательный вид, чувствительный к влажности, температуре и стрессу.\nПодходит владельцам с опытом содержания рептилий.",
                'care_level' => 'advanced',
                'temp_min' => 24,
                'temp_max' => 30,
                'humidity_min' => 50,
                'humidity_max' => 70,
                'quarantine_days' => 21,
            ]
        );

        $frog = Species::updateOrCreate(
            ['name' => 'Красноглазая квакша'],
            [
                'class' => 'амфибии',
                'habitat' => 'Влажный вертикальный террариум с растениями и чистой водой.',
                'description' => "Яркая древесная амфибия, требующая высокой влажности и аккуратного обращения.\nНе рекомендуется часто брать животное в руки.",
                'care_level' => 'intermediate',
                'temp_min' => 24,
                'temp_max' => 28,
                'humidity_min' => 70,
                'humidity_max' => 90,
                'quarantine_days' => 14,
            ]
        );

        $parrot = Species::updateOrCreate(
            ['name' => 'Сенегальский попугай'],
            [
                'class' => 'птицы',
                'habitat' => 'Просторная клетка с жердочками, игрушками и ежедневным выгулом.',
                'description' => "Социальная птица с развитым интеллектом.\nНуждается в общении, разнообразном рационе и регулярной уборке клетки.",
                'care_level' => 'intermediate',
                'temp_min' => 20,
                'temp_max' => 26,
                'humidity_min' => 40,
                'humidity_max' => 60,
                'quarantine_days' => 30,
            ]
        );

        $mantis = Species::updateOrCreate(
            ['name' => 'Орхидейный богомол'],
            [
                'class' => 'насекомые',
                'habitat' => 'Небольшой инсектарий с ветками, вентиляцией и стабильной влажностью.',
                'description' => "Декоративное насекомое с эффектной окраской.\nТребует живого корма и аккуратного контроля влажности.",
                'care_level' => 'intermediate',
                'temp_min' => 24,
                'temp_max' => 28,
                'humidity_min' => 60,
                'humidity_max' => 80,
                'quarantine_days' => 7,
            ]
        );

        /* поставщики */

        $supplierZooImport = Supplier::updateOrCreate(
            ['email' => 'import@exozoo.ru'],
            [
                'name' => 'ExoZoo Import',
                'contact_person' => 'Марина Орлова',
                'phone' => '+7 495 111-22-33',
                'license_number' => 'LIC-EXO-2026-001',
            ]
        );

        $supplierTerrarium = Supplier::updateOrCreate(
            ['email' => 'sales@terrarium-pro.ru'],
            [
                'name' => 'Terrarium Pro',
                'contact_person' => 'Алексей Смирнов',
                'phone' => '+7 495 222-44-55',
                'license_number' => 'LIC-TER-2026-014',
            ]
        );

        /* сотрудник-продавец */

        $seller = Employee::updateOrCreate(
            ['full_name' => 'Ольга Кузнецова'],
            [
                'role' => 'продавец',
                'phone' => '+7 900 555-10-20',
                'hire_date' => '2025-09-01',
            ]
        );

        /* пользователь-клиент и запись в clients */

        $clientUser = User::updateOrCreate(
            ['email' => 'client@exoticpets.ru'],
            [
                'name' => 'Иван Петров',
                'password' => bcrypt('client123'),
                'role' => 'клиент',
            ]
        );

        $client = Client::updateOrCreate(
            ['email' => 'client@exoticpets.ru'],
            [
                'user_id' => $clientUser->id,
                'full_name' => 'Иван Петров',
                'phone' => '+7 900 123-45-67',
                'passport_data' => '4512 345678',
                'registration_date' => now()->subMonths(2)->toDateString(),
            ]
        );

        /* животные */

        $animals = [];

        $animals['python_sold'] = Animal::updateOrCreate(
            ['nickname' => 'Нуар'],
            [
                'species_id' => $python->species_id,
                'supplier_id' => $supplierZooImport->supplier_id,
                'sex' => 'самец',
                'birth_date' => now()->subMonths(18)->toDateString(),
                'arrival_date' => now()->subMonths(4)->toDateString(),
                'status' => 'продано',
                'purchase_price' => 18000,
                'sale_price' => 32000,
                'cites_certificate' => 'CITES-PY-2401',
                'photo_url' => null,
            ]
        );

        $animals['gecko_sold'] = Animal::updateOrCreate(
            ['nickname' => 'Манго'],
            [
                'species_id' => $gecko->species_id,
                'supplier_id' => $supplierTerrarium->supplier_id,
                'sex' => 'самка',
                'birth_date' => now()->subMonths(10)->toDateString(),
                'arrival_date' => now()->subMonths(3)->toDateString(),
                'status' => 'продано',
                'purchase_price' => 6500,
                'sale_price' => 12500,
                'cites_certificate' => null,
                'photo_url' => null,
            ]
        );

        $animals['chameleon_sold'] = Animal::updateOrCreate(
            ['nickname' => 'Оливер'],
            [
                'species_id' => $chameleon->species_id,
                'supplier_id' => $supplierZooImport->supplier_id,
                'sex' => 'самец',
                'birth_date' => now()->subMonths(8)->toDateString(),
                'arrival_date' => now()->subMonths(2)->toDateString(),
                'status' => 'продано',
                'purchase_price' => 14000,
                'sale_price' => 26000,
                'cites_certificate' => 'CITES-CH-1108',
                'photo_url' => null,
            ]
        );

        $animals['python_sale'] = Animal::updateOrCreate(
            ['nickname' => 'Сапфир'],
            [
                'species_id' => $python->species_id,
                'supplier_id' => $supplierZooImport->supplier_id,
                'sex' => 'самка',
                'birth_date' => now()->subMonths(14)->toDateString(),
                'arrival_date' => now()->subDays(35)->toDateString(),
                'status' => 'на продажу',
                'purchase_price' => 21000,
                'sale_price' => 36500,
                'cites_certificate' => 'CITES-PY-2455',
                'photo_url' => null,
            ]
        );

        $animals['gecko_sale'] = Animal::updateOrCreate(
            ['nickname' => 'Лимон'],
            [
                'species_id' => $gecko->species_id,
                'supplier_id' => $supplierTerrarium->supplier_id,
                'sex' => 'самец',
                'birth_date' => now()->subMonths(7)->toDateString(),
                'arrival_date' => now()->subDays(25)->toDateString(),
                'status' => 'на продажу',
                'purchase_price' => 7000,
                'sale_price' => 13800,
                'cites_certificate' => null,
                'photo_url' => null,
            ]
        );

        $animals['frog_sale'] = Animal::updateOrCreate(
            ['nickname' => 'Руби'],
            [
                'species_id' => $frog->species_id,
                'supplier_id' => $supplierTerrarium->supplier_id,
                'sex' => 'самка',
                'birth_date' => now()->subMonths(6)->toDateString(),
                'arrival_date' => now()->subDays(22)->toDateString(),
                'status' => 'на продажу',
                'purchase_price' => 8500,
                'sale_price' => 16900,
                'cites_certificate' => null,
                'photo_url' => null,
            ]
        );

        $animals['parrot_sale'] = Animal::updateOrCreate(
            ['nickname' => 'Киви'],
            [
                'species_id' => $parrot->species_id,
                'supplier_id' => $supplierZooImport->supplier_id,
                'sex' => 'самец',
                'birth_date' => now()->subMonths(15)->toDateString(),
                'arrival_date' => now()->subDays(45)->toDateString(),
                'status' => 'на продажу',
                'purchase_price' => 42000,
                'sale_price' => 69000,
                'cites_certificate' => 'CITES-BR-9012',
                'photo_url' => null,
            ]
        );

        $animals['mantis_sale'] = Animal::updateOrCreate(
            ['nickname' => 'Флора'],
            [
                'species_id' => $mantis->species_id,
                'supplier_id' => $supplierTerrarium->supplier_id,
                'sex' => 'самка',
                'birth_date' => now()->subMonths(3)->toDateString(),
                'arrival_date' => now()->subDays(12)->toDateString(),
                'status' => 'на продажу',
                'purchase_price' => 2200,
                'sale_price' => 4900,
                'cites_certificate' => null,
                'photo_url' => null,
            ]
        );

        $animals['chameleon_quarantine'] = Animal::updateOrCreate(
            ['nickname' => 'Изумруд'],
            [
                'species_id' => $chameleon->species_id,
                'supplier_id' => $supplierZooImport->supplier_id,
                'sex' => 'самка',
                'birth_date' => now()->subMonths(5)->toDateString(),
                'arrival_date' => now()->subDays(5)->toDateString(),
                'status' => 'карантин',
                'purchase_price' => 13500,
                'sale_price' => 25500,
                'cites_certificate' => 'CITES-CH-1180',
                'photo_url' => null,
            ]
        );

        /* покупки тестового клиента */

        Sale::updateOrCreate(
            ['contract_number' => 'DOG-2026-001'],
            [
                'animal_id' => $animals['python_sold']->animal_id,
                'client_id' => $client->client_id,
                'employee_id' => $seller->employee_id,
                'sale_date' => now()->subDays(40)->toDateString(),
                'total_price' => 32000,
                'payment_method' => 'карта',
            ]
        );

        Sale::updateOrCreate(
            ['contract_number' => 'DOG-2026-002'],
            [
                'animal_id' => $animals['gecko_sold']->animal_id,
                'client_id' => $client->client_id,
                'employee_id' => $seller->employee_id,
                'sale_date' => now()->subDays(24)->toDateString(),
                'total_price' => 12500,
                'payment_method' => 'наличные',
            ]
        );

        Sale::updateOrCreate(
            ['contract_number' => 'DOG-2026-003'],
            [
                'animal_id' => $animals['chameleon_sold']->animal_id,
                'client_id' => $client->client_id,
                'employee_id' => $seller->employee_id,
                'sale_date' => now()->subDays(9)->toDateString(),
                'total_price' => 26000,
                'payment_method' => 'перевод',
            ]
        );
    }
}