<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Crowdfunding Project Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/project_management.css') }}">
    <script src="{{ asset('js/project_management.js') }}"></script>
</head>
<body class="bg-gradient-to-br from-emerald-50 to-teal-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg border-b-4 border-emerald-500">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="bg-emerald-500 text-white p-2 rounded-lg">
                        <i class="fas fa-building text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">NGOMBILAND</h1>
                    <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">Owner</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i class="fas fa-bell text-gray-600 text-xl cursor-pointer"></i>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $notificationsCount ?? 0 }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <img src="{{ auth()->user()->avatar ?? 'https://via.placeholder.com/40' }}" alt="Avatar" class="w-10 h-10 rounded-full">
                        <span class="font-medium">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-6" x-data="projectManagement()">
        <!-- Navigation Tabs -->
        <div class="mb-6">
            <div class="flex space-x-1 bg-white rounded-lg p-1 shadow-md">
                @php
                    $tabs = [
                        'dashboard' => 'Dashboard',
                        'create' => 'Create Project',
                        'projects' => 'My Projects',
                        'communication' => 'Communication',
                        'reports' => 'Reports'
                    ];
                @endphp
                @foreach($tabs as $key => $label)
                    <button @click="activeTab = '{{ $key }}'" 
                            :class="activeTab === '{{ $key }}' ? 'bg-emerald-500 text-white' : 'text-gray-600 hover:bg-gray-100'"
                            class="px-6 py-3 rounded-md font-medium transition-all duration-200">
                        @if($key == 'dashboard') <i class="fas fa-chart-line mr-2"></i>@endif
                        @if($key == 'create') <i class="fas fa-plus mr-2"></i>@endif
                        @if($key == 'projects') <i class="fas fa-list mr-2"></i>@endif
                        @if($key == 'communication') <i class="fas fa-comments mr-2"></i>@endif
                        @if($key == 'reports') <i class="fas fa-chart-bar mr-2"></i>@endif
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Dashboard Tab -->
        <div x-show="activeTab === 'dashboard'" x-transition>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Example Stats -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-emerald-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Active Projects</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $projects->count() }}</p>
                        </div>
                        <div class="bg-emerald-100 p-3 rounded-full">
                            <i class="fas fa-building text-emerald-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Raised</p>
                            <p class="text-3xl font-bold text-gray-900">{{ number_format($totalRaised) }}</p>
                            <p class="text-sm text-gray-500">FCFA</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-coins text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Investors</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $investorsCount }}</p>
                        </div>
                        <div class="bg-orange-100 p-3 rounded-full">
                            <i class="fas fa-users text-orange-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Average ROI</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $averageROI }}%</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-percentage text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Fundraising Progress</h3>
                    <canvas id="fundraisingChart" class="w-full h-64"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Project Distribution</h3>
                    <canvas id="projectChart" class="w-full h-64"></canvas>
                </div>
            </div>

            <!-- Recent Projects Table -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Projects</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-medium text-gray-600">Project</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600">Goal</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600">Raised</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600">Progress</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600">Status</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-4 px-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $project->image ?? 'https://via.placeholder.com/50' }}" alt="Project" class="w-12 h-12 rounded-lg object-cover">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $project->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $project->location }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-medium">{{ number_format($project->goal) }} FCFA</td>
                                <td class="py-4 px-4 font-medium text-emerald-600">{{ number_format($project->raised) }} FCFA</td>
                                <td class="py-4 px-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $project->progress }}%"></div>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">{{ $project->progress }}%</p>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="bg-{{ $project->status_color }}-100 text-{{ $project->status_color }}-800 px-3 py-1 rounded-full text-sm font-medium">{{ $project->status }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <a href="{{ route('projects.show', $project) }}" class="text-emerald-600 hover:text-emerald-800 mr-2"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('projects.edit', $project) }}" class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create Project Tab -->
        <div x-show="activeTab === 'create'" x-transition>
            @include('partials.project_create_form')
        </div>

        <!-- My Projects Tab -->
        <div x-show="activeTab === 'projects'" x-transition>
            @include('partials.project_list')
        </div>

        <!-- Communication Tab -->
        <div x-show="activeTab === 'communication'" x-transition>
            @include('partials.project_communication')
        </div>
    </div>

    <script>
        function projectManagement() {
            return {
                activeTab: 'dashboard'
            }
        }
    </script>
</body>
</html>
