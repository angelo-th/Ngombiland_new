{{-- resources/views/crowdfunding_management.blade.php --}}
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

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/crowdfunding_management.css') }}">

    {{-- Custom JS --}}
    <script src="{{ asset('js/crowdfunding_management.js') }}"></script>
</head>
<body>
    <div class="flex h-screen">
        {{-- Sidebar --}}
        <div class="w-64 bg-blue-800 text-white p-4">
            <div class="flex items-center mb-8">
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
                        <a href="{{ url('/estate_management') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                            <i class="fas fa-home mr-3"></i> Biens Immobiliers
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/crowdfunding_management') }}" class="flex items-center p-2 bg-blue-700 rounded">
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
        <div class="bg-white p-6 rounded-lg shadow w-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Projets Crowdfunding</h2>
                <button class="bg-blue-600 text-white px-4 py-2 rounded flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nouveau Projet
                </button>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left py-3 px-4">Projet</th>
                            <th class="text-left py-3 px-4">Localisation</th>
                            <th class="text-left py-3 px-4">Objectif</th>
                            <th class="text-left py-3 px-4">Collecté</th>
                            <th class="text-left py-3 px-4">Participants</th>
                            <th class="text-left py-3 px-4">Statut</th>
                            <th class="text-left py-3 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Example Project Row --}}
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <img src="{{ asset('project1.jpg') }}" alt="Project" class="w-10 h-10 rounded mr-2">
                                    <div>
                                        <p class="font-medium">Résidence Les Palmiers</p>
                                        <p class="text-xs text-gray-500">ID: #CF4587</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">Douala, Bonanjo</td>
                            <td class="py-3 px-4">250,000,000 FCFA</td>
                            <td class="py-3 px-4">187,500,000 FCFA (75%)</td>
                            <td class="py-3 px-4">42</td>
                            <td class="py-3 px-4">
                                <span class="bg-green-100 text-green-800 py-1 px-2 rounded-full text-xs">En cours</span>
                            </td>
                            <td class="py-3 px-4 flex space-x-2">
                                <button class="text-blue-600"><i class="fas fa-eye"></i></button>
                                <button class="text-yellow-600"><i class="fas fa-chart-line"></i></button>
                            </td>
                        </tr>
                        {{-- Add more projects dynamically here --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
