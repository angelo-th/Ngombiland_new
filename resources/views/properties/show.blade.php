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
                    <a href="{{ route('properties.edit', $property) }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Modifier
                    </a>
                    <a href="{{ route('properties.index') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Images -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    @if($property->images && count($property->images) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                            @foreach($property->images as $image)
                            <div class="aspect-w-16 aspect-h-12">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="{{ $property->title }}" 
                                     class="w-full h-48 object-cover rounded-lg">
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="h-64 bg-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Description</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $property->description }}</p>
                </div>
            </div>

            <!-- Details -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Détails</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Prix:</span>
                            <span class="font-semibold text-lg text-blue-600">
                                {{ number_format($property->price) }} FCFA
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-medium capitalize">{{ $property->type }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Statut:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($property->status === 'published') bg-green-100 text-green-800
                                @elseif($property->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($property->status === 'sold') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($property->status) }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Localisation:</span>
                            <span class="font-medium">{{ $property->location }}</span>
                        </div>
                        
                        @if($property->latitude && $property->longitude)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Coordonnées:</span>
                            <span class="font-mono text-sm">
                                {{ $property->latitude }}, {{ $property->longitude }}
                            </span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Créé le:</span>
                            <span class="font-medium">{{ $property->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 space-y-3">
                        <a href="{{ route('properties.edit', $property) }}" 
                           class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-center block">
                            Modifier la propriété
                        </a>
                        
                        <form action="{{ route('properties.destroy', $property) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette propriété ?')">
                                Supprimer la propriété
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection