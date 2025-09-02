<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    // Display user wallet balance
    public function index()
    {
        $user = Auth::user();
        return view('dashboard.wallet.index', [
            'balance' => $user->wallet_balance,
            'transactions' => $user->transactions()->latest()->get()
        ]);
    }

    // Top-up wallet via external API (MTN / Orange)
    public function topUp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100'
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        // Call external API (pseudo-example)
        $response = Http::post('https://api.mobilemoney.com/topup', [
            'phone' => $user->phone,
            'amount' => $amount,
            'currency' => 'XAF'
        ]);

        if ($response->successful()) {
            $user->wallet_balance += $amount;
            $user->save();

            // Save transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'topup',
                'amount' => $amount,
                'status' => 'completed'
            ]);

            return response()->json(['success' => true, 'message' => 'Wallet topped up successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Payment failed'], 400);
    }

    // Withdraw from wallet
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100'
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        if ($user->wallet_balance < $amount) {
            return response()->json(['success' => false, 'message' => 'Insufficient balance'], 400);
        }

        // Call external API for payout (pseudo-example)
        $response = Http::post('https://api.mobilemoney.com/withdraw', [
            'phone' => $user->phone,
            'amount' => $amount,
            'currency' => 'XAF'
        ]);

        if ($response->successful()) {
            $user->wallet_balance -= $amount;
            $user->save();

            // Save transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdraw',
                'amount' => $amount,
                'status' => 'completed'
            ]);

            return response()->json(['success' => true, 'message' => 'Withdrawal successful']);
        }

        return response()->json(['success' => false, 'message' => 'Withdrawal failed'], 400);
    }

    // Deduct 1% commission for platform on a transaction
    public function deductCommission($walletId, $amount)
    {
        $commission = $amount * 0.01;
        $wallet = Wallet::findOrFail($walletId);
        $wallet->balance -= $commission;
        $wallet->save();

        Transaction::create([
            'wallet_id' => $wallet->id,
            'type' => 'commission',
            'amount' => $commission,
            'status' => 'completed',
            'reference' => Str::uuid(),
        ]);

        return $commission;
    }
}