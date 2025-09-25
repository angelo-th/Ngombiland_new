@extends('layouts.app')

@section('title', 'Créer une Annonce - NGOMBILAND')

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
                        <h1 class="text-3xl font-bold text-gray-900">Créer une Annonce</h1>
                        <p class="text-gray-600">Vendez vos parts d'investissement</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Formulaire de création -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Détails de l'annonce</h2>
                
                <form action="{{ route('secondary-market.store') }}" method="POST" id="createListingForm">
                    @csrf
                    
                    <!-- Investissement à vendre -->
                    <div class="mb-6">
                        <label for="crowdfunding_investment_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Investissement à vendre
                        </label>
                        <select name="crowdfunding_investment_id" id="crowdfunding_investment_id" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Sélectionnez un investissement</option>
                            @foreach($userInvestments as $investment)
                                <option value="{{ $investment->id }}" 
                                        data-shares="{{ $investment->shares_purchased }}"
                                        data-project="{{ $investment->crowdfundingProject->title }}"
                                        data-location="{{ $investment->crowdfundingProject->property->location }}">
                                    {{ $investment->crowdfundingProject->title }} - {{ $investment->shares_purchased }} parts
                                </option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Sélectionnez l'investissement dont vous souhaitez vendre des parts</p>
                    </div>

                    <!-- Nombre de parts à vendre -->
                    <div class="mb-6">
                        <label for="shares_for_sale" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre de parts à vendre
                        </label>
                        <input type="number" 
                               id="shares_for_sale" 
                               name="shares_for_sale" 
                               min="1" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Entrez le nombre de parts"
                               required>
                        <p class="text-sm text-gray-500 mt-1">Maximum: <span id="maxShares">0</span> parts</p>
                    </div>

                    <!-- Prix par part -->
                    <div class="mb-6">
                        <label for="price_per_share" class="block text-sm font-medium text-gray-700 mb-2">
                            Prix par part (FCFA)
                        </label>
                        <input type="number" 
                               id="price_per_share" 
                               name="price_per_share" 
                               min="1" 
                               step="0.01"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Entrez le prix par part"
                               required>
                        <p class="text-sm text-gray-500 mt-1">Prix de vente par part</p>
                    </div>

                    <!-- Montant total (calculé automatiquement) -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Montant total
                        </label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-lg font-semibold text-gray-900" id="totalPrice">
                            0 FCFA
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Calculé automatiquement</p>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description (optionnel)
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Ajoutez une description pour votre annonce..."></textarea>
                        <p class="text-sm text-gray-500 mt-1">Décrivez pourquoi vous vendez ces parts</p>
                    </div>

                    <!-- Bouton de soumission -->
                    <button type="submit" 
                            class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium">
                        <i class="fas fa-plus mr-2"></i>
                        Créer l'annonce
                    </button>
                </form>
            </div>

            <!-- Informations et aide -->
            <div class="space-y-6">
                <!-- Détails de l'investissement sélectionné -->
                <div id="investmentDetails" class="bg-white rounded-lg shadow-lg p-6 hidden">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Détails de l'investissement</h3>
                    <div id="investmentInfo" class="space-y-3">
                        <!-- Les détails seront remplis dynamiquement -->
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4">
                        <i class="fas fa-info-circle mr-2"></i>
                        Instructions
                    </h3>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 mr-2 mt-0.5"></i>
                            Sélectionnez l'investissement dont vous souhaitez vendre des parts
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 mr-2 mt-0.5"></i>
                            Indiquez le nombre de parts que vous souhaitez vendre
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 mr-2 mt-0.5"></i>
                            Définissez le prix de vente par part
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 mr-2 mt-0.5"></i>
                            Ajoutez une description pour attirer les acheteurs
                        </li>
                    </ul>
                </div>

                <!-- Conseils de vente -->
                <div class="bg-green-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-green-900 mb-4">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Conseils de vente
                    </h3>
                    <ul class="space-y-2 text-sm text-green-800">
                        <li class="flex items-start">
                            <i class="fas fa-star text-green-600 mr-2 mt-0.5"></i>
                            Fixez un prix compétitif par rapport au marché
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-star text-green-600 mr-2 mt-0.5"></i>
                            Rédigez une description claire et attractive
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-star text-green-600 mr-2 mt-0.5"></i>
                            Vendez par lots pour attirer plus d'acheteurs
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-star text-green-600 mr-2 mt-0.5"></i>
                            Répondez rapidement aux offres reçues
                        </li>
                    </ul>
                </div>

                <!-- Conditions de vente -->
                <div class="bg-yellow-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-yellow-900 mb-4">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Conditions de vente
                    </h3>
                    <ul class="space-y-2 text-sm text-yellow-800">
                        <li class="flex items-start">
                            <i class="fas fa-ban text-yellow-600 mr-2 mt-0.5"></i>
                            Vous ne pouvez vendre que les parts que vous possédez
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-ban text-yellow-600 mr-2 mt-0.5"></i>
                            Les annonces expirent après 30 jours
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-ban text-yellow-600 mr-2 mt-0.5"></i>
                            Vous pouvez annuler votre annonce à tout moment
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-ban text-yellow-600 mr-2 mt-0.5"></i>
                            Les frais de transaction sont à la charge de l'acheteur
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const investmentSelect = document.getElementById('crowdfunding_investment_id');
    const sharesInput = document.getElementById('shares_for_sale');
    const priceInput = document.getElementById('price_per_share');
    const totalPriceDiv = document.getElementById('totalPrice');
    const maxSharesSpan = document.getElementById('maxShares');
    const investmentDetails = document.getElementById('investmentDetails');
    const investmentInfo = document.getElementById('investmentInfo');

    // Mise à jour des détails de l'investissement
    investmentSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const shares = selectedOption.dataset.shares;
            const project = selectedOption.dataset.project;
            const location = selectedOption.dataset.location;
            
            maxSharesSpan.textContent = shares;
            sharesInput.max = shares;
            sharesInput.value = Math.min(sharesInput.value || 1, shares);
            
            // Afficher les détails de l'investissement
            investmentInfo.innerHTML = `
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-building text-blue-600"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">${project}</h4>
                        <p class="text-sm text-gray-600">${location}</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Parts détenues:</span>
                        <span class="font-medium">${shares} parts</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Parts à vendre:</span>
                        <span class="font-medium" id="sharesToSell">0 parts</span>
                    </div>
                </div>
            `;
            investmentDetails.classList.remove('hidden');
        } else {
            investmentDetails.classList.add('hidden');
        }
        updateTotalPrice();
    });

    // Mise à jour du nombre de parts à vendre
    sharesInput.addEventListener('input', function() {
        const maxShares = parseInt(maxSharesSpan.textContent);
        if (parseInt(this.value) > maxShares) {
            this.value = maxShares;
        }
        updateTotalPrice();
        updateSharesToSell();
    });

    // Mise à jour du prix par part
    priceInput.addEventListener('input', updateTotalPrice);

    // Mise à jour du prix total
    function updateTotalPrice() {
        const shares = parseInt(sharesInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const total = shares * price;
        totalPriceDiv.textContent = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
    }

    // Mise à jour du nombre de parts à vendre dans les détails
    function updateSharesToSell() {
        const sharesToSellSpan = document.getElementById('sharesToSell');
        if (sharesToSellSpan) {
            sharesToSellSpan.textContent = (sharesInput.value || 0) + ' parts';
        }
    }
});
</script>
@endpush
@endsection
