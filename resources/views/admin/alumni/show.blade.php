<x-app-layout>
    <x-slot name="header">
        Detail Profil Alumni
    </x-slot>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(e, formId) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Data Alumni?',
                    text: "Data profil alumni beserta foto dan testimoni akan dihapus secara permanen.",
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
        </script>
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <div class="max-w-4xl mx-auto space-y-6">
            
            <!-- Top Action Bar -->
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.alumni.index') }}" 
                    class="px-3.5 py-2 text-xs font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                </a>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.alumni.edit', $alumni->id) }}" 
                        class="px-3.5 py-2 text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Alumni
                    </a>
                    <form id="delete-form-{{ $alumni->id }}" 
                        action="{{ route('admin.alumni.destroy', $alumni->id) }}" 
                        method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                            onclick="confirmDelete(event, 'delete-form-{{ $alumni->id }}')"
                            class="px-3.5 py-2 text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition-colors flex items-center gap-1.5">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>

            <!-- Profile Overview Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-10 text-white relative">
                    <div class="flex flex-col sm:flex-row items-center sm:items-end gap-6">
                        @if ($alumni->foto)
                            <img src="{{ $alumni->foto_url }}" alt="{{ $alumni->nama }}" 
                                class="w-28 h-28 rounded-2xl object-cover border-4 border-white shadow-lg shrink-0 bg-white">
                        @else
                            <div class="w-28 h-28 rounded-2xl bg-white/10 backdrop-blur-md border-4 border-white flex items-center justify-center text-4xl font-bold uppercase shrink-0 text-white shadow-lg">
                                {{ mb_substr($alumni->nama ?? 'A', 0, 2) }}
                            </div>
                        @endif

                        <div class="text-center sm:text-left flex-1">
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 backdrop-blur-md border border-white/30 text-white">
                                    Angkatan {{ $alumni->tahun_lulus }}
                                </span>
                                @if($alumni->jurusan)
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-black/20 text-white">
                                        {{ $alumni->jurusan }}
                                    </span>
                                @endif
                                @if($alumni->tampil === 'ya')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/90 text-white border border-emerald-400">
                                        <i class="fa-solid fa-circle-check text-[10px] mr-1"></i> Tampil di Website
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-600/90 text-white">
                                        <i class="fa-solid fa-eye-slash text-[10px] mr-1"></i> Disembunyikan
                                    </span>
                                @endif
                            </div>
                            <h2 class="text-2xl font-bold text-white">{{ $alumni->nama }}</h2>
                            <p class="text-blue-100 text-sm mt-0.5 font-medium">
                                {{ $alumni->pekerjaan }} &bull; {{ $alumni->instansi }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-100">
                    <div class="space-y-1">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Profesi & Instansi</span>
                        <p class="text-sm font-semibold text-gray-800">{{ $alumni->pekerjaan }}</p>
                        <p class="text-xs text-gray-500">{{ $alumni->instansi }}</p>
                    </div>

                    <div class="space-y-1">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Domisili</span>
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-location-dot text-rose-500 text-xs"></i>
                            {{ $alumni->alamat ?: 'Tidak dicantumkan' }}
                        </p>
                    </div>

                    <div class="space-y-1">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Kontak</span>
                        <div class="text-xs text-gray-600 space-y-1">
                            @if($alumni->email)
                                <div><i class="fa-solid fa-envelope mr-1 text-gray-400"></i><a href="mailto:{{ $alumni->email }}" class="text-blue-600 hover:underline">{{ $alumni->email }}</a></div>
                            @endif
                            @if($alumni->no_hp)
                                <div><i class="fa-solid fa-phone mr-1 text-gray-400"></i><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $alumni->no_hp) }}" target="_blank" class="text-emerald-600 hover:underline">{{ $alumni->no_hp }}</a></div>
                            @endif
                            @if(!$alumni->email && !$alumni->no_hp)
                                <p class="text-gray-400 italic">Tidak ada kontak</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Testimonial Section -->
                <div class="p-8 bg-gray-50/50">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fa-solid fa-quote-left text-blue-500 text-xl"></i>
                        <h4 class="text-sm font-bold text-gray-800">Kesan, Pesan & Testimoni Sukses</h4>
                    </div>
                    <blockquote class="pl-4 border-l-4 border-blue-500 text-gray-700 italic text-sm leading-relaxed bg-white p-5 rounded-r-xl border border-gray-100 shadow-xs">
                        "{{ $alumni->testimoni }}"
                    </blockquote>

                    <div class="mt-4 flex flex-wrap items-center justify-between text-[11px] text-gray-400 pt-3 border-t border-gray-200/60">
                        <span>Ditambahkan pada: {{ $alumni->created_at->format('d M Y, H:i') }}</span>
                        <span>Terakhir diperbarui: {{ $alumni->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
