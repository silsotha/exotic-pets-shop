<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SpeciesSeeder::class,
            SupplierSeeder::class,
            FeedSeeder::class,
            DemoSeeder::class,
        ]);

        User::updateOrCreate(
            ['email' => 'admin@exoticpets.ru'],
            [
                'name' => 'Администратор',
                'password' => bcrypt('admin123'),
                'role' => 'администратор',
            ]
        );

        $clientUser = User::updateOrCreate(
            ['email' => 'client@exoticpets.ru'],
            [
                'name' => 'Иван Петров',
                'password' => bcrypt('client123'),
                'role' => 'клиент',
            ]
        );

        Client::updateOrCreate(
            ['email' => 'client@exoticpets.ru'],
            [
                'user_id' => $clientUser->id,
                'full_name' => 'Иван Петров',
                'phone' => '+7 900 123-45-67',
                'passport_data' => 'тестовые данные',
                'registration_date' => now()->toDateString(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'vet@exoticpets.ru'],
            [
                'name' => 'Ветеринар',
                'password' => bcrypt('vet123'),
                'role' => 'ветврач',
            ]
        );

        Employee::updateOrCreate(
            ['full_name' => 'Анна Власова'],
            [
                'role' => 'ветврач',
                'phone' => '+7 900 777-22-33',
                'hire_date' => now()->subYear()->toDateString(),
            ]
        );
    }
}