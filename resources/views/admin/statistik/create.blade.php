<x-app-layout>
    <x-slot name="header">
        Manajemen Statistik
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800">Form Tambah Statistik</h3>
                <p class="text-sm text-gray-500 mt-1">Lengkapi informasi di bawah ini untuk menambahkan data statistik baru.</p>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.statistik.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Nama Statistik -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama">Nama Statistik <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" id="nama" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Contoh: Jumlah Siswa Aktif" value="{{ old('nama') }}" required>
                        </div>

                        <!-- Nilai / Value -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="value">Nilai (Value) <span class="text-red-500">*</span></label>
                            <input type="text" name="value" id="value" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Contoh: 1500+" value="{{ old('value') }}" required>
                        </div>
                    </div>

                    <!-- Icon (Font Awesome) -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="icon">Ikon (Class Font Awesome)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-icons text-gray-400"></i>
                            </div>
                            <input type="text" name="icon" id="icon" 
                                class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors font-mono" 
                                placeholder="fas fa-users" value="{{ old('icon') }}">
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Cari ikon di <a href="https://fontawesome.com/search?o=r&m=free" target="_blank" class="text-blue-600 hover:underline">FontAwesome Free</a> dan masukkan nama kelasnya (misal: <code>fas fa-users</code> atau <code>fas fa-book</code>).</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <!-- Tombol Batal (Blue Text) -->
                        <a href="{{ route('admin.statistik.index') }}" 
                            class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            Batal
                        </a>
                        
                        <!-- Tombol Simpan (Success / Green) -->
                        <button type="submit" 
                            class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Statistik
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
