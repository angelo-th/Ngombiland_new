@extends('layouts.app')

@section('title', 'Propriétés - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Découvrez nos propriétés</h1>
            <p class="text-xl text-gray-600">Trouvez le bien immobilier de vos rêves au Cameroun</p>
        </div>

        <!-- Composant de recherche Livewire -->
        @livewire('property-search')
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('search-updated', () => {
            // Optionnel : ajouter des animations ou des effets lors de la mise à jour
            console.log('Recherche mise à jour');
        });
    });
</script>
@endpush
