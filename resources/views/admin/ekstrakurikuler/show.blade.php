<x-app-layout>
    <x-slot name="header">
        Detail Ekstrakurikuler: {{ $ekstrakurikuler->nama }}
    </x-slot>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(e, formId) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Ekstrakurikuler?',
                    text: "Semua data termasuk logo dan galeri foto kegiatan akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(formId).submit();
                    }
                });
            }

            function openLightbox(src) {
                Swal.fire({
                    imageUrl: src,
                    imageAlt: 'Foto Dokumentasi',
                    showConfirmButton: false,
                    showCloseButton: true,
                    width: 'auto',
                    background: '#ffffff',
                    backdrop: 'rgba(15, 23, 42, 0.8)',
                    padding: '1rem',
                });
            }
        </script>
    </x-slot>

    <div class="p-6 h-full overflow-y-auto max-w-5xl mx-auto space-y-6">
        
        <!-- Header Profile Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 sm:p-8 bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-800 text-white relative">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
                    <div class="flex items-center gap-5">
                        @if($ekstrakurikuler->logo)
                            <img src="{{ asset('storage/' . $ekstrakurikuler->logo) }}" alt="{{ $ekstrakurikuler->nama }}" 
                                class="w-20 h-20 rounded-2xl object-cover bg-white p-1 border-2 border-white/20 shadow-md">
                        @else
                            <div class="w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-3xl font-bold text-white shadow-md">
                                <i class="fa-solid fa-volleyball"></i>
                            </div>
                        @endif

                        <div>
                            <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                @php
                                    $badgeClasses = match($ekstrakurikuler->kategori) {
                                        'Olahraga' => 'bg-emerald-500/20 text-emerald-200 border-emerald-400/30',
                                        'Seni' => 'bg-purple-500/20 text-purple-200 border-purple-400/30',
                                        'Akademik' => 'bg-blue-400/20 text-blue-200 border-blue-300/30',
                                        'Keagamaan' => 'bg-amber-500/20 text-amber-200 border-amber-400/30',
                                        default => 'bg-white/20 text-white border-white/30',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full border {{ $badgeClasses }}">
                                    {{ $ekstrakurikuler->kategori }}
                                </span>

                                @if($ekstrakurikuler->status === 'aktif')
                                    <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-emerald-500 text-white shadow-xs">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-600 text-gray-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </div>

                            <h2 class="text-2xl font-extrabold tracking-tight">{{ $ekstrakurikuler->nama }}</h2>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.ekstrakurikuler.edit', $ekstrakurikuler->id) }}" 
                            class="px-4 py-2 bg-white text-blue-700 hover:bg-blue-50 font-semibold text-xs rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
                            <i class="fa-regular fa-pen-to-square"></i> Edit Data
                        </a>
                        <a href="{{ route('admin.ekstrakurikuler.index') }}" 
                            class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white font-medium text-xs rounded-xl transition-colors flex items-center gap-1.5 backdrop-blur-xs">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Summary Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-gray-100 bg-gray-50/50 border-t border-gray-100">
                <div class="p-4">
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Jadwal Latihan</span>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $ekstrakurikuler->jadwal_formatted }}</p>
                </div>
                <div class="p-4">
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Tempat Latihan</span>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $ekstrakurikuler->tempat ?? '-' }}</p>
                </div>
                <div class="p-4">
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Pembina / Pelatih</span>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $ekstrakurikuler->pembina ?? '-' }}</p>
                </div>
                <div class="p-4">
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Ketua Ekskul</span>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $ekstrakurikuler->ketua ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Deskripsi Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-800 mb-2 flex items-center gap-2">
                <i class="fa-regular fa-file-lines text-blue-600"></i>
                Deskripsi & Profil Kegiatan
            </h3>
            <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                {{ $ekstrakurikuler->deskripsi ?? 'Belum ada deskripsi yang ditambahkan untuk kegiatan ini.' }}
            </p>
        </div>

        <!-- Galeri Dokumentasi Kegiatan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-images text-blue-600"></i>
                    Galeri Dokumentasi Kegiatan
                </h3>
                <span class="text-xs text-gray-400">
                    {{ is_array($ekstrakurikuler->galeri) ? count($ekstrakurikuler->galeri) : 0 }} Foto
                </span>
            </div>

            @if(is_array($ekstrakurikuler->galeri) && count($ekstrakurikuler->galeri) > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3.5">
                    @foreach($ekstrakurikuler->galeri as $photo)
                        <div onclick="openLightbox('{{ asset('storage/' . $photo) }}')" 
                            class="group relative aspect-video rounded-xl overflow-hidden bg-gray-100 border border-gray-200 cursor-pointer shadow-2xs hover:shadow-md transition-all">
                            <img src="{{ asset('storage/' . $photo) }}" alt="Foto kegiatan" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-lg">
                                <i class="fa-solid fa-magnifying-glass-plus"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-400 bg-gray-50/50 rounded-xl border border-dashed border-gray-200">
                    <i class="fa-regular fa-images text-3xl text-gray-300 mb-2"></i>
                    <p class="text-xs">Belum ada foto dokumentasi yang diunggah.</p>
                    <a href="{{ route('admin.ekstrakurikuler.edit', $ekstrakurikuler->id) }}" class="inline-block mt-2 text-xs font-semibold text-blue-600 hover:underline">
                        + Unggah Foto Sekarang
                    </a>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
