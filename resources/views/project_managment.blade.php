@extends('layouts.app')

@section('title', 'Gestion des Projets - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Projets</h1>
                <p class="mt-2 text-gray-600">Gérez vos projets de crowdfunding</p>
            </div>
            <a href="{{ route('crowdfunding.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Nouveau Projet
            </a>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <form method="GET" action="{{ route('projects.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les statuts</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="funded" {{ request('status') === 'funded' ? 'selected' : '' }}>Financé</option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expiré</option>
                    </select>
                </div>
                
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Titre du projet...">
                </div>
                
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                    <select name="sort" id="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Date de création</option>
                        <option value="amount_raised" {{ request('sort') === 'amount_raised' ? 'selected' : '' }}>Montant levé</option>
                        <option value="expected_roi" {{ request('sort') === 'expected_roi' ? 'selected' : '' }}>ROI attendu</option>
                        <option value="funding_deadline" {{ request('sort') === 'funding_deadline' ? 'selected' : '' }}>Date limite</option>
                    </select>
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
                            <i class="fas fa-project-diagram text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Projets</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $projects->total() }}</p>
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
                        <p class="text-sm font-medium text-gray-500">Financés</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $projects->where('status', 'funded')->count() }}</p>
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
                        <p class="text-sm font-medium text-gray-500">En cours</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $projects->where('status', 'active')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-coins text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Montant Levé</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($projects->sum('amount_raised')) }} FCFA</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des projets -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Mes Projets</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Projet
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Progression
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Montant
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ROI
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
                        @forelse($projects as $project)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        @if($project->images && count($project->images) > 0)
                                            <img src="{{ asset('storage/' . $project->images[0]) }}" alt="{{ $project->title }}" 
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        @else
                                            <i class="fas fa-home text-gray-400 text-xl"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($project->title, 30) }}</div>
                                        <div class="text-sm text-gray-500">{{ $project->property->location }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-20 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ round($project->progress_percentage) }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($project->amount_raised) }} / {{ number_format($project->total_amount) }} FCFA</div>
                                <div class="text-sm text-gray-500">{{ $project->shares_sold }} / {{ $project->total_shares }} parts</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $project->expected_roi }}%
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($project->status === 'active') bg-green-100 text-green-800
                                    @elseif($project->status === 'draft') bg-yellow-100 text-yellow-800
                                    @elseif($project->status === 'funded') bg-blue-100 text-blue-800
                                    @elseif($project->status === 'expired') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    @if($project->status === 'active') Actif
                                    @elseif($project->status === 'draft') Brouillon
                                    @elseif($project->status === 'funded') Financé
                                    @elseif($project->status === 'expired') Expiré
                                    @else {{ ucfirst($project->status) }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $project->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('crowdfunding.show', $project) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('crowdfunding.edit', $project) }}" 
                                       class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($project->status === 'draft')
                                    <button onclick="activateProject({{ $project->id }})" 
                                            class="text-green-600 hover:text-green-900">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    @endif
                                    @if($project->status === 'active')
                                    <button onclick="pauseProject({{ $project->id }})" 
                                            class="text-orange-600 hover:text-orange-900">
                                        <i class="fas fa-pause"></i>
                                    </button>
                                    @endif
                                    <button onclick="deleteProject({{ $project->id }})" 
                                            class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-project-diagram text-4xl text-gray-300 mb-4"></i>
                                <p>Aucun projet trouvé</p>
                                <a href="{{ route('crowdfunding.create') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Créer votre premier projet
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($projects->hasPages())
        <div class="mt-8">
            {{ $projects->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function activateProject(projectId) {
    if (confirm('Êtes-vous sûr de vouloir activer ce projet ?')) {
        // TODO: Implémenter l'activation du projet
        alert('Activer projet ' + projectId);
    }
}

function pauseProject(projectId) {
    if (confirm('Êtes-vous sûr de vouloir mettre en pause ce projet ?')) {
        // TODO: Implémenter la pause du projet
        alert('Mettre en pause projet ' + projectId);
    }
}

function deleteProject(projectId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce projet ? Cette action est irréversible.')) {
        // TODO: Implémenter la suppression du projet
        alert('Supprimer projet ' + projectId);
    }
}
</script>
@endsection