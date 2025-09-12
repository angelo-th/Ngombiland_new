@extends('layouts.app')

@section('title', 'Modifier le Profil - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Modifier le Profil</h1>
                    <p class="mt-2 text-gray-600">Mettez à jour vos informations personnelles</p>
                </div>
                <a href="{{ route('profile.show') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
            </div>
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
                               class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                                <i class="fas fa-user mr-3"></i>
                                Informations personnelles
                            </a>
                            <a href="{{ route('profile.edit') }}" 
                               class="flex items-center px-4 py-3 text-sm font-medium text-primary-600 bg-primary-50 border-r-2 border-primary-600">
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
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Informations personnelles -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-xl font-semibold text-gray-900">Informations personnelles</h2>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">Prénom *</label>
                                    <input type="text" 
                                           id="first_name" 
                                           name="first_name" 
                                           value="{{ old('first_name', auth()->user()->first_name) }}"
                                           class="form-input @error('first_name') border-error-500 @enderror"
                                           required>
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-error-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="last_name" class="form-label">Nom *</label>
                                    <input type="text" 
                                           id="last_name" 
                                           name="last_name" 
                                           value="{{ old('last_name', auth()->user()->last_name) }}"
                                           class="form-input @error('last_name') border-error-500 @enderror"
                                           required>
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-error-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', auth()->user()->email) }}"
                                           class="form-input @error('email') border-error-500 @enderror"
                                           required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-error-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="form-label">Téléphone *</label>
                                    <input type="tel" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', auth()->user()->phone) }}"
                                           class="form-input @error('phone') border-error-500 @enderror"
                                           placeholder="+237 6XX XXX XXX"
                                           required>
                                    @error('phone')
                                        <p class="mt-1 text-sm text-error-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mot de passe -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-xl font-semibold text-gray-900">Changer le mot de passe</h2>
                            <p class="text-sm text-gray-600 mt-1">Laissez vide si vous ne souhaitez pas changer le mot de passe</p>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-group">
                                    <label for="current_password" class="form-label">Mot de passe actuel</label>
                                    <input type="password" 
                                           id="current_password" 
                                           name="current_password"
                                           class="form-input @error('current_password') border-error-500 @enderror">
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-error-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label">Nouveau mot de passe</label>
                                    <input type="password" 
                                           id="password" 
                                           name="password"
                                           class="form-input @error('password') border-error-500 @enderror">
                                    @error('password')
                                        <p class="mt-1 text-sm text-error-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group md:col-span-2">
                                    <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation"
                                           class="form-input">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('profile.show') }}" class="btn btn-ghost">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
