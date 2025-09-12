@extends('layouts.app')

@section('title', 'Mon Profil - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mon Profil</h1>
            <p class="mt-2 text-gray-600">Gérez vos informations personnelles et paramètres de compte</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl font-bold text-primary-600">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ auth()->user()->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ auth()->user()->email }}</p>
                        <span class="badge badge-primary">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="card mt-6">
                    <div class="card-body p-0">
                        <nav class="space-y-1">
                            <a href="{{ route('profile.show') }}" 
                               class="flex items-center px-4 py-3 text-sm font-medium text-primary-600 bg-primary-50 border-r-2 border-primary-600">
                                <i class="fas fa-user mr-3"></i>
                                Informations personnelles
                            </a>
                            <a href="{{ route('profile.edit') }}" 
                               class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                                <i class="fas fa-edit mr-3"></i>
                                Modifier le profil
                            </a>
                            <a href="/wallet" 
                               class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                                <i class="fas fa-wallet mr-3"></i>
                                Mon portefeuille
                            </a>
                            <a href="{{ route('messages.index') }}" 
                               class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                                <i class="fas fa-envelope mr-3"></i>
                                Messages
                            </a>
                            <a href="#" 
                               class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                                <i class="fas fa-cog mr-3"></i>
                                Paramètres
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Informations personnelles -->
                <div class="card mb-6">
                    <div class="card-header">
                        <h2 class="text-xl font-semibold text-gray-900">Informations personnelles</h2>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="form-label">Prénom</label>
                                <div class="form-input bg-gray-50">{{ auth()->user()->first_name ?? 'Non renseigné' }}</div>
                            </div>
                            <div>
                                <label class="form-label">Nom</label>
                                <div class="form-input bg-gray-50">{{ auth()->user()->last_name ?? 'Non renseigné' }}</div>
                            </div>
                            <div>
                                <label class="form-label">Email</label>
                                <div class="form-input bg-gray-50">{{ auth()->user()->email }}</div>
                            </div>
                            <div>
                                <label class="form-label">Téléphone</label>
                                <div class="form-input bg-gray-50">{{ auth()->user()->phone ?? 'Non renseigné' }}</div>
                            </div>
                            <div>
                                <label class="form-label">Rôle</label>
                                <div class="form-input bg-gray-50">{{ ucfirst(auth()->user()->role) }}</div>
                            </div>
                            <div>
                                <label class="form-label">Membre depuis</label>
                                <div class="form-input bg-gray-50">{{ auth()->user()->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                <i class="fas fa-edit mr-2"></i>
                                Modifier les informations
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-home text-primary-600 text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ auth()->user()->properties->count() }}</h3>
                            <p class="text-gray-600">Propriétés</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-chart-line text-secondary-600 text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ auth()->user()->investments->count() }}</h3>
                            <p class="text-gray-600">Investissements</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="w-12 h-12 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-envelope text-accent-600 text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ auth()->user()->receivedMessages->count() }}</h3>
                            <p class="text-gray-600">Messages</p>
                        </div>
                    </div>
                </div>

                <!-- Activité récente -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-xl font-semibold text-gray-900">Activité récente</h2>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            @forelse(auth()->user()->properties->take(3) as $property)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-home text-primary-600"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $property->title }}</h4>
                                    <p class="text-sm text-gray-600">Ajouté le {{ $property->created_at->format('d/m/Y') }}</p>
                                </div>
                                <span class="badge badge-{{ $property->status === 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst($property->status) }}
                                </span>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <i class="fas fa-home text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-600">Aucune propriété ajoutée</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
