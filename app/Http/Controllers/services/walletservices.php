<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;

class WalletService
{
    // Top-up user wallet
    public function topUp(User $user, float $amount, string $provider)
    {
        // Call MTN or Orange Money API here
        // This is a placeholder for API integration
        $success = $this->callProviderAPI($user, $amount, $provider, 'topup');

        if ($success) {
            $user->wallet_balance += $amount;
            $user->save();

            // Record transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'topup',
                'amount' => $amount,
                'status' => 'completed',
                'provider' => $provider
            ]);

            return true;
        }

        return false;
    }

    // Withdraw from user wallet
    public function withdraw(User $user, float $amount, string $provider)
    {
        if ($user->wallet_balance < $amount) {
            return false; // Insufficient balance
        }

        $success = $this->callProviderAPI($user, $amount, $provider, 'withdraw');

        if ($success) {
            $user->wallet_balance -= $amount;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdraw',
                'amount' => $amount,
                'status' => 'completed',
                'provider' => $provider
            ]);

            return true;
        }

        return false;
    }

    // Simulate provider API call
    private function callProviderAPI(User $user, float $amount, string $provider, string $action)
    {
        // TODO: Implement real API call to MTN / Orange Money
        // Currently returns true for testing
        return true;
    }
}
// Example usage:
$walletService = new WalletService();
$user = User::find(1); // Get user by ID

// Top-up wallet
$walletService->topUp($user, 100.0, 'mtn');

// Withdraw from wallet
$walletService->withdraw($user, 50.0, 'orange');