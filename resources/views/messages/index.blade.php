@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Messages</h1>
            <p class="mt-2 text-gray-600">Gérez vos conversations et communications</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Liste des messages -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Conversations</h2>
                    </div>
                    
                    @if($messages->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($messages as $message)
                                <div class="p-6 hover:bg-gray-50 cursor-pointer" 
                                     onclick="location.href='{{ route('messages.show', $message) }}'">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-medium text-gray-900">
                                                    {{ $message->sender->name ?? 'Utilisateur inconnu' }}
                                                </h3>
                                                <p class="text-sm text-gray-500">
                                                    {{ Str::limit($message->message, 60) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500">
                                                {{ $message->created_at->diffForHumans() }}
                                            </p>
                                            @if(!$message->read)
                                                <div class="w-3 h-3 bg-blue-600 rounded-full mt-2"></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="p-6 border-t border-gray-200">
                            {{ $messages->links() }}
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <i class="fas fa-envelope text-gray-400 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun message</h3>
                            <p class="text-gray-500">Vous n'avez pas encore reçu de messages.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                    
                    <div class="space-y-3">
                        <button onclick="openNewMessageModal()" 
                                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-plus mr-2"></i>
                            Nouveau Message
                        </button>
                        
                        <a href="{{ route('dashboard') }}" 
                           class="w-full bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour Dashboard
                        </a>
                    </div>

                    <!-- Statistiques -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Statistiques</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Total messages</span>
                                <span class="font-medium">{{ $messages->total() }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Non lus</span>
                                <span class="font-medium text-blue-600">{{ $messages->where('read', false)->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nouveau Message -->
<div id="newMessageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Nouveau Message</h3>
                    <button onclick="closeNewMessageModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form action="{{ route('messages.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="receiver_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Destinataire
                        </label>
                        <select id="receiver_id" name="receiver_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">Sélectionner un utilisateur</option>
                            <!-- Les options seront chargées via JavaScript -->
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message
                        </label>
                        <textarea id="message" name="message" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Tapez votre message..." required></textarea>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeNewMessageModal()" 
                                class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition duration-200">
                            Annuler
                        </button>
                        <button type="submit" 
                                class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                            Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openNewMessageModal() {
    document.getElementById('newMessageModal').classList.remove('hidden');
}

function closeNewMessageModal() {
    document.getElementById('newMessageModal').classList.add('hidden');
}

// Charger la liste des utilisateurs pour le nouveau message
// Cette fonction devrait être implémentée avec une API call
</script>
@endsection
