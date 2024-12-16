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
        Schema::create('nozzles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('petrol_pump_id');
            $table->unsignedBigInteger('tank_id');
            $table->unsignedBigInteger('fuel_type_id');

            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('petrol_pump_id')->references('id')->on('petrol_pumps')->onDelete('cascade');
            $table->foreign('tank_id')->references('id')->on('tanks')->onDelete('cascade');
            $table->foreign('fuel_type_id')->references('id')->on('fuel_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nozzles');
    }
};
