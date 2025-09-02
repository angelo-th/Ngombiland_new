<section class="py-16 bg-blue-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @foreach($stats as $stat)
            <div>
                <div class="text-4xl font-bold mb-2">{{ $stat['value'] }}</div>
                <div class="text-blue-200">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
