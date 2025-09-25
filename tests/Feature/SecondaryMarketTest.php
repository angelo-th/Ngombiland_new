<?php

namespace Tests\Feature;

use App\Models\CrowdfundingProject;
use App\Models\CrowdfundingInvestment;
use App\Models\Property;
use App\Models\User;
use App\Models\Wallet;
use App\Models\SecondaryMarketListing;
use App\Models\SecondaryMarketOffer;
use App\Services\SecondaryMarketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecondaryMarketTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $property;
    protected $project;
    protected $investor;
    protected $buyer;
    protected $secondaryMarketService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->secondaryMarketService = new SecondaryMarketService();
        
        // Créer un utilisateur propriétaire
        $this->user = User::factory()->create(['role' => 'proprietor']);
        
        // Créer une propriété
        $this->property = Property::factory()->create([
            'user_id' => $this->user->id,
            'is_crowdfundable' => true
        ]);
        
        // Créer un projet de crowdfunding
        $this->project = CrowdfundingProject::create([
            'user_id' => $this->user->id,
            'property_id' => $this->property->id,
            'title' => 'Test Project',
            'description' => 'Test Description',
            'total_amount' => 10000000,
            'amount_raised' => 10000000,
            'total_shares' => 1000,
            'shares_sold' => 1000,
            'price_per_share' => 10000,
            'expected_roi' => 12.5,
            'funding_deadline' => now()->addDays(30),
            'status' => 'funded'
        ]);
        
        // Créer un investisseur
        $this->investor = User::factory()->create(['role' => 'investor']);
        $this->buyer = User::factory()->create(['role' => 'investor']);
        
        // Créer des wallets
        Wallet::create(['user_id' => $this->investor->id, 'balance' => 1000000, 'currency' => 'XAF', 'status' => 'active']);
        Wallet::create(['user_id' => $this->buyer->id, 'balance' => 1000000, 'currency' => 'XAF', 'status' => 'active']);
        
        // Créer un investissement
        $this->investment = CrowdfundingInvestment::create([
            'user_id' => $this->investor->id,
            'crowdfunding_project_id' => $this->project->id,
            'shares_purchased' => 100,
            'amount_invested' => 1000000,
            'price_per_share' => 10000,
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);
    }

    /** @test */
    public function it_can_create_a_secondary_market_listing()
    {
        $data = [
            'user_id' => $this->investor->id,
            'crowdfunding_investment_id' => $this->investment->id,
            'shares_for_sale' => 50,
            'price_per_share' => 12000,
            'description' => 'Selling half of my shares'
        ];
        
        $listing = $this->secondaryMarketService->createListing($data);
        
        $this->assertNotNull($listing);
        $this->assertEquals($this->investor->id, $listing->user_id);
        $this->assertEquals(50, $listing->shares_for_sale);
        $this->assertEquals(12000, $listing->price_per_share);
        $this->assertEquals(600000, $listing->total_price); // 50 * 12000
        $this->assertEquals('active', $listing->status);
    }

    /** @test */
    public function it_can_make_an_offer_on_listing()
    {
        $listing = SecondaryMarketListing::create([
            'user_id' => $this->investor->id,
            'crowdfunding_investment_id' => $this->investment->id,
            'shares_for_sale' => 50,
            'price_per_share' => 12000,
            'total_price' => 600000,
            'status' => 'active',
            'expires_at' => now()->addDays(30)
        ]);
        
        $offerData = [
            'user_id' => $this->buyer->id,
            'secondary_market_listing_id' => $listing->id,
            'shares_requested' => 25,
            'offer_price_per_share' => 11500,
            'message' => 'Interested in buying half'
        ];
        
        $offer = $this->secondaryMarketService->makeOffer($offerData);
        
        $this->assertNotNull($offer);
        $this->assertEquals($this->buyer->id, $offer->user_id);
        $this->assertEquals(25, $offer->shares_requested);
        $this->assertEquals(11500, $offer->offer_price_per_share);
        $this->assertEquals(287500, $offer->total_offer_amount); // 25 * 11500
        $this->assertEquals('pending', $offer->status);
    }

    /** @test */
    public function it_can_accept_an_offer()
    {
        $listing = SecondaryMarketListing::create([
            'user_id' => $this->investor->id,
            'crowdfunding_investment_id' => $this->investment->id,
            'shares_for_sale' => 50,
            'price_per_share' => 12000,
            'total_price' => 600000,
            'status' => 'active',
            'expires_at' => now()->addDays(30)
        ]);
        
        $offer = SecondaryMarketOffer::create([
            'user_id' => $this->buyer->id,
            'secondary_market_listing_id' => $listing->id,
            'shares_requested' => 25,
            'offer_price_per_share' => 11500,
            'total_offer_amount' => 287500,
            'status' => 'pending'
        ]);
        
        $this->secondaryMarketService->acceptOffer($offer);
        
        // Vérifier que l'offre est acceptée
        $this->assertEquals('accepted', $offer->fresh()->status);
        $this->assertNotNull($offer->fresh()->accepted_at);
        
        // Vérifier que le listing est mis à jour
        $listing = $listing->fresh();
        $this->assertEquals(25, $listing->shares_for_sale); // 50 - 25
        $this->assertEquals(300000, $listing->total_price); // 25 * 12000
    }

    /** @test */
    public function it_transfers_money_correctly_when_offer_is_accepted()
    {
        $listing = SecondaryMarketListing::create([
            'user_id' => $this->investor->id,
            'crowdfunding_investment_id' => $this->investment->id,
            'shares_for_sale' => 50,
            'price_per_share' => 12000,
            'total_price' => 600000,
            'status' => 'active',
            'expires_at' => now()->addDays(30)
        ]);
        
        $offer = SecondaryMarketOffer::create([
            'user_id' => $this->buyer->id,
            'secondary_market_listing_id' => $listing->id,
            'shares_requested' => 25,
            'offer_price_per_share' => 11500,
            'total_offer_amount' => 287500,
            'status' => 'pending'
        ]);
        
        $buyerInitialBalance = $this->buyer->wallet->balance;
        $sellerInitialBalance = $this->investor->wallet->balance;
        
        $this->secondaryMarketService->acceptOffer($offer);
        
        // Vérifier les soldes des wallets
        $this->assertEquals($buyerInitialBalance - 287500, $this->buyer->wallet->fresh()->balance);
        $this->assertEquals($sellerInitialBalance + 287500, $this->investor->wallet->fresh()->balance);
    }

    /** @test */
    public function it_prevents_self_offers()
    {
        $listing = SecondaryMarketListing::create([
            'user_id' => $this->investor->id,
            'crowdfunding_investment_id' => $this->investment->id,
            'shares_for_sale' => 50,
            'price_per_share' => 12000,
            'total_price' => 600000,
            'status' => 'active',
            'expires_at' => now()->addDays(30)
        ]);
        
        $offerData = [
            'user_id' => $this->investor->id, // Même utilisateur que le vendeur
            'secondary_market_listing_id' => $listing->id,
            'shares_requested' => 25,
            'offer_price_per_share' => 11500
        ];
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Vous ne pouvez pas faire d\'offre sur votre propre annonce');
        
        $this->secondaryMarketService->makeOffer($offerData);
    }

    /** @test */
    public function it_prevents_offers_on_expired_listings()
    {
        $listing = SecondaryMarketListing::create([
            'user_id' => $this->investor->id,
            'crowdfunding_investment_id' => $this->investment->id,
            'shares_for_sale' => 50,
            'price_per_share' => 12000,
            'total_price' => 600000,
            'status' => 'active',
            'expires_at' => now()->subDays(1) // Expiré hier
        ]);
        
        $offerData = [
            'user_id' => $this->buyer->id,
            'secondary_market_listing_id' => $listing->id,
            'shares_requested' => 25,
            'offer_price_per_share' => 11500
        ];
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cette annonce n\'est plus disponible');
        
        $this->secondaryMarketService->makeOffer($offerData);
    }
}
