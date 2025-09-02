<?php

namespace App\Http\Controllers\Crowdfunding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Investment;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class CrowdfundingController extends Controller
{
    // Show crowdfunding projects
    public function index()
    {
        $projects = Property::where('is_crowdfundable', true)->with('investments')->get();
        return view('crowdfunding.index', compact('projects'));
    }

    // Invest in a project
    public function invest(Request $request, Property $property)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000'
        ]);

        // Check if user has enough wallet balance
        $walletBalance = Auth::user()->walletBalance();

        if($walletBalance < $request->amount){
            return back()->with('error', 'Insufficient wallet balance.');
        }

        // Deduct wallet balance (Transaction)
        $transaction = Auth::user()->debitWallet($request->amount, "Investment in {$property->title}");

        // Record investment
        Investment::create([
            'user_id' => Auth::id(),
            'property_id' => $property->id,
            'amount' => $request->amount,
            'roi' => $property->expected_roi,
        ]);

        return back()->with('success', "Investment successful for {$property->title}.");
    }
}
// app/Http/Controllers/CrowdfundingController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investment;
use App\Models\Wallet;
use App\Models\Property;
use Illuminate\Support\Facades\DB;

class CrowdfundingController extends Controller
{
    // Invest in a property
    public function invest(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $wallet = Wallet::where('user_id', $request->user_id)->firstOrFail();

        if($wallet->balance < $request->amount){
            return response()->json(['error' => 'Insufficient balance'], 400);
        }

        DB::transaction(function () use ($request, $wallet) {
            // Deduct from wallet
            $wallet->balance -= $request->amount;
            $wallet->save();

            // Create investment record
            Investment::create([
                'user_id' => $request->user_id,
                'property_id' => $request->property_id,
                'amount' => $request->amount,
                'status' => 'active'
            ]);
        });

        return response()->json(['message' => 'Investment successful'], 200);
    }

    // Calculate ROI for a property
    public function calculateROI($propertyId)
    {
        $investments = Investment::where('property_id', $propertyId)->where('status', 'active')->get();
        $totalInvestment = $investments->sum('amount');
        $roiPercentage = 10; // Example: fixed 10% ROI

        foreach($investments as $investment){
            $investment->roi = ($investment->amount / $totalInvestment) * $roiPercentage;
            $investment->save();
        }

        return response()->json(['message' => 'ROI calculated successfully'], 200);
    }

    // Get user's investments
    public function userInvestments($userId)
    {
        $investments = Investment::with('property')->where('user_id', $userId)->get();
        return response()->json($investments, 200);
    }
}
// app/Http/Controllers/CrowdfundingController.php