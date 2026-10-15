<x-app-layout>
    <x-slot name="header">
        Manajemen Data Guru & Tenaga Kependidikan
    </x-slot>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(e, formId) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Data Guru?',
                    text: "Data profil guru beserta foto dan informasi terkait akan dihapus secara permanen.",
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
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Guru</span>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_guru'] ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Guru Aktif</span>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_aktif'] ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-user-xmark"></i>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Non-Aktif</span>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_nonaktif'] ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Mapel / Jabatan</span>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_jabatan'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col flex-1">
            
            <!-- Toolbar & Filter -->
            <div class="p-5 border-b border-gray-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Daftar Guru & Tenaga Kependidikan</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Kelola data guru, mata pelajaran yang diampu, NIP/NUPTK, kontak, serta status keaktifan.</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <form action="{{ route('admin.guru.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Cari nama, NIP, mapel..." 
                                class="pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500 w-48 sm:w-60">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                            </div>
                        </div>

                        <!-- Filter Jabatan / Mapel -->
                        @if(isset($jabatanList) && $jabatanList->count() > 0)
                        <select name="jabatan" onchange="this.form.submit()" 
                            class="py-2 pl-3 pr-8 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Jabatan / Mapel</option>
                            @foreach ($jabatanList as $j)
                                <option value="{{ $j }}" {{ request('jabatan') == $j ? 'selected' : '' }}>
                                    {{ $j }}
                                </option>
                            @endforeach
                        </select>
                        @endif

                        <!-- Filter Status Keaktifan -->
                        <select name="status" onchange="this.form.submit()" 
                            class="py-2 pl-3 pr-8 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>

                        <!-- Filter Jenis Kelamin -->
                        <select name="jenis_kelamin" onchange="this.form.submit()" 
                            class="py-2 pl-3 pr-8 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Gender</option>
                            <option value="L" {{ request('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                            <option value="P" {{ request('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>

                        @if(request()->anyFilled(['search', 'jabatan', 'status', 'jenis_kelamin']))
                            <a href="{{ route('admin.guru.index') }}" class="p-2 text-gray-400 hover:text-gray-600 transition-colors" title="Reset Filter">
                                <i class="fa-solid fa-rotate-left text-xs"></i>
                            </a>
                        @endif
                    </form>

                    <a href="{{ route('admin.guru.create') }}" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold flex items-center gap-2 shadow-xs transition-colors">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Guru
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">Guru / Pendidik</th>
                            <th class="py-3.5 px-4">Jabatan / Mapel</th>
                            <th class="py-3.5 px-4">Gender & Agama</th>
                            <th class="py-3.5 px-4">Kontak & Alamat</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse ($data as $index => $item)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="py-3.5 px-4 text-center font-medium text-gray-400">
                                    {{ $data->firstItem() + $index }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        @if ($item->foto)
                                            <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}" 
                                                class="w-10 h-10 rounded-full object-cover border border-gray-200 shrink-0">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 font-bold flex items-center justify-center border border-blue-100 shrink-0 uppercase text-xs">
                                                {{ substr($item->nama, 0, 2) }}
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.guru.edit', $item->id) }}" class="font-bold text-gray-800 hover:text-blue-600 transition-colors">
                                                {{ $item->nama }}
                                            </a>
                                            <div class="flex flex-wrap items-center gap-2 text-[11px] text-gray-400 mt-0.5">
                                                @if($item->nip)
                                                    <span>NIP: {{ $item->nip }}</span>
                                                @endif
                                                @if($item->nuptk)
                                                    <span>NUPTK: {{ $item->nuptk }}</span>
                                                @endif
                                                @if(!$item->nip && !$item->nuptk)
                                                    <span>-</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                        {{ $item->jabatan }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col gap-0.5">
                                        <div class="font-medium text-gray-700">
                                            @if($item->jenis_kelamin === 'L')
                                                <span class="text-blue-600 font-semibold"><i class="fa-solid fa-mars mr-1"></i>Laki-laki</span>
                                            @elseif($item->jenis_kelamin === 'P')
                                                <span class="text-pink-600 font-semibold"><i class="fa-solid fa-venus mr-1"></i>Perempuan</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-gray-400">
                                            {{ $item->agama ?: '-' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 max-w-xs">
                                    @if($item->alamat)
                                        <div class="text-gray-600 text-[11px] truncate flex items-center gap-1.5" title="{{ $item->alamat }}">
                                            <i class="fa-solid fa-location-dot text-gray-400 text-[10px] shrink-0"></i>
                                            <span class="truncate">{{ Str::limit($item->alamat, 28) }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center gap-2 mt-1">
                                        @if($item->whatsapp)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->whatsapp) }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 text-xs" title="WhatsApp: {{ $item->whatsapp }}">
                                                <i class="fa-brands fa-whatsapp"></i>
                                            </a>
                                        @endif
                                        @if($item->instagram)
                                            <a href="https://instagram.com/{{ ltrim($item->instagram, '@') }}" target="_blank" class="text-pink-600 hover:text-pink-700 text-xs" title="Instagram: {{ $item->instagram }}">
                                                <i class="fa-brands fa-instagram"></i>
                                            </a>
                                        @endif
                                        @if($item->facebook)
                                            <a href="{{ str_starts_with($item->facebook, 'http') ? $item->facebook : 'https://facebook.com/' . $item->facebook }}" target="_blank" class="text-blue-600 hover:text-blue-700 text-xs" title="Facebook: {{ $item->facebook }}">
                                                <i class="fa-brands fa-facebook"></i>
                                            </a>
                                        @endif
                                        @if(!$item->alamat && !$item->whatsapp && !$item->instagram && !$item->facebook)
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @if ($item->aktif)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <i class="fa-solid fa-circle-check text-[9px]"></i> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-600 border border-red-200">
                                            <i class="fa-solid fa-circle-xmark text-[9px]"></i> Non-Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.guru.edit', $item->id) }}" 
                                            class="w-7 h-7 flex items-center justify-center rounded-lg text-amber-600 hover:bg-amber-50 transition-colors"
                                            title="Edit Data Guru">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form id="delete-form-{{ $item->id }}" 
                                            action="{{ route('admin.guru.destroy', $item->id) }}" 
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                onclick="confirmDelete(event, 'delete-form-{{ $item->id }}')"
                                                class="w-7 h-7 flex items-center justify-center rounded-lg text-red-600 hover:bg-red-50 transition-colors"
                                                title="Hapus Guru">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center text-2xl mb-3 border border-gray-100">
                                            <i class="fa-solid fa-chalkboard-user"></i>
                                        </div>
                                        <p class="font-semibold text-gray-700 text-sm">Belum Ada Data Guru</p>
                                        <p class="text-xs text-gray-400 mt-1 max-w-sm">Mulai kelola data pendidik dan tenaga kependidikan untuk melengkapi profil sekolah.</p>
                                        <a href="{{ route('admin.guru.create') }}" 
                                            class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold flex items-center gap-2 shadow-xs transition-colors">
                                            <i class="fa-solid fa-plus"></i> Tambah Guru Sekarang
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
                <div class="p-4 border-t border-gray-100 bg-gray-50/30">
                    {{ $data->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
