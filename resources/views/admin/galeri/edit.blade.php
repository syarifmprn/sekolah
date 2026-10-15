<x-app-layout>
    <x-slot name="header">
        Manajemen Galeri
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <script>
            // Preview Image Script
            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function(){
                    const output = document.getElementById('image_preview');
                    output.src = reader.result;
                    output.classList.remove('hidden');
                };
                if(event.target.files[0]){
                    reader.readAsDataURL(event.target.files[0]);
                }
            }
        </script>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800">Edit Data Galeri</h3>
                <p class="text-sm text-gray-500 mt-1">Lakukan perubahan pada informasi foto di bawah ini.</p>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <!-- Judul -->
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="judul">Judul / Keterangan Foto <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" id="judul" 
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                            placeholder="Contoh: Kegiatan Upacara Bendera HUT RI ke-79" value="{{ old('judul', $galeri->judul) }}" required>
                    </div>

                    <!-- Foto -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="foto">Ubah Foto (Opsional)</label>
                        <div class="mt-1 flex items-start gap-4 flex-col sm:flex-row">
                            <div class="shrink-0">
                                @if($galeri->foto)
                                    <img id="image_preview" class="h-32 w-48 object-cover rounded-lg border-2 border-gray-200 bg-gray-50" src="{{ asset('storage/' . $galeri->foto) }}" alt="Preview">
                                @else
                                    <img id="image_preview" class="h-32 w-48 object-cover rounded-lg border-2 border-gray-200 hidden bg-gray-50" src="" alt="Preview">
                                @endif
                            </div>
                            <div class="flex-1 mt-2">
                                <input type="file" name="foto" id="foto" accept="image/*" onchange="previewImage(event)"
                                    class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100 transition-colors cursor-pointer">
                                <p class="mt-2 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah foto saat ini. Maksimal 5MB. Format: JPG, PNG.</p>
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
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
