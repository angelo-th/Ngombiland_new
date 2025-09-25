@extends('layouts.app')

@section('title', 'Marketplace Secondaire')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-exchange-alt mr-3 text-primary-600"></i>
                Marketplace Secondaire
            </h1>
            <p class="text-gray-600 mt-2">Achetez et vendez vos parts d'investissement</p>
        </div>
        <a href="{{ route('secondary-market.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>
            Vendre mes Parts
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtres</h3>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="project_id" class="form-label">Projet</label>
                <select name="project_id" id="project_id" class="form-select">
                    <option value="">Tous les projets</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="min_price" class="form-label">Prix min (FCFA)</label>
                <input type="number" name="min_price" id="min_price" 
                       value="{{ request('min_price') }}" 
                       class="form-input" placeholder="0">
            </div>
            
            <div>
                <label for="max_price" class="form-label">Prix max (FCFA)</label>
                <input type="number" name="max_price" id="max_price" 
                       value="{{ request('max_price') }}" 
                       class="form-input" placeholder="1000000">
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary w-full">
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
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-list text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Annonces Actives</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $listings->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-handshake text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Transactions</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-coins text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Volume Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($listings->sum('total_price'), 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-percentage text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Prix Moyen</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($listings->avg('price_per_share') ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des annonces -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Annonces Disponibles</h2>
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
                                        <span class="text-sm text-gray-500">
                                            <i class="fas fa-user mr-1"></i>
                                            {{ $listing->user->name }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $listing->days_remaining }} jours restants
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
                            
                            @if($listing->price_difference != 0)
                                <div class="text-sm {{ $listing->price_difference > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    <i class="fas fa-arrow-{{ $listing->price_difference > 0 ? 'up' : 'down' }} mr-1"></i>
                                    {{ $listing->price_difference > 0 ? '+' : '' }}{{ number_format($listing->price_difference_percentage, 1) }}%
                                </div>
                            @endif
                            
                            <div class="flex space-x-2 mt-4">
                                <a href="{{ route('secondary-market.show', $listing) }}" 
                                   class="btn btn-outline btn-sm">
                                    <i class="fas fa-eye mr-1"></i>
                                    Voir
                                </a>
                                @if($listing->user_id !== Auth::id())
                                    <button onclick="openOfferModal({{ $listing->id }}, {{ $listing->price_per_share }}, {{ $listing->shares_for_sale }})"
                                            class="btn btn-primary btn-sm">
                                        <i class="fas fa-handshake mr-1"></i>
                                        Faire Offre
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $listings->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <i class="fas fa-exchange-alt text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune annonce disponible</h3>
                <p class="text-gray-600">Il n'y a actuellement aucune annonce correspondant à vos critères.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal d'offre -->
<div id="offerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50" x-data="offerModal()">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Faire une Offre</h3>
            <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form @submit.prevent="submitOffer()">
            <div class="space-y-4">
                <div>
                    <label class="form-label">Nombre de parts</label>
                    <input type="number" x-model="sharesRequested" :max="maxShares" min="1" class="form-input" required>
                    <p class="text-sm text-gray-500 mt-1">Maximum: <span x-text="maxShares"></span> parts</p>
                </div>
                
                <div>
                    <label class="form-label">Prix par part (FCFA)</label>
                    <input type="number" x-model="offerPricePerShare" step="0.01" min="0" class="form-input" required>
                </div>
                
                <div>
                    <label class="form-label">Montant total</label>
                    <div class="form-input bg-gray-50" x-text="formatPrice(totalAmount)"></div>
                </div>
                
                <div>
                    <label class="form-label">Message (optionnel)</label>
                    <textarea x-model="message" class="form-textarea" rows="3" placeholder="Ajoutez un message..."></textarea>
                </div>
                
                <div class="flex space-x-3">
                    <button type="button" @click="closeModal()" class="btn btn-outline flex-1">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary flex-1">
                        <i class="fas fa-handshake mr-2"></i>
                        Envoyer Offre
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openOfferModal(listingId, pricePerShare, maxShares) {
    document.getElementById('offerModal').classList.remove('hidden');
    document.getElementById('offerModal').classList.add('flex');
    
    // Initialiser les valeurs
    window.offerModalData = {
        listingId: listingId,
        pricePerShare: pricePerShare,
        maxShares: maxShares,
        sharesRequested: 1,
        offerPricePerShare: pricePerShare,
        message: ''
    };
}

function offerModal() {
    return {
        listingId: 0,
        pricePerShare: 0,
        maxShares: 0,
        sharesRequested: 1,
        offerPricePerShare: 0,
        message: '',
        
        init() {
            if (window.offerModalData) {
                this.listingId = window.offerModalData.listingId;
                this.pricePerShare = window.offerModalData.pricePerShare;
                this.maxShares = window.offerModalData.maxShares;
                this.sharesRequested = window.offerModalData.sharesRequested;
                this.offerPricePerShare = window.offerModalData.offerPricePerShare;
                this.message = window.offerModalData.message;
            }
        },
        
        get totalAmount() {
            return this.sharesRequested * this.offerPricePerShare;
        },
        
        formatPrice(amount) {
            return new Intl.NumberFormat('fr-FR').format(amount || 0) + ' FCFA';
        },
        
        closeModal() {
            document.getElementById('offerModal').classList.add('hidden');
            document.getElementById('offerModal').classList.remove('flex');
        },
        
        submitOffer() {
            // Ici vous pouvez ajouter la logique pour envoyer l'offre
            console.log('Offre:', {
                listingId: this.listingId,
                sharesRequested: this.sharesRequested,
                offerPricePerShare: this.offerPricePerShare,
                message: this.message
            });
            
            this.closeModal();
        }
    }
}
</script>
@endpush
@endsection
