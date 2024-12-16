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
        Schema::create('tank_stocks', function (Blueprint $table) {
            $table->id();
            $table->decimal('reading_in_mm', 11, 2);
            $table->decimal('reading_in_ltr', 11, 2);
            $table->unsignedBigInteger('tank_id');
            $table->date('date');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('tank_id')->references('id')->on('tanks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tank_stocks');
    }
};
