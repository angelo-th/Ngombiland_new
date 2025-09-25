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
        Schema::create('secondary_market_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('crowdfunding_investment_id')->constrained()->onDelete('cascade');
            $table->integer('shares_for_sale');
            $table->decimal('price_per_share', 10, 2);
            $table->decimal('total_price', 15, 2);
            $table->enum('status', ['active', 'sold', 'cancelled', 'expired'])->default('active');
            $table->text('description')->nullable();
            $table->timestamp('expires_at');
            $table->timestamp('sold_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secondary_market_listings');
    }
};
