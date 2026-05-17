<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SpeciesSeeder::class,
            SupplierSeeder::class,
            FeedSeeder::class,
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
    }
}