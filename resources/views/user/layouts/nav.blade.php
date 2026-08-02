<!-- Navbar Bottom untuk Mobile -->
<nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-surface-container-low border-t border-outline-variant z-50">
    <div class="flex justify-around items-center px-2 py-1">
        <!-- Dashboard -->
        <a href="{{ route('dashboard-user') }}" 
           class="flex flex-col items-center py-1 px-3 rounded-lg transition-all
           {{ request()->routeIs('dashboard-user') 
                ? 'text-primary' 
                : 'text-on-surface-variant hover:text-primary' }}">
            <span class="material-symbols-outlined text-2xl">dashboard</span>
            <span class="text-[10px] font-medium mt-0.5">Dashboard</span>
        </a>

        <!-- Laporan -->
        <a href="{{ route('laporan.index') }}"
           class="flex flex-col items-center py-1 px-3 rounded-lg transition-all
           {{ request()->routeIs('laporan.*') 
                ? 'text-primary' 
                : 'text-on-surface-variant hover:text-primary' }}">
            <span class="material-symbols-outlined text-2xl">add_box</span>
            <span class="text-[10px] font-medium mt-0.5">Laporan</span>
        </a>

        <!-- Notifikasi dengan Badge -->
        <a href="{{ route('user.notifikasi.index') }}"
           class="flex flex-col items-center py-1 px-3 rounded-lg transition-all relative
           {{ request()->routeIs('user.notifikasi.*') 
                ? 'text-primary' 
                : 'text-on-surface-variant hover:text-primary' }}">
            <div class="relative">
                <span class="material-symbols-outlined text-2xl">notifications</span>
                @php
                    $unreadCount = auth()->user()->unreadNotifications()->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </div>
            <span class="text-[10px] font-medium mt-0.5">Notifikasi</span>
        </a>

        <!-- Profil -->
        <a href="{{ route('profile.edit') }}"
           class="flex flex-col items-center py-1 px-3 rounded-lg transition-all
           {{ request()->routeIs('profile.*') 
                ? 'text-primary' 
                : 'text-on-surface-variant hover:text-primary' }}">
            <span class="material-symbols-outlined text-2xl">person</span>
            <span class="text-[10px] font-medium mt-0.5">Profil</span>
        </a>
    </div>
</nav>

<!-- Sidebar untuk Desktop (tetap seperti sebelumnya) -->
<aside class="hidden lg:flex flex-col h-screen w-64 fixed left-0 top-0 bg-surface-container-low border-r border-outline-variant pt-20">
    <div class="px-md mb-lg">
        <div class="flex items-center gap-4 mb-xl">
            {{-- Logo DAMKAR --}}
            <div class="rounded-full overflow-hidden border-primary flex items-center justify-center shadow-sm">
                <img src="{{ asset('assets/logo1.png') }}"
                     alt="Logo Damkar"
                     class="h-17 w-17" style="filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3))">
            </div>

            {{-- Nama Aplikasi --}}
            <div>
                <p class="font-h4 text-h4 font-bold text-primary" style="font-size: 20px">
                    PEMADAM KEBAKARAN
                </p>
                <p class="text-small font-small text-on-surface-variant">
                    Damkar Manise
                </p>
            </div>
        </div>
        
        <nav class="flex flex-col gap-xs">
            <!-- Menu items sama seperti sebelumnya -->
            <a href="{{ route('dashboard-user') }}"
               class="flex items-center gap-md p-md rounded-lg transition-all
               {{ request()->routeIs('dashboard-user') 
                    ? 'bg-primary-container text-on-primary-container' 
                    : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-h4 text-h4">Dashboard</span>
            </a>

            <a href="{{ route('laporan.index') }}"
               class="flex items-center gap-md p-md rounded-lg transition-all
               {{ request()->routeIs('laporan.*') 
                    ? 'bg-primary-container text-on-primary-container' 
                    : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                <span class="material-symbols-outlined">add_box</span>
                <span class="font-h4 text-h4">Buat Laporan</span>
            </a>

            <a href="{{ route('user.notifikasi.index') }}"
               class="flex items-center justify-between p-md rounded-lg transition-all
               {{ request()->routeIs('user.notifikasi.*') 
                    ? 'bg-primary-container text-on-primary-container' 
                    : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                <div class="flex items-center gap-md">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="font-h4 text-h4">Notifikasi</span>
                </div>
                @if($unreadCount > 0)
                    <span class="min-w-[22px] h-[22px] px-1 rounded-full bg-red-500 text-white text-xs font-bold flex items-center justify-center">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </a>

            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-md p-md rounded-lg transition-all
               {{ request()->routeIs('profile.*') 
                    ? 'bg-primary-container text-on-primary-container' 
                    : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                <span class="material-symbols-outlined">person</span>
                <span class="font-h4 text-h4">Profil</span>
            </a>
        </nav>
    </div>
    
    <div class="mt-auto p-md border-t border-outline-variant">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full text-on-surface-variant mx-2 my-1 p-md flex items-center gap-md hover:bg-error-container hover:text-error rounded-lg transition-all">
                <span class="material-symbols-outlined">logout</span>
                <span class="font-h4 text-h4">Keluar</span>
            </button>
        </form>
    </div>
</aside>

<!-- Tambahkan padding bottom di konten utama untuk mobile -->
<style>
    /* Padding bottom untuk konten utama di mobile */
    @media (max-width: 1023px) {
        .main-content {
            padding-bottom: 70px; /* Sesuaikan dengan tinggi navbar */
        }
    }

    /* Animasi active state untuk bottom nav */
    .bottom-nav-active {
        position: relative;
    }
    
    .bottom-nav-active::after {
        content: '';
        position: absolute;
        top: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 3px;
        background-color: currentColor;
        border-radius: 2px;
    }

    /* Efek hover yang halus */
    .bottom-nav-item {
        transition: all 0.2s ease;
    }
    
    .bottom-nav-item:active {
        transform: scale(0.92);
    }
</style>