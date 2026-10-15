<x-app-layout>
    <x-slot name="header">
        Tambah Alumni
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <!-- Header Card -->
            <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Form Tambah Alumni Baru</h3>
                    <p class="text-xs text-gray-500 mt-1">Lengkapi biodata alumni, profesi, instansi, serta testimoni inspiratif.</p>
                </div>
                <a href="{{ route('admin.alumni.index') }}" 
                    class="px-3.5 py-2 text-xs font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

            <!-- Form -->
            <div class="p-6">
                <form action="{{ route('admin.alumni.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-6">
                        
                        <!-- Informasi Pribadi & Pendidikan -->
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 pb-2 border-b border-gray-100 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-user text-blue-600"></i> Informasi Pribadi & Kelulusan
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Nama Lengkap -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="nama">
                                        Nama Lengkap Alumni <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nama" id="nama" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Contoh: Sarah Anindya, S.Kom." 
                                        value="{{ old('nama') }}" required>
                                    @error('nama') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Tahun Lulus -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="tahun_lulus">
                                        Tahun Lulus / Angkatan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="tahun_lulus" id="tahun_lulus" min="1970" max="{{ date('Y') + 1 }}" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Contoh: 2020" value="{{ old('tahun_lulus', date('Y')) }}" required>
                                    @error('tahun_lulus') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Jurusan -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="jurusan">
                                        Jurusan / Program Keahlian <span class="text-gray-400 font-normal">(Opsional)</span>
                                    </label>
                                    <input type="text" name="jurusan" id="jurusan" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Contoh: MIPA, IPS, Rekayasa Perangkat Lunak" value="{{ old('jurusan') }}">
                                    @error('jurusan') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Karir & Domisili -->
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 pb-2 border-b border-gray-100 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-briefcase text-blue-600"></i> Karir & Domisili
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Pekerjaan -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="pekerjaan">
                                        Pekerjaan / Profesi Saat Ini <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="pekerjaan" id="pekerjaan" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Contoh: Data Scientist, Dokter, Wiraswasta" 
                                        value="{{ old('pekerjaan') }}" required>
                                    @error('pekerjaan') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Instansi / Kampus -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="instansi">
                                        Instansi / Tempat Kerja / Kampus <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="instansi" id="instansi" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Contoh: PT Telkom Indonesia / Universitas Indonesia" 
                                        value="{{ old('instansi') }}" required>
                                    @error('instansi') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Alamat / Kota Domisili -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="alamat">
                                        Kota / Domisili Saat Ini <span class="text-gray-400 font-normal">(Opsional)</span>
                                    </label>
                                    <input type="text" name="alamat" id="alamat" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Contoh: Jakarta Selatan, DKI Jakarta" 
                                        value="{{ old('alamat') }}">
                                    @error('alamat') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Kontak & Testimoni -->
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 pb-2 border-b border-gray-100 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-comment-dots text-blue-600"></i> Kontak & Testimoni
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- No HP -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="no_hp">
                                        Nomor WhatsApp / HP <span class="text-gray-400 font-normal">(Opsional)</span>
                                    </label>
                                    <input type="text" name="no_hp" id="no_hp" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Contoh: 081234567890" 
                                        value="{{ old('no_hp') }}">
                                    @error('no_hp') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="email">
                                        Email <span class="text-gray-400 font-normal">(Opsional)</span>
                                    </label>
                                    <input type="email" name="email" id="email" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Contoh: alumni@example.com" 
                                        value="{{ old('email') }}">
                                    @error('email') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Testimoni -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="testimoni">
                                        Kesan, Pesan & Testimoni Sukses <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="testimoni" id="testimoni" rows="4" 
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                        placeholder="Tuliskan pengalaman selama bersekolah, pesan untuk adik kelas, atau cerita karir..." required>{{ old('testimoni') }}</textarea>
                                    @error('testimoni') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Foto & Status Tampil -->
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 pb-2 border-b border-gray-100 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-image text-blue-600"></i> Media & Publikasi
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start">
                                <!-- Upload Foto -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2" for="foto">
                                        Foto Profil Alumni <span class="text-gray-400 font-normal">(Opsional)</span>
                                    </label>
                                    <input type="file" name="foto" id="foto" accept="image/*" 
                                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                                    <p class="text-[10px] text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB. Disarankan foto portrait rasio 1:1.</p>
                                    @error('foto') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Status Tampil -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">
                                        Tampilkan Testimoni di Website? <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-3 mt-1">
                                        <label class="flex items-center gap-2 p-3 border rounded-xl cursor-pointer hover:bg-gray-50 transition-colors {{ old('tampil', 'ya') === 'ya' ? 'border-blue-500 bg-blue-50/20' : 'border-gray-200' }}">
                                            <input type="radio" name="tampil" value="ya" {{ old('tampil', 'ya') === 'ya' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                                            <div>
                                                <span class="block text-xs font-bold text-gray-800">Tampilkan</span>
                                                <span class="text-[10px] text-gray-400">Muncul di halaman publik</span>
                                            </div>
                                        </label>
                                        <label class="flex items-center gap-2 p-3 border rounded-xl cursor-pointer hover:bg-gray-50 transition-colors {{ old('tampil') === 'tidak' ? 'border-blue-500 bg-blue-50/20' : 'border-gray-200' }}">
                                            <input type="radio" name="tampil" value="tidak" {{ old('tampil') === 'tidak' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                                            <div>
                                                <span class="block text-xs font-bold text-gray-800">Sembunyikan</span>
                                                <span class="text-[10px] text-gray-400">Arsip admin saja</span>
                                            </div>
                                        </label>
                                    </div>
                                    @error('tampil') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.alumni.index') }}" 
                            class="px-5 py-2.5 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                            class="px-5 py-2.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-xs transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-save"></i> Simpan Alumni
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
