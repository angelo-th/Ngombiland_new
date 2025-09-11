@extends('layouts.app')

@section('title', 'Crowdfunding - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                Projets de Crowdfunding
            </h1>
            <p class="text-lg text-gray-600">
                Investissez dans des projets immobiliers et générez des revenus passifs
            </p>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="relative">
                    @if($project->images && count($project->images) > 0)
                        <img src="{{ asset('storage/' . $project->images[0]) }}" 
                             alt="{{ $project->title }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4">
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $project->expected_roi ?? 10 }}% ROI
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $project->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($project->description, 100) }}</p>

                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Prix total:</span>
                            <span class="text-sm font-medium">{{ number_format($project->price) }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Localisation:</span>
                            <span class="text-sm font-medium">{{ $project->location }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Type:</span>
                            <span class="text-sm font-medium capitalize">{{ $project->type }}</span>
                        </div>
                    </div>

                    <!-- Investment Form -->
                    <form action="{{ route('crowdfunding.invest', $project) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label for="amount_{{ $project->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                Montant d'investissement (FCFA)
                            </label>
                            <input type="number" 
                                   id="amount_{{ $project->id }}" 
                                   name="amount" 
                                   min="1000" 
                                   step="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                        </div>
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            Investir
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun projet disponible</h3>
                <p class="text-gray-600">Il n'y a actuellement aucun projet de crowdfunding disponible.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
