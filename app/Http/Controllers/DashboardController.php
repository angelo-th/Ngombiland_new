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

        // Rediriger selon le rôle de l'utilisateur
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'agent':
                return redirect()->route('agent.dashboard');
            case 'proprietor':
                return $this->proprietorDashboard();
            case 'investor':
                return $this->investorDashboard();
            case 'client':
            default:
                return $this->clientDashboard();
        }
    }

    public function agentDashboard()
    {
        $user = auth()->user();

        // Vérifier que l'utilisateur est un agent
        if ($user->role !== 'agent') {
            abort(403, 'Accès non autorisé');
        }

        // Statistiques spécifiques aux agents
        $stats = [
            'properties_count' => $user->properties()->count(),
            'investments_count' => $user->investments()->count(),
            'unread_messages' => Message::where('receiver_id', $user->id)->where('read', false)->count(),
            'wallet_balance' => $user->wallet ? $user->wallet->balance : 0,
            'clients_count' => 0, // À implémenter selon vos besoins
            'commission_earned' => 0, // À implémenter selon vos besoins
        ];

        // Propriétés récentes de l'agent
        $recent_properties = $user->properties()->latest()->take(5)->get();

        // Investissements récents
        $recent_investments = $user->investments()->with('property')->latest()->take(5)->get();

        // Messages récents
        $recent_messages = Message::where('receiver_id', $user->id)
            ->with('sender')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.agent', compact('stats', 'recent_properties', 'recent_investments', 'recent_messages'));
    }

    public function proprietorDashboard()
    {
        $user = auth()->user();

        // Vérifier que l'utilisateur est un propriétaire
        if ($user->role !== 'proprietor') {
            abort(403, 'Accès non autorisé');
        }

        // Statistiques spécifiques aux propriétaires
        $stats = [
            'properties_count' => $user->properties()->count(),
            'investments_count' => $user->investments()->count(),
            'unread_messages' => Message::where('receiver_id', $user->id)->where('read', false)->count(),
            'wallet_balance' => $user->wallet ? $user->wallet->balance : 0,
        ];

        // Propriétés récentes du propriétaire
        $recent_properties = $user->properties()->latest()->take(5)->get();

        // Investissements récents
        $recent_investments = $user->investments()->with('property')->latest()->take(5)->get();

        // Messages récents
        $recent_messages = Message::where('receiver_id', $user->id)
            ->with('sender')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.proprietor', compact('stats', 'recent_properties', 'recent_investments', 'recent_messages'));
    }

    public function investorDashboard()
    {
        $user = auth()->user();

        // Vérifier que l'utilisateur est un investisseur
        if ($user->role !== 'investor') {
            abort(403, 'Accès non autorisé');
        }

        // Statistiques spécifiques aux investisseurs
        $stats = [
            'properties_count' => $user->properties()->count(),
            'investments_count' => $user->investments()->count(),
            'unread_messages' => Message::where('receiver_id', $user->id)->where('read', false)->count(),
            'wallet_balance' => $user->wallet ? $user->wallet->balance : 0,
        ];

        // Propriétés récentes de l'investisseur
        $recent_properties = $user->properties()->latest()->take(5)->get();

        // Investissements récents
        $recent_investments = $user->investments()->with('property')->latest()->take(5)->get();

        // Messages récents
        $recent_messages = Message::where('receiver_id', $user->id)
            ->with('sender')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.investor', compact('stats', 'recent_properties', 'recent_investments', 'recent_messages'));
    }

    public function clientDashboard()
    {
        $user = auth()->user();

        // Statistiques spécifiques aux clients
        $stats = [
            'properties_count' => $user->properties()->count(),
            'investments_count' => $user->investments()->count(),
            'unread_messages' => Message::where('receiver_id', $user->id)->where('read', false)->count(),
            'wallet_balance' => $user->wallet ? $user->wallet->balance : 0,
        ];

        // Propriétés récentes du client
        $recent_properties = $user->properties()->latest()->take(5)->get();

        // Investissements récents
        $recent_investments = $user->investments()->with('property')->latest()->take(5)->get();

        // Messages récents
        $recent_messages = Message::where('receiver_id', $user->id)
            ->with('sender')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.client', compact('stats', 'recent_properties', 'recent_investments', 'recent_messages'));
    }
}
