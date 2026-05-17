<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE users
            ALTER COLUMN role TYPE VARCHAR(30)
        ");

        DB::statement("
            ALTER TABLE users
            ALTER COLUMN role SET DEFAULT 'клиент'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE users
            ALTER COLUMN role SET DEFAULT 'продавец'
        ");
    }
};