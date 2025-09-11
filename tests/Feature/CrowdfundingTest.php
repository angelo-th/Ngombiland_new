<?php

namespace Tests\Feature;

use App\Models\Investment;
use App\Models\Property;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CrowdfundingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->investor = User::factory()->create(['role' => 'investor']);
        $this->proprietor = User::factory()->create(['role' => 'proprietor']);

        $this->investorWallet = Wallet::factory()->create([
            'user_id' => $this->investor->id,
            'balance' => 1000000,
        ]);

        $this->property = Property::factory()->create([
            'user_id' => $this->proprietor->id,
            'is_crowdfundable' => true,
            'expected_roi' => 12.5,
        ]);

        $this->actingAs($this->investor);
    }

    /** @test */
    public function investor_can_view_crowdfunding_projects()
    {
        $this->actingAs($this->investor);
        $response = $this->get('/crowdfunding');

        $response->assertStatus(200);
        $response->assertSee($this->property->title);
    }

    /** @test */
    public function investor_can_invest_in_crowdfunding_project()
    {
        $investmentData = [
            'amount' => 100000,
        ];

        $response = $this->post("/crowdfunding/{$this->property->id}/invest", $investmentData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('investments', [
            'user_id' => $this->investor->id,
            'property_id' => $this->property->id,
            'amount' => 100000,
            'roi' => 12.5,
        ]);
    }

    /** @test */
    public function investment_deducts_from_wallet_balance()
    {
        $initialBalance = $this->investorWallet->balance;
        $investmentAmount = 150000;

        $investmentData = [
            'amount' => $investmentAmount,
        ];

        $this->post("/crowdfunding/{$this->property->id}/invest", $investmentData);

        $this->investorWallet->refresh();
        $this->assertEquals($initialBalance - $investmentAmount, $this->investorWallet->balance);
    }

    /** @test */
    public function investor_cannot_invest_with_insufficient_balance()
    {
        $this->investorWallet->update(['balance' => 50000]);

        $investmentData = [
            'amount' => 100000, // More than balance
        ];

        $response = $this->post("/crowdfunding/{$this->property->id}/invest", $investmentData);

        $response->assertSessionHas('error');
        $response->assertSessionHas('error', 'Insufficient wallet balance.');

        $this->assertDatabaseMissing('investments', [
            'user_id' => $this->investor->id,
            'property_id' => $this->property->id,
        ]);
    }

    /** @test */
    public function minimum_investment_amount_is_enforced()
    {
        $investmentData = [
            'amount' => 500, // Below minimum
        ];

        $response = $this->post("/crowdfunding/{$this->property->id}/invest", $investmentData);

        $response->assertSessionHasErrors('amount');
    }

    /** @test */
    public function roi_is_calculated_correctly()
    {
        $investmentAmount = 200000;
        $expectedRoi = 12.5; // From property

        $investmentData = [
            'amount' => $investmentAmount,
        ];

        $this->post("/crowdfunding/{$this->property->id}/invest", $investmentData);

        $investment = Investment::where('user_id', $this->investor->id)
            ->where('property_id', $this->property->id)
            ->first();

        $this->assertEquals($expectedRoi, $investment->roi);
    }

    /** @test */
    public function investor_can_view_their_investments()
    {
        $investment = Investment::factory()->create([
            'user_id' => $this->investor->id,
            'property_id' => $this->property->id,
            'amount' => 100000,
            'roi' => 12.5,
        ]);

        $this->actingAs($this->investor);
        $response = $this->get('/investments');

        if ($response->status() !== 200) {
            dump('Response status: '.$response->status());
            dump('Response content: '.$response->getContent());
        }

        $response->assertStatus(200);
        $response->assertSee('100,000');
        $response->assertSee('12.50%');
    }

    /** @test */
    public function investment_status_is_set_correctly()
    {
        $investmentData = [
            'amount' => 100000,
        ];

        $this->post("/crowdfunding/{$this->property->id}/invest", $investmentData);

        $investment = Investment::where('user_id', $this->investor->id)
            ->where('property_id', $this->property->id)
            ->first();

        $this->assertEquals('active', $investment->status);
    }

    /** @test */
    public function investment_date_is_recorded()
    {
        $investmentData = [
            'amount' => 100000,
        ];

        $this->post("/crowdfunding/{$this->property->id}/invest", $investmentData);

        $investment = Investment::where('user_id', $this->investor->id)
            ->where('property_id', $this->property->id)
            ->first();

        $this->assertNotNull($investment->investment_date);
    }

    /** @test */
    public function multiple_investors_can_invest_in_same_property()
    {
        $investor2 = User::factory()->create(['role' => 'investor']);
        $wallet2 = Wallet::factory()->create([
            'user_id' => $investor2->id,
            'balance' => 500000,
        ]);

        // First investor
        $this->post("/crowdfunding/{$this->property->id}/invest", ['amount' => 100000]);

        // Second investor
        $this->actingAs($investor2);
        $this->post("/crowdfunding/{$this->property->id}/invest", ['amount' => 150000]);

        $this->assertDatabaseHas('investments', [
            'user_id' => $this->investor->id,
            'amount' => 100000,
        ]);

        $this->assertDatabaseHas('investments', [
            'user_id' => $investor2->id,
            'amount' => 150000,
        ]);
    }

    /** @test */
    public function total_investment_amount_is_calculated_correctly()
    {
        // Create multiple investments
        Investment::factory()->create([
            'user_id' => $this->investor->id,
            'property_id' => $this->property->id,
            'amount' => 100000,
            'status' => 'active',
        ]);

        Investment::factory()->create([
            'user_id' => $this->investor->id,
            'property_id' => $this->property->id,
            'amount' => 200000,
            'status' => 'active',
        ]);

        $totalInvestment = Investment::where('property_id', $this->property->id)
            ->where('status', 'active')
            ->sum('amount');

        $this->assertEquals(300000, $totalInvestment);
    }

    /** @test */
    public function only_crowdfundable_properties_are_shown()
    {
        $normalProperty = Property::factory()->create([
            'user_id' => $this->proprietor->id,
            'is_crowdfundable' => false,
        ]);

        $response = $this->get('/crowdfunding');

        $response->assertStatus(200);
        $response->assertSee($this->property->title);
        $response->assertDontSee($normalProperty->title);
    }
}
