<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Platform Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-blue-800 text-white p-4">
        <div class="flex items-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="NGOMBILAND" class="h-10 mr-2">
            <span class="font-bold">ADMIN</span>
        </div>
        <nav>
            <ul>
                <li class="mb-2">
                    <a href="{{ route('administration_backoffice') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('user_management') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-users mr-3"></i> Users
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('estate_management') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-home mr-3"></i> Properties
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('crowdfunding_management') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-project-diagram mr-3"></i> Crowdfunding Projects
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('history') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-money-bill-wave mr-3"></i> Transactions
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('stat') }}" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-chart-bar mr-3"></i> Statistics
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="flex items-center p-2 hover:bg-blue-700 rounded">
                        <i class="fas fa-message mr-3"></i> Chat Support
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('parameter') }}" class="flex items-center p-2 bg-blue-700 rounded">
                        <i class="fas fa-cog mr-3"></i> Settings
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 bg-white p-6 overflow-auto">
        <h2 class="text-xl font-bold mb-6">Platform Settings</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Section -->
            <div class="md:col-span-2 space-y-6">
                <!-- General Information -->
                <div class="bg-white p-4 rounded-lg border">
                    <h3 class="font-bold mb-4">General Information</h3>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-2">Platform Name</label>
                            <input type="text" value="NGOMBILAND" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Contact Email</label>
                            <input type="email" value="contact@ngombiland.cm" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Phone</label>
                            <input type="tel" value="+237 6XX XXX XXX" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <button class="bg-blue-600 text-white px-6 py-2 rounded-lg">Save</button>
                    </form>
                </div>
                
                <!-- Payments -->
                <div class="bg-white p-4 rounded-lg border">
                    <h3 class="font-bold mb-4">Payments</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <img src="{{ asset('images/mtn-momo.png') }}" alt="MTN Momo" class="h-8 mr-3">
                                <span>MTN Mobile Money</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white 
                                after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all 
                                peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <!-- Additional payment methods here -->
                    </div>
                </div>
            </div>
            
            <!-- Right Section -->
            <div class="space-y-6">
                <!-- Logo -->
                <div class="bg-white p-4 rounded-lg border">
                    <h3 class="font-bold mb-4">Platform Logo</h3>
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-32 mb-4">
                        <button class="bg-gray-100 px-4 py-2 rounded-lg">Change Logo</button>
                    </div>
                </div>
                
                <!-- Maintenance -->
                <div class="bg-white p-4 rounded-lg border">
                    <h3 class="font-bold mb-4">Maintenance</h3>
                    <div class="flex items-center justify-between mb-3">
                        <span>Maintenance Mode</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white 
                            after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all 
                            peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <p class="text-sm text-gray-500">Enable to put the platform in maintenance mode</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
