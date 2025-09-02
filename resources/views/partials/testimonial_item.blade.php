<div class="bg-gray-50 p-6 rounded-lg">
    <div class="flex items-center mb-4">
        <img src="{{ $testimonial['image'] }}" alt="." class="w-12 h-12 rounded-full mr-4">
        <div>
            <h4 class="font-bold">{{ $testimonial['name'] }}</h4>
            <p class="text-yellow-500">
                @for($i = 0; $i < $testimonial['stars']; $i++)
                    <i class="fas fa-star"></i>
                @endfor
                @if($testimonial['half_star'])
                    <i class="fas fa-star-half-alt"></i>
                @endif
            </p>
        </div>
    </div>
    <p class="text-gray-600">{{ $testimonial['message'] }}</p>
</div>
