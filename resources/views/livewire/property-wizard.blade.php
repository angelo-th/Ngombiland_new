<div class="max-w-4xl mx-auto">
    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            <i class="fas fa-plus-circle mr-3 text-primary-600"></i>
            Publier une Propriété
        </h1>
        <p class="text-gray-600">Créez une annonce pour votre propriété et proposez-la au crowdfunding</p>
    </div>

    <!-- Indicateur de progression -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            @for($i = 1; $i <= $totalSteps; $i++)
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full {{ $i <= $currentStep ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                        {{ $i }}
                    </div>
                    @if($i < $totalSteps)
                        <div class="w-16 h-1 mx-2 {{ $i < $currentStep ? 'bg-primary-600' : 'bg-gray-200' }}"></div>
                    @endif
                </div>
            @endfor
        </div>
        
        <div class="flex justify-between text-sm text-gray-600">
            <span>Informations</span>
            <span>Images</span>
            <span>Crowdfunding</span>
            <span>Documents</span>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <!-- Étape 1: Informations de base -->
        @if($currentStep === 1)
        <div class="bg-white rounded-lg shadow-lg p-8" x-transition>
            <h2 class="text-xl font-semibold text-gray-900 mb-6">1. Informations de Base</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="title" class="form-label">Titre de la propriété *</label>
                    <input type="text" id="title" wire:model="title" class="form-input" placeholder="Ex: Villa moderne à Douala">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="form-label">Description *</label>
                    <textarea id="description" wire:model="description" rows="4" class="form-textarea" 
                              placeholder="Décrivez votre propriété en détail..."></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="type" class="form-label">Type de propriété *</label>
                    <select id="type" wire:model="type" class="form-select">
                        <option value="house">Maison</option>
                        <option value="apartment">Appartement</option>
                        <option value="villa">Villa</option>
                        <option value="land">Terrain</option>
                        <option value="commercial">Commercial</option>
                    </select>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="price" class="form-label">Prix (FCFA) *</label>
                    <input type="number" id="price" wire:model="price" class="form-input" placeholder="50000000">
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="location" class="form-label">Localisation *</label>
                    <input type="text" id="location" wire:model="location" class="form-input" placeholder="Douala, Cameroun">
                    @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="latitude" class="form-label">Latitude *</label>
                    <input type="number" id="latitude" wire:model="latitude" step="any" class="form-input" placeholder="4.0483">
                    @error('latitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="longitude" class="form-label">Longitude *</label>
                    <input type="number" id="longitude" wire:model="longitude" step="any" class="form-input" placeholder="9.7043">
                    @error('longitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        @endif

        <!-- Étape 2: Images -->
        @if($currentStep === 2)
        <div class="bg-white rounded-lg shadow-lg p-8" x-transition>
            <h2 class="text-xl font-semibold text-gray-900 mb-6">2. Photos de la Propriété</h2>
            
            <div class="space-y-6">
                <div>
                    <label class="form-label">Ajouter des photos *</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-primary-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-camera text-4xl text-gray-400 mb-4"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>Télécharger des fichiers</span>
                                    <input id="images" type="file" class="sr-only" multiple wire:model="images" accept="image/*">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG jusqu'à 2MB (max 10 photos)</p>
                        </div>
                    </div>
                    @error('images') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                @if($images)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($images as $index => $image)
                    <div class="relative">
                        <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="w-full h-32 object-cover rounded-lg">
                        <button type="button" wire:click="removeImage({{ $index }})" 
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Étape 3: Crowdfunding -->
        @if($currentStep === 3)
        <div class="bg-white rounded-lg shadow-lg p-8" x-transition>
            <h2 class="text-xl font-semibold text-gray-900 mb-6">3. Options de Crowdfunding</h2>
            
            <div class="space-y-6">
                <div class="flex items-center">
                    <input type="checkbox" id="is_crowdfundable" wire:model="is_crowdfundable" class="form-checkbox h-4 w-4 text-primary-600">
                    <label for="is_crowdfundable" class="ml-3 text-sm font-medium text-gray-700">
                        Proposer cette propriété au crowdfunding
                    </label>
                </div>

                @if($is_crowdfundable)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 space-y-6">
                    <h3 class="text-lg font-medium text-blue-900">Configuration du Crowdfunding</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="expected_roi" class="form-label">ROI Attendu (%) *</label>
                            <input type="number" id="expected_roi" wire:model="expected_roi" step="0.1" class="form-input">
                            @error('expected_roi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="total_amount" class="form-label">Montant à Lever (FCFA) *</label>
                            <input type="number" id="total_amount" wire:model="total_amount" class="form-input">
                            @error('total_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="total_shares" class="form-label">Nombre de Parts *</label>
                            <input type="number" id="total_shares" wire:model="total_shares" class="form-input">
                            @error('total_shares') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="funding_deadline" class="form-label">Date Limite *</label>
                            <input type="date" id="funding_deadline" wire:model="funding_deadline" class="form-input">
                            @error('funding_deadline') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-2">Résumé</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Prix par part:</span>
                                <span class="font-semibold">{{ number_format($price_per_share ?? 0, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div>
                                <span class="text-gray-600">ROI annuel:</span>
                                <span class="font-semibold">{{ $expected_roi }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Étape 4: Documents -->
        @if($currentStep === 4)
        <div class="bg-white rounded-lg shadow-lg p-8" x-transition>
            <h2 class="text-xl font-semibold text-gray-900 mb-6">4. Documents Légaux (Optionnel)</h2>
            
            <div class="space-y-6">
                <div>
                    <label class="form-label">Ajouter des documents</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-primary-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-file-upload text-4xl text-gray-400 mb-4"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="documents" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500">
                                    <span>Télécharger des documents</span>
                                    <input id="documents" type="file" class="sr-only" multiple wire:model="documents" accept=".pdf,.doc,.docx">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PDF, DOC jusqu'à 5MB</p>
                        </div>
                    </div>
                </div>

                @if($documents)
                <div class="space-y-2">
                    @foreach($documents as $index => $document)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-file text-blue-500 mr-3"></i>
                            <span class="text-sm font-medium">{{ $document->getClientOriginalName() }}</span>
                        </div>
                        <button type="button" wire:click="removeDocument({{ $index }})" 
                                class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Boutons de navigation -->
        <div class="flex justify-between mt-8">
            @if($currentStep > 1)
                <button type="button" wire:click="previousStep" class="btn btn-outline">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Précédent
                </button>
            @else
                <div></div>
            @endif

            @if($currentStep < $totalSteps)
                <button type="button" wire:click="nextStep" class="btn btn-primary">
                    Suivant
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            @else
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Publier la Propriété
                </button>
            @endif
        </div>
    </form>
</div>
