{{-- resources/views/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Dashboard</title>

    {{-- Tailwind & FontAwesome CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- Laravel asset helper for CSS & JS --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="{{ asset('js/dashboard.js') }}"></script>
</head>
<body class="h-full">
<div class="min-h-full">
    {{-- Navigation --}}
    <nav class="gradient-bg shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        {{-- Logo with Laravel asset helper --}}
                        <img class="h-8 w-8" src="{{ asset('images/logo.png') }}" alt="NGOMBILAND">
                        <span class="ml-2 text-white font-bold text-xl">NGOMBILAND</span>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            {{-- Use route() or URL paths --}}
                            <a href="{{ url('/dashboard') }}" class="text-white bg-indigo-500 bg-opacity-75 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                            <a href="{{ url('/property_search') }}" class="text-indigo-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Properties</a>
                            <a href="{{ url('/marketplace_crowdfunding') }}" class="text-indigo-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Crowdfunding</a>
                            <a href="{{ url('/user_walet') }}" class="text-indigo-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Wallet</a>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    {{-- Notifications --}}
                    <a href="{{ url('/communication') }}">
                        <button class="relative p-2 text-gray-600 hover:text-primary transition-colors">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center animate-pulse">3</span>
                        </button>
                    </a>
                    {{-- User Profile --}}
                    <div class="relative">
                        <button class="flex items-center text-white space-x-2" onclick="toggleUserMenu()">
                            <img class="h-8 w-8 rounded-full" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTYiIGN5PSIxNiIgcj0iMTYiIGZpbGw9IiM2MzY2RjEiLz4KPGNpcmNsZSBjeD0iMTYiIGN5PSIxMiIgcj0iNCIgZmlsbD0id2hpdGUiLz4KPHBhdGggZD0iTTggMjZjMC00LjQgMy42LTggOC04czggMy42IDggOCIgZmlsbD0id2hpdGUiLz4KPC9zdmc+" alt="Avatar">
                            <span class="text-sm font-medium">Angelo Mbiock</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile & Settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Dashboard Header --}}
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-2">
                        <div class="flex items-center">
                            <a href="{{ url('/user_walet') }}">
                                <i class="fas fa-wallet text-green-600 mr-2"></i>
                                <span class="text-sm font-medium text-green-800">Balance: </span>
                                <span class="text-lg font-bold text-green-600 ml-1">45,750 FCFA</span>
                            </a>
                        </div>
                    </div>
                    <a href="#">
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                            <i class="fas fa-plus mr-2"></i>Add Property
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        {{-- Quick Stats --}}
        @include('partials.stats') {{-- Suggested partial for stats section --}}

        {{-- Main Dashboard Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Recent Activities --}}
            @include('partials.recent-activities')

            {{-- Sidebar --}}
            @include('partials.dashboard-sidebar')
        </div>
    </main>
</div>
</body>
</html>
