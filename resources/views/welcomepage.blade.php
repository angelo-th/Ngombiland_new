@extends('layouts.app')

@section('title', 'NGOMBILAND - Plateforme Immobilière Innovante')

@section('content')
    {{-- Hero Section --}}
    <div class="hero-bg text-white py-20 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">NGOMBILAND</h1>
        <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">La première plateforme immobilière intelligente du Cameroun, alliant marketplace classique et crowdfunding innovant</p>
        <a href="/dashboard" class="btn-primary inline-block bg-yellow-500 text-white px-8 py-4 rounded-full text-lg font-bold shadow-lg">WELCOME</a>
    </div>

    {{-- Services Section --}}
    @include('partials.services', ['services' => $services])

    {{-- Stats Section --}}
    @include('partials.stats', ['stats' => $stats])

    {{-- Testimonials --}}
    @include('partials.testimonials', ['testimonials' => $testimonials])

    {{-- CTA Section --}}
    @include('partials.cta')
@endsection
