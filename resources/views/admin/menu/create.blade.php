<x-app-layout>
    <x-slot name="header">
        Manajemen Menu
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800">Form Tambah Menu</h3>
                <p class="text-sm text-gray-500 mt-1">Tambahkan menu navigasi utama baru untuk pengunjung situs.</p>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.menu.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Nama Menu -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_menu">Nama Menu <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_menu" id="nama_menu" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Contoh: Tentang Kami" value="{{ old('nama_menu') }}" required>
                        </div>
                        
                        <!-- Link -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="link">URL / Link Target <span class="text-red-500">*</span></label>
                            <input type="text" name="link" id="link" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors font-mono" 
                                placeholder="Contoh: /tentang-kami atau #" value="{{ old('link') }}" required>
                            <p class="mt-2 text-xs text-gray-500">
                                Gunakan garis miring (/) untuk rute internal, atau awali dengan http(s):// untuk tautan luar.<br>
                                <strong class="text-amber-600">Penting:</strong> Apabila menu ini akan memiliki Sub Menu, isi link dengan <code class="bg-amber-50 px-1 py-0.5 rounded text-amber-700">#</code> agar *dropdown* Sub Menu bisa tampil.
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <!-- Tombol Batal (Blue Text) -->
                        <a href="{{ route('admin.menu.index') }}" 
                            class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            Batal
                        </a>
                        
                        <!-- Tombol Simpan (Success / Green) -->
                        <button type="submit" 
                            class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
