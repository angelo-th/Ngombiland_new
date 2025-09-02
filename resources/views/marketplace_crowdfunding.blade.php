<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Investment Marketplace</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AlpineJS -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/marketplace_crowdfunding.css') }}">

    <!-- Custom JS -->
    <script src="{{ asset('js/marketplace_crowdfunding.js') }}" defer></script>
</head>
<body class="h-full" x-data="crowdfundingApp()">

    <!-- Header -->
    @include('partials.header')

    <!-- Hero Section -->
    @include('partials.hero')

    <!-- Filters and Search -->
    @include('partials.filters')

    <!-- Projects List -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Available Investment Opportunities</h2>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">Sort by:</span>
                <select class="bg-gray-50 border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                    <option>Most Popular</option>
                    <option>Highest ROI</option>
                    <option>Newest</option>
                    <option>Ending Soon</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <template x-for="project in filteredProjects" :key="project.id">
                <div class="bg-white rounded-xl shadow-card overflow-hidden hover:shadow-card-hover transition-all duration-300 cursor-pointer group" @click="openProjectModal(project)">
                    @include('partials.project_card')
                </div>
            </template>
        </div>

        <!-- Empty state -->
        @include('partials.empty_state')

        <!-- Pagination -->
        @include('partials.pagination')
    </main>

    <!-- Project Detail Modal -->
    @include('partials.project_modal')

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>
