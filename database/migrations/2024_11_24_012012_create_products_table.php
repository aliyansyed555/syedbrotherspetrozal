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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name');
            $table->string('company');
            $table->float('price');
            $table->timestamps(); // Includes created_at and updated_at
            $table->foreignId('petrol_pump_id')->constrained('petrol_pumps')->onDelete('cascade');
        });

        // Create 'product_inventory' table
        Schema::create('product_inventory', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('quantity');
            $table->date('date');
            $table->timestamps(); // Includes created_at and updated_at
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        });

        // Create 'product_sales' table
        Schema::create('product_sales', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->float('amount');
            $table->json('products'); // JSON column
            $table->date('date');
            $table->timestamps(); // Includes created_at and updated_at
            $table->foreignId('petrol_pump_id')->constrained('petrol_pumps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sales');
        Schema::dropIfExists('product_inventory');
        Schema::dropIfExists('products');
    }
};
