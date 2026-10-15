<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pengaturan->nama_sekolah ?? 'Sekolah Unggulan' }} - @yield('title', 'Beranda')</title>

    <!-- Favicon -->
    @if(isset($pengaturan) && $pengaturan->logo)
        <link rel="icon" type="image/png" href="{{ storage_upload_url($pengaturan->logo) }}">
    @else
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23056ded' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'/%3E%3C/svg%3E">
    @endif
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .topbar-bg { background-color: #1c3faa; }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50 flex flex-col min-h-screen">

    <!-- Sub Header (Blue) -->
    <div class="topbar-bg text-white text-xs py-2 hidden md:block">
        <div class="container mx-auto px-4 lg:px-8 flex justify-between items-center max-w-7xl">
            <div class="flex items-center gap-6">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-phone"></i>
                    {{ $pengaturan->telefon ?? '+62 812 3456 7890' }}
                </span>
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-envelope"></i>
                    {{ $pengaturan->email ?? 'info@sekolahku.sch.id' }}
                </span>
            </div>
            <div class="flex items-center gap-4">
                @if(!empty($pengaturan->facebook))
                <a href="{{ $pengaturan->facebook }}" target="_blank" class="hover:text-blue-200 transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                @endif
                @if(!empty($pengaturan->instagram))
                <a href="{{ $pengaturan->instagram }}" target="_blank" class="hover:text-blue-200 transition-colors"><i class="fa-brands fa-instagram"></i></a>
                @endif
                @if(!empty($pengaturan->youtube))
                <a href="{{ $pengaturan->youtube }}" target="_blank" class="hover:text-blue-200 transition-colors"><i class="fa-brands fa-youtube"></i></a>
                @endif
            </div>
        </div>
    </div>

    <!-- Header / Navbar (White) -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="flex items-center h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    @if(isset($pengaturan->logo) && $pengaturan->logo)
                        <img src="{{ storage_upload_url($pengaturan->logo) }}" alt="Logo" class="h-12 w-auto object-contain">
                    @else
                        <div class="h-12 w-12 bg-gradient-to-br from-blue-600 to-indigo-600 text-white rounded-xl flex items-center justify-center font-bold text-2xl shadow-md">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="font-extrabold text-xl text-gray-900 leading-tight tracking-tight">{{ $pengaturan->nama_sekolah ?? 'Sekolah Unggulan' }}</h1>
                        <p class="text-[11px] text-blue-600 font-semibold tracking-wider uppercase hidden sm:block">Generasi Cerdas & Berkarakter</p>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex gap-2 items-center font-medium text-sm text-gray-600 mx-auto">
                    <a href="{{ route('home') }}" class="px-4 py-2.5 rounded-full transition-all duration-300 {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'hover:bg-gray-50 hover:text-blue-600' }}">Beranda</a>
                    <a href="{{ route('frontend.berita') }}" class="px-4 py-2.5 rounded-full transition-all duration-300 {{ request()->routeIs('frontend.berita*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'hover:bg-gray-50 hover:text-blue-600' }}">Berita</a>
                    
                    @if(isset($menus))
                        @foreach($menus as $menu)
                            @if($menu->subMenus->count() > 0)
                                <div class="relative group">
                                    <button class="flex items-center gap-1.5 px-4 py-2.5 rounded-full hover:bg-gray-50 hover:text-blue-600 transition-all duration-300">
                                        {{ $menu->nama_menu }}
                                        <i class="fa-solid fa-chevron-down text-[10px] opacity-70"></i>
                                    </button>
                                    <div class="absolute top-full left-0 mt-2 bg-white shadow-xl rounded-xl border border-gray-100 py-3 min-w-[220px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">
                                        @foreach($menu->subMenus as $sub)
                                            <a href="{{ Str::startsWith($sub->link, ['http://', 'https://']) ? $sub->link : url($sub->link) }}" 
                                               class="block px-5 py-2.5 hover:bg-blue-50 hover:text-blue-700 transition-colors mx-2 rounded-lg text-sm">
                                                {{ $sub->nama_menu }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ Str::startsWith($menu->link, ['http://', 'https://']) ? $menu->link : url($menu->link) }}" class="px-4 py-2.5 rounded-full hover:bg-gray-50 hover:text-blue-600 transition-all duration-300">
                                    {{ $menu->nama_menu }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                    
                    <a href="{{ route('frontend.prestasi') }}" class="px-4 py-2.5 rounded-full transition-all duration-300 {{ request()->routeIs('frontend.prestasi*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'hover:bg-gray-50 hover:text-blue-600' }}">Prestasi</a>
                    <a href="{{ route('frontend.ekstrakurikuler') }}" class="px-4 py-2.5 rounded-full transition-all duration-300 {{ request()->routeIs('frontend.ekstrakurikuler*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'hover:bg-gray-50 hover:text-blue-600' }}">Ekstrakurikuler</a>
                    <a href="{{ route('frontend.sarpras') }}" class="px-4 py-2.5 rounded-full transition-all duration-300 {{ request()->routeIs('frontend.sarpras*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'hover:bg-gray-50 hover:text-blue-600' }}">Fasilitas</a>
                    <a href="{{ route('frontend.alumni') }}" class="px-4 py-2.5 rounded-full transition-all duration-300 {{ request()->routeIs('frontend.alumni*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'hover:bg-gray-50 hover:text-blue-600' }}">Alumni</a>
                    <a href="{{ route('frontend.guru') }}" class="px-4 py-2.5 rounded-full transition-all duration-300 {{ request()->routeIs('frontend.guru*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'hover:bg-gray-50 hover:text-blue-600' }}">Direktori Guru</a>
                </nav>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-600 hover:text-blue-600 focus:outline-none ml-auto">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Modern Footer -->
    <footer class="bg-gradient-to-b from-blue-950 to-gray-950 text-gray-300 pt-20 pb-8 mt-auto relative overflow-hidden">
        <!-- Decorative Background -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-600/10 rounded-full filter blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-indigo-600/10 rounded-full filter blur-[100px] pointer-events-none"></div>

        <div class="container mx-auto px-4 lg:px-8 max-w-7xl relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Branding & Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="bg-white p-2 rounded-xl shadow-lg inline-block">
                            @if(isset($pengaturan) && $pengaturan->logo)
                                <img src="{{ storage_upload_url($pengaturan->logo) }}" alt="Logo" class="h-12 w-auto object-contain">
                            @else
                                <div class="w-12 h-12 flex items-center justify-center bg-blue-50 rounded-lg">
                                    <i class="fa-solid fa-graduation-cap text-2xl text-blue-600"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-2xl font-black text-white leading-tight">{{ $pengaturan->nama_sekolah ?? 'Sekolah Unggulan' }}</h2>
                            <p class="text-blue-400 text-sm font-bold tracking-wider uppercase">Generasi Cerdas & Berkarakter</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-8 max-w-md">
                        {{ isset($pengaturan) && $pengaturan->sambutan_kepala_sekolah ? Str::limit(strip_tags($pengaturan->sambutan_kepala_sekolah), 160) : 'Kami berkomitmen untuk menyediakan lingkungan pendidikan terbaik yang memadukan keunggulan akademik, pengembangan karakter moral, dan penguasaan teknologi modern untuk mencetak pemimpin masa depan.' }}
                    </p>
                    
                    <!-- Social Links -->
                    <div class="flex gap-3">
                        <a href="{{ $pengaturan->facebook ?? '#' }}" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-blue-600 hover:border-blue-600 transition-all text-gray-300 hover:text-white group">
                            <i class="fa-brands fa-facebook-f group-hover:scale-110 transition-transform"></i>
                        </a>
                        <a href="{{ $pengaturan->instagram ?? '#' }}" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-pink-600 hover:border-pink-600 transition-all text-gray-300 hover:text-white group">
                            <i class="fa-brands fa-instagram group-hover:scale-110 transition-transform"></i>
                        </a>
                        <a href="{{ $pengaturan->youtube ?? '#' }}" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-red-600 hover:border-red-600 transition-all text-gray-300 hover:text-white group">
                            <i class="fa-brands fa-youtube group-hover:scale-110 transition-transform"></i>
                        </a>
                        <a href="{{ $pengaturan->tiktok ?? '#' }}" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-gray-800 hover:border-gray-800 transition-all text-gray-300 hover:text-white group">
                            <i class="fa-brands fa-tiktok group-hover:scale-110 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <!-- Tautan Cepat -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-6 relative inline-block">
                        Menu Utama
                        <span class="absolute -bottom-2 left-0 w-12 h-1 bg-blue-500 rounded-full"></span>
                    </h3>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all flex items-center gap-2 inline-block"><i class="fa-solid fa-chevron-right text-[10px] text-blue-500"></i> Beranda Utama</a></li>
                        <li><a href="{{ route('frontend.berita') }}" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all flex items-center gap-2 inline-block"><i class="fa-solid fa-chevron-right text-[10px] text-blue-500"></i> Portal Berita</a></li>
                        <li><a href="{{ route('frontend.prestasi') }}" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all flex items-center gap-2 inline-block"><i class="fa-solid fa-chevron-right text-[10px] text-blue-500"></i> Galeri Prestasi</a></li>
                        <li><a href="{{ route('frontend.alumni') }}" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all flex items-center gap-2 inline-block"><i class="fa-solid fa-chevron-right text-[10px] text-blue-500"></i> Cerita Alumni</a></li>
                        <li><a href="{{ route('frontend.guru') }}" class="text-gray-400 hover:text-white hover:translate-x-1 transition-all flex items-center gap-2 inline-block"><i class="fa-solid fa-chevron-right text-[10px] text-blue-500"></i> Direktori Staf</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-6 relative inline-block">
                        Hubungi Kami
                        <span class="absolute -bottom-2 left-0 w-12 h-1 bg-blue-500 rounded-full"></span>
                    </h3>
                    <ul class="space-y-5 text-sm text-gray-400">
                        <li class="flex items-start gap-3 group">
                            <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 transition-colors">
                                <i class="fa-solid fa-map-location-dot text-blue-400 group-hover:text-white"></i>
                            </div>
                            <span class="leading-relaxed mt-1">{{ isset($pengaturan) && $pengaturan->alamat ? $pengaturan->alamat : 'Jl. Pendidikan No. 1, Kota Inovasi, Provinsi Pengetahuan, Indonesia 12345' }}</span>
                        </li>
                        <li class="flex items-center gap-3 group">
                            <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 transition-colors">
                                <i class="fa-solid fa-phone-volume text-blue-400 group-hover:text-white"></i>
                            </div>
                            <span class="font-medium">{{ isset($pengaturan) && $pengaturan->telefon ? $pengaturan->telefon : '+62 812 3456 7890' }}</span>
                        </li>
                        <li class="flex items-center gap-3 group">
                            <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 transition-colors">
                                <i class="fa-solid fa-envelope-open-text text-blue-400 group-hover:text-white"></i>
                            </div>
                            <span class="font-medium">{{ isset($pengaturan) && $pengaturan->email ? $pengaturan->email : 'info@sekolahunggulan.sch.id' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500 font-medium">
                <p>&copy; {{ date('Y') }} <span class="text-gray-300">{{ $pengaturan->nama_sekolah ?? 'Sekolah Unggulan' }}</span>. Hak Cipta Dilindungi.</p>
                <div class="flex items-center gap-2 bg-white/5 px-4 py-2 rounded-full">
                    <p>Dikembangkan dengan <i class="fa-solid fa-heart text-red-500 animate-pulse"></i> oleh <span class="text-blue-400">Tim IT Sekolah</span></p>
                </div>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
