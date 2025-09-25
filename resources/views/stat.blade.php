@extends('layouts.app')

@section('title', 'Statistiques - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Statistiques de la Plateforme</h1>
                <p class="mt-2 text-gray-600">Analysez les performances et les tendances de NGOMBILAND</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                Retour au Dashboard
            </a>
        </div>

        <!-- Métriques principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Utilisateurs Totaux</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                        <p class="text-sm text-green-600">+{{ $stats['users_growth'] }}% ce mois</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-home text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Propriétés</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_properties']) }}</p>
                        <p class="text-sm text-green-600">+{{ $stats['properties_growth'] }}% ce mois</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-project-diagram text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Projets Crowdfunding</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_projects']) }}</p>
                        <p class="text-sm text-green-600">+{{ $stats['projects_growth'] }}% ce mois</p>
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
                        <p class="text-sm font-medium text-gray-500">Volume Total</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_volume']) }} FCFA</p>
                        <p class="text-sm text-green-600">+{{ $stats['volume_growth'] }}% ce mois</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Évolution des utilisateurs -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Évolution des Utilisateurs</h3>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>

            <!-- Répartition par rôle -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Répartition par Rôle</h3>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="rolesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tableaux de données -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Top propriétés -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Propriétés</h3>
                <div class="space-y-4">
                    @foreach($top_properties as $property)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                @if($property->images && count($property->images) > 0)
                                    <img src="{{ asset('storage/' . $property->images[0]) }}" alt="{{ $property->title }}" 
                                         class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <i class="fas fa-home text-gray-400"></i>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ Str::limit($property->title, 25) }}</p>
                                <p class="text-sm text-gray-500">{{ $property->location }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">{{ number_format($property->price) }} FCFA</p>
                            <p class="text-sm text-gray-500">{{ $property->views }} vues</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Top projets crowdfunding -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Projets Crowdfunding</h3>
                <div class="space-y-4">
                    @foreach($top_projects as $project)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                @if($project->images && count($project->images) > 0)
                                    <img src="{{ asset('storage/' . $project->images[0]) }}" alt="{{ $project->title }}" 
                                         class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <i class="fas fa-home text-gray-400"></i>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ Str::limit($project->title, 25) }}</p>
                                <p class="text-sm text-gray-500">{{ $project->property->location }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">{{ round($project->progress_percentage) }}%</p>
                            <p class="text-sm text-gray-500">{{ number_format($project->amount_raised) }} FCFA</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Statistiques détaillées -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Statistiques Détaillées</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $stats['active_users'] }}</div>
                    <div class="text-gray-600">Utilisateurs Actifs</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600 mb-2">{{ $stats['successful_projects'] }}</div>
                    <div class="text-gray-600">Projets Financés</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-600 mb-2">{{ $stats['total_investments'] }}</div>
                    <div class="text-gray-600">Investissements</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique des utilisateurs
const usersCtx = document.getElementById('usersChart').getContext('2d');
new Chart(usersCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
        datasets: [{
            label: 'Utilisateurs',
            data: [120, 190, 300, 500, 200, 300],
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Graphique des rôles
const rolesCtx = document.getElementById('rolesChart').getContext('2d');
new Chart(rolesCtx, {
    type: 'doughnut',
    data: {
        labels: ['Clients', 'Propriétaires', 'Investisseurs', 'Agents'],
        datasets: [{
            data: [40, 25, 20, 15],
            backgroundColor: [
                'rgb(59, 130, 246)',
                'rgb(16, 185, 129)',
                'rgb(245, 158, 11)',
                'rgb(239, 68, 68)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>
@endsection