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
        Schema::create('employee_wages', function (Blueprint $table) {
            $table->id();
            $table->float('amount_received');
            $table->unsignedBigInteger('employee_id');
            
            $table->date('date');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_wages');
    }
};
