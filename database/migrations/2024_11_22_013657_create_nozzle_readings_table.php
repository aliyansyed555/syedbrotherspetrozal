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
        Schema::create('nozzle_readings', function (Blueprint $table) {
            $table->id();
            $table->decimal('analog_reading');
            $table->decimal('digital_reading');
            $table->unsignedBigInteger('nozzle_id');

            $table->date('date');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('nozzle_id')->references('id')->on('nozzles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nozzle_readings');
    }
};
