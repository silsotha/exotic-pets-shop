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
        Schema::create('feeding_log', function (Blueprint $table) {
            $table->increments('log_id');
            $table->unsignedInteger('animal_id');
            $table->unsignedInteger('feed_id')->nullable();
            $table->unsignedInteger('employee_id')->nullable();
            $table->date('feeding_date');
            $table->decimal('quantity', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->foreign('animal_id')->references('animal_id')->on('animals')->cascadeOnDelete();
            $table->foreign('feed_id')->references('feed_id')->on('feed')->nullOnDelete();
            $table->foreign('employee_id')->references('employee_id')->on('employees')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_log');
    }
};
