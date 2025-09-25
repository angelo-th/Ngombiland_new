<?php

namespace Tests\Feature;

use App\Models\CrowdfundingProject;
use App\Models\CrowdfundingInvestment;
use App\Models\Property;
use App\Models\User;
use App\Models\Wallet;
use App\Services\RentalDistributionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RentalDistributionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $property;
    protected $project;
    protected $investor1;
    protected $investor2;
    protected $rentalDistributionService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->rentalDistributionService = new RentalDistributionService();
        
        // Créer un utilisateur propriétaire
        $this->user = User::factory()->create(['role' => 'proprietor']);
        
        // Créer une propriété
        $this->property = Property::factory()->create([
            'user_id' => $this->user->id,
            'is_crowdfundable' => true,
            'expected_roi' => 12.5
        ]);
        
        // Créer un projet de crowdfunding
        $this->project = CrowdfundingProject::create([
            'user_id' => $this->user->id,
            'property_id' => $this->property->id,
            'title' => 'Test Project',
            'description' => 'Test Description',
            'total_amount' => 10000000, // 10M FCFA
            'amount_raised' => 10000000,
            'total_shares' => 1000,
            'shares_sold' => 1000,
            'price_per_share' => 10000,
            'expected_roi' => 12.5,
            'funding_deadline' => now()->addDays(30),
            'status' => 'funded'
        ]);
        
        // Créer des investisseurs
        $this->investor1 = User::factory()->create(['role' => 'investor']);
        $this->investor2 = User::factory()->create(['role' => 'investor']);
        
        // Créer des wallets pour les investisseurs
        Wallet::create(['user_id' => $this->investor1->id, 'balance' => 0, 'currency' => 'XAF', 'status' => 'active']);
        Wallet::create(['user_id' => $this->investor2->id, 'balance' => 0, 'currency' => 'XAF', 'status' => 'active']);
        
        // Créer des investissements
        CrowdfundingInvestment::create([
            'user_id' => $this->investor1->id,
            'crowdfunding_project_id' => $this->project->id,
            'shares_purchased' => 600,
            'amount_invested' => 6000000,
            'price_per_share' => 10000,
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);
        
        CrowdfundingInvestment::create([
            'user_id' => $this->investor2->id,
            'crowdfunding_project_id' => $this->project->id,
            'shares_purchased' => 400,
            'amount_invested' => 4000000,
            'price_per_share' => 10000,
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);
    }

    /** @test */
    public function it_can_distribute_rent_to_investors()
    {
        $totalRent = 100000; // 100K FCFA de loyer
        
        $distribution = $this->rentalDistributionService->distributeRent($this->project, $totalRent);
        
        $this->assertNotNull($distribution);
        $this->assertEquals($this->project->id, $distribution->crowdfunding_project_id);
        $this->assertEquals($totalRent, $distribution->total_rent_amount);
        $this->assertEquals($totalRent * 0.7, $distribution->distributed_amount);
    }

    /** @test */
    public function it_distributes_rent_proportionally_to_share_ownership()
    {
        $totalRent = 100000;
        
        $this->rentalDistributionService->distributeRent($this->project, $totalRent);
        
        // Recharger les wallets
        $investor1Wallet = $this->investor1->wallet->fresh();
        $investor2Wallet = $this->investor2->wallet->fresh();
        
        // Investor 1 a 60% des parts (600/1000)
        $expectedInvestor1Rent = $totalRent * 0.7 * 0.6; // 70% du loyer * 60% des parts
        $this->assertEquals($expectedInvestor1Rent, $investor1Wallet->balance);
        
        // Investor 2 a 40% des parts (400/1000)
        $expectedInvestor2Rent = $totalRent * 0.7 * 0.4; // 70% du loyer * 40% des parts
        $this->assertEquals($expectedInvestor2Rent, $investor2Wallet->balance);
    }

    /** @test */
    public function it_creates_transactions_for_rental_income()
    {
        $totalRent = 100000;
        
        $this->rentalDistributionService->distributeRent($this->project, $totalRent);
        
        $investor1Transactions = $this->investor1->transactions()->where('type', 'rental_income')->get();
        $investor2Transactions = $this->investor2->transactions()->where('type', 'rental_income')->get();
        
        $this->assertCount(1, $investor1Transactions);
        $this->assertCount(1, $investor2Transactions);
        
        $this->assertEquals('Rental income from ' . $this->project->title, $investor1Transactions->first()->description);
        $this->assertEquals('completed', $investor1Transactions->first()->status);
    }

    /** @test */
    public function it_creates_distribution_details()
    {
        $totalRent = 100000;
        
        $distribution = $this->rentalDistributionService->distributeRent($this->project, $totalRent);
        
        $details = $distribution->details;
        $this->assertCount(2, $details);
        
        $investor1Detail = $details->where('user_id', $this->investor1->id)->first();
        $investor2Detail = $details->where('user_id', $this->investor2->id)->first();
        
        $this->assertEquals(600, $investor1Detail->shares_owned);
        $this->assertEquals(400, $investor2Detail->shares_owned);
    }

    /** @test */
    public function it_handles_zero_rent_correctly()
    {
        $totalRent = 0;
        
        $distribution = $this->rentalDistributionService->distributeRent($this->project, $totalRent);
        
        $this->assertNotNull($distribution);
        $this->assertEquals(0, $distribution->total_rent_amount);
        $this->assertEquals(0, $distribution->distributed_amount);
        
        // Vérifier que les wallets n'ont pas changé
        $this->assertEquals(0, $this->investor1->wallet->fresh()->balance);
        $this->assertEquals(0, $this->investor2->wallet->fresh()->balance);
    }
}
