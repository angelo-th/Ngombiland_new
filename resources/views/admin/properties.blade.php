@extends('layouts.app')

@section('title', 'Gestion des Propriétés - Admin NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestion des Propriétés</h1>
                    <p class="mt-2 text-gray-600">Valider et gérer les annonces de propriétés</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" 
                   class="btn btn-outline">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour au Dashboard
                </a>
            </div>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <form method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-64">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Rechercher par titre, description ou localisation..."
                           class="form-input w-full">
                </div>
                <div>
                    <select name="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approuvées</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejetées</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search mr-2"></i>
                    Filtrer
                </button>
                <a href="{{ route('admin.properties') }}" class="btn btn-outline">
                    <i class="fas fa-times mr-2"></i>
                    Effacer
                </a>
            </form>
        </div>

        <!-- Liste des propriétés -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Propriétés ({{ $properties->total() }})
                </h3>
            </div>
            
            @if($properties->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($properties as $property)
                    <div class="p-6 hover:bg-gray-50">
                        <div class="flex items-start space-x-4">
                            <!-- Image -->
                            <div class="flex-shrink-0">
                                @if($property->images && count($property->images) > 0)
                                    <img src="{{ asset('storage/' . $property->images[0]) }}" 
                                         alt="{{ $property->title }}" 
                                         class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-home text-2xl text-gray-400"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Contenu -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900">{{ $property->title }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ $property->location }}</p>
                                        <p class="text-sm text-gray-500 mt-2">{{ Str::limit($property->description, 150) }}</p>
                                        
                                        <div class="flex items-center space-x-4 mt-3">
                                            <span class="text-lg font-bold text-blue-600">
                                                {{ number_format($property->price) }} FCFA
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                {{ ucfirst($property->type) }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                {{ $property->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Statut et actions -->
                                    <div class="flex flex-col items-end space-y-2">
                                        <!-- Statut -->
                                        <span class="badge {{ $property->status === 'approved' ? 'badge-success' : ($property->status === 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                                            {{ ucfirst($property->status) }}
                                        </span>

                                        <!-- Actions -->
                                        @if($property->status === 'pending')
                                        <div class="flex space-x-2">
                                            <form method="POST" action="{{ route('admin.properties.approve', $property) }}" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-success btn-sm"
                                                        onclick="return confirm('Approuver cette propriété ?')">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Approuver
                                                </button>
                                            </form>
                                            
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm"
                                                    onclick="showRejectModal({{ $property->id }}, '{{ $property->title }}')">
                                                <i class="fas fa-times mr-1"></i>
                                                Rejeter
                                            </button>
                                        </div>
                                        @endif

                                        <!-- Lien vers la propriété -->
                                        <a href="{{ route('properties.show', $property) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">
                                            Voir les détails →
                                        </a>
                                    </div>
                                </div>

                                <!-- Propriétaire -->
                                <div class="mt-3 flex items-center space-x-2">
                                    <span class="text-sm text-gray-500">Propriétaire:</span>
                                    <span class="text-sm font-medium">{{ $property->owner->name ?? 'N/A' }}</span>
                                    <span class="text-sm text-gray-500">({{ $property->owner->email ?? 'N/A' }})</span>
                                </div>

                                <!-- Raison de rejet -->
                                @if($property->status === 'rejected' && $property->rejection_reason)
                                <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <p class="text-sm text-red-800">
                                        <strong>Raison du rejet:</strong> {{ $property->rejection_reason }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $properties->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-home text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune propriété trouvée</h3>
                    <p class="text-gray-500">Aucune propriété ne correspond à vos critères de recherche.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de rejet -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <form id="rejectForm" method="POST">
                @csrf
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Rejeter la propriété
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Vous êtes sur le point de rejeter la propriété: <strong id="propertyTitle"></strong>
                    </p>
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Raison du rejet *
                        </label>
                        <textarea id="reason" 
                                  name="reason" 
                                  rows="4" 
                                  class="form-input w-full"
                                  placeholder="Expliquez pourquoi cette propriété est rejetée..."
                                  required></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" 
                            onclick="hideRejectModal()"
                            class="btn btn-outline">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times mr-2"></i>
                        Rejeter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal(propertyId, propertyTitle) {
    document.getElementById('propertyTitle').textContent = propertyTitle;
    document.getElementById('rejectForm').action = `/admin/properties/${propertyId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectForm').reset();
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideRejectModal();
    }
});
</script>
@endsection
