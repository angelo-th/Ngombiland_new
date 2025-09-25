@extends('layouts.app')

@section('title', 'Mes Annonces - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('secondary-market.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Mes Annonces</h1>
                            <p class="text-gray-600">Gérez vos annonces de vente de parts</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('secondary-market.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Nouvelle Annonce
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-list text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total annonces</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $listings->total() }}</p>
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
                        <p class="text-sm font-medium text-gray-500">Annonces actives</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $listings->where('status', 'active')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-handshake text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Offres reçues</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $listings->sum(function($listing) { return $listing->offers->count(); }) }}</p>
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
                        <p class="text-sm font-medium text-gray-500">Valeur totale</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($listings->sum('total_price')) }} FCFA</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des annonces -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Mes Annonces</h2>
            </div>

            @if($listings->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($listings as $listing)
                    <div class="p-6 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($listing->crowdfundingProject->property->images && count($listing->crowdfundingProject->property->images) > 0)
                                            <img src="{{ asset('storage/' . $listing->crowdfundingProject->property->images[0]) }}" 
                                                 alt="{{ $listing->crowdfundingProject->title }}" 
                                                 class="h-16 w-16 rounded-lg object-cover">
                                        @else
                                            <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-building text-gray-400 text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 truncate">
                                            {{ $listing->crowdfundingProject->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 truncate">
                                            {{ $listing->crowdfundingProject->property->location }}
                                        </p>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-tag mr-1"></i>
                                                {{ $listing->shares_for_sale }} parts
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($listing->status === 'active') bg-green-100 text-green-800
                                                @elseif($listing->status === 'sold') bg-blue-100 text-blue-800
                                                @elseif($listing->status === 'cancelled') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                @if($listing->status === 'active') Actif
                                                @elseif($listing->status === 'sold') Vendu
                                                @elseif($listing->status === 'cancelled') Annulé
                                                @else {{ ucfirst($listing->status) }}
                                                @endif
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $listing->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <div class="mb-2">
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($listing->price_per_share, 0, ',', ' ') }} FCFA</p>
                                    <p class="text-sm text-gray-600">par part</p>
                                </div>
                                <div class="mb-4">
                                    <p class="text-lg font-semibold text-primary-600">{{ number_format($listing->total_price, 0, ',', ' ') }} FCFA</p>
                                    <p class="text-sm text-gray-600">total</p>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('secondary-market.show', $listing) }}" 
                                       class="btn btn-outline btn-sm">
                                        <i class="fas fa-eye mr-1"></i>
                                        Voir
                                    </a>
                                    @if($listing->status === 'active')
                                        <form action="{{ route('secondary-market.cancel', $listing) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir annuler cette annonce ?')">
                                                <i class="fas fa-times mr-1"></i>
                                                Annuler
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Offres reçues -->
                        @if($listing->offers->count() > 0)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">
                                <i class="fas fa-handshake mr-1"></i>
                                Offres reçues ({{ $listing->offers->count() }})
                            </h4>
                            <div class="space-y-2">
                                @foreach($listing->offers->take(3) as $offer)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-600">
                                                {{ substr($offer->user->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $offer->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $offer->shares_requested }} parts • {{ number_format($offer->offer_price_per_share) }} FCFA/part</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-semibold text-gray-900">
                                            {{ number_format($offer->total_offer_amount) }} FCFA
                                        </span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($offer->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($offer->status === 'accepted') bg-green-100 text-green-800
                                            @elseif($offer->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            @if($offer->status === 'pending') En attente
                                            @elseif($offer->status === 'accepted') Acceptée
                                            @elseif($offer->status === 'rejected') Rejetée
                                            @else {{ ucfirst($offer->status) }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                                @if($listing->offers->count() > 3)
                                <p class="text-sm text-gray-500 text-center">
                                    +{{ $listing->offers->count() - 3 }} autres offres
                                </p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $listings->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-list text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune annonce</h3>
                    <p class="text-gray-600 mb-6">Vous n'avez pas encore créé d'annonce de vente.</p>
                    <a href="{{ route('secondary-market.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Créer ma première annonce
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
