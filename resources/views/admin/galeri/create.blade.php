<x-app-layout>
    <x-slot name="header">
        Manajemen Galeri
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <script>
            // Preview Image Script
            function previewImage(input) {
                const previewContainer = document.getElementById('image_preview_container');
                const previewImg = document.getElementById('image_preview');
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    if (!previewImg.src || previewImg.src === window.location.href) {
                        previewContainer.classList.add('hidden');
                    }
                }
            }

            function removeImage() {
                const previewContainer = document.getElementById('image_preview_container');
                const previewImg = document.getElementById('image_preview');
                const fileInput = document.getElementById('foto');

                previewContainer.classList.add('hidden');
                previewImg.src = '';
                fileInput.value = '';
            }
        </script>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800">Form Tambah Galeri</h3>
                <p class="text-sm text-gray-500 mt-1">Tambahkan foto baru ke dalam galeri sekolah.</p>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6">
                        <!-- Judul -->
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="judul">Judul / Keterangan Foto <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" id="judul" 
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                            placeholder="Contoh: Kegiatan Upacara Bendera HUT RI ke-79" value="{{ old('judul') }}" required>
                    </div>

                    <!-- Foto -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="foto">Pilih Foto <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex items-start gap-4 flex-col sm:flex-row">
                            <div id="image_preview_container" class="shrink-0 relative group hidden">
                                <img id="image_preview" class="h-32 w-48 object-cover rounded-lg border border-gray-200 bg-gray-50" src="" alt="Preview">
                                <button type="button" onclick="removeImage()" class="absolute top-1 right-1 bg-white text-red-600 hover:text-red-700 hover:bg-red-50 rounded p-1.5 shadow-md border border-red-100 focus:outline-none transition-all" title="Hapus Gambar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                            <div class="flex-1 mt-2">
                                <input type="file" name="foto" id="foto" accept="image/*" onchange="previewImage(this)" required
                                    class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100 transition-colors cursor-pointer">
                                <p class="mt-2 text-xs text-gray-500">Foto lanskap (landscape) disarankan. Maksimal 5MB. Format: JPG, PNG.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <!-- Tombol Batal (Blue Text) -->
                        <a href="{{ route('admin.galeri.index') }}" 
                            class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            Batal
                        </a>
                        
                        <!-- Tombol Simpan (Success / Green) -->
                        <button type="submit" 
                            class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Unggah Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
