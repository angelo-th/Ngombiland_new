@extends('layouts.app') {{-- Assure-toi d'avoir un layout principal --}}

@section('title', 'NGOMBILAND - Marketplace Secondaire')

@section('content')
<div x-data="secondaryMarketplace(@json($user), @json($portfolio), @json($projects), @json($listings))">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="{{ url()->previous() }}" class="mr-4 text-gray-500 hover:text-emerald-600 flex items-center">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('images/logo.png') }}" alt="NGOMBILAND" class="h-10">
                    <h1 class="text-xl font-bold text-gray-800">Marketplace Secondaire</h1>
                </div>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-dark transition-colors">
                        <img src="{{ $user->avatar }}" alt="Profile" class="w-8 h-8 rounded-full border-2 border-white shadow">
                        <span class="hidden md:block font-medium">{{ $user->name }}</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl py-1 z-50 border border-gray-100">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-user mr-2"></i> My Profile & Settings
                        </a>
                        <a href="{{ route('crowdfunding_project') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-chart-line mr-2"></i> My Investments
                        </a>
                        <hr class="my-1 border-gray-100">
                        <a href="{{ route('welcomepage') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Portfolio Summary -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Mon Portefeuille d'Investissement</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Valeur Totale</p>
                            <p class="text-2xl font-bold">{{ number_format($portfolio['totalValue'], 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div class="bg-emerald-100 p-2 rounded-full">
                            <i class="fas fa-wallet text-emerald-600"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-600">ROI Moyen</p>
                            <p class="text-2xl font-bold text-emerald-600">{{ $portfolio['averageROI'] }}%</p>
                        </div>
                        <div class="bg-blue-100 p-2 rounded-full">
                            <i class="fas fa-chart-line text-blue-600"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Parts Disponibles</p>
                            <p class="text-2xl font-bold">{{ $portfolio['availableShares'] }}</p>
                        </div>
                        <div class="bg-purple-100 p-2 rounded-full">
                            <i class="fas fa-certificate text-purple-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mes Parts à Vendre Table -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Mes Parts à Vendre</h3>
                <button @click="openSellModal" class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Proposer des Parts
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 text-left">
                            <th class="py-3 px-4 font-medium text-gray-600">Projet</th>
                            <th class="py-3 px-4 font-medium text-gray-600">Parts</th>
                            <th class="py-3 px-4 font-medium text-gray-600">Prix/Part</th>
                            <th class="py-3 px-4 font-medium text-gray-600">ROI Actuel</th>
                            <th class="py-3 px-4 font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($portfolio['shares'] as $item)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4 px-4">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $item['projectImage'] }}" class="w-10 h-10 rounded-lg object-cover">
                                    <div>
                                        <p class="font-medium">{{ $item['projectName'] }}</p>
                                        <p class="text-sm text-gray-500">{{ $item['projectLocation'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">{{ $item['quantity'] }}</td>
                            <td class="py-4 px-4 font-medium">{{ number_format($item['pricePerShare'], 0, ',', ' ') }} FCFA</td>
                            <td class="py-4 px-4">
                                <span class="{{ $item['currentROI'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $item['currentROI'] }}%
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <button @click="editListing({{ json_encode($item) }})" class="text-blue-600 hover:text-blue-800 mr-2">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button @click="cancelListing({{ json_encode($item) }})" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Marketplace Listings Blade Template -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                @forelse($listings as $listing)
                <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <img src="{{ $listing['projectImage'] }}" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg">{{ $listing['projectName'] }}</h3>
                            <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full text-xs font-medium">{{ $listing['projectStatus'] }}</span>
                        </div>
                        <p class="text-gray-600 text-sm mb-3">{{ $listing['projectLocation'] }}</p>
                        <div class="flex justify-between text-sm">
                            <span>Prix/part:</span>
                            <span class="font-medium">{{ number_format($listing['pricePerShare'], 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>ROI actuel:</span>
                            <span class="{{ $listing['currentROI'] >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ $listing['currentROI'] }}%</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>Vendeur:</span>
                            <span class="font-medium">{{ $listing['sellerName'] }}</span>
                        </div>
                        <button @click="openBuyModal({{ json_encode($listing) }})" class="mt-2 w-full bg-emerald-500 text-white px-3 py-1 rounded-lg hover:bg-emerald-600">Acheter</button>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 col-span-3">Aucune offre disponible</p>
                @endforelse
            </div>
        </div>
    </main>
</div>

{{-- Inclure le JS Alpine --}}
<script src="{{ asset('js/second_marketplace.js') }}"></script>
@endsection
