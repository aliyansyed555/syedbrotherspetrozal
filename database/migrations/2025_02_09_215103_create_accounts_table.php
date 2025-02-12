<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('account_type', ['current', 'saving', 'other']);
            $table->string('bank_name', 100);
            $table->string('person_name' , 100);
            $table->string('account_number', 50)->unique();
            $table->decimal('previous_cash', 14, 2);
            $table->timestamps();
        });

        Schema::create('bank_account_credits', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('amount', 14, 2);
            $table->string('remarks', 100)->nullable();
            $table->integer('revise_account_id'); #foreign key
            $table->enum('type', ['received' , 'transfer']);
            $table->text('details')->nullable()->comment('used as json OR array data to save like product sales.');

            $table->integer('bank_account_id'); #foreign key
            $table->timestamps();

            $table->foreignId('revise_account_id')->constrained('bank_accounts')->onDelete('cascade');
            $table->foreignId('bank_account_id')->constrained('bank_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('bank_account_credits');
    }
};
