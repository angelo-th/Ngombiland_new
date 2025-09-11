<?php

namespace App\Http\Controllers;

use App\Models\Message;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        // Statistiques de l'utilisateur
        $stats = [
            'properties_count' => $user->properties()->count(),
            'investments_count' => $user->investments()->count(),
            'unread_messages' => Message::where('receiver_id', $user->id)->where('read', false)->count(),
            'wallet_balance' => $user->wallet ? $user->wallet->balance : 0,
        ];

        // Propriétés récentes de l'utilisateur
        $recent_properties = $user->properties()->latest()->take(5)->get();

        // Investissements récents
        $recent_investments = $user->investments()->with('property')->latest()->take(5)->get();

        // Messages récents
        $recent_messages = Message::where('receiver_id', $user->id)
            ->with('sender')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_properties', 'recent_investments', 'recent_messages'));
    }
}
