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
        Schema::create('animals', function (Blueprint $table) {
            $table->increments('animal_id');
            $table->unsignedInteger('species_id')->nullable();
            $table->unsignedInteger('supplier_id')->nullable();
            $table->string('nickname', 50)->nullable();
            $table->string('sex', 10)->nullable();
            $table->date('birth_date')->nullable();
            $table->date('arrival_date')->nullable();
            $table->string('status', 20)->default('карантин');
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('cites_certificate', 50)->nullable();
            $table->string('photo_url', 500)->nullable();
            $table->foreign('species_id')->references('species_id')->on('species')->nullOnDelete();
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
