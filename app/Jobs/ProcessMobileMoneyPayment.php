<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessMobileMoneyPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaction;

    /**
     * Create a new job instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     */
    public function handle(PaymentService $paymentService): void
    {
        try {
            // Simuler le traitement du paiement Mobile Money
            // Dans un vrai système, vous feriez appel à l'API Mobile Money
            
            // Attendre 3 secondes pour simuler le traitement
            sleep(3);
            
            // Simuler un succès (95% de chance)
            $success = rand(1, 100) <= 95;
            
            if ($success) {
                // Créditer le portefeuille
                $paymentService->topupWallet(
                    $this->transaction->user_id,
                    $this->transaction->amount,
                    $this->transaction->provider,
                    $this->transaction->description
                );
                
                // Marquer la transaction comme terminée
                $this->transaction->update(['status' => 'completed']);
            } else {
                // Marquer la transaction comme échouée
                $this->transaction->update(['status' => 'failed']);
            }
            
        } catch (\Exception $e) {
            // Marquer la transaction comme échouée en cas d'erreur
            $this->transaction->update([
                'status' => 'failed',
                'description' => $this->transaction->description . ' - Erreur: ' . $e->getMessage()
            ]);
        }
    }
}
