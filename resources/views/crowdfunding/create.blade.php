@extends('layouts.app')

@section('title', 'Créer un Projet Crowdfunding - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Créer un Projet Crowdfunding</h1>
                    <p class="text-gray-600">Lancez un projet de crowdfunding pour votre propriété</p>
                </div>
                <a href="{{ route('crowdfunding.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="POST" action="{{ route('crowdfunding.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <!-- Informations du projet -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Informations du Projet</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titre du projet *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Ex: Villa moderne à Douala - Projet de Crowdfunding">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                        <textarea id="description" name="description" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                  placeholder="Décrivez votre projet en détail...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="property_id" class="block text-sm font-medium text-gray-700 mb-2">Propriété *</label>
                        <select id="property_id" name="property_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Sélectionner une propriété</option>
                            @foreach($properties as $property)
                                <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                    {{ $property->title }} - {{ number_format($property->price) }} FCFA
                                </option>
                            @endforeach
                        </select>
                        @error('property_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="expected_roi" class="block text-sm font-medium text-gray-700 mb-2">ROI Attendu (%) *</label>
                        <input type="number" id="expected_roi" name="expected_roi" value="{{ old('expected_roi', 12) }}" 
                               step="0.1" min="5" max="50"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('expected_roi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Configuration financière -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Configuration Financière</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="total_amount" class="block text-sm font-medium text-gray-700 mb-2">Montant à Lever (FCFA) *</label>
                        <input type="number" id="total_amount" name="total_amount" value="{{ old('total_amount') }}" 
                               min="1000000" step="1000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('total_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="total_shares" class="block text-sm font-medium text-gray-700 mb-2">Nombre de Parts *</label>
                        <input type="number" id="total_shares" name="total_shares" value="{{ old('total_shares', 100) }}" 
                               min="10" max="10000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('total_shares')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="funding_deadline" class="block text-sm font-medium text-gray-700 mb-2">Date Limite de Financement *</label>
                        <input type="date" id="funding_deadline" name="funding_deadline" 
                               value="{{ old('funding_deadline', now()->addDays(30)->format('Y-m-d')) }}"
                               min="{{ now()->addDay()->format('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('funding_deadline')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prix par Part (Calculé automatiquement)</label>
                        <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600" id="price_per_share_display">
                            {{ number_format(old('total_amount', 0) / old('total_shares', 100), 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                </div>
            </div>

            <!-- Images du projet -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Images du Projet</h2>
                
                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Photos du projet</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-camera text-4xl text-gray-400 mb-4"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                    <span>Télécharger des fichiers</span>
                                    <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG jusqu'à 2MB (max 10 photos)</p>
                        </div>
                    </div>
                    @error('images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Informations supplémentaires -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Informations Supplémentaires</h2>
                
                <div class="space-y-6">
                    <div>
                        <label for="risks" class="block text-sm font-medium text-gray-700 mb-2">Risques du Projet</label>
                        <textarea id="risks" name="risks" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                  placeholder="Décrivez les risques potentiels...">{{ old('risks') }}</textarea>
                        @error('risks')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="benefits" class="block text-sm font-medium text-gray-700 mb-2">Avantages du Projet</label>
                        <textarea id="benefits" name="benefits" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                  placeholder="Décrivez les avantages pour les investisseurs...">{{ old('benefits') }}</textarea>
                        @error('benefits')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('crowdfunding.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Créer le Projet
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalAmount = document.getElementById('total_amount');
    const totalShares = document.getElementById('total_shares');
    const pricePerShareDisplay = document.getElementById('price_per_share_display');

    function updatePricePerShare() {
        const amount = parseFloat(totalAmount.value) || 0;
        const shares = parseInt(totalShares.value) || 1;
        const pricePerShare = amount / shares;
        
        if (pricePerShare > 0) {
            pricePerShareDisplay.textContent = new Intl.NumberFormat('fr-FR').format(Math.round(pricePerShare)) + ' FCFA';
        } else {
            pricePerShareDisplay.textContent = '0 FCFA';
        }
    }

    totalAmount.addEventListener('input', updatePricePerShare);
    totalShares.addEventListener('input', updatePricePerShare);
});
</script>
@endsection