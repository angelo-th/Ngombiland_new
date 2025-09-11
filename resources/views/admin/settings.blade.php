@extends('layouts.app')

@section('title', 'Paramètres - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Paramètres de la Plateforme</h1>
                <p class="mt-2 text-gray-600">Configurez les paramètres généraux de NGOMBILAND</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                Retour au Dashboard
            </a>
        </div>

        <div class="space-y-8">
            <!-- General Settings -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Paramètres Généraux</h3>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom du Site
                            </label>
                            <input type="text" id="site_name" name="site_name" value="NGOMBILAND"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="site_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email de Contact
                            </label>
                            <input type="email" id="site_email" name="site_email" value="contact@ngombiland.cm"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    
                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description du Site
                        </label>
                        <textarea id="site_description" name="site_description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">La plateforme immobilière nouvelle génération pour le marché camerounais.</textarea>
                    </div>
                </form>
            </div>

            <!-- Commission Settings -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Paramètres de Commission</h3>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="contact_commission" class="block text-sm font-medium text-gray-700 mb-2">
                                Commission Contact (FCFA)
                            </label>
                            <input type="number" id="contact_commission" name="contact_commission" value="150"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="publication_commission" class="block text-sm font-medium text-gray-700 mb-2">
                                Commission Publication (FCFA)
                            </label>
                            <input type="number" id="publication_commission" name="publication_commission" value="500"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="investment_commission" class="block text-sm font-medium text-gray-700 mb-2">
                                Commission Investissement (%)
                            </label>
                            <input type="number" id="investment_commission" name="investment_commission" value="1" step="0.1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Crowdfunding Settings -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Paramètres Crowdfunding</h3>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="rental_distribution" class="block text-sm font-medium text-gray-700 mb-2">
                                Distribution Loyers - Investisseurs (%)
                            </label>
                            <input type="number" id="rental_distribution" name="rental_distribution" value="70" step="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="platform_fee" class="block text-sm font-medium text-gray-700 mb-2">
                                Frais Plateforme (%)
                            </label>
                            <input type="number" id="platform_fee" name="platform_fee" value="30" step="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    
                    <div>
                        <label for="minimum_investment" class="block text-sm font-medium text-gray-700 mb-2">
                            Investissement Minimum (FCFA)
                        </label>
                        <input type="number" id="minimum_investment" name="minimum_investment" value="1000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </form>
            </div>

            <!-- Payment Settings -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Paramètres de Paiement</h3>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                MTN Mobile Money
                            </label>
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" id="mtn_enabled" name="mtn_enabled" checked
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="mtn_enabled" class="text-sm text-gray-700">Activé</label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Stripe
                            </label>
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" id="stripe_enabled" name="stripe_enabled"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="stripe_enabled" class="text-sm text-gray-700">Activé</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Security Settings -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Paramètres de Sécurité</h3>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Double Authentification
                            </label>
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" id="2fa_enabled" name="2fa_enabled"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="2fa_enabled" class="text-sm text-gray-700">Activé</label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Historique Blockchain
                            </label>
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" id="blockchain_enabled" name="blockchain_enabled"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="blockchain_enabled" class="text-sm text-gray-700">Activé</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="button" onclick="saveSettings()"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Sauvegarder les Paramètres
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function saveSettings() {
    // TODO: Implémenter la sauvegarde des paramètres
    alert('Paramètres sauvegardés avec succès !');
}
</script>
@endsection
