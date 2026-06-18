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
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        // сотрудники

        $employeesData = [
            [
                'email' => 'seller1@exopets.ru',
                'password' => 'seller123',
                'full_name' => 'Ольга Кузнецова',
                'role' => 'продавец',
                'phone' => '+7 900 555-10-20',
                'hire_date' => '2025-09-01',
            ],
            [
                'email' => 'seller2@exopets.ru',
                'password' => 'seller123',
                'full_name' => 'Дмитрий Соколов',
                'role' => 'продавец',
                'phone' => '+7 900 555-10-21',
                'hire_date' => '2025-10-15',
            ],
            [
                'email' => 'seller3@exopets.ru',
                'password' => 'seller123',
                'full_name' => 'Алина Романова',
                'role' => 'продавец',
                'phone' => '+7 900 555-10-22',
                'hire_date' => '2026-01-12',
            ],
            [
                'email' => 'vet1@exopets.ru',
                'password' => 'vet123',
                'full_name' => 'Анна Власова',
                'role' => 'ветврач',
                'phone' => '+7 900 777-22-33',
                'hire_date' => '2024-11-20',
            ],
            [
                'email' => 'vet2@exopets.ru',
                'password' => 'vet123',
                'full_name' => 'Игорь Павлов',
                'role' => 'ветврач',
                'phone' => '+7 900 777-22-34',
                'hire_date' => '2025-03-18',
            ],
            [
                'email' => 'vet3@exopets.ru',
                'password' => 'vet123',
                'full_name' => 'Наталья Белова',
                'role' => 'ветврач',
                'phone' => '+7 900 777-22-35',
                'hire_date' => '2025-08-05',
            ],
        ];

        $employees = [];

        foreach ($employeesData as $item) {
            $employee = Employee::updateOrCreate(
                ['full_name' => $item['full_name']],
                [
                    'role' => $item['role'],
                    'phone' => $item['phone'],
                    'hire_date' => $item['hire_date'],
                ]
            );

            $employees[$item['email']] = $employee;

            User::updateOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['full_name'],
                    'password' => Hash::make($item['password']),
                    'role' => $item['role'],
                    'employee_id' => $employee->employee_id,
                ]
            );
        }

        User::updateOrCreate(
            ['email' => 'admin@exopets.ru'],
            [
                'name' => 'Администратор EXO PETS',
                'password' => Hash::make('admin123'),
                'role' => 'администратор',
                'employee_id' => null,
            ]
        );

        // поставщики

        $suppliers = [];

        $suppliers['exo_import'] = Supplier::updateOrCreate(
            ['email' => 'import@exozoo.ru'],
            [
                'name' => 'ExoZoo Import',
                'contact_person' => 'Марина Орлова',
                'phone' => '+7 495 111-22-33',
                'license_number' => 'LIC-EXO-2026-001',
            ]
        );

        $suppliers['terrarium_pro'] = Supplier::updateOrCreate(
            ['email' => 'sales@terrarium-pro.ru'],
            [
                'name' => 'Terrarium Pro',
                'contact_person' => 'Алексей Смирнов',
                'phone' => '+7 495 222-44-55',
                'license_number' => 'LIC-TER-2026-014',
            ]
        );

        $suppliers['aqua_exotic'] = Supplier::updateOrCreate(
            ['email' => 'order@aqua-exotic.ru'],
            [
                'name' => 'Aqua Exotic',
                'contact_person' => 'Елена Морозова',
                'phone' => '+7 495 333-66-77',
                'license_number' => 'LIC-AQUA-2026-021',
            ]
        );

        // виды животных

        $speciesData = [
            [
                'name' => 'Королевский питон',
                'class' => 'рептилии',
                'habitat' => 'Сухой террариум с укрытиями, поилкой и тёплой зоной.',
                'description' => "Спокойная неядовитая змея, часто подходит начинающим владельцам.\nВажно поддерживать стабильную температуру и не тревожить животное во время линьки.",
                'care_level' => 'beginner',
                'temp_min' => 26,
                'temp_max' => 32,
                'humidity_min' => 50,
                'humidity_max' => 65,
                'quarantine_days' => 14,
            ],
            [
                'name' => 'Эублефар',
                'class' => 'рептилии',
                'habitat' => 'Горизонтальный террариум с сухой и влажной зонами.',
                'description' => "Небольшая ящерица с относительно простым уходом.\nНуждается в укрытиях, кальциевых добавках и контроле температуры.",
                'care_level' => 'beginner',
                'temp_min' => 24,
                'temp_max' => 31,
                'humidity_min' => 35,
                'humidity_max' => 50,
                'quarantine_days' => 10,
            ],
            [
                'name' => 'Йеменский хамелеон',
                'class' => 'рептилии',
                'habitat' => 'Вертикальный террариум с ветками, живыми растениями и вентиляцией.',
                'description' => "Требовательный вид, чувствительный к влажности, температуре и стрессу.\nПодходит владельцам с опытом содержания рептилий.",
                'care_level' => 'advanced',
                'temp_min' => 24,
                'temp_max' => 30,
                'humidity_min' => 50,
                'humidity_max' => 70,
                'quarantine_days' => 21,
            ],
            [
                'name' => 'Пантеровый хамелеон',
                'class' => 'рептилии',
                'habitat' => 'Вертикальный террариум с большим количеством ветвей и хорошей вентиляцией.',
                'description' => "Яркий древесный хамелеон, требующий стабильных условий содержания.\nНуждается в УФ-освещении, живом корме и контроле влажности.",
                'care_level' => 'advanced',
                'temp_min' => 24,
                'temp_max' => 32,
                'humidity_min' => 60,
                'humidity_max' => 80,
                'quarantine_days' => 30,
            ],
            [
                'name' => 'Красноглазая квакша',
                'class' => 'амфибии',
                'habitat' => 'Влажный вертикальный террариум с растениями и чистой водой.',
                'description' => "Яркая древесная амфибия, требующая высокой влажности и аккуратного обращения.\nНе рекомендуется часто брать животное в руки.",
                'care_level' => 'intermediate',
                'temp_min' => 24,
                'temp_max' => 28,
                'humidity_min' => 70,
                'humidity_max' => 90,
                'quarantine_days' => 14,
            ],
            [
                'name' => 'Аксолотль',
                'class' => 'амфибии',
                'habitat' => 'Аквариум с прохладной чистой водой, фильтрацией и укрытиями.',
                'description' => "Водная амфибия с необычной внешностью.\nОсобенно чувствительна к качеству воды и перегреву.",
                'care_level' => 'intermediate',
                'temp_min' => 14,
                'temp_max' => 20,
                'humidity_min' => 80,
                'humidity_max' => 100,
                'quarantine_days' => 21,
            ],
            [
                'name' => 'Сенегальский попугай',
                'class' => 'птицы',
                'habitat' => 'Просторная клетка с жердочками, игрушками и ежедневным выгулом.',
                'description' => "Социальная птица с развитым интеллектом.\nНуждается в общении, разнообразном рационе и регулярной уборке клетки.",
                'care_level' => 'intermediate',
                'temp_min' => 20,
                'temp_max' => 26,
                'humidity_min' => 40,
                'humidity_max' => 60,
                'quarantine_days' => 30,
            ],
            [
                'name' => 'Гиацинтовый ара',
                'class' => 'птицы',
                'habitat' => 'Крупный вольер или просторная клетка, ежедневная активность и общение.',
                'description' => "Крупный попугай с высоким интеллектом и сильной привязанностью к владельцу.\nТребует опыта, времени и продуманного рациона.",
                'care_level' => 'advanced',
                'temp_min' => 20,
                'temp_max' => 28,
                'humidity_min' => 50,
                'humidity_max' => 70,
                'quarantine_days' => 30,
            ],
            [
                'name' => 'Сахарный поссум',
                'class' => 'млекопитающие',
                'habitat' => 'Высокая клетка с ветками, домиками, гамаками и ночной активностью.',
                'description' => "Ночное социальное животное, которому нужна компания и регулярное общение.\nТребует сбалансированного питания и аккуратного приручения.",
                'care_level' => 'advanced',
                'temp_min' => 18,
                'temp_max' => 26,
                'humidity_min' => 40,
                'humidity_max' => 60,
                'quarantine_days' => 14,
            ],
            [
                'name' => 'Орхидейный богомол',
                'class' => 'насекомые',
                'habitat' => 'Небольшой инсектарий с ветками, вентиляцией и стабильной влажностью.',
                'description' => "Декоративное насекомое с эффектной окраской.\nТребует живого корма и аккуратного контроля влажности.",
                'care_level' => 'intermediate',
                'temp_min' => 24,
                'temp_max' => 28,
                'humidity_min' => 60,
                'humidity_max' => 80,
                'quarantine_days' => 7,
            ],
        ];

        $species = [];

        foreach ($speciesData as $item) {
            $species[$item['name']] = Species::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }

        // животные

        $animalsData = [
            [
                'key' => 'python_sold_1',
                'nickname' => 'Нуар',
                'species' => 'Королевский питон',
                'supplier' => 'exo_import',
                'sex' => 'самец',
                'birth_months' => 18,
                'arrival_days' => 120,
                'status' => 'продано',
                'purchase_price' => 18000,
                'sale_price' => 32000,
                'cites_certificate' => 'CITES-PY-2401',
            ],
            [
                'key' => 'gecko_sold_1',
                'nickname' => 'Манго',
                'species' => 'Эублефар',
                'supplier' => 'terrarium_pro',
                'sex' => 'самка',
                'birth_months' => 10,
                'arrival_days' => 90,
                'status' => 'продано',
                'purchase_price' => 6500,
                'sale_price' => 12500,
                'cites_certificate' => null,
            ],
            [
                'key' => 'chameleon_sold_1',
                'nickname' => 'Оливер',
                'species' => 'Йеменский хамелеон',
                'supplier' => 'exo_import',
                'sex' => 'самец',
                'birth_months' => 8,
                'arrival_days' => 70,
                'status' => 'продано',
                'purchase_price' => 14000,
                'sale_price' => 26000,
                'cites_certificate' => 'CITES-CH-1108',
            ],
            [
                'key' => 'axolotl_sold_1',
                'nickname' => 'Пиксель',
                'species' => 'Аксолотль',
                'supplier' => 'aqua_exotic',
                'sex' => 'самец',
                'birth_months' => 9,
                'arrival_days' => 60,
                'status' => 'продано',
                'purchase_price' => 5200,
                'sale_price' => 9800,
                'cites_certificate' => null,
            ],
            [
                'key' => 'python_sale_1',
                'nickname' => 'Сапфир',
                'species' => 'Королевский питон',
                'supplier' => 'exo_import',
                'sex' => 'самка',
                'birth_months' => 14,
                'arrival_days' => 35,
                'status' => 'на продажу',
                'purchase_price' => 21000,
                'sale_price' => 36500,
                'cites_certificate' => 'CITES-PY-2455',
            ],
            [
                'key' => 'gecko_sale_1',
                'nickname' => 'Лимон',
                'species' => 'Эублефар',
                'supplier' => 'terrarium_pro',
                'sex' => 'самец',
                'birth_months' => 7,
                'arrival_days' => 25,
                'status' => 'на продажу',
                'purchase_price' => 7000,
                'sale_price' => 13800,
                'cites_certificate' => null,
            ],
            [
                'key' => 'frog_sale_1',
                'nickname' => 'Руби',
                'species' => 'Красноглазая квакша',
                'supplier' => 'terrarium_pro',
                'sex' => 'самка',
                'birth_months' => 6,
                'arrival_days' => 22,
                'status' => 'на продажу',
                'purchase_price' => 8500,
                'sale_price' => 16900,
                'cites_certificate' => null,
            ],
            [
                'key' => 'parrot_sale_1',
                'nickname' => 'Киви',
                'species' => 'Сенегальский попугай',
                'supplier' => 'exo_import',
                'sex' => 'самец',
                'birth_months' => 15,
                'arrival_days' => 45,
                'status' => 'на продажу',
                'purchase_price' => 42000,
                'sale_price' => 69000,
                'cites_certificate' => 'CITES-BR-9012',
            ],
            [
                'key' => 'ara_sale_1',
                'nickname' => 'Лазурь',
                'species' => 'Гиацинтовый ара',
                'supplier' => 'exo_import',
                'sex' => 'самка',
                'birth_months' => 22,
                'arrival_days' => 50,
                'status' => 'на продажу',
                'purchase_price' => 180000,
                'sale_price' => 260000,
                'cites_certificate' => 'CITES-ARA-7781',
            ],
            [
                'key' => 'possum_sale_1',
                'nickname' => 'Ночка',
                'species' => 'Сахарный поссум',
                'supplier' => 'terrarium_pro',
                'sex' => 'самка',
                'birth_months' => 5,
                'arrival_days' => 18,
                'status' => 'на продажу',
                'purchase_price' => 16000,
                'sale_price' => 29500,
                'cites_certificate' => null,
            ],
            [
                'key' => 'mantis_sale_1',
                'nickname' => 'Флора',
                'species' => 'Орхидейный богомол',
                'supplier' => 'terrarium_pro',
                'sex' => 'самка',
                'birth_months' => 3,
                'arrival_days' => 12,
                'status' => 'на продажу',
                'purchase_price' => 2200,
                'sale_price' => 4900,
                'cites_certificate' => null,
            ],
            [
                'key' => 'panther_quarantine_1',
                'nickname' => 'Спектр',
                'species' => 'Пантеровый хамелеон',
                'supplier' => 'exo_import',
                'sex' => 'самец',
                'birth_months' => 6,
                'arrival_days' => 6,
                'status' => 'карантин',
                'purchase_price' => 24000,
                'sale_price' => 41000,
                'cites_certificate' => 'CITES-PCH-2026',
            ],
            [
                'key' => 'axolotl_quarantine_1',
                'nickname' => 'Лотос',
                'species' => 'Аксолотль',
                'supplier' => 'aqua_exotic',
                'sex' => 'самка',
                'birth_months' => 4,
                'arrival_days' => 4,
                'status' => 'карантин',
                'purchase_price' => 4800,
                'sale_price' => 9200,
                'cites_certificate' => null,
            ],
        ];

        $animals = [];

        foreach ($animalsData as $item) {
            $animals[$item['key']] = Animal::updateOrCreate(
                ['nickname' => $item['nickname']],
                [
                    'species_id' => $species[$item['species']]->species_id,
                    'supplier_id' => $suppliers[$item['supplier']]->supplier_id,
                    'sex' => $item['sex'],
                    'birth_date' => now()->subMonths($item['birth_months'])->toDateString(),
                    'arrival_date' => now()->subDays($item['arrival_days'])->toDateString(),
                    'status' => $item['status'],
                    'purchase_price' => $item['purchase_price'],
                    'sale_price' => $item['sale_price'],
                    'cites_certificate' => $item['cites_certificate'],
                    'photo_url' => null,
                ]
            );
        }

        // клиенты

        $clientsData = [
            [
                'email' => 'client1@exopets.ru',
                'password' => 'client123',
                'full_name' => 'Иван Петров',
                'phone' => '+7 900 123-45-67',
                'passport_data' => '4512 345678',
                'registered' => now()->subMonths(2)->toDateString(),
            ],
            [
                'email' => 'client2@exopets.ru',
                'password' => 'client123',
                'full_name' => 'Артём Крылов',
                'phone' => '+7 900 222-33-44',
                'passport_data' => '4520 112233',
                'registered' => now()->subMonths(1)->toDateString(),
            ],
            [
                'email' => 'client3@exopets.ru',
                'password' => 'client123',
                'full_name' => 'Мария Лебедева',
                'phone' => '+7 900 333-44-55',
                'passport_data' => '4530 223344',
                'registered' => now()->subDays(18)->toDateString(),
            ],
        ];

        $clients = [];

        foreach ($clientsData as $item) {
            $user = User::updateOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['full_name'],
                    'password' => Hash::make($item['password']),
                    'role' => 'клиент',
                    'employee_id' => null,
                ]
            );

            $clients[$item['email']] = Client::updateOrCreate(
                ['email' => $item['email']],
                [
                    'user_id' => $user->id,
                    'full_name' => $item['full_name'],
                    'phone' => $item['phone'],
                    'passport_data' => $item['passport_data'],
                    'registration_date' => $item['registered'],
                ]
            );
        }

        // продажи

        $salesData = [
            [
                'contract_number' => 'DOG-2026-001',
                'animal' => 'python_sold_1',
                'client' => 'client1@exopets.ru',
                'employee' => 'seller1@exopets.ru',
                'sale_days_ago' => 40,
                'total_price' => 32000,
                'payment_method' => 'карта',
            ],
            [
                'contract_number' => 'DOG-2026-002',
                'animal' => 'gecko_sold_1',
                'client' => 'client1@exopets.ru',
                'employee' => 'seller1@exopets.ru',
                'sale_days_ago' => 24,
                'total_price' => 12500,
                'payment_method' => 'наличные',
            ],
            [
                'contract_number' => 'DOG-2026-003',
                'animal' => 'chameleon_sold_1',
                'client' => 'client2@exopets.ru',
                'employee' => 'seller2@exopets.ru',
                'sale_days_ago' => 12,
                'total_price' => 26000,
                'payment_method' => 'перевод',
            ],
            [
                'contract_number' => 'DOG-2026-004',
                'animal' => 'axolotl_sold_1',
                'client' => 'client3@exopets.ru',
                'employee' => 'seller3@exopets.ru',
                'sale_days_ago' => 5,
                'total_price' => 9800,
                'payment_method' => 'карта',
            ],
        ];

        foreach ($salesData as $item) {
            Sale::updateOrCreate(
                ['contract_number' => $item['contract_number']],
                [
                    'animal_id' => $animals[$item['animal']]->animal_id,
                    'client_id' => $clients[$item['client']]->client_id,
                    'employee_id' => $employees[$item['employee']]->employee_id,
                    'sale_date' => now()->subDays($item['sale_days_ago'])->toDateString(),
                    'total_price' => $item['total_price'],
                    'payment_method' => $item['payment_method'],
                ]
            );

            $animals[$item['animal']]->update([
                'status' => 'продано',
            ]);
        }
    }
}