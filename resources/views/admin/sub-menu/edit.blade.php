<x-app-layout>
    <x-slot name="header">
        Manajemen Sub Menu
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800">Edit Data Sub Menu</h3>
                <p class="text-sm text-gray-500 mt-1">Lakukan perubahan pada informasi sub menu navigasi di bawah ini.</p>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.sub-menu.update', $subMenu->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Induk Menu -->
                        <div class="md:col-span-2 max-w-md">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="menu_id">Pilih Menu Utama (Induk) <span class="text-red-500">*</span></label>
                            <select name="menu_id" id="menu_id" required
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors bg-white">
                                <option value="" disabled>-- Pilih Menu Utama --</option>
                                @foreach($menus as $menu)
                                    <option value="{{ $menu->id }}" {{ old('menu_id', $subMenu->menu_id) == $menu->id ? 'selected' : '' }}>
                                        {{ $menu->nama_menu }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Sub Menu -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_menu">Nama Sub Menu <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_menu" id="nama_menu" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Contoh: Sejarah Singkat" value="{{ old('nama_menu', $subMenu->nama_menu) }}" required>
                        </div>
                        
                        <!-- Link -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="link">URL / Link Target <span class="text-red-500">*</span></label>
                            <input type="text" name="link" id="link" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors font-mono" 
                                placeholder="Contoh: /sejarah-singkat atau https://..." value="{{ old('link', $subMenu->link) }}" required>
                            <p class="mt-2 text-xs text-gray-500">Gunakan garis miring (/) untuk rute internal, atau awali dengan http(s):// untuk tautan luar.</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <!-- Tombol Batal (Blue Text) -->
                        <a href="{{ route('admin.sub-menu.index') }}" 
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
</x-app-layout>
