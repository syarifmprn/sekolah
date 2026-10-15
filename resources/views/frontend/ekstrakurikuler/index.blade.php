@extends('layouts.frontend')
@section('title', 'Ekstrakurikuler')

@section('content')
    <!-- Page Header (Card Style) -->
    <div class="pt-8 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="bg-gradient-to-br from-[#056ded] to-blue-900 text-white py-12 md:py-16 rounded-[2rem] relative overflow-hidden shadow-xl">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
                <div class="relative z-10 text-center px-4">
                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold tracking-wider uppercase mb-3">
                        Pengembangan Bakat & Minat
                    </span>
                    <h1 class="text-3xl md:text-5xl font-extrabold mb-4">Ekstrakurikuler Sekolah</h1>
                    <p class="text-blue-100 text-base md:text-lg max-w-2xl mx-auto">
                        Wadah kreativitas, sportivitas, dan kepemimpinan bagi seluruh siswa untuk berprestasi di luar akademik.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content & Filters -->
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            
            <!-- Filter & Search Bar -->
            <div class="bg-white p-4 sm:p-6 rounded-2xl border border-gray-100 shadow-xs mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <!-- Kategori Tabs -->
                <div class="flex flex-wrap items-center gap-1.5">
                    <a href="{{ route('frontend.ekstrakurikuler', array_merge(request()->except('kategori', 'page'))) }}" 
                        class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all {{ !request('kategori') ? 'bg-[#056ded] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Semua Kategori
                    </a>
                    @foreach($kategoriList as $kat)
                        <a href="{{ route('frontend.ekstrakurikuler', array_merge(request()->except('page'), ['kategori' => $kat])) }}" 
                            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all {{ request('kategori') == $kat ? 'bg-[#056ded] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $kat }}
                        </a>
                    @endforeach
                </div>

                <!-- Search Input -->
                <form action="{{ route('frontend.ekstrakurikuler') }}" method="GET" class="relative">
                    @if(request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari nama ekskul atau pembina..." 
                        class="pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-xs focus:ring-[#056ded] focus:border-[#056ded] w-full md:w-64 bg-gray-50/50">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                    </div>
                </form>
            </div>

            <!-- Grid Ekstrakurikuler -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @forelse($ekstrakurikulers as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                        
                        <!-- Top Banner / Logo -->
                        <div class="h-44 overflow-hidden relative bg-gradient-to-br from-blue-50 to-indigo-50/60 p-6 flex items-center justify-center">
                            @if($item->logo)
                                <img src="{{ asset('storage/' . $item->logo) }}" alt="{{ $item->nama }}" 
                                    class="w-24 h-24 object-cover rounded-2xl border-2 border-white shadow-md group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-24 h-24 rounded-2xl bg-white border border-blue-100 flex items-center justify-center text-4xl text-[#056ded] shadow-md group-hover:scale-105 transition-transform duration-500">
                                    <i class="fa-solid fa-people-group"></i>
                                </div>
                            @endif

                            <!-- Kategori Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="bg-[#056ded] text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-md">
                                    {{ $item->kategori }}
                                </span>
                            </div>

                            @if(is_array($item->galeri) && count($item->galeri) > 0)
                                <div class="absolute top-4 right-4 bg-black/60 backdrop-blur-md text-white text-[10px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1">
                                    <i class="fa-regular fa-images"></i>
                                    {{ count($item->galeri) }} Foto
                                </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2 leading-tight group-hover:text-[#056ded] transition-colors">
                                    <a href="{{ route('frontend.ekstrakurikuler.show', $item->id) }}">
                                        {{ $item->nama }}
                                    </a>
                                </h3>
                                
                                <p class="text-gray-500 text-xs line-clamp-2 leading-relaxed mb-4">
                                    {{ $item->deskripsi ?? 'Kegiatan ekstrakurikuler pembinaan minat dan bakat siswa di sekolah.' }}
                                </p>

                                <!-- Meta Info -->
                                <div class="space-y-1.5 pt-3 border-t border-gray-100 text-xs text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-regular fa-clock text-[#056ded] w-4 text-center"></i>
                                        <span>{{ $item->jadwal_formatted }}</span>
                                    </div>
                                    @if($item->tempat)
                                        <div class="flex items-center gap-2 text-gray-500">
                                            <i class="fa-solid fa-location-dot text-gray-400 w-4 text-center"></i>
                                            <span>{{ $item->tempat }}</span>
                                        </div>
                                    @endif
                                    @if($item->pembina)
                                        <div class="flex items-center gap-2 text-gray-500">
                                            <i class="fa-solid fa-chalkboard-user text-gray-400 w-4 text-center"></i>
                                            <span class="truncate">Pembina: {{ $item->pembina }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Footer Link -->
                            <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-[11px] font-medium text-emerald-600 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                                </span>

                                <a href="{{ route('frontend.ekstrakurikuler.show', $item->id) }}" 
                                    class="text-xs font-bold text-[#056ded] group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                                    Lihat Detail <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-gray-100">
                        <i class="fa-solid fa-people-group text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-700">Belum ada ekstrakurikuler</h3>
                        <p class="text-gray-500 text-sm mt-1">Data ekstrakurikuler belum tersedia atau tidak ditemukan dalam pencarian.</p>
                        @if(request()->anyFilled(['search', 'kategori']))
                            <a href="{{ route('frontend.ekstrakurikuler') }}" class="inline-block mt-4 text-xs font-semibold text-[#056ded] hover:underline">
                                Reset Pencarian
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($ekstrakurikulers->hasPages())
                <div class="flex justify-center">
                    {{ $ekstrakurikulers->links('pagination::tailwind') }}
                </div>
            @endif

        </div>
    </div>
@endsection
