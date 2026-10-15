<div class="w-72 sidebar-bg text-white flex flex-col h-full flex-shrink-0">
    <div class="flex items-center justify-center h-20 flex-shrink-0">
        <div class="flex items-center gap-2">
            <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
            </svg>
            <span class="text-2xl font-bold tracking-wider">Sekolahku</span>
        </div>
    </div>
    
    <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 pl-4 pr-0">
        <ul class="space-y-0 text-sm">
            <li>
                <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
            </li>

            @if(Auth::user()->role === 'superadmin' || Auth::user()->hasAnyPermission(['berita', 'prestasi', 'pengumuman', 'guru', 'galeri', 'halaman', 'statistik', 'ekstrakurikuler', 'prasarana', 'sarana', 'alumni']))
            <li class="pt-6 pb-2 px-4 text-xs font-semibold text-white/50 uppercase tracking-wider">Modul Data</li>
            
            @if(Auth::user()->hasPermission('berita'))
            <li>
                <a href="{{ route('admin.berita.index') }}" class="sidebar-item {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    Berita
                </a>
            </li>
            @endif
            
            @if(Auth::user()->hasPermission('prestasi'))
            <li>
                <a href="{{ route('admin.prestasi.index') }}" class="sidebar-item {{ request()->routeIs('admin.prestasi.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    Prestasi
                </a>
            </li>
            @endif
            
            @if(Auth::user()->hasPermission('pengumuman'))
            <li>
                <a href="{{ route('admin.pengumuman.index') }}" class="sidebar-item {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    Pengumuman
                </a>
            </li>
            @endif
            
            @if(Auth::user()->hasPermission('guru'))
            <li>
                <a href="{{ route('admin.guru.index') }}" class="sidebar-item {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Guru
                </a>
            </li>
            @endif
            
            @if(Auth::user()->hasPermission('galeri'))
            <li>
                <a href="{{ route('admin.galeri.index') }}" class="sidebar-item {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Galeri
                </a>
            </li>
            @endif
            
            @if(Auth::user()->hasPermission('halaman'))
            <li>
                <a href="{{ route('admin.halaman.index') }}" class="sidebar-item {{ request()->routeIs('admin.halaman.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Halaman
                </a>
            </li>
            @endif

            @if(Auth::user()->hasPermission('statistik'))
            <li>
                <a href="{{ route('admin.statistik.index') }}" class="sidebar-item {{ request()->routeIs('admin.statistik.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Statistik
                </a>
            </li>
            @endif

            @if(Auth::user()->hasPermission('ekstrakurikuler'))
            <li>
                <a href="{{ route('admin.ekstrakurikuler.index') }}" class="sidebar-item {{ request()->routeIs('admin.ekstrakurikuler.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <i class="fa-solid fa-people-group w-5 h-5 mr-3 text-center text-base"></i>
                    Ekstrakurikuler
                </a>
            </li>
            @endif

            @if(Auth::user()->hasPermission('prasarana'))
            <li>
                <a href="{{ route('admin.prasarana.index') }}" class="sidebar-item {{ request()->routeIs('admin.prasarana.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <i class="fa-solid fa-building w-5 h-5 mr-3 text-center text-base"></i>
                    Prasarana
                </a>
            </li>
            @endif

            @if(Auth::user()->hasPermission('sarana'))
            <li>
                <a href="{{ route('admin.sarana.index') }}" class="sidebar-item {{ request()->routeIs('admin.sarana.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <i class="fa-solid fa-boxes-stacked w-5 h-5 mr-3 text-center text-base"></i>
                    Sarana (Barang)
                </a>
            </li>
            @endif

            @if(Auth::user()->hasPermission('alumni'))
            <li>
                <a href="{{ route('admin.alumni.index') }}" class="sidebar-item {{ request()->routeIs('admin.alumni.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <i class="fa-solid fa-user-graduate w-5 h-5 mr-3 text-center text-base"></i>
                    Alumni
                </a>
            </li>
            @endif
            @endif
            
            @if(Auth::user()->role === 'superadmin' || Auth::user()->hasAnyPermission(['menu', 'sub-menu', 'pengaturan-website']))
            <li class="pt-6 pb-2 px-4 text-xs font-semibold text-white/50 uppercase tracking-wider">Pengaturan</li>
            
            @if(Auth::user()->hasPermission('menu'))
            <li>
                <a href="{{ route('admin.menu.index') }}" class="sidebar-item {{ request()->routeIs('admin.menu.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    Menu
                </a>
            </li>
            @endif
            
            @if(Auth::user()->hasPermission('sub-menu'))
            <li>
                <a href="{{ route('admin.sub-menu.index') }}" class="sidebar-item {{ request()->routeIs('admin.sub-menu.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"></path></svg>
                    Sub Menu
                </a>
            </li>
            @endif

            @if(Auth::user()->hasPermission('pengaturan-website'))
            <li>
                <a href="{{ route('admin.pengaturan-website.index') }}" class="sidebar-item {{ request()->routeIs('admin.pengaturan-website.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    Pengaturan Website
                </a>
            </li>
            @endif

            @if(Auth::user()->role === 'superadmin')
            <li>
                <a href="{{ route('admin.user.index') }}" class="sidebar-item {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                    <span class="curve-top"></span>
                    <span class="curve-bottom"></span>
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Pengguna
                </a>
            </li>
            @endif
            @endif
        </ul>
    </nav>
</div>

<script>
    (function () {
        function setupSidebarScroll() {
            const sidebarNav = document.querySelector('.sidebar-scroll');
            if (!sidebarNav) return;

            let scrollTimer = null;
            const activateScroll = function () {
                sidebarNav.classList.add('is-scrolling');
                clearTimeout(scrollTimer);
                scrollTimer = setTimeout(function () {
                    sidebarNav.classList.remove('is-scrolling');
                }, 1000);
            };

            sidebarNav.addEventListener('scroll', activateScroll, { passive: true });
            sidebarNav.addEventListener('wheel', activateScroll, { passive: true });
            sidebarNav.addEventListener('touchmove', activateScroll, { passive: true });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupSidebarScroll);
        } else {
            setupSidebarScroll();
        }
    })();
</script>
