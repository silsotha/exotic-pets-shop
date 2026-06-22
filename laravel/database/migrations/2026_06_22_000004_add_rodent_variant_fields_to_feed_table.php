<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feed', function (Blueprint $table) {
            $table->string('rodent_stage', 30)
                ->nullable()
                ->after('feed_type');

            $table->unsignedSmallInteger('prey_weight_min')
                ->nullable()
                ->after('rodent_stage');

            $table->unsignedSmallInteger('prey_weight_max')
                ->nullable()
                ->after('prey_weight_min');
        });
    }

    public function down(): void
    {
        Schema::table('feed', function (Blueprint $table) {
            $table->dropColumn([
                'rodent_stage',
                'prey_weight_min',
                'prey_weight_max',
            ]);
        });
    }
};
