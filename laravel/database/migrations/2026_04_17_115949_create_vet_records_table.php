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
        Schema::create('vet_records', function (Blueprint $table) {
            $table->increments('record_id');
            $table->unsignedInteger('animal_id');
            $table->unsignedInteger('vet_id')->nullable();
            $table->date('record_date');
            $table->string('record_type', 20)->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->string('result', 20)->nullable();
            $table->foreign('animal_id')->references('animal_id')->on('animals')->cascadeOnDelete();
            $table->foreign('vet_id')->references('employee_id')->on('employees')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vet_records');
    }
};
