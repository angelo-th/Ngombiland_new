<?php

namespace App\Services;

use App\Models\CrowdfundingProject;
use App\Models\RentalDistribution;
use App\Models\Transaction;

class RentalDistributionService
{
    public function distributeRent(CrowdfundingProject $project, float $totalRent)
    {
        $investors = $project->investments()->with('user.wallet')->confirmed()->get();
        $totalShares = $project->total_shares;
        $rentToDistribute = $totalRent * 0.7;

        $distribution = RentalDistribution::create([
            'crowdfunding_project_id' => $project->id,
            'total_rent_amount' => $totalRent,
            'distributed_amount' => $rentToDistribute,
            'distribution_date' => now(),
        ]);

        foreach ($investors as $investment) {
            $user = $investment->user;
            $userShare = $investment->shares_purchased / $totalShares;
            $userRent = $rentToDistribute * $userShare;

            if ($user->wallet) {
                $user->wallet->balance += $userRent;
                $user->wallet->save();

                Transaction::create([
                    'user_id' => $user->id,
                    'wallet_id' => $user->wallet->id,
                    'type' => 'rental_income',
                    'amount' => $userRent,
                    'description' => 'Rental income from ' . $project->title,
                    'status' => 'completed',
                ]);

                $distribution->details()->create([
                    'user_id' => $user->id,
                    'investment_id' => $investment->id,
                    'shares_owned' => $investment->shares_purchased,
                    'amount_received' => $userRent,
                ]);
            }
        }

        return $distribution;
    }
}