<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propriétés - NGOMBILAND</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Découvrez nos propriétés</h1>
                <p class="text-xl text-gray-600">Trouvez le bien immobilier de vos rêves au Cameroun</p>
            </div>

            <!-- Properties Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($properties as $property)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="relative">
                        @if($property->images && count($property->images) > 0)
                            <img src="{{ asset('storage/' . $property->images[0]) }}" 
                                 alt="{{ $property->title }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-home text-4xl text-gray-400"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4">
                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                {{ ucfirst($property->type) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $property->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($property->description, 100) }}</p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span class="text-sm">{{ $property->location }}</span>
                            </div>
                            <div class="text-2xl font-bold text-blue-600">
                                {{ number_format($property->price, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-user mr-2"></i>
                                <span>Propriétaire</span>
                            </div>
                            <a href="{{ route('properties.show', $property->id) }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Voir détails
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-home text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune propriété trouvée</h3>
                    <p class="text-gray-600">Il n'y a actuellement aucune propriété disponible.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($properties->hasPages())
            <div class="mt-8">
                {{ $properties->links() }}
            </div>
            @endif
        </div>
    </div>
</body>
</html>
