@extends('layouts.app')

@section('title', 'Mes Revenus Locatifs - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Mes Revenus Locatifs</h1>
                        <p class="text-gray-600">Consultez vos revenus générés par vos investissements</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('payments.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-wallet mr-2"></i>
                            Mon Portefeuille
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistiques des revenus -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total des revenus</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ number_format(Auth::user()->transactions()->where('type', 'rental_income')->sum('amount')) }} FCFA
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Ce mois</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ number_format(Auth::user()->transactions()->where('type', 'rental_income')->whereMonth('created_at', now()->month)->sum('amount')) }} FCFA
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-building text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Projets actifs</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ Auth::user()->investments()->whereHas('crowdfundingProject', function($q) { $q->where('status', 'funded'); })->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-percentage text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">ROI moyen</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ number_format(Auth::user()->investments()->avg('expected_roi') ?? 0, 1) }}%
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtres</h3>
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">Projet</label>
                    <select name="project_id" id="project_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tous les projets</option>
                        @foreach(Auth::user()->investments()->with('crowdfundingProject')->get() as $investment)
                            <option value="{{ $investment->crowdfundingProject->id }}" {{ request('project_id') == $investment->crowdfundingProject->id ? 'selected' : '' }}>
                                {{ $investment->crowdfundingProject->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
                    <input type="date" name="date_from" id="date_from" 
                           value="{{ request('date_from') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">Date de fin</label>
                    <input type="date" name="date_to" id="date_to" 
                           value="{{ request('date_to') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Filtrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des revenus -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Historique des Revenus</h2>
            </div>

            @if($rentalIncomes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projet</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parts détenues</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant reçu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($rentalIncomes as $income)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $income->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-building text-blue-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $income->crowdfundingProject->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $income->crowdfundingProject->property->location }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($income->shares_owned) }} parts
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="text-green-600 font-semibold">
                                        +{{ number_format($income->amount_received) }} FCFA
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Reçu
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $rentalIncomes->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-chart-line text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun revenu locatif</h3>
                    <p class="text-gray-600 mb-6">Vous n'avez pas encore reçu de revenus locatifs.</p>
                    <a href="{{ route('crowdfunding.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Découvrir des projets
                    </a>
                </div>
            @endif
        </div>

        <!-- Projets d'investissement -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Mes Investissements Actifs</h3>
            
            @if(Auth::user()->investments()->whereHas('crowdfundingProject', function($q) { $q->where('status', 'funded'); })->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(Auth::user()->investments()->whereHas('crowdfundingProject', function($q) { $q->where('status', 'funded'); })->with('crowdfundingProject.property')->get() as $investment)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-building text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $investment->crowdfundingProject->title }}</h4>
                                <p class="text-sm text-gray-500">{{ $investment->crowdfundingProject->property->location }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Parts détenues:</span>
                                <span class="font-medium">{{ number_format($investment->shares_purchased) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Investissement:</span>
                                <span class="font-medium">{{ number_format($investment->amount_invested) }} FCFA</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">ROI attendu:</span>
                                <span class="font-medium text-green-600">{{ $investment->expected_roi }}%</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-chart-line text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 mb-4">Vous n'avez pas encore d'investissements actifs.</p>
                    <a href="{{ route('crowdfunding.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Découvrir des projets
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
