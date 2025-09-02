@extends('layouts.dashboard') {{-- Utilise le layout dashboard existant --}}

@section('title', 'Published Properties')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/publish_properties.css') }}">
@endsection

@section('content')
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Published Properties</h1>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('properties.add') }}">
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                            <i class="fas fa-plus mr-2"></i>Add Property
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @include('properties.partials.filters') {{-- Filtre séparé --}}
        @include('properties.partials.list') {{-- Liste des propriétés --}}
        @include('properties.partials.pagination') {{-- Pagination --}}
    </main>
@endsection

@section('scripts')
<script src="{{ asset('js/publish_properties.js') }}"></script>
@endsection
