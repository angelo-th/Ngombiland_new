{{-- resources/views/admin/statistics.blade.php --}}
@extends('layouts.admin')

@section('title', 'NGOMBILAND - Statistiques')

@section('content')
<div class="flex h-screen">
    {{-- Sidebar --}}
    <div class="w-64 bg-blue-800 text-white p-4">
        <div class="flex items-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="NGOMBILAND" class="h-10 mr-2">
            <span class="font-bold">ADMIN</span>
        </div>
        <nav>
            <ul>
                <li class="mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.users') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-users mr-3"></i> Utilisateurs
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.properties') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-home mr-3"></i> Biens Immobiliers
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.crowdfunding') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-project-diagram mr-3"></i> Projets Crowdfunding
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.transactions') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-money-bill-wave mr-3"></i> Transactions
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.statistics') }}" class="flex items-center p-2 bg-blue-700 rounded">
                        <i class="fas fa-chart-bar mr-3"></i> Statistiques
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.chat') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-message mr-3"></i> Chat Support
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.settings') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-cog mr-3"></i> Paramètres
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    {{-- Main content --}}
    <div class="flex-1 bg-white p-6 overflow-auto">
        <h2 class="text-xl font-bold mb-6">Statistiques de la Plateforme</h2>

        {{-- Charts --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-4 rounded-lg border">
                <h3 class="font-bold mb-4">Activité des Utilisateurs</h3>
                <canvas id="userActivityChart" height="200"></canvas>
            </div>
            <div class="bg-white p-4 rounded-lg border">
                <h3 class="font-bold mb-4">Répartition des Biens</h3>
                <canvas id="propertyDistributionChart" height="200"></canvas>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg border mb-6">
            <h3 class="font-bold mb-4">Transactions Mensuelles</h3>
            <canvas id="monthlyTransactionsChart" height="300"></canvas>
        </div>

        {{-- Top lists --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
                <h4 class="font-bold text-blue-800 mb-2">Top Villes</h4>
                <ul class="space-y-2">
                    @foreach($topCities as $city)
                        <li class="flex justify-between">
                            <span>{{ $city['name'] }}</span>
                            <span class="font-bold">{{ $city['properties_count'] }} biens</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <h4 class="font-bold text-green-800 mb-2">Top Projets</h4>
                <ul class="space-y-2">
                    @foreach($topProjects as $project)
                        <li class="flex justify-between">
                            <span>{{ $project['name'] }}</span>
                            <span class="font-bold">{{ $project['funded_percent'] }}% financé</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
                <h4 class="font-bold text-purple-800 mb-2">Méthodes de Paiement</h4>
                <ul class="space-y-2">
                    @foreach($paymentMethods as $method)
                        <li class="flex justify-between">
                            <span>{{ $method['name'] }}</span>
                            <span class="font-bold">{{ $method['usage_percent'] }}%</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/stat.js') }}"></script>
<script>
    // Ici vous pouvez initialiser vos graphiques avec les données dynamiques
</script>
@endsection
