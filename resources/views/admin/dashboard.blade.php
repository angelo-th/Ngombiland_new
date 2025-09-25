@extends('layouts.app')

@section('title', 'Dashboard Admin - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Administrateur</h1>
            <p class="mt-2 text-gray-600">Vue d'ensemble de la plateforme NGOMBILAND</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Utilisateurs</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['users'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Propriétés</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['properties'] }}</p>
                        <p class="text-xs text-gray-500">{{ $stats['properties_pending'] }} en attente</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Crowdfunding</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['crowdfunding_active'] }}</p>
                        <p class="text-xs text-gray-500">{{ $stats['crowdfunding_pending'] }} en attente</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Investi</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_invested']) }} FCFA</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Users -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Utilisateurs Récents</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                <span class="text-gray-600 font-semibold">
                                    {{ substr($user->name, 0, 1) }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.users') }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Voir tous les utilisateurs →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Properties -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Propriétés Récentes</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach(\App\Models\Property::latest()->take(5)->get() as $property)
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ Str::limit($property->title, 30) }}</p>
                                <p class="text-sm text-gray-500">{{ number_format($property->price) }} FCFA</p>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $property->created_at->diffForHumans() }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('properties.index') }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Voir toutes les propriétés →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions Administrateur</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.users') }}" 
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Gestion Utilisateurs</p>
                        <p class="text-sm text-gray-500">Gérer les comptes utilisateurs</p>
                    </div>
                </a>

                <a href="{{ route('admin.properties') }}" 
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Modération Propriétés</p>
                        <p class="text-sm text-gray-500">Valider les annonces ({{ $stats['properties_pending'] }})</p>
                    </div>
                </a>

                <a href="{{ route('admin.crowdfunding') }}" 
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Modération Crowdfunding</p>
                        <p class="text-sm text-gray-500">Valider les projets ({{ $stats['crowdfunding_pending'] }})</p>
                    </div>
                </a>

                <a href="{{ route('admin.settings') }}" 
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Paramètres</p>
                        <p class="text-sm text-gray-500">Configuration plateforme</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
