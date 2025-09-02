<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Ce que disent nos utilisateurs</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
                @include('partials.testimonial_item', ['testimonial' => $testimonial])
            @endforeach
        </div>
    </div>
</section>
