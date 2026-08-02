<aside class="fixed left-0 top-0 h-screen w-64 z-50 bg-white border-r border-outline-variant flex flex-col py-lg px-md">

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
                <a href="{{ route('pemantau.profil') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors  {{ activeMenu('profile.edit') }}">
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