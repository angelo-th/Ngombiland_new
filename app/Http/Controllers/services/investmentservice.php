<?php

namespace App\Services;

use App\Models\Investment;
use App\Models\Property;
use App\Models\User;

class InvestmentService
{
    // Invest in a property
    public function invest(User $user, Property $property, float $amount)
    {
        // Check user wallet
        if ($user->wallet_balance < $amount) {
            return false; // Not enough balance
        }

        // Deduct wallet balance
        $user->wallet_balance -= $amount;
        $user->save();

        // Create investment record
        Investment::create([
            'user_id' => $user->id,
            'property_id' => $property->id,
            'amount' => $amount,
            'roi' => $this->calculateROI($property, $amount),
        ]);

        return true;
    }

    // Calculate ROI (simplified)
    private function calculateROI(Property $property, float $amount)
    {
        $roiPercentage = 0.12; // 12% annual return as example

        return $amount * $roiPercentage;
    }
}
