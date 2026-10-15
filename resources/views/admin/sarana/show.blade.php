<x-app-layout>
    <x-slot name="header">
        Detail Sarana: {{ $sarana->nama }}
    </x-slot>

    <div class="p-6 h-full overflow-y-auto max-w-4xl mx-auto space-y-6">
        
        <!-- Header Info Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 sm:p-8 bg-gradient-to-r from-blue-700 to-indigo-800 text-white flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    @if($sarana->foto)
                        <img src="{{ asset('storage/' . $sarana->foto) }}" alt="{{ $sarana->nama }}" 
                            class="w-20 h-20 rounded-2xl object-cover bg-white p-1 border-2 border-white/20 shadow-md">
                    @else
                        <div class="w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-3xl font-bold text-white shadow-md">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                    @endif

                    <div>
                        <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                            @if($sarana->kondisi === 'baik')
                                <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-emerald-500 text-white shadow-xs">
                                    Kondisi Baik
                                </span>
                            @elseif($sarana->kondisi === 'rusak_ringan')
                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-amber-500 text-white">
                                    Rusak Ringan
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-red-500 text-white">
                                    Rusak Berat
                                </span>
                            @endif

                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-white/20 text-white">
                                {{ $sarana->jumlah }} Unit
                            </span>
                        </div>

                        <h2 class="text-2xl font-extrabold tracking-tight">{{ $sarana->nama }}</h2>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.sarana.edit', $sarana->id) }}" 
                        class="px-4 py-2 bg-white text-blue-700 hover:bg-blue-50 font-semibold text-xs rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
                        <i class="fa-regular fa-pen-to-square"></i> Edit Data
                    </a>
                    <a href="{{ route('admin.sarana.index') }}" 
                        class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white font-medium text-xs rounded-xl transition-colors flex items-center gap-1.5 backdrop-blur-xs">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-gray-100 bg-gray-50/50 border-t border-gray-100">
                <div class="p-4">
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Jumlah Unit</span>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $sarana->jumlah }} Unit</p>
                </div>
                <div class="p-4">
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Lokasi Ruangan</span>
                    @if($sarana->prasarana)
                        <a href="{{ route('admin.prasarana.show', $sarana->prasarana->id) }}" class="font-bold text-blue-600 hover:underline text-sm mt-0.5 block truncate">
                            {{ $sarana->prasarana->nama }}
                        </a>
                    @else
                        <p class="font-medium text-gray-400 text-sm mt-0.5">Belum ditentukan</p>
                    @endif
                </div>
                <div class="p-4">
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Kondisi Barang</span>
                    <p class="font-bold text-gray-800 text-sm mt-0.5 uppercase">{{ str_replace('_', ' ', $sarana->kondisi) }}</p>
                </div>
                <div class="p-4">
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Tahun Pengadaan</span>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $sarana->tahun_pengadaan ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Keterangan Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-800 mb-2 flex items-center gap-2">
                <i class="fa-regular fa-file-lines text-blue-600"></i>
                Keterangan & Spesifikasi Barang
            </h3>
            <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                {{ $sarana->keterangan ?? 'Belum ada keterangan atau spesifikasi khusus untuk barang ini.' }}
            </p>
        </div>

    </div>
</x-app-layout>
