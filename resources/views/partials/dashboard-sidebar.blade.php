<nav class="bg-white shadow-lg rounded-lg p-4">
    <div class="space-y-4">
        <!-- Dashboard Home -->
        <div class="flex items-center space-x-3 p-3 rounded-lg text-gray-700">
            <i class="fas fa-home w-5"></i>
            <span class="font-medium">Dashboard</span>
        </div>

        <!-- Properties -->
        <div class="flex items-center space-x-3 p-3 rounded-lg text-gray-700">
            <i class="fas fa-building w-5"></i>
            <span class="font-medium">Properties</span>
            <span class="text-xs text-gray-500">(Coming Soon)</span>
        </div>

        <!-- Investments -->
        <div class="flex items-center space-x-3 p-3 rounded-lg text-gray-700">
            <i class="fas fa-chart-line w-5"></i>
            <span class="font-medium">Investments</span>
            <span class="text-xs text-gray-500">(Coming Soon)</span>
        </div>

        @if(auth()->check())
        <!-- Wallet -->
        <a href="{{ route('wallet') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('wallet') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-wallet w-5"></i>
            <span class="font-medium">Wallet</span>
        </a>

        <!-- Messages -->
        <a href="{{ route('messages') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('messages') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-envelope w-5"></i>
            <span class="font-medium">Messages</span>
            @if(isset($unreadMessages) && $unreadMessages > 0)
                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $unreadMessages }}</span>
            @endif
        </a>

        <!-- Reports -->
        <a href="{{ route('reports') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('reports') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-file-alt w-5"></i>
            <span class="font-medium">Reports</span>
        </a>
        @else
        <!-- Guest Links -->
        <div class="space-y-2">
            <div class="flex items-center space-x-3 p-3 rounded-lg text-gray-400">
                <i class="fas fa-wallet w-5"></i>
                <span class="font-medium">Wallet</span>
                <span class="text-xs text-gray-400">(Connexion requise)</span>
            </div>
            <div class="flex items-center space-x-3 p-3 rounded-lg text-gray-400">
                <i class="fas fa-envelope w-5"></i>
                <span class="font-medium">Messages</span>
                <span class="text-xs text-gray-400">(Connexion requise)</span>
            </div>
            <div class="flex items-center space-x-3 p-3 rounded-lg text-gray-400">
                <i class="fas fa-file-alt w-5"></i>
                <span class="font-medium">Reports</span>
                <span class="text-xs text-gray-400">(Connexion requise)</span>
            </div>
        </div>
        @endif

        @if(auth()->check() && auth()->user()->isAdmin())
        <!-- Admin Section -->
        <div class="pt-4 mt-4 border-t border-gray-200">
            <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Admin</h3>
            
            <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 p-3 mt-3 rounded-lg {{ request()->routeIs('admin.users') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-users w-5"></i>
                <span class="font-medium">User Management</span>
            </a>

            <a href="{{ route('admin.settings') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.settings') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-cog w-5"></i>
                <span class="font-medium">Settings</span>
            </a>
        </div>
        @endif
    </div>

    <!-- Profile Section -->
    @if(auth()->check())
    <div class="mt-6 pt-6 border-t border-gray-200">
        <div class="flex items-center px-3 py-2">
            <img src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ auth()->user()->name }}" class="h-10 w-10 rounded-full">
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>
    @else
    <!-- Guest Section -->
    <div class="mt-6 pt-6 border-t border-gray-200">
        <div class="px-3 py-2">
            <p class="text-sm text-gray-500 mb-3">Connectez-vous pour accéder à votre profil</p>
            <div class="space-y-2">
                <a href="{{ route('login') }}" class="block w-full bg-indigo-600 text-white text-center py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors">
                    Se connecter
                </a>
                <a href="{{ route('register') }}" class="block w-full bg-gray-200 text-gray-700 text-center py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors">
                    S'inscrire
                </a>
            </div>
        </div>
    </div>
    @endif
</nav>