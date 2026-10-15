<x-app-layout>
    <x-slot name="header">
        Tambah Ekstrakurikuler
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <!-- Header Card -->
            <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Form Tambah Ekstrakurikuler</h3>
                    <p class="text-xs text-gray-500 mt-1">Lengkapi data ekstrakurikuler, pembina, jadwal latihan, serta foto logo dan dokumentasi galeri.</p>
                </div>
                <a href="{{ route('admin.ekstrakurikuler.index') }}" 
                    class="px-3.5 py-2 text-xs font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

            <!-- Form -->
            <div class="p-6">
                <form action="{{ route('admin.ekstrakurikuler.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-8">
                        
                        <!-- 1. INFORMASI UTAMA -->
                        <div>
                            <div class="flex items-center gap-2 pb-3 mb-4 border-b border-gray-100">
                                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">1</span>
                                <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Informasi Utama</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                <!-- Nama Ekskul -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="nama">
                                        Nama Ekstrakurikuler <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nama" id="nama" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Contoh: Basket, Pramuka, Rohis, Paduan Suara" 
                                        value="{{ old('nama') }}" required>
                                    @error('nama') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Kategori -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="kategori">
                                        Kategori <span class="text-red-500">*</span>
                                    </label>
                                    <select name="kategori" id="kategori" required
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors bg-white">
                                        <option value="" disabled selected>-- Pilih Kategori --</option>
                                        @foreach($kategoriList as $kat)
                                            <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="status">
                                        Status Keaktifan <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status" id="status" required
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors bg-white">
                                        <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                    @error('status') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Deskripsi Singkat -->
                                <div class="md:col-span-3">
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="deskripsi">
                                        Deskripsi Singkat Kegiatan
                                    </label>
                                    <textarea name="deskripsi" id="deskripsi" rows="3" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Jelaskan mengenai tujuan, kegiatan rutin, atau prestasi ekskul ini...">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 2. PEMBINA & KETUA -->
                        <div>
                            <div class="flex items-center gap-2 pb-3 mb-4 border-b border-gray-100">
                                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">2</span>
                                <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Penanggung Jawab & Kepengurusan</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Pembina -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="pembina">
                                        Guru Pembina / Pelatih
                                    </label>
                                    <input type="text" name="pembina" id="pembina" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Contoh: Drs. H. Ahmad Fauzi, M.Pd" value="{{ old('pembina') }}">
                                    @error('pembina') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Ketua Ekskul -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="ketua">
                                        Ketua Ekskul (Siswa)
                                    </label>
                                    <input type="text" name="ketua" id="ketua" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Contoh: Muhammad Rizky Pratama" value="{{ old('ketua') }}">
                                    @error('ketua') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 3. JADWAL & LOKASI -->
                        <div>
                            <div class="flex items-center gap-2 pb-3 mb-4 border-b border-gray-100">
                                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">3</span>
                                <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Jadwal & Lokasi Latihan</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                                <!-- Hari Latihan -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="hari">
                                        Hari Latihan
                                    </label>
                                    <select name="hari" id="hari" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors bg-white">
                                        <option value="">-- Pilih Hari --</option>
                                        @foreach($hariList as $h)
                                            <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                                        @endforeach
                                    </select>
                                    @error('hari') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Jam Mulai -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="jam_mulai">
                                        Jam Mulai
                                    </label>
                                    <input type="time" name="jam_mulai" id="jam_mulai" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        value="{{ old('jam_mulai') }}">
                                    @error('jam_mulai') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Jam Selesai -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="jam_selesai">
                                        Jam Selesai
                                    </label>
                                    <input type="time" name="jam_selesai" id="jam_selesai" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        value="{{ old('jam_selesai') }}">
                                    @error('jam_selesai') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Tempat Latihan -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="tempat">
                                        Tempat / Lokasi Latihan
                                    </label>
                                    <input type="text" name="tempat" id="tempat" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Contoh: Lapangan Utama / Aula" value="{{ old('tempat') }}">
                                    @error('tempat') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 4. MEDIA (LOGO & GALERI FOTO) -->
                        <div>
                            <div class="flex items-center gap-2 pb-3 mb-4 border-b border-gray-100">
                                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">4</span>
                                <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Logo & Dokumentasi Kegiatan</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Logo Utama -->
                                <div class="bg-gray-50/70 p-4 rounded-xl border border-gray-100">
                                    <label class="block text-xs font-semibold text-gray-700 mb-1" for="logo">
                                        Foto / Logo Utama Ekskul
                                    </label>
                                    <p class="text-[11px] text-gray-400 mb-3">Format: PNG, JPG, WEBP. Maks 2MB.</p>

                                    <div class="flex items-center gap-4">
                                        <!-- Preview Box -->
                                        <div id="logo-preview-box" class="w-20 h-20 rounded-xl bg-white border border-dashed border-gray-300 flex items-center justify-center overflow-hidden flex-shrink-0 text-gray-300 text-2xl">
                                            <i class="fa-solid fa-image"></i>
                                        </div>

                                        <div class="flex-1">
                                            <input type="file" name="logo" id="logo" accept="image/*" 
                                                class="text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        </div>
                                    </div>
                                    @error('logo') <p class="text-red-500 text-[11px] mt-2">{{ $message }}</p> @enderror
                                </div>

                                <!-- Galeri Foto (Multiple Upload) -->
                                <div class="md:col-span-2 bg-gray-50/70 p-4 rounded-xl border border-gray-100">
                                    <label class="block text-xs font-semibold text-gray-700 mb-1" for="galeri">
                                        Galeri Foto Kegiatan (Upload Sekaligus / Multiple)
                                    </label>
                                    <p class="text-[11px] text-gray-400 mb-3">Pilih satu atau beberapa foto kegiatan ekskul (Format JPG, PNG, WEBP. Maks 3MB per foto).</p>

                                    <input type="file" name="galeri[]" id="galeri" multiple accept="image/*" 
                                        class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

                                    <!-- Grid Preview Galeri -->
                                    <div id="galeri-preview-grid" class="grid grid-cols-4 sm:grid-cols-6 gap-2 mt-3 empty:hidden"></div>
                                    @error('galeri') <p class="text-red-500 text-[11px] mt-2">{{ $message }}</p> @enderror
                                    @error('galeri.*') <p class="text-red-500 text-[11px] mt-2">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 mt-8 border-t border-gray-100">
                        <a href="{{ route('admin.ekstrakurikuler.index') }}" 
                            class="text-xs font-semibold text-gray-500 hover:text-gray-700 transition-colors">
                            Batal
                        </a>
                        
                        <button type="submit" 
                            class="px-6 py-2.5 text-xs font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-colors flex items-center gap-2 shadow-xs">
                            <i class="fa-solid fa-check"></i>
                            Simpan Ekstrakurikuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            // Live Preview Logo
            document.getElementById('logo').addEventListener('change', function (e) {
                const box = document.getElementById('logo-preview-box');
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        box.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover rounded-xl" />`;
                    };
                    reader.readAsDataURL(file);
                } else {
                    box.innerHTML = `<i class="fa-solid fa-image"></i>`;
                }
            });

            // Live Preview Multi Galeri
            document.getElementById('galeri').addEventListener('change', function (e) {
                const grid = document.getElementById('galeri-preview-grid');
                grid.innerHTML = '';
                const files = e.target.files;
                if (files && files.length > 0) {
                    Array.from(files).forEach((file) => {
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            const div = document.createElement('div');
                            div.className = 'relative aspect-square rounded-lg border border-gray-200 overflow-hidden bg-white shadow-2xs';
                            div.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover" />`;
                            grid.appendChild(div);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            });
        </script>
    </x-slot>
</x-app-layout>
