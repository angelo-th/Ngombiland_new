<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        // Créer un portefeuille s'il n'existe pas
        if (!$user->wallet) {
            $user->wallet()->create(['balance' => 0]);
        }

        return view('payments.index');
    }

    public function showTopupForm()
    {
        return view('payments.topup');
    }

    public function topup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'payment_method' => 'required|in:mtn,orange,express',
            'phone' => 'required|string|regex:/^6[0-9]{8}$/',
        ]);

        $user = Auth::user();
        $amount = $request->amount;
        $fees = max($amount * 0.01, 100); // 1% avec minimum 100 FCFA
        $total = $amount + $fees;

        try {
            DB::beginTransaction();

            // Créer le portefeuille s'il n'existe pas
            if (!$user->wallet) {
                $user->wallet()->create(['balance' => 0]);
            }

            // Créer la transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'wallet_id' => $user->wallet->id,
                'type' => 'deposit',
                'amount' => $amount,
                'description' => 'Alimentation du portefeuille via ' . strtoupper($request->payment_method),
                'status' => 'pending',
                'metadata' => [
                    'payment_method' => $request->payment_method,
                    'phone' => $request->phone,
                    'fees' => $fees,
                    'total_paid' => $total,
                ],
            ]);

            // Simuler le processus de paiement (dans un vrai projet, intégrer avec l'API de paiement)
            $this->processPayment($transaction, $request->payment_method, $request->phone, $total);

            DB::commit();

            return redirect()->route('payments.index')
                ->with('success', 'Transaction en cours de traitement. Votre portefeuille sera crédité une fois le paiement confirmé.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors du traitement de votre demande.');
        }
    }

    public function showWithdrawForm()
    {
        return view('payments.withdraw');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'payment_method' => 'required|in:mtn,orange,express',
            'phone' => 'required|string|regex:/^6[0-9]{8}$/',
        ]);

        $user = Auth::user();
        $amount = $request->amount;
        $fees = max($amount * 0.01, 100); // 1% avec minimum 100 FCFA
        $total = $amount + $fees;

        // Vérifier que l'utilisateur a suffisamment de fonds
        if ($user->wallet->balance < $total) {
            return back()->with('error', 'Solde insuffisant. Vous devez avoir au moins ' . number_format($total) . ' FCFA.');
        }

        try {
            DB::beginTransaction();

            // Créer la transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'wallet_id' => $user->wallet->id,
                'type' => 'withdrawal',
                'amount' => $amount,
                'description' => 'Retrait du portefeuille vers ' . strtoupper($request->payment_method),
                'status' => 'pending',
                'metadata' => [
                    'payment_method' => $request->payment_method,
                    'phone' => $request->phone,
                    'fees' => $fees,
                    'total_deducted' => $total,
                ],
            ]);

            // Débiter le portefeuille
            $user->wallet->balance -= $total;
            $user->wallet->save();

            // Simuler le processus de retrait
            $this->processWithdrawal($transaction, $request->payment_method, $request->phone, $amount);

            DB::commit();

            return redirect()->route('payments.index')
                ->with('success', 'Demande de retrait en cours de traitement. Les fonds seront transférés dans les 24h.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors du traitement de votre demande.');
        }
    }

    public function history()
    {
        $transactions = Auth::user()->transactions()
            ->latest()
            ->paginate(20);

        return view('payments.history', compact('transactions'));
    }

    public function getBalance()
    {
        $user = Auth::user();
        return response()->json([
            'balance' => $user->wallet ? $user->wallet->balance : 0
        ]);
    }

    public function checkPayment(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id'
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);
        
        // Vérifier que la transaction appartient à l'utilisateur
        if ($transaction->user_id !== Auth::id()) {
            return response()->json(['error' => 'Transaction non trouvée'], 404);
        }

        return response()->json([
            'status' => $transaction->status,
            'amount' => $transaction->amount,
            'description' => $transaction->description,
            'created_at' => $transaction->created_at->format('d/m/Y H:i'),
        ]);
    }

    private function processPayment($transaction, $method, $phone, $amount)
    {
        // Dans un vrai projet, intégrer avec l'API de paiement mobile
        // Pour la démo, on simule un succès après 5 secondes
        
        // Simuler le délai de traitement
        sleep(2);
        
        // Marquer comme terminé
        $transaction->update(['status' => 'completed']);
        
        // Créditer le portefeuille
        $transaction->wallet->balance += $transaction->amount;
        $transaction->wallet->save();
    }

    private function processWithdrawal($transaction, $method, $phone, $amount)
    {
        // Dans un vrai projet, intégrer avec l'API de paiement mobile
        // Pour la démo, on simule un succès après 2 secondes
        
        // Simuler le délai de traitement
        sleep(1);
        
        // Marquer comme terminé
        $transaction->update(['status' => 'completed']);
    }
}