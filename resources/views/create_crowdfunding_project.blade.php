{{-- resources/views/create_crowdfunding_project.blade.php --}}
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Create Crowdfunding Project</title>
    {{-- Tailwind & FontAwesome --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    {{-- CSS & JS --}}
    <link rel="stylesheet" href="{{ asset('css/create_crowdfunding_project.css') }}">
    <script src="{{ asset('js/create_crowdfunding_project.js') }}"></script>
</head>
<body class="h-full">
    <div class="min-h-full">
        {{-- Navigation --}}
        <nav class="gradient-bg shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            {{-- Logo --}}
                            <img class="h-8 w-8" src="data:image/svg+xml;base64,PHN2Zy..." alt="NGOMBILAND">
                            <span class="ml-2 text-white font-bold text-xl">NGOMBILAND</span>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                {{-- Change to route() if named routes exist --}}
                                <a href="{{ url('/dashboard') }}" class="text-indigo-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                                <a href="{{ url('/property_search') }}" class="text-indigo-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Properties</a>
                                <a href="{{ url('/marketplace_crowdfunding') }}" class="text-white bg-indigo-500 bg-opacity-75 px-3 py-2 rounded-md text-sm font-medium">Crowdfunding</a>
                                <a href="{{ url('/user_walet') }}" class="text-indigo-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Wallet</a>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        {{-- Notifications --}}
                        <a href="{{ url('/communication') }}">
                            <button class="relative p-2 text-gray-600 hover:text-primary transition-colors">
                                <i class="fas fa-bell text-xl text-white"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center animate-pulse">3</span>
                            </button>
                        </a>
                        {{-- User Profile --}}
                        <div class="relative">
                            <button class="flex items-center text-white space-x-2" onclick="toggleUserMenu()">
                                <img class="h-8 w-8 rounded-full" src="data:image/svg+xml;base64,PHN2Zy..." alt="Avatar">
                                <span class="text-sm font-medium">Angelo Mbiock</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile & Settings</a>
                                <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
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
                        <h1 class="text-3xl font-bold text-gray-900">Create Crowdfunding Project</h1>
                        <p class="text-gray-600 mt-1">Launch a new real estate investment opportunity</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-2">
                            <div class="flex items-center">
                                <a href="{{ url('/user_walet') }}">
                                    <i class="fas fa-wallet text-green-600 mr-2"></i>
                                    <span class="text-sm font-medium text-green-800">Balance: </span>
                                    <span class="text-lg font-bold text-green-600 ml-1">45,750 FCFA</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Form Section --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        {{-- Progress Steps --}}
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            {{-- Same progress bar --}}
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-medium">1</span>
                                    <span class="text-sm font-medium text-gray-700">Project Details</span>
                                </div>
                                <div class="flex-1 border-t-2 border-gray-300 mx-4"></div>
                                <div class="flex items-center space-x-2">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600 font-medium">2</span>
                                    <span class="text-sm font-medium text-gray-500">Financials</span>
                                </div>
                                <div class="flex-1 border-t-2 border-gray-300 mx-4"></div>
                                <div class="flex items-center space-x-2">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600 font-medium">3</span>
                                    <span class="text-sm font-medium text-gray-500">Review</span>
                                </div>
                            </div>
                        </div>

                        {{-- Form --}}
                        <div class="p-6">
                            <form id="crowdfundingForm" method="POST" action="#">
                                @csrf
                                {{-- Project Title --}}
                                <div class="mb-6">
                                    <label for="projectTitle" class="block text-sm font-medium text-gray-700 mb-1">Project Title *</label>
                                    <input type="text" id="projectTitle" name="projectTitle" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. Akwa Luxury Apartments" required>
                                    <p class="mt-1 text-xs text-gray-500">Give your project a clear and attractive name</p>
                                </div>

                                {{-- Project Description --}}
                                <div class="mb-6">
                                    <label for="projectDescription" class="block text-sm font-medium text-gray-700 mb-1">Project Description *</label>
                                    <textarea id="projectDescription" name="projectDescription" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Describe the project in detail..." required></textarea>
                                    <p class="mt-1 text-xs text-gray-500">Include key features, location advantages, and unique selling points</p>
                                </div>

                                {{-- Location --}}
                                <div class="mb-6">
                                    <label for="projectLocation" class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <select id="country" name="country" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                                                <option value="">Country</option>
                                                <option value="Cameroon" selected>Cameroon</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Ghana">Ghana</option>
                                            </select>
                                        </div>
                                        <div>
                                            <select id="city" name="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                                                <option value="">City</option>
                                                <option value="Douala">Douala</option>
                                                <option value="Yaounde">Yaoundé</option>
                                                <option value="Bamenda">Bamenda</option>
                                                <option value="Buea">Buea</option>
                                            </select>
                                        </div>
                                        <div>
                                            <input type="text" id="neighborhood" name="neighborhood" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Neighborhood" required>
                                        </div>
                                    </div>
                                </div>

                                {{-- Project Type --}}
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Project Type *</label>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="projectType" value="residential" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500" checked>
                                            <span class="ml-2 text-sm text-gray-700">Residential</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="projectType" value="commercial" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-700">Commercial</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="projectType" value="mixed" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-700">Mixed Use</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="projectType" value="land" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-700">Land</span>
                                        </label>
                                    </div>
                                </div>

                                {{-- Project Images --}}
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Project Images *</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                        <div class="space-y-1 text-center">
                                            <div class="flex text-sm text-gray-600">
                                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                    <span>Upload files</span>
                                                    <input id="file-upload" name="file-upload" type="file" class="sr-only" multiple>
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                        </div>
                                    </div>
                                    <div id="preview-container" class="mt-3 grid grid-cols-3 gap-2 hidden">
                                        {{-- Image previews --}}
                                    </div>
                                </div>

                                {{-- Timeline --}}
                                <div class="mb-6">
                                    <label for="projectTimeline" class="block text-sm font-medium text-gray-700 mb-1">Project Timeline (months) *</label>
                                    <input type="number" id="projectTimeline" name="projectTimeline" min="3" max="36" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" value="12" required>
                                    <p class="mt-1 text-xs text-gray-500">Estimated duration from funding completion to project delivery</p>
                                </div>

                                {{-- Next Button --}}
                                <div class="mt-8 flex justify-end">
                                    <button type="button" onclick="nextStep()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center">
                                        Next: Financial Details <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Guidance --}}
                <div class="space-y-6">
                    {{-- Tips Card --}}
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-lightbulb text-yellow-500 mr-2"></i> Crowdfunding Tips
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Be clear about the project's goals and benefits</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Use high-quality images to attract investors</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Set realistic funding targets and timelines</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Offer attractive returns to incentivize participation</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Provide regular updates to maintain investor trust</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Requirements Card --}}
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-clipboard-check text-blue-500 mr-2"></i> Requirements
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-start">
                                <i class="fas fa-file-alt text-blue-500 mt-1 mr-2"></i>
                                <span>Valid property title or ownership documents</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-file-alt text-blue-500 mt-1 mr-2"></i>
                                <span>Detailed project plan and budget</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-file-alt text-blue-500 mt-1 mr-2"></i>
                                <span>Professional valuation report (optional but recommended)</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-file-alt text-blue-500 mt-1 mr-2"></i>
                                <span>Government approvals (if applicable)</span>
                            </li>
                        </ul>
                        <div class="mt-4">
                            <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View complete requirements guide</a>
                        </div>
                    </div>

                    {{-- Support Card --}}
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-headset text-purple-500 mr-2"></i> Need Help?
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">Our team is ready to assist you with your crowdfunding campaign setup.</p>
                        <button class="w-full bg-purple-50 hover:bg-purple-100 text-purple-700 font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-comment-dots mr-2"></i> Contact Support
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
