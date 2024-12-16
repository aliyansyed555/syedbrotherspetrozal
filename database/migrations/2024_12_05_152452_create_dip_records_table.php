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
        Schema::create('dip_records', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->float('reading_in_mm'); // Reading in millimeters
            $table->float('reading_in_ltr'); // Reading in liters
            $table->date('date'); // Date of the record
            $table->unsignedBigInteger('tank_id'); // Foreign key to the tanks table
            $table->timestamps(); // created_at and updated_at columns

            // Foreign key constraint
            $table->foreign('tank_id')->references('id')->on('tanks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dip_records');
    }
};
