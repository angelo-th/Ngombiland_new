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
                    <p class="text-gray-600">Gérez vos finances et vos transactions</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('payments.topup') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Alimenter
                    </a>
                    <a href="{{ route('payments.withdraw') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-minus mr-2"></i>
                        Retirer
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Solde actuel -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold mb-2">Solde Actuel</h2>
                    <p class="text-4xl font-bold">{{ number_format(auth()->user()->wallet->balance ?? 0) }} FCFA</p>
                </div>
                <div class="text-right">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-wallet text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-arrow-up text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Dépôts</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format(auth()->user()->transactions()->where('type', 'deposit')->sum('amount') ?? 0) }} FCFA</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-arrow-down text-red-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Retraits</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format(auth()->user()->transactions()->where('type', 'withdrawal')->sum('amount') ?? 0) }} FCFA</p>
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
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format(auth()->user()->transactions()->where('type', 'investment')->sum('amount') ?? 0) }} FCFA</p>
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
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format(auth()->user()->transactions()->where('type', 'income')->sum('amount') ?? 0) }} FCFA</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions Rapides</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('payments.topup') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-plus text-green-600 mr-3 text-xl"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Alimenter le portefeuille</h4>
                        <p class="text-sm text-gray-600">Ajouter des fonds via Mobile Money</p>
                    </div>
                </a>

                <a href="{{ route('payments.withdraw') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="fas fa-minus text-blue-600 mr-3 text-xl"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Retirer des fonds</h4>
                        <p class="text-sm text-gray-600">Transférer vers votre compte</p>
                    </div>
                </a>

                <a href="{{ route('payments.history') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-history text-gray-600 mr-3 text-xl"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Historique</h4>
                        <p class="text-sm text-gray-600">Voir toutes les transactions</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Transactions récentes -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Transactions Récentes</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse(auth()->user()->transactions()->latest()->take(10)->get() as $transaction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center
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
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 capitalize">{{ $transaction->type }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-900">{{ $transaction->description }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-semibold 
                                    @if($transaction->type === 'deposit' || $transaction->type === 'income') text-green-600
                                    @elseif($transaction->type === 'withdrawal' || $transaction->type === 'investment') text-red-600
                                    @else text-gray-900
                                    @endif">
                                    @if($transaction->type === 'deposit' || $transaction->type === 'income') +
                                    @elseif($transaction->type === 'withdrawal' || $transaction->type === 'investment') -
                                    @endif
                                    {{ number_format($transaction->amount) }} FCFA
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <i class="fas fa-wallet text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500">Aucune transaction pour le moment</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(auth()->user()->transactions()->count() > 10)
            <div class="mt-4 text-center">
                <a href="{{ route('payments.history') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Voir toutes les transactions →
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection