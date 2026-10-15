@extends('layouts.frontend')
@section('title', 'Prestasi')

@section('content')
    <!-- Page Header (Card Style) -->
    <div class="pt-8 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="bg-gradient-to-br from-[#056ded] to-blue-900 text-white py-12 md:py-16 rounded-[2rem] relative overflow-hidden shadow-xl">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
                <div class="relative z-10 text-center px-4">
                    <h1 class="text-3xl md:text-5xl font-extrabold mb-4">Prestasi & Penghargaan</h1>
                    <p class="text-blue-200 text-lg max-w-2xl mx-auto">Deretan prestasi membanggakan yang diraih oleh siswa dan siswi terbaik kami di berbagai bidang.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
                @forelse($prestasi as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow group">
                        <div class="h-48 overflow-hidden relative bg-gray-100 flex items-center justify-center">
                            @if(isset($item->dokumentasi) && is_array($item->dokumentasi) && count($item->dokumentasi) > 0)
                                <img src="{{ storage_upload_url($item->dokumentasi[0]) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $item->nama_kegiatan }}">
                            @else
                                <i class="fa-solid fa-trophy text-5xl text-gray-300"></i>
                            @endif
                            @php
                                $badgePrestasi = 'Juara';
                                if (!empty($item->hasil)) {
                                    $badgePrestasi = is_numeric($item->hasil) ? 'Juara ' . $item->hasil : $item->hasil;
                                }
                            @endphp
                            <div class="absolute top-3 left-3 bg-yellow-400 text-yellow-950 text-xs font-bold px-3 py-1 rounded-full shadow-lg flex items-center gap-1.5 uppercase tracking-wider">
                                <i class="fa-solid fa-medal"></i> {{ $badgePrestasi }}
                            </div>
                        </div>
                        <div class="p-5 flex flex-col justify-between flex-grow">
                            <div>
                                <div class="flex items-center gap-2 mb-2 text-xs font-semibold text-gray-500">
                                    @if(!empty($item->tipe))
                                        <span class="inline-flex items-center text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider text-[10px]">
                                            {{ $item->tipe }}
                                        </span>
                                    @endif
                                    @if(!empty($item->tahun))
                                        <span class="text-gray-400">
                                            <i class="fa-regular fa-calendar-alt mr-1"></i> {{ $item->tahun }}
                                        </span>
                                    @endif
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2 leading-snug">{{ $item->nama_kegiatan }}</h4>
                            </div>
                            @if(!empty($item->hasil))
                                <div class="text-xs font-bold text-blue-900 bg-blue-50/80 p-2.5 rounded-xl border border-blue-100/60 mt-3 flex items-center gap-2">
                                    <i class="fa-solid fa-award text-yellow-600"></i>
                                    <span>Pencapaian: {{ is_numeric($item->hasil) ? 'Juara ' . $item->hasil : $item->hasil }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fa-solid fa-trophy text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-600">Belum ada prestasi</h3>
                        <p class="text-gray-500">Daftar prestasi belum ditambahkan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 flex justify-center">
                {{ $prestasi->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection
