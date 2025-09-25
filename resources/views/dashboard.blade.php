@extends('layouts.app')

@section('title', 'Dashboard - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-gray-600">Bienvenue, {{ Auth::user()->name }} !</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-2">
                        <div class="flex items-center">
                            <i class="fas fa-wallet text-green-600 mr-2"></i>
                            <span class="text-sm font-medium text-green-800">Solde: </span>
                            <span class="text-lg font-bold text-green-600 ml-1">{{ number_format(Auth::user()->wallet->balance ?? 0) }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-home text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Mes Propriétés</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ Auth::user()->properties->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Mes Investissements</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ Auth::user()->crowdfundingInvestments->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-coins text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Investi</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format(Auth::user()->crowdfundingInvestments->sum('amount_invested')) }} FCFA</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exchange-alt text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Mes Annonces</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ Auth::user()->secondaryMarketListings->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Actions Rapides -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions Rapides</h3>
                <div class="grid grid-cols-2 gap-4">
                    @if(Auth::user()->isProprietor())
                    <a href="{{ route('properties.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <i class="fas fa-plus text-blue-600 mr-3"></i>
                        <span class="font-medium">Ajouter une propriété</span>
                    </a>
                    <a href="{{ route('crowdfunding.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <i class="fas fa-project-diagram text-green-600 mr-3"></i>
                        <span class="font-medium">Créer un projet</span>
                    </a>
                    @endif
                    
                    @if(Auth::user()->isInvestor())
                    <a href="{{ route('crowdfunding.index') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                        <i class="fas fa-search text-yellow-600 mr-3"></i>
                        <span class="font-medium">Découvrir les projets</span>
                    </a>
                    <a href="{{ route('secondary-market.index') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <i class="fas fa-exchange-alt text-purple-600 mr-3"></i>
                        <span class="font-medium">Marketplace secondaire</span>
                    </a>
                    @endif
                    
                    <a href="{{ route('payments.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-wallet text-gray-600 mr-3"></i>
                        <span class="font-medium">Mon portefeuille</span>
                    </a>
                    <a href="{{ route('rental-distribution.user-history') }}" class="flex items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                        <i class="fas fa-chart-line text-indigo-600 mr-3"></i>
                        <span class="font-medium">Mes revenus</span>
                    </a>
                </div>
            </div>

            <!-- Projets Crowdfunding Actifs -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Projets Crowdfunding Actifs</h3>
                <div class="space-y-4">
                    @foreach(\App\Models\CrowdfundingProject::where('status', 'active')->take(3)->get() as $project)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-medium text-gray-900">{{ $project->title }}</h4>
                            <span class="text-sm text-gray-500">{{ round($project->progress_percentage) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>{{ number_format($project->amount_raised) }} FCFA levés</span>
                            <span>{{ $project->expected_roi }}% ROI</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('crowdfunding.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Voir tous les projets →
                    </a>
                </div>
            </div>
        </div>

        <!-- Mes Investissements Récents -->
        @if(Auth::user()->crowdfundingInvestments->count() > 0)
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Mes Investissements Récents</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parts</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ROI</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(Auth::user()->crowdfundingInvestments->take(5) as $investment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $investment->crowdfundingProject->title }}</div>
                                <div class="text-sm text-gray-500">{{ $investment->crowdfundingProject->property->location }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($investment->amount_invested) }} FCFA
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $investment->shares_purchased }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                {{ $investment->crowdfundingProject->expected_roi }}%
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($investment->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($investment->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($investment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('crowdfunding.show', $investment->crowdfundingProject) }}" class="text-blue-600 hover:text-blue-900">Voir</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Mes Propriétés Récentes -->
        @if(Auth::user()->properties->count() > 0)
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Mes Propriétés Récentes</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach(Auth::user()->properties->take(3) as $property)
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                    @if($property->images && count($property->images) > 0)
                    <img src="{{ asset('storage/' . $property->images[0]) }}" alt="{{ $property->title }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-home text-4xl text-gray-400"></i>
                    </div>
                    @endif
                    <div class="p-4">
                        <h4 class="font-medium text-gray-900 mb-2">{{ $property->title }}</h4>
                        <p class="text-sm text-gray-600 mb-2">{{ $property->location }}</p>
                        <p class="text-lg font-semibold text-blue-600">{{ number_format($property->price) }} FCFA</p>
                        <div class="mt-3">
                            <a href="{{ route('properties.show', $property) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Voir la propriété →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection