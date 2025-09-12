@extends('layouts.app')

@section('title', 'Dashboard - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Bienvenue, {{ auth()->user()->name }} !</h1>
            <p class="mt-2 text-gray-600">Vue d'ensemble de votre activité sur NGOMBILAND</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-home text-primary-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Mes Propriétés</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['properties'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-chart-line text-secondary-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Investissements</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['investments'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-accent-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-wallet text-accent-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Solde</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['balance'] ?? 0) }} FCFA</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-info-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-envelope text-info-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Messages</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['messages'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Actions Rapides -->
            <div class="lg:col-span-2">
                <div class="card mb-6">
                    <div class="card-header">
                        <h2 class="text-xl font-semibold text-gray-900">Actions Rapides</h2>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('properties.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-plus text-primary-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Ajouter une propriété</h3>
                                    <p class="text-sm text-gray-600">Publiez votre bien immobilier</p>
                                </div>
                            </a>

                            <a href="{{ route('crowdfunding.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-users text-secondary-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Investir</h3>
                                    <p class="text-sm text-gray-600">Découvrir les projets</p>
                                </div>
                            </a>

                            <a href="/wallet" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="w-12 h-12 bg-accent-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-wallet text-accent-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Mon portefeuille</h3>
                                    <p class="text-sm text-gray-600">Gérer mes finances</p>
                                </div>
                            </a>

                            <a href="{{ route('messages.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="w-12 h-12 bg-info-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-envelope text-info-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Messages</h3>
                                    <p class="text-sm text-gray-600">Voir mes conversations</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Propriétés récentes -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-xl font-semibold text-gray-900">Mes Propriétés Récentes</h2>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            @forelse($recent_properties ?? [] as $property)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-home text-primary-600"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $property->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $property->location }} • {{ number_format($property->price) }} FCFA</p>
                                </div>
                                <span class="badge badge-{{ $property->status === 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst($property->status) }}
                                </span>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <i class="fas fa-home text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-600 mb-4">Aucune propriété ajoutée</p>
                                <a href="{{ route('properties.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus mr-2"></i>
                                    Ajouter ma première propriété
                                </a>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Messages récents -->
                <div class="card mb-6">
                    <div class="card-header">
                        <h2 class="text-xl font-semibold text-gray-900">Messages Récents</h2>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            @forelse($recent_messages ?? [] as $message)
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-600">
                                        {{ substr($message->sender->name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $message->sender->name }}</p>
                                    <p class="text-sm text-gray-600 truncate">{{ Str::limit($message->message, 50) }}</p>
                                    <p class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-envelope text-gray-400 text-2xl mb-2"></i>
                                <p class="text-gray-600 text-sm">Aucun message</p>
                            </div>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('messages.index') }}" class="btn btn-outline w-full">
                                Voir tous les messages
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Investissements récents -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-xl font-semibold text-gray-900">Investissements Récents</h2>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            @forelse($recent_investments ?? [] as $investment)
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-secondary-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-chart-line text-secondary-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $investment->property->title }}</p>
                                    <p class="text-sm text-gray-600">{{ number_format($investment->amount) }} FCFA</p>
                                </div>
                                <span class="badge badge-success">{{ $investment->roi }}%</span>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-chart-line text-gray-400 text-2xl mb-2"></i>
                                <p class="text-gray-600 text-sm">Aucun investissement</p>
                            </div>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('crowdfunding.index') }}" class="btn btn-outline w-full">
                                Découvrir les projets
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection