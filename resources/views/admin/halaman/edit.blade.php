<x-app-layout>
    <x-slot name="header">
        Manajemen Halaman Statis
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector: '#isi_halaman',
                height: 400,
                menubar: false,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                'bold italic forecolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'image media link | removeformat | help',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                promotion: false
            });

            // Preview Image Script
            function previewImage(input) {
                const previewContainer = document.getElementById('image_preview_container');
                const previewImg = document.getElementById('image_preview');
                const removeInput = document.getElementById('remove_image');
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                        if (removeInput) removeInput.value = '0';
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
                const fileInput = document.getElementById('thumbnail');
                const removeInput = document.getElementById('remove_image');

                previewContainer.classList.add('hidden');
                previewImg.src = '';
                fileInput.value = '';
                if (removeInput) removeInput.value = '1';
            }
            
            // Generate Slug from Judul
            function generateSlug() {
                const title = document.getElementById('judul').value;
                const slug = title.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/[\s-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                document.getElementById('slug').value = slug;
            }
        </script>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800">Edit Halaman</h3>
                <p class="text-sm text-gray-500 mt-1">Lakukan perubahan pada informasi halaman statis di bawah ini.</p>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.halaman.update', $halaman->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Judul -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="judul">Judul Halaman <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" id="judul" onkeyup="generateSlug()"
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Contoh: Visi dan Misi" value="{{ old('judul', $halaman->judul) }}" required>
                        </div>

                        <!-- Slug -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="slug">URL Slug <span class="text-red-500">*</span></label>
                            <input type="text" name="slug" id="slug" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors bg-gray-50" 
                                placeholder="visi-dan-misi" value="{{ old('slug', $halaman->slug) }}" required>
                        </div>
                        
                        <!-- Tanggal -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="tanggal">Tanggal Dibuat <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                value="{{ old('tanggal', $halaman->tanggal) }}" required>
                        </div>
                    </div>

                    <!-- Isi Halaman (TinyMCE) -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="isi_halaman">Isi Halaman <span class="text-red-500">*</span></label>
                        <textarea name="isi" id="isi_halaman">{{ old('isi', $halaman->isi) }}</textarea>
                    </div>

                    <!-- Thumbnail -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="thumbnail">Gambar / Banner Halaman (Opsional)</label>
                        <div class="mt-1 flex items-center gap-6">
                            <input type="hidden" name="remove_image" id="remove_image" value="0">
                            <div id="image_preview_container" class="shrink-0 relative group {{ $halaman->thumbnail ? '' : 'hidden' }}">
                                <img id="image_preview" class="h-32 w-48 object-cover rounded-lg border border-gray-200 bg-gray-50" src="{{ $halaman->thumbnail ? (str_starts_with($halaman->thumbnail, 'http') ? $halaman->thumbnail : asset('storage/' . $halaman->thumbnail)) : '' }}" alt="Preview">
                                <button type="button" onclick="removeImage()" class="absolute top-1 right-1 bg-white text-red-600 hover:text-red-700 hover:bg-red-50 rounded p-1.5 shadow-md border border-red-100 focus:outline-none transition-all" title="Hapus Gambar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                            <div class="flex-1">
                                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" onchange="previewImage(this)"
                                    class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100 transition-colors cursor-pointer">
                                <p class="mt-2 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah gambar. Maksimal 2MB. Format: JPG, PNG.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <!-- Tombol Batal (Blue Text) -->
                        <a href="{{ route('admin.halaman.index') }}" 
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
