<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class CommissionController extends Controller
{
    // Show commissions overview
    public function index()
    {
        // Fetch all transactions and calculate platform commission (1%)
        $transactions = Transaction::orderBy('created_at', 'desc')->get();

        $totalCommission = $transactions->sum(function ($txn) {
            return $txn->amount * 0.01; // 1% commission
        });

        return view('admin.commissions.index', compact('transactions', 'totalCommission'));
    }

    // Export commission report (CSV)
    public function exportCsv()
    {
        $transactions = Transaction::all();
        $csvHeader = ['ID', 'User', 'Type', 'Amount', 'Commission', 'Date'];
        $csvData = $transactions->map(function ($txn) {
            return [
                $txn->id,
                $txn->user->name ?? 'Unknown',
                $txn->type,
                $txn->amount,
                $txn->amount * 0.01,
                $txn->created_at->format('d/m/Y H:i'),
            ];
        });

        $filename = 'commission_report_'.now()->format('Ymd_His').'.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, $csvHeader);

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
