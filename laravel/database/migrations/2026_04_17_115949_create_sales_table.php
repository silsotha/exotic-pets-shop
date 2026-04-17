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
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('sale_id');
            $table->unsignedInteger('animal_id');
            $table->unsignedInteger('client_id')->nullable();
            $table->unsignedInteger('employee_id')->nullable();
            $table->date('sale_date');
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('payment_method', 30)->nullable();
            $table->string('contract_number', 30)->nullable();
            $table->foreign('animal_id')->references('animal_id')->on('animals')->cascadeOnDelete();
            $table->foreign('client_id')->references('client_id')->on('clients')->nullOnDelete();
            $table->foreign('employee_id')->references('employee_id')->on('employees')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
