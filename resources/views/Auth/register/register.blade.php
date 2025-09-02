<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-gray-900">

<div class="relative w-full max-w-md">
    <!-- Steps container -->
    <form id="registrationForm" method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf
        @include('auth.register.step1')
        @include('auth.register.step2')
        @include('auth.register.step3')
        @include('auth.register.step4')
    </form>
</div>

<script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
