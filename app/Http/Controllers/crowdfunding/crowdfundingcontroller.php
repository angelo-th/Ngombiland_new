<?php

namespace App\Http\Controllers\Crowdfunding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Investment;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Wallet;

class CrowdfundingController extends Controller
{
    public function index()
    {
        $projects = Property::where('is_crowdfundable', true)->with('investments')->get();
        return view('crowdfunding.index', compact('projects'));
    }

    public function invest(Request $request, Property $property)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000'
        ]);

        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet || $wallet->balance < $request->amount) {
            return back()->with('error', 'Insufficient wallet balance.');
        }

        DB::transaction(function () use ($request, $property, $user, $wallet) {
            // Débiter le portefeuille
            $wallet->balance -= $request->amount;
            $wallet->save();

            // Créer la transaction
            \App\Models\Transaction::create([
                'user_id' => $user->id,
                'type' => 'investment',
                'amount' => $request->amount,
                'status' => 'completed',
                'reference' => \Illuminate\Support\Str::uuid(),
            ]);

            // Créer l'investissement
            Investment::create([
                'user_id' => $user->id,
                'property_id' => $property->id,
                'amount' => $request->amount,
                'roi' => $property->expected_roi,
                'status' => 'active',
                'investment_date' => now(),
            ]);
        });

        return back()->with('success', "Investment successful for {$property->title}.");
    }

    public function calculateROI(Property $property)
    {
        $roiPercentage = $property->expected_roi ?? 0;
        return response()->json(['roi_percentage' => $roiPercentage], 200);
    }

    public function userInvestments(Request $request)
    {
        try {
            $user = Auth::user();
            $investments = $user->investments()->with('property')->get();
            return view('crowdfunding.my_investments', compact('investments'));
        } catch (\Exception $e) {
            \Log::error('Error in userInvestments: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
        }
    }
}