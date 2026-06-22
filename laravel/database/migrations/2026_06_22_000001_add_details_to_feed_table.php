<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feed', function (Blueprint $table) {
            $table->text('description')->nullable()->after('feed_type');
            $table->text('purpose')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('feed', function (Blueprint $table) {
            $table->dropColumn(['description', 'purpose']);
        });
    }
};
