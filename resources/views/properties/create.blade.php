@extends('layouts.app')

@section('title', 'Ajouter une propriété - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Ajouter une propriété</h1>
                    <p class="mt-2 text-gray-600">Publiez votre bien immobilier sur NGOMBILAND</p>
                </div>
                <a href="{{ route('properties.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" x-data="propertyForm()">
                    @csrf
                    
                    <!-- Étape 1: Informations de base -->
                    <div x-show="currentStep === 1" x-transition>
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Informations de base</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="title" class="form-label">Titre de l'annonce *</label>
                                <input type="text" id="title" name="title" class="form-input" 
                                       value="{{ old('title') }}" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="type" class="form-label">Type de bien *</label>
                                <select id="type" name="type" class="form-select" required>
                                    <option value="">Sélectionner un type</option>
                                    <option value="appartement" {{ old('type') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                    <option value="villa" {{ old('type') == 'villa' ? 'selected' : '' }}>Villa</option>
                                    <option value="maison" {{ old('type') == 'maison' ? 'selected' : '' }}>Maison</option>
                                    <option value="terrain" {{ old('type') == 'terrain' ? 'selected' : '' }}>Terrain</option>
                                    <option value="bureau" {{ old('type') == 'bureau' ? 'selected' : '' }}>Bureau</option>
                                </select>
                                @error('type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="form-label">Statut *</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="">Sélectionner un statut</option>
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                                    <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Loué</option>
                                    <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Vendu</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="price" class="form-label">Prix (FCFA) *</label>
                                <input type="number" id="price" name="price" class="form-input" 
                                       value="{{ old('price') }}" min="0" required>
                                @error('price')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="area" class="form-label">Superficie (m²)</label>
                                <input type="number" id="area" name="area" class="form-input" 
                                       value="{{ old('area') }}" min="0">
                                @error('area')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="description" class="form-label">Description *</label>
                            <textarea id="description" name="description" rows="4" class="form-textarea" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Étape 2: Localisation -->
                    <div x-show="currentStep === 2" x-transition>
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Localisation</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="location" class="form-label">Adresse complète *</label>
                                <input type="text" id="location" name="location" class="form-input" 
                                       value="{{ old('location') }}" placeholder="Ex: Douala, Bonanjo, Rue de la Paix" required>
                                @error('location')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" id="latitude" name="latitude" class="form-input" 
                                       value="{{ old('latitude') }}" placeholder="Ex: 4.0483">
                                @error('latitude')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="form-input" 
                                       value="{{ old('longitude') }}" placeholder="Ex: 9.7043">
                                @error('longitude')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <p class="text-sm text-gray-600 mb-2">Cliquez sur la carte pour définir la position exacte</p>
                            <div id="map" class="w-full h-64 bg-gray-200 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                <p class="text-gray-500">Carte interactive (Mapbox sera intégré)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 3: Images et détails -->
                    <div x-show="currentStep === 3" x-transition>
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Images et détails</h3>
                        
                        <div class="mb-6">
                            <label for="images" class="form-label">Photos de la propriété</label>
                            <input type="file" id="images" name="images[]" class="form-input" 
                                   multiple accept="image/*">
                            <p class="text-sm text-gray-500 mt-1">Vous pouvez sélectionner plusieurs images (max 10)</p>
                            @error('images')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="bedrooms" class="form-label">Nombre de chambres</label>
                                <input type="number" id="bedrooms" name="bedrooms" class="form-input" 
                                       value="{{ old('bedrooms') }}" min="0">
                                @error('bedrooms')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="bathrooms" class="form-label">Nombre de salles de bain</label>
                                <input type="number" id="bathrooms" name="bathrooms" class="form-input" 
                                       value="{{ old('bathrooms') }}" min="0">
                                @error('bathrooms')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="floors" class="form-label">Nombre d'étages</label>
                                <input type="number" id="floors" name="floors" class="form-input" 
                                       value="{{ old('floors') }}" min="0">
                                @error('floors')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="year_built" class="form-label">Année de construction</label>
                                <input type="number" id="year_built" name="year_built" class="form-input" 
                                       value="{{ old('year_built') }}" min="1800" max="{{ date('Y') }}">
                                @error('year_built')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="features[]" value="parking" class="form-checkbox">
                                <span class="ml-2 text-gray-700">Parking</span>
                            </label>
                            <label class="flex items-center mt-2">
                                <input type="checkbox" name="features[]" value="garden" class="form-checkbox">
                                <span class="ml-2 text-gray-700">Jardin</span>
                            </label>
                            <label class="flex items-center mt-2">
                                <input type="checkbox" name="features[]" value="pool" class="form-checkbox">
                                <span class="ml-2 text-gray-700">Piscine</span>
                            </label>
                            <label class="flex items-center mt-2">
                                <input type="checkbox" name="features[]" value="security" class="form-checkbox">
                                <span class="ml-2 text-gray-700">Sécurité</span>
                            </label>
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
                                Publier la propriété
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
function propertyForm() {
    return {
        currentStep: 1,
        
        nextStep() {
            if (this.validateCurrentStep()) {
                this.currentStep++;
            }
        },
        
        previousStep() {
            this.currentStep--;
        },
        
        validateCurrentStep() {
            // Validation basique côté client
            const currentStepElement = document.querySelector(`[x-show="currentStep === ${this.currentStep}"]`);
            const requiredFields = currentStepElement.querySelectorAll('[required]');
            
            for (let field of requiredFields) {
                if (!field.value.trim()) {
                    field.focus();
                    return false;
                }
            }
            
            return true;
        }
    }
}
</script>
@endpush
@endsection