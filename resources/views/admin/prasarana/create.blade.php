<x-app-layout>
    <x-slot name="header">
        Tambah Prasarana
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <!-- Header Card -->
            <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Form Tambah Prasarana Baru</h3>
                    <p class="text-xs text-gray-500 mt-1">Lengkapi informasi fisik gedung, ruang kelas, laboratorium, atau aula sekolah.</p>
                </div>
                <a href="{{ route('admin.prasarana.index') }}" 
                    class="px-3.5 py-2 text-xs font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

            <!-- Form -->
            <div class="p-6">
                <form action="{{ route('admin.prasarana.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Nama Prasarana -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 mb-2" for="nama">
                                    Nama Prasarana / Ruangan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama" id="nama" 
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                    placeholder="Contoh: Laboratorium Komputer 1, Aula Utama, Ruang Guru" 
                                    value="{{ old('nama') }}" required>
                                @error('nama') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Jumlah Unit -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2" for="jumlah">
                                    Jumlah Unit / Ruang <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="jumlah" id="jumlah" min="1" 
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                    value="{{ old('jumlah', 1) }}" required>
                                @error('jumlah') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Luas (m²) -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2" for="luas">
                                    Luas (m²)
                                </label>
                                <input type="number" step="0.01" name="luas" id="luas" min="0" 
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                    placeholder="Contoh: 72.50" value="{{ old('luas') }}">
                                <p class="text-[10px] text-gray-400 mt-1">Masukkan ukuran luas dalam satuan meter persegi (m²).</p>
                                @error('luas') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Kondisi -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2" for="kondisi">
                                    Kondisi Prasarana <span class="text-red-500">*</span>
                                </label>
                                <select name="kondisi" id="kondisi" required
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors bg-white">
                                    @foreach($kondisiList as $key => $label)
                                        <option value="{{ $key }}" {{ old('kondisi', 'baik') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('kondisi') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Foto Ruangan / Gedung -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2" for="foto">
                                    Foto Dokumentasi Prasarana
                                </label>
                                <input type="file" name="foto" id="foto" accept="image/*" 
                                    class="w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-[10px] text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                                @error('foto') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Preview Foto Box -->
                            <div class="md:col-span-2" id="preview-container" style="display: none;">
                                <span class="block text-xs font-semibold text-gray-700 mb-2">Pratinjau Foto:</span>
                                <div class="w-32 h-24 rounded-xl border border-gray-200 overflow-hidden bg-gray-50 shadow-2xs">
                                    <img id="image-preview" src="" class="w-full h-full object-cover">
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 mb-2" for="keterangan">
                                    Keterangan / Catatan Tambahan
                                </label>
                                <textarea name="keterangan" id="keterangan" rows="3" 
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                    placeholder="Contoh: Dilengkapi AC 2 unit, proyektor, dan lantai keramik baru...">{{ old('keterangan') }}</textarea>
                                @error('keterangan') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 mt-8 border-t border-gray-100">
                        <a href="{{ route('admin.prasarana.index') }}" 
                            class="text-xs font-semibold text-gray-500 hover:text-gray-700 transition-colors">
                            Batal
                        </a>
                        
                        <button type="submit" 
                            class="px-6 py-2.5 text-xs font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-colors flex items-center gap-2 shadow-xs">
                            <i class="fa-solid fa-check"></i>
                            Simpan Prasarana
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.getElementById('foto').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewContainer = document.getElementById('preview-container');
                const imagePreview = document.getElementById('image-preview');
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        imagePreview.src = event.target.result;
                        previewContainer.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.style.display = 'none';
                    imagePreview.src = '';
                }
            });
        </script>
    </x-slot>
</x-app-layout>
