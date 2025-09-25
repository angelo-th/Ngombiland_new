@extends('layouts.app')

@section('title', 'Projets Crowdfunding - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Projets Crowdfunding</h1>
                    <p class="text-gray-600">Découvrez et investissez dans des projets immobiliers prometteurs</p>
                </div>
                @if(Auth::check() && Auth::user()->isProprietor())
                <a href="{{ route('crowdfunding.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-plus mr-2"></i>
                    Créer un projet
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <form method="GET" action="{{ route('crowdfunding.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="funded" {{ request('status') === 'funded' ? 'selected' : '' }}>Financé</option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expiré</option>
                    </select>
                </div>
                
                <div>
                    <label for="min_roi" class="block text-sm font-medium text-gray-700 mb-2">ROI minimum (%)</label>
                    <input type="number" name="min_roi" id="min_roi" value="{{ request('min_roi') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="5">
                </div>
                
                <div>
                    <label for="max_amount" class="block text-sm font-medium text-gray-700 mb-2">Montant maximum (FCFA)</label>
                    <input type="number" name="max_amount" id="max_amount" value="{{ request('max_amount') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           placeholder="10000000">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Filtrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des projets -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($projects as $project)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <!-- Image du projet -->
                @if($project->images && count($project->images) > 0)
                <img src="{{ asset('storage/' . $project->images[0]) }}" alt="{{ $project->title }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-home text-4xl text-gray-400"></i>
                </div>
                @endif
                
                <div class="p-6">
                    <!-- En-tête du projet -->
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $project->title }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($project->status === 'active') bg-green-100 text-green-800
                            @elseif($project->status === 'funded') bg-blue-100 text-blue-800
                            @elseif($project->status === 'expired') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            @if($project->status === 'active') Actif
                            @elseif($project->status === 'funded') Financé
                            @elseif($project->status === 'expired') Expiré
                            @else {{ ucfirst($project->status) }}
                            @endif
                        </span>
                    </div>
                    
                    <!-- Description -->
                    <p class="text-gray-600 mb-4">{{ Str::limit($project->description, 120) }}</p>
                    
                    <!-- Localisation -->
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $project->property->location }}</span>
                    </div>
                    
                    <!-- Progression -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Progression</span>
                            <span>{{ round($project->progress_percentage) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $project->progress_percentage }}%"></div>
                        </div>
                    </div>
                    
                    <!-- Statistiques -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600">Montant levé</p>
                            <p class="text-lg font-semibold text-gray-900">{{ number_format($project->amount_raised) }} FCFA</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">ROI attendu</p>
                            <p class="text-lg font-semibold text-green-600">{{ $project->expected_roi }}%</p>
                        </div>
                    </div>
                    
                    <!-- Détails supplémentaires -->
                    <div class="grid grid-cols-2 gap-4 mb-4 text-sm text-gray-600">
                        <div>
                            <i class="fas fa-coins mr-1"></i>
                            {{ number_format($project->price_per_share) }} FCFA/part
                        </div>
                        <div>
                            <i class="fas fa-users mr-1"></i>
                            {{ $project->investments->count() }} investisseurs
                        </div>
                    </div>
                    
                    <!-- Temps restant -->
                    @if($project->status === 'active')
                    <div class="mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-clock mr-2"></i>
                            <span>
                                @if($project->days_remaining > 0)
                                    {{ $project->days_remaining }} jours restants
                                @else
                                    Expire bientôt
                                @endif
                            </span>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Actions -->
                    <div class="flex space-x-2">
                        <a href="{{ route('crowdfunding.show', $project) }}" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-center">
                            <i class="fas fa-eye mr-2"></i>
                            Voir le projet
                        </a>
                        @if($project->status === 'active' && $project->remaining_shares > 0)
                        <a href="{{ route('crowdfunding.show', $project) }}#invest" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors text-center">
                            <i class="fas fa-coins mr-2"></i>
                            Investir
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun projet trouvé</h3>
                <p class="text-gray-600 mb-4">Aucun projet ne correspond à vos critères de recherche.</p>
                <a href="{{ route('crowdfunding.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Voir tous les projets
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($projects->hasPages())
        <div class="mt-8">
            {{ $projects->links() }}
        </div>
        @endif
    </div>
</div>
@endsection