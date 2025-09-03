@extends('layouts.app')

@section('title', 'À Propos')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600 to-blue-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">À Propos de NGOMBILAND</h1>
                <p class="text-xl text-green-100 max-w-3xl mx-auto">
                    Révolutionner l'investissement immobilier au Cameroun grâce à la technologie
                </p>
            </div>
        </div>
    </div>

    <!-- Mission Section -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Notre Mission</h2>
                    <p class="text-lg text-gray-600 mb-6">
                        NGOMBILAND démocratise l'investissement immobilier au Cameroun en permettant à tous 
                        d'investir dans l'immobilier avec des montants accessibles grâce au crowdfunding.
                    </p>
                    <p class="text-lg text-gray-600 mb-6">
                        Nous connectons propriétaires, investisseurs et agents immobiliers sur une plateforme 
                        sécurisée et transparente, facilitant les transactions immobilières.
                    </p>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-2">1,250+</div>
                            <div class="text-gray-600">Biens immobiliers</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600 mb-2">850+</div>
                            <div class="text-gray-600">Investisseurs actifs</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Nos Valeurs</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-shield-alt text-blue-600 mr-3 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900">Sécurité</h4>
                                <p class="text-gray-600">Protection maximale des investissements et données</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-eye text-green-600 mr-3 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900">Transparence</h4>
                                <p class="text-gray-600">Informations claires et vérifiées</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-users text-purple-600 mr-3 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900">Accessibilité</h4>
                                <p class="text-gray-600">Investissement immobilier pour tous</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Notre Équipe</h2>
                <p class="text-lg text-gray-600">
                    Des experts passionnés par l'innovation immobilière
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($team as $member)
                    <div class="text-center">
                        <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <i class="fas fa-user text-gray-400 text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $member['name'] }}</h3>
                        <p class="text-blue-600 font-medium mb-3">{{ $member['role'] }}</p>
                        <p class="text-gray-600">{{ $member['bio'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Technology Section -->
    <div class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Technologie de Pointe</h2>
                <p class="text-lg text-gray-600">
                    Nous utilisons les dernières technologies pour sécuriser vos investissements
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lock text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Sécurité</h3>
                    <p class="text-gray-600 text-sm">Chiffrement SSL et authentification 2FA</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Mobile</h3>
                    <p class="text-gray-600 text-sm">Application mobile et USSD</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-robot text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">IA</h3>
                    <p class="text-gray-600 text-sm">Intelligence artificielle pour l'évaluation</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Analytics</h3>
                    <p class="text-gray-600 text-sm">Suivi en temps réel des investissements</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
