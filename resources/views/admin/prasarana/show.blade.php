<x-app-layout>
    <x-slot name="header">
        Detail Prasarana: {{ $prasarana->nama }}
    </x-slot>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(e, formId) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Data Prasarana?',
                    text: "Data ruangan beserta foto akan dihapus permanen!",
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

    <div class="p-6 h-full overflow-y-auto max-w-6xl mx-auto space-y-6">
        
        <!-- Header Info Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 sm:p-8 bg-gradient-to-r from-blue-700 to-indigo-800 text-white flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    @if($prasarana->foto)
                        <img src="{{ asset('storage/' . $prasarana->foto) }}" alt="{{ $prasarana->nama }}" 
                            class="w-20 h-20 rounded-2xl object-cover bg-white p-1 border-2 border-white/20 shadow-md">
                    @else
                        <div class="w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-3xl font-bold text-white shadow-md">
                            <i class="fa-solid fa-building"></i>
                        </div>
                    @endif

                    <div>
                        <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                            @if($prasarana->kondisi === 'baik')
                                <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-emerald-500 text-white shadow-xs">
                                    Kondisi Baik
                                </span>
                            @elseif($prasarana->kondisi === 'rusak_ringan')
                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-amber-500 text-white">
                                    Rusak Ringan
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-red-500 text-white">
                                    Rusak Berat
                                </span>
                            @endif

                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-white/20 text-white">
                                {{ $prasarana->jumlah }} Unit Ruang
                            </span>
                        </div>

                        <h2 class="text-2xl font-extrabold tracking-tight">{{ $prasarana->nama }}</h2>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.prasarana.edit', $prasarana->id) }}" 
                        class="px-4 py-2 bg-white text-blue-700 hover:bg-blue-50 font-semibold text-xs rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
                        <i class="fa-regular fa-pen-to-square"></i> Edit Data
                    </a>
                    <a href="{{ route('admin.prasarana.index') }}" 
                        class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white font-medium text-xs rounded-xl transition-colors flex items-center gap-1.5 backdrop-blur-xs">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-gray-100 bg-gray-50/50 border-t border-gray-100">
                <div class="p-4">
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Jumlah Ruang</span>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $prasarana->jumlah }} Unit</p>
                </div>
                <div class="p-4">
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Ukuran Luas</span>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $prasarana->luas_formatted }}</p>
                </div>
                <div class="p-4">
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Kondisi Fisik</span>
                    <p class="font-bold text-gray-800 text-sm mt-0.5 uppercase">{{ str_replace('_', ' ', $prasarana->kondisi) }}</p>
                </div>
                <div class="p-4">
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider block">Total Barang Aset</span>
                    <p class="font-bold text-gray-800 text-sm mt-0.5">{{ $prasarana->saranas->count() }} Jenis ({{ $prasarana->saranas->sum('jumlah') }} Unit)</p>
                </div>
            </div>
        </div>

        <!-- Keterangan Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-800 mb-2 flex items-center gap-2">
                <i class="fa-regular fa-file-lines text-blue-600"></i>
                Keterangan & Catatan Prasarana
            </h3>
            <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                {{ $prasarana->keterangan ?? 'Belum ada keterangan atau catatan khusus untuk prasarana ini.' }}
            </p>
        </div>

        <!-- Daftar Sarana (Barang) di Ruangan Ini -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-boxes-stacked text-blue-600"></i>
                        Inventaris Sarana & Barang di {{ $prasarana->nama }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">Daftar peralatan, inventaris, dan perabot yang tercatat berada di ruangan ini.</p>
                </div>

                <a href="{{ route('admin.sarana.create', ['prasarana_id' => $prasarana->id]) }}" 
                    class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-colors">
                    <i class="fa-solid fa-plus"></i> Tambah Barang
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-600">
                    <thead class="bg-gray-50/75 text-gray-500 uppercase font-semibold tracking-wider border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3">Nama Barang</th>
                            <th class="px-5 py-3 text-center">Jumlah</th>
                            <th class="px-5 py-3 text-center">Kondisi</th>
                            <th class="px-5 py-3 text-center">Tahun Pengadaan</th>
                            <th class="px-5 py-3">Keterangan</th>
                            <th class="px-5 py-3 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($prasarana->saranas as $item)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-5 py-3.5 font-bold text-gray-800">
                                    <div class="flex items-center gap-2.5">
                                        @if($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" class="w-8 h-8 rounded-lg object-cover border border-gray-200">
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-400 flex items-center justify-center text-xs">
                                                <i class="fa-solid fa-box"></i>
                                            </div>
                                        @endif
                                        <span>{{ $item->nama }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-center font-semibold text-gray-700">
                                    {{ $item->jumlah }} Unit
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @if($item->kondisi === 'baik')
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">Baik</span>
                                    @elseif($item->kondisi === 'rusak_ringan')
                                        <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200">Rusak Ringan</span>
                                    @else
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-red-50 text-red-700 border border-red-200">Rusak Berat</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-center text-gray-500">
                                    {{ $item->tahun_pengadaan ?? '-' }}
                                </td>
                                <td class="px-5 py-3.5 text-gray-500">
                                    {{ $item->keterangan ?? '-' }}
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.sarana.edit', $item->id) }}" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-md" title="Edit">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.sarana.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus barang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-md" title="Hapus">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-gray-400">
                                    <i class="fa-solid fa-boxes-stacked text-2xl text-gray-300 mb-1"></i>
                                    <p class="text-xs">Belum ada barang atau peralatan yang terdaftar di ruangan ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
