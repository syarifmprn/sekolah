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

            // Bulk Actions Handler
            function updateBulkState() {
                const checkedBoxes = document.querySelectorAll('.alumni-checkbox:checked');
                const allCheckboxes = document.querySelectorAll('.alumni-checkbox');
                const count = checkedBoxes.length;
                const bulkActionBar = document.getElementById('bulk-action-bar');
                const bulkCountBadge = document.getElementById('bulk-count-badge');
                const bulkCountText = document.getElementById('bulk-count-text');
                const bulkAllInput = document.getElementById('bulk-all-input');
                const checkAll = document.getElementById('check-all');
                
                if (!bulkActionBar) return;

                if (count > 0) {
                    bulkActionBar.classList.remove('hidden');
                    bulkCountBadge.innerText = count;
                    bulkCountText.innerText = count;
                    bulkAllInput.value = '0';
                } else {
                    bulkActionBar.classList.add('hidden');
                    bulkAllInput.value = '0';
                }

                if (checkAll && allCheckboxes.length > 0) {
                    checkAll.checked = (count === allCheckboxes.length);
                    checkAll.indeterminate = (count > 0 && count < allCheckboxes.length);
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const checkAll = document.getElementById('check-all');
                const checkboxes = document.querySelectorAll('.alumni-checkbox');

                if (checkAll) {
                    checkAll.addEventListener('change', function () {
                        checkboxes.forEach(cb => {
                            cb.checked = checkAll.checked;
                        });
                        updateBulkState();
                    });
                }

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', updateBulkState);
                });
            });

            function clearAllSelections() {
                const checkAll = document.getElementById('check-all');
                const checkboxes = document.querySelectorAll('.alumni-checkbox');
                if (checkAll) {
                    checkAll.checked = false;
                    checkAll.indeterminate = false;
                }
                checkboxes.forEach(cb => {
                    cb.checked = false;
                });
                updateBulkState();
            }

            function selectAllAlumniInDb() {
                const checkAll = document.getElementById('check-all');
                const checkboxes = document.querySelectorAll('.alumni-checkbox');
                const bulkActionBar = document.getElementById('bulk-action-bar');
                const bulkCountBadge = document.getElementById('bulk-count-badge');
                const bulkCountText = document.getElementById('bulk-count-text');
                const bulkAllInput = document.getElementById('bulk-all-input');

                if (checkAll) checkAll.checked = true;
                checkboxes.forEach(cb => {
                    cb.checked = true;
                });
                if (bulkActionBar) {
                    bulkActionBar.classList.remove('hidden');
                    bulkCountBadge.innerText = '{{ $stats['total_alumni'] ?? 0 }}';
                    bulkCountText.innerText = 'Semua ({{ $stats['total_alumni'] ?? 0 }})';
                    bulkAllInput.value = '1';
                }
            }

            function submitBulkStatus(status, isAll = false) {
                const label = status === 'ya' ? 'Publik' : 'Private';
                const checkedCount = document.querySelectorAll('.alumni-checkbox:checked').length;
                const totalInDb = {{ $stats['total_alumni'] ?? 0 }};
                const bulkStatusInput = document.getElementById('bulk-status-input');
                const bulkAllInput = document.getElementById('bulk-all-input');
                const bulkForm = document.getElementById('bulk-status-form');

                if (!isAll && checkedCount === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Pilih Alumni',
                        text: 'Silakan centang setidaknya satu alumni terlebih dahulu.',
                        confirmButtonColor: '#3b82f6'
                    });
                    return;
                }

                bulkStatusInput.value = status;
                bulkAllInput.value = isAll ? '1' : '0';

                const countText = isAll ? `seluruh ${totalInDb}` : `${checkedCount}`;
                const titleText = isAll ? `Publikasikan Seluruh Alumni?` : `Jadikan ${label}?`;
                const descText = `Apakah Anda yakin ingin mengubah status ${countText} data alumni menjadi ${label}?`;

                Swal.fire({
                    title: titleText,
                    text: descText,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: status === 'ya' ? '#10b981' : '#64748b',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: `Ya, Ubah ke ${label}`,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        bulkForm.submit();
                    }
                });
            }

            function publishAllAlumniConfirm() {
                submitBulkStatus('ya', true);
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

                    <button type="button" onclick="publishAllAlumniConfirm()" 
                        class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold flex items-center justify-center gap-1.5 shadow-xs transition-colors w-full sm:w-auto cursor-pointer"
                        title="Publikasikan semua data alumni sekaligus">
                        <i class="fa-solid fa-globe"></i>
                        <span>Publikasikan Semua</span>
                    </button>

                    <a href="{{ route('admin.alumni.create') }}" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold flex items-center justify-center gap-2 shadow-xs transition-colors w-full sm:w-auto">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Alumni
                    </a>
                </div>
            </div>

            <!-- Form Bulk Action (Hidden Form) -->
            <form id="bulk-status-form" action="{{ route('admin.alumni.bulk-status') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="status" id="bulk-status-input" value="ya">
                <input type="hidden" name="all" id="bulk-all-input" value="0">
            </form>

            <!-- Bulk Action Interactive Bar -->
            <div id="bulk-action-bar" class="hidden px-4 sm:px-5 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100 flex flex-wrap items-center justify-between gap-3 text-xs transition-all">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full bg-blue-600 text-white font-bold text-[11px]" id="bulk-count-badge">0</span>
                    <span class="font-bold text-gray-800"><span id="bulk-count-text">0</span> alumni dipilih</span>
                    <span class="text-gray-300 hidden sm:inline">&bull;</span>
                    <button type="button" onclick="selectAllAlumniInDb()" class="text-blue-600 hover:text-blue-800 underline font-semibold cursor-pointer text-[11px] sm:text-xs">
                        Pilih Seluruh Alumni ({{ $stats['total_alumni'] ?? 0 }})
                    </button>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <button type="button" onclick="submitBulkStatus('ya', false)" 
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-xs active:scale-95 transition cursor-pointer text-[11px] sm:text-xs">
                        <i class="fa-solid fa-globe text-[10px]"></i>
                        <span>Jadikan Publik</span>
                    </button>
                    <button type="button" onclick="submitBulkStatus('tidak', false)" 
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-600 hover:bg-slate-700 text-white font-bold shadow-xs active:scale-95 transition cursor-pointer text-[11px] sm:text-xs">
                        <i class="fa-solid fa-lock text-[10px]"></i>
                        <span>Jadikan Private</span>
                    </button>
                    <button type="button" onclick="clearAllSelections()" 
                        class="px-2.5 py-1.5 text-gray-500 hover:text-gray-700 font-semibold hover:bg-white rounded-lg transition cursor-pointer text-[11px] sm:text-xs">
                        Batal
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto w-full">
                <table class="table-fit w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50 text-[10px] sm:text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                            <th class="py-3 px-2 sm:px-3 text-center w-7 sm:w-9">
                                <input type="checkbox" id="check-all" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer w-4 h-4" title="Pilih Semua di Halaman Ini">
                            </th>
                            <th class="py-3 px-1 sm:px-2 w-7 sm:w-10 text-center hidden xs:table-cell">No</th>
                            <th class="py-3 px-2 sm:px-4">Alumni</th>
                            <th class="py-3 px-4 hidden md:table-cell">Angkatan & Jurusan</th>
                            <th class="py-3 px-4 hidden lg:table-cell">Profesi / Instansi</th>
                            <th class="py-3 px-4 hidden xl:table-cell">Testimoni</th>
                            <th class="py-3 px-1.5 sm:px-4 text-center whitespace-nowrap">Status</th>
                            <th class="py-3 px-1.5 sm:px-4 text-center w-20 sm:w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse ($data as $index => $item)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="py-3 px-2 sm:px-3 text-center">
                                    <input type="checkbox" name="ids[]" value="{{ $item->id }}" form="bulk-status-form" class="alumni-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer w-4 h-4">
                                </td>
                                <td class="py-3 px-1 sm:px-2 text-center font-medium text-gray-400 text-[11px] sm:text-xs hidden xs:table-cell">
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
                                <td colspan="8" class="py-12 text-center">
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
