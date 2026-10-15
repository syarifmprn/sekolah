@extends('layouts.frontend')
@section('title', $halaman->judul)

@section('content')
    <!-- Page Header (Card Style) -->
    <div class="pt-8 bg-white">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            <div class="bg-gradient-to-br from-[#056ded] to-blue-900 text-white py-12 md:py-16 rounded-[2rem] relative overflow-hidden shadow-xl">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
                <div class="relative z-10 text-center px-4">
                    <h1 class="text-3xl md:text-5xl font-extrabold mb-2">{{ $halaman->judul }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 bg-white">
        <div class="container mx-auto px-4 lg:px-8 max-w-4xl">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-12">
                <div class="prose prose-lg prose-blue max-w-none text-gray-700 text-justify">
                    {!! $halaman->konten !!}
                </div>
            </div>
        </div>
    </div>
@endsection
