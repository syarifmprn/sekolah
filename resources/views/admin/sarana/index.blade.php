<x-app-layout>
    <x-slot name="header">
        Manajemen Sarana (Inventaris & Peralatan)
    </x-slot>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(e, formId) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Data Sarana?',
                    text: "Data inventaris barang beserta fotonya akan dihapus permanen!",
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

    <div class="p-6 h-full flex flex-col gap-6 overflow-y-auto">
        <!-- Flash Message -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-xl shadow-xs flex items-center justify-between" role="alert">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-green-500 text-lg"></i>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Quick Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Jenis Barang</span>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_barang'] ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Fisik Unit</span>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_unit'] ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kondisi Baik</span>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['kondisi_baik'] ?? 0 }} <span class="text-xs font-normal text-gray-400">unit</span></h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Perlu Perbaikan</span>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['kondisi_rusak'] ?? 0 }} <span class="text-xs font-normal text-gray-400">unit</span></h3>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col flex-1">
            
            <!-- Toolbar & Filter -->
            <div class="p-5 border-b border-gray-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Daftar Sarana & Inventaris Barang</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Kelola aset alat laboratorium, komputer, proyektor, mebel, dan peralatan penunjang.</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <form action="{{ route('admin.sarana.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Cari nama barang..." 
                                class="pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500 w-40 sm:w-52">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                            </div>
                        </div>

                        <!-- Filter Ruangan / Prasarana -->
                        <select name="prasarana_id" onchange="this.form.submit()" 
                            class="py-2 pl-3 pr-8 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">Semua Ruangan</option>
                            @foreach($prasaranasList as $pra)
                                <option value="{{ $pra->id }}" {{ request('prasarana_id') == $pra->id ? 'selected' : '' }}>{{ $pra->nama }}</option>
                            @endforeach
                        </select>

                        <!-- Filter Kondisi -->
                        <select name="kondisi" onchange="this.form.submit()" 
                            class="py-2 pl-3 pr-8 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">Semua Kondisi</option>
                            @foreach($kondisiList as $key => $label)
                                <option value="{{ $key }}" {{ request('kondisi') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>

                        @if(request()->anyFilled(['search', 'prasarana_id', 'kondisi', 'tahun']))
                            <a href="{{ route('admin.sarana.index') }}" 
                                class="p-2 text-gray-500 hover:text-red-500 text-xs flex items-center gap-1" title="Reset Filter">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </a>
                        @endif
                    </form>

                    <a href="{{ route('admin.sarana.create') }}" 
                        class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-colors focus:ring-4 focus:ring-blue-100 gap-1.5 shadow-xs">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Sarana
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-xs text-gray-600">
                    <thead class="bg-gray-50/75 text-gray-500 uppercase font-semibold tracking-wider sticky top-0 border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3.5">Nama Sarana / Barang</th>
                            <th class="px-5 py-3.5">Lokasi Ruangan</th>
                            <th class="px-5 py-3.5 text-center">Jumlah Unit</th>
                            <th class="px-5 py-3.5 text-center">Kondisi</th>
                            <th class="px-5 py-3.5 text-center">Tahun Pengadaan</th>
                            <th class="px-5 py-3.5">Keterangan</th>
                            <th class="px-5 py-3.5 text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($data as $row)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <!-- Foto & Nama -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($row->foto)
                                        <img src="{{ asset('storage/' . $row->foto) }}" alt="{{ $row->nama }}" 
                                            class="w-12 h-12 rounded-xl object-cover border border-gray-200 bg-white shadow-2xs">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-lg font-bold">
                                            <i class="fa-solid fa-boxes-stacked"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.sarana.show', $row->id) }}" class="font-bold text-gray-800 hover:text-blue-600 transition-colors text-sm">
                                            {{ $row->nama }}
                                        </a>
                                        <span class="text-[11px] text-gray-400 block mt-0.5">ID: #{{ $row->id }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Lokasi Ruangan / Prasarana -->
                            <td class="px-5 py-4">
                                @if($row->prasarana)
                                    <a href="{{ route('admin.prasarana.show', $row->prasarana->id) }}" 
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-50 text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-md border border-gray-200 font-medium transition-colors" title="Lihat Ruangan">
                                        <i class="fa-solid fa-building text-[10px] text-gray-400"></i>
                                        {{ $row->prasarana->nama }}
                                    </a>
                                @else
                                    <span class="text-gray-400 text-[11px] italic">Belum ditentukan</span>
                                @endif
                            </td>

                            <!-- Jumlah Unit -->
                            <td class="px-5 py-4 text-center">
                                <span class="font-bold text-gray-800 text-sm">{{ $row->jumlah }}</span>
                                <span class="text-[11px] text-gray-400 block">Unit</span>
                            </td>

                            <!-- Kondisi -->
                            <td class="px-5 py-4 text-center">
                                @if($row->kondisi === 'baik')
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Baik
                                    </span>
                                @elseif($row->kondisi === 'rusak_ringan')
                                    <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                        Rusak Ringan
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-red-50 text-red-700 border border-red-200">
                                        Rusak Berat
                                    </span>
                                @endif
                            </td>

                            <!-- Tahun Pengadaan -->
                            <td class="px-5 py-4 text-center text-gray-600 font-medium">
                                {{ $row->tahun_pengadaan ?? '-' }}
                            </td>

                            <!-- Keterangan -->
                            <td class="px-5 py-4 text-gray-500 max-w-xs">
                                <span class="line-clamp-2 text-[11px] leading-relaxed">{{ $row->keterangan ?? '-' }}</span>
                            </td>

                            <!-- Aksi -->
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.sarana.show', $row->id) }}" 
                                        class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors" title="Lihat Detail">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('admin.sarana.edit', $row->id) }}" 
                                        class="p-2 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors" title="Edit Data">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    
                                    <form id="delete-form-{{ $row->id }}" action="{{ route('admin.sarana.destroy', $row->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(event, 'delete-form-{{ $row->id }}')" 
                                            class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-300 text-2xl mb-3">
                                        <i class="fa-solid fa-boxes-stacked"></i>
                                    </div>
                                    <p class="font-medium text-gray-600">Belum ada data sarana / barang</p>
                                    <p class="text-xs text-gray-400 mt-1">Mulai catat inventaris barang, komputer, proyektor, atau perabot sekolah.</p>
                                    <a href="{{ route('admin.sarana.create') }}" 
                                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 transition-colors">
                                        + Tambah Sarana
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($data->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
