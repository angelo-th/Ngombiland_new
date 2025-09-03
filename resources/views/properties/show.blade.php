<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - {{ $property->title }}</title>
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

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Images -->
            <div class="lg:col-span-2">
                @if($property->images)
                    @php
                        $images = json_decode($property->images, true);
                    @endphp
                    @if($images && count($images) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($images as $image)
                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $property->title }}" class="w-full h-64 object-cover rounded-lg">
                            @endforeach
                        </div>
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg">
                            <i class="fas fa-home text-gray-400 text-6xl"></i>
                        </div>
                    @endif
                @else
                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg">
                        <i class="fas fa-home text-gray-400 text-6xl"></i>
                    </div>
                @endif
            </div>

            <!-- Property Details -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $property->title }}</h1>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-3xl font-bold text-indigo-600">{{ number_format($property->price, 0, ',', ' ') }} FCFA</span>
                        </div>

                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>{{ $property->location }}</span>
                        </div>

                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-home mr-2"></i>
                            <span>{{ ucfirst($property->type ?? 'Non spécifié') }}</span>
                        </div>

                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                {{ ucfirst($property->status) }}
                            </span>
                        </div>

                        <div class="pt-4 border-t">
                            <h3 class="font-semibold text-gray-900 mb-2">Propriétaire</h3>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-indigo-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $property->owner->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $property->owner->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-4 rounded-lg font-medium">
                                <i class="fas fa-phone mr-2"></i>Contacter le propriétaire
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Description</h2>
            <p class="text-gray-700 leading-relaxed">{{ $property->description }}</p>
        </div>
    </main>
</body>
</html>
