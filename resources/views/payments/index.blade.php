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
                    <p class="text-gray-600">Gérez votre solde et vos transactions</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('payments.topup') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium">
                        <i class="fas fa-plus mr-2"></i>
                        Recharger
                    </a>
                    <a href="{{ route('payments.withdraw') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
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
                        <p class="text-sm font-medium text-gray-500">Solde actuel</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format(Auth::user()->wallet->balance ?? 0) }} FCFA</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-arrow-up text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total rechargé</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format(Auth::user()->transactions()->where('type', 'credit')->sum('amount')) }} FCFA</p>
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
                        <p class="text-sm font-medium text-gray-500">Total retiré</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format(Auth::user()->transactions()->where('type', 'debit')->sum('amount')) }} FCFA</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Revenus locatifs</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format(Auth::user()->transactions()->where('type', 'rental_income')->sum('amount')) }} FCFA</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Rechargement -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recharger mon portefeuille</h3>
                <p class="text-gray-600 mb-4">Ajoutez des fonds à votre portefeuille via Mobile Money ou d'autres méthodes de paiement.</p>
                <a href="{{ route('payments.topup') }}" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition-colors text-center block">
                    <i class="fas fa-plus mr-2"></i>
                    Recharger maintenant
                </a>
            </div>

            <!-- Retrait -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Retirer des fonds</h3>
                <p class="text-gray-600 mb-4">Retirez vos fonds vers votre compte Mobile Money ou votre compte bancaire.</p>
                <a href="{{ route('payments.withdraw') }}" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors text-center block">
                    <i class="fas fa-minus mr-2"></i>
                    Retirer maintenant
                </a>
            </div>
        </div>

        <!-- Historique des transactions -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Historique des transactions</h3>
                <a href="{{ route('payments.history') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Voir tout l'historique →
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($transaction->type === 'credit') bg-green-100 text-green-800
                                    @elseif($transaction->type === 'debit') bg-red-100 text-red-800
                                    @elseif($transaction->type === 'rental_income') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    @if($transaction->type === 'credit') Crédit
                                    @elseif($transaction->type === 'debit') Débit
                                    @elseif($transaction->type === 'rental_income') Revenus locatifs
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
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Aucune transaction trouvée
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection