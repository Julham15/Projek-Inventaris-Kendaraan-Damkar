@extends('Pemantau.layouts.index')
@section('admin2')

<!-- ===== WELCOME ===== -->
<div class="mb-xl p-lg bg-primary-container/10 border border-primary-container/30 rounded-xl">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-h1 text-h1 text-primary mb-xs">Notifikasi</h1>
            <p class="font-body-regular text-body-regular text-on-surface-variant max-w-3xl">Daftar semua notifikasi dan pengumuman terbaru untuk Anda.</p>
        </div>
    </div>
</div>

<!-- ===== NOTIFICATION STATS ===== -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-lg">
    <div class="bg-white rounded-xl shadow-sm border border-outline-variant p-md flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
            <span class="material-symbols-outlined text-primary">notifications</span>
        </div>
        <div>
            <p class="font-small text-small text-on-surface-variant">Total Notifikasi</p>
            <p class="font-h2 text-h2 text-on-surface font-bold">{{auth()->user()->notifications->count()}}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-outline-variant p-md flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center">
            <span class="material-symbols-outlined text-blue-500">mark_email_unread</span>
        </div>
        <div>
            <p class="font-small text-small text-on-surface-variant">Belum Dibaca</p>
            <p class="font-h2 text-h2 text-blue-500 font-bold">{{ auth()->user()->unreadNotifications->whereNull('read_at')->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-outline-variant p-md flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center">
            <span class="material-symbols-outlined text-green-500">mark_email_read</span>
        </div>
        <div>
            <p class="font-small text-small text-on-surface-variant">Sudah Dibaca</p>
            <p class="font-h2 text-h2 text-green-500 font-bold">{{ $notifikasis->whereNotNull('read_at')->count() }}</p>
        </div>
    </div>
</div>

<!-- ===== NOTIFICATION LIST ===== -->
<div class="space-y-md">
    @forelse($notifikasis as $notif)
    <div class="bg-white rounded-xl border border-outline-variant custom-shadow overflow-hidden transition-all hover:shadow-md 
                {{ $notif->read_at ? 'border-l-4 border-l-green-500 opacity-75' : 'border-l-4 border-l-primary' }}">
        <div class="p-lg">
            <div class="flex items-start justify-between gap-md">
                <div class="flex-1">
                    <!-- Header -->
                    <div class="flex items-center gap-sm mb-xs">
                        @if(!$notif->read_at)
                            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                            <span class="px-sm py-xs bg-primary/10 text-primary text-[10px] rounded-full font-bold">Baru</span>
                        @else
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            <span class="px-sm py-xs bg-green-500/10 text-green-600 text-[10px] rounded-full font-bold">Sudah Dibaca</span>
                        @endif
                        <h3 class="font-h3 text-h3 text-on-surface {{ $notif->read_at ? 'text-on-surface-variant' : '' }}">
                            {{ $notif->data['judul'] }}
                        </h3>
                    </div>
                    
                    <!-- Pesan -->
                    <p class="font-body-regular text-body-regular text-on-surface-variant mb-sm">
                        {{ $notif->data['pesan'] }}
                    </p>
                    
                    <!-- Footer -->
                    <div class="flex items-center gap-md flex-wrap">
                        <span class="font-caption text-caption text-on-surface-variant flex items-center gap-xs">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            {{ $notif->created_at->diffForHumans() }}
                        </span>
                        <span class="font-caption text-caption text-on-surface-variant flex items-center gap-xs">
                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                            {{ $notif->created_at->format('d M Y H:i') }}
                        </span>
                        @if($notif->read_at)
                            <span class="font-caption text-caption text-green-600 flex items-center gap-xs">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                Dibaca {{ $notif->read_at->diffForHumans() }}
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Action Button -->
                @if(!$notif->read_at)
                <form method="POST" action="{{ route('pemantaunotifikasi.read', $notif->id) }}" class="flex-shrink-0">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center gap-xs px-md py-sm bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-body-regular text-small">
                        <span class="material-symbols-outlined text-sm">done_all</span>
                        Tandai Dibaca
                    </button>
                </form>
                @else
                <span class="inline-flex items-center gap-xs px-md py-sm bg-green-50 text-green-600 rounded-lg font-body-regular text-small border border-green-200">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    Sudah Dibaca
                </span>
                @endif
            </div>
        </div>
    </div>
    @empty
    <!-- Empty State -->
    <div class="bg-white rounded-xl border border-outline-variant custom-shadow p-xl text-center">
        <span class="material-symbols-outlined text-6xl text-on-surface-variant/30 block mb-md">notifications_off</span>
        <h3 class="font-h3 text-h3 text-on-surface mb-xs">Tidak Ada Notifikasi</h3>
        <p class="font-body-regular text-body-regular text-on-surface-variant">Semua notifikasi sudah dibaca atau belum ada notifikasi baru.</p>
    </div>
    @endforelse
</div>

<!-- ===== PAGINATION ===== -->
@if($notifikasis->hasPages())
<div class="mt-xl">
    {{ $notifikasis->links() }}
</div>
@endif

@endsection