<x-app-layout>
    <x-slot name="header">
        Pengaturan Website Utama
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm" role="alert">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800">Form Identitas & Pengaturan Website</h3>
                <p class="text-sm text-gray-500 mt-1">Lengkapi informasi di bawah ini untuk ditampilkan pada halaman profil dan identitas sekolah.</p>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.pengaturan-website.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        
                        <!-- Bagian Kiri: Identitas Utama & Media -->
                        <div class="space-y-6">
                            <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wider border-b pb-2">Identitas & Media</h4>

                            <!-- Nama Sekolah -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_sekolah">Nama Sekolah</label>
                                <input type="text" name="nama_sekolah" id="nama_sekolah" 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                    placeholder="Contoh: SMA Negeri 1 Unggulan" value="{{ old('nama_sekolah', $pengaturan->nama_sekolah) }}">
                            </div>

                            <!-- Akreditasi -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2" for="akreditasi">Akreditasi</label>
                                <input type="text" name="akreditasi" id="akreditasi" 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                    placeholder="Contoh: A (Unggul)" value="{{ old('akreditasi', $pengaturan->akreditasi) }}">
                            </div>

                            <!-- Logo -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2" for="logo">Logo Sekolah</label>
                                <input type="hidden" name="remove_logo" id="remove_logo" value="0">
                                <div class="mt-1 flex items-center gap-6">
                                    <div id="logo-preview-container" class="shrink-0 relative group {{ $pengaturan->logo ? '' : 'hidden' }}">
                                        <img id="logo-preview" 
                                             src="{{ $pengaturan->logo ? asset('storage/uploads/' . $pengaturan->logo) : '' }}" 
                                             alt="Preview Logo" 
                                             class="h-24 w-24 object-contain rounded-lg border border-gray-200 bg-gray-50">
                                        <button type="button" onclick="removeImage('logo')" class="absolute top-1 right-1 bg-white text-red-600 hover:text-red-700 hover:bg-red-50 rounded p-1.5 shadow-md border border-red-100 focus:outline-none transition-all" title="Hapus Gambar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="logo" id="logo" accept="image/*" onchange="previewImage(this, 'logo')"
                                            class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-blue-50 file:text-blue-700
                                            hover:file:bg-blue-100 transition-colors cursor-pointer">
                                        <p class="mt-2 text-xs text-gray-500">Abaikan jika tidak ingin mengubah logo.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Foto Kepala Sekolah -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2" for="foto_kepala_sekolah">Foto Kepala Sekolah</label>
                                <input type="hidden" name="remove_foto_kepala_sekolah" id="remove_foto_kepala_sekolah" value="0">
                                <div class="mt-1 flex items-center gap-6">
                                    <div id="foto_kepala_sekolah-preview-container" class="shrink-0 relative group {{ $pengaturan->foto_kepala_sekolah ? '' : 'hidden' }}">
                                        <img id="foto_kepala_sekolah-preview" 
                                             src="{{ $pengaturan->foto_kepala_sekolah ? asset('storage/uploads/' . $pengaturan->foto_kepala_sekolah) : '' }}" 
                                             alt="Preview Foto Kepala Sekolah" 
                                             class="h-32 w-24 object-cover rounded-lg border border-gray-200 bg-gray-50">
                                        <button type="button" onclick="removeImage('foto_kepala_sekolah')" class="absolute top-1 right-1 bg-white text-red-600 hover:text-red-700 hover:bg-red-50 rounded p-1.5 shadow-md border border-red-100 focus:outline-none transition-all" title="Hapus Gambar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="foto_kepala_sekolah" id="foto_kepala_sekolah" accept="image/*" onchange="previewImage(this, 'foto_kepala_sekolah')"
                                            class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-blue-50 file:text-blue-700
                                            hover:file:bg-blue-100 transition-colors cursor-pointer">
                                        <p class="mt-2 text-xs text-gray-500">Abaikan jika tidak ingin mengubah foto.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Slider Hero -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Slider Hero (Maks. 3 Gambar)</label>
                                
                                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                                    <table class="w-full text-left text-sm text-gray-600">
                                        <thead class="bg-gray-50/50 text-gray-500 uppercase text-xs font-semibold tracking-wider">
                                            <tr>
                                                <th class="px-4 py-3 border-b border-gray-100 w-16 text-center">No</th>
                                                <th class="px-4 py-3 border-b border-gray-100 w-32 text-center">Preview</th>
                                                <th class="px-4 py-3 border-b border-gray-100">Upload File Baru</th>
                                                <th class="px-4 py-3 border-b border-gray-100 w-16 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 bg-white">
                                            @for($i = 1; $i <= 3; $i++)
                                                @php
                                                    $sliderExists = isset($pengaturan->slider_hero[$i - 1]);
                                                    $sliderPath = $sliderExists ? $pengaturan->slider_hero[$i - 1] : null;
                                                @endphp
                                                <tr class="hover:bg-gray-50/50 transition-colors">
                                                    <td class="px-4 py-3 text-center font-semibold text-gray-800">{{ $i }}</td>
                                                    <td class="px-4 py-3 text-center">
                                                        <div id="slider_hero_{{ $i }}-preview-container" class="relative group {{ $sliderExists ? '' : 'hidden' }}">
                                                            <img id="slider_hero_{{ $i }}-preview" 
                                                                 src="{{ $sliderExists ? asset('storage/uploads/' . $sliderPath) : '' }}" 
                                                                 class="h-16 w-24 object-cover rounded-md border border-gray-200 bg-gray-50 mx-auto">
                                                        </div>
                                                        <div id="slider_hero_{{ $i }}-empty" class="{{ $sliderExists ? 'hidden' : '' }} flex items-center justify-center h-16 w-24 border border-dashed border-gray-300 rounded-md bg-gray-50 mx-auto text-gray-400">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <input type="hidden" name="remove_slider_hero_{{ $i }}" id="remove_slider_hero_{{ $i }}" value="0">
                                                        <input type="file" name="slider_hero_{{ $i }}" id="slider_hero_{{ $i }}" accept="image/*" onchange="previewImageSlider(this, 'slider_hero_{{ $i }}')"
                                                            class="block w-full text-xs text-gray-500
                                                            file:mr-2 file:py-1 file:px-3
                                                            file:rounded-full file:border-0
                                                            file:text-xs file:font-semibold
                                                            file:bg-blue-50 file:text-blue-700
                                                            hover:file:bg-blue-100 transition-colors cursor-pointer">
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <button type="button" onclick="removeImageSlider('slider_hero_{{ $i }}')" class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 rounded-lg transition-colors" title="Hapus Gambar">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Nama Kepala Sekolah -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_kepala_sekolah">Nama Kepala Sekolah</label>
                                <input type="text" name="nama_kepala_sekolah" id="nama_kepala_sekolah" 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                    placeholder="Contoh: Dr. H. Budi Santoso, M.Pd." value="{{ old('nama_kepala_sekolah', $pengaturan->nama_kepala_sekolah) }}">
                            </div>

                            <!-- Sambutan Kepala Sekolah -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2" for="sambutan_kepala_sekolah">Sambutan Kepala Sekolah</label>
                                <textarea name="sambutan_kepala_sekolah" id="sambutan_kepala_sekolah" rows="4" 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                    placeholder="Tuliskan kata sambutan Kepala Sekolah di sini...">{{ old('sambutan_kepala_sekolah', $pengaturan->sambutan_kepala_sekolah) }}</textarea>
                            </div>
                        </div>

                        <!-- Bagian Kanan: Kontak & Sosial Media -->
                        <div class="space-y-6">
                            <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wider border-b pb-2">Kontak & Peta</h4>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Telepon -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="telefon">No. Telepon</label>
                                    <input type="text" name="telefon" id="telefon" 
                                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                        placeholder="Contoh: (021) 1234567" value="{{ old('telefon', $pengaturan->telefon) }}">
                                </div>
                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="email">Alamat Email</label>
                                    <input type="email" name="email" id="email" 
                                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                        placeholder="Contoh: info@sekolah.sch.id" value="{{ old('email', $pengaturan->email) }}">
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2" for="alamat">Alamat Lengkap</label>
                                <textarea name="alamat" id="alamat" rows="2" 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                    placeholder="Contoh: Jl. Merdeka No. 123, Kota Bahagia">{{ old('alamat', $pengaturan->alamat) }}</textarea>
                            </div>

                            <!-- Titik Koordinat -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2" for="titik_koordinat">Titik Koordinat Sekolah (Iframe Google Maps)</label>
                                <textarea name="titik_koordinat" id="titik_koordinat" rows="3" 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm font-mono transition-colors text-xs text-gray-600" 
                                    placeholder="Paste kode <iframe> dari Google Maps di sini">{{ old('titik_koordinat', $pengaturan->titik_koordinat) }}</textarea>
                                <p class="mt-2 text-xs text-gray-500">Gunakan fitur <code class="bg-gray-100 px-1 py-0.5 rounded">Embed a map</code> di Google Maps.</p>
                            </div>

                            <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wider border-b pb-2 pt-4">Sosial Media</h4>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Facebook -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="facebook">Facebook URL</label>
                                    <input type="url" name="facebook" id="facebook" 
                                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                        placeholder="https://facebook.com/..." value="{{ old('facebook', $pengaturan->facebook) }}">
                                </div>
                                <!-- Instagram -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="instagram">Instagram URL</label>
                                    <input type="url" name="instagram" id="instagram" 
                                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                        placeholder="https://instagram.com/..." value="{{ old('instagram', $pengaturan->instagram) }}">
                                </div>
                                <!-- Tiktok -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="tiktok">Tiktok URL</label>
                                    <input type="url" name="tiktok" id="tiktok" 
                                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                        placeholder="https://tiktok.com/@..." value="{{ old('tiktok', $pengaturan->tiktok) }}">
                                </div>
                                <!-- Youtube -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="youtube">Youtube URL</label>
                                    <input type="url" name="youtube" id="youtube" 
                                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                        placeholder="https://youtube.com/..." value="{{ old('youtube', $pengaturan->youtube) }}">
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end pt-6 border-t border-gray-100 bg-gray-50/50 -mx-6 -mb-6 px-6 pb-6 rounded-b-2xl">
                        <!-- Tombol Simpan (Success / Green) -->
                        <button type="submit" 
                            class="px-6 py-3 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-colors flex items-center gap-2 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Pengaturan Website
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function previewImage(input, type) {
                const previewContainer = document.getElementById(type + '-preview-container');
                const previewImg = document.getElementById(type + '-preview');
                const removeInput = document.getElementById('remove_' + type);
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                        removeInput.value = '0'; // Batalkan status hapus jika memilih foto baru
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    if (!previewImg.src || previewImg.src === window.location.href) {
                        previewContainer.classList.add('hidden');
                    }
                }
            }

            function removeImage(type) {
                const previewContainer = document.getElementById(type + '-preview-container');
                const previewImg = document.getElementById(type + '-preview');
                const fileInput = document.getElementById(type);
                const removeInput = document.getElementById('remove_' + type);

                // Sembunyikan preview
                previewContainer.classList.add('hidden');
                previewImg.src = '';
                
                // Kosongkan file input jika ada yang dipilih
                fileInput.value = '';

                // Tandai input hidden bahwa gambar ini dihapus
                removeInput.value = '1';
            }

            function previewImageSlider(input, type) {
                const previewContainer = document.getElementById(type + '-preview-container');
                const previewImg = document.getElementById(type + '-preview');
                const emptyPlaceholder = document.getElementById(type + '-empty');
                const removeInput = document.getElementById('remove_' + type);
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                        if (emptyPlaceholder) emptyPlaceholder.classList.add('hidden');
                        removeInput.value = '0';
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    if (!previewImg.src || previewImg.src === window.location.href) {
                        previewContainer.classList.add('hidden');
                        if (emptyPlaceholder) emptyPlaceholder.classList.remove('hidden');
                    }
                }
            }

            function removeImageSlider(type) {
                const previewContainer = document.getElementById(type + '-preview-container');
                const previewImg = document.getElementById(type + '-preview');
                const emptyPlaceholder = document.getElementById(type + '-empty');
                const fileInput = document.getElementById(type);
                const removeInput = document.getElementById('remove_' + type);

                previewContainer.classList.add('hidden');
                previewImg.src = '';
                if (emptyPlaceholder) emptyPlaceholder.classList.remove('hidden');
                
                fileInput.value = '';
                removeInput.value = '1';
            }
        </script>
    </x-slot>
</x-app-layout>
