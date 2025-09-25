@extends('layouts.app')

@section('title', 'Mes Propriétés - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Mes Propriétés</h1>
                    <p class="text-gray-600">Gérez vos propriétés et créez des projets de crowdfunding</p>
                </div>
                <a href="{{ route('properties.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter une propriété
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <form method="GET" action="{{ route('properties.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approuvé</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                </div>
                
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les types</option>
                        <option value="villa" {{ request('type') === 'villa' ? 'selected' : '' }}>Villa</option>
                        <option value="apartment" {{ request('type') === 'apartment' ? 'selected' : '' }}>Appartement</option>
                        <option value="house" {{ request('type') === 'house' ? 'selected' : '' }}>Maison</option>
                        <option value="land" {{ request('type') === 'land' ? 'selected' : '' }}>Terrain</option>
                        <option value="commercial" {{ request('type') === 'commercial' ? 'selected' : '' }}>Commercial</option>
                    </select>
                </div>
                
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="Titre ou localisation">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Filtrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des propriétés -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($properties as $property)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <!-- Image de la propriété -->
                @if($property->images && count($property->images) > 0)
                <img src="{{ asset('storage/' . $property->images[0]) }}" alt="{{ $property->title }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-home text-4xl text-gray-400"></i>
                </div>
                @endif
                
                <div class="p-6">
                    <!-- En-tête de la propriété -->
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $property->title }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($property->status === 'approved') bg-green-100 text-green-800
                            @elseif($property->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($property->status === 'rejected') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            @if($property->status === 'approved') Approuvé
                            @elseif($property->status === 'pending') En attente
                            @elseif($property->status === 'rejected') Rejeté
                            @else {{ ucfirst($property->status) }}
                            @endif
                        </span>
                    </div>
                    
                    <!-- Description -->
                    <p class="text-gray-600 mb-4">{{ Str::limit($property->description, 100) }}</p>
                    
                    <!-- Localisation -->
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $property->location }}</span>
                    </div>
                    
                    <!-- Prix -->
                    <div class="mb-4">
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($property->price) }} FCFA</p>
                    </div>
                    
                    <!-- Détails -->
                    <div class="grid grid-cols-2 gap-4 mb-4 text-sm text-gray-600">
                        <div>
                            <i class="fas fa-home mr-1"></i>
                            {{ ucfirst($property->type) }}
                        </div>
                        @if($property->is_crowdfundable)
                        <div>
                            <i class="fas fa-coins mr-1"></i>
                            Crowdfundable
                        </div>
                        @endif
                    </div>
                    
                    <!-- Projets de crowdfunding -->
                    @if($property->crowdfundingProjects->count() > 0)
                    <div class="mb-4">
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <h4 class="font-medium text-blue-900 mb-2">Projets de crowdfunding</h4>
                            @foreach($property->crowdfundingProjects->take(2) as $project)
                            <div class="text-sm text-blue-700">
                                <p class="font-medium">{{ $project->title }}</p>
                                <p>{{ round($project->progress_percentage) }}% financé - {{ $project->expected_roi }}% ROI</p>
                            </div>
                            @endforeach
                            @if($property->crowdfundingProjects->count() > 2)
                            <p class="text-xs text-blue-600 mt-1">+{{ $property->crowdfundingProjects->count() - 2 }} autres projets</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Actions -->
                    <div class="flex space-x-2">
                        <a href="{{ route('properties.show', $property) }}" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-center">
                            <i class="fas fa-eye mr-2"></i>
                            Voir
                        </a>
                        <a href="{{ route('properties.edit', $property) }}" class="flex-1 bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors text-center">
                            <i class="fas fa-edit mr-2"></i>
                            Modifier
                        </a>
                    </div>
                    
                    <!-- Actions supplémentaires -->
                    <div class="mt-3 flex space-x-2">
                        @if($property->status === 'approved' && $property->is_crowdfundable)
                        <a href="{{ route('crowdfunding.create') }}?property={{ $property->id }}" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors text-center text-sm">
                            <i class="fas fa-project-diagram mr-2"></i>
                            Créer un projet
                        </a>
                        @endif
                        
                        <form method="POST" action="{{ route('properties.destroy', $property) }}" class="flex-1" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette propriété ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                <i class="fas fa-trash mr-2"></i>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-home text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune propriété</h3>
                <p class="text-gray-600 mb-4">Vous n'avez pas encore de propriétés listées.</p>
                <a href="{{ route('properties.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter une propriété
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($properties->hasPages())
        <div class="mt-8">
            {{ $properties->links() }}
        </div>
        @endif
    </div>
</div>
@endsection