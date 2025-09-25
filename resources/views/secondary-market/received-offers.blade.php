@extends('layouts.app')

@section('title', 'Offres Reçues - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center">
                    <a href="{{ route('secondary-market.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Offres Reçues</h1>
                        <p class="text-gray-600">Gérez les offres reçues sur vos annonces</p>
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
                            <i class="fas fa-handshake text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total offres</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $offers->total() }}</p>
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
                        <p class="text-sm font-medium text-gray-500">En attente</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $offers->where('status', 'pending')->count() }}</p>
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
                        <p class="text-sm font-medium text-gray-500">Acceptées</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $offers->where('status', 'accepted')->count() }}</p>
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
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($offers->sum('total_offer_amount')) }} FCFA</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtres</h3>
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Acceptée</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejetée</option>
                    </select>
                </div>
                
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
                    <input type="date" name="date_from" id="date_from" 
                           value="{{ request('date_from') }}" 
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

        <!-- Liste des offres -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Offres Reçues</h2>
            </div>

            @if($offers->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($offers as $offer)
                    <div class="p-6 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($offer->listing->crowdfundingProject->property->images && count($offer->listing->crowdfundingProject->property->images) > 0)
                                            <img src="{{ asset('storage/' . $offer->listing->crowdfundingProject->property->images[0]) }}" 
                                                 alt="{{ $offer->listing->crowdfundingProject->title }}" 
                                                 class="h-16 w-16 rounded-lg object-cover">
                                        @else
                                            <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-building text-gray-400 text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 truncate">
                                            {{ $offer->listing->crowdfundingProject->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 truncate">
                                            {{ $offer->listing->crowdfundingProject->property->location }}
                                        </p>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-tag mr-1"></i>
                                                {{ $offer->shares_requested }} parts
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                <i class="fas fa-user mr-1"></i>
                                                {{ $offer->user->name }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $offer->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <div class="mb-2">
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($offer->offer_price_per_share, 0, ',', ' ') }} FCFA</p>
                                    <p class="text-sm text-gray-600">par part</p>
                                </div>
                                <div class="mb-4">
                                    <p class="text-lg font-semibold text-primary-600">{{ number_format($offer->total_offer_amount, 0, ',', ' ') }} FCFA</p>
                                    <p class="text-sm text-gray-600">total</p>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
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
                                    
                                    @if($offer->status === 'pending')
                                        <form action="{{ route('secondary-market.accept-offer', $offer) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-success btn-sm"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir accepter cette offre ?')">
                                                <i class="fas fa-check mr-1"></i>
                                                Accepter
                                            </button>
                                        </form>
                                        <form action="{{ route('secondary-market.reject-offer', $offer) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir rejeter cette offre ?')">
                                                <i class="fas fa-times mr-1"></i>
                                                Rejeter
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Message de l'offre -->
                        @if($offer->message)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">
                                <i class="fas fa-comment mr-1"></i>
                                Message de l'acheteur
                            </h4>
                            <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">
                                {{ $offer->message }}
                            </p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $offers->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-handshake text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune offre reçue</h3>
                    <p class="text-gray-600 mb-6">Vous n'avez pas encore reçu d'offre sur vos annonces.</p>
                    <a href="{{ route('secondary-market.my-listings') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-list mr-2"></i>
                        Voir mes annonces
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
