@extends('layouts.app')

@section('title', 'Recharger le Portefeuille')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('wallet') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Recharger le Portefeuille</h1>
            </div>
            <p class="text-gray-600">Ajoutez des fonds à votre portefeuille NGOMBILAND</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('wallet.topup') }}" method="POST" id="topupForm">
                @csrf
                
                <!-- Montant -->
                <div class="mb-6">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Montant à recharger (FCFA)
                    </label>
                    <div class="relative">
                        <input type="number" 
                               id="amount" 
                               name="amount" 
                               min="100" 
                               step="100"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Entrez le montant"
                               required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <span class="text-gray-500 text-sm">FCFA</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Montant minimum : 100 FCFA</p>
                </div>

                <!-- Méthode de paiement -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Méthode de paiement
                    </label>
                    <div class="space-y-3">
                        <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" id="mtn" name="payment_method" value="mtn" class="mr-3" checked>
                            <label for="mtn" class="flex items-center cursor-pointer">
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">M</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">MTN Mobile Money</p>
                                    <p class="text-sm text-gray-500">{{ auth()->user()->phone }}</p>
                                </div>
                            </label>
                        </div>
                        
                        <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" id="orange" name="payment_method" value="orange" class="mr-3">
                            <label for="orange" class="flex items-center cursor-pointer">
                                <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">O</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Orange Money</p>
                                    <p class="text-sm text-gray-500">{{ auth()->user()->phone }}</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex space-x-4">
                    <a href="{{ route('wallet') }}" 
                       class="flex-1 bg-gray-300 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-400 transition duration-200 text-center">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-credit-card mr-2"></i>
                        Recharger
                    </button>
                </div>
            </form>
        </div>

        <!-- Informations -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">
                        Informations importantes
                    </h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Le rechargement est instantané</li>
                            <li>Aucun frais de transaction</li>
                            <li>Votre numéro de téléphone sera utilisé pour le paiement</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('topupForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const amount = document.getElementById('amount').value;
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
    if (amount < 100) {
        alert('Le montant minimum est de 100 FCFA');
        return;
    }
    
    // Simulation du paiement
    if (confirm(`Confirmer le rechargement de ${amount} FCFA via ${paymentMethod.toUpperCase()} ?`)) {
        this.submit();
    }
});
</script>
@endsection
