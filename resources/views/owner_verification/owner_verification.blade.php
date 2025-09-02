{{-- resources/views/owner_verification/owner_verification.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Verification - NGOMBILAND</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Lucide icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/propritory_verification.css') }}">

    {{-- Custom JS --}}
    <script src="{{ asset('js/propritory_verification.js') }}" defer></script>
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- Header --}}
    <header class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <button onclick="goBack()" class="p-2 hover:bg-white/10 rounded-full transition">
                    <i data-lucide="arrow-left" class="w-6 h-6"></i>
                </button>
                <h1 class="text-2xl font-bold">Owner Verification</h1>
            </div>
            <div class="text-sm">
                Step <span id="currentStep">1</span> of 4
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-6">
        {{-- Progress Bar --}}
        @include('owner_verification.progress_bar')

        {{-- Steps --}}
        <div id="stepsContainer">
            @include('owner_verification.step1')
            @include('owner_verification.step2')
            @include('owner_verification.step3')
            @include('owner_verification.step4')
            @include('owner_verification.success')
        </div>
    </div>

</body>
</html>
