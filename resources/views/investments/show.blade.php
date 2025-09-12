@extends('layouts.app')

@section('title', 'Détail de l\'investissement - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Détail de l'investissement</h1>
                    <p class="mt-2 text-gray-600">{{ $investment->property->title ?? 'Projet supprimé' }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('investments.index') }}" 
                       class="btn btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Informations de l'investissement -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informations principales -->
            <div class="lg:col-span-2">
                <div class="card mb-6">
                    <div class="card-header">
                        <h2 class="text-xl font-semibold">Informations de l'investissement</h2>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Montant investi</h3>
                                <p class="text-3xl font-bold text-blue-600">
                                    {{ number_format($investment->amount, 0, ',', ' ') }} FCFA
                                </p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Statut</h3>
                                <span class="badge {{ $investment->status === 'active' ? 'badge-success' : 'badge-warning' }}">
                                    {{ ucfirst($investment->status) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Date d'investissement</h3>
                                <p class="text-gray-600">{{ $investment->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">ROI estimé</h3>
                                <p class="text-2xl font-bold text-green-600">
                                    {{ $investment->property->roi ?? 0 }}%
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations du projet -->
                @if($investment->property)
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-xl font-semibold">Informations du projet</h2>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Titre du projet</h3>
                                <p class="text-gray-600">{{ $investment->property->title }}</p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Localisation</h3>
                                <p class="text-gray-600">{{ $investment->property->location }}</p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Type de propriété</h3>
                                <p class="text-gray-600">{{ ucfirst($investment->property->type) }}</p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Prix total du projet</h3>
                                <p class="text-gray-600">{{ number_format($investment->property->price, 0, ',', ' ') }} FCFA</p>
                            </div>
                        </div>
                        
                        @if($investment->property->description)
                        <div class="mt-6">
                            <h3 class="font-semibold text-gray-900 mb-2">Description du projet</h3>
                            <p class="text-gray-600">{{ $investment->property->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Performance -->
                <div class="card mb-6">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Performance</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-chart-line text-green-600 text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-1">0%</h3>
                            <p class="text-gray-600">ROI actuel</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Actions</h3>
                    </div>
                    <div class="card-body space-y-3">
                        @if($investment->property)
                        <a href="{{ route('properties.show', $investment->property) }}" 
                           class="btn btn-primary w-full">
                            <i class="fas fa-eye mr-2"></i>
                            Voir le projet
                        </a>
                        @endif
                        
                        <button class="btn btn-outline w-full">
                            <i class="fas fa-download mr-2"></i>
                            Télécharger le contrat
                        </button>
                        
                        <button class="btn btn-outline w-full">
                            <i class="fas fa-envelope mr-2"></i>
                            Contacter le porteur
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
