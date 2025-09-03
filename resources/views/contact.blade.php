@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Contactez-nous</h1>
                <p class="text-xl text-purple-100 max-w-3xl mx-auto">
                    Nous sommes là pour vous aider dans votre parcours d'investissement immobilier
                </p>
            </div>
        </div>
    </div>

    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Formulaire de contact -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Envoyez-nous un message</h2>
                    
                    <form action="{{ route('support.message') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nom complet
                                </label>
                                <input type="text" id="name" name="name" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                       placeholder="Votre nom" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email
                                </label>
                                <input type="email" id="email" name="email" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                       placeholder="votre@email.com" required>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Téléphone
                            </label>
                            <input type="tel" id="phone" name="phone" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="+237 6XX XXX XXX">
                        </div>
                        
                        <div class="mb-6">
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Sujet
                            </label>
                            <select id="subject" name="subject" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                                <option value="">Sélectionner un sujet</option>
                                <option value="support">Support technique</option>
                                <option value="investment">Question sur l'investissement</option>
                                <option value="property">Propriété</option>
                                <option value="payment">Paiement</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>
                        
                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message
                            </label>
                            <textarea id="message" name="message" rows="5" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Décrivez votre demande..." required></textarea>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-purple-600 text-white py-3 px-6 rounded-lg hover:bg-purple-700 transition duration-200 font-semibold">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Envoyer le message
                        </button>
                    </form>
                </div>

                <!-- Informations de contact -->
                <div class="space-y-8">
                    <!-- Coordonnées -->
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Nos Coordonnées</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-map-marker-alt text-purple-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Adresse</h4>
                                    <p class="text-gray-600">
                                        Douala, Cameroun<br>
                                        Quartier Akwa, Immeuble NGOMBILAND
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-phone text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Téléphone</h4>
                                    <p class="text-gray-600">+237 6XX XXX XXX</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-envelope text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Email</h4>
                                    <p class="text-gray-600">contact@ngombiland.cm</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-clock text-yellow-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Horaires</h4>
                                    <p class="text-gray-600">
                                        Lun - Ven: 8h00 - 18h00<br>
                                        Sam: 9h00 - 15h00
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Support Rapide</h3>
                        
                        <div class="space-y-4">
                            <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-comments text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Chat en direct</h4>
                                    <p class="text-gray-600 text-sm">Disponible 24/7</p>
                                </div>
                            </a>
                            
                            <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-question-circle text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">FAQ</h4>
                                    <p class="text-gray-600 text-sm">Questions fréquentes</p>
                                </div>
                            </a>
                            
                            <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-book text-purple-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Documentation</h4>
                                    <p class="text-gray-600 text-sm">Guides et tutoriels</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
