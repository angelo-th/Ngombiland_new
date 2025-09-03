<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Propriétés</title>
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
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                    @auth
                        <a href="{{ route('logout') }}" class="text-gray-700 hover:text-indigo-600">Déconnexion</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Connexion</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Propriétés disponibles</h1>
                @auth
                    <a href="{{ route('properties.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium">
                        <i class="fas fa-plus mr-2"></i>Ajouter une propriété
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($properties as $property)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($property->images)
                        @php
                            $images = json_decode($property->images, true);
                        @endphp
                        @if($images && count($images) > 0)
                            <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $property->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-home text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-home text-gray-400 text-4xl"></i>
                        </div>
                    @endif

                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $property->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $property->location }}</p>
                        <p class="text-gray-700 text-sm mb-4">{{ Str::limit($property->description, 100) }}</p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-indigo-600">{{ number_format($property->price, 0, ',', ' ') }} FCFA</span>
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                {{ ucfirst($property->status) }}
                            </span>
                        </div>

                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('properties.show', $property) }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium">
                                Voir détails
                            </a>
                            @auth
                                @if(auth()->id() === $property->owner_id)
                                    <a href="{{ route('properties.edit', $property) }}" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg text-sm font-medium">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-home text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune propriété trouvée</h3>
                    <p class="text-gray-500">Il n'y a pas encore de propriétés disponibles.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($properties->hasPages())
            <div class="mt-8">
                {{ $properties->links() }}
            </div>
        @endif
    </main>
</body>
</html>
