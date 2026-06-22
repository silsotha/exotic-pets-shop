<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_species', function (Blueprint $table) {
            $table->unsignedInteger('feed_id');
            $table->unsignedInteger('species_id');

            $table->primary(['feed_id', 'species_id']);

            $table->foreign('feed_id')
                ->references('feed_id')
                ->on('feed')
                ->cascadeOnDelete();

            $table->foreign('species_id')
                ->references('species_id')
                ->on('species')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_species');
    }
};
