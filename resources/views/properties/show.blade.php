@extends('layouts.app')

@section('title', $property->title . ' - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $property->title }}</h1>
                    <p class="mt-2 text-gray-600">{{ $property->location }}</p>
                </div>
                <div class="flex space-x-4">
                    @can('update', $property)
                    <a href="{{ route('properties.edit', $property) }}" 
                       class="btn btn-primary">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier
                    </a>
                    @endcan
                    <a href="{{ route('properties.index') }}" 
                       class="btn btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Property Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Images -->
                <div class="mb-8">
                    @if($property->images && count($property->images) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($property->images as $image)
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="{{ $property->title }}" 
                                     class="w-full h-64 object-cover rounded-lg">
                            @endforeach
                        </div>
                    @else
                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-home text-6xl text-gray-400"></i>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="card mb-8">
                    <div class="card-header">
                        <h2 class="text-xl font-semibold">Description</h2>
                    </div>
                    <div class="card-body">
                        <p class="text-gray-700">{{ $property->description }}</p>
                    </div>
                </div>

                <!-- Property Details -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-xl font-semibold">Détails de la propriété</h2>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Type</h3>
                                <p class="text-gray-600">{{ ucfirst($property->type) }}</p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Prix</h3>
                                <p class="text-2xl font-bold text-blue-600">
                                    {{ number_format($property->price, 0, ',', ' ') }} FCFA
                                </p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Localisation</h3>
                                <p class="text-gray-600">{{ $property->location }}</p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Statut</h3>
                                <span class="badge {{ $property->status === 'approved' ? 'badge-success' : 'badge-warning' }}">
                                    {{ ucfirst($property->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Owner Info -->
                <div class="card mb-6">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Propriétaire</h3>
                    </div>
                    <div class="card-body">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-semibold">
                                    {{ substr($property->owner->name ?? 'P', 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-semibold">{{ $property->owner->name ?? 'Propriétaire' }}</p>
                                <p class="text-sm text-gray-600">{{ $property->owner->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Contact</h3>
                    </div>
                    <div class="card-body space-y-3">
                        @if($property->owner)
                        <a href="{{ route('messages.create', ['receiver_id' => $property->owner->id]) }}" 
                           class="btn btn-primary w-full">
                            <i class="fas fa-envelope mr-2"></i>
                            Envoyer un message
                        </a>
                        @else
                        <button class="btn btn-primary w-full" disabled>
                            <i class="fas fa-envelope mr-2"></i>
                            Propriétaire non disponible
                        </button>
                        @endif
                        <button class="btn btn-outline w-full">
                            <i class="fas fa-heart mr-2"></i>
                            Ajouter aux favoris
                        </button>
                        <button class="btn btn-outline w-full">
                            <i class="fas fa-share mr-2"></i>
                            Partager
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection