<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND Mobile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .mobile-container {
            max-width: 414px;
            margin: 0 auto;
            background-color: #f5f5f5;
            min-height: 100vh;
            position: relative;
        }
        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            max-width: 414px;
            background: white;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
        }
        .bottom-nav a {
            flex: 1;
            text-align: center;
            padding: 10px 0;
            color: #666;
        }
        .bottom-nav a.active {
            color: #2c5282;
        }
        .property-card {
            transition: transform 0.2s;
        }
        .property-card:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <div class="mobile-container">
        <!-- Header -->
        <header class="bg-blue-800 text-white p-4 sticky top-0 z-10">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <img src="/logo-white.png" alt="NGOMBILAND" class="h-8 mr-2">
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-search"></i>
                    <i class="fas fa-bell"></i>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="pb-16">
            <!-- Search Bar -->
            <div class="p-3 bg-white shadow-sm">
                <div class="relative">
                    <input type="text" placeholder="Rechercher un bien, un lieu..." class="w-full p-2 pl-10 border border-gray-300 rounded-full">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Quick Filters -->
            <div class="p-3 bg-white mt-1 overflow-x-auto">
                <div class="flex space-x-2 w-max">
                    <button class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm whitespace-nowrap">Tous</button>
                    <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm whitespace-nowrap">Maisons</button>
                    <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm whitespace-nowrap">Appartements</button>
                    <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm whitespace-nowrap">Terrains</button>
                    <button class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm whitespace-nowrap">Crowdfunding</button>
                </div>
            </div>

            <!-- Property List -->
            <div class="mt-2 space-y-2">
                <div class="property-card bg-white p-3 shadow-sm">
                    <div class="relative">
                        <img src="/property1.jpg" alt="Appartement" class="w-full h-48 object-cover rounded">
                        <div class="absolute top-2 right-2 bg-blue-800 text-white px-2 py-1 rounded text-xs">
                            <i class="fas fa-star mr-1"></i> 4.8
                        </div>
                        <div class="absolute bottom-2 left-2 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs">
                            <i class="fas fa-map-marker-alt mr-1"></i> Douala
                        </div>
                    </div>
                    <div class="mt-2">
                        <h3 class="font-bold">Appartement moderne 3 pièces</h3>
                        <p class="text-gray-600 text-sm">Bonamoussadi, Douala</p>
                        <div class="flex justify-between items-center mt-2">
                            <span class="font-bold text-blue-800">150,000 FCFA/mois</span>
                            <button class="text-blue-800">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="property-card bg-white p-3 shadow-sm">
                    <div class="relative">
                        <img src="/property2.jpg" alt="Terrain" class="w-full h-48 object-cover rounded">
                        <div class="absolute top-2 right-2 bg-blue-800 text-white px-2 py-1 rounded text-xs">
                            Crowdfunding
                        </div>
                    </div>
                    <div class="mt-2">
                        <h3 class="font-bold">Terrain constructible 500m²</h3>
                        <p class="text-gray-600 text-sm">Odza, Yaoundé</p>
                        <div class="mt-1">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: 65%"></div>
                            </div>
                            <div class="flex justify-between text-xs mt-1">
                                <span>65% financé</span>
                                <span>35 parts restantes</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="font-bold text-blue-800">25,000 FCFA/part</span>
                            <button class="bg-blue-800 text-white px-3 py-1 rounded text-sm">
                                Investir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Bottom Navigation -->
        <nav class="bottom-nav flex">
            <a href="#" class="active">
                <i class="fas fa-home block mx-auto mb-1"></i>
                <span class="text-xs">Accueil</span>
            </a>
            <a href="#">
                <i class="fas fa-search block mx-auto mb-1"></i>
                <span class="text-xs">Recherche</span>
            </a>
            <a href="#">
                <i class="fas fa-project-diagram block mx-auto mb-1"></i>
                <span class="text-xs">Investir</span>
            </a>
            <a href="#">
                <i class="fas fa-user block mx-auto mb-1"></i>
                <span class="text-xs">Profil</span>
            </a>
        </nav>
    </div>
</body>
</html>