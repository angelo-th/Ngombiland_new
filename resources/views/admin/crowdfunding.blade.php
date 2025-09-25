@extends('layouts.app')

@section('title', 'Gestion du Crowdfunding - Admin NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestion du Crowdfunding</h1>
                    <p class="mt-2 text-gray-600">Valider et gérer les projets de crowdfunding</p>
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
                           placeholder="Rechercher par titre de propriété..."
                           class="form-input w-full">
                </div>
                <div>
                    <select name="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actifs</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejetés</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Terminés</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search mr-2"></i>
                    Filtrer
                </button>
                <a href="{{ route('admin.crowdfunding') }}" class="btn btn-outline">
                    <i class="fas fa-times mr-2"></i>
                    Effacer
                </a>
            </form>
        </div>

        <!-- Liste des projets -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Projets de Crowdfunding ({{ $projects->total() }})
                </h3>
            </div>
            
            @if($projects->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($projects as $project)
                    <div class="p-6 hover:bg-gray-50">
                        <div class="flex items-start space-x-4">
                            <!-- Image de la propriété -->
                            <div class="flex-shrink-0">
                                @if($project->property->images && count($project->property->images) > 0)
                                    <img src="{{ asset('storage/' . $project->property->images[0]) }}" 
                                         alt="{{ $project->property->title }}" 
                                         class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-building text-2xl text-gray-400"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Contenu -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900">{{ $project->property->title }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ $project->property->location }}</p>
                                        
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3">
                                            <div>
                                                <span class="text-sm text-gray-500">Montant cible</span>
                                                <p class="font-semibold text-blue-600">
                                                    {{ number_format($project->target_amount) }} FCFA
                                                </p>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Montant collecté</span>
                                                <p class="font-semibold text-green-600">
                                                    {{ number_format($project->collected_amount) }} FCFA
                                                </p>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Investisseurs</span>
                                                <p class="font-semibold">{{ $project->investors_count }}</p>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Progression</span>
                                                <div class="flex items-center">
                                                    <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                                        <div class="bg-blue-600 h-2 rounded-full" 
                                                             style="width: {{ $project->progress_percentage }}%"></div>
                                                    </div>
                                                    <span class="text-sm font-medium">{{ $project->progress_percentage }}%</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3 flex items-center space-x-4">
                                            <span class="text-sm text-gray-500">
                                                Créé {{ $project->created_at->diffForHumans() }}
                                            </span>
                                            @if($project->end_date)
                                            <span class="text-sm text-gray-500">
                                                Fin: {{ $project->end_date->format('d/m/Y') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Statut et actions -->
                                    <div class="flex flex-col items-end space-y-2">
                                        <!-- Statut -->
                                        <span class="badge {{ $project->status === 'active' ? 'badge-success' : ($project->status === 'rejected' ? 'badge-danger' : ($project->status === 'completed' ? 'badge-info' : 'badge-warning')) }}">
                                            {{ ucfirst($project->status) }}
                                        </span>

                                        <!-- Actions -->
                                        @if($project->status === 'pending')
                                        <div class="flex space-x-2">
                                            <form method="POST" action="{{ route('admin.crowdfunding.approve', $project) }}" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-success btn-sm"
                                                        onclick="return confirm('Approuver ce projet de crowdfunding ?')">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Approuver
                                                </button>
                                            </form>
                                            
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm"
                                                    onclick="showRejectModal({{ $project->id }}, '{{ $project->property->title }}')">
                                                <i class="fas fa-times mr-1"></i>
                                                Rejeter
                                            </button>
                                        </div>
                                        @endif

                                        <!-- Lien vers le projet -->
                                        <a href="{{ route('crowdfunding.show', $project) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">
                                            Voir le projet →
                                        </a>
                                    </div>
                                </div>

                                <!-- Propriétaire -->
                                <div class="mt-3 flex items-center space-x-2">
                                    <span class="text-sm text-gray-500">Propriétaire:</span>
                                    <span class="text-sm font-medium">{{ $project->property->owner->name ?? 'N/A' }}</span>
                                    <span class="text-sm text-gray-500">({{ $project->property->owner->email ?? 'N/A' }})</span>
                                </div>

                                <!-- Description du projet -->
                                @if($project->description)
                                <div class="mt-3">
                                    <p class="text-sm text-gray-700">{{ Str::limit($project->description, 200) }}</p>
                                </div>
                                @endif

                                <!-- Raison de rejet -->
                                @if($project->status === 'rejected' && $project->rejection_reason)
                                <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <p class="text-sm text-red-800">
                                        <strong>Raison du rejet:</strong> {{ $project->rejection_reason }}
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
                    {{ $projects->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-chart-line text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun projet trouvé</h3>
                    <p class="text-gray-500">Aucun projet de crowdfunding ne correspond à vos critères de recherche.</p>
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
                        Rejeter le projet
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Vous êtes sur le point de rejeter le projet: <strong id="projectTitle"></strong>
                    </p>
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Raison du rejet *
                        </label>
                        <textarea id="reason" 
                                  name="reason" 
                                  rows="4" 
                                  class="form-input w-full"
                                  placeholder="Expliquez pourquoi ce projet est rejeté..."
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
function showRejectModal(projectId, projectTitle) {
    document.getElementById('projectTitle').textContent = projectTitle;
    document.getElementById('rejectForm').action = `/admin/crowdfunding/${projectId}/reject`;
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
