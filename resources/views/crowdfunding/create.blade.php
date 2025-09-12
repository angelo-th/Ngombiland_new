@extends('layouts.app')

@section('title', 'Créer un projet de crowdfunding - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Créer un projet de crowdfunding</h1>
                    <p class="mt-2 text-gray-600">Transformez votre propriété en opportunité d'investissement</p>
                </div>
                <a href="{{ route('crowdfunding.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('crowdfunding.store') }}" method="POST" enctype="multipart/form-data" x-data="crowdfundingForm()">
                    @csrf
                    
                    <!-- Étape 1: Sélection de la propriété -->
                    <div x-show="currentStep === 1" x-transition>
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">1. Sélectionner une propriété</h3>
                        
                        @if($properties->count() > 0)
                            <div class="space-y-4">
                                @foreach($properties as $property)
                                <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-primary-300 cursor-pointer">
                                    <input type="radio" name="property_id" value="{{ $property->id }}" 
                                           class="form-radio text-primary-600" 
                                           x-model="selectedProperty"
                                           @change="updatePropertyInfo({{ $property->toJson() }})">
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-semibold text-gray-900">{{ $property->title }}</h4>
                                            <span class="text-lg font-bold text-primary-600">{{ number_format($property->price, 0, ',', ' ') }} FCFA</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">{{ $property->location }}</p>
                                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                            <span><i class="fas fa-home mr-1"></i>{{ ucfirst($property->type) }}</span>
                                            @if($property->area)
                                                <span><i class="fas fa-ruler-combined mr-1"></i>{{ $property->area }} m²</span>
                                            @endif
                                        </div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-home text-4xl text-gray-300 mb-4"></i>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune propriété disponible</h3>
                                <p class="text-gray-600 mb-4">Vous devez d'abord ajouter une propriété pour créer un projet de crowdfunding.</p>
                                <a href="{{ route('properties.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus mr-2"></i>
                                    Ajouter une propriété
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Étape 2: Informations du projet -->
                    <div x-show="currentStep === 2" x-transition>
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">2. Informations du projet</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="form-label">Titre du projet *</label>
                                <input type="text" id="title" name="title" class="form-input" 
                                       value="{{ old('title') }}" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="form-label">Description du projet *</label>
                                <textarea id="description" name="description" rows="4" class="form-textarea" required>{{ old('description') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Décrivez votre projet, ses avantages et son potentiel d'investissement.</p>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="total_amount" class="form-label">Montant total à lever (FCFA) *</label>
                                    <input type="number" id="total_amount" name="total_amount" class="form-input" 
                                           value="{{ old('total_amount') }}" min="1000000" required>
                                    <p class="text-sm text-gray-500 mt-1">Minimum 1,000,000 FCFA</p>
                                    @error('total_amount')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="total_shares" class="form-label">Nombre de parts *</label>
                                    <input type="number" id="total_shares" name="total_shares" class="form-input" 
                                           value="{{ old('total_shares') }}" min="10" max="10000" required>
                                    <p class="text-sm text-gray-500 mt-1">Entre 10 et 10,000 parts</p>
                                    @error('total_shares')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="expected_roi" class="form-label">ROI attendu (%) *</label>
                                    <input type="number" id="expected_roi" name="expected_roi" class="form-input" 
                                           value="{{ old('expected_roi') }}" min="5" max="50" step="0.1" required>
                                    <p class="text-sm text-gray-500 mt-1">Entre 5% et 50% par an</p>
                                    @error('expected_roi')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="funding_deadline" class="form-label">Date limite de levée *</label>
                                    <input type="date" id="funding_deadline" name="funding_deadline" class="form-input" 
                                           value="{{ old('funding_deadline') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                    @error('funding_deadline')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Calcul automatique du prix par part -->
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-blue-900 mb-2">Calcul automatique</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <span class="text-blue-700">Prix par part:</span>
                                        <span class="font-semibold" x-text="formatPrice(pricePerShare)"></span> FCFA
                                    </div>
                                    <div>
                                        <span class="text-blue-700">Montant total:</span>
                                        <span class="font-semibold" x-text="formatPrice(totalAmount)"></span> FCFA
                                    </div>
                                    <div>
                                        <span class="text-blue-700">Parts disponibles:</span>
                                        <span class="font-semibold" x-text="totalShares"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 3: Détails et risques -->
                    <div x-show="currentStep === 3" x-transition>
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">3. Détails et risques</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="benefits" class="form-label">Avantages pour les investisseurs</label>
                                <textarea id="benefits" name="benefits" rows="3" class="form-textarea">{{ old('benefits') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Décrivez les avantages et bénéfices pour les investisseurs.</p>
                                @error('benefits')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="risks" class="form-label">Risques identifiés</label>
                                <textarea id="risks" name="risks" rows="3" class="form-textarea">{{ old('risks') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Décrivez les risques potentiels liés à cet investissement.</p>
                                @error('risks')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="images" class="form-label">Images du projet</label>
                                <input type="file" id="images" name="images[]" class="form-input" 
                                       multiple accept="image/*">
                                <p class="text-sm text-gray-500 mt-1">Ajoutez des images pour illustrer votre projet (max 5 images, 2MB chacune).</p>
                                @error('images')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Navigation des étapes -->
                    <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                        <button type="button" @click="previousStep()" 
                                x-show="currentStep > 1"
                                class="btn btn-outline">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Précédent
                        </button>
                        
                        <div class="flex space-x-2">
                            <button type="button" @click="nextStep()" 
                                    x-show="currentStep < 3"
                                    class="btn btn-primary">
                                Suivant
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                            
                            <button type="submit" 
                                    x-show="currentStep === 3"
                                    class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>
                                Créer le projet
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function crowdfundingForm() {
    return {
        currentStep: 1,
        selectedProperty: null,
        totalAmount: 0,
        totalShares: 0,
        
        get pricePerShare() {
            return this.totalAmount > 0 && this.totalShares > 0 ? this.totalAmount / this.totalShares : 0;
        },
        
        nextStep() {
            if (this.validateCurrentStep()) {
                this.currentStep++;
            }
        },
        
        previousStep() {
            this.currentStep--;
        },
        
        validateCurrentStep() {
            if (this.currentStep === 1) {
                return this.selectedProperty !== null;
            }
            
            if (this.currentStep === 2) {
                const requiredFields = ['title', 'description', 'total_amount', 'total_shares', 'expected_roi', 'funding_deadline'];
                for (let field of requiredFields) {
                    const element = document.querySelector(`[name="${field}"]`);
                    if (!element || !element.value.trim()) {
                        element.focus();
                        return false;
                    }
                }
                return true;
            }
            
            return true;
        },
        
        updatePropertyInfo(property) {
            // Optionnel : pré-remplir des champs basés sur la propriété sélectionnée
            console.log('Propriété sélectionnée:', property);
        },
        
        formatPrice(price) {
            return new Intl.NumberFormat('fr-FR').format(Math.round(price));
        }
    }
}

// Mise à jour des calculs en temps réel
document.addEventListener('DOMContentLoaded', function() {
    const totalAmountInput = document.getElementById('total_amount');
    const totalSharesInput = document.getElementById('total_shares');
    
    function updateCalculations() {
        const totalAmount = parseFloat(totalAmountInput.value) || 0;
        const totalShares = parseInt(totalSharesInput.value) || 0;
        
        // Mettre à jour les valeurs dans Alpine.js
        const form = document.querySelector('[x-data="crowdfundingForm()"]');
        if (form && form._x_dataStack) {
            form._x_dataStack[0].totalAmount = totalAmount;
            form._x_dataStack[0].totalShares = totalShares;
        }
    }
    
    if (totalAmountInput) totalAmountInput.addEventListener('input', updateCalculations);
    if (totalSharesInput) totalSharesInput.addEventListener('input', updateCalculations);
});
</script>
@endpush
@endsection
