@extends('Pemantau.layouts.index')
@section('admin2')

<!-- ===== WELCOME ===== -->
<div class="mb-md md:mb-xl p-md md:p-lg bg-primary-container/10 border border-primary-container/30 rounded-xl">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-sm">
        <div>
            <h1 class="font-h2 md:font-h1 text-h2 md:text-h1 text-primary mb-xs">Notifikasi</h1>
            <p class="font-small md:font-body-regular text-small md:text-body-regular text-on-surface-variant max-w-3xl">Daftar semua notifikasi dan pengumuman terbaru untuk Anda.</p>
        </div>
    </div>
</div>

<!-- ===== NOTIFICATION STATS (Mobile Optimized) ===== -->
<div class="grid grid-cols-3 gap-2 sm:gap-3 md:gap-gutter mb-md md:mb-lg">
    <!-- Total Notifikasi -->
    <div class="bg-white rounded-xl shadow-sm border border-outline-variant p-2 sm:p-3 md:p-md flex flex-col items-center text-center">
        <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full bg-primary/10 flex items-center justify-center mb-1 sm:mb-2">
            <span class="material-symbols-outlined text-primary text-sm sm:text-base md:text-xl">notifications</span>
        </div>
        <div>
            <p class="font-small text-[10px] sm:text-xs md:text-small text-on-surface-variant">Total</p>
            <p class="font-h2 text-base sm:text-xl md:text-h2 text-on-surface font-bold">{{ auth()->user()->notifications->count() }}</p>
        </div>
    </div>

    <!-- Belum Dibaca -->
    <div class="bg-white rounded-xl shadow-sm border border-outline-variant p-2 sm:p-3 md:p-md flex flex-col items-center text-center">
        <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full bg-blue-500/10 flex items-center justify-center mb-1 sm:mb-2">
            <span class="material-symbols-outlined text-blue-500 text-sm sm:text-base md:text-xl">mark_email_unread</span>
        </div>
        <div>
            <p class="font-small text-[10px] sm:text-xs md:text-small text-on-surface-variant">Belum Dibaca</p>
            <p class="font-h2 text-base sm:text-xl md:text-h2 text-blue-500 font-bold">{{ auth()->user()->unreadNotifications->whereNull('read_at')->count() }}</p>
        </div>
    </div>

    <!-- Sudah Dibaca -->
    <div class="bg-white rounded-xl shadow-sm border border-outline-variant p-2 sm:p-3 md:p-md flex flex-col items-center text-center">
        <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full bg-green-500/10 flex items-center justify-center mb-1 sm:mb-2">
            <span class="material-symbols-outlined text-green-500 text-sm sm:text-base md:text-xl">mark_email_read</span>
        </div>
        <div>
            <p class="font-small text-[10px] sm:text-xs md:text-small text-on-surface-variant">Sudah Dibaca</p>
            <p class="font-h2 text-base sm:text-xl md:text-h2 text-green-500 font-bold">{{ $notifikasis->whereNotNull('read_at')->count() }}</p>
        </div>
    </div>
</div>

<!-- ===== NOTIFICATION LIST (Mobile Optimized) ===== -->
<div class="space-y-3 md:space-y-md">
    @forelse($notifikasis as $notif)
    <div class="bg-white rounded-xl border border-outline-variant custom-shadow overflow-hidden transition-all hover:shadow-md 
                {{ $notif->read_at ? 'border-l-4 border-l-green-500 opacity-75' : 'border-l-4 border-l-primary' }}">
        <div class="p-3 sm:p-4 md:p-lg">
            <div class="flex flex-col sm:flex-row sm:items-start gap-2 sm:gap-3 md:gap-4">
                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <!-- Header -->
                    <div class="flex flex-wrap items-center gap-1 sm:gap-2 mb-1 sm:mb-2">
                        @if(!$notif->read_at)
                            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse flex-shrink-0"></span>
                            <span class="px-1.5 py-0.5 bg-primary/10 text-primary text-[8px] sm:text-[10px] rounded-full font-bold flex-shrink-0">Baru</span>
                        @else
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 flex-shrink-0"></span>
                            <span class="px-1.5 py-0.5 bg-green-500/10 text-green-600 text-[8px] sm:text-[10px] rounded-full font-bold flex-shrink-0">Sudah Dibaca</span>
                        @endif
                        <h3 class="font-h3 text-sm sm:text-base md:text-h3 text-on-surface truncate {{ $notif->read_at ? 'text-on-surface-variant' : '' }}">
                            {{ $notif->data['judul'] }}
                        </h3>
                    </div>
                    
                    <!-- Pesan -->
                    <p class="font-body-regular text-xs sm:text-sm md:text-body-regular text-on-surface-variant mb-1 sm:mb-2 break-words">
                        {{ $notif->data['pesan'] }}
                    </p>
                    
                    <!-- Footer -->
                    <div class="flex flex-wrap items-center gap-1 sm:gap-2 md:gap-3">
                        <span class="font-caption text-[9px] sm:text-xs md:text-caption text-on-surface-variant flex items-center gap-0.5 sm:gap-1">
                            <span class="material-symbols-outlined text-[12px] sm:text-sm">schedule</span>
                            {{ $notif->created_at->diffForHumans() }}
                        </span>
                        <span class="font-caption text-[9px] sm:text-xs md:text-caption text-on-surface-variant flex items-center gap-0.5 sm:gap-1">
                            <span class="material-symbols-outlined text-[12px] sm:text-sm">calendar_today</span>
                            {{ $notif->created_at->format('d M Y H:i') }}
                        </span>
                        @if($notif->read_at)
                            <span class="font-caption text-[9px] sm:text-xs md:text-caption text-green-600 flex items-center gap-0.5 sm:gap-1">
                                <span class="material-symbols-outlined text-[12px] sm:text-sm">check_circle</span>
                                Dibaca {{ $notif->read_at->diffForHumans() }}
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Action Button (Mobile Optimized) -->
                <div class="flex-shrink-0 self-start sm:self-center">
                    @if(!$notif->read_at)
                    <form method="POST" action="{{ route('pemantaunotifikasi.read', $notif->id) }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center justify-center gap-0.5 sm:gap-1 px-2 sm:px-3 md:px-4 py-1 sm:py-1.5 md:py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-body-regular text-[10px] sm:text-xs md:text-small w-full sm:w-auto">
                            <span class="material-symbols-outlined text-[14px] sm:text-sm md:text-base">done_all</span>
                            <span class="hidden xs:inline">Tandai Dibaca</span>
                            <span class="inline xs:hidden">Baca</span>
                        </button>
                    </form>
                    @else
                    <span class="inline-flex items-center gap-0.5 sm:gap-1 px-2 sm:px-3 md:px-4 py-1 sm:py-1.5 md:py-2 bg-green-50 text-green-600 rounded-lg font-body-regular text-[10px] sm:text-xs md:text-small border border-green-200 w-full sm:w-auto justify-center">
                        <span class="material-symbols-outlined text-[14px] sm:text-sm md:text-base">check_circle</span>
                        <span class="hidden xs:inline">Sudah Dibaca</span>
                        <span class="inline xs:hidden">Dibaca</span>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <!-- Empty State -->
    <div class="bg-white rounded-xl border border-outline-variant custom-shadow p-md md:p-xl text-center">
        <span class="material-symbols-outlined text-4xl md:text-6xl text-on-surface-variant/30 block mb-sm md:mb-md">notifications_off</span>
        <h3 class="font-h3 text-base md:text-h3 text-on-surface mb-0.5 md:mb-xs">Tidak Ada Notifikasi</h3>
        <p class="font-body-regular text-xs md:text-body-regular text-on-surface-variant">Semua notifikasi sudah dibaca atau belum ada notifikasi baru.</p>
    </div>
    @endforelse
</div>

<!-- ===== PAGINATION ===== -->
@if($notifikasis->hasPages())
<div class="mt-md md:mt-xl">
    {{ $notifikasis->links() }}
</div>
@endif

<!-- ===== MOBILE OPTIMIZATION CSS ===== -->
<style>
    @media (max-width: 400px) {
        .grid-cols-3 {
            gap: 4px;
        }
        .grid-cols-3 > div {
            padding: 6px 4px;
        }
        .grid-cols-3 .material-symbols-outlined {
            font-size: 16px !important;
        }
        .grid-cols-3 .font-h2 {
            font-size: 14px !important;
        }
        .grid-cols-3 .font-small {
            font-size: 8px !important;
        }
        .grid-cols-3 .w-8.h-8 {
            width: 28px !important;
            height: 28px !important;
        }
    }
</style>

@endsection