@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Utilisateurs</h1>
                <p class="mt-2 text-gray-600">Gérez les comptes utilisateurs de la plateforme</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                Retour au Dashboard
            </a>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <form method="GET" action="{{ route('admin.users') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Nom, email...">
                </div>
                
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                    <select name="role" id="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les rôles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                        <option value="proprietor" {{ request('role') === 'proprietor' ? 'selected' : '' }}>Propriétaire</option>
                        <option value="investor" {{ request('role') === 'investor' ? 'selected' : '' }}>Investisseur</option>
                        <option value="agent" {{ request('role') === 'agent' ? 'selected' : '' }}>Agent</option>
                        <option value="client" {{ request('role') === 'client' ? 'selected' : '' }}>Client</option>
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspendu</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Filtrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Utilisateurs</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $users->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-check text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Actifs</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $users->where('status', 'active')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-clock text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En attente</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $users->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-times text-red-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Suspendus</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $users->where('status', 'suspended')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des utilisateurs -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Liste des Utilisateurs</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Utilisateur
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rôle
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Propriétés
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Inscription
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                        <span class="text-gray-600 font-semibold">
                                            {{ substr($user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($user->role === 'admin') bg-red-100 text-red-800
                                    @elseif($user->role === 'proprietor') bg-blue-100 text-blue-800
                                    @elseif($user->role === 'investor') bg-green-100 text-green-800
                                    @elseif($user->role === 'agent') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->properties->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($user->status === 'active') bg-green-100 text-green-800
                                    @elseif($user->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($user->status === 'suspended') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    @if($user->status === 'active') Actif
                                    @elseif($user->status === 'pending') En attente
                                    @elseif($user->status === 'suspended') Suspendu
                                    @else {{ ucfirst($user->status) }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="viewUser({{ $user->id }})" 
                                            class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="editUser({{ $user->id }})" 
                                            class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if($user->status === 'active')
                                    <button onclick="suspendUser({{ $user->id }})" 
                                            class="text-orange-600 hover:text-orange-900">
                                        <i class="fas fa-pause"></i>
                                    </button>
                                    @else
                                    <button onclick="activateUser({{ $user->id }})" 
                                            class="text-green-600 hover:text-green-900">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    @endif
                                    <button onclick="deleteUser({{ $user->id }})" 
                                            class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                                <p>Aucun utilisateur trouvé</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="mt-8">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function viewUser(userId) {
    // TODO: Implémenter la vue détaillée de l'utilisateur
    alert('Voir utilisateur ' + userId);
}

function editUser(userId) {
    // TODO: Implémenter l'édition de l'utilisateur
    alert('Modifier utilisateur ' + userId);
}

function suspendUser(userId) {
    if (confirm('Êtes-vous sûr de vouloir suspendre cet utilisateur ?')) {
        // TODO: Implémenter la suspension de l'utilisateur
        alert('Suspendre utilisateur ' + userId);
    }
}

function activateUser(userId) {
    if (confirm('Êtes-vous sûr de vouloir activer cet utilisateur ?')) {
        // TODO: Implémenter l'activation de l'utilisateur
        alert('Activer utilisateur ' + userId);
    }
}

function deleteUser(userId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')) {
        // TODO: Implémenter la suppression de l'utilisateur
        alert('Supprimer utilisateur ' + userId);
    }
}
</script>
@endsection