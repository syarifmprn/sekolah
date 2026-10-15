@extends('layouts.frontend')
@section('title', 'Berita')

@section('content')
    <!-- Page Header (Card Style) -->
    <div class="pt-8 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="bg-gradient-to-br from-[#056ded] to-blue-900 text-white py-12 md:py-16 rounded-[2rem] relative overflow-hidden shadow-xl">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
                <div class="relative z-10 text-center px-4">
                    <h1 class="text-3xl md:text-5xl font-extrabold mb-4">Berita & Informasi</h1>
                    <p class="text-blue-200 text-lg max-w-2xl mx-auto">Kumpulan berita, pengumuman, dan artikel terbaru seputar kegiatan akademik dan non-akademik.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @forelse($berita as $item)
                    <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow border border-gray-100 overflow-hidden flex flex-col h-full group">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ storage_upload_url($item->thumbnail) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-blue-600">
                                {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : $item->created_at->format('d M Y') }}
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h4 class="text-xl font-bold text-gray-900 mb-3 leading-tight group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('frontend.berita.show', $item->id) }}">{{ $item->judul }}</a>
                            </h4>
                            <p class="text-gray-500 text-sm mb-6 flex-grow">{{ Str::limit(strip_tags($item->isi), 100) }}</p>
                            <a href="{{ route('frontend.berita.show', $item->id) }}" class="inline-flex items-center font-bold text-sm text-blue-600 hover:text-blue-800 transition-colors mt-auto">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fa-solid fa-newspaper text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-600">Belum ada berita</h3>
                        <p class="text-gray-500">Berita dan informasi terbaru akan segera hadir.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 flex justify-center">
                {{ $berita->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection
