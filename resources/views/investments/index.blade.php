@extends('layouts.app')

@section('title', 'Mes Investissements - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mes Investissements</h1>
            <p class="mt-2 text-gray-600">Suivez la performance de vos investissements</p>
        </div>

        <!-- Statistiques rapides -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card">
                <div class="card-body text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-chart-line text-primary-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $investments->count() }}</h3>
                    <p class="text-gray-600">Investissements totaux</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center">
                    <div class="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-money-bill-wave text-secondary-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($investments->sum('amount'), 0, ',', ' ') }} FCFA</h3>
                    <p class="text-gray-600">Montant total investi</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center">
                    <div class="w-12 h-12 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-percentage text-accent-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">0%</h3>
                    <p class="text-gray-600">ROI moyen</p>
                </div>
            </div>
        </div>

        <!-- Liste des investissements -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Tous mes investissements</h2>
            </div>
            <div class="card-body">
                @forelse($investments as $investment)
                <div class="flex items-center space-x-6 py-4 border-b border-gray-200 last:border-b-0">
                    <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-green-600 text-xl"></i>
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $investment->property->title ?? 'Projet supprimé' }}
                        </h3>
                        <p class="text-gray-600">{{ $investment->property->location ?? 'Localisation inconnue' }}</p>
                        <div class="flex items-center space-x-4 mt-2">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $investment->created_at->format('d/m/Y') }}
                            </span>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-tag mr-1"></i>
                                {{ $investment->property->type ?? 'Type inconnu' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-2xl font-bold text-gray-900">
                            {{ number_format($investment->amount, 0, ',', ' ') }} FCFA
                        </p>
                        <span class="badge {{ $investment->status === 'active' ? 'badge-success' : 'badge-warning' }}">
                            {{ ucfirst($investment->status) }}
                        </span>
                        <div class="mt-2">
                            <a href="{{ route('investments.show', $investment) }}" 
                               class="btn btn-outline btn-sm">
                                <i class="fas fa-eye mr-1"></i>
                                Voir détails
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <i class="fas fa-chart-line text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun investissement</h3>
                    <p class="text-gray-600 mb-6">Vous n'avez pas encore investi dans des projets</p>
                    <a href="{{ route('crowdfunding.index') }}" class="btn btn-primary">
                        <i class="fas fa-search mr-2"></i>
                        Découvrir des projets
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if($investments->hasPages())
        <div class="mt-8">
            {{ $investments->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
