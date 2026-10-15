@extends('layouts.frontend')
@section('title', 'Beranda')

@section('content')

    <!-- Hero Slider Section -->
    <section class="relative min-h-[580px] sm:min-h-[640px] lg:h-[700px] bg-gray-900 overflow-hidden flex items-center">
        @if(isset($pengaturan->slider_hero) && is_array($pengaturan->slider_hero) && count($pengaturan->slider_hero) > 0)
            <div id="hero-slider" class="w-full h-full relative absolute inset-0">
                @foreach($pengaturan->slider_hero as $index => $slider)
                    <div class="absolute inset-0 transition-opacity duration-1000 slider-slide {{ $index == 0 ? 'opacity-100' : 'opacity-0' }}">
                        <img src="{{ storage_upload_url($slider) }}" alt="Slider {{ $index+1 }}" class="w-full h-full object-cover">
                        <!-- Modern Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-br from-[#056ded]/70 via-blue-800/65 to-blue-950/80" style="background: linear-gradient(135deg, rgba(5, 109, 237, 0.7) 0%, rgba(30, 64, 175, 0.65) 50%, rgba(23, 37, 84, 0.8) 100%);"></div>
                        <!-- Texture/Noise overlay (optional) -->
                        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noiseFilter%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.65%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noiseFilter)%22/%3E%3C/svg%3E');"></div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Default Fallback Slider with 3 Images -->
            <div id="hero-slider" class="w-full h-full relative absolute inset-0">
                @php
                    $defaultImages = [
                        "https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=2000&auto=format&fit=crop", // Majestic campus building
                        "https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2000&auto=format&fit=crop", // Students on beautiful campus grass
                        "https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=2000&auto=format&fit=crop"  // Modern tech-focused study group
                    ];
                @endphp
                @foreach($defaultImages as $index => $img)
                    <div class="absolute inset-0 transition-opacity duration-1000 slider-slide {{ $index == 0 ? 'opacity-100' : 'opacity-0' }}">
                        <img src="{{ $img }}" alt="Default Slider {{ $index+1 }}" class="w-full h-full object-cover">
                        <!-- Modern Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-br from-[#056ded]/70 via-blue-800/65 to-blue-950/80" style="background: linear-gradient(135deg, rgba(5, 109, 237, 0.7) 0%, rgba(30, 64, 175, 0.65) 50%, rgba(23, 37, 84, 0.8) 100%);"></div>
                        <!-- Texture/Noise overlay (optional) -->
                        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noiseFilter%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.65%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noiseFilter)%22/%3E%3C/svg%3E');"></div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Hero Content -->
        <div class="relative z-10 w-full py-16 sm:py-20 lg:py-24 text-left">
            <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
                <div class="max-w-3xl transform transition-all duration-700 translate-y-0 opacity-100">
                    <!-- Decorative Badge -->
                    <div class="mb-5 sm:mb-8 inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-full bg-gradient-to-r from-yellow-500 to-yellow-600 border border-yellow-400 shadow-[0_0_20px_rgba(234,179,8,0.4)] hover:shadow-[0_0_25px_rgba(234,179,8,0.6)] transition-all cursor-default">
                        <div class="bg-white/20 p-1 rounded-full shadow-inner">
                            <i class="fa-solid fa-star text-white text-[10px] block"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-bold text-white tracking-widest uppercase">Akreditasi {{ optional($pengaturan)->akreditasi ?? 'A (Unggul)' }}</span>
                    </div>
                    
                    <!-- Title (Modern & Dynamic) -->
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4 sm:mb-6 leading-[1.15] tracking-tight drop-shadow-xl">
                        Selamat Datang di <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-yellow-200 filter drop-shadow-lg">{{ optional($pengaturan)->nama_sekolah ?? 'Sekolah Unggulan' }}</span>
                    </h1>
                    
                    <p class="text-sm sm:text-base md:text-lg lg:text-xl text-blue-50/90 max-w-2xl mb-8 sm:mb-10 font-medium leading-relaxed drop-shadow-md">
                        Mencetak generasi cerdas, berkarakter, dan berdaya saing global melalui pendidikan berkualitas berbasis keunggulan teknologi dan akhlak mulia.
                    </p>
                    
                    <!-- Button (Modern Outline Transparent) -->
                    <div class="flex flex-wrap gap-4">
                        <a href="#tentang" class="group inline-flex items-center gap-3 bg-transparent border-2 border-white/70 hover:border-white hover:bg-white/10 text-white font-bold py-3 sm:py-3.5 px-6 sm:px-8 text-sm sm:text-base rounded-full backdrop-blur-sm transition-all duration-300 transform hover:-translate-y-1">
                            <span>Jelajahi Lebih Lanjut</span>
                            <i class="fa-solid fa-arrow-down text-sm transition-transform group-hover:translate-y-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slider Dots -->
        <div class="absolute bottom-8 left-0 w-full flex justify-center gap-3 z-20" id="slider-dots">
            <!-- Dots will be generated by JS based on number of slides -->
        </div>
    </section>

    <!-- Sambutan Kepala Sekolah -->
    <section id="tentang" class="py-12 md:py-20 bg-white relative">
        <!-- Decorative Background Element -->
        <div class="absolute top-0 left-0 w-full h-1/2 bg-blue-50/30"></div>
        
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl relative z-10">
            <div class="bg-gradient-to-br from-[#056ded] via-blue-700 to-blue-900 rounded-[2rem] sm:rounded-[2.5rem] shadow-2xl overflow-hidden border border-blue-600/50 p-6 sm:p-8 md:p-10 lg:p-12 relative">
                
                <!-- Abstract Decorative Shapes inside Card -->
                <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000 pointer-events-none"></div>

                <div class="flex flex-col lg:flex-row gap-8 lg:gap-16 items-center relative z-10">
                    <!-- Photo with Frame -->
                    <div class="w-full lg:w-5/12 flex justify-center">
                        <div class="relative group">
                            <!-- Subtle Glow -->
                            <div class="absolute -inset-1 bg-gradient-to-br from-yellow-400 to-blue-500 rounded-3xl opacity-30 group-hover:opacity-60 blur-md transition duration-500"></div>
                            
                            <!-- Sleek Photo Container -->
                            <div class="relative bg-white/10 backdrop-blur-sm p-1.5 rounded-3xl border border-white/20 shadow-2xl transform transition-transform duration-500 group-hover:-translate-y-1">
                                @if(isset($pengaturan->foto_kepala_sekolah) && $pengaturan->foto_kepala_sekolah)
                                    <img src="{{ storage_upload_url($pengaturan->foto_kepala_sekolah) }}" alt="Kepala Sekolah" class="w-48 h-56 sm:w-56 sm:h-64 lg:w-64 lg:h-80 object-cover rounded-2xl shadow-inner">
                                @else
                                    <img src="https://ui-avatars.com/api/?name=Kepala+Sekolah&background=1c3faa&color=fff&size=512" alt="Kepala Sekolah" class="w-48 h-56 sm:w-56 sm:h-64 lg:w-64 lg:h-80 object-cover rounded-2xl shadow-inner">
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Text Content -->
                    <div class="w-full lg:w-7/12 text-white">
                        <div class="inline-block px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-4">
                            <span class="text-xs font-bold tracking-widest uppercase text-yellow-300">Pesan Inspiratif</span>
                        </div>
                        
                        <h3 class="text-2xl sm:text-3xl md:text-4xl font-extrabold mb-4 sm:mb-5 leading-tight">
                            Sambutan <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-100">Kepala Sekolah</span>
                        </h3>
                        
                        <div class="relative">
                            <i class="fa-solid fa-quote-left absolute -top-4 -left-3 sm:-left-6 text-3xl sm:text-4xl text-blue-400/20"></i>
                            <div class="prose prose-sm sm:prose-md prose-invert text-blue-50 leading-relaxed text-left sm:text-justify mb-6 relative z-10 font-medium line-clamp-6">
                                <p>
                                    {{ optional($pengaturan)->sambutan_kepala_sekolah ?? 'Selamat datang di website resmi kami. Sebagai institusi pendidikan terdepan, kami berkomitmen penuh untuk memfasilitasi setiap siswa-siswi agar dapat mengembangkan potensi terbaiknya. Di tengah era digital ini, kami terus berinovasi dalam mengintegrasikan teknologi ke dalam sistem pembelajaran, guna menciptakan lingkungan yang kondusif, aman, dan memotivasi.' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 mt-6 border-t border-white/10 pt-6">
                            <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center text-xl text-yellow-400 border border-white/20 flex-shrink-0">
                                <i class="fa-solid fa-pen-nib"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-base sm:text-lg text-white truncate">{{ optional($pengaturan)->nama_kepala_sekolah ?? 'Bapak/Ibu Kepala Sekolah' }}</h4>
                                <span class="text-blue-200 text-xs font-semibold tracking-wider block truncate">Kepala Sekolah {{ optional($pengaturan)->nama_sekolah ?? 'Sekolah Unggulan' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Card (Glassmorphism) -->
    <section class="relative z-20 -mt-10 mb-16 sm:mb-20 px-4">
        <div class="container mx-auto max-w-7xl relative">
            
            <!-- Decorative Blurred Orbs Behind Cards -->
            <div class="absolute inset-0 pointer-events-none overflow-visible z-[-1] flex justify-between items-center px-10">
                <div class="w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-[80px] opacity-40 animate-blob"></div>
                <div class="w-64 h-64 bg-indigo-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-40 animate-blob animation-delay-2000"></div>
                <div class="w-64 h-64 bg-yellow-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-30 animate-blob animation-delay-4000 hidden md:block"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-6">
                @forelse($statistik as $stat)
                    <div class="bg-white/60 backdrop-blur-xl rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 text-center shadow-[0_8px_32px_rgba(31,38,135,0.07)] border border-white/80 group transform transition-all duration-500 hover:-translate-y-2 hover:bg-white/90 hover:shadow-[0_15px_40px_rgba(31,38,135,0.12)]">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto bg-gradient-to-tr from-blue-600 to-indigo-400 rounded-xl sm:rounded-[1.25rem] shadow-lg flex items-center justify-center mb-3 sm:mb-5 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                            <i class="{{ $stat->icon }} text-xl sm:text-2xl text-white"></i>
                        </div>
                        <h4 class="text-2xl sm:text-3xl md:text-4xl font-black text-blue-950 mb-1 drop-shadow-sm">{{ $stat->value }}</h4>
                        <p class="text-blue-900/70 font-bold text-[10px] sm:text-xs md:text-sm uppercase tracking-wider">{{ $stat->nama }}</p>
                    </div>
                @empty
                    <!-- Default Stats -->
                    <div class="bg-white/60 backdrop-blur-xl rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 text-center shadow-[0_8px_32px_rgba(31,38,135,0.07)] border border-white/80 group transform transition-all duration-500 hover:-translate-y-2 hover:bg-white/90 hover:shadow-[0_15px_40px_rgba(31,38,135,0.12)]">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto bg-gradient-to-tr from-blue-600 to-indigo-400 rounded-xl sm:rounded-[1.25rem] shadow-lg flex items-center justify-center mb-3 sm:mb-5 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                            <i class="fa-solid fa-user-graduate text-xl sm:text-2xl text-white"></i>
                        </div>
                        <h4 class="text-2xl sm:text-3xl md:text-4xl font-black text-blue-950 mb-1 drop-shadow-sm">1,250</h4>
                        <p class="text-blue-900/70 font-bold text-[10px] sm:text-xs md:text-sm uppercase tracking-wider">Siswa Aktif</p>
                    </div>
                    
                    <div class="bg-white/60 backdrop-blur-xl rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 text-center shadow-[0_8px_32px_rgba(31,38,135,0.07)] border border-white/80 group transform transition-all duration-500 hover:-translate-y-2 hover:bg-white/90 hover:shadow-[0_15px_40px_rgba(31,38,135,0.12)]">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto bg-gradient-to-tr from-blue-600 to-indigo-400 rounded-xl sm:rounded-[1.25rem] shadow-lg flex items-center justify-center mb-3 sm:mb-5 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                            <i class="fa-solid fa-chalkboard-user text-xl sm:text-2xl text-white"></i>
                        </div>
                        <h4 class="text-2xl sm:text-3xl md:text-4xl font-black text-blue-950 mb-1 drop-shadow-sm">85</h4>
                        <p class="text-blue-900/70 font-bold text-[10px] sm:text-xs md:text-sm uppercase tracking-wider">Guru Pengajar</p>
                    </div>
                    
                    <div class="bg-white/60 backdrop-blur-xl rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 text-center shadow-[0_8px_32px_rgba(31,38,135,0.07)] border border-white/80 group transform transition-all duration-500 hover:-translate-y-2 hover:bg-white/90 hover:shadow-[0_15px_40px_rgba(31,38,135,0.12)]">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto bg-gradient-to-tr from-blue-600 to-indigo-400 rounded-xl sm:rounded-[1.25rem] shadow-lg flex items-center justify-center mb-3 sm:mb-5 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                            <i class="fa-solid fa-school text-xl sm:text-2xl text-white"></i>
                        </div>
                        <h4 class="text-2xl sm:text-3xl md:text-4xl font-black text-blue-950 mb-1 drop-shadow-sm">32</h4>
                        <p class="text-blue-900/70 font-bold text-[10px] sm:text-xs md:text-sm uppercase tracking-wider">Ruang Kelas</p>
                    </div>
                    
                    <div class="bg-white/60 backdrop-blur-xl rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 text-center shadow-[0_8px_32px_rgba(31,38,135,0.07)] border border-white/80 group transform transition-all duration-500 hover:-translate-y-2 hover:bg-white/90 hover:shadow-[0_15px_40px_rgba(31,38,135,0.12)]">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto bg-gradient-to-tr from-blue-600 to-indigo-400 rounded-xl sm:rounded-[1.25rem] shadow-lg flex items-center justify-center mb-3 sm:mb-5 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                            <i class="fa-solid fa-trophy text-xl sm:text-2xl text-white"></i>
                        </div>
                        <h4 class="text-2xl sm:text-3xl md:text-4xl font-black text-blue-950 mb-1 drop-shadow-sm">150+</h4>
                        <p class="text-blue-900/70 font-bold text-[10px] sm:text-xs md:text-sm uppercase tracking-wider">Prestasi Diraih</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    <!-- Direktori Guru Card -->
    <section class="py-20 bg-gradient-to-b from-white to-blue-50/50 relative overflow-hidden">
        <!-- Modern Background Element -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-100/50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-yellow-100/50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none"></div>

        <div class="container mx-auto px-4 lg:px-8 max-w-7xl relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-widest mb-3">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span> Tenaga Pendidik
                    </div>
                    <h3 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Direktori Guru Kami</h3>
                </div>
                <a href="{{ route('frontend.guru') }}" class="hidden sm:inline-flex bg-white text-blue-700 font-bold px-6 py-2.5 rounded-full shadow-sm hover:shadow-md border border-gray-100 hover:bg-blue-50 transition-all items-center gap-2">
                    Lihat Semua <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                @forelse($guru as $g)
                    <div class="relative rounded-[2rem] overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-500 group h-[22rem]">
                        <!-- Image -->
                        <img src="{{ $g->foto ? storage_upload_url($g->foto) : 'https://randomuser.me/api/portraits/men/' . ($loop->index % 90 + 1) . '.jpg' }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $g->nama }}">
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-950 via-blue-900/40 to-transparent opacity-80 group-hover:opacity-95 transition-opacity duration-500"></div>
                        
                        <!-- Content -->
                        <div class="absolute bottom-0 left-0 w-full p-6 lg:p-8 flex flex-col justify-end h-full">
                            <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                <h4 class="text-xl lg:text-2xl font-bold text-white mb-1 drop-shadow-md leading-tight">{{ $g->nama }}</h4>
                                <p class="text-sm text-blue-100 font-normal mb-0 group-hover:mb-4 transition-all duration-500">{{ $g->jabatan ?? 'Guru' }}</p>
                                
                                <!-- Social links (fade in on hover) -->
                                <div class="flex gap-2.5 opacity-0 h-0 group-hover:h-auto group-hover:opacity-100 transition-all duration-500 overflow-hidden">
                                    @if($g->facebook)<a href="{{ $g->facebook }}" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md text-white flex items-center justify-center hover:bg-blue-600 transition-colors"><i class="fa-brands fa-facebook-f text-sm"></i></a>@endif
                                    @if($g->instagram)<a href="{{ $g->instagram }}" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md text-white flex items-center justify-center hover:bg-pink-600 transition-colors"><i class="fa-brands fa-instagram text-sm"></i></a>@endif
                                    @if($g->whatsapp)<a href="https://wa.me({{ preg_replace('/[^0-9]/', '', $g->whatsapp) }})" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md text-white flex items-center justify-center hover:bg-green-500 transition-colors"><i class="fa-brands fa-whatsapp text-sm"></i></a>@endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Default Guru -->
                    @for($i=1; $i<=4; $i++)
                        <div class="relative rounded-[2rem] overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-500 group h-[22rem]">
                            <img src="https://randomuser.me/api/portraits/men/{{ 30 + $i }}.jpg" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Guru">
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-950 via-blue-900/40 to-transparent opacity-80 group-hover:opacity-95 transition-opacity duration-500"></div>
                            <div class="absolute bottom-0 left-0 w-full p-6 lg:p-8 flex flex-col justify-end h-full">
                                <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    <h4 class="text-xl lg:text-2xl font-bold text-white mb-1 drop-shadow-md leading-tight">Nama Guru Lengkap</h4>
                                    <p class="text-sm text-blue-100 font-normal mb-0 group-hover:mb-4 transition-all duration-500">Guru Mata Pelajaran</p>
                                    <div class="flex gap-2.5 opacity-0 h-0 group-hover:h-auto group-hover:opacity-100 transition-all duration-500 overflow-hidden">
                                        <a href="#" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md text-white flex items-center justify-center hover:bg-blue-600 transition-colors"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                                        <a href="#" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md text-white flex items-center justify-center hover:bg-pink-600 transition-colors"><i class="fa-brands fa-instagram text-sm"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
            
            <div class="mt-8 text-center sm:hidden">
                <a href="{{ route('frontend.guru') }}" class="inline-flex bg-white text-blue-700 font-bold px-8 py-3.5 rounded-full shadow-md border border-gray-100 items-center gap-2 w-full justify-center">
                    Lihat Semua Guru <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Prestasi Section (Modern Full Background) -->
    <section class="py-16 relative overflow-hidden">
        <!-- Full Image Background -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover" alt="Diskusi Kelompok">
        </div>
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#056ded]/80 to-blue-900/80"></div>
        
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl relative z-10">
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-blue-200 text-xs font-bold uppercase tracking-widest mb-4">
                    <i class="fa-solid fa-star text-yellow-400"></i> Kebanggaan Kami
                </div>
                <h3 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Prestasi Sekolah</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                @forelse($prestasi as $item)
                    <div class="relative rounded-[1.5rem] overflow-hidden group h-56 md:h-64 shadow-xl hover:shadow-2xl transition-all duration-500">
                        <!-- Image -->
                        @if(isset($item->dokumentasi) && is_array($item->dokumentasi) && count($item->dokumentasi) > 0)
                            <img src="{{ storage_upload_url($item->dokumentasi[0]) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $item->nama_kegiatan }}">
                        @else
                            <img src="https://picsum.photos/seed/prestasi{{ $item->id }}/800/600" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Prestasi">
                        @endif
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-900/50 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-500"></div>
                        
                        <!-- Content Overlay -->
                        <div class="absolute bottom-0 left-0 w-full p-6 flex flex-col justify-end">
                            <div class="mb-3 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500 flex items-center gap-2 flex-wrap">
                                @php
                                    $badgePrestasi = 'Juara';
                                    if (!empty($item->hasil)) {
                                        $badgePrestasi = is_numeric($item->hasil) ? 'Juara ' . $item->hasil : $item->hasil;
                                    }
                                @endphp
                                <span class="inline-flex items-center gap-1.5 bg-yellow-400 text-yellow-950 text-xs font-bold px-3 py-1.5 rounded-md uppercase tracking-wider shadow-sm">
                                    <i class="fa-solid fa-medal"></i> {{ $badgePrestasi }}
                                </span>
                                @if(!empty($item->tipe))
                                    <span class="inline-flex items-center text-[11px] font-semibold text-white/90 bg-white/20 backdrop-blur-md px-2.5 py-1 rounded-md uppercase tracking-wider">
                                        {{ $item->tipe }}
                                    </span>
                                @endif
                                @if(!empty($item->tahun))
                                    <span class="inline-flex items-center text-[11px] font-medium text-white/80 bg-black/30 backdrop-blur-md px-2 py-1 rounded-md">
                                        {{ $item->tahun }}
                                    </span>
                                @endif
                            </div>
                            <h4 class="text-xl md:text-2xl font-bold text-white leading-tight group-hover:text-yellow-300 transition-colors">{{ $item->nama_kegiatan }}</h4>
                        </div>
                    </div>
                @empty
                    @php
                        $defaultPrestasiImages = [
                            "https://picsum.photos/seed/prestasi1/800/600",
                            "https://picsum.photos/seed/prestasi2/800/600",
                            "https://picsum.photos/seed/prestasi3/800/600"
                        ];
                    @endphp
                    <!-- Default Prestasi -->
                    @foreach($defaultPrestasiImages as $index => $img)
                        <div class="relative rounded-[1.5rem] overflow-hidden group h-56 md:h-64 shadow-xl hover:shadow-2xl transition-all duration-500 border border-white/10">
                            <img src="{{ $img }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Prestasi Dummy">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-900/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-500"></div>
                            <div class="absolute bottom-0 left-0 w-full p-6 flex flex-col justify-end">
                                <div class="mb-3 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                                    <span class="inline-flex items-center gap-1.5 bg-yellow-400 text-yellow-950 text-xs font-bold px-3 py-1.5 rounded-md uppercase tracking-wider shadow-sm">
                                        <i class="fa-solid fa-medal"></i> Juara {{ $index + 1 }}
                                    </span>
                                </div>
                                <h4 class="text-xl md:text-2xl font-bold text-white leading-tight group-hover:text-yellow-300 transition-colors">Lomba Cerdas Cermat Tingkat Provinsi</h4>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
            
            <div class="text-center mt-10">
                <a href="{{ route('frontend.prestasi') }}" class="inline-flex items-center justify-center bg-white/10 backdrop-blur-md border border-white/20 text-white font-bold px-8 py-3.5 rounded-full hover:bg-white hover:text-blue-900 transition-all gap-2 shadow-lg">
                    Lihat Semua Prestasi <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>


    <!-- Berita Section -->
    <section class="py-24 bg-white relative">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl relative z-10">
            <!-- Modern Section Title -->
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white shadow-sm border border-gray-100 text-blue-600 text-xs font-bold uppercase tracking-widest mb-4">
                        <i class="fa-solid fa-newspaper text-blue-500"></i> Informasi & Update
                    </div>
                    <h3 class="text-3xl md:text-5xl font-black text-gray-900 tracking-tight">Berita <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500">Terbaru</span></h3>
                </div>
                <a href="{{ route('frontend.berita') }}" class="hidden sm:inline-flex items-center gap-2 bg-white hover:bg-blue-50 text-blue-700 font-bold px-6 py-3 rounded-full shadow-sm hover:shadow-md border border-gray-100 transition-all">
                    Lihat Semua Berita <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            @php
                $mainBerita = $berita->first();
                $sideBerita = $berita->slice(1, 3);
            @endphp

            @if($mainBerita)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                    <!-- 1 Card Besar Full Gambar (Kiri) -->
                    <div class="h-full">
                        <article class="relative rounded-[1.5rem] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 group h-[400px] lg:h-full w-full min-h-[400px]">
                            <!-- Image -->
                            <img src="{{ $mainBerita->thumbnail ? storage_upload_url($mainBerita->thumbnail) : 'https://picsum.photos/seed/news_main/800/600' }}" alt="{{ $mainBerita->judul }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-900/60 to-transparent opacity-90 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <!-- Content -->
                            <div class="absolute bottom-0 left-0 w-full p-6 md:p-10 flex flex-col justify-end z-10">
                                <h4 class="text-2xl md:text-4xl font-bold text-white mb-4 leading-tight group-hover:text-blue-200 transition-colors drop-shadow-md">
                                    <a href="{{ route('frontend.berita.show', $mainBerita->id) }}" class="before:absolute before:inset-0">{{ $mainBerita->judul }}</a>
                                </h4>
                                
                                <div class="flex items-center gap-3 mb-6">
                                    <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-md uppercase tracking-wider shadow-sm">
                                        Terbaru
                                    </span>
                                    <span class="bg-white/20 backdrop-blur-md border border-white/20 text-white text-xs font-medium px-3 py-1.5 rounded-md flex items-center shadow-sm">
                                        <i class="fa-regular fa-calendar-alt mr-1.5"></i> {{ $mainBerita->tanggal ? \Carbon\Carbon::parse($mainBerita->tanggal)->format('d M Y') : $mainBerita->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center font-bold text-sm text-white group-hover:text-blue-200 transition-colors">
                                    Lihat Selengkapnya <i class="fa-solid fa-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-2"></i>
                                </div>
                            </div>
                        </article>
                    </div>
                    
                    <!-- 3 Card Bersusun Bawah (Kanan) -->
                    <div class="flex flex-col gap-4 md:gap-6 justify-between h-full">
                        @foreach($sideBerita as $index => $item)
                            <article class="bg-white rounded-[1.5rem] p-4 flex items-center gap-4 md:gap-5 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group relative">
                                <a href="{{ route('frontend.berita.show', $item->id) }}" class="absolute inset-0 z-10"></a>
                                
                                <!-- Nomor Urutan -->
                                <div class="flex-shrink-0 w-10 md:w-14 h-full flex items-center justify-center font-black text-3xl text-gray-200 group-hover:text-blue-600 transition-colors">
                                    0{{ $index + 1 }}
                                </div>
                                
                                <!-- Thumbnail -->
                                <div class="w-24 h-24 md:w-32 md:h-32 flex-shrink-0 rounded-[1rem] overflow-hidden relative shadow-sm">
                                    <img src="{{ $item->thumbnail ? storage_upload_url($item->thumbnail) : 'https://picsum.photos/seed/news_'.$item->id.'/800/600' }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                                
                                <!-- Text Content -->
                                <div class="flex-grow py-2 flex flex-col justify-center">
                                    <h4 class="text-base md:text-lg font-bold text-gray-900 mb-3 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                                        {{ $item->judul }}
                                    </h4>
                                    <div>
                                        <span class="inline-flex items-center text-[11px] md:text-xs font-medium bg-gray-50 border border-gray-100 text-gray-600 px-2.5 py-1 rounded-md">
                                            <i class="fa-regular fa-calendar-alt mr-1.5 text-blue-600"></i> {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : $item->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Default Berita if Empty -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                    <!-- Left Full Card Dummy -->
                    <div class="h-full">
                        <article class="relative rounded-[1.5rem] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 group h-[400px] lg:h-full w-full min-h-[400px]">
                            <img src="https://picsum.photos/seed/news_default_main/800/600" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Berita Utama">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-900/60 to-transparent opacity-90 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <div class="absolute bottom-0 left-0 w-full p-6 md:p-10 flex flex-col justify-end z-10">
                                <h4 class="text-2xl md:text-4xl font-bold text-white mb-4 leading-tight group-hover:text-blue-200 transition-colors drop-shadow-md">
                                    Belum Ada Berita Utama
                                </h4>
                                
                                <div class="flex items-center gap-3 mb-6">
                                    <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-md uppercase tracking-wider shadow-sm">
                                        Terbaru
                                    </span>
                                    <span class="bg-white/20 backdrop-blur-md border border-white/20 text-white text-xs font-medium px-3 py-1.5 rounded-md flex items-center shadow-sm">
                                        <i class="fa-regular fa-calendar-alt mr-1.5"></i> {{ date('d M Y') }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center font-bold text-sm text-white group-hover:text-blue-200 transition-colors cursor-pointer">
                                    Lihat Selengkapnya <i class="fa-solid fa-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-2"></i>
                                </div>
                            </div>
                        </article>
                    </div>
                    
                    <!-- Right List Dummy -->
                    <div class="flex flex-col gap-4 md:gap-6 justify-between h-full">
                        @for($i=1; $i<=3; $i++)
                            <article class="bg-white rounded-[1.5rem] p-4 flex items-center gap-4 md:gap-5 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group relative">
                                <!-- Nomor Urutan -->
                                <div class="flex-shrink-0 w-10 md:w-14 h-full flex items-center justify-center font-black text-3xl text-gray-200 group-hover:text-blue-600 transition-colors">
                                    0{{ $i }}
                                </div>
                                
                                <!-- Thumbnail -->
                                <div class="w-24 h-24 md:w-32 md:h-32 flex-shrink-0 rounded-[1rem] overflow-hidden relative shadow-sm">
                                    <img src="https://picsum.photos/seed/news_default_{{ $i }}/800/600" alt="Berita Dummy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                                
                                <!-- Text Content -->
                                <div class="flex-grow py-2 flex flex-col justify-center">
                                    <h4 class="text-base md:text-lg font-bold text-gray-900 mb-3 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                                        Berita Dummy {{ $i }}: Belum ada berita yang ditambahkan di database
                                    </h4>
                                    <div>
                                        <span class="inline-flex items-center text-[11px] md:text-xs font-medium bg-gray-50 border border-gray-100 text-gray-600 px-2.5 py-1 rounded-md">
                                            <i class="fa-regular fa-calendar-alt mr-1.5 text-blue-600"></i> {{ date('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </article>
                        @endfor
                    </div>
                </div>
            @endif

            <div class="mt-10 text-center sm:hidden">
                <a href="{{ route('frontend.berita') }}" class="inline-flex bg-white hover:bg-blue-50 text-blue-700 font-bold px-8 py-3.5 rounded-full shadow-md border border-gray-100 transition-all items-center gap-2 w-full justify-center">
                    Lihat Semua Berita <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- SPMB CTA Card -->
    <section class="py-16 bg-gray-50 relative z-20">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="relative rounded-[2rem] overflow-hidden shadow-2xl bg-blue-900">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover opacity-20" alt="Students">
                </div>
                <!-- Gradient highlight -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-900 via-blue-800/90 to-transparent"></div>
                
                <div class="relative z-10 p-6 sm:p-10 md:p-16 flex flex-col lg:flex-row items-center justify-between text-center lg:text-left gap-6 sm:gap-8">
                    <div class="max-w-2xl">
                        <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-widest mb-4 sm:mb-5 inline-block shadow-sm">Pendaftaran Dibuka</span>
                        <h3 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white mb-3 sm:mb-4 leading-tight">Penerimaan Siswa Baru (SPMB)</h3>
                        <p class="text-blue-100/90 text-sm sm:text-base md:text-lg">Bergabunglah bersama kami dan wujudkan impian Anda. Pendaftaran tahun ajaran baru telah resmi dibuka.</p>
                    </div>
                    <div class="flex-shrink-0 w-full sm:w-auto">
                        <a href="#" class="inline-flex items-center justify-center bg-yellow-400 text-yellow-950 font-bold px-8 py-3.5 sm:py-4 rounded-xl shadow-[0_0_20px_rgba(250,204,21,0.3)] hover:shadow-[0_0_25px_rgba(250,204,21,0.5)] hover:bg-yellow-300 transition-all gap-2 text-base sm:text-lg transform hover:-translate-y-1 w-full sm:w-auto">
                            Daftar Sekarang <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni & Peta Indonesia Alumni Section -->
    @php
        $defaultAlumniMap = [
            [
                'nama' => 'M. Rafi Maulana',
                'tahun_lulus' => '2021',
                'instansi' => 'USAFA 26',
                'pekerjaan' => 'Teknik Penerbangan',
                'alamat' => 'Bandung',
                'foto' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400&auto=format&fit=crop',
                'testimoni' => 'Unforgettable moments and invaluable connections at SMA Pradita Dirgantara.',
                'pos_desktop' => 'lg:top-[6%] lg:left-[4%] xl:left-[8%]',
            ],
            [
                'nama' => 'Afifah Iswantara',
                'tahun_lulus' => '2020',
                'instansi' => 'UNHAN',
                'pekerjaan' => 'Kedokteran',
                'alamat' => 'Jakarta',
                'foto' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400&auto=format&fit=crop',
                'testimoni' => 'What a great moment to grow!',
                'pos_desktop' => 'lg:top-[6%] lg:right-[4%] xl:right-[8%]',
            ],
            [
                'nama' => 'Judha Hoka',
                'tahun_lulus' => '2019',
                'instansi' => 'National University of Singapore',
                'pekerjaan' => 'Informatika',
                'alamat' => 'Surabaya',
                'foto' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400&auto=format&fit=crop',
                'testimoni' => 'Our laughs are limitless, our memories are countless, our friendship is endless.',
                'pos_desktop' => 'lg:bottom-[8%] lg:left-[30%] xl:left-[34%]',
            ],
            [
                'nama' => 'Revina Elisabeth',
                'tahun_lulus' => '2020',
                'instansi' => 'Institut Teknologi Bandung',
                'pekerjaan' => 'Desain & Bisnis',
                'alamat' => 'Yogyakarta',
                'foto' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400&auto=format&fit=crop',
                'testimoni' => 'Life is short, but the memories we create at school are timeless.',
                'pos_desktop' => 'lg:bottom-[8%] lg:right-[4%] xl:right-[8%]',
            ],
        ];

        // Merge real database records if available
        $mapAlumniList = [];
        $realAlumniList = (isset($testimoni_alumni) && $testimoni_alumni->count() > 0) ? $testimoni_alumni->values()->all() : [];

        foreach ($defaultAlumniMap as $index => $item) {
            if (isset($realAlumniList[$index])) {
                $real = $realAlumniList[$index];
                $mapAlumniList[] = [
                    'nama' => $real->nama,
                    'tahun_lulus' => $real->tahun_lulus,
                    'instansi' => $real->instansi,
                    'pekerjaan' => $real->pekerjaan,
                    'alamat' => $real->alamat ?: $item['alamat'],
                    'foto' => $real->foto ? $real->foto_url : $item['foto'],
                    'testimoni' => $real->testimoni,
                    'pos_desktop' => $item['pos_desktop'],
                ];
            } else {
                $mapAlumniList[] = $item;
            }
        }
    @endphp

    <section class="py-16 lg:py-20 bg-white relative overflow-hidden">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            
            <!-- Section Header (Clean & Centered) -->
            <div class="text-center max-w-2xl mx-auto mb-6 lg:mb-8">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">
                    Testimoni Alumni
                </h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-2">
                    Cerita dan jejak inspiratif para lulusan yang kini berkarya di berbagai penjuru nusantara.
                </p>
            </div>

            <!-- Stage Canvas: Indonesia Dot Map & Floating Cards -->
            <div class="relative w-full min-h-[460px] lg:h-[500px] xl:h-[540px] flex items-center justify-center">
                
                <!-- Ambient Soft Radial Warm Glow in Center -->
                <div class="absolute inset-x-16 top-1/2 -translate-y-1/2 h-36 bg-gradient-to-r from-transparent via-rose-100/40 to-transparent blur-3xl pointer-events-none -z-10"></div>

                <!-- SVG Peta Indonesia Terbentuk Nyata dari Titik-Titik Dot Abu-Abu + Aksen Ornamen Halus -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none z-0">
                    <svg class="w-full h-full max-w-5xl opacity-90" viewBox="0 0 1000 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="ig-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#ec4899" />
                                <stop offset="100%" stop-color="#e11d48" />
                            </linearGradient>
                        </defs>

                        <!-- Peta Dot Indonesia Asli (2,653 Titik Koordinat Presisi) -->
                        <g opacity="0.85">
                            @include('frontend.alumni.indo_dots_svg')
                        </g>

                        <!-- Garis Lengkung Koneksi Halus Antar Wilayah -->
                        <path d="M 120 140 Q 200 110 272 276" stroke="#e2e8f0" stroke-width="1.2" stroke-dasharray="3,3" fill="none" opacity="0.6"/>
                        <path d="M 272 276 Q 400 210 530 240" stroke="#e2e8f0" stroke-width="1.2" stroke-dasharray="3,3" fill="none" opacity="0.6"/>
                        <path d="M 530 240 Q 660 170 800 260" stroke="#e2e8f0" stroke-width="1.2" stroke-dasharray="3,3" fill="none" opacity="0.6"/>

                        <!-- Ornamen Lingkaran Halus (Orange Rings & Teal Rings Sesuai Referensi) -->
                        <circle cx="160" cy="180" r="5" stroke="#f97316" stroke-width="2" fill="white" opacity="0.85" />
                        <circle cx="272" cy="276" r="6" stroke="#f97316" stroke-width="2" fill="white" opacity="0.85" />
                        <circle cx="476" cy="175" r="5" stroke="#f97316" stroke-width="2" fill="white" opacity="0.85" />
                        <circle cx="708" cy="225" r="5.5" stroke="#f97316" stroke-width="2" fill="white" opacity="0.85" />
                        
                        <circle cx="288" cy="291" r="5" stroke="#0d9488" stroke-width="2" fill="white" opacity="0.85" />
                        <circle cx="393" cy="298" r="6" stroke="#0d9488" stroke-width="2" fill="white" opacity="0.85" />
                        <circle cx="592" cy="231" r="5" stroke="#0d9488" stroke-width="2" fill="white" opacity="0.85" />
                        <circle cx="964" cy="201" r="5.5" stroke="#0d9488" stroke-width="2" fill="white" opacity="0.85" />

                        <!-- Floating Social / Story Circular Badges dengan Halo Merah Muda Lembut -->
                        <!-- 1. Riau / Sumatera Tengah -->
                        <g transform="translate(160, 155)">
                            <circle cx="0" cy="0" r="24" fill="#fb7185" opacity="0.14" />
                            <circle cx="0" cy="0" r="15" fill="url(#ig-grad)" />
                            <rect x="-5.5" y="-5.5" width="11" height="11" rx="3" fill="none" stroke="white" stroke-width="1.2" />
                            <circle cx="0" cy="0" r="2.5" fill="none" stroke="white" stroke-width="1.2" />
                            <circle cx="2.8" cy="-2.8" r="0.7" fill="white" />
                        </g>

                        <!-- 2. Laut Jawa / Antara Kalimantan & Jawa -->
                        <g transform="translate(440, 260)">
                            <circle cx="0" cy="0" r="24" fill="#fb7185" opacity="0.14" />
                            <circle cx="0" cy="0" r="15" fill="url(#ig-grad)" />
                            <rect x="-5.5" y="-5.5" width="11" height="11" rx="3" fill="none" stroke="white" stroke-width="1.2" />
                            <circle cx="0" cy="0" r="2.5" fill="none" stroke="white" stroke-width="1.2" />
                            <circle cx="2.8" cy="-2.8" r="0.7" fill="white" />
                        </g>

                        <!-- 3. Sulawesi / Banda -->
                        <g transform="translate(620, 230)">
                            <circle cx="0" cy="0" r="24" fill="#fb7185" opacity="0.14" />
                            <circle cx="0" cy="0" r="15" fill="url(#ig-grad)" />
                            <rect x="-5.5" y="-5.5" width="11" height="11" rx="3" fill="none" stroke="white" stroke-width="1.2" />
                            <circle cx="0" cy="0" r="2.5" fill="none" stroke="white" stroke-width="1.2" />
                            <circle cx="2.8" cy="-2.8" r="0.7" fill="white" />
                        </g>

                        <!-- 4. Maluku / Papua Barat -->
                        <g transform="translate(820, 250)">
                            <circle cx="0" cy="0" r="24" fill="#fb7185" opacity="0.14" />
                            <circle cx="0" cy="0" r="15" fill="url(#ig-grad)" />
                            <rect x="-5.5" y="-5.5" width="11" height="11" rx="3" fill="none" stroke="white" stroke-width="1.2" />
                            <circle cx="0" cy="0" r="2.5" fill="none" stroke="white" stroke-width="1.2" />
                            <circle cx="2.8" cy="-2.8" r="0.7" fill="white" />
                        </g>
                    </svg>
                </div>

                <!-- Desktop Layout: 4 Card dengan Posisi Sesuai Diagram:
                     card             Card
                                Card          Card
                -->
                <div class="hidden lg:block absolute inset-0 z-10 pointer-events-auto">
                    @foreach($mapAlumniList as $alumni)
                        <div class="absolute {{ $alumni['pos_desktop'] }} w-[240px] xl:w-[265px] group transition-all duration-300 hover:scale-105 hover:z-20">
                            <div class="bg-white rounded-2xl p-4 xl:p-4.5 border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.06)] group-hover:shadow-[0_16px_36px_rgba(37,99,235,0.12)] transition-all">
                                <p class="text-slate-600 text-[12px] xl:text-[13px] italic leading-relaxed mb-3 font-medium">
                                    "{{ Str::limit($alumni['testimoni'], 80) }}"
                                </p>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $alumni['foto'] }}" alt="{{ $alumni['nama'] }}" 
                                        class="w-9 h-9 xl:w-10 xl:h-10 rounded-full object-cover ring-2 ring-white shadow-xs shrink-0">
                                    <div class="overflow-hidden min-w-0">
                                        <h4 class="font-bold text-slate-900 text-xs xl:text-sm truncate leading-tight group-hover:text-blue-600 transition-colors">
                                            {{ $alumni['nama'] }}
                                        </h4>
                                        <p class="text-[11px] xl:text-xs font-bold text-blue-900 leading-snug mt-0.5">
                                            {{ $alumni['instansi'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Mobile & Tablet Grid Layout -->
                <div class="lg:hidden w-full relative z-10 py-2">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($mapAlumniList as $alumni)
                            <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-md flex flex-col justify-between">
                                <p class="text-slate-600 text-xs italic leading-relaxed mb-3">
                                    "{{ Str::limit($alumni['testimoni'], 85) }}"
                                </p>
                                <div class="flex items-center gap-2.5 pt-2 border-t border-slate-100">
                                    <img src="{{ $alumni['foto'] }}" alt="{{ $alumni['nama'] }}" 
                                        class="w-8 h-8 rounded-full object-cover shadow-xs shrink-0 ring-1 ring-blue-100">
                                    <div class="overflow-hidden min-w-0">
                                        <h4 class="font-bold text-slate-900 text-xs truncate">{{ $alumni['nama'] }}</h4>
                                        <p class="text-[11px] font-bold text-blue-900 truncate">{{ $alumni['instansi'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Tombol Biru Gradient (Lihat Alumni Detail) -->
            <div class="mt-8 text-center relative z-20">
                <a href="{{ route('frontend.alumni') }}" 
                    class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-full bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold text-xs sm:text-sm shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/35 hover:-translate-y-0.5 transition-all duration-300">
                    Lihat Alumni Detail <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

        </div>
    </section>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.slider-slide');
        const dotsContainer = document.getElementById('slider-dots');
        
        if(slides.length > 1) {
            let current = 0;
            
            // Create dots
            slides.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.className = `h-3 rounded-full transition-all duration-500 ${index === 0 ? 'bg-blue-500 w-10' : 'bg-white/50 hover:bg-white/80 w-3'}`;
                dot.setAttribute('aria-label', `Slide ${index + 1}`);
                
                dot.addEventListener('click', () => {
                    goToSlide(index);
                });
                
                dotsContainer.appendChild(dot);
            });
            
            const dots = dotsContainer.querySelectorAll('button');
            
            function goToSlide(index) {
                if (current === index) return; // Do nothing if clicking current slide

                // Remove active classes from old slide & dot
                slides[current].classList.remove('opacity-100');
                slides[current].classList.add('opacity-0');
                dots[current].classList.remove('bg-blue-500', 'w-10');
                dots[current].classList.add('bg-white/50', 'w-3');
                
                // Update current
                current = index;
                
                // Add active classes to new slide & dot
                slides[current].classList.remove('opacity-0');
                slides[current].classList.add('opacity-100');
                dots[current].classList.remove('bg-white/50', 'w-3');
                dots[current].classList.add('bg-blue-500', 'w-10');
            }
            
            // Auto slide
            let slideInterval = setInterval(() => {
                goToSlide((current + 1) % slides.length);
            }, 5000);
            
            // Pause on hover
            const heroSection = document.querySelector('#hero-slider').parentElement;
            heroSection.addEventListener('mouseenter', () => clearInterval(slideInterval));
            heroSection.addEventListener('mouseleave', () => {
                slideInterval = setInterval(() => {
                    goToSlide((current + 1) % slides.length);
                }, 5000);
            });
        }
    });
</script>
@endsection
