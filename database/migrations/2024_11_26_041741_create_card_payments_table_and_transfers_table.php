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
        Schema::create('card_payments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('card_number');
            $table->float('amount'); // Card payment amount
            $table->enum('card_type', ['PSO', 'Other']); // Card type
            $table->unsignedBigInteger('petrol_pump_id'); // Foreign key to petrol_pumps
            $table->date('date'); // Payment date
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraint
            $table->foreign('petrol_pump_id')->references('id')->on('petrol_pumps')->onDelete('cascade');
        });

        Schema::create('card_payments_transfers', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->float('amount'); // Transferred amount
            $table->string('account_number'); // Account number to which amount is transferred
            $table->unsignedBigInteger('petrol_pump_id'); // Foreign key to petrol_pumps
            $table->date('date'); // Transfer date
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraint
            $table->foreign('petrol_pump_id')->references('id')->on('petrol_pumps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_payments');
        Schema::dropIfExists('card_payments_transfers');
    }
};
