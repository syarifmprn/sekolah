@extends('layouts.frontend')
@section('title', 'Direktori Guru')

@section('content')
    <!-- Page Header (Card Style) -->
    <div class="pt-8 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="bg-gradient-to-br from-[#056ded] to-blue-900 text-white py-12 md:py-16 rounded-[2rem] relative overflow-hidden shadow-xl">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
                <div class="relative z-10 text-center px-4">
                    <h1 class="text-3xl md:text-5xl font-extrabold mb-4">Direktori Guru & Tenaga Pendidik</h1>
                    <p class="text-blue-200 text-lg max-w-2xl mx-auto">Mengenal lebih dekat para pahlawan tanpa tanda jasa yang berdedikasi membimbing dan mendidik generasi bangsa.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
                @forelse($guru as $g)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow group cursor-pointer" onclick="openGuruModal('{{ $g->nama }}', '{{ $g->jabatan ?? 'Guru' }}', '{{ $g->nip ?? '-' }}', '{{ $g->nuptk ?? '-' }}', '{{ $g->jenis_kelamin ?? '-' }}', '{{ $g->agama ?? '-' }}', '{{ $g->alamat ?? '-' }}', '{{ $g->foto ? storage_upload_url($g->foto) : 'https://ui-avatars.com/api/?name='.urlencode($g->nama).'&background=f3f4f6&color=1c3faa&size=512' }}', '{{ $g->facebook }}', '{{ $g->instagram }}', '{{ $g->whatsapp }}')">
                        <div class="h-72 overflow-hidden relative">
                            <img src="{{ $g->foto ? storage_upload_url($g->foto) : 'https://ui-avatars.com/api/?name='.urlencode($g->nama).'&background=f3f4f6&color=1c3faa&size=512' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $g->nama }}">
                            
                            <!-- Hover overlay -->
                            <div class="absolute inset-0 bg-gradient-to-br from-[#056ded] to-blue-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="bg-white text-blue-900 font-bold px-4 py-2 rounded-full text-sm shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform">Lihat Profil</span>
                            </div>
                        </div>
                        <div class="p-5 text-center">
                            <h4 class="text-lg font-bold text-gray-900 mb-1 truncate">{{ $g->nama }}</h4>
                            <p class="text-sm font-medium text-blue-600 truncate">{{ $g->jabatan ?? 'Guru' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fa-solid fa-users text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-600">Belum ada data</h3>
                        <p class="text-gray-500">Data direktori guru masih kosong.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 flex justify-center">
                {{ $guru->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <!-- Modal Detail Guru -->
    <div id="guruModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/80 backdrop-blur-sm opacity-0 invisible transition-all duration-300">
        <div class="bg-white rounded-3xl w-11/12 max-w-3xl overflow-hidden shadow-2xl transform scale-95 transition-transform duration-300 relative" id="guruModalContent">
            
            <button onclick="closeGuruModal()" class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-red-500 text-gray-500 hover:text-white rounded-full flex items-center justify-center transition-colors z-20 backdrop-blur-sm shadow">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            
            <div class="flex flex-col md:flex-row">
                <!-- Foto Modal -->
                <div class="w-full md:w-5/12 bg-gray-100 relative h-64 md:h-auto">
                    <img id="modalFoto" src="" alt="Foto" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 w-full">
                        <div class="flex gap-3 justify-center" id="modalSosmed">
                            <!-- JS akan mengisi ini -->
                        </div>
                    </div>
                </div>
                
                <!-- Info Modal -->
                <div class="w-full md:w-7/12 p-8 lg:p-10 bg-white">
                    <span class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full mb-4 uppercase tracking-wider" id="modalJabatan">Guru</span>
                    
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-6 leading-tight" id="modalNama">Nama Guru</h3>
                    
                    <div class="space-y-4">
                        <div class="flex flex-col border-b border-gray-100 pb-3">
                            <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">NIP</span>
                            <span class="text-gray-900 font-medium" id="modalNip">-</span>
                        </div>
                        <div class="flex flex-col border-b border-gray-100 pb-3">
                            <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">NUPTK</span>
                            <span class="text-gray-900 font-medium" id="modalNuptk">-</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 border-b border-gray-100 pb-3">
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Jenis Kelamin</span>
                                <span class="text-gray-900 font-medium" id="modalJk">-</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Agama</span>
                                <span class="text-gray-900 font-medium" id="modalAgama">-</span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Alamat</span>
                            <span class="text-gray-900 font-medium text-sm leading-relaxed" id="modalAlamat">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openGuruModal(nama, jabatan, nip, nuptk, jk, agama, alamat, foto, fb, ig, wa) {
        document.getElementById('modalNama').innerText = nama;
        document.getElementById('modalJabatan').innerText = jabatan;
        document.getElementById('modalNip').innerText = nip;
        document.getElementById('modalNuptk').innerText = nuptk;
        document.getElementById('modalJk').innerText = jk == 'L' ? 'Laki-laki' : (jk == 'P' ? 'Perempuan' : '-');
        document.getElementById('modalAgama').innerText = agama;
        document.getElementById('modalAlamat').innerText = alamat;
        document.getElementById('modalFoto').src = foto;
        
        let sosmedHtml = '';
        if(fb) sosmedHtml += `<a href="${fb}" target="_blank" class="w-10 h-10 rounded-full bg-white/20 hover:bg-blue-600 text-white flex items-center justify-center transition-colors backdrop-blur-md"><i class="fa-brands fa-facebook-f"></i></a>`;
        if(ig) sosmedHtml += `<a href="${ig}" target="_blank" class="w-10 h-10 rounded-full bg-white/20 hover:bg-pink-600 text-white flex items-center justify-center transition-colors backdrop-blur-md"><i class="fa-brands fa-instagram"></i></a>`;
        if(wa) {
            let waNum = wa.replace(/[^0-9]/g, '');
            sosmedHtml += `<a href="https://wa.me/${waNum}" target="_blank" class="w-10 h-10 rounded-full bg-white/20 hover:bg-green-500 text-white flex items-center justify-center transition-colors backdrop-blur-md"><i class="fa-brands fa-whatsapp"></i></a>`;
        }
        
        document.getElementById('modalSosmed').innerHTML = sosmedHtml;

        const modal = document.getElementById('guruModal');
        const content = document.getElementById('guruModalContent');
        
        modal.classList.remove('opacity-0', 'invisible');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
        
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeGuruModal() {
        const modal = document.getElementById('guruModal');
        const content = document.getElementById('guruModalContent');
        
        modal.classList.add('opacity-0', 'invisible');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        
        document.body.style.overflow = 'auto'; // Restore scrolling
    }
</script>
@endsection
