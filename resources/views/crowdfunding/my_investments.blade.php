@extends('layouts.app')

@section('title', 'Mes Investissements - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                Mes Investissements
            </h1>
            <p class="text-lg text-gray-600">
                Suivez vos investissements et leurs performances
            </p>
        </div>

        <!-- Investments List -->
        <div class="space-y-6">
            @forelse($investments as $investment)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                {{ $investment->property->title }}
                            </h3>
                            <p class="text-gray-600 mb-4">{{ $investment->property->description }}</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500">Montant investi</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ number_format($investment->amount) }} FCFA
                                    </p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500">ROI attendu</p>
                                    <p class="text-lg font-semibold text-green-600">
                                        {{ $investment->roi }}%
                                    </p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500">Statut</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($investment->status === 'active') bg-green-100 text-green-800
                                        @elseif($investment->status === 'completed') bg-blue-100 text-blue-800
                                        @elseif($investment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($investment->status) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="text-sm text-gray-500">
                                <p>Date d'investissement: {{ $investment->investment_date->format('d/m/Y H:i') }}</p>
                                <p>Localisation: {{ $investment->property->location }}</p>
                            </div>
                        </div>
                        
                        <div class="ml-6">
                            <a href="{{ route('properties.show', $investment->property->id) }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Voir le projet
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun investissement</h3>
                <p class="text-gray-600 mb-4">Vous n'avez pas encore d'investissements.</p>
                <a href="{{ route('crowdfunding.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Découvrir les projets
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
