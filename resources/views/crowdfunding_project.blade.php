{{-- resources/views/crowdfunding_project.blade.php --}}
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - My Crowdfunding Investments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    {{-- Laravel asset helper for CSS --}}
    <link rel="stylesheet" href="{{ asset('css/crowdfunding_project.css') }}">
    {{-- Laravel asset helper for JS --}}
    <script src="{{ asset('js/crowdfunding_project.js') }}"></script>
</head>
<body class="h-full">
    <div class="min-h-full">
        {{-- Navigation --}}
        <nav class="gradient-bg shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <img class="h-8 w-8" src="{{ asset('images/logo.png') }}" alt="NGOMBILAND">
                            <span class="ml-2 text-white font-bold text-xl">NGOMBILAND</span>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                {{-- Use Laravel route() or URL helpers --}}
                                <a href="{{ url('/dashboard') }}" class="text-indigo-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                                <a href="{{ url('/property_search') }}" class="text-indigo-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Properties</a>
                                <a href="{{ url('/marketplace_crowdfunding') }}" class="text-white bg-indigo-500 bg-opacity-75 px-3 py-2 rounded-md text-sm font-medium">Crowdfunding</a>
                                <a href="{{ url('/user_walet') }}" class="text-indigo-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Wallet</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Header --}}
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">My Crowdfunding Portfolio</h1>
                        <p class="text-sm text-gray-600 mt-1">Track your real estate investments and returns</p>
                    </div>
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium flex items-center">
                        <i class="fas fa-plus mr-2"></i>Invest in New Project
                    </button>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            {{-- Investment Overview --}}
            <div class="investment-stats rounded-xl shadow-lg p-6 mb-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                {{-- Total Invested --}}
                <div class="bg-white bg-opacity-80 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Invested</p>
                            <p class="text-2xl font-bold text-indigo-600">12,450,000 FCFA</p>
                        </div>
                        <div class="bg-indigo-100 p-2 rounded-full">
                            <i class="fas fa-hand-holding-usd text-indigo-600"></i>
                        </div>
                    </div>
                </div>

                {{-- Active Projects --}}
                <div class="bg-white bg-opacity-80 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Active Projects</p>
                            <p class="text-2xl font-bold text-green-600">4</p>
                        </div>
                        <div class="bg-green-100 p-2 rounded-full">
                            <i class="fas fa-chart-line text-green-600"></i>
                        </div>
                    </div>
                </div>

                {{-- Avg. ROI --}}
                <div class="bg-white bg-opacity-80 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Avg. ROI</p>
                            <p class="text-2xl font-bold text-purple-600">18.5%</p>
                        </div>
                        <div class="bg-purple-100 p-2 rounded-full">
                            <i class="fas fa-percentage text-purple-600"></i>
                        </div>
                    </div>
                </div>

                {{-- Completed --}}
                <div class="bg-white bg-opacity-80 rounded-lg p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Completed</p>
                            <p class="text-2xl font-bold text-blue-600">2</p>
                        </div>
                        <div class="bg-blue-100 p-2 rounded-full">
                            <i class="fas fa-check-circle text-blue-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <select class="appearance-none bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option>All Status</option>
                                <option>Active</option>
                                <option>Completed</option>
                                <option>Pending</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-2.5 text-gray-500 text-xs"></i>
                        </div>
                        <div class="relative">
                            <select class="appearance-none bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option>All Cities</option>
                                <option>Douala</option>
                                <option>Yaoundé</option>
                                <option>Bafoussam</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-2.5 text-gray-500 text-xs"></i>
                        </div>
                    </div>
                    <div class="relative w-full md:w-64">
                        <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Search projects...">
                        <i class="fas fa-search absolute left-3 top-2.5 text-gray-500"></i>
                    </div>
                </div>
            </div>

            {{-- Projects List --}}
            <div class="space-y-6">
                {{-- Active Project --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden project-card">
                    <div class="md:flex">
                        {{-- Project Image --}}
                        <div class="md:w-1/4 relative">
                            <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Project" class="w-full h-48 md:h-full object-cover">
                            <div class="absolute top-3 right-3 bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full status-badge">
                                <i class="fas fa-circle text-green-500 mr-1" style="font-size: 6px;"></i> Active
                            </div>
                        </div>

                        {{-- Project Details --}}
                        <div class="md:w-2/4 p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-gray-900">Akwa Shopping Center</h3>
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">Commercial</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Modern shopping center in Douala's business district with 25 retail spaces and premium amenities.</p>

                            {{-- Progress Bar --}}
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>85% funded (245M/290M FCFA)</span>
                                    <span class="font-medium">15 days left</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full progress-thin">
                                    <div class="bg-green-600 h-full rounded-full" style="width: 85%"></div>
                                </div>
                            </div>

                            {{-- Project Metrics --}}
                            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                <div>
                                    <p class="text-gray-600">Investors</p>
                                    <p class="font-medium">42</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Target ROI</p>
                                    <p class="font-medium text-green-600">22%</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Duration</p>
                                    <p class="font-medium">24 months</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Next Update</p>
                                    <p class="font-medium">Jul 15, 2023</p>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex space-x-3">
                                <button class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                                    <i class="fas fa-chart-line mr-2"></i>Track Progress
                                </button>
                                <button class="w-10 h-10 flex items-center justify-center border border-gray-300 hover:bg-gray-100 rounded-lg text-gray-600 transition-colors">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                        </div>

                        {{-- User Investment --}}
                        <div class="md:w-1/4 bg-gray-50 p-6 border-l border-gray-200">
                            <h4 class="font-medium text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-user-tie mr-2 text-indigo-600"></i> Your Stake
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500">Amount Invested</p>
                                    <p class="font-bold text-lg text-indigo-600">5,000,000 FCFA</p>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <p class="text-xs text-gray-500">Ownership</p>
                                        <p class="font-medium">2.04%</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Projected Return</p>
                                        <p class="font-medium text-green-600">1,100,000 FCFA</p>
                                    </div>
                                </div>
                                <div class="pt-2 border-t border-gray-200">
                                    <p class="text-xs text-gray-500">Invested On</p>
                                    <p class="font-medium">Mar 15, 2023</p>
                                </div>
                                <button class="w-full mt-2 text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center justify-center">
                                    <i class="fas fa-file-contract mr-2"></i>View Contract
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Completed Project --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden project-card">
                    <div class="md:flex">
                        {{-- Project Image --}}
                        <div class="md:w-1/4 relative">
                            <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Project" class="w-full h-48 md:h-full object-cover">
                            <div class="absolute top-3 right-3 bg-purple-100 text-purple-800 text-xs font-medium px-2 py-1 rounded-full status-badge">
                                <i class="fas fa-check-circle text-purple-500 mr-1" style="font-size: 6px;"></i> Completed
                            </div>
                        </div>

                        {{-- Project Details --}}
                        <div class="md:w-2/4 p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-gray-900">Bonanjo Residences</h3>
                                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2 py-1 rounded-full">Residential</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Luxury apartment complex in Bonanjo with 35 units, completed 3 months ahead of schedule.</p>

                            {{-- Completion --}}
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>100% funded (150M/150M FCFA)</span>
                                    <span class="font-medium text-green-600">Fully Delivered</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full progress-thin">
                                    <div class="bg-purple-600 h-full rounded-full" style="width: 100%"></div>
                                </div>
                            </div>

                            {{-- Performance --}}
                            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                <div>
                                    <p class="text-gray-600">Investors</p>
                                    <p class="font-medium">28</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Actual ROI</p>
                                    <p class="font-medium text-green-600">19.2%</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Duration</p>
                                    <p class="font-medium">18 months</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Completion</p>
                                    <p class="font-medium">May 5, 2023</p>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex space-x-3">
                                <button class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                                    <i class="fas fa-file-invoice-dollar mr-2"></i>View Returns
                                </button>
                                <button class="w-10 h-10 flex items-center justify-center border border-gray-300 hover:bg-gray-100 rounded-lg text-gray-600 transition-colors">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                        </div>

                        {{-- User Returns --}}
                        <div class="md:w-1/4 bg-gray-50 p-6 border-l border-gray-200">
                            <h4 class="font-medium text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-coins mr-2 text-yellow-500"></i> Your Returns
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500">Total Invested</p>
                                    <p class="font-bold text-lg text-indigo-600">3,750,000 FCFA</p>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <p class="text-xs text-gray-500">Ownership</p>
                                        <p class="font-medium">2.5%</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Total Returns</p>
                                        <p class="font-medium text-green-600">720,000 FCFA</p>
                                    </div>
                                </div>
                                <div class="pt-2 border-t border-gray-200">
                                    <p class="text-xs text-gray-500">Last Payout</p>
                                    <p class="font-medium">Jun 15, 2023 (180,000 FCFA)</p>
                                </div>
                                <button class="w-full mt-2 text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center justify-center">
                                    <i class="fas fa-history mr-2"></i>Payment History
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
