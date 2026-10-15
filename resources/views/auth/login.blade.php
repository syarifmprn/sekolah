<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $pengaturan = \App\Models\PengaturanWebsite::first();
        @endphp
        <title>{{ $pengaturan->nama_sekolah ?? 'Sekolah Unggulan' }} - Login</title>

        <!-- Favicon -->
        @if(isset($pengaturan) && $pengaturan->logo)
            <link rel="icon" type="image/png" href="{{ asset('storage/uploads/' . $pengaturan->logo) }}">
        @else
            <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23056ded' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'/%3E%3C/svg%3E">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .sidebar-bg { background-color: #1c3faa; }
            .content-bg { background-color: #f4f7fd; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 h-full overflow-hidden flex">
        
        <!-- Left Side: Banner / Info -->
        <div class="hidden lg:flex lg:w-1/2 sidebar-bg text-white relative overflow-hidden flex-col">
            
            <!-- Pattern Overlay (Dots) -->
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
            
            <!-- Glow Effects -->
            <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-blue-400 opacity-20 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-[-10%] right-[-20%] w-[600px] h-[600px] bg-blue-300 opacity-20 rounded-full blur-[120px]"></div>
            
            <!-- Main Content Container -->
            <div class="relative z-10 flex flex-col h-full w-full max-w-2xl mx-auto px-12 py-16">
                
                <!-- Brand (Top) -->
                <div class="flex items-center gap-4 mb-auto">
                    <div class="bg-white/10 p-3.5 rounded-2xl backdrop-blur-sm border border-white/20 shadow-lg flex items-center justify-center">
                        @if(isset($pengaturan) && $pengaturan->logo)
                            <img src="{{ asset('storage/uploads/' . $pengaturan->logo) }}" alt="Logo" class="w-8 h-8 object-contain">
                        @else
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        @endif
                    </div>
                    <div>
                        <span class="text-2xl font-bold tracking-wider block">{{ $pengaturan->nama_sekolah ?? 'Sekolah Unggulan' }}</span>
                        <span class="text-sm text-blue-200">Sistem Informasi Manajemen</span>
                    </div>
                </div>
                
                <!-- Center Content -->
                <div class="mt-12 mb-16">
                    <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight mb-6 leading-tight">
                        Kelola Sekolah<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">Lebih Mudah & Cerdas</span>
                    </h1>
                    <p class="text-lg text-blue-100 max-w-md leading-relaxed mb-10">
                        Sistem administrasi digital yang dirancang untuk mempercepat alur kerja dan meningkatkan transparansi akademik.
                    </p>

                    <!-- Feature List -->
                    <ul class="space-y-5">
                        <li class="flex items-start gap-4 text-blue-50">
                            <div class="bg-blue-500/30 p-1.5 rounded-full mt-0.5"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                            <span class="text-base font-medium">Manajemen Data Berita & Pengumuman</span>
                        </li>
                        <li class="flex items-start gap-4 text-blue-50">
                            <div class="bg-blue-500/30 p-1.5 rounded-full mt-0.5"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                            <span class="text-base font-medium">Pengelolaan Direktori Guru & Staf</span>
                        </li>
                        <li class="flex items-start gap-4 text-blue-50">
                            <div class="bg-blue-500/30 p-1.5 rounded-full mt-0.5"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                            <span class="text-base font-medium">Statistik & Laporan Real-time</span>
                        </li>
                    </ul>
                </div>

                <!-- Bottom Floating Widget -->
                <div class="mt-auto">
                    <div class="inline-flex bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-2xl shadow-xl items-center gap-5 relative group cursor-default transition-all hover:bg-white/20">
                        <div class="absolute -top-2 -right-2">
                            <span class="flex h-4 w-4 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-4 w-4 bg-green-500 border-2 border-[#1c3faa]"></span>
                            </span>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-blue-100 font-medium mb-0.5">Status Server</p>
                            <p class="text-lg font-bold text-white leading-none">Sistem 100% Aktif</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center content-bg p-8">
            <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                
                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-2xl font-bold text-gray-800">Selamat Datang 👋</h2>
                    <p class="text-sm text-gray-500 mt-2">Silakan masukkan email dan kata sandi Anda untuk masuk ke panel admin.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Alamat Email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#1c3faa] focus:ring-2 focus:ring-blue-200 transition-colors bg-gray-50 text-sm">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Kata Sandi') }}</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#1c3faa] focus:ring-2 focus:ring-blue-200 transition-colors bg-gray-50 text-sm pr-12">
                            
                            <!-- Toggle Password Eye Icon -->
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-slash-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-8">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#1c3faa] shadow-sm focus:ring-[#1c3faa]" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-[#1c3faa] hover:underline font-semibold" href="{{ route('password.request') }}">
                                {{ __('Lupa Password?') }}
                            </a>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white sidebar-bg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1c3faa] transition-colors">
                            {{ __('Log In') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const eyeIcon = document.getElementById('eye-icon');
                const eyeSlashIcon = document.getElementById('eye-slash-icon');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.add('hidden');
                    eyeSlashIcon.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('hidden');
                }
            }
        </script>
    </body>
</html>
