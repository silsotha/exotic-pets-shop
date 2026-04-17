<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('species', function (Blueprint $table) {
            $table->increments('species_id');
            $table->string('name', 100);
            $table->string('class', 50)->nullable();
            $table->string('habitat', 200)->nullable();
            $table->float('temp_min')->nullable();
            $table->float('temp_max')->nullable();
            $table->float('humidity_min')->nullable();
            $table->float('humidity_max')->nullable();
            $table->integer('quarantine_days')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('species');
    }
};
