{{-- resources/views/admin/estate_management.blade.php --}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Gestion des Utilisateurs</title>
    {{-- Tailwind CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="flex h-screen">
    {{-- Sidebar --}}
    <div class="w-64 bg-blue-800 text-white p-4">
        <div class="flex items-center mb-8">
            {{-- Use asset() helper for Laravel --}}
            <img src="{{ asset('images/logo.png') }}" alt="NGOMBILAND" class="h-10 mr-2">
            <span class="font-bold">ADMIN</span>
        </div>
        <nav>
            <ul>
                <li class="mb-2">
                    <a href="{{ url('/administration_backoffice') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ url('/user_management') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-users mr-3"></i> Utilisateurs
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ url('/estate_management') }}" class="flex items-center p-2 bg-blue-700 rounded">
                        <i class="fas fa-home mr-3"></i> Biens Immobiliers
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ url('/crowdfunding_management') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-project-diagram mr-3"></i> Projets Crowdfunding
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ url('/history') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-money-bill-wave mr-3"></i> Transactions
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ url('/stat') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-chart-bar mr-3"></i> Statistiques
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-message mr-3"></i> Chat Support
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ url('/parameter') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-cog mr-3"></i> Paramètres
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    {{-- Main Content --}}
    <div class="bg-gray-50 p-6 rounded-lg shadow flex-1">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Gestion des Biens Immobiliers</h2>
            <div class="flex space-x-2">
                <button class="bg-gray-100 px-4 py-2 rounded flex items-center">
                    <i class="fas fa-filter mr-2"></i> Filtres
                </button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded flex items-center">
                    <i class="fas fa-plus mr-2"></i> Ajouter
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-14 mb-6">
            <div class="border rounded-lg overflow-hidden">
                <img src="{{ asset('property1.jpg') }}" alt="Property" class="w-full h-40 object-cover">
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <h3 class="font-bold">Villa à Bonanjo</h3>
                        <span class="bg-blue-100 text-blue-800 py-1 px-2 rounded-full text-xs">Disponible</span>
                    </div>
                    <p class="text-gray-600 text-sm my-2">5 chambres, 3 salles de bain</p>
                    <p class="font-bold text-lg">75,000,000 FCFA</p>
                    <div class="flex justify-between mt-3">
                        <button class="text-blue-600"><i class="fas fa-eye"></i></button>
                        <button class="text-green-600"><i class="fas fa-edit"></i></button>
                        <button class="text-red-600"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
            {{-- Add more properties dynamically with @foreach --}}
        </div>

        <div class="flex justify-between items-center mt-4">
            <div class="text-gray-500">Affichage 1-6 sur 856</div>
            <div class="flex space-x-1">
                <button class="bg-gray-200 px-3 py-1 rounded">Précédent</button>
                <button class="bg-blue-600 text-white px-3 py-1 rounded">1</button>
                <button class="bg-gray-200 px-3 py-1 rounded">Suivant</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
