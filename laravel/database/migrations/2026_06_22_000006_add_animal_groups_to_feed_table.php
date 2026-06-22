<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feed', function (Blueprint $table) {
            $table->json('animal_groups')->nullable()->after('animal_classes');
        });
    }

    public function down(): void
    {
        Schema::table('feed', function (Blueprint $table) {
            $table->dropColumn('animal_groups');
        });
    }
};
