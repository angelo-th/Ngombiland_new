<?php
// database/migrations/2025_08_28_000001_create_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // 'top-up', 'withdrawal', 'purchase'
            $table->decimal('amount', 15, 2);
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->string('reference')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
Schema::create('transactions', function(Blueprint $table){
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('type'); // 'top-up', 'withdrawal', 'purchase'
    $table->decimal('amount',15,2);
    $table->string('status')->default('pending'); // pending, completed, failed
    $table->string('reference')->unique();
    $table->timestamps();
});
 // Transactions table
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['top-up','withdraw','purchase','commission']);
            $table->decimal('amount', 15, 2);
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->string('reference')->unique(); // Transaction reference
            $table->timestamps();
        });
        Schema::dropIfExists('transactions');