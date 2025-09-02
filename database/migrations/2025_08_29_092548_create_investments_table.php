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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
Schema::create('investments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('property_id')->constrained()->onDelete('cascade');
    $table->decimal('amount',15,2);
    $table->timestamps();
});
$table->unique(['user_id','property_id']);
// database/migrations/2025_08_28_000002_create_investments_table.php

Schema::create('investments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('property_id')->constrained()->onDelete('cascade');
    $table->decimal('amount', 15, 2);
    $table->decimal('roi', 5, 2)->default(0); // ROI percentage
    $table->string('status')->default('active'); // active, completed
    $table->timestamps();
});
$table->unique(['user_id', 'property_id']);
{
    Schema::table('investments', function (Blueprint $table) {
        $table->dropUnique(['user_id', 'property_id']);
    });
}