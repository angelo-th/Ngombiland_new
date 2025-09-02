<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($properties as $property)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
            <div class="relative">
                <img src="{{ $property->image_url }}" alt="Property" class="w-full h-48 object-cover">
                
                @if($property->status === 'active')
                    <div class="absolute top-2 right-2 bg-indigo-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        Active
                    </div>
                @elseif($property->status === 'pending')
                    <div class="absolute top-2 right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                        Pending
                    </div>
                @elseif($property->status === 'sold')
                    <div class="absolute top-2 right-2 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        Sold
                    </div>
                @endif
            </div>

            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $property->title }}</h3>
                        <p class="text-gray-600 flex items-center mt-1">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>{{ $property->location }}
                        </p>
                    </div>
                    <span class="bg-green-100 text-green-800 text-sm font-medium px-2 py-1 rounded">
                        {{ number_format($property->price) }} FCFA
                    </span>
                </div>

                <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                    <div>
                        <p class="text-gray-500 text-sm">Bedrooms</p>
                        <p class="font-medium">{{ $property->bedrooms }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Bathrooms</p>
                        <p class="font-medium">{{ $property->bathrooms }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Area</p>
                        <p class="font-medium">{{ $property->area }} m²</p>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between">
                    <span class="text-sm text-gray-500">Published: {{ $property->published_at->format('d/m/Y') }}</span>
                    <div class="flex space-x-2">
                        <a href="{{ route('properties.edit', $property->id) }}" class="text-indigo-600 hover:text-indigo-800">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('properties.delete', $property->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @if($properties->isEmpty())
        <p class="col-span-full text-center text-gray-500">No properties found.</p>
    @endif
</div>
