@extends('layouts.app')

@section('title', 'Dashboard Agent - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Agent</h1>
            <p class="mt-2 text-gray-600">Gérez vos propriétés et vos clients</p>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="card">
                <div class="card-body text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-home text-primary-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['properties_count'] }}</h3>
                    <p class="text-gray-600">Mes Propriétés</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center">
                    <div class="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-users text-secondary-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['clients_count'] }}</h3>
                    <p class="text-gray-600">Clients</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center">
                    <div class="w-12 h-12 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-wallet text-accent-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($stats['wallet_balance'], 0, ',', ' ') }} FCFA</h3>
                    <p class="text-gray-600">Solde</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center">
                    <div class="w-12 h-12 bg-success-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-chart-line text-success-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($stats['commission_earned'], 0, ',', ' ') }} FCFA</h3>
                    <p class="text-gray-600">Commissions</p>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="card mb-8">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Actions Rapides</h2>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('properties.create') }}" class="action-card">
                        <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-plus text-primary-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Ajouter une propriété</h3>
                        <p class="text-sm text-gray-600">Publiez votre bien immobilier</p>
                    </a>

                    <a href="{{ route('properties.index') }}" class="action-card">
                        <div class="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-list text-secondary-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Mes propriétés</h3>
                        <p class="text-sm text-gray-600">Gérer mes annonces</p>
                    </a>

                    <a href="{{ route('messages.index') }}" class="action-card">
                        <div class="w-12 h-12 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-envelope text-accent-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Messages</h3>
                        <p class="text-sm text-gray-600">Voir mes conversations</p>
                    </a>

                    <a href="{{ route('wallet') }}" class="action-card">
                        <div class="w-12 h-12 bg-success-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-wallet text-success-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Portefeuille</h3>
                        <p class="text-sm text-gray-600">Gérer mes finances</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Propriétés récentes -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Mes Propriétés Récentes</h2>
                </div>
                <div class="card-body">
                    @forelse($recent_properties as $property)
                    <div class="flex items-center space-x-4 py-3 border-b border-gray-200 last:border-b-0">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-home text-gray-500"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $property->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $property->location }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">{{ number_format($property->price, 0, ',', ' ') }} FCFA</p>
                            <span class="badge {{ $property->status === 'approved' ? 'badge-success' : 'badge-warning' }}">
                                {{ ucfirst($property->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-home text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Aucune propriété ajoutée</p>
                        <a href="{{ route('properties.create') }}" class="btn btn-primary mt-4">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter ma première propriété
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Messages récents -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Messages Récents</h2>
                </div>
                <div class="card-body">
                    @forelse($recent_messages as $message)
                    <div class="flex items-center space-x-4 py-3 border-b border-gray-200 last:border-b-0">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-semibold text-sm">
                                {{ substr($message->sender->name, 0, 1) }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $message->sender->name }}</h3>
                            <p class="text-sm text-gray-600">{{ Str::limit($message->message, 50) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</p>
                            @if(!$message->read)
                                <span class="inline-block w-2 h-2 bg-blue-600 rounded-full mt-1"></span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-envelope text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Aucun message</p>
                        <a href="{{ route('messages.index') }}" class="btn btn-outline mt-4">
                            Voir tous les messages
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
