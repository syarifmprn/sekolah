<x-app-layout>
    <x-slot name="header">
        Edit Sarana (Barang / Inventaris)
    </x-slot>

    <div class="p-6 h-full overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <!-- Header Card -->
            <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Edit Data Sarana</h3>
                    <p class="text-xs text-gray-500 mt-1">Perbarui data inventaris barang, jumlah unit, lokasi ruangan, atau kondisi fisik.</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.sarana.show', $sarana->id) }}" 
                        class="px-3.5 py-2 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                        <i class="fa-regular fa-eye mr-1"></i> Detail
                    </a>
                    <a href="{{ route('admin.sarana.index') }}" 
                        class="px-3.5 py-2 text-xs font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Form -->
            <div class="p-6">
                <form action="{{ route('admin.sarana.update', $sarana->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Nama Barang -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 mb-2" for="nama">
                                    Nama Barang / Peralatan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama" id="nama" 
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                    value="{{ old('nama', $sarana->nama) }}" required>
                                @error('nama') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Lokasi / Prasarana -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2" for="prasarana_id">
                                    Lokasi Ruangan / Prasarana
                                </label>
                                <select name="prasarana_id" id="prasarana_id" 
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors bg-white">
                                    <option value="">-- Pilih Ruangan / Lokasi --</option>
                                    @foreach($prasaranasList as $pra)
                                        <option value="{{ $pra->id }}" {{ old('prasarana_id', $sarana->prasarana_id) == $pra->id ? 'selected' : '' }}>
                                            {{ $pra->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[10px] text-gray-400 mt-1">Ruangan tempat barang ini disimpan.</p>
                                @error('prasarana_id') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Jumlah Unit -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2" for="jumlah">
                                    Jumlah Unit Barang <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="jumlah" id="jumlah" min="1" 
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                    value="{{ old('jumlah', $sarana->jumlah) }}" required>
                                @error('jumlah') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Kondisi -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2" for="kondisi">
                                    Kondisi Barang <span class="text-red-500">*</span>
                                </label>
                                <select name="kondisi" id="kondisi" required
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors bg-white">
                                    @foreach($kondisiList as $key => $label)
                                        <option value="{{ $key }}" {{ old('kondisi', $sarana->kondisi) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('kondisi') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Tahun Pengadaan -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2" for="tahun_pengadaan">
                                    Tahun Pengadaan / Pembelian
                                </label>
                                <input type="number" name="tahun_pengadaan" id="tahun_pengadaan" min="1950" max="{{ date('Y') + 1 }}" 
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors" 
                                    value="{{ old('tahun_pengadaan', $sarana->tahun_pengadaan) }}">
                                @error('tahun_pengadaan') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Foto Barang -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2" for="foto">
                                    Foto Barang / Aset
                                </label>
                                <input type="file" name="foto" id="foto" accept="image/*" 
                                    class="w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-[10px] text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah foto.</p>
                                @error('foto') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Preview Foto Saat Ini & Hapus Foto -->
                            <div>
                                <span class="block text-xs font-semibold text-gray-700 mb-2">Foto Saat Ini:</span>
                                <div class="flex items-start gap-4">
                                    <div class="w-32 h-24 rounded-xl border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center shadow-2xs">
                                        @if($sarana->foto)
                                            <img id="image-preview" src="{{ asset('storage/' . $sarana->foto) }}" class="w-full h-full object-cover">
                                        @else
                                            <div id="image-placeholder" class="text-gray-300 text-3xl">
                                                <i class="fa-solid fa-boxes-stacked"></i>
                                            </div>
                                            <img id="image-preview" src="" class="w-full h-full object-cover hidden">
                                        @endif
                                    </div>

                                    @if($sarana->foto)
                                        <div class="pt-2">
                                            <label class="inline-flex items-center cursor-pointer text-xs text-red-600 hover:text-red-700 font-medium select-none">
                                                <input type="checkbox" name="remove_foto" value="1" class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500 mr-2">
                                                Hapus Foto Ini
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 mb-2" for="keterangan">
                                    Keterangan / Spesifikasi / Nomor Seri
                                </label>
                                <textarea name="keterangan" id="keterangan" rows="3" 
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-xs transition-colors">{{ old('keterangan', $sarana->keterangan) }}</textarea>
                                @error('keterangan') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 mt-8 border-t border-gray-100">
                        <a href="{{ route('admin.sarana.index') }}" 
                            class="text-xs font-semibold text-gray-500 hover:text-gray-700 transition-colors">
                            Batal
                        </a>
                        
                        <button type="submit" 
                            class="px-6 py-2.5 text-xs font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-colors flex items-center gap-2 shadow-xs">
                            <i class="fa-solid fa-check"></i>
                            Simpan Perubahan
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
                const imagePreview = document.getElementById('image-preview');
                const imagePlaceholder = document.getElementById('image-placeholder');
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        imagePreview.src = event.target.result;
                        imagePreview.classList.remove('hidden');
                        if (imagePlaceholder) imagePlaceholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </x-slot>
</x-app-layout>
