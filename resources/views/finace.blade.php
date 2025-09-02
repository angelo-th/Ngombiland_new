{{-- resources/views/admin/finance.blade.php --}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Finance</title>
    {{-- Tailwind CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold">Gestion Financière</h1>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <button class="bg-blue-800 text-white px-4 py-2 rounded flex items-center">
                    <i class="fas fa-download mr-2"></i> Exporter
                </button>
            </div>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-500">Revenus Totaux</p>
                    <h3 class="text-2xl font-bold">4,250,000 FCFA</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-money-bill-wave text-green-600"></i>
                </div>
            </div>
            <p class="text-green-500 text-sm mt-2">+15% vs dernier mois</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-500">Investisseurs</p>
                    <h3 class="text-2xl font-bold">128</h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
            </div>
            <p class="text-green-500 text-sm mt-2">+8 nouveaux</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-500">ROI Moyen</p>
                    <h3 class="text-2xl font-bold">7.2%</h3>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-chart-line text-purple-600"></i>
                </div>
            </div>
            <p class="text-green-500 text-sm mt-2">+0.5% vs trimestre dernier</p>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Revenue Chart --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Revenus Mensuels</h2>
                    <select class="border rounded px-2 py-1 text-sm">
                        <option>12 derniers mois</option>
                        <option>6 derniers mois</option>
                        <option>Cette année</option>
                    </select>
                </div>
                <canvas id="revenueChart" height="250"></canvas>
            </div>

            {{-- Recent Transactions --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Dernières Transactions</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 px-4">Date</th>
                                <th class="text-left py-3 px-4">Projet</th>
                                <th class="text-left py-3 px-4">Investisseur</th>
                                <th class="text-left py-3 px-4">Montant</th>
                                <th class="text-left py-3 px-4">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Example: could be dynamic with @foreach --}}
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">15/07/2023</td>
                                <td class="py-3 px-4">Résidence Jasmine</td>
                                <td class="py-3 px-4">Marc Atangana</td>
                                <td class="py-3 px-4">750,000 FCFA</td>
                                <td class="py-3 px-4"><span class="bg-green-100 text-green-800 py-1 px-2 rounded-full text-xs">Complété</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-center">
                    <button class="text-blue-800 font-medium">Voir toutes les transactions</button>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            {{-- Distribution --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Répartition 70/30</h2>
                <div class="flex justify-center mb-4">
                    <canvas id="distributionChart" width="200" height="200"></canvas>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span>Investisseurs (70%)</span>
                        <span class="font-bold">2,975,000 FCFA</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Frais plateforme (20%)</span>
                        <span class="font-bold">850,000 FCFA</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Maintenance (10%)</span>
                        <span class="font-bold">425,000 FCFA</span>
                    </div>
                </div>
            </div>

            {{-- ROI by Project --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">ROI par Projet</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-1">
                            <span>Résidence Jasmine</span>
                            <span class="font-bold">8.2%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 82%"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Actions Rapides</h2>
                <div class="grid grid-cols-2 gap-3">
                    <button class="bg-blue-800 text-white py-2 px-3 rounded flex flex-col items-center">
                        <i class="fas fa-money-bill-transfer mb-1"></i>
                        <span class="text-sm">Redistribuer</span>
                    </button>
                    <button class="bg-green-600 text-white py-2 px-3 rounded flex flex-col items-center">
                        <i class="fas fa-file-invoice-dollar mb-1"></i>
                        <span class="text-sm">Générer rapports</span>
                    </button>
                    <button class="bg-purple-600 text-white py-2 px-3 rounded flex flex-col items-center">
                        <i class="fas fa-envelope mb-1"></i>
                        <span class="text-sm">Notifier investisseurs</span>
                    </button>
                    <button class="bg-yellow-500 text-white py-2 px-3 rounded flex flex-col items-center">
                        <i class="fas fa-calculator mb-1"></i>
                        <span class="text-sm">Calcul fiscal</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
