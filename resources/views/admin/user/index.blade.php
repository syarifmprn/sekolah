<x-app-layout>
    <x-slot name="header">
        Manajemen Pengguna (User)
    </x-slot>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(e, formId) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(formId).submit();
                    }
                })
            }
        </script>
    </x-slot>

    <div class="p-6 h-full">
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm" role="alert">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg shadow-sm" role="alert">
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Card Container -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full max-h-full">
            
            <!-- Card Header -->
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h3 class="text-xl font-bold text-gray-800">Daftar Pengguna Sistem</h3>
                
                <div class="flex items-center gap-4">
                    <!-- Search Form -->
                    <form action="{{ route('admin.user.index') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau role..." class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </form>

                    <!-- Tombol Tambah Biru -->
                    <a href="{{ route('admin.user.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors focus:ring-4 focus:ring-blue-200">
                        <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah
                    </a>
                </div>
            </div>

            <!-- Card Body / Table (Responsive & Scrollable) -->
            <div class="flex-1 overflow-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50/50 text-gray-500 sticky top-0 uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th class="px-6 py-4 border-b border-gray-100">Nama Lengkap</th>
                            <th class="px-6 py-4 border-b border-gray-100">Email</th>
                            <th class="px-6 py-4 border-b border-gray-100">Role & Hak Akses Menu</th>
                            <th class="px-6 py-4 border-b border-gray-100 text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($data as $row)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-gray-800 font-medium">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3 border border-blue-200">
                                        {{ strtoupper(substr($row->name, 0, 1)) }}
                                    </div>
                                    {{ $row->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $row->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if($row->role === 'superadmin')
                                    <div class="inline-flex flex-col gap-1 items-start">
                                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 font-bold rounded-md text-xs border border-indigo-200 uppercase tracking-wide flex items-center gap-1.5">
                                            <i class="fa-solid fa-crown text-[10px] text-amber-500"></i>
                                            Superadmin
                                        </span>
                                        <span class="text-[11px] text-gray-500">Akses Penuh Semua Modul</span>
                                    </div>
                                @else
                                    <div class="flex flex-col gap-1.5 items-start">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 font-bold rounded-md text-xs border border-blue-200 uppercase tracking-wide">
                                                Admin
                                            </span>
                                            @php
                                                $permCount = is_array($row->permissions) ? count($row->permissions) : 0;
                                                $totalModules = count($modules);
                                            @endphp
                                            @if($permCount >= $totalModules)
                                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[11px] font-semibold rounded-full border border-emerald-200">
                                                    Semua Menu ({{ $permCount }})
                                                </span>
                                            @elseif($permCount > 0)
                                                <span class="px-2 py-0.5 bg-sky-50 text-sky-700 text-[11px] font-semibold rounded-full border border-sky-200">
                                                    {{ $permCount }} Menu Diizinkan
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 bg-amber-50 text-amber-700 text-[11px] font-medium rounded-full border border-amber-200">
                                                    Belum Ada Akses
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if(is_array($row->permissions) && count($row->permissions) > 0)
                                            <div class="flex flex-wrap gap-1 max-w-md">
                                                @foreach(array_slice($row->permissions, 0, 4) as $permKey)
                                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-gray-100 text-gray-600 rounded text-[10px]">
                                                        <i class="fa-solid {{ $modules[$permKey]['icon'] ?? 'fa-check' }} text-[9px] text-blue-500"></i>
                                                        {{ $modules[$permKey]['label'] ?? $permKey }}
                                                    </span>
                                                @endforeach
                                                @if(count($row->permissions) > 4)
                                                    <span class="px-1.5 py-0.5 bg-gray-100 text-gray-500 rounded text-[10px] font-medium">
                                                        +{{ count($row->permissions) - 4 }} lainnya
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.user.edit', $row->id) }}" class="p-2 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form id="delete-form-{{ $row->id }}" action="{{ route('admin.user.destroy', $row->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(event, 'delete-form-{{ $row->id }}')" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <p>Belum ada data pengguna yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Card Footer / Pagination -->
            @if ($data->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
