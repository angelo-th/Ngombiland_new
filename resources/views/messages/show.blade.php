@extends('layouts.app')

@section('title', 'Message - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Message</h1>
                <p class="mt-2 text-gray-600">Conversation avec {{ $message->sender->name }}</p>
            </div>
            <a href="{{ route('messages.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                Retour aux messages
            </a>
        </div>

        <!-- Message Details -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex items-start space-x-4">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-semibold text-xl">
                                {{ substr($message->sender->name, 0, 1) }}
                            </span>
                        </div>
                    </div>

                    <!-- Message Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-semibold text-gray-900">
                                {{ $message->sender->name }}
                            </h3>
                            <div class="flex items-center space-x-2">
                                @if($message->read)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Lu
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Non lu
                                    </span>
                                @endif
                                <span class="text-sm text-gray-500">
                                    {{ $message->created_at->format('d/m/Y à H:i') }}
                                </span>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-4">
                            {{ $message->sender->email }}
                        </p>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">
                                {{ $message->message }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        Message reçu le {{ $message->created_at->format('d/m/Y à H:i') }}
                    </div>
                    <div class="flex space-x-3">
                        <button onclick="openReplyModal()" 
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Répondre
                        </button>
                        <form action="{{ route('messages.destroy', $message) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div id="replyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Répondre à {{ $message->sender->name }}</h3>
                <button onclick="closeReplyModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $message->sender->id }}">
                
                <div class="mb-4">
                    <label for="reply_message" class="block text-sm font-medium text-gray-700 mb-2">
                        Votre réponse
                    </label>
                    <textarea id="reply_message" name="message" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Tapez votre réponse ici..."
                              required></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeReplyModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openReplyModal() {
    document.getElementById('replyModal').classList.remove('hidden');
}

function closeReplyModal() {
    document.getElementById('replyModal').classList.add('hidden');
}
</script>
@endsection