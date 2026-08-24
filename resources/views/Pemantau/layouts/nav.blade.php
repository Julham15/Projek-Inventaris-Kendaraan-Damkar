<!-- ===== OVERLAY ===== -->
<div id="sidebarOverlay" class="sidebar-overlay" onclick="closeSidebar()"></div>

<!-- ===== SIDEBAR DESKTOP (tetap seperti sebelumnya) ===== -->
<aside id="sidebarDesktop" class="sidebar-desktop fixed left-0 top-0 h-screen w-64 z-50 bg-white border-r border-outline-variant flex flex-col py-lg px-md">
    <!-- Brand -->
    <div class="flex items-center gap-md mb-xl px-xs">
        <div class="rounded-full overflow-hidden border-primary flex items-center justify-center shadow-sm">
            <img src="{{ asset('assets/logo1.png') }}"
                 alt="Logo Damkar"
                 class="h-17 w-17" style="filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3))">
        </div>
        <div>
            <p class="font-h4 text-h4 font-bold text-primary" style="font-size: 20px">
                PEMADAM KEBAKARAN
            </p>
            <p class="text-small font-small text-on-surface-variant">
                Damkar Manise
            </p>
        </div>
    </div>

    @php
    function activeMenu($route){
        return request()->routeIs($route)
            ? 'bg-surface-container-low text-primary font-bold'
            : 'text-on-surface-variant hover:bg-surface-container-high';
    }
    @endphp

    <!-- Nav -->
    <nav class="flex-1 flex flex-col gap-xs">
        <a href="{{ route('dashboard-pemantau') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('dashboard-pemantau') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-body-regular text-body-regular">Dashboard</span>
        </a>
        <a href="{{ route('pemantau.laporan.index') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('pemantau.laporan.index') }}">
            <span class="material-symbols-outlined">description</span>
            <span class="font-body-regular text-body-regular">Laporan</span>
        </a>
        <a href="{{ route('pemantaunotifikasi.index') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('pemantaunotifikasi.index') }} relative">
            <span class="material-symbols-outlined">notifications</span>
            <span class="font-body-regular text-body-regular">Notifikasi</span>
            <span class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 bg-error text-white text-[10px] flex items-center justify-center rounded-full font-bold">{{ auth()->user()->unreadNotifications->count() }}</span>
        </a>
        <a href="{{ route('pemantau.profil') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('profile.edit') }}">
            <span class="material-symbols-outlined">person</span>
            <span class="font-body-regular text-body-regular">Profil</span>
        </a>
    </nav>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-lg border-t border-outline-variant">
        @csrf
        <button type="submit" class="w-full flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors">
            <span class="material-symbols-outlined">logout</span>
            <span class="font-body-regular text-body-regular">Keluar</span>
        </button>
    </form>
</aside>

<!-- ===== SIDEBAR MOBILE (slide from left) ===== -->
<aside id="sidebarMobile" class="sidebar-mobile fixed left-0 top-0 h-screen w-72 z-50 bg-white border-r border-outline-variant flex-col py-lg px-md shadow-2xl" style="display: none;">
    <!-- Close button -->
    <div class="flex justify-end mb-md">
        <button onclick="closeSidebar()" class="p-2 hover:bg-surface-container-high rounded-lg transition-colors">
            <span class="material-symbols-outlined text-2xl">close</span>
        </button>
    </div>

    <!-- Brand -->
    <div class="flex items-center gap-md mb-xl px-xs">
        <div class="rounded-full overflow-hidden border-primary flex items-center justify-center shadow-sm">
            <img src="{{ asset('assets/logo1.png') }}"
                 alt="Logo Damkar"
                 class="h-14 w-14" style="filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3))">
        </div>
        <div>
            <p class="font-h4 text-h4 font-bold text-primary" style="font-size: 18px">
                PEMADAM KEBAKARAN
            </p>
            <p class="text-small font-small text-on-surface-variant">
                Damkar Manise
            </p>
        </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 flex flex-col gap-xs">
        <a href="{{ route('dashboard-pemantau') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('dashboard-pemantau') }}" onclick="closeSidebar()">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-body-regular text-body-regular">Dashboard</span>
        </a>
        <a href="{{ route('pemantau.laporan.index') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('pemantau.laporan.index') }}" onclick="closeSidebar()">
            <span class="material-symbols-outlined">description</span>
            <span class="font-body-regular text-body-regular">Laporan</span>
        </a>
        <a href="{{ route('pemantaunotifikasi.index') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('pemantaunotifikasi.index') }} relative" onclick="closeSidebar()">
            <span class="material-symbols-outlined">notifications</span>
            <span class="font-body-regular text-body-regular">Notifikasi</span>
            <span class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 bg-error text-white text-[10px] flex items-center justify-center rounded-full font-bold">{{ auth()->user()->unreadNotifications->count() }}</span>
        </a>
        <a href="{{ route('pemantau.profil') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('profile.edit') }}" onclick="closeSidebar()">
            <span class="material-symbols-outlined">person</span>
            <span class="font-body-regular text-body-regular">Profil</span>
        </a>
    </nav>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-lg border-t border-outline-variant">
        @csrf
        <button type="submit" class="w-full flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors">
            <span class="material-symbols-outlined">logout</span>
            <span class="font-body-regular text-body-regular">Keluar</span>
        </button>
    </form>
</aside>

<!-- ===== MOBILE HEADER with Hamburger ===== -->
<header class="mobile-header" id="mobileHeader">
    <div class="flex items-center gap-3">
        <!-- Hamburger Button -->
        <button id="hamburgerBtn" class="hamburger-btn p-2 rounded-lg hover:bg-surface-container-high transition-colors" onclick="toggleSidebar()">
            <div class="hamburger-icon" id="hamburgerIcon">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        
        <!-- Logo kecil di header mobile -->
        <div class="flex items-center gap-2">
            <img src="{{ asset('assets/logo1.png') }}"
                 alt="Logo"
                 class="h-8 w-8">
            <span class="font-bold text-primary text-sm">Damkar Manise</span>
        </div>
    </div>
    
    <!-- Notifikasi icon di header mobile -->
    <a href="{{ route('pemantaunotifikasi.index') }}" class="relative p-2 hover:bg-surface-container-high rounded-lg transition-colors">
        <span class="material-symbols-outlined">notifications</span>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-error text-white text-[8px] flex items-center justify-center rounded-full font-bold">{{ auth()->user()->unreadNotifications->count() }}</span>
        @endif
    </a>
</header>