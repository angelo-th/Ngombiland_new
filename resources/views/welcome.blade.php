<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Immobilier collaboratif au Cameroun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <img class="h-8 w-8" src="{{ asset('images/logo.png') }}" alt="NGOMBILAND">
                    <span class="ml-2 text-white font-bold text-xl text-gray-900">NGOMBILAND</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('properties.index') }}" class="text-gray-700 hover:text-indigo-600">Propriétés</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                        <a href="{{ route('logout') }}" class="text-gray-700 hover:text-indigo-600">Déconnexion</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">S'inscrire</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Immobilier collaboratif au Cameroun
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-indigo-100">
                Investissez dans l'immobilier camerounais avec NGOMBILAND
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('properties.index') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Voir les propriétés
                </a>
                @guest
                    <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition-colors">
                        Commencer à investir
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Pourquoi choisir NGOMBILAND ?</h2>
                <p class="text-xl text-gray-600">Une plateforme innovante pour l'investissement immobilier</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-home text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Propriétés vérifiées</h3>
                    <p class="text-gray-600">Toutes nos propriétés sont vérifiées et documentées par nos experts</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">ROI attractif</h3>
                    <p class="text-gray-600">Bénéficiez de retours sur investissement compétitifs</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Sécurisé</h3>
                    <p class="text-gray-600">Vos investissements sont protégés par nos garanties</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-indigo-600 mb-2">150+</div>
                    <div class="text-gray-600">Propriétés disponibles</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-green-600 mb-2">25M+</div>
                    <div class="text-gray-600">FCFA investis</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-purple-600 mb-2">500+</div>
                    <div class="text-gray-600">Investisseurs actifs</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-orange-600 mb-2">18%</div>
                    <div class="text-gray-600">ROI moyen</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-indigo-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Prêt à commencer ?</h2>
            <p class="text-xl mb-8 text-indigo-100">Rejoignez des centaines d'investisseurs qui font confiance à NGOMBILAND</p>
            @guest
                <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Créer un compte gratuit
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Accéder au dashboard
                </a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <img class="h-8 w-8" src="{{ asset('images/logo.png') }}" alt="NGOMBILAND">
                        <span class="ml-2 text-xl font-bold">NGOMBILAND</span>
                    </div>
                    <p class="text-gray-400">La plateforme d'investissement immobilier collaboratif au Cameroun</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('properties.index') }}" class="text-gray-400 hover:text-white">Propriétés</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Comment ça marche</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">À propos</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Aide</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Suivez-nous</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin text-xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2023 NGOMBILAND. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>
