@extends('layouts.frontend')
@section('title', $berita->judul)

@section('content')
    <!-- Page Header (Card Style) -->
    <div class="pt-8 bg-white">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="bg-gradient-to-br from-[#056ded] to-blue-900 text-white py-12 md:py-16 rounded-[2rem] relative overflow-hidden shadow-xl">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
                <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
                    <div class="bg-blue-800/50 backdrop-blur-md inline-block px-4 py-1 rounded-full text-blue-200 text-sm font-semibold mb-4 border border-blue-700">
                        <i class="fa-regular fa-calendar mr-2"></i> {{ $berita->tanggal ? \Carbon\Carbon::parse($berita->tanggal)->format('d F Y') : $berita->created_at->format('d F Y') }}
                    </div>
                    <h1 class="text-3xl md:text-5xl font-extrabold mb-2 leading-tight">{{ $berita->judul }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 bg-white">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Main Content -->
                <div class="lg:w-2/3">
                    <img src="{{ storage_upload_url($berita->thumbnail) }}" alt="{{ $berita->judul }}" class="w-full h-auto rounded-2xl shadow-md mb-8">
                    
                    <div class="prose prose-lg prose-blue max-w-none text-gray-700 text-justify">
                        {!! $berita->isi !!}
                    </div>

                    <!-- Share -->
                    <div class="mt-12 pt-8 border-t border-gray-100 flex items-center gap-4">
                        <span class="font-semibold text-gray-800">Bagikan:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($berita->judul) }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-sky-500 hover:bg-sky-500 hover:text-white transition-colors">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-green-500 hover:bg-green-500 hover:text-white transition-colors">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:w-1/3">
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 sticky top-28">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">Berita Lainnya</h3>
                        <div class="space-y-6">
                            @foreach($berita_lainnya as $lain)
                                <a href="{{ route('frontend.berita.show', $lain->id) }}" class="flex gap-4 group">
                                    <img src="{{ storage_upload_url($lain->thumbnail) }}" class="w-20 h-20 object-cover rounded-lg shadow-sm" alt="{{ $lain->judul }}">
                                    <div>
                                        <h4 class="font-bold text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-2 text-sm leading-snug mb-1">{{ $lain->judul }}</h4>
                                        <p class="text-xs text-gray-500"><i class="fa-regular fa-clock mr-1"></i> {{ $lain->tanggal ? \Carbon\Carbon::parse($lain->tanggal)->format('d M Y') : $lain->created_at->format('d M Y') }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
