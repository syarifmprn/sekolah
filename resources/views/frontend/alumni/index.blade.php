@extends('layouts.frontend')
@section('title', 'Direktori & Cerita Alumni')

@section('content')
    <!-- Page Header (Card Style) -->
    <div class="pt-8 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="bg-gradient-to-br from-[#056ded] to-blue-900 text-white py-12 md:py-16 rounded-[2rem] relative overflow-hidden shadow-xl">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
                <div class="relative z-10 text-center px-4">
                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold tracking-wider uppercase mb-3">
                        Keluarga Besar & Ikatan Alumni
                    </span>
                    <h1 class="text-3xl md:text-5xl font-extrabold mb-4">Direktori & Kisah Sukses Alumni</h1>
                    <p class="text-blue-100 text-base md:text-lg max-w-2xl mx-auto">
                        Inspirasi perjalanan karir, pengalaman berharga, dan jejak langkah lulusan kami yang berkarya di berbagai instansi ternama di seluruh penjuru negeri dan dunia.
                    </p>
                    
                    <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                        <a href="#cerita-alumni" class="px-5 py-2.5 bg-white text-blue-700 font-bold text-xs rounded-xl hover:bg-blue-50 transition-all shadow-md">
                            <i class="fa-solid fa-comments mr-1.5"></i> Baca Testimoni
                        </a>
                        <a href="#form-alumni" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold text-xs rounded-xl backdrop-blur-md border border-white/20 transition-all">
                            <i class="fa-solid fa-paper-plane mr-1.5"></i> Bagikan Cerita Anda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            
            <!-- Flash Message -->
            @if (session('success'))
                <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-5 rounded-r-2xl shadow-sm flex items-start gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl mt-0.5"></i>
                    <div>
                        <h4 class="font-bold text-sm">Berhasil Dikirim!</h4>
                        <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Quick Summary Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-12">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#056ded] flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Alumni Terdata</span>
                        <h3 class="text-3xl font-extrabold text-gray-800">{{ $stats['total_alumni'] ?? 0 }} <span class="text-sm font-normal text-gray-500">Orang</span></h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kisah & Testimoni</span>
                        <h3 class="text-3xl font-extrabold text-gray-800">{{ $stats['total_tampil'] ?? 0 }} <span class="text-sm font-normal text-gray-500">Cerita</span></h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Angkatan Kelulusan</span>
                        <h3 class="text-3xl font-extrabold text-gray-800">{{ $stats['total_angkatan'] ?? 0 }} <span class="text-sm font-normal text-gray-500">Generasi</span></h3>
                    </div>
                </div>
            </div>

            <!-- Featured Testimonials Section -->
            @if(isset($featured_testimoni) && $featured_testimoni->count() > 0)
            <div id="cerita-alumni" class="mb-14">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-black text-gray-800">Sorotan Cerita Sukses</h2>
                        <p class="text-xs text-gray-500 mt-1">Refleksi dan kesan berharga dari para alumni selama menempuh pendidikan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featured_testimoni as $ft)
                        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
                            <div>
                                <div class="flex items-center gap-1 text-amber-400 text-xs mb-3">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <p class="text-gray-600 italic text-sm leading-relaxed mb-6">
                                    "{{ $ft->testimoni }}"
                                </p>
                            </div>

                            <div class="pt-4 border-t border-gray-100 flex items-center gap-3">
                                @if($ft->foto)
                                    <img src="{{ $ft->foto_url }}" alt="{{ $ft->nama }}" 
                                        class="w-12 h-12 rounded-full object-cover border-2 border-blue-100 shrink-0">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-blue-50 text-[#056ded] font-bold flex items-center justify-center border border-blue-100 shrink-0 uppercase text-xs">
                                        {{ substr($ft->nama, 0, 2) }}
                                    </div>
                                @endif
                                <div class="overflow-hidden">
                                    <h4 class="font-bold text-gray-800 text-sm truncate">{{ $ft->nama }}</h4>
                                    <p class="text-xs text-blue-600 font-semibold truncate">{{ $ft->pekerjaan }}</p>
                                    <p class="text-[11px] text-gray-400 truncate">{{ $ft->instansi }} &bull; Lulus {{ $ft->tahun_lulus }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Directory Toolbar & Filter -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-black text-gray-800">Direktori Alumni</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Jelajahi jaringan alumni berdasarkan nama, profesi, instansi, atau angkatan.</p>
                    </div>

                    <form action="{{ route('frontend.alumni') }}" method="GET" class="flex flex-wrap items-center gap-3">
                        <!-- Search Input -->
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Cari nama, profesi, kampus..." 
                                class="pl-9 pr-3 py-2 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded] w-48 sm:w-60">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                            </div>
                        </div>

                        <!-- Filter Tahun Lulus -->
                        <select name="tahun_lulus" onchange="this.form.submit()" 
                            class="py-2 pl-3 pr-8 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded]">
                            <option value="">Semua Angkatan</option>
                            @foreach ($tahunList as $thn)
                                <option value="{{ $thn }}" {{ request('tahun_lulus') == $thn ? 'selected' : '' }}>
                                    Lulus {{ $thn }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Filter Jurusan -->
                        @if($jurusanList->count() > 0)
                        <select name="jurusan" onchange="this.form.submit()" 
                            class="py-2 pl-3 pr-8 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded]">
                            <option value="">Semua Jurusan</option>
                            @foreach ($jurusanList as $jur)
                                <option value="{{ $jur }}" {{ request('jurusan') == $jur ? 'selected' : '' }}>
                                    {{ $jur }}
                                </option>
                            @endforeach
                        </select>
                        @endif

                        @if(request()->anyFilled(['search', 'tahun_lulus', 'jurusan']))
                            <a href="{{ route('frontend.alumni') }}" class="p-2 text-gray-400 hover:text-gray-600 transition-colors" title="Reset Filter">
                                <i class="fa-solid fa-rotate-left text-xs"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Directory Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @forelse ($alumnis as $item)
                    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                        <div class="p-6">
                            <div class="flex items-start gap-4 mb-4">
                                @if ($item->foto)
                                    <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}" 
                                        class="w-16 h-16 rounded-2xl object-cover border-2 border-blue-100 shadow-xs shrink-0">
                                @else
                                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-[#056ded] font-bold flex items-center justify-center border border-blue-100 shrink-0 text-xl uppercase shadow-xs">
                                        {{ substr($item->nama, 0, 2) }}
                                    </div>
                                @endif

                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-1.5 mb-1">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-[#056ded]">
                                            Lulus {{ $item->tahun_lulus }}
                                        </span>
                                        @if($item->jurusan)
                                            <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-medium bg-gray-100 text-gray-600">
                                                {{ $item->jurusan }}
                                            </span>
                                        @endif
                                    </div>
                                    <h4 class="font-bold text-gray-800 text-base truncate">{{ $item->nama }}</h4>
                                    <p class="text-xs font-semibold text-blue-600 truncate">{{ $item->pekerjaan }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $item->instansi }}</p>
                                </div>
                            </div>

                            @if($item->alamat)
                                <div class="text-[11px] text-gray-400 flex items-center gap-1 mb-3">
                                    <i class="fa-solid fa-location-dot text-rose-400"></i>
                                    <span>{{ $item->alamat }}</span>
                                </div>
                            @endif

                            <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-100">
                                <p class="text-xs text-gray-600 italic line-clamp-3">
                                    "{{ $item->testimoni }}"
                                </p>
                            </div>
                        </div>

                        <div class="px-6 py-3.5 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                            <span>Ikatan Alumni</span>
                            <span class="font-semibold text-gray-700">Angkatan {{ $item->tahun_lulus }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <div class="w-16 h-16 rounded-full bg-blue-50 text-[#056ded] flex items-center justify-center text-2xl mx-auto mb-3">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <h4 class="text-base font-bold text-gray-800">Tidak Ada Data Alumni Ditemukan</h4>
                        <p class="text-xs text-gray-400 mt-1 max-w-md mx-auto">
                            Coba ubah kata kunci pencarian atau reset filter untuk menampilkan semua data alumni.
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($alumnis->hasPages())
                <div class="mb-14">
                    {{ $alumnis->links() }}
                </div>
            @endif

            <!-- Submission Form Section -->
            <div id="form-alumni" class="bg-white rounded-3xl border border-gray-100 shadow-lg overflow-hidden max-w-4xl mx-auto">
                <div class="bg-gradient-to-r from-blue-700 to-indigo-800 p-8 text-white relative">
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold tracking-wider uppercase inline-block mb-2">
                        Formulir Alumni
                    </span>
                    <h3 class="text-2xl font-black">Apakah Anda Alumni Sekolah Ini?</h3>
                    <p class="text-blue-100 text-xs sm:text-sm mt-1 max-w-xl">
                        Kirimkan biodata dan cerita inspiratif Anda untuk mempererat silaturahmi, memotivasi adik kelas, dan bergabung dalam jejaring alumni.
                    </p>
                </div>

                <form action="{{ route('frontend.alumni.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <!-- Nama -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required 
                                placeholder="Contoh: Muhammad Farhan, S.T." 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded]">
                            @error('nama') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tahun Lulus -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">
                                Tahun Lulus / Angkatan <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus', date('Y')) }}" min="1970" max="{{ date('Y') + 1 }}" required 
                                placeholder="Contoh: 2021" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded]">
                            @error('tahun_lulus') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Jurusan -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">
                                Jurusan <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="text" name="jurusan" value="{{ old('jurusan') }}" 
                                placeholder="Contoh: IPA / IPS / Rekayasa Perangkat Lunak" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded]">
                            @error('jurusan') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Pekerjaan -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">
                                Pekerjaan / Profesi Saat Ini <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" required 
                                placeholder="Contoh: Pegawai BUMN / Dokter / Software Engineer" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded]">
                            @error('pekerjaan') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Instansi -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">
                                Instansi / Tempat Kerja / Kampus <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="instansi" value="{{ old('instansi') }}" required 
                                placeholder="Contoh: PT Bank Mandiri / ITB Bandung" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded]">
                            @error('instansi') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Domisili -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">
                                Kota Domisili Saat Ini <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="text" name="alamat" value="{{ old('alamat') }}" 
                                placeholder="Contoh: Surabaya, Jawa Timur" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded]">
                            @error('alamat') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Foto -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">
                                Foto Diri <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="file" id="foto_alumni" name="foto" accept="image/jpeg,image/png,image/jpg,image/webp" 
                                class="w-full px-3 py-2 border border-gray-200 rounded-xl text-xs file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                            <p class="text-[10px] text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>

                            <!-- Alert Error Ukuran Lebih 2MB -->
                            <div id="foto-error-box" class="hidden mt-2 p-2.5 bg-red-50 border border-red-200 rounded-xl flex items-start gap-2">
                                <i class="fa-solid fa-circle-xmark text-red-500 mt-0.5 text-xs"></i>
                                <div class="text-[11px] text-red-600 font-medium" id="foto-error-text">
                                    Ukuran foto melebihi batas maksimum 2MB.
                                </div>
                            </div>

                            <!-- Preview Foto Aman -->
                            <div id="foto-preview-box" class="hidden mt-2 flex items-center gap-3 p-2 bg-blue-50 border border-blue-100 rounded-xl">
                                <img id="foto-preview-img" src="" alt="Preview Foto" class="w-10 h-10 object-cover rounded-lg border border-blue-200">
                                <div class="text-[11px]">
                                    <p id="foto-preview-name" class="font-bold text-gray-800 truncate max-w-[180px]"></p>
                                    <p id="foto-preview-size" class="text-blue-600 font-semibold"></p>
                                </div>
                            </div>

                            @error('foto') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Kontak No HP -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">
                                Nomor WhatsApp <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" 
                                placeholder="Contoh: 081234567890" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded]">
                            @error('no_hp') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Kontak Email -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">
                                Email <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                placeholder="Contoh: alumni@example.com" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded]">
                            @error('email') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Testimoni -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-2">
                                Pesan, Kesan, atau Cerita Pengalaman Anda <span class="text-red-500">*</span>
                            </label>
                            <textarea name="testimoni" rows="4" required 
                                placeholder="Tuliskan cerita pengalaman Anda selama menuntut ilmu di sekolah ini, tips karir untuk adik-adik kelas, atau apresiasi untuk para guru tercinta..." 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded]">{{ old('testimoni') }}</textarea>
                            @error('testimoni') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <p class="text-[11px] text-gray-400">
                            * Data Anda akan diverifikasi oleh pihak sekolah sebelum ditampilkan pada daftar direktori publik.
                        </p>
                        <button type="submit" 
                            class="px-6 py-3 bg-[#056ded] hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-md transition-all flex items-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Profil Alumni
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Script Validasi Ukuran Foto Maksimal 2MB di Halaman Depan -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fotoInput = document.getElementById('foto_alumni');
            const errorBox = document.getElementById('foto-error-box');
            const errorText = document.getElementById('foto-error-text');
            const previewBox = document.getElementById('foto-preview-box');
            const previewImg = document.getElementById('foto-preview-img');
            const previewName = document.getElementById('foto-preview-name');
            const previewSize = document.getElementById('foto-preview-size');
            const maxBytes = 2 * 1024 * 1024; // 2 MB (2,097,152 bytes)

            if (fotoInput) {
                fotoInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (!file) {
                        if (previewBox) previewBox.classList.add('hidden');
                        if (errorBox) errorBox.classList.add('hidden');
                        return;
                    }

                    // Periksa jika ukuran melebihi 2MB
                    if (file.size > maxBytes) {
                        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                        this.value = ''; // Reset input agar tidak terunggah

                        if (previewBox) previewBox.classList.add('hidden');
                        if (errorBox) {
                            errorText.textContent = `Foto ditolak! Ukuran file Anda (${sizeMB} MB) melebihi batas maksimal 2 MB. Silakan pilih foto dengan ukuran lebih kecil.`;
                            errorBox.classList.remove('hidden');
                        }
                        alert(`Perhatian: Ukuran foto Anda (${sizeMB} MB) melebihi batas maksimum 2 MB!\n\nFoto ditolak secara otomatis. Silakan gunakan foto yang telah dikompres atau berukuran di bawah 2 MB.`);
                    } else {
                        // Ukuran valid (< 2MB)
                        if (errorBox) errorBox.classList.add('hidden');
                        if (previewBox && previewImg) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                previewImg.src = e.target.result;
                                if (previewName) previewName.textContent = file.name;
                                const formattedSize = file.size >= 1024 * 1024 
                                    ? (file.size / (1024 * 1024)).toFixed(2) + ' MB' 
                                    : (file.size / 1024).toFixed(1) + ' KB';
                                if (previewSize) previewSize.textContent = `${formattedSize} (Ukuran Sesuai)`;
                                previewBox.classList.remove('hidden');
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                });

                // Validasi saat formulir di-submit
                const form = fotoInput.closest('form');
                if (form) {
                    form.addEventListener('submit', function (e) {
                        if (fotoInput.files && fotoInput.files[0] && fotoInput.files[0].size > maxBytes) {
                            e.preventDefault();
                            const sizeMB = (fotoInput.files[0].size / (1024 * 1024)).toFixed(2);
                            alert(`Gagal mengirim formulir!\nUkuran foto (${sizeMB} MB) melebihi batas 2 MB. Mohon ganti foto terlebih dahulu.`);
                            fotoInput.focus();
                            return false;
                        }
                    });
                }
            }
        });
    </script>
@endsection
