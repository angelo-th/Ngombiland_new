<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Afficher la page de paiement
     */
    public function index()
    {
        $userId = Auth::id();
        $wallet = Auth::user()->wallet;
        $stats = $this->paymentService->getPaymentStats($userId);
        $recentTransactions = $this->paymentService->getPaymentHistory($userId, 10);

        return view('payments.index', compact('wallet', 'stats', 'recentTransactions'));
    }

    /**
     * Afficher le formulaire de rechargement
     */
    public function showTopupForm()
    {
        return view('payments.topup');
    }

    /**
     * Traiter un rechargement
     */
    public function topup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'method' => 'required|in:mobile_money,manual',
            'phone_number' => 'required_if:method,mobile_money|string|min:9',
            'provider' => 'required_if:method,mobile_money|in:MTN,Orange,Express Union',
        ]);

        try {
            $userId = Auth::id();
            $amount = $request->amount;

            if ($request->method === 'mobile_money') {
                $transaction = $this->paymentService->simulateMobileMoneyPayment(
                    $userId,
                    $amount,
                    $request->phone_number,
                    $request->provider
                );

                return redirect()->route('payments.index')
                    ->with('success', 'Paiement Mobile Money en cours de traitement...');
            } else {
                $transaction = $this->paymentService->topupWallet(
                    $userId,
                    $amount,
                    'manual',
                    'Rechargement manuel'
                );

                return redirect()->route('payments.index')
                    ->with('success', 'Portefeuille rechargé avec succès !');
            }

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Afficher le formulaire de retrait
     */
    public function showWithdrawForm()
    {
        return view('payments.withdraw');
    }

    /**
     * Traiter un retrait
     */
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'method' => 'required|in:mobile_money,bank_transfer',
            'phone_number' => 'required_if:method,mobile_money|string|min:9',
            'bank_account' => 'required_if:method,bank_transfer|string',
        ]);

        try {
            $userId = Auth::id();
            $amount = $request->amount;

            $transaction = $this->paymentService->withdrawFromWallet(
                $userId,
                $amount,
                $request->method,
                "Retrait via {$request->method}"
            );

            return redirect()->route('payments.index')
                ->with('success', 'Retrait effectué avec succès !');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Afficher l'historique des transactions
     */
    public function history()
    {
        $userId = Auth::id();
        $transactions = $this->paymentService->getPaymentHistory($userId, 50);

        return view('payments.history', compact('transactions'));
    }

    /**
     * API pour obtenir le solde du portefeuille
     */
    public function getBalance()
    {
        $wallet = Auth::user()->wallet;
        
        return response()->json([
            'balance' => $wallet ? $wallet->balance : 0,
            'currency' => 'XAF'
        ]);
    }

    /**
     * API pour vérifier si un paiement est possible
     */
    public function checkPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $wallet = Auth::user()->wallet;
        $canPay = $wallet && $wallet->balance >= $request->amount;

        return response()->json([
            'can_pay' => $canPay,
            'current_balance' => $wallet ? $wallet->balance : 0,
            'required_amount' => $request->amount,
            'shortfall' => $canPay ? 0 : $request->amount - ($wallet ? $wallet->balance : 0)
        ]);
    }
}
