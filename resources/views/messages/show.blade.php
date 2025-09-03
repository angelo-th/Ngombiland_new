@extends('layouts.app')

@section('title', 'Message')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('messages') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Message</h1>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md">
            <!-- En-tête du message -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">
                                {{ $message->sender->name ?? 'Utilisateur inconnu' }}
                            </h2>
                            <p class="text-sm text-gray-500">
                                {{ $message->sender->email ?? 'Email non disponible' }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">
                            {{ $message->created_at->format('d/m/Y à H:i') }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $message->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contenu du message -->
            <div class="p-6">
                <div class="prose max-w-none">
                    <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $message->message }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="p-6 border-t border-gray-200 bg-gray-50">
                <div class="flex space-x-4">
                    <button onclick="replyToMessage()" 
                            class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center">
                        <i class="fas fa-reply mr-2"></i>
                        Répondre
                    </button>
                    
                    <button onclick="deleteMessage()" 
                            class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200 flex items-center">
                        <i class="fas fa-trash mr-2"></i>
                        Supprimer
                    </button>
                    
                    <a href="{{ route('messages') }}" 
                       class="bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition duration-200 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Section de réponse -->
        <div id="replySection" class="mt-6 bg-white rounded-lg shadow-md p-6 hidden">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Répondre</h3>
            
            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $message->sender_id }}">
                
                <div class="mb-4">
                    <label for="reply_message" class="block text-sm font-medium text-gray-700 mb-2">
                        Votre réponse
                    </label>
                    <textarea id="reply_message" name="message" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Tapez votre réponse..." required></textarea>
                </div>
                
                <div class="flex space-x-3">
                    <button type="button" onclick="cancelReply()" 
                            class="bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition duration-200">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function replyToMessage() {
    document.getElementById('replySection').classList.remove('hidden');
    document.getElementById('reply_message').focus();
}

function cancelReply() {
    document.getElementById('replySection').classList.add('hidden');
    document.getElementById('reply_message').value = '';
}

function deleteMessage() {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce message ?')) {
        // Ici, vous pouvez ajouter une route pour supprimer le message
        // fetch(`/messages/{{ $message->id }}`, { method: 'DELETE' })
        //     .then(() => window.location.href = '{{ route("messages") }}');
        
        alert('Fonctionnalité de suppression à implémenter');
    }
}
</script>
@endsection
