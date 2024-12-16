<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('fuel_prices', function (Blueprint $table) {
            $table->id(); // auto-incrementing id column
            $table->float('selling_price');
            $table->float('buying_price');
            $table->unsignedBigInteger('fuel_type_id'); // foreign key column
            $table->unsignedBigInteger('petrol_pump_id'); // foreign key column
            $table->date('date'); // date column
            $table->timestamps(); // created_at and updated_at columns

            // Foreign Key Constraints
            $table->foreign('fuel_type_id')->references('id')->on('fuel_types')->onDelete('cascade');
            $table->foreign('petrol_pump_id')->references('id')->on('petrol_pumps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_prices');
    }
};
