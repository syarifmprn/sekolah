@extends('layouts.frontend')
@section('title', $ekskul->nama . ' - Ekstrakurikuler')

@section('content')
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-[#056ded]">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i>
                <a href="{{ route('frontend.ekstrakurikuler') }}" class="hover:text-[#056ded]">Ekstrakurikuler</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i>
                <span class="text-gray-800 font-semibold truncate">{{ $ekskul->nama }}</span>
            </nav>

            <!-- Hero Header Card -->
            <div class="bg-gradient-to-r from-[#056ded] via-blue-700 to-indigo-800 rounded-3xl p-6 sm:p-10 text-white shadow-xl mb-8 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center gap-6 justify-between">
                    <div class="flex items-center gap-5">
                        @if($ekskul->logo)
                            <img src="{{ storage_upload_url($ekskul->logo) }}" alt="{{ $ekskul->nama }}" 
                                class="w-24 h-24 rounded-2xl object-cover bg-white p-1 border-2 border-white/20 shadow-lg">
                        @else
                            <div class="w-24 h-24 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-4xl text-white shadow-lg">
                                <i class="fa-solid fa-people-group"></i>
                            </div>
                        @endif

                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-white/20 backdrop-blur-md px-3 py-0.5 rounded-full text-xs font-semibold">
                                    {{ $ekskul->kategori }}
                                </span>
                                <span class="bg-emerald-500 text-white px-2.5 py-0.5 rounded-full text-[11px] font-bold">
                                    Aktif
                                </span>
                            </div>
                            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $ekskul->nama }}</h1>
                            @if($ekskul->tempat)
                                <p class="text-blue-200 text-xs mt-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot"></i> {{ $ekskul->tempat }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('frontend.ekstrakurikuler') }}" 
                        class="self-start md:self-auto px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold rounded-xl backdrop-blur-md transition-colors flex items-center gap-1.5 border border-white/20">
                        <i class="fa-solid fa-arrow-left"></i> Semua Ekskul
                    </a>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Details (Left 2 cols) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Deskripsi -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
                            <i class="fa-regular fa-file-lines text-[#056ded]"></i>
                            Tentang Kegiatan
                        </h2>
                        <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                            {{ $ekskul->deskripsi ?? 'Belum ada deskripsi lengkap mengenai kegiatan ekstrakurikuler ini.' }}
                        </div>
                    </div>

                    <!-- Galeri Dokumentasi -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
                            <i class="fa-solid fa-images text-[#056ded]"></i>
                            Galeri & Dokumentasi Kegiatan
                        </h2>

                        @if(is_array($ekskul->galeri) && count($ekskul->galeri) > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3.5">
                                @foreach($ekskul->galeri as $photo)
                                    <div onclick="previewPhoto('{{ storage_upload_url($photo) }}')" 
                                        class="aspect-video rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 cursor-pointer group shadow-2xs hover:shadow-md transition-all relative">
                                        <img src="{{ storage_upload_url($photo) }}" alt="Foto {{ $ekskul->nama }}" 
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                            <i class="fa-solid fa-magnifying-glass-plus text-lg"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10 text-gray-400 bg-gray-50/50 rounded-2xl border border-dashed border-gray-200">
                                <i class="fa-regular fa-images text-4xl text-gray-300 mb-2"></i>
                                <p class="text-xs">Dokumentasi foto kegiatan belum tersedia.</p>
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Sidebar Info (Right 1 col) -->
                <div class="space-y-6">
                    
                    <!-- Jadwal & Kepengurusan Card -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-5">
                        <h3 class="text-base font-bold text-gray-900 pb-3 border-b border-gray-100 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-[#056ded]"></i>
                            Informasi Jadwal & Tim
                        </h3>

                        <!-- Jadwal -->
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#056ded] flex items-center justify-center text-base flex-shrink-0">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div>
                                <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Waktu Latihan</span>
                                <p class="text-sm font-bold text-gray-800">{{ $ekskul->jadwal_formatted }}</p>
                            </div>
                        </div>

                        <!-- Tempat -->
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base flex-shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Lokasi Latihan</span>
                                <p class="text-sm font-bold text-gray-800">{{ $ekskul->tempat ?? 'Di lingkungan sekolah' }}</p>
                            </div>
                        </div>

                        <!-- Pembina -->
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-base flex-shrink-0">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </div>
                            <div>
                                <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Guru Pembina / Pelatih</span>
                                <p class="text-sm font-bold text-gray-800">{{ $ekskul->pembina ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Ketua -->
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-base flex-shrink-0">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                            <div>
                                <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Ketua Ekskul</span>
                                <p class="text-sm font-bold text-gray-800">{{ $ekskul->ketua ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ekskul Lainnya -->
                    @if($ekskul_lainnya->count() > 0)
                        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                            <h3 class="text-base font-bold text-gray-900 pb-3 mb-4 border-b border-gray-100">
                                Ekstrakurikuler Lainnya
                            </h3>

                            <div class="space-y-3.5">
                                @foreach($ekskul_lainnya as $other)
                                    <a href="{{ route('frontend.ekstrakurikuler.show', $other->id) }}" 
                                        class="flex items-center gap-3 p-2 rounded-2xl hover:bg-gray-50 transition-colors group">
                                        @if($other->logo)
                                            <img src="{{ storage_upload_url($other->logo) }}" alt="{{ $other->nama }}" 
                                                class="w-12 h-12 rounded-xl object-cover border border-gray-100 flex-shrink-0">
                                        @else
                                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#056ded] flex items-center justify-center text-base font-bold flex-shrink-0">
                                                <i class="fa-solid fa-people-group"></i>
                                            </div>
                                        @endif
                                        <div class="min-w-0 flex-1">
                                            <h4 class="text-xs font-bold text-gray-800 group-hover:text-[#056ded] transition-colors truncate">
                                                {{ $other->nama }}
                                            </h4>
                                            <span class="text-[10px] text-gray-400">{{ $other->kategori }} &bull; {{ $other->hari ?? 'Jadwal Fleksibel' }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </div>
    </div>

    <!-- Modal Lightbox -->
    <div id="photo-modal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-xs flex items-center justify-center p-4 hidden" onclick="closeModal()">
        <div class="relative max-w-4xl max-h-[90vh] bg-white rounded-2xl overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
            <button onclick="closeModal()" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-black/60 text-white hover:bg-black flex items-center justify-center text-sm z-10 transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <img id="modal-image" src="" alt="Foto" class="max-w-full max-h-[85vh] object-contain">
        </div>
    </div>

    <script>
        function previewPhoto(src) {
            document.getElementById('modal-image').src = src;
            document.getElementById('photo-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('photo-modal').classList.add('hidden');
            document.getElementById('modal-image').src = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>
@endsection
