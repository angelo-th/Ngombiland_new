<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Property Search</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/property_search.css') }}">
    <script src="{{ asset('js/property_search.js') }}"></script>
</head>
<body class="h-full">
<div class="min-h-full">
    <!-- Navigation -->
    <nav class="gradient-bg shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-8 w-8" src="{{ asset('images/logo.svg') }}" alt="NGOMBILAND">
                        <span class="ml-2 text-white font-bold text-xl">NGOMBILAND</span>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="{{ route('dashboard') }}" class="text-indigo-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                            <a href="{{ route('properties.index') }}" class="text-white bg-indigo-500 bg-opacity-75 px-3 py-2 rounded-md text-sm font-medium">Properties</a>
                            <a href="{{ route('marketplace.crowdfunding') }}" class="text-indigo-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Crowdfunding</a>
                            <a href="{{ route('user.wallet') }}" class="text-indigo-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Wallet</a>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <a href="{{ route('communication') }}"><button class="relative p-2 text-white hover:text-indigo-100 transition-colors">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                    </button></a>
                    <!-- User Profile -->
                    <div class="relative">
                        <button class="flex items-center text-white space-x-2" onclick="toggleUserMenu()">
                            <img class="h-8 w-8 rounded-full" src="{{ asset('images/avatar.svg') }}" alt="Avatar">
                            <span class="text-sm font-medium">{{ Auth::user()->name ?? 'Guest' }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile & Settings</a>
                            <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Find Properties in Cameroon</h1>
            <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-2">
                <div class="flex items-center">
                    <a href="{{ route('user.wallet') }}">
                        <i class="fas fa-wallet text-green-600 mr-2"></i>
                        <span class="text-sm font-medium text-green-800">Balance:</span>
                        <span class="text-lg font-bold text-green-600 ml-1">{{ Auth::user()->wallet_balance ?? '0' }} FCFA</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Search + Map -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-card">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="lg:w-1/2">
                    <div id="map"></div>
                </div>
                <div class="lg:w-1/2">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Search Properties</h2>
                    <form id="propertySearchForm" class="space-y-4">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-medium text-gray-700">Use my current location</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="useCurrentLocation" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white
                                after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                        <!-- Add all search fields here as in original code -->
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">Search Properties</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Latest Properties -->
        <div class="animate-card">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Latest Properties</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($properties as $property)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                        <div class="property-image" style="background-image: url('{{ $property->image }}');">
                            <a href="#" class="absolute bottom-3 left-3 bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-sm font-medium transition-colors"
                               onclick="openModal('{{ $property->id }}')">View Details</a>
                        </div>
                        <div class="p-4">
                            <div class="text-xl font-bold text-indigo-600 mb-1">{{ $property->price }}</div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $property->title }}</h3>
                            <div class="flex items-center text-gray-600 mb-3">
                                <i class="fas fa-map-marker-alt text-sm mr-1"></i>
                                <span class="text-sm">{{ $property->location }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-ruler-combined mr-1"></i>
                                    <span>{{ $property->surface }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-home mr-1"></i>
                                    <span>{{ $property->rooms }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</div>


<!-- Include Modals and Scripts as in original code -->

</body>
</html>
