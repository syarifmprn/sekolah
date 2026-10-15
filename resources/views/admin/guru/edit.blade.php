<x-app-layout>
    <x-slot name="header">
        Manajemen Guru
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <script>
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
                const fileInput = document.getElementById('foto');
                const removeInput = document.getElementById('remove_image');

                previewContainer.classList.add('hidden');
                previewImg.src = '';
                fileInput.value = '';
                if (removeInput) removeInput.value = '1';
            }
        </script>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-800">Form Edit Guru</h3>
                <p class="text-sm text-gray-500 mt-1">Ubah informasi di bawah ini untuk memperbarui data guru.</p>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" id="nama" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Contoh: Budi Santoso, S.Pd., M.Pd." value="{{ old('nama', $guru->nama) }}" required>
                        </div>
                        
                        <!-- Jabatan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="jabatan">Jabatan / Guru Mapel <span class="text-red-500">*</span></label>
                            <input type="text" name="jabatan" id="jabatan" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Contoh: Guru Matematika / Kepala Sekolah" value="{{ old('jabatan', $guru->jabatan) }}" required>
                        </div>

                        <!-- NIP -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="nip">NIP</label>
                            <input type="text" name="nip" id="nip" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Nomor Induk Pegawai" value="{{ old('nip', $guru->nip) }}">
                        </div>

                        <!-- NUPTK -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="nuptk">NUPTK</label>
                            <input type="text" name="nuptk" id="nuptk" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Nomor Unik Pendidik dan Tenaga Kependidikan" value="{{ old('nuptk', $guru->nuptk) }}">
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <!-- Agama -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="agama">Agama</label>
                            <select name="agama" id="agama" 
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors">
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam" {{ old('agama', $guru->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama', $guru->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama', $guru->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama', $guru->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama', $guru->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama', $guru->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                        </div>

                        <!-- Status Aktif -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg bg-gray-50 cursor-pointer hover:bg-gray-100 transition-colors">
                                <input type="checkbox" name="aktif" value="1" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500" {{ old('aktif', $guru->aktif) ? 'checked' : '' }}>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-800">Guru Aktif</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">Centang jika guru masih aktif mengajar di sekolah ini</span>
                                </div>
                            </label>
                        </div>

                        <!-- Alamat -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="alamat">Alamat Lengkap</label>
                            <textarea name="alamat" id="alamat" rows="3"
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                placeholder="Alamat domisili saat ini">{{ old('alamat', $guru->alamat) }}</textarea>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-100">

                    <h4 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Sosial Media & Kontak</h4>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Facebook -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="facebook">Facebook (URL)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fab fa-facebook"></i>
                                </div>
                                <input type="text" name="facebook" id="facebook" 
                                    class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                    placeholder="https://facebook.com/..." value="{{ old('facebook', $guru->facebook) }}">
                            </div>
                        </div>

                        <!-- Instagram -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="instagram">Instagram (URL)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fab fa-instagram"></i>
                                </div>
                                <input type="text" name="instagram" id="instagram" 
                                    class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                    placeholder="https://instagram.com/..." value="{{ old('instagram', $guru->instagram) }}">
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="whatsapp">WhatsApp (Nomor)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <input type="text" name="whatsapp" id="whatsapp" 
                                    class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors" 
                                    placeholder="081234567890" value="{{ old('whatsapp', $guru->whatsapp) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Foto -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="foto">Foto Profil (Opsional)</label>
                        <div class="mt-1 flex items-start gap-4 flex-col sm:flex-row">
                            <input type="hidden" name="remove_image" id="remove_image" value="0">
                            <div id="image_preview_container" class="shrink-0 relative group {{ $guru->foto ? '' : 'hidden' }}">
                                <img id="image_preview" class="h-32 w-48 object-cover rounded-lg border border-gray-200 bg-gray-50" src="{{ $guru->foto ? (str_starts_with($guru->foto, 'http') ? $guru->foto : asset('storage/' . $guru->foto)) : '' }}" alt="Preview">
                                <button type="button" onclick="removeImage()" class="absolute top-1 right-1 bg-white text-red-600 hover:text-red-700 hover:bg-red-50 rounded p-1.5 shadow-md border border-red-100 focus:outline-none transition-all" title="Hapus Gambar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                            <div class="flex-1 mt-2">
                                <input type="file" name="foto" id="foto" accept="image/*" onchange="previewImage(this)"
                                    class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100 transition-colors cursor-pointer">
                                <p class="mt-2 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <!-- Tombol Batal (Blue Text) -->
                        <a href="{{ route('admin.guru.index') }}" 
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
