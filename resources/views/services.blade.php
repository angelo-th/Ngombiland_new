@extends('layouts.app')

@section('title', 'Nos Services')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Nos Services</h1>
                <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                    Découvrez comment NGOMBILAND révolutionne l'investissement immobilier au Cameroun
                </p>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                    <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-{{ $service['icon'] }} text-blue-600 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $service['title'] }}</h3>
                            <p class="text-gray-600 mb-6">{{ $service['description'] }}</p>
                            
                            <ul class="text-left space-y-2">
                                @foreach($service['features'] as $feature)
                                    <li class="flex items-center text-sm text-gray-700">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-blue-600 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Prêt à commencer ?</h2>
            <p class="text-xl text-blue-100 mb-8">
                Rejoignez des milliers d'investisseurs qui font confiance à NGOMBILAND
            </p>
            <div class="space-x-4">
                <a href="{{ route('register') }}" 
                   class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-200">
                    S'inscrire maintenant
                </a>
                <a href="{{ route('contact') }}" 
                   class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-200">
                    Nous contacter
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
