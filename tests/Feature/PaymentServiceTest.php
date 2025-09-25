<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $paymentService;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->paymentService = new PaymentService();
        $this->user = User::factory()->create();
        
        // Créer un wallet pour l'utilisateur
        Wallet::create([
            'user_id' => $this->user->id,
            'balance' => 1000000, // 1M FCFA
            'currency' => 'XAF',
            'status' => 'active'
        ]);
    }

    /** @test */
    public function it_can_process_investment_payment()
    {
        $amount = 100000; // 100K FCFA
        
        $transaction = $this->paymentService->processInvestmentPayment(
            $this->user->id,
            $amount,
            'Test investment'
        );
        
        $this->assertNotNull($transaction);
        $this->assertEquals('investment_payment', $transaction->type);
        $this->assertEquals(-$amount, $transaction->amount);
        $this->assertEquals('completed', $transaction->status);
        
        // Vérifier que le wallet a été débité
        $this->assertEquals(900000, $this->user->wallet->fresh()->balance);
    }

    /** @test */
    public function it_prevents_insufficient_funds_payment()
    {
        $amount = 2000000; // 2M FCFA (plus que le solde)
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Solde insuffisant');
        
        $this->paymentService->processInvestmentPayment(
            $this->user->id,
            $amount,
            'Test investment'
        );
    }

    /** @test */
    public function it_can_topup_wallet()
    {
        $amount = 500000; // 500K FCFA
        
        $transaction = $this->paymentService->topupWallet(
            $this->user->id,
            $amount,
            'mobile_money',
            'Rechargement MTN'
        );
        
        $this->assertNotNull($transaction);
        $this->assertEquals('topup', $transaction->type);
        $this->assertEquals($amount, $transaction->amount);
        $this->assertEquals('completed', $transaction->status);
        $this->assertEquals('mobile_money', $transaction->provider);
        
        // Vérifier que le wallet a été crédité
        $this->assertEquals(1500000, $this->user->wallet->fresh()->balance);
    }

    /** @test */
    public function it_creates_wallet_if_not_exists()
    {
        $newUser = User::factory()->create();
        
        $transaction = $this->paymentService->topupWallet(
            $newUser->id,
            100000,
            'manual',
            'Premier rechargement'
        );
        
        $this->assertNotNull($transaction);
        
        // Vérifier que le wallet a été créé
        $wallet = Wallet::where('user_id', $newUser->id)->first();
        $this->assertNotNull($wallet);
        $this->assertEquals(100000, $wallet->balance);
    }

    /** @test */
    public function it_can_withdraw_from_wallet()
    {
        $amount = 200000; // 200K FCFA
        
        $transaction = $this->paymentService->withdrawFromWallet(
            $this->user->id,
            $amount,
            'bank_transfer',
            'Retrait vers compte bancaire'
        );
        
        $this->assertNotNull($transaction);
        $this->assertEquals('withdrawal', $transaction->type);
        $this->assertEquals(-$amount, $transaction->amount);
        $this->assertEquals('completed', $transaction->status);
        $this->assertEquals('bank_transfer', $transaction->provider);
        
        // Vérifier que le wallet a été débité
        $this->assertEquals(800000, $this->user->wallet->fresh()->balance);
    }

    /** @test */
    public function it_can_simulate_mobile_money_payment()
    {
        $amount = 100000;
        $phoneNumber = '675123456';
        $provider = 'MTN';
        
        $transaction = $this->paymentService->simulateMobileMoneyPayment(
            $this->user->id,
            $amount,
            $phoneNumber,
            $provider
        );
        
        $this->assertNotNull($transaction);
        $this->assertEquals('mobile_money_payment', $transaction->type);
        $this->assertEquals($amount, $transaction->amount);
        $this->assertEquals('pending', $transaction->status);
        $this->assertEquals($provider, $transaction->provider);
        $this->assertStringContains('Paiement Mobile Money MTN - 675123456', $transaction->description);
    }

    /** @test */
    public function it_can_get_payment_history()
    {
        // Créer quelques transactions
        $this->paymentService->topupWallet($this->user->id, 100000, 'manual', 'Test 1');
        $this->paymentService->processInvestmentPayment($this->user->id, 50000, 'Test 2');
        $this->paymentService->topupWallet($this->user->id, 200000, 'manual', 'Test 3');
        
        $history = $this->paymentService->getPaymentHistory($this->user->id, 10);
        
        $this->assertCount(3, $history);
        $this->assertEquals('topup', $history->first()->type);
        $this->assertEquals('investment_payment', $history->skip(1)->first()->type);
    }

    /** @test */
    public function it_can_get_payment_stats()
    {
        // Créer quelques transactions
        $this->paymentService->topupWallet($this->user->id, 500000, 'manual', 'Topup 1');
        $this->paymentService->processInvestmentPayment($this->user->id, 100000, 'Investment 1');
        $this->paymentService->processInvestmentPayment($this->user->id, 200000, 'Investment 2');
        $this->paymentService->withdrawFromWallet($this->user->id, 50000, 'manual', 'Withdrawal 1');
        
        $stats = $this->paymentService->getPaymentStats($this->user->id);
        
        $this->assertEquals(500000, $stats['total_topup']);
        $this->assertEquals(-300000, $stats['total_invested']); // Négatif car c'est un débit
        $this->assertEquals(50000, $stats['total_withdrawn']);
        $this->assertEquals(4, $stats['transaction_count']);
    }
}
