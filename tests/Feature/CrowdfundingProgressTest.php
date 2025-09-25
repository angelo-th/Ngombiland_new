<?php

namespace Tests\Feature;

use App\Models\CrowdfundingProject;
use App\Models\CrowdfundingInvestment;
use App\Models\Property;
use App\Models\User;
use App\Models\Wallet;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrowdfundingProgressTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $property;
    protected $project;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create(['role' => 'proprietor']);
        
        $this->property = Property::factory()->create([
            'user_id' => $this->user->id,
            'is_crowdfundable' => true
        ]);
        
        $this->project = CrowdfundingProject::create([
            'user_id' => $this->user->id,
            'property_id' => $this->property->id,
            'title' => 'Test Project',
            'description' => 'Test Description',
            'total_amount' => 10000000, // 10M FCFA
            'amount_raised' => 7500000, // 7.5M FCFA (75%)
            'total_shares' => 1000,
            'shares_sold' => 750,
            'price_per_share' => 10000,
            'expected_roi' => 12.5,
            'funding_deadline' => now()->addDays(15),
            'status' => 'active'
        ]);
    }

    /** @test */
    public function it_displays_correct_progress_percentage()
    {
        Livewire::test('crowdfunding-progress', ['project' => $this->project])
            ->assertSet('progressPercentage', 75.0)
            ->assertSee('75.0%');
    }

    /** @test */
    public function it_displays_correct_amounts()
    {
        Livewire::test('crowdfunding-progress', ['project' => $this->project])
            ->assertSet('amountRaised', 7500000)
            ->assertSet('totalAmount', 10000000)
            ->assertSet('sharesSold', 750)
            ->assertSet('totalShares', 1000);
    }

    /** @test */
    public function it_calculates_days_remaining_correctly()
    {
        Livewire::test('crowdfunding-progress', ['project' => $this->project])
            ->assertSet('daysRemaining', 15);
    }

    /** @test */
    public function it_displays_investors_count()
    {
        // Créer des investisseurs
        $investor1 = User::factory()->create(['role' => 'investor']);
        $investor2 = User::factory()->create(['role' => 'investor']);
        
        CrowdfundingInvestment::create([
            'user_id' => $investor1->id,
            'crowdfunding_project_id' => $this->project->id,
            'shares_purchased' => 400,
            'amount_invested' => 4000000,
            'price_per_share' => 10000,
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);
        
        CrowdfundingInvestment::create([
            'user_id' => $investor2->id,
            'crowdfunding_project_id' => $this->project->id,
            'shares_purchased' => 350,
            'amount_invested' => 3500000,
            'price_per_share' => 10000,
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);
        
        Livewire::test('crowdfunding-progress', ['project' => $this->project])
            ->assertSet('investorsCount', 2);
    }

    /** @test */
    public function it_shows_fully_funded_status()
    {
        $this->project->update([
            'amount_raised' => 10000000,
            'shares_sold' => 1000,
            'status' => 'funded'
        ]);
        
        Livewire::test('crowdfunding-progress', ['project' => $this->project])
            ->assertSet('progressPercentage', 100.0)
            ->assertSee('Projet entièrement financé !');
    }

    /** @test */
    public function it_shows_last_week_warning()
    {
        $this->project->update([
            'funding_deadline' => now()->addDays(5)
        ]);
        
        Livewire::test('crowdfunding-progress', ['project' => $this->project])
            ->assertSee('Dernière semaine !');
    }

    /** @test */
    public function it_shows_expired_status()
    {
        $this->project->update([
            'funding_deadline' => now()->subDays(5)
        ]);
        
        Livewire::test('crowdfunding-progress', ['project' => $this->project])
            ->assertSee('Expiré');
    }

    /** @test */
    public function it_updates_progress_when_data_changes()
    {
        $component = Livewire::test('crowdfunding-progress', ['project' => $this->project]);
        
        // Mettre à jour le projet
        $this->project->update([
            'amount_raised' => 9000000,
            'shares_sold' => 900
        ]);
        
        $component->call('updateProgress')
            ->assertSet('progressPercentage', 90.0)
            ->assertSet('amountRaised', 9000000)
            ->assertSet('sharesSold', 900);
    }
}
