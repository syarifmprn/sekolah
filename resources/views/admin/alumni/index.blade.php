<x-app-layout>
    <x-slot name="header">
        Manajemen Data Alumni & Testimoni
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

    <div class="p-4 sm:p-6 min-h-full flex flex-col gap-4 sm:gap-6">
        <!-- Flash Message -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-xl shadow-xs flex items-center justify-between" role="alert">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-green-500 text-lg"></i>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Quick Summary Cards (2 Cols on Mobile, 4 Cols on Desktop) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <div class="bg-white p-3.5 sm:p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg sm:text-xl shrink-0">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-[10px] sm:text-xs font-semibold text-gray-400 uppercase tracking-wider block truncate">Total Alumni</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['total_alumni'] ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white p-3.5 sm:p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg sm:text-xl shrink-0">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-[10px] sm:text-xs font-semibold text-gray-400 uppercase tracking-wider block truncate">Publik</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['total_tampil'] ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white p-3.5 sm:p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg sm:text-xl shrink-0">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-[10px] sm:text-xs font-semibold text-gray-400 uppercase tracking-wider block truncate">Total Angkatan</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['total_angkatan'] ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white p-3.5 sm:p-5 rounded-2xl border border-gray-100 shadow-xs flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg sm:text-xl shrink-0">
                    <i class="fa-solid fa-comment-dots"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-[10px] sm:text-xs font-semibold text-gray-400 uppercase tracking-wider block truncate">Total Testimoni</span>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['total_testimoni'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
            
            <!-- Toolbar & Filter -->
            <div class="p-4 sm:p-5 border-b border-gray-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-800">Daftar Alumni</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Kelola data alumni sekolah, profesi terkini, dan testimoni untuk website publik.</p>
                </div>

                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                    <form action="{{ route('admin.alumni.index') }}" method="GET" class="flex flex-wrap items-center gap-2 w-full lg:w-auto">
                        <!-- Search -->
                        <div class="relative flex-1 sm:flex-initial">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Cari nama, pekerjaan, kampus..." 
                                class="pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500 w-full sm:w-56">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                            </div>
                        </div>

                        <!-- Filter Tahun Lulus -->
                        <select name="tahun_lulus" onchange="this.form.submit()" 
                            class="py-2 pl-3 pr-8 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">Semua Angkatan</option>
                            @foreach ($tahunList as $thn)
                                <option value="{{ $thn }}" {{ request('tahun_lulus') == $thn ? 'selected' : '' }}>
                                    Lulus {{ $thn }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Filter Jurusan -->
                        @if($jurusanList->count() > 0)
                        <select name="jurusan" onchange="this.form.submit()" 
                            class="py-2 pl-3 pr-8 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">Semua Jurusan</option>
                            @foreach ($jurusanList as $jur)
                                <option value="{{ $jur }}" {{ request('jurusan') == $jur ? 'selected' : '' }}>
                                    {{ $jur }}
                                </option>
                            @endforeach
                        </select>
                        @endif

                        <!-- Filter Status Tampil -->
                        <select name="tampil" onchange="this.form.submit()" 
                            class="py-2 pl-3 pr-8 border border-gray-200 rounded-lg text-xs focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">Semua Status</option>
                            <option value="ya" {{ request('tampil') == 'ya' ? 'selected' : '' }}>Publik</option>
                            <option value="tidak" {{ request('tampil') == 'tidak' ? 'selected' : '' }}>Private</option>
                        </select>

                        @if(request()->anyFilled(['search', 'tahun_lulus', 'jurusan', 'tampil']))
                            <a href="{{ route('admin.alumni.index') }}" class="p-2 text-gray-400 hover:text-gray-600 transition-colors" title="Reset Filter">
                                <i class="fa-solid fa-rotate-left text-xs"></i>
                            </a>
                        @endif
                    </form>

                    <a href="{{ route('admin.alumni.create') }}" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold flex items-center justify-center gap-2 shadow-xs transition-colors w-full sm:w-auto">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Alumni
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto w-full">
                <table class="table-fit w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50 text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                            <th class="py-3 px-1.5 sm:px-4 w-7 sm:w-12 text-center">No</th>
                            <th class="py-3 px-2 sm:px-4">Alumni</th>
                            <th class="py-3 px-4 hidden md:table-cell">Angkatan & Jurusan</th>
                            <th class="py-3 px-4 hidden lg:table-cell">Profesi / Instansi</th>
                            <th class="py-3 px-4 hidden xl:table-cell">Testimoni</th>
                            <th class="py-3 px-1.5 sm:px-4 text-center whitespace-nowrap"><span class="hidden sm:inline">Tampil di Web</span><span class="sm:hidden">Status</span></th>
                            <th class="py-3 px-1.5 sm:px-4 text-center w-20 sm:w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse ($data as $index => $item)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="py-3 px-1.5 sm:px-4 text-center font-medium text-gray-400 text-[11px] sm:text-xs">
                                    {{ $data->firstItem() + $index }}
                                </td>
                                <td class="py-3 px-2 sm:px-4">
                                    <div class="flex items-center gap-2 sm:gap-3">
                                        @if ($item->foto)
                                            <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}" 
                                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover border border-gray-200 shrink-0">
                                        @else
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blue-50 text-blue-600 font-bold flex items-center justify-center border border-blue-100 shrink-0 uppercase text-[11px] sm:text-xs">
                                                {{ strtoupper(substr($item->nama ?? 'A', 0, 2)) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <a href="{{ route('admin.alumni.show', $item->id) }}" class="font-bold text-gray-800 hover:text-blue-600 transition-colors text-xs sm:text-sm block truncate max-w-[110px] xs:max-w-[150px] sm:max-w-none">
                                                {{ $item->nama }}
                                            </a>
                                            
                                            <!-- Sub-info for Mobile Only (< md) -->
                                            <div class="md:hidden flex flex-col gap-0.5 mt-0.5">
                                                <div class="flex items-center gap-1 flex-wrap">
                                                    <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                                        Lulus {{ $item->tahun_lulus }}
                                                    </span>
                                                    @if($item->jurusan)
                                                        <span class="text-[9px] text-gray-500 font-medium">
                                                            {{ $item->jurusan }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-[9px] text-gray-500 truncate max-w-[120px] xs:max-w-[160px]">
                                                    {{ $item->pekerjaan }} &bull; {{ $item->instansi }}
                                                </div>
                                            </div>

                                            <!-- Contact info for Desktop (>= md) -->
                                            <div class="hidden md:flex items-center gap-2 text-[11px] text-gray-400 mt-0.5">
                                                @if($item->email)
                                                    <span title="{{ $item->email }}"><i class="fa-solid fa-envelope mr-1"></i>{{ Str::limit($item->email, 18) }}</span>
                                                @endif
                                                @if($item->no_hp)
                                                    <span title="{{ $item->no_hp }}"><i class="fa-solid fa-phone mr-1"></i>{{ $item->no_hp }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 hidden md:table-cell">
                                    <div class="flex flex-col gap-1 items-start">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                             Lulus {{ $item->tahun_lulus }}
                                        </span>
                                        <span class="text-gray-600 font-medium text-[11px]">
                                            {{ $item->jurusan ?: '-' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 hidden lg:table-cell">
                                    <div class="font-semibold text-gray-800">{{ $item->pekerjaan }}</div>
                                    <div class="text-[11px] text-gray-500">{{ $item->instansi }}</div>
                                    @if($item->alamat)
                                        <div class="text-[10px] text-gray-400 mt-0.5"><i class="fa-solid fa-location-dot mr-1"></i>{{ $item->alamat }}</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 max-w-xs hidden xl:table-cell">
                                    <p class="text-gray-600 italic line-clamp-2 text-[11px]">
                                        "{{ $item->testimoni }}"
                                    </p>
                                </td>
                                <td class="py-3 px-1.5 sm:px-4 text-center">
                                    <form action="{{ route('admin.alumni.toggle-tampil', $item->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                            class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1 rounded-full text-[10px] sm:text-[11px] font-bold transition-all shadow-xs cursor-pointer active:scale-95 {{ $item->tampil === 'ya' ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-300' }}" 
                                            title="Klik untuk ubah status ke {{ $item->tampil === 'ya' ? 'Private' : 'Publik' }}">
                                            @if ($item->tampil === 'ya')
                                                <i class="fa-solid fa-globe text-[9px] sm:text-[10px] text-emerald-500"></i>
                                                <span>Publik</span>
                                            @else
                                                <i class="fa-solid fa-lock text-[9px] sm:text-[10px] text-slate-500"></i>
                                                <span>Private</span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="py-3 px-1.5 sm:px-4 text-center">
                                    <div class="flex items-center justify-center gap-0.5 sm:gap-1">
                                        <a href="{{ route('admin.alumni.show', $item->id) }}" 
                                            class="w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition-colors"
                                            title="Lihat Profil">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                        <a href="{{ route('admin.alumni.edit', $item->id) }}" 
                                            class="w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center rounded-lg text-amber-600 hover:bg-amber-50 transition-colors"
                                            title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <form id="delete-form-{{ $item->id }}" 
                                             action="{{ route('admin.alumni.destroy', $item->id) }}" 
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                onclick="confirmDelete(event, 'delete-form-{{ $item->id }}')"
                                                class="w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center rounded-lg text-red-600 hover:bg-red-50 transition-colors"
                                                title="Hapus Alumni">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
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
                                            <i class="fa-solid fa-user-graduate"></i>
                                        </div>
                                        <p class="font-semibold text-gray-700 text-sm">Belum Ada Data Alumni</p>
                                        <p class="text-xs text-gray-400 mt-1 max-w-sm">Mulai kumpulkan profil dan testimoni alumni berprestasi untuk menginspirasi siswa.</p>
                                        <a href="{{ route('admin.alumni.create') }}" 
                                            class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold flex items-center gap-2 shadow-xs transition-colors">
                                            <i class="fa-solid fa-plus"></i> Tambah Alumni Sekarang
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
