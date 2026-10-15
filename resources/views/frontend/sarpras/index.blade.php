@extends('layouts.frontend')
@section('title', 'Sarana & Prasarana')

@section('content')
    <!-- Page Header (Card Style) -->
    <div class="pt-8 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="bg-gradient-to-br from-[#056ded] to-blue-900 text-white py-12 md:py-16 rounded-[2rem] relative overflow-hidden shadow-xl">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
                <div class="relative z-10 text-center px-4">
                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold tracking-wider uppercase mb-3">
                        Fasilitas & Penunjang Belajar
                    </span>
                    <h1 class="text-3xl md:text-5xl font-extrabold mb-4">Sarana & Prasarana</h1>
                    <p class="text-blue-100 text-base md:text-lg max-w-2xl mx-auto">
                        Fasilitas gedung, ruang kelas, laboratorium berteknologi modern, dan inventaris pembelajaran untuk mendukung kegiatan belajar mengajar secara optimal.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            
            <!-- Quick Summary Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-10">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#056ded] flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Ruang & Fasilitas</span>
                        <h3 class="text-3xl font-extrabold text-gray-800">{{ $stats['total_ruang'] ?? 0 }} <span class="text-sm font-normal text-gray-500">Unit</span></h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-ruler-combined"></i>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Luas Area Ruang</span>
                        <h3 class="text-3xl font-extrabold text-gray-800">{{ number_format($stats['total_luas'] ?? 0, 1, ',', '.') }} <span class="text-sm font-normal text-gray-500">m²</span></h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Inventaris Sarana</span>
                        <h3 class="text-3xl font-extrabold text-gray-800">{{ $stats['total_sarana'] ?? 0 }} <span class="text-sm font-normal text-gray-500">Peralatan</span></h3>
                    </div>
                </div>
            </div>

            <!-- Toolbar & Filter -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-xs mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Katalog Fasilitas Sekolah</span>
                </div>

                <!-- Search Input -->
                <form action="{{ route('frontend.sarpras') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari fasilitas / ruangan..." 
                        class="pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded] w-full sm:w-64 bg-gray-50/50">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                    </div>
                </form>
            </div>

            <!-- Grid Prasarana -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @forelse($prasaranas as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                        
                        <!-- Foto Prasarana -->
                        <div class="h-48 overflow-hidden relative bg-gray-100 flex items-center justify-center">
                            @if($item->foto)
                                <img src="{{ storage_upload_url($item->foto) }}" alt="{{ $item->nama }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50/60 text-[#056ded]">
                                    <i class="fa-solid fa-building text-4xl mb-1 opacity-70"></i>
                                    <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Fasilitas Sekolah</span>
                                </div>
                            @endif

                            <!-- Kondisi Badge -->
                            <div class="absolute top-3 left-3">
                                @if($item->kondisi === 'baik')
                                    <span class="bg-emerald-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-md">
                                        Kondisi Baik
                                    </span>
                                @elseif($item->kondisi === 'rusak_ringan')
                                    <span class="bg-amber-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-md">
                                        Perbaikan Ringan
                                    </span>
                                @else
                                    <span class="bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-md">
                                        Perlu Renovasi
                                    </span>
                                @endif
                            </div>

                            @if($item->luas)
                                <div class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-md text-white text-[10px] font-semibold px-2.5 py-0.5 rounded-full">
                                    <i class="fa-solid fa-ruler-combined mr-1"></i> {{ $item->luas_formatted }}
                                </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-base font-bold text-gray-900 mb-1 group-hover:text-[#056ded] transition-colors leading-snug">
                                    {{ $item->nama }}
                                </h3>

                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                    <span><strong class="text-gray-700">{{ $item->jumlah }}</strong> Unit Ruang</span>
                                </div>

                                @if($item->keterangan)
                                    <p class="text-gray-500 text-xs line-clamp-2 leading-relaxed mb-4">
                                        {{ $item->keterangan }}
                                    </p>
                                @endif

                                <!-- Sarana Terkait Preview -->
                                @if($item->saranas && $item->saranas->count() > 0)
                                    <div class="pt-3 border-t border-gray-100">
                                        <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider block mb-1.5">Sarana di Ruangan:</span>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($item->saranas->take(3) as $sar)
                                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-[10px]">
                                                    {{ $sar->nama }} ({{ $sar->jumlah }})
                                                </span>
                                            @endforeach
                                            @if($item->saranas->count() > 3)
                                                <span class="px-1.5 py-0.5 bg-gray-100 text-gray-400 rounded text-[10px]">
                                                    +{{ $item->saranas->count() - 3 }} lainnya
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-gray-100">
                        <i class="fa-solid fa-building text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-700">Belum ada data sarana prasarana</h3>
                        <p class="text-gray-500 text-sm mt-1">Data fasilitas gedung dan inventaris belum ditambahkan.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($prasaranas->hasPages())
                <div class="flex justify-center">
                    {{ $prasaranas->links('pagination::tailwind') }}
                </div>
            @endif

        </div>
    </div>
@endsection
