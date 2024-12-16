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
        Schema::create('fuel_purchases', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('petrol_pump_id'); // Foreign key to petrol_pumps
            $table->unsignedBigInteger('fuel_type_id');   // Foreign key to fuel_types
            $table->float('quantity_ltr');                // Quantity in liters
            $table->float('buying_price_per_ltr');        // Buying price per liter
            $table->date('purchase_date');                // Date of purchase
            $table->timestamps();                         // Created at and Updated at timestamps

            // Foreign key constraints
            $table->foreign('petrol_pump_id')
                  ->references('id')
                  ->on('petrol_pumps')
                  ->onDelete('cascade'); // Delete purchases when the petrol pump is deleted

            $table->foreign('fuel_type_id')
                  ->references('id')
                  ->on('fuel_types')
                  ->onDelete('cascade'); // Delete purchases when the fuel type is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_purchases');
    }
};
