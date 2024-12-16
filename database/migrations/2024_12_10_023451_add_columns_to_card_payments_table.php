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
        Schema::table('card_payments', function (Blueprint $table) {
            $table->string('account_number')->nullable()->after('card_type'); 
            $table->enum('transaction_type', ['deposit', 'withdrawal'])->default('deposit')->after('card_type');
            $table->text('remarks')->nullable()->after('card_type');
            $table->string('card_number')->nullable()->change();
            $table->string('card_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_payments', function (Blueprint $table) {
            $table->dropColumn(['account_number', 'transaction_type', 'remarks']);
        });
    }
};
