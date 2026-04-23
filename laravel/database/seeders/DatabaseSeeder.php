<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SpeciesSeeder::class,
            SupplierSeeder::class,
            FeedSeeder::class,
        ]);
        // удаляем старого и создаём заново
        \App\Models\User::where('email', 'admin@exoticpets.ru')->delete();

        \App\Models\User::create([
            'name' => 'Администратор',
            'email' => 'admin@exoticpets.ru',
            'password' => bcrypt('admin123'),
            'role' => 'администратор',
        ]);
    }
}