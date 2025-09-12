<div class="relative">
    <!-- Bouton de notification -->
    <button 
        wire:click="toggleDropdown"
        class="relative p-2 text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600"
    >
        <i class="fas fa-bell text-xl"></i>
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 badge badge-error">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown des notifications -->
    @if($showDropdown)
    <div class="absolute right-0 mt-2 w-80 card py-1 z-50 max-h-96 overflow-y-auto"
         x-data="{ open: true }"
         x-show="open"
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
                @if($unreadCount > 0)
                    <button 
                        wire:click="markAllAsRead"
                        class="text-sm text-blue-600 hover:text-blue-800"
                    >
                        Tout marquer comme lu
                    </button>
                @endif
            </div>
            
            <!-- Filtres -->
            <div class="flex space-x-2 mt-2">
                <button 
                    wire:click="setFilter('all')"
                    class="px-3 py-1 text-xs rounded-full {{ $filter === 'all' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}"
                >
                    Toutes
                </button>
                <button 
                    wire:click="setFilter('unread')"
                    class="px-3 py-1 text-xs rounded-full {{ $filter === 'unread' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}"
                >
                    Non lues
                </button>
                <button 
                    wire:click="setFilter('read')"
                    class="px-3 py-1 text-xs rounded-full {{ $filter === 'read' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}"
                >
                    Lues
                </button>
            </div>
        </div>

        <!-- Liste des notifications -->
        <div class="max-h-64 overflow-y-auto">
            @forelse($notifications as $notification)
            <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 {{ !$notification->read ? 'bg-blue-50' : '' }}">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center">
                            <!-- Icône selon le type -->
                            @switch($notification->type)
                                @case('message')
                                    <i class="fas fa-envelope text-blue-500 mr-2"></i>
                                    @break
                                @case('investment')
                                    <i class="fas fa-chart-line text-green-500 mr-2"></i>
                                    @break
                                @case('property')
                                    <i class="fas fa-home text-purple-500 mr-2"></i>
                                    @break
                                @case('system')
                                    <i class="fas fa-cog text-gray-500 mr-2"></i>
                                    @break
                                @default
                                    <i class="fas fa-bell text-gray-500 mr-2"></i>
                            @endswitch
                            
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 {{ !$notification->read ? 'font-bold' : '' }}">
                                    {{ $notification->title }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ Str::limit($notification->message, 80) }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 ml-2">
                        @if(!$notification->read)
                            <button 
                                wire:click="markAsRead({{ $notification->id }})"
                                class="text-xs text-blue-600 hover:text-blue-800"
                                title="Marquer comme lu"
                            >
                                <i class="fas fa-check"></i>
                            </button>
                        @endif
                        <button 
                            wire:click="deleteNotification({{ $notification->id }})"
                            class="text-xs text-red-600 hover:text-red-800"
                            title="Supprimer"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="px-4 py-8 text-center">
                <i class="fas fa-bell-slash text-4xl text-gray-300 mb-2"></i>
                <p class="text-gray-500">Aucune notification</p>
            </div>
            @endforelse
        </div>

        <!-- Footer -->
        @if($notifications->count() > 0)
        <div class="px-4 py-2 border-t border-gray-200 text-center">
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">
                Voir toutes les notifications
            </a>
        </div>
        @endif
    </div>
    @endif
</div>