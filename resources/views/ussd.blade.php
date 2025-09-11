@extends('layouts.app')

@section('title', 'Version USSD - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-4">
                NGOMBILAND USSD
            </h1>
            <p class="text-lg text-gray-300">
                Accédez à NGOMBILAND depuis n'importe quel téléphone
            </p>
        </div>

        <!-- USSD Code Display -->
        <div class="text-center mb-8">
            <div class="bg-gray-800 rounded-lg p-6 max-w-md mx-auto">
                <p class="text-gray-300 text-sm mb-2">Code USSD:</p>
                <code class="text-green-400 text-2xl font-mono">*126*123#</code>
                <p class="text-gray-400 text-xs mt-2">
                    Composez ce code sur votre téléphone
                </p>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Balance Check -->
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Solde Portefeuille</h3>
                </div>
                <p class="text-gray-300 text-sm mb-4">
                    Consultez votre solde NGOMBILAND en temps réel
                </p>
                <div class="bg-gray-700 rounded p-3">
                    <code class="text-green-400 text-sm">*126*123*1#</code>
                </div>
            </div>

            <!-- Property Search -->
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Recherche Propriétés</h3>
                </div>
                <p class="text-gray-300 text-sm mb-4">
                    Trouvez des propriétés par type et localisation
                </p>
                <div class="bg-gray-700 rounded p-3">
                    <code class="text-green-400 text-sm">*126*123*2#</code>
                </div>
            </div>

            <!-- Investments -->
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Mes Investissements</h3>
                </div>
                <p class="text-gray-300 text-sm mb-4">
                    Suivez vos investissements et ROI
                </p>
                <div class="bg-gray-700 rounded p-3">
                    <code class="text-green-400 text-sm">*126*123*3#</code>
                </div>
            </div>

            <!-- Top-up -->
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Recharger Portefeuille</h3>
                </div>
                <p class="text-gray-300 text-sm mb-4">
                    Rechargez via Mobile Money
                </p>
                <div class="bg-gray-700 rounded p-3">
                    <code class="text-green-400 text-sm">*126*123*4#</code>
                </div>
            </div>

            <!-- Support -->
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Support Client</h3>
                </div>
                <p class="text-gray-300 text-sm mb-4">
                    Contactez notre support technique
                </p>
                <div class="bg-gray-700 rounded p-3">
                    <code class="text-green-400 text-sm">*126*123*5#</code>
                </div>
            </div>

            <!-- Notifications -->
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-2H4v2zM4 5h6V3H4v2zM4 11h6V9H4v2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Notifications SMS</h3>
                </div>
                <p class="text-gray-300 text-sm mb-4">
                    Recevez des alertes par SMS
                </p>
                <div class="bg-gray-700 rounded p-3">
                    <code class="text-green-400 text-sm">*126*123*6#</code>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="bg-gray-800 rounded-lg p-6">
            <h3 class="text-xl font-semibold text-white mb-4">Comment utiliser NGOMBILAND USSD</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-lg font-medium text-white mb-2">Étapes d'utilisation :</h4>
                    <ol class="list-decimal list-inside space-y-2 text-gray-300">
                        <li>Composez <code class="text-green-400">*126*123#</code> sur votre téléphone</li>
                        <li>Suivez les instructions à l'écran</li>
                        <li>Sélectionnez l'option désirée (1-6)</li>
                        <li>Confirmez vos choix</li>
                        <li>Recevez les informations par SMS</li>
                    </ol>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-white mb-2">Fonctionnalités disponibles :</h4>
                    <ul class="list-disc list-inside space-y-2 text-gray-300">
                        <li>Consultation du solde portefeuille</li>
                        <li>Recherche de propriétés par type</li>
                        <li>Suivi des investissements</li>
                        <li>Rechargement Mobile Money</li>
                        <li>Support client 24/7</li>
                        <li>Notifications SMS automatiques</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Network Support -->
        <div class="mt-8 bg-gray-800 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Réseaux supportés</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <span class="text-orange-600 font-bold text-lg">MTN</span>
                    </div>
                    <p class="text-gray-300 text-sm">MTN Cameroon</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <span class="text-blue-600 font-bold text-lg">OR</span>
                    </div>
                    <p class="text-gray-300 text-sm">Orange Cameroon</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <span class="text-green-600 font-bold text-lg">NE</span>
                    </div>
                    <p class="text-gray-300 text-sm">Nexttel</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <span class="text-red-600 font-bold text-lg">CM</span>
                    </div>
                    <p class="text-gray-300 text-sm">Camtel</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection