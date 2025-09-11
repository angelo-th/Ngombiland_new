@extends('layouts.app')

@section('title', 'Vérification Propriétaire - Étape 3')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                Vérification Propriétaire
            </h1>
            <p class="text-lg text-gray-600">
                Géolocalisez votre propriété pour la vérification
            </p>
        </div>

        <!-- Progress Bar -->
        @include('owner_verification.progress_bar', ['step' => 3])

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                        Géolocalisation de la Propriété
                    </h2>
                    <p class="text-gray-600">
                        Localisez précisément votre propriété sur la carte
                    </p>
                </div>

                <form action="{{ route('owner.verification.step3.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Map Container -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Carte Interactive
                        </h3>
                        
                        <div class="relative">
                            <!-- Map -->
                            <div id="map" class="w-full h-96 rounded-lg border border-gray-300"></div>
                            
                            <!-- Map Controls -->
                            <div class="absolute top-4 right-4 space-y-2">
                                <button type="button" 
                                        id="locate-me" 
                                        class="bg-white p-2 rounded-lg shadow-md hover:bg-gray-50 transition-colors"
                                        title="Ma position actuelle">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </button>
                                
                                <button type="button" 
                                        id="search-location" 
                                        class="bg-white p-2 rounded-lg shadow-md hover:bg-gray-50 transition-colors"
                                        title="Rechercher une adresse">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                </button>
            </div>

                            <!-- Search Box -->
                            <div id="search-box" class="absolute top-4 left-4 w-80 hidden">
                                <div class="bg-white rounded-lg shadow-md p-4">
                                    <div class="flex">
                                        <input type="text" 
                                               id="address-input" 
                                               placeholder="Rechercher une adresse..."
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" 
                                                id="search-btn" 
                                                class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location Info -->
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Latitude
                                </label>
                                <input type="text" 
                                       id="latitude" 
                                       name="latitude" 
                                       value="{{ old('latitude') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('latitude') border-red-500 @enderror"
                                       readonly>
                                @error('latitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Longitude
                                </label>
                                <input type="text" 
                                       id="longitude" 
                                       name="longitude" 
                                       value="{{ old('longitude') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('longitude') border-red-500 @enderror"
                                       readonly>
                                @error('longitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Adresse complète
                            </label>
                            <input type="text" 
                                   id="full-address" 
                                   name="address" 
                                   value="{{ old('address') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror"
                                   readonly>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Détails de la propriété
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="property_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Type de propriété *
                                </label>
                                <select id="property_type" 
                                        name="property_type" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('property_type') border-red-500 @enderror"
                                        required>
                                    <option value="">Sélectionner un type</option>
                                    <option value="villa" {{ old('property_type') == 'villa' ? 'selected' : '' }}>Villa</option>
                                    <option value="apartment" {{ old('property_type') == 'apartment' ? 'selected' : '' }}>Appartement</option>
                                    <option value="house" {{ old('property_type') == 'house' ? 'selected' : '' }}>Maison</option>
                                    <option value="land" {{ old('property_type') == 'land' ? 'selected' : '' }}>Terrain</option>
                                    <option value="commercial" {{ old('property_type') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                                </select>
                                @error('property_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="surface_area" class="block text-sm font-medium text-gray-700 mb-2">
                                    Superficie (m²) *
                                </label>
                                <input type="number" 
                                       id="surface_area" 
                                       name="surface_area" 
                                       value="{{ old('surface_area') }}"
                                       min="1"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('surface_area') border-red-500 @enderror"
                                       required>
                                @error('surface_area')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="property_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description de la propriété *
                            </label>
                            <textarea id="property_description" 
                                      name="property_description" 
                                      rows="4"
                                      placeholder="Décrivez votre propriété en détail..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('property_description') border-red-500 @enderror"
                                      required>{{ old('property_description') }}</textarea>
                            @error('property_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between pt-6">
                        <a href="{{ route('owner.verification.step2') }}" 
                           class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Précédent
                        </a>
                        
                        <button type="submit" 
                                id="submit-btn"
                                class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            Continuer
                </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Instructions -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">
                        Instructions de géolocalisation
                    </h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Cliquez sur la carte pour marquer l'emplacement exact de votre propriété</li>
                            <li>Utilisez le bouton "Ma position" pour vous localiser automatiquement</li>
                            <li>Recherchez une adresse si vous connaissez l'emplacement exact</li>
                            <li>Assurez-vous que le marqueur est placé au centre de votre propriété</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Mapbox GL JS -->
<script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />

<script>
    // Mapbox configuration
    mapboxgl.accessToken = '{{ config("services.mapbox.token", "pk.your_mapbox_token") }}';
    
    let map;
    let marker;
    let geocoder;
    
    // Initialize map
    function initMap() {
        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [11.5021, 3.8480], // Yaoundé, Cameroon
            zoom: 10
        });
        
        // Add navigation controls
        map.addControl(new mapboxgl.NavigationControl());
        
        // Add geocoder
        geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl,
            placeholder: 'Rechercher une adresse...',
            countries: 'cm' // Limit to Cameroon
        });
        
        // Add geocoder to search box
        document.getElementById('search-box').appendChild(geocoder.onAdd(map));
        
        // Handle map clicks
        map.on('click', function(e) {
            const { lng, lat } = e.lngLat;
            updateLocation(lat, lng);
        });
        
        // Handle geocoder results
        geocoder.on('result', function(e) {
            const { lng, lat } = e.result.center;
            updateLocation(lat, lng);
        });
    }
    
    // Update location
    function updateLocation(lat, lng) {
        // Remove existing marker
        if (marker) {
            marker.remove();
        }
        
        // Add new marker
        marker = new mapboxgl.Marker({
            draggable: true,
            color: '#3B82F6'
        })
        .setLngLat([lng, lat])
        .addTo(map);
        
        // Update form fields
        document.getElementById('latitude').value = lat.toFixed(7);
        document.getElementById('longitude').value = lng.toFixed(7);
        
        // Reverse geocoding
        reverseGeocode(lat, lng);
        
        // Enable submit button
        document.getElementById('submit-btn').disabled = false;
        
        // Handle marker drag
        marker.on('dragend', function() {
            const { lng, lat } = marker.getLngLat();
            updateLocation(lat, lng);
        });
    }
    
    // Reverse geocoding
    function reverseGeocode(lat, lng) {
        fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}&country=cm`)
            .then(response => response.json())
            .then(data => {
                if (data.features && data.features.length > 0) {
                    document.getElementById('full-address').value = data.features[0].place_name;
                }
            })
            .catch(error => console.error('Error:', error));
    }
    
    // Locate me button
    document.getElementById('locate-me').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const { latitude, longitude } = position.coords;
                map.flyTo({
                    center: [longitude, latitude],
                    zoom: 15
                });
                updateLocation(latitude, longitude);
            }, function(error) {
                alert('Erreur de géolocalisation: ' + error.message);
            });
        } else {
            alert('La géolocalisation n\'est pas supportée par ce navigateur');
        }
    });
    
    // Search location button
    document.getElementById('search-location').addEventListener('click', function() {
        const searchBox = document.getElementById('search-box');
        searchBox.classList.toggle('hidden');
    });
    
    // Initialize map when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const lat = document.getElementById('latitude').value;
        const lng = document.getElementById('longitude').value;
        
        if (!lat || !lng) {
            e.preventDefault();
            alert('Veuillez sélectionner un emplacement sur la carte');
            return;
        }
    });
</script>
@endpush
@endsection