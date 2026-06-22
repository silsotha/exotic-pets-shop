<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('feed_id');
            $table->unsignedInteger('employee_id')->nullable();
            $table->string('operation_type', 30);
            $table->integer('quantity_change');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('feed_id')->references('feed_id')->on('feed')->cascadeOnDelete();
            $table->foreign('employee_id')->references('employee_id')->on('employees')->nullOnDelete();
            $table->index(['feed_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_stock_movements');
    }
};
