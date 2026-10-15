<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $pengaturan = \App\Models\PengaturanWebsite::first();
        @endphp
        <title>{{ $pengaturan->nama_sekolah ?? 'Sekolah Unggulan' }} - @yield('title', 'Admin Panel')</title>

        <!-- Favicon -->
        @if(isset($pengaturan) && $pengaturan->logo)
            <link rel="icon" type="image/png" href="{{ storage_upload_url($pengaturan->logo) }}">
        @else
            <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23056ded' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'/%3E%3C/svg%3E">
        @endif
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
            .sidebar-bg { background-color: #1c3faa; }
            .content-bg { background-color: #f4f7fd; }
            
            /* Transparent Auto-Hide Scrollbar for Sidebar */
            .sidebar-scroll,
            .sidebar-bg nav {
                scrollbar-width: none; /* Hide by default in Firefox */
                -ms-overflow-style: none; /* Hide in IE/Edge */
                overscroll-behavior: contain;
                -webkit-overflow-scrolling: touch;
            }
            .sidebar-scroll::-webkit-scrollbar,
            .sidebar-bg nav::-webkit-scrollbar {
                width: 5px;
                height: 5px;
                background: transparent !important;
                background-color: transparent !important;
            }
            .sidebar-scroll::-webkit-scrollbar-track,
            .sidebar-bg nav::-webkit-scrollbar-track {
                background: transparent !important;
                background-color: transparent !important;
                border: none !important;
            }
            .sidebar-scroll::-webkit-scrollbar-thumb,
            .sidebar-bg nav::-webkit-scrollbar-thumb {
                background: transparent !important;
                background-color: transparent !important;
                border-radius: 9999px !important;
                border: none !important;
                transition: background-color 0.25s ease;
            }
            /* Reveal translucent thumb ONLY during scrolling or active drag */
            .sidebar-scroll.is-scrolling,
            .sidebar-bg nav.is-scrolling {
                scrollbar-width: thin;
                scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
            }
            .sidebar-scroll.is-scrolling::-webkit-scrollbar-thumb,
            .sidebar-bg nav.is-scrolling::-webkit-scrollbar-thumb,
            .sidebar-scroll:active::-webkit-scrollbar-thumb,
            .sidebar-bg nav:active::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.3) !important;
                background-color: rgba(255, 255, 255, 0.3) !important;
            }
            .sidebar-scroll.is-scrolling::-webkit-scrollbar-thumb:hover,
            .sidebar-bg nav.is-scrolling::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.55) !important;
                background-color: rgba(255, 255, 255, 0.55) !important;
            }
            .sidebar-scroll::-webkit-scrollbar-corner,
            .sidebar-bg nav::-webkit-scrollbar-corner {
                background: transparent !important;
                background-color: transparent !important;
            }
            
            .sidebar-item {
                position: relative;
                display: flex;
                align-items: center;
                padding: 0.75rem 1rem;
                color: rgba(255, 255, 255, 0.7);
                transition: background-color 0.3s, color 0.3s;
                border-top-left-radius: 9999px;
                border-bottom-left-radius: 9999px;
                margin-bottom: 0.25rem;
            }
            .sidebar-item:hover {
                color: #ffffff;
                background-color: rgba(255, 255, 255, 0.1);
            }
            .sidebar-item.active {
                background-color: #f4f7fd;
                color: #1c3faa !important;
                font-weight: 600;
            }
            .sidebar-item.active:hover {
                background-color: #f4f7fd;
            }

            /* Smooth Inverse Curves for Active Item */
            .curve-top, .curve-bottom {
                display: none;
            }
            .sidebar-item.active .curve-top,
            .sidebar-item.active .curve-bottom {
                display: block;
            }

            .curve-top {
                position: absolute;
                right: 0;
                bottom: 100%;
                width: 25px;
                height: 25px;
                background-color: #f4f7fd;
                pointer-events: none;
            }
            .curve-top::after {
                content: "";
                position: absolute;
                top: 0; left: 0; right: 0; bottom: 0;
                background-color: #1c3faa;
                border-bottom-right-radius: 25px;
            }

            .curve-bottom {
                position: absolute;
                right: 0;
                top: 100%;
                width: 25px;
                height: 25px;
                background-color: #f4f7fd;
                pointer-events: none;
            }
            .curve-bottom::after {
                content: "";
                position: absolute;
                top: 0; left: 0; right: 0; bottom: 0;
                background-color: #1c3faa;
                border-top-right-radius: 25px;
            }
        </style>
    </head>
    <body class="font-sans antialiased content-bg text-gray-900 overflow-hidden">
        <div class="fixed inset-0 flex w-full h-full overflow-hidden">
            <!-- Sidebar -->
            @include('layouts.navigation')

            <!-- Main Content -->
            <div class="flex-1 flex flex-col h-full overflow-hidden">
                <!-- Header -->
                <header class="bg-white border-b flex items-center justify-between px-6 py-4 flex-shrink-0">
                    <div class="flex items-center">
                        @isset($header)
                            <div class="font-semibold text-lg text-gray-800 leading-tight">
                                {{ $header }}
                            </div>
                        @else
                            <h2 class="font-semibold text-lg text-gray-800 leading-tight">Dashboard</h2>
                        @endisset
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="relative hidden md:block">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </span>
                            <input type="text" class="w-64 pl-10 pr-4 py-2 rounded-full border border-gray-200 bg-gray-50 text-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Search...">
                        </div>
                        
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 transition duration-150 ease-in-out">
                                    <img class="h-8 w-8 rounded-full object-cover mr-2" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=1c3faa&background=f4f7fd" alt="{{ Auth::user()->name }}" />
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <!-- Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto content-bg">
                    {{ $slot }}
                </main>
                
                <!-- Footer -->
                <footer class="bg-white p-4 text-center text-sm text-gray-500 flex-shrink-0 shadow-inner">
                    &copy; {{ date('Y') }} Powered admin panel by Sekolahku CMS
                </footer>
            </div>
        </div>
        
        @isset($scripts)
            {{ $scripts }}
        @endisset
    </body>
</html>
