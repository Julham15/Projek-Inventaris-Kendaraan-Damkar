@php
    $active = 'bg-secondary-fixed dark:bg-on-secondary-fixed-variant text-on-secondary-fixed dark:text-secondary-fixed';
    $normal = 'text-on-surface-variant dark:text-surface-variant hover:bg-surface-container dark:hover:bg-surface-container-high';
@endphp
<!-- SideNavBar -->
<aside class="hidden lg:flex flex-col gap-xs p-md h-screen w-[280px] fixed left-0 top-0 overflow-y-auto bg-white dark:bg-inverse-surface border-r border-outline-variant dark:border-outline z-50">
    
<div class="flex items-center gap-sm mb-lg px-xs py-sm">
<img alt="Admin Fire Dept Profile" class="w-12 h-12 rounded-full object-cover border border-outline-variant" src="{{ asset('assets/logo1.png') }}">
<div>
<h1 class="font-h2 text-h2 font-bold text-primary dark:text-inverse-primary">PEMADAM KEBAKARAN</h1>
<p class="font-small text-small text-on-surface-variant">Damkar Manise</p>
</div>

</div>
<nav class="flex-1 flex flex-col gap-xs">
<a href="{{ route('dashboard') }}"
class="flex items-center gap-md px-md py-sm rounded-lg transition-colors duration-200
{{ request()->routeIs('dashboard') ? $active : $normal }}">
    <span class="material-symbols-outlined">dashboard</span>
    <span class="font-h4 text-h4">Dashboard</span>
</a>
<a href="{{ route('pencarian.index') }}"
class="flex items-center gap-md px-md py-sm rounded-lg transition-colors duration-200
{{ request()->routeIs('pencarian.*') ? $active : $normal }}">
    <span class="material-symbols-outlined">search</span>
    <span class="font-h4 text-h4">Pencarian</span>
</a>
<a href="{{ route('posko.index') }}"
class="flex items-center gap-md px-md py-sm rounded-lg transition-colors duration-200
{{ request()->routeIs('posko.*') ? $active : $normal }}">
    <span class="material-symbols-outlined">domain</span>
    <span class="font-h4 text-h4">Data Pos</span>
</a>

<a href="{{ route('admin.laporan.index') }}"
class="flex items-center gap-md px-md py-sm rounded-lg transition-colors duration-200
{{ request()->routeIs('admin.laporan.*') ? $active : $normal }}">
    <span class="material-symbols-outlined">assessment</span>
    <span class="font-h4 text-h4">Laporan</span>
</a>
<a href="{{ route('pengguna.index') }}"
class="flex items-center gap-md px-md py-sm rounded-lg transition-colors duration-200
{{ request()->routeIs('pengguna.*') ? $active : $normal }}">
    <span class="material-symbols-outlined">group</span>
    <span class="font-h4 text-h4">Manajemen Pengguna</span>
</a>
<a href="{{ route('platon.index') }}"
class="flex items-center gap-md px-md py-sm rounded-lg transition-colors duration-200
{{ request()->routeIs('platon.*') ? $active : $normal }}">
    <span class="material-symbols-outlined">format_list_bulleted</span>
    <span class="font-h4 text-h4">Manajemen Peleton</span>
</a>
<a href="{{ route('notifikasi.index') }}"
   class="flex items-center gap-md px-md py-sm rounded-lg transition-colors duration-200
   {{ request()->routeIs('notifikasi.*') ? $active : $normal }}">

    <span class="material-symbols-outlined">notifications</span>

    <span class="font-h4 text-h4">Notifikasi</span>

    @if(auth()->user()->unreadNotifications->count() > 0)
        <span class="badge bg-error text-white text-[10px] flex items-center justify-center rounded-full font-bold w-5 h-5">
            {{ auth()->user()->unreadNotifications->count() }}
        </span>
    @endif
</a>
<div class="mt-auto border-t border-outline-variant pt-md flex flex-col gap-sm">

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button
            type="submit"
            class="w-full flex items-center gap-md px-md py-sm text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors duration-200 text-left text-red-400">

            <span class="material-symbols-outlined">
                logout
            </span>

            <span class="font-h4 text-h4">
                Logout
            </span>

        </button>
    </form>

</div>
</nav>

</aside>

