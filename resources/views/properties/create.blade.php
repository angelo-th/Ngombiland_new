@extends('layouts.app')

@section('title', 'Créer une Propriété - NGOMBILAND')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Créer une Propriété</h1>
                    <p class="text-gray-600">Ajoutez une nouvelle propriété à votre portefeuille</p>
                </div>
                <a href="{{ route('properties.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Wizard de création -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Étapes -->
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white font-medium">1</span>
                        <span class="text-sm font-medium text-gray-700">Informations de base</span>
                    </div>
                    <div class="flex-1 border-t-2 border-gray-300 mx-4"></div>
                    <div class="flex items-center space-x-2">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600 font-medium">2</span>
                        <span class="text-sm font-medium text-gray-500">Options crowdfunding</span>
                    </div>
                    <div class="flex-1 border-t-2 border-gray-300 mx-4"></div>
                    <div class="flex items-center space-x-2">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600 font-medium">3</span>
                        <span class="text-sm font-medium text-gray-500">Images et documents</span>
                    </div>
                    <div class="flex-1 border-t-2 border-gray-300 mx-4"></div>
                    <div class="flex items-center space-x-2">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600 font-medium">4</span>
                        <span class="text-sm font-medium text-gray-500">Validation</span>
                    </div>
                </div>
            </div>

            <!-- Contenu du wizard -->
            <div class="p-6">
                @livewire('property-wizard')
            </div>
        </div>
    </div>
</div>
@endsection