@extends('admin.layouts')
@section('navbar')
<!-- Main Content Area -->
<main class="flex-1 flex flex-col lg:pl-[280px] w-full h-full overflow-hidden relative">
<!-- TopNavBar -->
<header class="flex justify-between items-center w-full px-lg py-md sticky top-0 z-40 bg-white border-b border-outline-variant">
    <div class="flex items-center gap-md">
        <button class="lg:hidden text-on-surface-variant hover:text-primary transition-colors p-sm rounded-lg hover:bg-surface-container">
            <span class="material-symbols-outlined" data-icon="menu">menu</span>
        </button>
        <span class="font-h2 text-h2 font-bold text-primary">Notifikasi</span>
    </div>
    <div class="flex-1 max-w-md mx-lg hidden md:block">
        <div class="relative">
            <!-- Search bar jika diperlukan -->
        </div>
    </div>
    <div class="flex items-center gap-sm">
        <!-- Tombol tambahan jika diperlukan -->
    </div>
</header>

<!-- Page Content -->
<div class="p-lg md:p-margin flex-1 overflow-x-hidden">
    <!-- Page Header with Back Button -->
    <div class="flex items-center gap-md mb-lg">
        
        <div>
           
            <p class="font-body-regular text-body-regular text-on-surface-variant mt-1">
                Semua notifikasi dan pemberitahuan sistem
            </p>
        </div>
    </div>

    <!-- Notifikasi Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-lg">
        <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-md flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-[#38B6FF]/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-[#38B6FF]">notifications</span>
            </div>
            <div>
                <p class="font-small text-small text-on-surface-variant">Total Notifikasi</p>
                <p class="font-h2 text-h2 text-on-surface font-bold">{{auth()->user()->notifications->count()}}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-md flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-500">mark_email_unread</span>
            </div>
            <div>
                <p class="font-small text-small text-on-surface-variant">Belum Dibaca</p>
                <p class="font-h2 text-h2 text-blue-500 font-bold">{{ $notifikasis->whereNull('read_at')->count() }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-md flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-green-500">mark_email_read</span>
            </div>
            <div>
                <p class="font-small text-small text-on-surface-variant">Sudah Dibaca</p>
                <p class="font-h2 text-h2 text-green-500 font-bold">{{ $notifikasis->whereNotNull('read_at')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Daftar Notifikasi -->
    <div class="space-y-md">
        @forelse($notifikasis as $notif)
        <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-lg transition-all hover:shadow-md
            {{ $notif->read_at ? 'border-l-4 border-l-green-500' : 'border-l-4 border-l-[#38B6FF]' }}">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-md">
                <!-- Konten Notifikasi -->
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="material-symbols-outlined text-[#38B6FF]">
                            {{ $notif->data['icon'] ?? 'notifications' }}
                        </span>
                        <h3 class="font-h3 text-h3 text-on-surface 
                            {{ $notif->read_at ? 'text-on-surface' : 'font-bold' }}">
                            {{ $notif->data['judul'] ?? 'Notifikasi' }}
                        </h3>
                        @if(!$notif->read_at)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-[#38B6FF] text-white">
                            Baru
                        </span>
                        @endif
                    </div>
                    <p class="font-body-regular text-body-regular text-on-surface-variant mb-2">
                        {{ $notif->data['pesan'] ?? 'Tidak ada pesan' }}
                    </p>
                    <div class="flex items-center gap-4 text-on-surface-variant">
                        <span class="font-small text-small flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">schedule</span>
                            {{ $notif->created_at->diffForHumans() }}
                        </span>
                        @if($notif->read_at)
                        <span class="font-small text-small flex items-center gap-1 text-green-600">
                            <span class="material-symbols-outlined text-[16px]">check_circle</span>
                            Dibaca {{ $notif->read_at->diffForHumans() }}
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Tombol Aksi -->
               <!-- Tombol Aksi -->
<div class="flex items-center gap-2">
    @if(!$notif->read_at)
    <form method="POST" action="{{ route('notifikasi.read', $notif->id) }}" class="inline">
        @csrf
        <button type="submit" 
                class="px-4 py-2 rounded-lg bg-[#38B6FF] text-white font-h4 text-h4 hover:bg-[#0A8FD6] transition-colors shadow-sm active:scale-[0.98] flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">done</span>
            Tandai Dibaca
        </button>
    </form>
    @else
    <span class="px-4 py-2 rounded-lg bg-green-50 text-green-600 font-h4 text-h4 flex items-center gap-1 border border-green-200">
        <span class="material-symbols-outlined text-[18px]">check_circle</span>
        Sudah Dibaca
    </span>
    @endif

    {{-- Tombol Hapus --}}
    <form method="POST" action="{{ route('notifikasi.destroy', $notif->id) }}" class="inline"
          onsubmit="return confirm('Hapus notifikasi ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="p-2 rounded-lg text-red-500 hover:bg-red-50 transition-colors active:scale-[0.98]">
            <span class="material-symbols-outlined text-[18px]">delete</span>
        </button>
    </form>
</div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-lg">
            <div class="flex flex-col items-center justify-center py-12">
                <span class="material-symbols-outlined text-6xl text-outline mb-3">notifications_off</span>
                <p class="font-h4 text-h4 text-on-surface-variant">Tidak ada notifikasi</p>
                <p class="text-sm text-on-surface-variant mt-1">Belum ada notifikasi yang masuk</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifikasis instanceof \Illuminate\Pagination\LengthAwarePaginator && $notifikasis->total() > 0)
    <div class="mt-lg py-sm px-md border-t border-[#D1E9F6] bg-white rounded-xl shadow-sm border border-[#D1E9F6] flex flex-col sm:flex-row justify-between items-center gap-4">
        <p class="font-small text-small text-on-surface-variant">
            Menampilkan {{ $notifikasis->firstItem() ?? 0 }} hingga {{ $notifikasis->lastItem() ?? 0 }} dari {{ $notifikasis->total() }} notifikasi
        </p>
        <div class="flex items-center gap-1">
            <!-- Tombol Previous -->
            @if($notifikasis->onFirstPage())
            <button class="p-1 rounded text-on-surface-variant/50 cursor-not-allowed" disabled>
                <span class="material-symbols-outlined text-[20px]">chevron_left</span>
            </button>
            @else
            <a href="{{ $notifikasis->previousPageUrl() }}" 
               class="p-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-[20px]">chevron_left</span>
            </a>
            @endif

            <!-- Nomor Halaman -->
            @foreach($notifikasis->getUrlRange(1, $notifikasis->lastPage()) as $page => $url)
                @if($page == $notifikasis->currentPage())
                    <button class="w-8 h-8 rounded bg-[#38B6FF] text-white font-body-regular text-body-regular flex items-center justify-center">
                        {{ $page }}
                    </button>
                @else
                    <a href="{{ $url }}" 
                       class="w-8 h-8 rounded hover:bg-surface-container text-on-surface-variant font-body-regular text-body-regular flex items-center justify-center transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            <!-- Tombol Next -->
            @if($notifikasis->hasMorePages())
            <a href="{{ $notifikasis->nextPageUrl() }}" 
               class="p-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-[20px]">chevron_right</span>
            </a>
            @else
            <button class="p-1 rounded text-on-surface-variant/50 cursor-not-allowed" disabled>
                <span class="material-symbols-outlined text-[20px]">chevron_right</span>
            </button>
            @endif
        </div>
    </div>
    @endif
</div>
</main>

<style>
/* Animasi untuk notifikasi baru */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.border-l-4 {
    animation: slideIn 0.3s ease-out;
}

/* Hover effect untuk card info */
.bg-\[\#E6F6FF\]\/20:hover {
    background-color: rgba(230, 246, 255, 0.4);
    transition: background-color 0.3s ease;
}

/* Styling untuk notifikasi belum dibaca */
.border-l-\[#38B6FF\] {
    border-left-color: #38B6FF;
}

/* Styling untuk notifikasi sudah dibaca */
.border-l-green-500 {
    border-left-color: #22C55E;
}

/* Badge Baru */
.bg-\[\#38B6FF\] {
    background-color: #38B6FF;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide flash messages jika ada
    setTimeout(function() {
        document.querySelectorAll('.flash-message').forEach(msg => {
            msg.style.transition = 'opacity 0.5s';
            msg.style.opacity = '0';
            setTimeout(() => msg.style.display = 'none', 500);
        });
    }, 5000);

    // Animasi masuk untuk notifikasi baru
    document.querySelectorAll('.border-l-4').forEach((item, index) => {
        item.style.animationDelay = (index * 0.05) + 's';
    });
});
</script>
@endsection