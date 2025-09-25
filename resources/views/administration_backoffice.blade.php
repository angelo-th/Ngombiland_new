{{-- resources/views/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Admin</title>
    {{-- TailwindCSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    {{-- Custom JS --}}
    <script src="{{ asset('js/administration_backoffice.js') }}"></script>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Sidebar -->
    <div class="flex h-screen">
        <div class="w-64 bg-blue-800 text-white p-4">
            <div class="flex items-center mb-8">
                {{-- Laravel asset helper for logo --}}
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-home text-blue-600 text-xl"></i>
                </div>
                <span class="font-bold">NGOMBILAND ADMIN</span>
            </div>
            <nav>
                <ul>
                    {{-- Use route() helper if named routes exist --}}
                    <li class="mb-2">
                        <a href="{{ url('/administration_backoffice') }}" class="flex items-center p-2 bg-blue-700 rounded">
                            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/user_management') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                            <i class="fas fa-users mr-3"></i> Users
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/estate_management') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                            <i class="fas fa-home mr-3"></i> Properties
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/crowdfunding_management') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                            <i class="fas fa-project-diagram mr-3"></i> Crowdfunding projects
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/history') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                            <i class="fas fa-money-bill-wave mr-3"></i> Transactions
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/stat') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                            <i class="fas fa-chart-bar mr-3"></i> Statistics
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-2 hover:bg-blue-700 rounded">
                            <i class="fas fa-message mr-3"></i> Chat Support
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/parameter') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                            <i class="fas fa-cog mr-3"></i> Settings
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow p-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-xl font-bold">Dashboard</h1>
                    <div class="flex items-center">
                        <div class="relative mr-4">
                            <i class="fas fa-bell text-gray-600"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs">3</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-2">
                                <i class="fas fa-user text-gray-600"></i>
                            </div>
                            <span>Admin</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-gray-500">Users</p>
                                <h3 class="text-2xl font-bold">1,248</h3>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                        </div>
                        <p class="text-green-500 text-sm mt-2">+12% this month</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-gray-500">Properties</p>
                                <h3 class="text-2xl font-bold">856</h3>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-home text-green-600"></i>
                            </div>
                        </div>
                        <p class="text-green-500 text-sm mt-2">+8% this month</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-gray-500">Transactions</p>
                                <h3 class="text-2xl font-bold">FCFA 42M</h3>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="fas fa-money-bill-wave text-purple-600"></i>
                            </div>
                        </div>
                        <p class="text-green-500 text-sm mt-2">+23% this month</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-gray-500">Crowdfunding projects</p>
                                <h3 class="text-2xl font-bold">24</h3>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <i class="fas fa-project-diagram text-yellow-600"></i>
                            </div>
                        </div>
                        <p class="text-green-500 text-sm mt-2">+2 new</p>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white p-6 rounded-lg shadow mb-8">
                    <h2 class="text-xl font-bold mb-4">Recent Activity</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3 px-4">User</th>
                                    <th class="text-left py-3 px-4">Action</th>
                                    <th class="text-left py-3 px-4">Date</th>
                                    <th class="text-left py-3 px-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">Ken Gessy</td>
                                    <td class="py-3 px-4">New property added</td>
                                    <td class="py-3 px-4">10 min ago</td>
                                    <td class="py-3 px-4"><span class="bg-green-100 text-green-800 py-1 px-2 rounded-full text-xs">Accepted</span></td>
                                </tr>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">Gaetan Mbiock</td>
                                    <td class="py-3 px-4">Crowdfunding project</td>
                                    <td class="py-3 px-4">25 min ago</td>
                                    <td class="py-3 px-4"><span class="bg-yellow-100 text-yellow-800 py-1 px-2 rounded-full text-xs">Pending</span></td>
                                </tr>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">Paul Biya</td>
                                    <td class="py-3 px-4">Mobile Money Payment</td>
                                    <td class="py-3 px-4">1h ago</td>
                                    <td class="py-3 px-4"><span class="bg-green-100 text-green-800 py-1 px-2 rounded-full text-xs">DONE</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold mb-4">Pending</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <p class="font-medium">Land title #4587</p>
                                    <p class="text-sm text-gray-500">By Marc Owona</p>
                                </div>
                                <button class="bg-blue-100 text-blue-600 p-1 rounded">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <p class="font-medium">ID #784512</p>
                                    <p class="text-sm text-gray-500">By Alice Mballa</p>
                                </div>
                                <button class="bg-blue-100 text-blue-600 p-1 rounded">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold mb-4">Annonces à modérer</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <p class="font-medium">Appartement à Douala</p>
                                    <p class="text-sm text-gray-500">150,000 FCFA/mois</p>
                                </div>
                                <div>
                                    <button class="bg-green-100 text-green-600 p-1 rounded mr-1">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="bg-red-100 text-red-600 p-1 rounded">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <p class="font-medium">Terrain à Yaoundé</p>
                                    <p class="text-sm text-gray-500">25,000,000 FCFA</p>
                                </div>
                                <div>
                                    <button class="bg-green-100 text-green-600 p-1 rounded mr-1">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="bg-red-100 text-red-600 p-1 rounded">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold mb-4">Alertes système</h3>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="bg-red-100 text-red-600 p-1 rounded-full mr-2 mt-1">
                                    <i class="fas fa-exclamation-circle text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Paiement échoué</p>
                                    <p class="text-sm text-gray-500">Transaction #458712</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-yellow-100 text-yellow-600 p-1 rounded-full mr-2 mt-1">
                                    <i class="fas fa-exclamation-triangle text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Maintenance programmée</p>
                                    <p class="text-sm text-gray-500">Demain à 2h du matin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
