<?php

namespace App\Http\Controllers;

use App\Models\SecondaryMarketplaceListing;
use App\Models\CrowdfundingInvestment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecondaryMarketplaceController extends Controller
{
    public function index()
    {
        $listings = SecondaryMarketplaceListing::with('investment.crowdfundingProject.property', 'seller')
            ->where('status', 'active')
            ->latest()
            ->paginate(12);

        return view('secondary-marketplace.index', compact('listings'));
    }

    public function create(Request $request)
    {
        $investment = CrowdfundingInvestment::findOrFail($request->investment_id);
        // Add authorization logic here to ensure the user owns the investment
        $this->authorize('sell', $investment);

        return view('secondary-marketplace.create', compact('investment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'investment_id' => 'required|exists:crowdfunding_investments,id',
            'shares' => 'required|integer|min:1',
            'price_per_share' => 'required|numeric|min:0',
        ]);

        $investment = CrowdfundingInvestment::findOrFail($request->investment_id);
        $this->authorize('sell', $investment);

        if ($request->shares > $investment->shares_purchased) {
            return back()->with('error', 'You cannot sell more shares than you own.');
        }

        $listing = SecondaryMarketplaceListing::create([
            'crowdfunding_investment_id' => $investment->id,
            'seller_id' => Auth::id(),
            'shares_on_sale' => $request->shares,
            'price_per_share' => $request->price_per_share,
        ]);

        return redirect()->route('secondary-marketplace.index')->with('success', 'Your shares have been listed for sale.');
    }

    public function show(SecondaryMarketplaceListing $listing)
    {
        $listing->load('investment.crowdfundingProject.property', 'seller');
        return view('secondary-marketplace.show', compact('listing'));
    }

    public function buy(Request $request, SecondaryMarketplaceListing $listing)
    {
        $request->validate([
            'shares' => 'required|integer|min:1|' . $listing->shares_on_sale,
        ]);

        $buyer = Auth::user();
        $sharesToBuy = $request->shares;
        $totalCost = $sharesToBuy * $listing->price_per_share;

        if ($buyer->wallet->balance < $totalCost) {
            return back()->with('error', 'Insufficient funds.');
        }

        // Transfer funds
        $seller = $listing->seller;
        $buyer->wallet->balance -= $totalCost;
        $seller->wallet->balance += $totalCost;
        $buyer->wallet->save();
        $seller->wallet->save();

        // Create transactions
        Transaction::create([
            'user_id' => $buyer->id,
            'wallet_id' => $buyer->wallet->id,
            'type' => 'buy_shares',
            'amount' => $totalCost,
            'description' => 'Bought ' . $sharesToBuy . ' shares from ' . $seller->name,
            'status' => 'completed',
        ]);

        Transaction::create([
            'user_id' => $seller->id,
            'wallet_id' => $seller->wallet->id,
            'type' => 'sell_shares',
            'amount' => $totalCost,
            'description' => 'Sold ' . $sharesToBuy . ' shares to ' . $buyer->name,
            'status' => 'completed',
        ]);

        // Update listing
        $listing->shares_on_sale -= $sharesToBuy;
        if ($listing->shares_on_sale == 0) {
            $listing->status = 'sold';
        }
        $listing->save();

        // Transfer ownership of shares
        $sellerInvestment = $listing->investment;
        $sellerInvestment->shares_purchased -= $sharesToBuy;
        $sellerInvestment->save();

        $buyerInvestment = CrowdfundingInvestment::firstOrNew([
            'user_id' => $buyer->id,
            'crowdfunding_project_id' => $listing->investment->crowdfunding_project_id,
        ]);

        $buyerInvestment->shares_purchased += $sharesToBuy;
        $buyerInvestment->amount_invested += $totalCost; // This might need adjustment based on how you track investment value
        $buyerInvestment->price_per_share = $listing->price_per_share;
        $buyerInvestment->status = 'confirmed';
        $buyerInvestment->confirmed_at = now();
        $buyerInvestment->save();

        return redirect()->route('secondary-marketplace.index')->with('success', 'You have successfully purchased the shares.');
    }
}
