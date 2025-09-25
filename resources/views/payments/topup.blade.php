@extends('layouts.app')

@section('title', 'Recharger mon Portefeuille')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-8">
            <a href="{{ route('payments.index') }}" class="text-primary-600 hover:text-primary-700 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-plus-circle mr-3 text-primary-600"></i>
                Recharger mon Portefeuille
            </h1>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('payments.topup') }}" method="POST" x-data="topupForm()">
                @csrf
                
                <!-- Montant -->
                <div class="mb-6">
                    <label for="amount" class="form-label">Montant à recharger (FCFA)</label>
                    <div class="relative">
                        <input type="number" id="amount" name="amount" 
                               x-model="amount" step="100" min="1000"
                               class="form-input pl-12" required>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">FCFA</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Montant minimum: 1,000 FCFA</p>
                </div>

                <!-- Méthode de paiement -->
                <div class="mb-6">
                    <label class="form-label">Méthode de paiement</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-primary-300 cursor-pointer">
                            <input type="radio" name="method" value="mobile_money" 
                                   x-model="method" class="form-radio text-primary-600">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center">
                                    <i class="fas fa-mobile-alt text-2xl text-blue-600 mr-3"></i>
                                    <div>
                                        <h3 class="font-medium text-gray-900">Mobile Money</h3>
                                        <p class="text-sm text-gray-600">MTN, Orange, Express Union</p>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-primary-300 cursor-pointer">
                            <input type="radio" name="method" value="manual" 
                                   x-model="method" class="form-radio text-primary-600">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center">
                                    <i class="fas fa-hand-holding-usd text-2xl text-green-600 mr-3"></i>
                                    <div>
                                        <h3 class="font-medium text-gray-900">Rechargement Manuel</h3>
                                        <p class="text-sm text-gray-600">Pour la démonstration</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Détails Mobile Money -->
                <div x-show="method === 'mobile_money'" x-transition class="mb-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="font-medium text-blue-900 mb-3">Détails Mobile Money</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="phone_number" class="form-label">Numéro de téléphone</label>
                                <input type="tel" id="phone_number" name="phone_number" 
                                       class="form-input" placeholder="6XXXXXXXX">
                            </div>
                            
                            <div>
                                <label for="provider" class="form-label">Opérateur</label>
                                <select name="provider" id="provider" class="form-select">
                                    <option value="">Sélectionner un opérateur</option>
                                    <option value="MTN">MTN Mobile Money</option>
                                    <option value="Orange">Orange Money</option>
                                    <option value="Express Union">Express Union</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Résumé -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h4 class="font-medium text-gray-900 mb-2">Résumé de la transaction</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Montant à recharger:</span>
                            <span class="font-semibold" x-text="formatPrice(amount)"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Méthode:</span>
                            <span class="font-semibold" x-text="getMethodName()"></span>
                        </div>
                        <div class="border-t pt-2">
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total:</span>
                                <span x-text="formatPrice(amount)"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex space-x-4">
                    <a href="{{ route('payments.index') }}" class="btn btn-outline flex-1">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary flex-1">
                        <i class="fas fa-credit-card mr-2"></i>
                        Confirmer le Rechargement
                    </button>
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
                        <ul class="list-disc list-inside space-y-1">
                            <li>Les paiements Mobile Money sont traités en temps réel</li>
                            <li>Votre portefeuille sera crédité automatiquement après confirmation</li>
                            <li>En cas de problème, contactez le support client</li>
                            <li>Ce système est en mode démonstration</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function topupForm() {
    return {
        amount: 10000,
        method: 'mobile_money',
        
        formatPrice(amount) {
            return new Intl.NumberFormat('fr-FR').format(amount || 0) + ' FCFA';
        },
        
        getMethodName() {
            switch(this.method) {
                case 'mobile_money':
                    return 'Mobile Money';
                case 'manual':
                    return 'Rechargement Manuel';
                default:
                    return 'Non sélectionné';
            }
        }
    }
}
</script>
@endpush
@endsection
