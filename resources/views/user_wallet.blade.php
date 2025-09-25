@extends('layouts.app')

@section('title', 'Mon Portefeuille - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Mon Portefeuille</h1>
                    <p class="text-gray-600">Gérez vos finances et investissements</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('payments.topup') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Recharger
                    </a>
                    <a href="{{ route('payments.withdraw') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-minus mr-2"></i>
                        Retirer
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Solde et statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-wallet text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Solde Actuel</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($wallet->balance) }} FCFA</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Investissements</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($investments_total) }} FCFA</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-coins text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Revenus</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($income_total) }} FCFA</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-percentage text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">ROI Moyen</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $average_roi }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('payments.topup') }}" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-plus text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Recharger le Portefeuille</h3>
                        <p class="text-gray-600">Ajoutez des fonds via Mobile Money ou carte bancaire</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('payments.withdraw') }}" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-minus text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Retirer des Fonds</h3>
                        <p class="text-gray-600">Retirez vos gains vers votre compte bancaire</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('payments.history') }}" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-history text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Historique</h3>
                        <p class="text-gray-600">Consultez toutes vos transactions</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Mes investissements -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Mes Investissements</h2>
                <a href="{{ route('investments.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Voir tous
                </a>
            </div>
            
            <div class="space-y-4">
                @forelse($recent_investments as $investment)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-home text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">{{ $investment->property->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $investment->property->location }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900">{{ number_format($investment->amount) }} FCFA</p>
                        <p class="text-sm text-gray-500">ROI: {{ $investment->expected_roi }}%</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-chart-line text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Aucun investissement pour le moment</p>
                    <a href="{{ route('crowdfunding.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        Découvrir les projets
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Transactions récentes -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Transactions Récentes</h2>
                <a href="{{ route('payments.history') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Voir toutes
                </a>
            </div>
            
            <div class="space-y-4">
                @forelse($recent_transactions as $transaction)
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3
                            @if($transaction->type === 'deposit') bg-green-100
                            @elseif($transaction->type === 'withdrawal') bg-red-100
                            @elseif($transaction->type === 'investment') bg-blue-100
                            @elseif($transaction->type === 'income') bg-yellow-100
                            @else bg-gray-100
                            @endif">
                            <i class="fas 
                                @if($transaction->type === 'deposit') fa-arrow-up text-green-600
                                @elseif($transaction->type === 'withdrawal') fa-arrow-down text-red-600
                                @elseif($transaction->type === 'investment') fa-chart-line text-blue-600
                                @elseif($transaction->type === 'income') fa-coins text-yellow-600
                                @else fa-exchange-alt text-gray-600
                                @endif text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $transaction->description }}</p>
                            <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold 
                            @if($transaction->type === 'deposit' || $transaction->type === 'income') text-green-600
                            @elseif($transaction->type === 'withdrawal' || $transaction->type === 'investment') text-red-600
                            @else text-gray-900
                            @endif">
                            @if($transaction->type === 'deposit' || $transaction->type === 'income') +
                            @elseif($transaction->type === 'withdrawal' || $transaction->type === 'investment') -
                            @endif
                            {{ number_format($transaction->amount) }} FCFA
                        </p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($transaction->status === 'completed') bg-green-100 text-green-800
                            @elseif($transaction->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($transaction->status === 'failed') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            @if($transaction->status === 'completed') Terminé
                            @elseif($transaction->status === 'pending') En attente
                            @elseif($transaction->status === 'failed') Échoué
                            @else {{ ucfirst($transaction->status) }}
                            @endif
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-wallet text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Aucune transaction récente</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection