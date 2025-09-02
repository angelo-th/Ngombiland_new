{{-- resources/views/admin/transactions.blade.php --}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Historique des Transactions</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
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
                    <a href="{{ url('/crowdfunding_management') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-project-diagram mr-3"></i> Projets Crowdfunding
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ url('/history') }}" class="flex items-center p-2 bg-blue-700 rounded">
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
    <div class="flex-1 p-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Historique des Transactions</h2>
                <div class="flex space-x-2">
                    <button class="bg-gray-100 px-4 py-2 rounded flex items-center">
                        <i class="fas fa-download mr-2"></i> Exporter
                    </button>
                    <button class="bg-gray-100 px-4 py-2 rounded flex items-center">
                        <i class="fas fa-filter mr-2"></i> Filtres
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left py-3 px-4">ID Transaction</th>
                            <th class="text-left py-3 px-4">Utilisateur</th>
                            <th class="text-left py-3 px-4">Type</th>
                            <th class="text-left py-3 px-4">Montant</th>
                            <th class="text-left py-3 px-4">Méthode</th>
                            <th class="text-left py-3 px-4">Date</th>
                            <th class="text-left py-3 px-4">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Exemple dynamique --}}
                        @foreach($transactions as $tx)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $tx->id }}</td>
                                <td class="py-3 px-4">{{ $tx->user->name }}</td>
                                <td class="py-3 px-4">{{ $tx->type }}</td>
                                <td class="py-3 px-4">{{ number_format($tx->amount, 0, ',', ' ') }} FCFA</td>
                                <td class="py-3 px-4">{{ $tx->method }}</td>
                                <td class="py-3 px-4">{{ $tx->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 px-4">
                                    @if($tx->status === 'completed')
                                        <span class="bg-green-100 text-green-800 py-1 px-2 rounded-full text-xs">Complété</span>
                                    @elseif($tx->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 py-1 px-2 rounded-full text-xs">En attente</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 py-1 px-2 rounded-full text-xs">Annulé</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
