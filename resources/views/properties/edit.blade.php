@extends('layouts.app')

@section('title', 'Modifier la propriété - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Modifier la propriété</h1>
            <p class="mt-2 text-gray-600">Mettez à jour les informations de votre propriété</p>
        </div>

        <!-- Form -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('properties.update', $property) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="form-label">Titre *</label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $property->title) }}"
                                   class="form-input @error('title') border-red-500 @enderror"
                                   required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="form-label">Description *</label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      class="form-input @error('description') border-red-500 @enderror"
                                      required>{{ old('description', $property->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="type" class="form-label">Type de propriété *</label>
                            <select id="type" 
                                    name="type" 
                                    class="form-select @error('type') border-red-500 @enderror"
                                    required>
                                <option value="">Sélectionner un type</option>
                                <option value="villa" {{ old('type', $property->type) === 'villa' ? 'selected' : '' }}>Villa</option>
                                <option value="apartment" {{ old('type', $property->type) === 'apartment' ? 'selected' : '' }}>Appartement</option>
                                <option value="house" {{ old('type', $property->type) === 'house' ? 'selected' : '' }}>Maison</option>
                                <option value="land" {{ old('type', $property->type) === 'land' ? 'selected' : '' }}>Terrain</option>
                                <option value="commercial" {{ old('type', $property->type) === 'commercial' ? 'selected' : '' }}>Commercial</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="form-label">Prix (FCFA) *</label>
                            <input type="number" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price', $property->price) }}"
                                   class="form-input @error('price') border-red-500 @enderror"
                                   required>
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="md:col-span-2">
                            <label for="location" class="form-label">Localisation *</label>
                            <input type="text" 
                                   id="location" 
                                   name="location" 
                                   value="{{ old('location', $property->location) }}"
                                   class="form-input @error('location') border-red-500 @enderror"
                                   required>
                            @error('location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Latitude -->
                        <div>
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="number" 
                                   id="latitude" 
                                   name="latitude" 
                                   value="{{ old('latitude', $property->latitude) }}"
                                   step="any"
                                   class="form-input @error('latitude') border-red-500 @enderror">
                            @error('latitude')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Longitude -->
                        <div>
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="number" 
                                   id="longitude" 
                                   name="longitude" 
                                   value="{{ old('longitude', $property->longitude) }}"
                                   step="any"
                                   class="form-input @error('longitude') border-red-500 @enderror">
                            @error('longitude')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Images -->
                        <div class="md:col-span-2">
                            <label for="images" class="form-label">Images</label>
                            <input type="file" 
                                   id="images" 
                                   name="images[]" 
                                   multiple
                                   accept="image/*"
                                   class="form-input @error('images') border-red-500 @enderror">
                            @error('images')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 mt-1">Vous pouvez sélectionner plusieurs images</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-4 mt-8">
                        <a href="{{ route('properties.show', $property) }}" 
                           class="btn btn-outline">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection