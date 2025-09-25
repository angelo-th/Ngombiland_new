<?php

// database/migrations/2025_08_28_000001_create_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('wallet_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type'); // 'top-up', 'withdrawal', 'purchase', 'rental_income', etc.
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->string('reference')->nullable();
            $table->string('provider')->nullable(); // MTN, Orange, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
