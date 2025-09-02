<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Property Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/property_management.css') }}">
    <script src="{{ asset('js/property_management.js') }}" defer></script>
</head>
<body class="h-full bg-gradient-to-br from-blue-50 via-white to-purple-50" x-data="propertiesApp()">

<!-- Navigation Header -->
<nav class="glass-effect border-b border-white/20 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <img class="h-8 w-auto" src="{{ asset('images/logo.svg') }}" alt="NGOMBILAND">
                    <span class="ml-2 text-xl font-bold gradient-bg bg-clip-text text-transparent">NGOMBILAND</span>
                </div>
                <nav class="hidden md:ml-10 md:flex space-x-8">
                    <a href="#" class="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium">Dashboard</a>
                    <a href="#" class="text-blue-600 border-b-2 border-blue-600 px-3 py-2 text-sm font-medium">My Properties</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium">Crowdfunding</a>
                </nav>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="bg-white/20 rounded-full px-4 py-2 flex items-center space-x-2">
                    <i class="fas fa-wallet text-green-600"></i>
                    <span class="text-sm font-medium">Balance: {{ number_format(auth()->user()->balance ?? 0) }} FCFA</span>
                </div>
                <div class="flex items-center space-x-2">
                    <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->profile_photo_url ?? asset('images/default_avatar.png') }}" alt="Profile">
                    <span class="text-sm font-medium">{{ auth()->user()->name ?? 'Guest' }}</span>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header with actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Property Management</h1>
            <p class="text-gray-600">Manage your real estate listings and track their performance</p>
        </div>
        <div class="flex space-x-3 mt-4 md:mt-0">
            <button @click="showAddPropertyModal = true" class="gradient-bg text-white px-6 py-3 rounded-xl font-medium hover:shadow-lg transition-all duration-300 flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Add Property</span>
            </button>
            <button @click="showFavorites = !showFavorites" :class="showFavorites ? 'bg-red-500 text-white' : 'bg-white text-gray-700'" class="px-6 py-3 rounded-xl font-medium border border-gray-200 hover:shadow-lg transition-all duration-300 flex items-center space-x-2">
                <i class="fas fa-heart"></i>
                <span>Favorites</span>
            </button>
        </div>
    </div>

    <!-- Quick stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="glass-effect p-6 rounded-2xl card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Listings</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $properties->count() }}</p>
                </div>
                <div class="p-3 bg-blue-500/20 rounded-xl">
                    <i class="fas fa-building text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="glass-effect p-6 rounded-2xl card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Monthly Views</p>
                    <p class="text-2xl font-bold text-gray-900">1,247</p>
                </div>
                <div class="p-3 bg-green-500/20 rounded-xl">
                    <i class="fas fa-eye text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="glass-effect p-6 rounded-2xl card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Leads Received</p>
                    <p class="text-2xl font-bold text-gray-900">43</p>
                </div>
                <div class="p-3 bg-purple-500/20 rounded-xl">
                    <i class="fas fa-phone text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="glass-effect p-6 rounded-2xl card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Revenue Generated</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($properties->sum('price')) }} FCFA</p>
                </div>
                <div class="p-3 bg-yellow-500/20 rounded-xl">
                    <i class="fas fa-coins text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and search -->
    <div class="glass-effect p-6 rounded-2xl mb-8">
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <div class="flex-1">
                <input type="text" x-model="searchQuery" placeholder="Search properties..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select x-model="filterType" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">All Types</option>
                @foreach(['appartement'=>'Apartment','maison'=>'House','villa'=>'Villa','terrain'=>'Land','commercial'=>'Commercial','bureau'=>'Office'] as $key=>$label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            <select x-model="filterStatus" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">All Statuses</option>
                @foreach(['active'=>'Active','pending'=>'Pending','sold'=>'Sold','rented'=>'Rented'] as $key=>$label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Property list -->
    <div class="space-y-6" x-show="!showFavorites">
        @foreach($properties as $property)
            <div class="glass-effect rounded-2xl overflow-hidden card-hover fade-in">
                <div class="md:flex">
                    <!-- Image -->
                    <div class="md:w-1/3 relative">
                        <img src="{{ $property->image_url }}" alt="{{ $property->title }}" class="h-64 md:h-48 w-full object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $property->status_class }}">{{ $property->status_label }}</span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <button @click="toggleFavorite({{ $property->id }})" class="p-2 bg-black/50 rounded-full hover:bg-black/70 transition-colors">
                                <i class="{{ $property->is_favorite ? 'fas fa-heart text-red-500' : 'far fa-heart text-white' }}"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="md:w-2/3 p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $property->title }}</h3>
                                <div class="flex items-center text-gray-600 mb-2">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span>{{ $property->location }}</span>
                                </div>
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span><i class="fas fa-bed mr-1"></i>{{ $property->bedrooms }} beds</span>
                                    <span><i class="fas fa-bath mr-1"></i>{{ $property->bathrooms }} baths</span>
                                    <span><i class="fas fa-ruler-combined mr-1"></i>{{ $property->surface }} sqm</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-blue-600">{{ number_format($property->price) }} FCFA</p>
                                <p class="text-sm text-gray-500">{{ ucfirst($property->type) }}</p>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="grid grid-cols-3 gap-4 mb-4 text-center">
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-600">Views</p>
                                <p class="font-bold text-blue-600">{{ $property->views }}</p>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-600">Leads</p>
                                <p class="font-bold text-green-600">{{ $property->contacts }}</p>
                            </div>
                            <div class="bg-purple-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-600">Favorites</p>
                                <p class="font-bold text-purple-600">{{ $property->favorite_count }}</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-wrap gap-2">
                            <button @click="viewProperty({{ $property->id }})" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm">
                                <i class="fas fa-eye mr-1"></i> View
                            </button>
                            <button @click="editProperty({{ $property->id }})" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors text-sm">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>
                            <button @click="promoteProperty({{ $property->id }})" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm">
                                <i class="fas fa-bullhorn mr-1"></i> Promote
                            </button>
                            <button @click="deleteProperty({{ $property->id }})" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
