@extends('layouts.app')

@section('title', 'Paiements et Portefeuille')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-wallet mr-3 text-primary-600"></i>
            Mon Portefeuille
        </h1>
        <div class="flex space-x-3">
            <a href="{{ route('payments.topup') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Recharger
            </a>
            <a href="{{ route('payments.withdraw') }}" class="btn btn-outline">
                <i class="fas fa-minus mr-2"></i>
                Retirer
            </a>
        </div>
    </div>

    <!-- Solde du portefeuille -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg shadow-lg p-8 mb-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold mb-2">Solde Actuel</h2>
                <p class="text-4xl font-bold">{{ number_format($wallet ? $wallet->balance : 0, 0, ',', ' ') }} FCFA</p>
                <p class="text-primary-100 mt-2">Portefeuille numérique sécurisé</p>
            </div>
            <div class="text-right">
                <i class="fas fa-shield-alt text-6xl text-primary-200"></i>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-arrow-up text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Reçu</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_received'], 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-arrow-down text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Investi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format(abs($stats['total_invested']), 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-plus text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Rechargé</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_topup'], 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-exchange-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Transactions</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['transaction_count'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Actions rapides -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-bolt mr-2 text-yellow-600"></i>
                Actions Rapides
            </h3>
            
            <div class="space-y-4">
                <a href="{{ route('secondary-market.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg mr-4">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Marketplace Secondaire</h4>
                        <p class="text-sm text-gray-600">Acheter ou vendre des parts</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
                </a>

                <a href="{{ route('crowdfunding.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="p-2 bg-green-100 text-green-600 rounded-lg mr-4">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Investir</h4>
                        <p class="text-sm text-gray-600">Découvrir de nouveaux projets</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
                </a>

                <a href="{{ route('rental-distribution.user-history') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="p-2 bg-purple-100 text-purple-600 rounded-lg mr-4">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Mes Revenus</h4>
                        <p class="text-sm text-gray-600">Voir mes revenus locatifs</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
                </a>
            </div>
        </div>

        <!-- Transactions récentes -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-history mr-2 text-gray-600"></i>
                    Transactions Récentes
                </h3>
                <a href="{{ route('payments.history') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Voir tout
                </a>
            </div>
            
            @if($recentTransactions->count() > 0)
                <div class="space-y-3">
                    @foreach($recentTransactions as $transaction)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-full {{ $transaction->amount > 0 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                <i class="fas fa-{{ $transaction->amount > 0 ? 'arrow-up' : 'arrow-down' }} text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ $transaction->description }}</p>
                                <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold {{ $transaction->amount > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->amount > 0 ? '+' : '' }}{{ number_format($transaction->amount, 0, ',', ' ') }} FCFA
                            </p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $transaction->status === 'completed' ? 'Terminé' : 
                                   ($transaction->status === 'pending' ? 'En cours' : 'Échoué') }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-receipt text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600">Aucune transaction récente</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
