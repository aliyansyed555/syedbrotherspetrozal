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
        Schema::table('tank_stocks', function (Blueprint $table) {
            $table->dropColumn('reading_in_mm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tank_stocks', function (Blueprint $table) {
            $table->decimal('reading_in_mm', 11, 2);
        });
    }
};
