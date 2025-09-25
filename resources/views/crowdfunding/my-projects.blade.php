@extends('layouts.app')

@section('title', 'Mes Projets Crowdfunding - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Mes Projets Crowdfunding</h1>
                    <p class="mt-2 text-gray-600">Gérez vos projets de crowdfunding immobiliers</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('crowdfunding.create') }}" 
                       class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Nouveau Projet
                    </a>
                    <a href="{{ route('crowdfunding.index') }}" 
                       class="btn btn-outline">
                        <i class="fas fa-eye mr-2"></i>
                        Voir Tous
                    </a>
                </div>
            </div>
        </div>

        <!-- Liste des projets -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
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
                                        <h4 class="text-lg font-semibold text-gray-900">{{ $project->title }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ $project->property->title }}</p>
                                        <p class="text-sm text-gray-500 mt-2">{{ Str::limit($project->description, 150) }}</p>
                                        
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3">
                                            <div>
                                                <span class="text-sm text-gray-500">Montant cible</span>
                                                <p class="font-semibold text-blue-600">
                                                    {{ number_format($project->total_amount) }} FCFA
                                                </p>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Montant collecté</span>
                                                <p class="font-semibold text-green-600">
                                                    {{ number_format($project->amount_raised) }} FCFA
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
                                            @if($project->funding_deadline)
                                            <span class="text-sm text-gray-500">
                                                Fin: {{ $project->funding_deadline->format('d/m/Y') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Statut et actions -->
                                    <div class="flex flex-col items-end space-y-2">
                                        <!-- Statut -->
                                        <span class="badge {{ $project->status === 'active' ? 'badge-success' : ($project->status === 'rejected' ? 'badge-danger' : ($project->status === 'completed' ? 'badge-info' : ($project->status === 'draft' ? 'badge-secondary' : 'badge-warning'))) }}">
                                            @if($project->status === 'draft') Brouillon
                                            @elseif($project->status === 'pending') En attente
                                            @elseif($project->status === 'active') Actif
                                            @elseif($project->status === 'rejected') Rejeté
                                            @elseif($project->status === 'completed') Terminé
                                            @else {{ ucfirst($project->status) }}
                                            @endif
                                        </span>

                                        <!-- Actions -->
                                        <div class="flex space-x-2">
                                            @if($project->status === 'draft')
                                                <form method="POST" action="{{ route('crowdfunding.submit', $project) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-primary btn-sm"
                                                            onclick="return confirm('Soumettre ce projet pour validation ?')">
                                                        <i class="fas fa-paper-plane mr-1"></i>
                                                        Soumettre
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('crowdfunding.show', $project) }}" 
                                               class="btn btn-outline btn-sm">
                                                <i class="fas fa-eye mr-1"></i>
                                                Voir
                                            </a>

                                            @if($project->status === 'draft')
                                            <a href="{{ route('crowdfunding.edit', $project) }}" 
                                               class="btn btn-outline btn-sm">
                                                <i class="fas fa-edit mr-1"></i>
                                                Modifier
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

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
                    <p class="text-gray-500 mb-4">Vous n'avez pas encore créé de projet de crowdfunding.</p>
                    <a href="{{ route('crowdfunding.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Créer votre premier projet
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
