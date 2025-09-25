@extends('layouts.app')

@section('title', 'Gestion des Propriétés - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Propriétés</h1>
                <p class="mt-2 text-gray-600">Gérez toutes les propriétés de la plateforme</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                Retour au Dashboard
            </a>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <form method="GET" action="{{ route('admin.properties') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Titre, localisation...">
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
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approuvé</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejeté</option>
                        <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Vendu</option>
                    </select>
                </div>
                
                <div>
                    <label for="price_min" class="block text-sm font-medium text-gray-700 mb-2">Prix min (FCFA)</label>
                    <input type="number" name="price_min" id="price_min" value="{{ request('price_min') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="0">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Filtrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-home text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Propriétés</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $properties->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Approuvées</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $properties->where('status', 'approved')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En attente</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $properties->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-times-circle text-red-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Rejetées</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $properties->where('status', 'rejected')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des propriétés -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Liste des Propriétés</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Propriété
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Propriétaire
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prix
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($properties as $property)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        @if($property->images && count($property->images) > 0)
                                            <img src="{{ asset('storage/' . $property->images[0]) }}" alt="{{ $property->title }}" 
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        @else
                                            <i class="fas fa-home text-gray-400 text-xl"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($property->title, 30) }}</div>
                                        <div class="text-sm text-gray-500">{{ $property->location }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $property->owner->name }}</div>
                                <div class="text-sm text-gray-500">{{ $property->owner->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($property->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($property->price) }} FCFA
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($property->status === 'approved') bg-green-100 text-green-800
                                    @elseif($property->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($property->status === 'rejected') bg-red-100 text-red-800
                                    @elseif($property->status === 'sold') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    @if($property->status === 'approved') Approuvé
                                    @elseif($property->status === 'pending') En attente
                                    @elseif($property->status === 'rejected') Rejeté
                                    @elseif($property->status === 'sold') Vendu
                                    @else {{ ucfirst($property->status) }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $property->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="viewProperty({{ $property->id }})" 
                                            class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($property->status === 'pending')
                                    <button onclick="approveProperty({{ $property->id }})" 
                                            class="text-green-600 hover:text-green-900">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button onclick="rejectProperty({{ $property->id }})" 
                                            class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @endif
                                    <button onclick="editProperty({{ $property->id }})" 
                                            class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteProperty({{ $property->id }})" 
                                            class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-home text-4xl text-gray-300 mb-4"></i>
                                <p>Aucune propriété trouvée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($properties->hasPages())
        <div class="mt-8">
            {{ $properties->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function viewProperty(propertyId) {
    // TODO: Implémenter la vue détaillée de la propriété
    alert('Voir propriété ' + propertyId);
}

function approveProperty(propertyId) {
    if (confirm('Êtes-vous sûr de vouloir approuver cette propriété ?')) {
        // TODO: Implémenter l'approbation de la propriété
        alert('Approuver propriété ' + propertyId);
    }
}

function rejectProperty(propertyId) {
    if (confirm('Êtes-vous sûr de vouloir rejeter cette propriété ?')) {
        // TODO: Implémenter le rejet de la propriété
        alert('Rejeter propriété ' + propertyId);
    }
}

function editProperty(propertyId) {
    // TODO: Implémenter l'édition de la propriété
    alert('Modifier propriété ' + propertyId);
}

function deleteProperty(propertyId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette propriété ? Cette action est irréversible.')) {
        // TODO: Implémenter la suppression de la propriété
        alert('Supprimer propriété ' + propertyId);
    }
}
</script>
@endsection