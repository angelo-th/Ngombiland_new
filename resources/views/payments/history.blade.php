@extends('layouts.app')

@section('title', 'Historique des Transactions - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('payments.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Historique des Transactions</h1>
                            <p class="text-gray-600">Consultez toutes vos transactions</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
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
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtres</h3>
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type de transaction</label>
                    <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tous les types</option>
                        <option value="credit" {{ request('type') === 'credit' ? 'selected' : '' }}>Crédit</option>
                        <option value="debit" {{ request('type') === 'debit' ? 'selected' : '' }}>Débit</option>
                        <option value="rental_income" {{ request('type') === 'rental_income' ? 'selected' : '' }}>Revenus locatifs</option>
                        <option value="investment" {{ request('type') === 'investment' ? 'selected' : '' }}>Investissement</option>
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tous les statuts</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Terminé</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Échoué</option>
                    </select>
                </div>
                
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
                    <input type="date" name="date_from" id="date_from" 
                           value="{{ request('date_from') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Filtrer
                    </button>
                </div>
            </form>
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
                        <p class="text-sm font-medium text-gray-500">Total crédité</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ number_format($transactions->where('type', 'credit')->sum('amount')) }} FCFA
                        </p>
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
                        <p class="text-sm font-medium text-gray-500">Total débité</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ number_format($transactions->where('type', 'debit')->sum('amount')) }} FCFA
                        </p>
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
                        <p class="text-sm font-medium text-gray-500">Revenus locatifs</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ number_format($transactions->where('type', 'rental_income')->sum('amount')) }} FCFA
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-list text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total transactions</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $transactions->total() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des transactions -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Transactions</h2>
            </div>

            @if($transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($transactions as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $transaction->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($transaction->type === 'credit') bg-green-100 text-green-800
                                        @elseif($transaction->type === 'debit') bg-red-100 text-red-800
                                        @elseif($transaction->type === 'rental_income') bg-blue-100 text-blue-800
                                        @elseif($transaction->type === 'investment') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        @if($transaction->type === 'credit') Crédit
                                        @elseif($transaction->type === 'debit') Débit
                                        @elseif($transaction->type === 'rental_income') Revenus locatifs
                                        @elseif($transaction->type === 'investment') Investissement
                                        @else {{ ucfirst($transaction->type) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $transaction->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="@if($transaction->type === 'credit' || $transaction->type === 'rental_income') text-green-600 @else text-red-600 @endif">
                                        @if($transaction->type === 'credit' || $transaction->type === 'rental_income') + @else - @endif
                                        {{ number_format($transaction->amount) }} FCFA
                                    </span>
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
                                    {{ $transaction->reference ?? '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-receipt text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune transaction trouvée</h3>
                    <p class="text-gray-600">Aucune transaction ne correspond à vos critères de recherche.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
