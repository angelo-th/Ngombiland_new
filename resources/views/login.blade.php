{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOMBILAND - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="{{ asset('js/login.js') }}" defer></script>
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-gray-900">
    
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 rounded-full bg-gradient-to-br from-yellow-400 to-orange-400 opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-gradient-to-br from-green-400 to-blue-400 opacity-20 animate-pulse delay-1000"></div>
    </div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8 animate-float">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/20 backdrop-blur-md mb-3">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white mb-1">NGOMBILAND</h1>
            <p class="text-white/80 text-sm">Collaborative real estate in Cameroon</p>
        </div>

        <!-- Login Form -->
        <div class="glass-card rounded-xl p-6">
            <div class="mb-5">
                <h2 class="text-xl font-semibold text-white mb-1">Welcome back</h2>
                <p class="text-white/70 text-sm">Sign in to your account</p>
            </div>

            {{-- Use Laravel route and CSRF protection --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-white/80 text-xs font-medium mb-1">Email</label>
                    <div class="relative">
                        <input 
                            type="email" 
                            name="email"
                            value="{{ old('email') }}"
                            class="input-field w-full px-3 py-2.5 rounded-lg text-white placeholder-white/50 text-sm focus:outline-none @error('email') border-red-500 @enderror"
                            placeholder="votre@email.com"
                            required
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-white/70" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-white/80 text-xs font-medium mb-1">Password</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password"
                            class="input-field w-full px-3 py-2.5 rounded-lg text-white placeholder-white/50 text-sm focus:outline-none @error('password') border-red-500 @enderror"
                            placeholder="••••••••"
                            required
                        >
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword()">
                            <svg class="w-4 h-4 text-white/70" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-3.5 h-3.5 text-green-500 border-white/30 rounded focus:ring-green-500">
                        <span class="ml-2 text-xs text-white/70">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-xs text-green-400 hover:text-green-300 transition-colors">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="primary-btn w-full py-2.5 px-4 rounded-lg text-white font-medium text-sm">
                    Sign in
                </button>
                <!-- Divider -->
                <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/20"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-transparent text-white/70">or continue with</span>
                    </div>
                </div>

                <!-- Quick Mobile Money Buttons -->
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" class="flex items-center justify-center py-2 px-3 rounded-lg glass-effect mobile-money-btn hover:bg-white/20">
                        <div class="w-5 h-5 bg-yellow-500 rounded mr-1.5 flex items-center justify-center">
                            <span class="text-[10px] font-bold text-black">MTN</span>
                        </div>
                        <span class="text-white text-xs">MTN MoMo</span>
                    </button>
                    <button type="button" class="flex items-center justify-center py-2 px-3 rounded-lg glass-effect mobile-money-btn hover:bg-white/20">
                        <div class="w-5 h-5 bg-orange-500 rounded mr-1.5 flex items-center justify-center">
                            <span class="text-[10px] font-bold text-white">OM</span>
                        </div>
                        <span class="text-white text-xs">Orange Money</span>
                    </button>
                </div>
            </form>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-white/60 text-xs">
                    New to NGOMBILAND? 
                    <a href="{{ route('register') }}" class="text-green-400 hover:text-green-300 font-medium ml-1">Create account</a>
                </p>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="mt-6 grid grid-cols-3 gap-3 text-center">
            <div class="glass-card rounded-lg p-2">
                <div class="text-green-400 font-semibold text-sm">150+</div>
                <div class="text-white/60 text-[10px]">Properties</div>
            </div>
            <div class="glass-card rounded-lg p-2">
                <div class="text-yellow-400 font-semibold text-sm">25M+</div>
                <div class="text-white/60 text-[10px]">FCFA invested</div>
            </div>
            <div class="glass-card rounded-lg p-2">
                <div class="text-blue-400 font-semibold text-sm">500+</div>
                <div class="text-white/60 text-[10px]">Investors</div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.querySelector('input[name="password"]');
            const toggleButton = document.querySelector('button[onclick="togglePassword()"]');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.innerHTML = `
                    <svg class="w-4 h-4 text-white/70" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"/>
                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>
                    </svg>
                `;
            } else {
                passwordInput.type = 'password';
                toggleButton.innerHTML = `
                    <svg class="w-4 h-4 text-white/70" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                `;
            }
        }

        // Afficher les erreurs de validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const emailInput = document.querySelector('input[name="email"]');
            const passwordInput = document.querySelector('input[name="password"]');

            // Ajouter des classes d'erreur si nécessaire
            if (emailInput.classList.contains('border-red-500')) {
                emailInput.classList.add('border-red-500');
            }
            if (passwordInput.classList.contains('border-red-500')) {
                passwordInput.classList.add('border-red-500');
            }
        });
    </script>
</body>
</html>
