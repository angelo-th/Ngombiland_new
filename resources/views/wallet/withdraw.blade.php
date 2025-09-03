@extends('layouts.app')

@section('title', 'Retirer du Portefeuille')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('wallet') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Retirer du Portefeuille</h1>
            </div>
            <p class="text-gray-600">Retirez vos fonds vers votre compte mobile money</p>
        </div>

        <!-- Solde actuel -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="text-center">
                <h2 class="text-lg font-medium text-gray-900 mb-2">Solde Disponible</h2>
                <div class="text-3xl font-bold text-green-600">
                    {{ number_format($balance, 0, ',', ' ') }} FCFA
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('wallet.withdraw') }}" method="POST" id="withdrawForm">
                @csrf
                
                <!-- Montant -->
                <div class="mb-6">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Montant à retirer (FCFA)
                    </label>
                    <div class="relative">
                        <input type="number" 
                               id="amount" 
                               name="amount" 
                               min="100" 
                               max="{{ $balance }}"
                               step="100"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Entrez le montant"
                               required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <span class="text-gray-500 text-sm">FCFA</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Montant maximum : {{ number_format($balance, 0, ',', ' ') }} FCFA</p>
                </div>

                <!-- Méthode de retrait -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Méthode de retrait
                    </label>
                    <div class="space-y-3">
                        <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" id="mtn" name="withdraw_method" value="mtn" class="mr-3" checked>
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
                            <input type="radio" id="orange" name="withdraw_method" value="orange" class="mr-3">
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
                            class="flex-1 bg-red-600 text-white py-3 px-6 rounded-lg hover:bg-red-700 transition duration-200">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        Retirer
                    </button>
                </div>
            </form>
        </div>

        <!-- Informations -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">
                        Informations importantes
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Le retrait peut prendre jusqu'à 24h</li>
                            <li>Frais de retrait : 50 FCFA</li>
                            <li>Vérifiez votre numéro de téléphone</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('withdrawForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const amount = parseFloat(document.getElementById('amount').value);
    const balance = {{ $balance }};
    const withdrawMethod = document.querySelector('input[name="withdraw_method"]:checked').value;
    
    if (amount < 100) {
        alert('Le montant minimum est de 100 FCFA');
        return;
    }
    
    if (amount > balance) {
        alert('Le montant ne peut pas dépasser votre solde disponible');
        return;
    }
    
    // Simulation du retrait
    if (confirm(`Confirmer le retrait de ${amount.toLocaleString()} FCFA vers ${withdrawMethod.toUpperCase()} ?`)) {
        this.submit();
    }
});
</script>
@endsection
