@extends('layouts.app')

@section('title', 'Historique des Transactions - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Historique des Transactions</h1>
                    <p class="text-gray-600">Consultez toutes vos transactions financières</p>
                </div>
                <a href="{{ route('payments.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour au portefeuille
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <form method="GET" action="{{ route('payments.history') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type de transaction</label>
                    <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les types</option>
                        <option value="deposit" {{ request('type') === 'deposit' ? 'selected' : '' }}>Dépôt</option>
                        <option value="withdrawal" {{ request('type') === 'withdrawal' ? 'selected' : '' }}>Retrait</option>
                        <option value="investment" {{ request('type') === 'investment' ? 'selected' : '' }}>Investissement</option>
                        <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Revenus</option>
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les statuts</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Terminé</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Échoué</option>
                    </select>
                </div>
                
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
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
                        <p class="text-sm font-medium text-gray-500">Total Dépôts</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($transactions->where('type', 'deposit')->sum('amount')) }} FCFA</p>
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
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($transactions->where('type', 'withdrawal')->sum('amount')) }} FCFA</p>
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
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($transactions->where('type', 'investment')->sum('amount')) }} FCFA</p>
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
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($transactions->where('type', 'income')->sum('amount')) }} FCFA</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des transactions -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Toutes les Transactions</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50">
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
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900">{{ $transaction->description }}</p>
                                @if($transaction->metadata)
                                    <p class="text-xs text-gray-500">
                                        @if(isset($transaction->metadata['payment_method']))
                                            {{ strtoupper($transaction->metadata['payment_method']) }}
                                        @endif
                                        @if(isset($transaction->metadata['phone']))
                                            - {{ $transaction->metadata['phone'] }}
                                        @endif
                                    </p>
                                @endif
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
                                <div>
                                    <p>{{ $transaction->created_at->format('d/m/Y') }}</p>
                                    <p>{{ $transaction->created_at->format('H:i') }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="checkTransactionStatus({{ $transaction->id }})" 
                                        class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Détails
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="fas fa-wallet text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500">Aucune transaction trouvée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($transactions->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $transactions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de détails -->
<div id="transactionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Détails de la Transaction</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="transactionDetails" class="space-y-3">
                <!-- Les détails seront chargés ici -->
            </div>
        </div>
    </div>
</div>

<script>
function checkTransactionStatus(transactionId) {
    fetch(`/api/payments/check?transaction_id=${transactionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Erreur: ' + data.error);
                return;
            }
            
            document.getElementById('transactionDetails').innerHTML = `
                <div class="flex justify-between">
                    <span class="text-gray-600">Statut:</span>
                    <span class="font-semibold">${data.status}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Montant:</span>
                    <span class="font-semibold">${new Intl.NumberFormat('fr-FR').format(data.amount)} FCFA</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Description:</span>
                    <span class="font-semibold">${data.description}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Date:</span>
                    <span class="font-semibold">${data.created_at}</span>
                </div>
            `;
            
            document.getElementById('transactionModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors du chargement des détails');
        });
}

function closeModal() {
    document.getElementById('transactionModal').classList.add('hidden');
}
</script>
@endsection