<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pour SQLite, on doit recréer la table avec le nouvel ENUM
        Schema::table('crowdfunding_projects', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('crowdfunding_projects', function (Blueprint $table) {
            $table->enum('status', ['draft', 'pending', 'active', 'rejected', 'funded', 'cancelled', 'completed'])->default('draft');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revenir à l'ENUM original
        Schema::table('crowdfunding_projects', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('crowdfunding_projects', function (Blueprint $table) {
            $table->enum('status', ['draft', 'active', 'funded', 'cancelled', 'completed'])->default('draft');
        });
    }
};