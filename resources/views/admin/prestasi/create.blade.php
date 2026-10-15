<x-app-layout>
    <x-slot name="header">
        Manajemen Prestasi
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <script>
            // Preview Multiple Images Script
            function previewImages(event) {
                const previewContainer = document.getElementById('image_preview_container');
                previewContainer.innerHTML = ''; // Clear existing
                
                if(event.target.files) {
                    Array.from(event.target.files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e){
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'h-24 w-32 object-cover rounded-lg border border-gray-200 bg-gray-50';
                            previewContainer.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            }
        </script>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800">Form Tambah Prestasi</h3>
                <p class="text-sm text-gray-500 mt-1">Lengkapi informasi di bawah ini untuk mencatat prestasi baru.</p>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.prestasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Nama Kegiatan -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_kegiatan">Nama Kegiatan <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Contoh: Olimpiade Sains Nasional" value="{{ old('nama_kegiatan') }}" required>
                        </div>
                        
                        <!-- Hasil -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="hasil">Hasil (Peringkat/Medali) <span class="text-red-500">*</span></label>
                            <input type="text" name="hasil" id="hasil" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Contoh: Juara 1 / Medali Emas" value="{{ old('hasil') }}" required>
                        </div>

                        <!-- Tahun -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="tahun">Tahun <span class="text-red-500">*</span></label>
                            <input type="number" name="tahun" id="tahun" min="2000" max="2100"
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Contoh: 2026" value="{{ old('tahun', date('Y')) }}" required>
                        </div>
                        
                        <!-- Tipe -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="tipe">Tingkat Prestasi <span class="text-red-500">*</span></label>
                            <select name="tipe" id="tipe" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors bg-white" required>
                                <option value="" disabled selected>Pilih Tingkat...</option>
                                <option value="sekolah" {{ (old('tipe') == 'sekolah') ? 'selected' : '' }}>Tingkat Sekolah</option>
                                <option value="daerah" {{ (old('tipe') == 'daerah') ? 'selected' : '' }}>Tingkat Daerah / Provinsi</option>
                                <option value="nasional" {{ (old('tipe') == 'nasional') ? 'selected' : '' }}>Tingkat Nasional</option>
                                <option value="internasional" {{ (old('tipe') == 'internasional') ? 'selected' : '' }}>Tingkat Internasional</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dokumentasi -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="dokumentasi">Dokumentasi (Opsional, Maksimal 3 Foto)</label>
                        <div class="mt-1 flex flex-col gap-4">
                            <div class="flex-1">
                                <input type="file" name="dokumentasi[]" id="dokumentasi" multiple accept="image/*" onchange="previewImages(event)"
                                    class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100 transition-colors cursor-pointer">
                                <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG. Bisa memilih lebih dari 1 foto sekaligus.</p>
                            </div>
                            <!-- Image Preview Container -->
                            <div id="image_preview_container" class="flex flex-wrap gap-3">
                                <!-- Previews will be injected here via JS -->
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <!-- Tombol Batal (Blue Text) -->
                        <a href="{{ route('admin.prestasi.index') }}" 
                            class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            Batal
                        </a>
                        
                        <!-- Tombol Simpan (Success / Green) -->
                        <button type="submit" 
                            class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Prestasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
