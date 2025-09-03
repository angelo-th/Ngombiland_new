<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Ajouter une propriété</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <img class="h-8 w-8" src="{{ asset('images/logo.png') }}" alt="NGOMBILAND">
                    <span class="ml-2 text-white font-bold text-xl text-gray-900">NGOMBILAND</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('properties.index') }}" class="text-gray-700 hover:text-indigo-600">Retour aux propriétés</a>
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Ajouter une nouvelle propriété</h1>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg">
            <form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Titre de la propriété *</label>
                    <input type="text" id="title" name="title" required 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           value="{{ old('title') }}">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                    <textarea id="description" name="description" rows="4" required 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Type de propriété *</label>
                        <select id="type" name="type" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Sélectionner un type</option>
                            <option value="maison" {{ old('type') == 'maison' ? 'selected' : '' }}>Maison</option>
                            <option value="appartement" {{ old('type') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                            <option value="terrain" {{ old('type') == 'terrain' ? 'selected' : '' }}>Terrain</option>
                            <option value="bureau" {{ old('type') == 'bureau' ? 'selected' : '' }}>Bureau</option>
                            <option value="commerce" {{ old('type') == 'commerce' ? 'selected' : '' }}>Commerce</option>
                        </select>
                        @error('type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Statut *</label>
                        <select id="status" name="status" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Sélectionner un statut</option>
                            <option value="disponible" {{ old('status') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="loue" {{ old('status') == 'loue' ? 'selected' : '' }}>Loué</option>
                            <option value="vendu" {{ old('status') == 'vendu' ? 'selected' : '' }}>Vendu</option>
                            <option value="en_attente" {{ old('status') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Prix (FCFA) *</label>
                        <input type="number" id="price" name="price" required min="0" step="1000"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               value="{{ old('price') }}">
                        @error('price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Localisation *</label>
                        <input type="text" id="location" name="location" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               value="{{ old('location') }}">
                        @error('location')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700">Images de la propriété</label>
                    <input type="file" id="images" name="images[]" multiple accept="image/*"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <p class="mt-2 text-sm text-gray-500">Vous pouvez sélectionner plusieurs images (JPG, PNG, GIF - Max 2MB chacune)</p>
                    @error('images')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('properties.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
                        Créer la propriété
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
