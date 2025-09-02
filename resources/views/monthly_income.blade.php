<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Monthly Income</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/monthly_income.css') }}">

    <!-- Custom JS -->
    <script src="{{ asset('js/monthly_income.js') }}" defer></script>
</head>
<body class="h-full">
    <div class="min-h-full">
        <!-- Navigation -->
        @include('partials.dashboard_nav')

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Monthly Income</h1>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option>2023</option>
                            <option>2022</option>
                            <option>2021</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-500 text-xs"></i>
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-indigo-600 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @include('partials.income_card', [
                    'title' => 'Total Income (2023)',
                    'amount' => '3,412,500 FCFA',
                    'change' => '+18.5% vs 2022',
                    'change_color' => 'green',
                    'icon' => 'coins',
                    'icon_color' => 'green'
                ])
                @include('partials.income_card', [
                    'title' => 'Average Monthly',
                    'amount' => '284,375 FCFA',
                    'change' => 'Consistent growth',
                    'change_color' => 'blue',
                    'icon' => 'chart-bar',
                    'icon_color' => 'blue'
                ])
                @include('partials.income_card', [
                    'title' => 'Best Month',
                    'amount' => 'April - 425,000 FCFA',
                    'change' => 'Record high',
                    'change_color' => 'purple',
                    'icon' => 'star',
                    'icon_color' => 'purple'
                ])
            </div>

            <!-- Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Monthly Income Overview</h3>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 bg-indigo-600 text-white rounded-lg text-sm">Year</button>
                        <button class="px-3 py-1 bg-white border border-gray-300 rounded-lg text-sm">Quarter</button>
                        <button class="px-3 py-1 bg-white border border-gray-300 rounded-lg text-sm">Month</button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="incomeChart"></canvas>
                </div>
            </div>

            <!-- Transactions -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Transactions</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @include('partials.transaction_item', [
                        'icon' => 'home',
                        'icon_color' => 'green',
                        'title' => 'Property Sale Commission',
                        'subtitle' => 'Villa in Bastos - #PROP-2023-056',
                        'amount' => '+85,000 FCFA',
                        'date' => '15 Jun 2023'
                    ])
                    @include('partials.transaction_item', [
                        'icon' => 'users',
                        'icon_color' => 'blue',
                        'title' => 'Crowdfunding Fee',
                        'subtitle' => 'Akwa Shopping Center - #CF-2023-012',
                        'amount' => '+42,500 FCFA',
                        'date' => '10 Jun 2023'
                    ])
                    @include('partials.transaction_item', [
                        'icon' => 'handshake',
                        'icon_color' => 'purple',
                        'title' => 'Consultation Service',
                        'subtitle' => 'Real Estate Investment Advice',
                        'amount' => '+25,000 FCFA',
                        'date' => '5 Jun 2023'
                    ])
                </div>
                <div class="px-6 py-4 border-t border-gray-200 text-center">
                    <button class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                        View all transactions
                    </button>
                </div>
            </div>

        </main>
    </div>
</body>
</html>
