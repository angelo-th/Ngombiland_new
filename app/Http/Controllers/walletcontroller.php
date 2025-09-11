<?php

namespace App\Http\Controllers;

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
        $wallet = $user->wallet;
        $balance = $wallet ? $wallet->balance : 0;
        
        return view('wallet.index', [
            'balance' => $balance,
            'transactions' => $user->transactions()->latest()->get()
        ]);
    }

    // Show topup form
    public function showTopupForm()
    {
        return view('wallet.topup');
    }

    // Show withdraw form
    public function showWithdrawForm()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        $balance = $wallet ? $wallet->balance : 0;
        
        return view('wallet.withdraw', compact('balance'));
    }

    // Top-up wallet via external API (MTN / Orange)
    public function topup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100'
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        // Call external API (pseudo-example)
        // For testing purposes, simulate successful response
        $response = app()->environment('testing')
            ? (object) ['successful' => true]
            : Http::post('https://api.mobilemoney.com/topup', [
                'phone' => $user->phone,
                'amount' => $amount,
                'currency' => 'XAF'
            ]);

        if (app()->environment('testing') || $response->successful()) {
            $wallet = $user->wallet;
            $wallet->balance += $amount;
            $wallet->save();

            // Save transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'topup',
                'amount' => $amount,
                'status' => 'completed',
                'reference' => \Illuminate\Support\Str::uuid(),
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

        $wallet = $user->wallet;
        if ($wallet->balance < $amount) {
            return response()->json(['success' => false, 'message' => 'Insufficient balance'], 400);
        }

        // Call external API for payout (pseudo-example)
        // For testing purposes, simulate successful response
        $response = app()->environment('testing')
            ? (object) ['successful' => true]
            : Http::post('https://api.mobilemoney.com/withdraw', [
                'phone' => $user->phone,
                'amount' => $amount,
                'currency' => 'XAF'
            ]);

        if (app()->environment('testing') || $response->successful()) {
            $wallet->balance -= $amount;
            $wallet->save();

            // Save transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdraw',
                'amount' => $amount,
                'status' => 'completed',
                'reference' => \Illuminate\Support\Str::uuid(),
            ]);

            return response()->json(['success' => true, 'message' => 'Withdrawal successful']);
        }

        return response()->json(['success' => false, 'message' => 'Withdrawal failed'], 400);
    }

    // Deduct 1% commission for platform on a transaction
    public function deductCommission($walletId, $amount)
    {
        $commission = $amount * 0.01;
        $wallet = \App\Models\Wallet::findOrFail($walletId);
        $wallet->balance -= $commission;
        $wallet->save();

        Transaction::create([
            'user_id' => $wallet->user_id,
            'type' => 'commission',
            'amount' => $commission,
            'status' => 'completed',
            'reference' => \Illuminate\Support\Str::uuid(),
        ]);

        return $commission;
    }
}