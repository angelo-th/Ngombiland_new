@extends('layouts.app')

@section('title', 'Alimenter le Portefeuille - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Alimenter le Portefeuille</h1>
                    <p class="text-gray-600">Ajoutez des fonds à votre portefeuille via Mobile Money</p>
                </div>
                <a href="{{ route('payments.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Solde actuel -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-blue-900">Solde Actuel</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ number_format(auth()->user()->wallet->balance ?? 0) }} FCFA</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-wallet text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Formulaire d'alimentation -->
            <form method="POST" action="{{ route('payments.topup') }}" id="topupForm">
                @csrf
                
                <div class="space-y-6">
                    <!-- Montant -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                            Montant à ajouter (FCFA) *
                        </label>
                        <div class="relative">
                            <input type="number" id="amount" name="amount" 
                                   class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
                                   placeholder="50000" min="1000" step="100" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">FCFA</span>
                            </div>
                        </div>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Montants prédéfinis -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Montants rapides</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <button type="button" onclick="setAmount(10000)" 
                                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                10 000 FCFA
                            </button>
                            <button type="button" onclick="setAmount(25000)" 
                                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                25 000 FCFA
                            </button>
                            <button type="button" onclick="setAmount(50000)" 
                                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                50 000 FCFA
                            </button>
                            <button type="button" onclick="setAmount(100000)" 
                                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-center">
                                100 000 FCFA
                            </button>
                        </div>
                    </div>

                    <!-- Méthode de paiement -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Méthode de paiement</label>
                        <div class="space-y-3">
                            <div class="flex items-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" id="mtn" name="payment_method" value="mtn" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                <label for="mtn" class="ml-3 flex items-center">
                                    <img src="https://via.placeholder.com/40x40/FF6B35/FFFFFF?text=MTN" alt="MTN" class="w-10 h-10 rounded mr-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">MTN Mobile Money</p>
                                        <p class="text-sm text-gray-500">Paiement via MTN MoMo</p>
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" id="orange" name="payment_method" value="orange" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="orange" class="ml-3 flex items-center">
                                    <img src="https://via.placeholder.com/40x40/FF6600/FFFFFF?text=OM" alt="Orange Money" class="w-10 h-10 rounded mr-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Orange Money</p>
                                        <p class="text-sm text-gray-500">Paiement via Orange Money</p>
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" id="express" name="payment_method" value="express" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="express" class="ml-3 flex items-center">
                                    <img src="https://via.placeholder.com/40x40/00A651/FFFFFF?text=EX" alt="Express Union" class="w-10 h-10 rounded mr-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Express Union</p>
                                        <p class="text-sm text-gray-500">Paiement via Express Union</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Numéro de téléphone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Numéro de téléphone *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">+237</span>
                            </div>
                            <input type="tel" id="phone" name="phone" 
                                   class="w-full pl-12 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="6XX XXX XXX" required>
                        </div>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Résumé de la transaction -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Résumé de la transaction</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Montant à ajouter:</span>
                                <span class="font-semibold" id="amount-display">0 FCFA</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Frais de transaction:</span>
                                <span class="font-semibold" id="fees-display">0 FCFA</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-900 font-medium">Total à payer:</span>
                                    <span class="font-bold text-lg" id="total-display">0 FCFA</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex space-x-4">
                        <a href="{{ route('payments.index') }}" 
                           class="flex-1 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-center">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="flex-1 bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-credit-card mr-2"></i>
                            Procéder au paiement
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Informations importantes -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Informations importantes</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Le montant minimum d'alimentation est de 1 000 FCFA</li>
                            <li>Les frais de transaction sont de 1% du montant (minimum 100 FCFA)</li>
                            <li>Votre portefeuille sera crédité immédiatement après confirmation du paiement</li>
                            <li>Assurez-vous que votre numéro de téléphone est correct</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function setAmount(amount) {
    document.getElementById('amount').value = amount;
    updateSummary();
}

function updateSummary() {
    const amount = parseFloat(document.getElementById('amount').value) || 0;
    const fees = Math.max(amount * 0.01, 100); // 1% avec minimum 100 FCFA
    const total = amount + fees;

    document.getElementById('amount-display').textContent = new Intl.NumberFormat('fr-FR').format(amount) + ' FCFA';
    document.getElementById('fees-display').textContent = new Intl.NumberFormat('fr-FR').format(fees) + ' FCFA';
    document.getElementById('total-display').textContent = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
}

// Mettre à jour le résumé quand le montant change
document.getElementById('amount').addEventListener('input', updateSummary);

// Initialiser le résumé
updateSummary();
</script>
@endsection