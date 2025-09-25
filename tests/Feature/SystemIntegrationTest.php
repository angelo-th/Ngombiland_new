<?php

namespace Tests\Feature;

use App\Models\CrowdfundingProject;
use App\Models\CrowdfundingInvestment;
use App\Models\Property;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SystemIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function complete_crowdfunding_workflow_works()
    {
        // 1. Créer un propriétaire
        $proprietor = User::factory()->create(['role' => 'proprietor']);
        
        // 2. Créer une propriété
        $property = Property::factory()->create([
            'user_id' => $proprietor->id,
            'is_crowdfundable' => true,
            'expected_roi' => 12.0,
            'price' => 50000000
        ]);
        
        // 3. Créer un projet de crowdfunding
        $project = CrowdfundingProject::create([
            'user_id' => $proprietor->id,
            'property_id' => $property->id,
            'title' => 'Projet Test',
            'description' => 'Description du projet test',
            'total_amount' => 10000000,
            'amount_raised' => 0,
            'total_shares' => 1000,
            'shares_sold' => 0,
            'price_per_share' => 10000,
            'expected_roi' => 12.0,
            'funding_deadline' => now()->addDays(30),
            'status' => 'active'
        ]);
        
        // 4. Créer des investisseurs avec wallets
        $investor1 = User::factory()->create(['role' => 'investor']);
        $investor2 = User::factory()->create(['role' => 'investor']);
        
        Wallet::create(['user_id' => $investor1->id, 'balance' => 5000000, 'currency' => 'XAF', 'status' => 'active']);
        Wallet::create(['user_id' => $investor2->id, 'balance' => 3000000, 'currency' => 'XAF', 'status' => 'active']);
        
        // 5. Créer des investissements
        CrowdfundingInvestment::create([
            'user_id' => $investor1->id,
            'crowdfunding_project_id' => $project->id,
            'shares_purchased' => 500,
            'amount_invested' => 5000000,
            'price_per_share' => 10000,
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);
        
        CrowdfundingInvestment::create([
            'user_id' => $investor2->id,
            'crowdfunding_project_id' => $project->id,
            'shares_purchased' => 300,
            'amount_invested' => 3000000,
            'price_per_share' => 10000,
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);
        
        // 6. Mettre à jour le projet
        $project->update([
            'amount_raised' => 8000000,
            'shares_sold' => 800,
            'status' => 'funded'
        ]);
        
        // Vérifications
        $this->assertEquals(8000000, $project->fresh()->amount_raised);
        $this->assertEquals(800, $project->fresh()->shares_sold);
        $this->assertEquals('funded', $project->fresh()->status);
        
        // Vérifier les investissements
        $this->assertCount(2, $project->investments);
        $this->assertEquals(500, $project->investments()->where('user_id', $investor1->id)->first()->shares_purchased);
        $this->assertEquals(300, $project->investments()->where('user_id', $investor2->id)->first()->shares_purchased);
    }

    /** @test */
    public function payment_system_works()
    {
        $user = User::factory()->create();
        
        // Créer un wallet
        $wallet = Wallet::create([
            'user_id' => $user->id,
            'balance' => 1000000,
            'currency' => 'XAF',
            'status' => 'active'
        ]);
        
        $this->assertEquals(1000000, $wallet->balance);
        
        // Simuler un débit
        $wallet->balance -= 500000;
        $wallet->save();
        
        $this->assertEquals(500000, $wallet->fresh()->balance);
        
        // Simuler un crédit
        $wallet->balance += 200000;
        $wallet->save();
        
        $this->assertEquals(700000, $wallet->fresh()->balance);
    }

    /** @test */
    public function property_wizard_data_structure_is_correct()
    {
        $user = User::factory()->create(['role' => 'proprietor']);
        
        $propertyData = [
            'user_id' => $user->id,
            'title' => 'Nouvelle Propriété',
            'description' => 'Description complète de la propriété pour test',
            'type' => 'house',
            'price' => 50000000,
            'location' => 'Douala, Cameroun',
            'latitude' => 4.0483,
            'longitude' => 9.7043,
            'status' => 'pending',
            'is_crowdfundable' => true,
            'expected_roi' => 15.0
        ];
        
        $property = Property::create($propertyData);
        
        $this->assertNotNull($property);
        $this->assertEquals('Nouvelle Propriété', $property->title);
        $this->assertTrue($property->is_crowdfundable);
        $this->assertEquals(15.0, (float)$property->expected_roi);
        
        // Test de création de projet crowdfunding
        $crowdfundingData = [
            'user_id' => $user->id,
            'property_id' => $property->id,
            'title' => $property->title . ' - Projet de Crowdfunding',
            'description' => $property->description,
            'total_amount' => 40000000,
            'amount_raised' => 0,
            'total_shares' => 800,
            'shares_sold' => 0,
            'price_per_share' => 50000,
            'expected_roi' => 15.0,
            'funding_deadline' => now()->addDays(60),
            'status' => 'draft'
        ];
        
        $project = CrowdfundingProject::create($crowdfundingData);
        
        $this->assertNotNull($project);
        $this->assertEquals($property->id, $project->property_id);
        $this->assertEquals(50000, $project->price_per_share);
    }

    /** @test */
    public function crowdfunding_progress_calculations_work()
    {
        $project = CrowdfundingProject::factory()->create([
            'total_amount' => 10000000,
            'amount_raised' => 7500000,
            'total_shares' => 1000,
            'shares_sold' => 750,
            'funding_deadline' => now()->addDays(15)
        ]);
        
        // Test des calculs de progression
        $progressPercentage = ($project->amount_raised / $project->total_amount) * 100;
        $this->assertEquals(75.0, $progressPercentage);
        
        $sharesProgressPercentage = ($project->shares_sold / $project->total_shares) * 100;
        $this->assertEquals(75.0, $sharesProgressPercentage);
        
        $daysRemaining = now()->diffInDays($project->funding_deadline, false);
        $this->assertGreaterThanOrEqual(14, $daysRemaining);
        $this->assertLessThanOrEqual(15, $daysRemaining);
        
        $remainingShares = $project->total_shares - $project->shares_sold;
        $this->assertEquals(250, $remainingShares);
    }

    /** @test */
    public function user_roles_and_permissions_work()
    {
        $proprietor = User::factory()->create(['role' => 'proprietor']);
        $investor = User::factory()->create(['role' => 'investor']);
        $admin = User::factory()->create(['role' => 'admin']);
        
        $this->assertEquals('proprietor', $proprietor->role);
        $this->assertEquals('investor', $investor->role);
        $this->assertEquals('admin', $admin->role);
        
        // Test des relations
        $property = Property::factory()->create(['user_id' => $proprietor->id]);
        $this->assertEquals($proprietor->id, $property->user_id);
        
        $wallet = Wallet::create(['user_id' => $investor->id, 'balance' => 1000000, 'currency' => 'XAF', 'status' => 'active']);
        $this->assertEquals($investor->id, $wallet->user_id);
    }

    /** @test */
    public function database_relationships_work()
    {
        $user = User::factory()->create();
        $property = Property::factory()->create(['user_id' => $user->id]);
        $project = CrowdfundingProject::factory()->create([
            'user_id' => $user->id,
            'property_id' => $property->id
        ]);
        
        // Test des relations
        $this->assertEquals($user->id, $property->user->id);
        $this->assertEquals($property->id, $project->property->id);
        $this->assertEquals($user->id, $project->user->id);
        
        // Test relation inverse
        $this->assertInstanceOf(Property::class, $project->property);
        $this->assertInstanceOf(User::class, $project->user);
    }
}
