@extends('layouts.app')

@section('title', 'Retirer des Fonds - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center">
                    <a href="{{ route('payments.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Retirer des Fonds</h1>
                        <p class="text-gray-600">Retirez vos fonds vers votre compte</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Formulaire de retrait -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Demande de retrait</h2>
                
                <form action="{{ route('payments.withdraw') }}" method="POST" id="withdrawForm">
                    @csrf
                    
                    <!-- Montant -->
                    <div class="mb-6">
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                            Montant à retirer (FCFA)
                        </label>
                        <input type="number" 
                               id="amount" 
                               name="amount" 
                               min="100" 
                               step="100" 
                               max="{{ Auth::user()->wallet->balance ?? 0 }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Entrez le montant"
                               required>
                        <p class="text-sm text-gray-500 mt-1">
                            Montant maximum: {{ number_format(Auth::user()->wallet->balance ?? 0) }} FCFA
                        </p>
                    </div>

                    <!-- Méthode de retrait -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Méthode de retrait
                        </label>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="provider" value="mtn_momo" class="text-blue-600 focus:ring-blue-500" required>
                                <div class="ml-3 flex items-center">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-mobile-alt text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">MTN Mobile Money</div>
                                        <div class="text-sm text-gray-500">Retrait vers MTN MoMo</div>
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="provider" value="orange_money" class="text-blue-600 focus:ring-blue-500">
                                <div class="ml-3 flex items-center">
                                    <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-mobile-alt text-orange-600"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Orange Money</div>
                                        <div class="text-sm text-gray-500">Retrait vers Orange Money</div>
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="provider" value="bank_transfer" class="text-blue-600 focus:ring-blue-500">
                                <div class="ml-3 flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-university text-blue-600"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Virement bancaire</div>
                                        <div class="text-sm text-gray-500">Retrait vers compte bancaire</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Détails du compte -->
                    <div class="mb-6">
                        <label for="account_details" class="block text-sm font-medium text-gray-700 mb-2">
                            Détails du compte
                        </label>
                        <input type="text" 
                               id="account_details" 
                               name="account_details" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Numéro de téléphone ou détails bancaires"
                               required>
                        <p class="text-sm text-gray-500 mt-1">
                            Pour Mobile Money: numéro de téléphone<br>
                            Pour virement bancaire: nom de la banque et numéro de compte
                        </p>
                    </div>

                    <!-- Bouton de soumission -->
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <i class="fas fa-minus mr-2"></i>
                        Demander le retrait
                    </button>
                </form>
            </div>

            <!-- Informations et aide -->
            <div class="space-y-6">
                <!-- Solde actuel -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Solde disponible</h3>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-gray-900 mb-2">
                            {{ number_format(Auth::user()->wallet->balance ?? 0) }} FCFA
                        </div>
                        <p class="text-gray-600">Disponible pour retrait</p>
                    </div>
                </div>

                <!-- Délais de traitement -->
                <div class="bg-yellow-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-yellow-900 mb-4">
                        <i class="fas fa-clock mr-2"></i>
                        Délais de traitement
                    </h3>
                    <ul class="space-y-2 text-sm text-yellow-800">
                        <li class="flex items-start">
                            <i class="fas fa-mobile-alt text-yellow-600 mr-2 mt-0.5"></i>
                            <div>
                                <strong>Mobile Money:</strong> 1-2 heures ouvrables
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-university text-yellow-600 mr-2 mt-0.5"></i>
                            <div>
                                <strong>Virement bancaire:</strong> 1-3 jours ouvrables
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Instructions -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4">
                        <i class="fas fa-info-circle mr-2"></i>
                        Instructions
                    </h3>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 mr-2 mt-0.5"></i>
                            Vérifiez que vous avez suffisamment de fonds
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 mr-2 mt-0.5"></i>
                            Entrez le montant que vous souhaitez retirer
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 mr-2 mt-0.5"></i>
                            Sélectionnez votre méthode de retrait préférée
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 mr-2 mt-0.5"></i>
                            Vérifiez les détails de votre compte
                        </li>
                    </ul>
                </div>

                <!-- Limites -->
                <div class="bg-red-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-red-900 mb-4">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Limites et conditions
                    </h3>
                    <ul class="space-y-2 text-sm text-red-800">
                        <li class="flex items-start">
                            <i class="fas fa-ban text-red-600 mr-2 mt-0.5"></i>
                            Montant minimum: 100 FCFA
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-ban text-red-600 mr-2 mt-0.5"></i>
                            Montant maximum: votre solde disponible
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-ban text-red-600 mr-2 mt-0.5"></i>
                            Les retraits sont traités pendant les heures ouvrables
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const maxAmount = {{ Auth::user()->wallet->balance ?? 0 }};
    
    // Validation du montant
    amountInput.addEventListener('input', function() {
        const value = parseFloat(this.value);
        if (value > maxAmount) {
            this.setCustomValidity('Le montant ne peut pas dépasser votre solde disponible');
        } else if (value < 100) {
            this.setCustomValidity('Le montant minimum est de 100 FCFA');
        } else {
            this.setCustomValidity('');
        }
    });
    
    // Mise à jour du placeholder des détails du compte
    const providerRadios = document.querySelectorAll('input[name="provider"]');
    const accountDetailsInput = document.getElementById('account_details');
    
    providerRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'mtn_momo' || this.value === 'orange_money') {
                accountDetailsInput.placeholder = 'Ex: +237 6XX XXX XXX';
            } else if (this.value === 'bank_transfer') {
                accountDetailsInput.placeholder = 'Ex: BICEC - 1234567890';
            }
        });
    });
});
</script>
@endpush
@endsection
