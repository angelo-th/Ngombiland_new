@extends('layouts.app')

@section('title', 'Détail de l\'Annonce - NGOMBILAND')

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
                        <h1 class="text-3xl font-bold text-gray-900">Détail de l'Annonce</h1>
                        <p class="text-gray-600">Informations sur cette annonce de vente</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informations principales -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            @if($listing->crowdfundingProject->property->images && count($listing->crowdfundingProject->property->images) > 0)
                                <img src="{{ asset('storage/' . $listing->crowdfundingProject->property->images[0]) }}" 
                                     alt="{{ $listing->crowdfundingProject->title }}" 
                                     class="h-20 w-20 rounded-lg object-cover">
                            @else
                                <div class="h-20 w-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-building text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $listing->crowdfundingProject->title }}</h2>
                                <p class="text-gray-600">{{ $listing->crowdfundingProject->property->location }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
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
                        </div>
                    </div>

                    <!-- Détails de l'annonce -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ number_format($listing->shares_for_sale) }}</div>
                            <div class="text-sm text-gray-600">Parts à vendre</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ number_format($listing->price_per_share, 0, ',', ' ') }}</div>
                            <div class="text-sm text-gray-600">FCFA par part</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-primary-600">{{ number_format($listing->total_price, 0, ',', ' ') }}</div>
                            <div class="text-sm text-gray-600">FCFA total</div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($listing->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-600">{{ $listing->description }}</p>
                    </div>
                    @endif

                    <!-- Informations du vendeur -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Vendeur</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-gray-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $listing->user->name }}</p>
                                <p class="text-sm text-gray-600">Membre depuis {{ $listing->user->created_at->format('M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Offres reçues (si c'est votre annonce) -->
                @if($listing->user_id === Auth::id())
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-handshake mr-2"></i>
                        Offres Reçues ({{ $listing->offers->count() }})
                    </h3>
                    
                    @if($listing->offers->count() > 0)
                        <div class="space-y-4">
                            @foreach($listing->offers as $offer)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-600">
                                                {{ substr($offer->user->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $offer->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $offer->shares_requested }} parts • {{ number_format($offer->offer_price_per_share) }} FCFA/part</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-lg font-semibold text-gray-900">
                                            {{ number_format($offer->total_offer_amount) }} FCFA
                                        </div>
                                        <div class="flex items-center space-x-2 mt-2">
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
                                            @if($offer->status === 'pending')
                                                <form action="{{ route('secondary-market.accept-offer', $offer) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir accepter cette offre ?')">
                                                        Accepter
                                                    </button>
                                                </form>
                                                <form action="{{ route('secondary-market.reject-offer', $offer) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir rejeter cette offre ?')">
                                                        Rejeter
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($offer->message)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded">
                                        <strong>Message:</strong> {{ $offer->message }}
                                    </p>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-handshake text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-600">Aucune offre reçue pour le moment</p>
                        </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                    
                    @if($listing->user_id === Auth::id())
                        <!-- Actions pour le vendeur -->
                        @if($listing->status === 'active')
                            <form action="{{ route('secondary-market.cancel', $listing) }}" method="POST" class="mb-4">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors"
                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler cette annonce ?')">
                                    <i class="fas fa-times mr-2"></i>
                                    Annuler l'annonce
                                </button>
                            </form>
                        @endif
                    @else
                        <!-- Actions pour l'acheteur -->
                        @if($listing->status === 'active')
                            @if($myOffer)
                                <div class="text-center py-4">
                                    <p class="text-gray-600 mb-2">Vous avez déjà fait une offre</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($myOffer->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($myOffer->status === 'accepted') bg-green-100 text-green-800
                                        @elseif($myOffer->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        @if($myOffer->status === 'pending') En attente
                                        @elseif($myOffer->status === 'accepted') Acceptée
                                        @elseif($myOffer->status === 'rejected') Rejetée
                                        @else {{ ucfirst($myOffer->status) }}
                                        @endif
                                    </span>
                                </div>
                            @else
                                <button onclick="openOfferModal()" 
                                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-handshake mr-2"></i>
                                    Faire une offre
                                </button>
                            @endif
                        @endif
                    @endif
                </div>

                <!-- Informations du projet -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations du projet</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Type:</span>
                            <span class="font-medium capitalize">{{ $listing->crowdfundingProject->property->type }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Prix original:</span>
                            <span class="font-medium">{{ number_format($listing->crowdfundingProject->price_per_share) }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">ROI attendu:</span>
                            <span class="font-medium text-green-600">{{ $listing->crowdfundingProject->expected_roi }}%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Date de création:</span>
                            <span class="font-medium">{{ $listing->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact</h3>
                    <div class="space-y-3">
                        <a href="{{ route('messages.create', ['user' => $listing->user->id]) }}" 
                           class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors text-center block">
                            <i class="fas fa-envelope mr-2"></i>
                            Contacter le vendeur
                        </a>
                    </div>
                </div>
            </div>
        </div>
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de parts</label>
                    <input type="number" x-model="sharesRequested" :max="{{ $listing->shares_for_sale }}" min="1" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           required>
                    <p class="text-sm text-gray-500 mt-1">Maximum: {{ $listing->shares_for_sale }} parts</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prix par part (FCFA)</label>
                    <input type="number" x-model="offerPricePerShare" step="0.01" min="0" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Montant total</label>
                    <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-lg font-semibold" x-text="formatPrice(totalAmount)"></div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message (optionnel)</label>
                    <textarea x-model="message" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                              rows="3" placeholder="Ajoutez un message..."></textarea>
                </div>
                
                <div class="flex space-x-3">
                    <button type="button" @click="closeModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
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
function openOfferModal() {
    document.getElementById('offerModal').classList.remove('hidden');
    document.getElementById('offerModal').classList.add('flex');
}

function offerModal() {
    return {
        sharesRequested: 1,
        offerPricePerShare: {{ $listing->price_per_share }},
        message: '',
        
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
            // Soumettre le formulaire d'offre
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("secondary-market.offer", $listing) }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const sharesInput = document.createElement('input');
            sharesInput.type = 'hidden';
            sharesInput.name = 'shares_requested';
            sharesInput.value = this.sharesRequested;
            
            const priceInput = document.createElement('input');
            priceInput.type = 'hidden';
            priceInput.name = 'offer_price_per_share';
            priceInput.value = this.offerPricePerShare;
            
            const messageInput = document.createElement('input');
            messageInput.type = 'hidden';
            messageInput.name = 'message';
            messageInput.value = this.message;
            
            form.appendChild(csrfToken);
            form.appendChild(sharesInput);
            form.appendChild(priceInput);
            form.appendChild(messageInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    }
}
</script>
@endpush
@endsection
