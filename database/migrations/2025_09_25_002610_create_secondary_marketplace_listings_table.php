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
        Schema::create('secondary_marketplace_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crowdfunding_investment_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->integer('shares_on_sale');
            $table->decimal('price_per_share', 10, 2);
            $table->string('status')->default('active'); // active, sold, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secondary_marketplace_listings');
    }
};
