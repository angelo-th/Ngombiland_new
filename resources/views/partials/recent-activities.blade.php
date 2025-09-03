<section class="bg-white shadow rounded-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activities</h3>

    @if(isset($recentActivities) && count($recentActivities) > 0)
        <div class="space-y-4">
            @foreach($recentActivities as $activity)
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                            <i class="fas {{ $activity['icon'] ?? 'fa-bell' }} text-indigo-600"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">
                            {{ $activity['description'] }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $activity['time'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 text-sm">No recent activities to display.</p>
    @endif
</section>
