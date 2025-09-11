<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class WalletManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->wallet = Wallet::factory()->create([
            'user_id' => $this->user->id,
            'balance' => 100000
        ]);
        $this->actingAs($this->user);
    }

    /** @test */
    public function user_can_view_wallet_balance()
    {
        $response = $this->get('/wallet');

        $response->assertStatus(200);
        $response->assertSee('100,000');
    }

    /** @test */
    public function user_can_topup_wallet()
    {
        $topupData = [
            'amount' => 50000
        ];

        $response = $this->post('/wallet/topup', $topupData);

        $response->assertJson(['success' => true]);
        
        $this->wallet->refresh();
        $this->assertEquals(150000, $this->wallet->balance);
        
        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'type' => 'topup',
            'amount' => 50000,
            'status' => 'completed'
        ]);
    }

    /** @test */
    public function user_can_withdraw_from_wallet()
    {
        $withdrawData = [
            'amount' => 25000
        ];

        $response = $this->post('/wallet/withdraw', $withdrawData);

        $response->assertJson(['success' => true]);
        
        $this->wallet->refresh();
        $this->assertEquals(75000, $this->wallet->balance);
        
        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'type' => 'withdraw',
            'amount' => 25000,
            'status' => 'completed'
        ]);
    }

    /** @test */
    public function user_cannot_withdraw_more_than_balance()
    {
        $withdrawData = [
            'amount' => 200000 // More than balance
        ];

        $response = $this->post('/wallet/withdraw', $withdrawData);

        $response->assertJson(['success' => false]);
        $response->assertJsonFragment(['message' => 'Insufficient balance']);
        
        $this->wallet->refresh();
        $this->assertEquals(100000, $this->wallet->balance); // Unchanged
    }

    /** @test */
    public function minimum_topup_amount_is_enforced()
    {
        $topupData = [
            'amount' => 50 // Below minimum
        ];

        $response = $this->post('/wallet/topup', $topupData);

        $response->assertSessionHasErrors('amount');
    }

    /** @test */
    public function minimum_withdraw_amount_is_enforced()
    {
        $withdrawData = [
            'amount' => 50 // Below minimum
        ];

        $response = $this->post('/wallet/withdraw', $withdrawData);

        $response->assertSessionHasErrors('amount');
    }

    /** @test */
    public function wallet_transactions_are_displayed()
    {
        // Create some transactions
        Transaction::factory()->create([
            'user_id' => $this->user->id,
            'type' => 'topup',
            'amount' => 10000,
            'status' => 'completed'
        ]);

        Transaction::factory()->create([
            'user_id' => $this->user->id,
            'type' => 'withdraw',
            'amount' => 5000,
            'status' => 'completed'
        ]);

        $response = $this->get('/wallet');

        $response->assertStatus(200);
        $response->assertSee('10,000');
        $response->assertSee('5,000');
    }

    /** @test */
    public function commission_is_deducted_correctly()
    {
        $amount = 100000;
        $expectedCommission = $amount * 0.01; // 1%
        $expectedBalance = $this->wallet->balance - $expectedCommission;

        $this->wallet->deductCommission($amount);

        $this->wallet->refresh();
        $this->assertEquals($expectedBalance, $this->wallet->balance);
        
        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'type' => 'commission',
            'amount' => $expectedCommission,
            'status' => 'completed'
        ]);
    }

    /** @test */
    public function wallet_balance_is_updated_correctly()
    {
        $initialBalance = $this->wallet->balance;
        
        // Topup
        $this->wallet->balance += 25000;
        $this->wallet->save();
        
        $this->assertEquals($initialBalance + 25000, $this->wallet->balance);
        
        // Withdraw
        $this->wallet->balance -= 15000;
        $this->wallet->save();
        
        $this->assertEquals($initialBalance + 10000, $this->wallet->balance);
    }

    /** @test */
    public function wallet_creation_for_new_user()
    {
        $newUser = User::factory()->create();
        
        // Simulate wallet creation during registration
        $wallet = Wallet::create([
            'user_id' => $newUser->id,
            'balance' => 0
        ]);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $newUser->id,
            'balance' => 0
        ]);
    }
}
