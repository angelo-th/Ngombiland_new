<?php

// ⚡ API simulation pour gérer Wallet (TopUp et Withdraw)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $amount = (int) ($_POST['amount'] ?? 0);
    $balance = 125750; // Exemple : solde initial

    if ($action === 'recharge') {
        $balance += $amount;
        echo json_encode([
            'status' => 'success',
            'message' => 'Top up successful',
            'newBalance' => $balance,
        ]);
    } elseif ($action === 'withdraw') {
        if ($amount > $balance) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Insufficient funds',
            ]);
        } else {
            $balance -= $amount;
            echo json_encode([
                'status' => 'success',
                'message' => 'Withdrawal request submitted',
                'newBalance' => $balance,
            ]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
}
// Example: send top-up request to MTN API
$response = Http::post(env('MTN_API_URL').'/topup', [
    'phone' => $user->phone,
    'amount' => $amount,
    'reference' => $tx->reference,
]);
