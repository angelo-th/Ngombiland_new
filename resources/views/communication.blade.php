{{-- resources/views/communication.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Communication</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    {{-- FontAwesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- Laravel asset helper for CSS --}}
    <link rel="stylesheet" href="{{ asset('css/communication.css') }}">

    {{-- Laravel asset helper for JS --}}
    <script src="{{ asset('js/communication.js') }}"></script>
</head>
<body class="bg-gray-50" x-data="communicationApp()">
    {{-- Header --}}
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="javascript:history.back()" class="mr-4 text-gray-500 hover:text-emerald-600 flex items-center">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    {{-- Logo with asset helper --}}
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-home text-white text-xl"></i>
                    </div>
                    <h1 class="text-xl font-bold text-gray-800">Centre de Communication</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button @click="openNotifications" class="p-2 text-gray-600 hover:text-primary relative">
                        <i class="fas fa-bell text-xl"></i>
                        <span x-show="unreadNotifications > 0"
                              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
                              x-text="unreadNotifications"></span>
                    </button>
                    {{-- Dynamic user avatar --}}
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center border-2 border-white shadow">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-4">
                {{-- Quick Support --}}
                <div class="bg-white rounded-xl shadow-md p-4">
                    <h3 class="font-bold text-lg mb-3">Support Rapide</h3>
                    <div class="space-y-2">
                        <button @click="startNewChat('support')" class="w-full text-left px-3 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                            <i class="fas fa-headset mr-2"></i>Nouvelle demande
                        </button>
                        <button @click="activeTab = 'faq'" class="w-full text-left px-3 py-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="fas fa-question-circle mr-2"></i>FAQ
                        </button>
                        <button @click="activeTab = 'guides'" class="w-full text-left px-3 py-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="fas fa-book mr-2"></i>Guides
                        </button>
                    </div>
                </div>

                {{-- Conversations List --}}
                <div class="bg-white rounded-xl shadow-md p-4">
                    <h3 class="font-bold text-lg mb-3">Messages</h3>
                    <div class="space-y-2">
                        <template x-for="conversation in conversations" :key="conversation.id">
                            <button @click="selectConversation(conversation.id)" 
                                    :class="{'bg-gray-100': activeConversation === conversation.id}"
                                    class="w-full text-left p-2 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                                <img :src="conversation.avatar" class="w-10 h-10 rounded-full mr-3">
                                <div class="flex-1 truncate">
                                    <p class="font-medium" x-text="conversation.name"></p>
                                    <p class="text-sm text-gray-500 truncate" x-text="conversation.lastMessage"></p>
                                </div>
                                <span x-show="conversation.unread > 0" class="bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center" x-text="conversation.unread"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Main Chat / FAQ / Guides --}}
            <div class="lg:col-span-3">
                
                {{-- Chat Section --}}
                <div x-show="activeTab === 'chat'" class="bg-white rounded-xl shadow-md overflow-hidden h-full">
                    <div class="border-b border-gray-200 p-4 flex items-center justify-between bg-gray-50">
                        <div class="flex items-center space-x-3">
                            <img :src="currentChat.avatar" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-bold" x-text="currentChat.name"></p>
                                <p class="text-xs text-gray-500">
                                    <span x-show="currentChat.isTyping" class="text-emerald-500">
                                        <i class="fas fa-circle text-xs"></i> En train d'écrire...
                                    </span>
                                    <span x-show="!currentChat.isTyping && currentChat.online" class="text-green-500">
                                        <i class="fas fa-circle text-xs"></i> En ligne
                                    </span>
                                    <span x-show="!currentChat.online" class="text-gray-500">Hors ligne</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="p-2 text-gray-500 hover:text-emerald-500"><i class="fas fa-phone"></i></button>
                            <button class="p-2 text-gray-500 hover:text-emerald-500"><i class="fas fa-video"></i></button>
                            <button class="p-2 text-gray-500 hover:text-emerald-500"><i class="fas fa-ellipsis-v"></i></button>
                        </div>
                    </div>

                    {{-- Messages --}}
                    <div class="p-4 h-96 overflow-y-auto space-y-4" x-ref="messagesContainer">
                        <template x-for="message in currentChat.messages" :key="message.id">
                            <div :class="{'flex justify-end': message.sender === 'user', 'flex': message.sender !== 'user'}" class="space-x-3">
                                <img x-show="message.sender !== 'user'" :src="currentChat.avatar" class="w-8 h-8 rounded-full mt-1">
                                <div class="chat-message">
                                    <div :class="{'bg-emerald-500 text-white': message.sender === 'user', 'bg-gray-100': message.sender !== 'user'}" class="rounded-lg p-3">
                                        <p x-text="message.text"></p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1" x-text="message.time"></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Input --}}
                    <div class="border-t border-gray-200 p-4 bg-white">
                        <div class="flex items-center space-x-3">
                            <button class="text-gray-500 hover:text-emerald-500"><i class="fas fa-paperclip"></i></button>
                            <input x-model="newMessage" @keyup.enter="sendMessage" type="text" placeholder="Écrivez votre message..." class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <button @click="sendMessage" class="bg-emerald-500 text-white p-2 rounded-lg hover:bg-emerald-600 transition-colors">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- FAQ --}}
                <div x-show="activeTab === 'faq'" class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-6">Foire Aux Questions</h2>
                    <div class="space-y-4">
                        <template x-for="item in faqs" :key="item.id">
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <button @click="toggleFAQ(item.id)" class="w-full text-left p-4 hover:bg-gray-50 flex justify-between items-center">
                                    <span class="font-medium" x-text="item.question"></span>
                                    <i :class="{'transform rotate-180': openedFAQ === item.id}" class="fas fa-chevron-down transition-transform"></i>
                                </button>
                                <div x-show="openedFAQ === item.id" x-collapse class="p-4 pt-0 text-gray-700">
                                    <p x-text="item.answer"></p>
                                    <div x-show="item.link" class="mt-3">
                                        <a :href="item.link" class="text-emerald-500 hover:underline">En savoir plus</a>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Guides --}}
                <div x-show="activeTab === 'guides'" class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-6">Guides d'Utilisation</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <template x-for="guide in guides" :key="guide.id">
                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                                <img :src="guide.image" class="w-full h-40 object-cover">
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-2" x-text="guide.title"></h3>
                                    <p class="text-gray-600 mb-3" x-text="guide.description"></p>
                                    <a :href="guide.link" class="text-emerald-500 hover:underline">Lire le guide →</a>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Notifications Panel --}}
    <div x-show="showNotifications" x-transition class="fixed inset-0 bg-black/50 z-50 flex justify-end">
        <div class="bg-white w-full max-w-md h-full overflow-y-auto" @click.stop>
            <div class="sticky top-0 bg-white border-b p-4 flex justify-between items-center">
                <h3 class="text-xl font-bold">Notifications</h3>
                <button @click="showNotifications = false" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4 space-y-3">
                <template x-for="notification in notifications" :key="notification.id">
                    <div :class="{'bg-blue-50': !notification.read}" class="border border-gray-200 rounded-lg p-3">
                        <div class="flex items-start space-x-3">
                            <div :class="{'text-blue-500': notification.type === 'info', 'text-green-500': notification.type === 'success', 'text-yellow-500': notification.type === 'warning'}" class="mt-1">
                                <i :class="{'fas fa-info-circle': notification.type === 'info', 'fas fa-check-circle': notification.type === 'success', 'fas fa-exclamation-triangle': notification.type === 'warning'}"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium" x-text="notification.title"></p>
                                <p class="text-sm text-gray-600" x-text="notification.message"></p>
                                <p class="text-xs text-gray-400 mt-1" x-text="notification.time"></p>
                            </div>
                            <button @click="markAsRead(notification.id)" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</body>
</html>
