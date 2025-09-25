<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Traiter un paiement pour un investissement
     */
    public function processInvestmentPayment($userId, $amount, $description = '')
    {
        return DB::transaction(function () use ($userId, $amount, $description) {
            $wallet = Wallet::where('user_id', $userId)->first();
            
            if (!$wallet) {
                throw new \Exception('Portefeuille non trouvé');
            }

            if ($wallet->balance < $amount) {
                throw new \Exception('Solde insuffisant');
            }

            // Débiter le portefeuille
            $wallet->decrement('balance', $amount);

            // Créer la transaction
            $transaction = Transaction::create([
                'user_id' => $userId,
                'wallet_id' => $wallet->id,
                'type' => 'investment_payment',
                'amount' => -$amount,
                'description' => $description ?: 'Paiement d\'investissement',
                'status' => 'completed',
                'reference' => 'INV_' . Str::uuid(),
            ]);

            return $transaction;
        });
    }

    /**
     * Traiter un paiement pour le marketplace secondaire
     */
    public function processSecondaryMarketPayment($buyerId, $sellerId, $amount, $description = '')
    {
        return DB::transaction(function () use ($buyerId, $sellerId, $amount, $description) {
            $buyerWallet = Wallet::where('user_id', $buyerId)->first();
            $sellerWallet = Wallet::where('user_id', $sellerId)->first();

            if (!$buyerWallet || !$sellerWallet) {
                throw new \Exception('Portefeuille non trouvé');
            }

            if ($buyerWallet->balance < $amount) {
                throw new \Exception('Solde insuffisant');
            }

            // Débiter l'acheteur
            $buyerWallet->decrement('balance', $amount);

            // Créer la transaction de l'acheteur
            Transaction::create([
                'user_id' => $buyerId,
                'wallet_id' => $buyerWallet->id,
                'type' => 'secondary_market_purchase',
                'amount' => -$amount,
                'description' => $description ?: 'Achat sur le marketplace secondaire',
                'status' => 'completed',
                'reference' => 'SEC_' . Str::uuid(),
            ]);

            // Créditer le vendeur
            $sellerWallet->increment('balance', $amount);

            // Créer la transaction du vendeur
            Transaction::create([
                'user_id' => $sellerId,
                'wallet_id' => $sellerWallet->id,
                'type' => 'secondary_market_sale',
                'amount' => $amount,
                'description' => $description ?: 'Vente sur le marketplace secondaire',
                'status' => 'completed',
                'reference' => 'SEC_' . Str::uuid(),
            ]);

            return true;
        });
    }

    /**
     * Recharger un portefeuille
     */
    public function topupWallet($userId, $amount, $method = 'manual', $description = '')
    {
        return DB::transaction(function () use ($userId, $amount, $method, $description) {
            $wallet = Wallet::where('user_id', $userId)->first();
            
            if (!$wallet) {
                // Créer un portefeuille si il n'existe pas
                $wallet = Wallet::create([
                    'user_id' => $userId,
                    'balance' => 0,
                    'currency' => 'XAF',
                    'status' => 'active',
                ]);
            }

            // Créditer le portefeuille
            $wallet->increment('balance', $amount);

            // Créer la transaction
            $transaction = Transaction::create([
                'user_id' => $userId,
                'wallet_id' => $wallet->id,
                'type' => 'topup',
                'amount' => $amount,
                'description' => $description ?: 'Rechargement de portefeuille',
                'status' => 'completed',
                'reference' => 'TOPUP_' . Str::uuid(),
                'provider' => $method,
            ]);

            return $transaction;
        });
    }

    /**
     * Retirer de l'argent du portefeuille
     */
    public function withdrawFromWallet($userId, $amount, $method = 'manual', $description = '')
    {
        return DB::transaction(function () use ($userId, $amount, $method, $description) {
            $wallet = Wallet::where('user_id', $userId)->first();
            
            if (!$wallet) {
                throw new \Exception('Portefeuille non trouvé');
            }

            if ($wallet->balance < $amount) {
                throw new \Exception('Solde insuffisant');
            }

            // Débiter le portefeuille
            $wallet->decrement('balance', $amount);

            // Créer la transaction
            $transaction = Transaction::create([
                'user_id' => $userId,
                'wallet_id' => $wallet->id,
                'type' => 'withdrawal',
                'amount' => -$amount,
                'description' => $description ?: 'Retrait de portefeuille',
                'status' => 'completed',
                'reference' => 'WITHDRAW_' . Str::uuid(),
                'provider' => $method,
            ]);

            return $transaction;
        });
    }

    /**
     * Simuler un paiement Mobile Money (pour la démo)
     */
    public function simulateMobileMoneyPayment($userId, $amount, $phoneNumber, $provider = 'MTN')
    {
        return DB::transaction(function () use ($userId, $amount, $phoneNumber, $provider) {
            // Simuler un délai de traitement
            sleep(2);

            // Simuler un succès (90% de chance)
            $success = rand(1, 10) <= 9;

            if (!$success) {
                throw new \Exception('Paiement échoué. Veuillez réessayer.');
            }

            // Créer une transaction en attente
            $transaction = Transaction::create([
                'user_id' => $userId,
                'type' => 'mobile_money_payment',
                'amount' => $amount,
                'description' => "Paiement Mobile Money {$provider} - {$phoneNumber}",
                'status' => 'pending',
                'reference' => 'MM_' . Str::uuid(),
                'provider' => $provider,
            ]);

            // Simuler la confirmation après 3 secondes
            \App\Jobs\ProcessMobileMoneyPayment::dispatch($transaction);

            return $transaction;
        });
    }

    /**
     * Obtenir l'historique des paiements d'un utilisateur
     */
    public function getPaymentHistory($userId, $limit = 20)
    {
        return Transaction::where('user_id', $userId)
            ->with('wallet')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtenir les statistiques de paiement
     */
    public function getPaymentStats($userId)
    {
        $transactions = Transaction::where('user_id', $userId)->get();

        return [
            'total_invested' => $transactions->where('type', 'investment_payment')->sum('amount'),
            'total_received' => $transactions->where('type', 'rental_income')->sum('amount'),
            'total_topup' => $transactions->where('type', 'topup')->sum('amount'),
            'total_withdrawn' => abs($transactions->where('type', 'withdrawal')->sum('amount')),
            'transaction_count' => $transactions->count(),
        ];
    }
}
