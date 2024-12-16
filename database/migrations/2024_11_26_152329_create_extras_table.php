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
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->decimal('daily_expense', 10, 2)->nullable()->comment('Daily expense amount');
            $table->text('expense_detail')->nullable()->comment('Details of the expense');
            $table->decimal('pump_rent', 16, 2)->nullable()->comment('Rent amount for the pump');
            $table->decimal('bank_deposit', 16, 2)->nullable()->comment('Amount deposited in the bank');
            $table->decimal('cash_in_hand', 16, 2)->nullable()->comment('Amount Stay in Hand');
            $table->string('account_number')->nullable()->comment('Bank account number');
            $table->date('date')->comment('Date for the record');
            $table->unsignedBigInteger('petrol_pump_id')->comment('Foreign key referencing petrol_pumps table');
            $table->timestamps();
                 
            $table->foreign('petrol_pump_id')->references('id')->on('petrol_pumps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
