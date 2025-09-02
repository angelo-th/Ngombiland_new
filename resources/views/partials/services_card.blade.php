<div class="service-card bg-white p-8 rounded-lg shadow-md transition duration-300">
    <div class="text-blue-800 mb-4">
        <i class="{{ $service['icon'] }} text-4xl"></i>
    </div>
    <h3 class="text-xl font-bold mb-3 text-gray-800">{{ $service['title'] }}</h3>
    <p class="text-gray-600 mb-4">{{ $service['description'] }}</p>
    <ul class="text-gray-600 space-y-2">
        @foreach($service['features'] as $feature)
            <li class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-2"></i> {{ $feature }}
            </li>
        @endforeach
    </ul>
</div>
