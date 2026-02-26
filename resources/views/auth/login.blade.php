<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NUSTECH</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #1a365d 50%, #164e63 75%, #0f172a 100%);
            background-size: 400% 400%;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 font-sans overflow-hidden">
    <!-- Animated background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
        <div class="absolute top-40 right-20 w-80 h-80 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
    </div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Card Container -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl shadow-2xl p-8 sm:p-10 transition-all duration-500 hover:border-white/20 hover:bg-white/8">
            
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-linear-to-br from-cyan-400 via-blue-500 to-indigo-600 rounded-2xl mb-6 shadow-xl animate-float">
                    <i class="fas fa-lock text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold mb-3 text-white tracking-tight">Welcome Back</h1>
                <p class="text-slate-300 text-sm sm:text-base">Sign in to access your account</p>
            </div>

            <!-- Error Message -->
            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/30 text-red-300 p-4 rounded-xl mb-6 text-sm backdrop-blur-sm flex items-start gap-3 animate-pulse">
                    <i class="fas fa-circle-exclamation mt-1 flex-shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Email Field -->
                <div class="group">
                    <label class="flex items-center text-slate-200 text-sm font-semibold mb-3 transition-colors group-focus-within:text-cyan-400">
                        <i class="fas fa-envelope mr-3 text-cyan-400 text-lg"></i>Email Address
                    </label>
                    <input type="email" name="email" 
                        class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:bg-white/10 focus:border-cyan-500/50 transition-all duration-300" 
                        placeholder="your@email.com" 
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required>
                </div>

                <!-- Password Field -->
                <div class="group">
                    <label class="flex items-center text-slate-200 text-sm font-semibold mb-3 transition-colors group-focus-within:text-cyan-400">
                        <i class="fas fa-lock mr-3 text-cyan-400 text-lg"></i>Password
                    </label>
                    <input type="password" name="password" 
                        class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:bg-white/10 focus:border-cyan-500/50 transition-all duration-300" 
                        placeholder="••••••••" 
                        autocomplete="current-password"
                        required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full mt-8 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:shadow-lg hover:shadow-cyan-500/30 flex items-center justify-center gap-2 group shadow-lg">
                    <i class="fas fa-sign-in-alt group-hover:translate-x-1 transition-transform"></i>
                    <span>Sign In</span>
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-white/5 text-center">
                <p class="text-slate-400 text-xs sm:text-sm">© 2024 NUSTECH. All rights reserved.</p>
            </div>
        </div>

        <!-- Decorative bottom element -->
        <div class="mt-6 text-center">
            <p class="text-slate-500 text-xs">Secure authentication powered by NUSTECH</p>
        </div>
    </div>
</body>
</html>