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
        Schema::create('crowdfunding_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('total_amount', 15, 2); // Montant total à lever
            $table->decimal('amount_raised', 15, 2)->default(0); // Montant levé
            $table->integer('total_shares'); // Nombre total de parts
            $table->integer('shares_sold')->default(0); // Parts vendues
            $table->decimal('price_per_share', 10, 2); // Prix par part
            $table->decimal('expected_roi', 5, 2); // ROI attendu en %
            $table->date('funding_deadline'); // Date limite de levée
            $table->enum('status', ['draft', 'active', 'funded', 'cancelled', 'completed'])->default('draft');
            $table->json('images')->nullable(); // Images du projet
            $table->json('documents')->nullable(); // Documents légaux
            $table->text('risks')->nullable(); // Description des risques
            $table->text('benefits')->nullable(); // Avantages pour investisseurs
            $table->decimal('management_fee', 5, 2)->default(5.0); // Frais de gestion en %
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crowdfunding_projects');
    }
};
