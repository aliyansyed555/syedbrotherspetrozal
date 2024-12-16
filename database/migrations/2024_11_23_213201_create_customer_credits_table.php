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
        Schema::create('customer_credits', function (Blueprint $table) {
            $table->id(); // auto-incrementing primary key
           
            $table->float('bill_amount')->default(0);
            $table->float('amount_paid')->default(0);
            $table->float('balance')->default(0);
            $table->string('remarks')->nullable(); 
            $table->date('date');
            $table->timestamps(); 

            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_credits');
    }
};
