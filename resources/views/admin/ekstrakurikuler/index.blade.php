<x-app-layout>
    <x-slot name="header">
        Manajemen Ekstrakurikuler
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
        </script>
    </x-slot>

    <div class="p-6 h-full flex flex-col gap-6 overflow-y-auto">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-xl shadow-xs flex items-center justify-between" role="alert">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-green-500 text-lg"></i>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Quick Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-people-group"></i>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Ekskul</span>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Status Aktif</span>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['aktif'] }}</h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gray-100 text-gray-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-circle-pause"></i>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nonaktif</span>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['nonaktif'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col flex-1">
            
            <!-- Toolbar & Filter -->
            <div class="p-5 border-b border-gray-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Daftar Kegiatan Ekstrakurikuler</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Kelola informasi ekskul, struktur pembina, jadwal latihan, dan galeri kegiatan.</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <!-- Form Filter & Pencarian -->
                    <form action="{{ route('admin.ekstrakurikuler.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                        <!-- Search Input -->
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Cari nama, pembina, tempat..." 
                                class="pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500 w-48 sm:w-60">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                            </div>
                        </div>

                        <!-- Filter Kategori -->
                        <select name="kategori" onchange="this.form.submit()" 
                            class="py-2 pl-3 pr-8 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>

                        <!-- Filter Status -->
                        <select name="status" onchange="this.form.submit()" 
                            class="py-2 pl-3 pr-8 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>

                        @if(request()->anyFilled(['search', 'kategori', 'status']))
                            <a href="{{ route('admin.ekstrakurikuler.index') }}" 
                                class="p-2 text-gray-500 hover:text-red-500 text-xs flex items-center gap-1" title="Reset Filter">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </a>
                        @endif
                    </form>

                    <!-- Tombol Tambah -->
                    <a href="{{ route('admin.ekstrakurikuler.create') }}" 
                        class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-colors focus:ring-4 focus:ring-blue-100 gap-1.5 shadow-xs">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Ekskul
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-xs text-gray-600">
                    <thead class="bg-gray-50/75 text-gray-500 uppercase font-semibold tracking-wider sticky top-0 border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3.5">Ekstrakurikuler</th>
                            <th class="px-5 py-3.5">Kategori</th>
                            <th class="px-5 py-3.5">Jadwal & Tempat</th>
                            <th class="px-5 py-3.5">Pembina & Ketua</th>
                            <th class="px-5 py-3.5 text-center">Galeri Foto</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($data as $row)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <!-- Logo & Nama -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($row->logo)
                                        <img src="{{ asset('storage/' . $row->logo) }}" alt="{{ $row->nama }}" 
                                            class="w-11 h-11 rounded-xl object-cover border border-gray-200 bg-white shadow-2xs">
                                    @else
                                        <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-lg font-bold">
                                            <i class="fa-solid fa-volleyball"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.ekstrakurikuler.show', $row->id) }}" class="font-bold text-gray-800 hover:text-blue-600 transition-colors text-sm">
                                            {{ $row->nama }}
                                        </a>
                                        @if($row->deskripsi)
                                            <p class="text-[11px] text-gray-400 line-clamp-1 mt-0.5">{{ Str::limit(strip_tags($row->deskripsi), 45) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="px-5 py-4">
                                @php
                                    $badgeClasses = match($row->kategori) {
                                        'Olahraga' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'Seni' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'Akademik' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'Keagamaan' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        default => 'bg-gray-50 text-gray-700 border-gray-200',
                                    };
                                @endphp
                                <span class="px-2.5 py-1 text-[11px] font-semibold rounded-md border {{ $badgeClasses }}">
                                    {{ $row->kategori }}
                                </span>
                            </td>

                            <!-- Jadwal & Lokasi -->
                            <td class="px-5 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="font-semibold text-gray-700 flex items-center gap-1.5">
                                        <i class="fa-regular fa-clock text-blue-500 text-[11px]"></i>
                                        {{ $row->jadwal_formatted }}
                                    </span>
                                    @if($row->tempat)
                                        <span class="text-gray-400 flex items-center gap-1.5 text-[11px]">
                                            <i class="fa-solid fa-location-dot text-gray-400 text-[10px]"></i>
                                            {{ $row->tempat }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Pembina & Ketua -->
                            <td class="px-5 py-4">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-gray-700">
                                        <strong class="text-gray-500 font-medium">Pembina:</strong> {{ $row->pembina ?? '-' }}
                                    </span>
                                    <span class="text-gray-500">
                                        <strong class="text-gray-400 font-medium">Ketua:</strong> {{ $row->ketua ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            <!-- Galeri Foto -->
                            <td class="px-5 py-4 text-center">
                                @php
                                    $galeriCount = is_array($row->galeri) ? count($row->galeri) : 0;
                                @endphp
                                @if($galeriCount > 0)
                                    <a href="{{ route('admin.ekstrakurikuler.show', $row->id) }}" 
                                        class="inline-flex items-center gap-1 px-2.5 py-1 bg-sky-50 text-sky-700 rounded-md border border-sky-100 hover:bg-sky-100 transition-colors font-semibold" title="Lihat foto kegiatan">
                                        <i class="fa-solid fa-images text-[11px]"></i>
                                        {{ $galeriCount }} Foto
                                    </a>
                                @else
                                    <span class="text-gray-300 text-[11px] italic">Belum ada</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="px-5 py-4 text-center">
                                @if($row->status === 'aktif')
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-[11px] font-medium rounded-full bg-gray-100 text-gray-500 border border-gray-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Detail -->
                                    <a href="{{ route('admin.ekstrakurikuler.show', $row->id) }}" 
                                        class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors" title="Lihat Detail">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    
                                    <!-- Edit -->
                                    <a href="{{ route('admin.ekstrakurikuler.edit', $row->id) }}" 
                                        class="p-2 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors" title="Edit Data">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    
                                    <!-- Hapus -->
                                    <form id="delete-form-{{ $row->id }}" action="{{ route('admin.ekstrakurikuler.destroy', $row->id) }}" method="POST" class="inline-block">
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
                                        <i class="fa-solid fa-volleyball"></i>
                                    </div>
                                    <p class="font-medium text-gray-600">Belum ada data ekstrakurikuler</p>
                                    <p class="text-xs text-gray-400 mt-1">Mulai tambahkan kegiatan ekskul baru untuk ditampilkan pada sistem.</p>
                                    <a href="{{ route('admin.ekstrakurikuler.create') }}" 
                                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 transition-colors">
                                        + Tambah Ekstrakurikuler
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
