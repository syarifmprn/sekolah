<x-app-layout>
    <x-slot name="header">
        Manajemen Pengguna (User)
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800">Edit Data Pengguna</h3>
                <p class="text-sm text-gray-500 mt-1">Lakukan perubahan pada informasi profil, peran, atau kata sandi pengguna di bawah ini.</p>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="name">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Contoh: Budi Santoso" value="{{ old('name', $user->name) }}" required>
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="email">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Contoh: budi@sekolah.sch.id" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <!-- Role / Hak Akses -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="role">Role / Hak Akses <span class="text-red-500">*</span></label>
                            <select name="role" id="role" required
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors bg-white">
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Hak Akses Menu Dapat Diatur)</option>
                                <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Superadmin (Akses Penuh Semua Fitur)</option>
                            </select>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="password">Kata Sandi (Password Baru)</label>
                            <input type="password" name="password" id="password" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Kosongkan jika tidak ingin mengubah sandi">
                            <p class="mt-2 text-xs text-gray-500">Isi bagian ini HANYA JIKA Anda ingin mengganti kata sandi lama.</p>
                        </div>
                    </div>

                    <!-- Section Hak Akses Modul / Permissions (Hanya untuk Admin) -->
                    <div id="permissions-container" class="mb-8 border border-blue-100 bg-blue-50/40 rounded-xl p-5 transition-all">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-4 border-b border-blue-100 gap-2">
                            <div>
                                <h4 class="text-base font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fa-solid fa-shield-halved text-blue-600"></i>
                                    Pengaturan Hak Akses Menu & Modul (Admin Panel)
                                </h4>
                                <p class="text-xs text-gray-500 mt-0.5">Pilih menu dan fitur apa saja yang dapat dilihat serta dikelola (Create, Read, Update, Delete) oleh Admin ini.</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <label class="inline-flex items-center cursor-pointer text-xs font-semibold text-blue-700 bg-white hover:bg-blue-50 border border-blue-200 px-3 py-1.5 rounded-lg transition-colors select-none shadow-xs">
                                    <input type="checkbox" id="check-all-permissions" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 mr-2">
                                    Pilih Semua Menu
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
                            @php
                                $userPerms = is_array($user->permissions) ? $user->permissions : [];
                            @endphp
                            @foreach($modules as $slug => $module)
                                <label class="relative flex items-start p-3 bg-white border border-gray-200 rounded-xl hover:border-blue-400 hover:shadow-xs transition-all cursor-pointer group">
                                    <div class="flex items-center h-5 mt-0.5">
                                        <input type="checkbox" name="permissions[]" value="{{ $slug }}"
                                            {{ in_array($slug, old('permissions', $userPerms)) ? 'checked' : '' }}
                                            class="permission-checkbox w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    </div>
                                    <div class="ml-3 text-sm flex-1">
                                        <div class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors flex items-center gap-1.5">
                                            <i class="fa-solid {{ $module['icon'] ?? 'fa-folder' }} text-blue-500 text-xs w-4 text-center"></i>
                                            {{ $module['label'] }}
                                        </div>
                                        <p class="text-xs text-gray-500 mt-0.5 leading-snug">{{ $module['desc'] }}</p>
                                        <span class="inline-block mt-1 text-[10px] font-medium text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-100">
                                            Akses Lihat & CRUD
                                        </span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        
                        @error('permissions')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <!-- Tombol Batal (Blue Text) -->
                        <a href="{{ route('admin.user.index') }}" 
                            class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            Batal
                        </a>
                        
                        <!-- Tombol Simpan (Success / Green) -->
                        <button type="submit" 
                            class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const roleSelect = document.getElementById('role');
                const permContainer = document.getElementById('permissions-container');
                const checkAll = document.getElementById('check-all-permissions');
                const checkboxes = document.querySelectorAll('.permission-checkbox');

                function togglePermissions() {
                    if (roleSelect && roleSelect.value === 'admin') {
                        permContainer.classList.remove('hidden');
                    } else if (permContainer) {
                        permContainer.classList.add('hidden');
                    }
                }

                function updateCheckAll() {
                    if (checkboxes.length === 0 || !checkAll) return;
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                    const someChecked = Array.from(checkboxes).some(cb => cb.checked);
                    checkAll.checked = allChecked;
                    checkAll.indeterminate = !allChecked && someChecked;
                }

                if (roleSelect) {
                    roleSelect.addEventListener('change', togglePermissions);
                    togglePermissions();
                }

                if (checkAll) {
                    checkAll.addEventListener('change', function () {
                        checkboxes.forEach(cb => cb.checked = checkAll.checked);
                    });
                }

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', updateCheckAll);
                });

                updateCheckAll();
            });
        </script>
    </x-slot>
</x-app-layout>
