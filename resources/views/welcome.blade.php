<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Plateforme Immobilière Camerounaise</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="font-sans antialiased bg-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-home text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold text-gray-900">NGOMBILAND</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium transition-colors">Fonctionnalités</a>
                    <a href="#projects" class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium transition-colors">Projets</a>
                    <a href="#about" class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium transition-colors">À propos</a>
                    <a href="#contact" class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium transition-colors">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium transition-colors">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium transition-colors">Déconnexion</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium transition-colors">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6 leading-tight">
                    Investissez dans l'immobilier camerounais avec le crowdfunding
                </h1>
                <p class="text-xl mb-8 text-blue-100 max-w-3xl mx-auto">
                    Démocratisez l'investissement immobilier au Cameroun. Achetez des parts de propriétés, recevez des revenus locatifs et revendez sur le marché secondaire.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors text-center">
                            Accéder au Dashboard
                        </a>
                        <a href="{{ route('crowdfunding.index') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors text-center">
                            Voir les Projets
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors text-center">
                            Commencer maintenant
                        </a>
                        <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors text-center">
                            Se connecter
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ \App\Models\User::count() }}</div>
                    <div class="text-gray-600">Utilisateurs actifs</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-green-600 mb-2">{{ \App\Models\Property::count() }}</div>
                    <div class="text-gray-600">Propriétés listées</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-purple-600 mb-2">{{ \App\Models\CrowdfundingProject::count() }}</div>
                    <div class="text-gray-600">Projets crowdfunding</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-yellow-600 mb-2">{{ number_format(\App\Models\CrowdfundingInvestment::sum('amount_invested') ?? 0) }}</div>
                    <div class="text-gray-600">FCFA investis</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projets Crowdfunding Actifs -->
    <section id="projects" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Projets Crowdfunding Actifs</h2>
                <p class="text-lg text-gray-600">Investissez dans des projets immobiliers prometteurs</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach(\App\Models\CrowdfundingProject::where('status', 'active')->take(3)->get() as $project)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    @if($project->images && count($project->images) > 0)
                    <img src="{{ asset('storage/' . $project->images[0]) }}" alt="{{ $project->title }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-home text-4xl text-gray-400"></i>
                    </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $project->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($project->description, 100) }}</p>
                        
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Progression</span>
                                <span>{{ round($project->progress_percentage) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Montant levé</p>
                                <p class="text-lg font-semibold">{{ number_format($project->amount_raised) }} FCFA</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">ROI attendu</p>
                                <p class="text-lg font-semibold text-green-600">{{ $project->expected_roi }}%</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('crowdfunding.show', $project) }}" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 text-center block">
                            Voir le projet
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-8">
                <a href="{{ route('crowdfunding.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                    Voir tous les projets
                </a>
            </div>
        </div>
    </section>

    <!-- Fonctionnalités -->
    <section id="features" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Pourquoi choisir NGOMBILAND ?</h2>
                <p class="text-lg text-gray-600">Une plateforme complète pour l'investissement immobilier</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-coins text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Crowdfunding Immobilier</h3>
                    <p class="text-gray-600">Investissez dans l'immobilier avec des montants accessibles grâce au crowdfunding</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Revenus Locatifs</h3>
                    <p class="text-gray-600">Recevez 70% des revenus locatifs proportionnellement à vos parts</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exchange-alt text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Marché Secondaire</h3>
                    <p class="text-gray-600">Revendez vos parts sur notre marketplace secondaire</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Prêt à commencer votre investissement ?</h2>
            <p class="text-xl text-blue-100 mb-8">Rejoignez des milliers d'investisseurs qui font confiance à NGOMBILAND</p>
            @auth
                <a href="{{ route('crowdfunding.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Découvrir les projets
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Créer un compte
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-2">
                            <i class="fas fa-home text-white"></i>
                        </div>
                        <span class="text-xl font-bold">NGOMBILAND</span>
                    </div>
                    <p class="text-gray-400">La plateforme immobilière nouvelle génération pour le Cameroun</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('crowdfunding.index') }}" class="text-gray-400 hover:text-white">Projets</a></li>
                        <li><a href="{{ route('properties.index') }}" class="text-gray-400 hover:text-white">Propriétés</a></li>
                        <li><a href="{{ route('secondary-market.index') }}" class="text-gray-400 hover:text-white">Marché secondaire</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Contact</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white">À propos</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <div class="space-y-2 text-gray-400">
                        <p><i class="fas fa-envelope mr-2"></i>contact@ngombiland.cm</p>
                        <p><i class="fas fa-phone mr-2"></i>+237 6XX XXX XXX</p>
                        <p><i class="fas fa-map-marker-alt mr-2"></i>Douala, Cameroun</p>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 NGOMBILAND. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>