<div>
    <!-- Barre de recherche principale -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Champ de recherche -->
            <div class="flex-1">
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Rechercher par titre, description ou localisation..."
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Bouton de filtres -->
            <button 
                wire:click="toggleFilters"
                class="btn btn-outline flex items-center gap-2"
            >
                <i class="fas fa-filter"></i>
                Filtres
                @if($search || $type || $status || $minPrice || $maxPrice || $city)
                    <span class="bg-blue-600 text-white text-xs rounded-full px-2 py-1">
                        {{ collect([$search, $type, $status, $minPrice, $maxPrice, $city])->filter()->count() }}
                    </span>
                @endif
            </button>

            <!-- Tri -->
            <select wire:model.live="sort" class="form-select">
                <option value="latest">Plus récent</option>
                <option value="price_asc">Prix croissant</option>
                <option value="price_desc">Prix décroissant</option>
                <option value="oldest">Plus ancien</option>
            </select>
        </div>

        <!-- Filtres avancés -->
        @if($showFilters)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Type de propriété -->
                <div>
                    <label class="form-label">Type de propriété</label>
                    <select wire:model.live="type" class="form-select">
                        <option value="">Tous les types</option>
                        @foreach($propertyTypes as $propertyType)
                            <option value="{{ $propertyType }}">{{ ucfirst($propertyType) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Statut -->
                <div>
                    <label class="form-label">Statut</label>
                    <select wire:model.live="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        @foreach($propertyStatuses as $propertyStatus)
                            <option value="{{ $propertyStatus }}">{{ ucfirst($propertyStatus) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Ville -->
                <div>
                    <label class="form-label">Ville</label>
                    <select wire:model.live="city" class="form-select">
                        <option value="">Toutes les villes</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Prix minimum -->
                <div>
                    <label class="form-label">Prix minimum (FCFA)</label>
                    <input 
                        type="number" 
                        wire:model.live.debounce.300ms="minPrice"
                        placeholder="0"
                        class="form-input"
                    >
                </div>

                <!-- Prix maximum -->
                <div>
                    <label class="form-label">Prix maximum (FCFA)</label>
                    <input 
                        type="number" 
                        wire:model.live.debounce.300ms="maxPrice"
                        placeholder="Aucune limite"
                        class="form-input"
                    >
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex justify-end gap-3 mt-4">
                <button 
                    wire:click="clearFilters"
                    class="btn btn-ghost"
                >
                    <i class="fas fa-times mr-2"></i>
                    Effacer les filtres
                </button>
            </div>
        </div>
        @endif
    </div>

    <!-- Résultats de recherche -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($properties as $property)
        <div class="card card-hover">
            <div class="relative">
                @if($property->images && count($property->images) > 0)
                    <img src="{{ asset('storage/' . $property->images[0]) }}" 
                         alt="{{ $property->title }}" 
                         class="w-full h-48 object-cover rounded-t-lg">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg">
                        <i class="fas fa-home text-4xl text-gray-400"></i>
                    </div>
                @endif
                <div class="absolute top-4 right-4">
                    <span class="badge badge-primary">
                        {{ ucfirst($property->type) }}
                    </span>
                </div>
                @if($property->status === 'approved')
                    <div class="absolute top-4 left-4">
                        <span class="badge badge-success">
                            <i class="fas fa-check mr-1"></i>
                            Approuvé
                        </span>
                    </div>
                @endif
            </div>
            
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $property->title }}</h3>
                <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit($property->description, 100) }}</p>
                
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center text-gray-500">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span class="text-sm">{{ $property->location }}</span>
                    </div>
                    <div class="text-2xl font-bold text-blue-600">
                        {{ number_format($property->price, 0, ',', ' ') }} FCFA
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-user mr-2"></i>
                        <span>{{ $property->owner->name ?? 'Propriétaire' }}</span>
                    </div>
                    <a href="{{ route('properties.show', $property->id) }}" 
                       class="btn btn-primary">
                        <i class="fas fa-eye mr-2"></i>
                        Voir détails
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune propriété trouvée</h3>
            <p class="text-gray-600 mb-4">Essayez de modifier vos critères de recherche.</p>
            <button 
                wire:click="clearFilters"
                class="btn btn-primary"
            >
                <i class="fas fa-refresh mr-2"></i>
                Effacer les filtres
            </button>
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