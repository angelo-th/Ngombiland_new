@extends('layouts.app')

@section('title', 'Messages - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Mes Messages</h1>
                <p class="mt-2 text-gray-600">Gérez vos conversations</p>
            </div>
            <button onclick="openMessageModal()" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Nouveau Message
            </button>
        </div>

        <!-- Messages List -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            @forelse($messages as $message)
            <div class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                <a href="{{ route('messages.show', $message) }}" class="block p-6">
                    <div class="flex items-start space-x-4">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-lg">
                                    {{ substr($message->sender->name, 0, 1) }}
                                </span>
                            </div>
                        </div>

                        <!-- Message Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $message->sender->name }}
                                </h3>
                                <div class="flex items-center space-x-2">
                                    @if(!$message->read)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Nouveau
                                        </span>
                                    @endif
                                    <span class="text-sm text-gray-500">
                                        {{ $message->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <p class="mt-1 text-gray-600 line-clamp-2">
                                {{ Str::limit($message->message, 100) }}
                            </p>
                        </div>

                        <!-- Arrow -->
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun message</h3>
                <p class="text-gray-600 mb-4">Vous n'avez pas encore de messages.</p>
                <button onclick="openMessageModal()" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Envoyer un message
                </button>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($messages->hasPages())
        <div class="mt-8">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Message Modal -->
<div id="messageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Nouveau Message</h3>
                <button onclick="closeMessageModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="receiver_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Destinataire
                    </label>
                    <select id="receiver_id" name="receiver_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('receiver_id') border-red-500 @enderror"
                            required>
                        <option value="">Sélectionner un destinataire</option>
                        @foreach(\App\Models\User::where('id', '!=', auth()->id())->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('receiver_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                        Message
                    </label>
                    <textarea id="message" name="message" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('message') border-red-500 @enderror"
                              placeholder="Tapez votre message ici..."
                              required></textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeMessageModal()" 
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
function openMessageModal() {
    document.getElementById('messageModal').classList.remove('hidden');
}

function closeMessageModal() {
    document.getElementById('messageModal').classList.add('hidden');
}
</script>
@endsection