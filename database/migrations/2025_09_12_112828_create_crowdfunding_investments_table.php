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
        Schema::create('crowdfunding_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('crowdfunding_project_id')->constrained()->onDelete('cascade');
            $table->integer('shares_purchased'); // Nombre de parts achetées
            $table->decimal('amount_invested', 15, 2); // Montant investi
            $table->decimal('price_per_share', 10, 2); // Prix par part au moment de l'achat
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crowdfunding_investments');
    }
};
