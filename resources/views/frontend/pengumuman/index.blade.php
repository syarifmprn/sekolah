@extends('layouts.frontend')
@section('title', 'Pengumuman')

@section('content')
    <!-- Page Header (Card Style) -->
    <div class="pt-8 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="bg-gradient-to-br from-[#056ded] to-blue-900 text-white py-12 md:py-16 rounded-[2rem] relative overflow-hidden shadow-xl">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
                <div class="relative z-10 text-center px-4">
                    <h1 class="text-3xl md:text-5xl font-extrabold mb-4">Pengumuman</h1>
                    <p class="text-blue-200 text-lg max-w-2xl mx-auto">Kumpulan informasi dan pengumuman resmi terbaru untuk seluruh civitas akademika.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @forelse($pengumuman as $item)
                    <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow border border-gray-100 overflow-hidden flex flex-col h-full group">
                        <div class="p-6 flex flex-col flex-grow relative">
                            <!-- Label Pengumuman -->
                            <div class="mb-4 text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-full inline-block self-start border border-blue-100">
                                <i class="fa-regular fa-calendar-alt mr-1"></i> {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : $item->created_at->format('d M Y') }}
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3 leading-tight group-hover:text-blue-600 transition-colors">
                                {{ $item->judul }}
                            </h4>
                            <p class="text-gray-500 text-sm mb-6 flex-grow">{{ Str::limit(strip_tags($item->isi), 100) }}</p>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fa-solid fa-bullhorn text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-600">Belum ada pengumuman</h3>
                        <p class="text-gray-500">Pengumuman resmi akan segera hadir.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 flex justify-center">
                {{ $pengumuman->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection
