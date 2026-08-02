@extends('user.layouts.index')
@section('user')
    <!-- Main Content - Mobile First -->
    <main class="px-4 py-4 pb-24 max-w-full space-y-5 sm:px-6 md:px-8 lg:ml-64 lg:max-w-7xl lg:mx-auto lg:space-y-7">
        <!-- Header -->
        <section class="mt-2">
            <h1 class="text-2xl font-bold text-primary md:text-3xl lg:text-h1">Notifikasi</h1>
            <p class="text-sm text-on-surface-variant mt-1 md:text-base lg:text-body-regular">Daftar semua notifikasi dan pengumuman terbaru untuk Anda.</p>
        </section>

        <!-- Notification Stats -->
        <section>
            <div class="grid grid-cols-3 gap-2 md:gap-3 lg:gap-4">
                <!-- Total Notifikasi -->
                <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant p-3 flex flex-col items-center text-center md:p-4 lg:p-5 hover:shadow-md transition-shadow duration-300">
                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center mb-1.5 md:w-12 md:h-12 lg:w-14 lg:h-14 lg:mb-2">
                        <span class="material-symbols-outlined text-primary text-lg md:text-xl lg:text-2xl">notifications</span>
                    </div>
                    <div>
                        <p class="text-xs text-on-surface-variant md:text-sm lg:text-base">Total Notifikasi</p>
                        <p class="text-xl font-bold text-on-surface md:text-2xl lg:text-h2">{{ auth()->user()->notifications->count() }}</p>
                    </div>
                </div>
                
                <!-- Belum Dibaca -->
                <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant p-3 flex flex-col items-center text-center md:p-4 lg:p-5 hover:shadow-md transition-shadow duration-300">
                    <div class="w-10 h-10 rounded-full bg-yellow-500/10 flex items-center justify-center mb-1.5 md:w-12 md:h-12 lg:w-14 lg:h-14 lg:mb-2">
                        <span class="material-symbols-outlined text-yellow-500 text-lg md:text-xl lg:text-2xl">mark_email_unread</span>
                    </div>
                    <div>
                        <p class="text-xs text-on-surface-variant md:text-sm lg:text-base">Belum Dibaca</p>
                        <p class="text-xl font-bold text-yellow-500 md:text-2xl lg:text-h2">{{ auth()->user()->unreadNotifications->whereNull('read_at')->count() }}</p>
                    </div>
                </div>
                
                <!-- Sudah Dibaca -->
                <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant p-3 flex flex-col items-center text-center md:p-4 lg:p-5 hover:shadow-md transition-shadow duration-300">
                    <div class="w-10 h-10 rounded-full bg-green-500/10 flex items-center justify-center mb-1.5 md:w-12 md:h-12 lg:w-14 lg:h-14 lg:mb-2">
                        <span class="material-symbols-outlined text-green-500 text-lg md:text-xl lg:text-2xl">mark_email_read</span>
                    </div>
                    <div>
                        <p class="text-xs text-on-surface-variant md:text-sm lg:text-base">Sudah Dibaca</p>
                        <p class="text-xl font-bold text-green-500 md:text-2xl lg:text-h2">{{ $notifikasis->whereNotNull('read_at')->count() }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Notification List -->
        <section>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="divide-y divide-outline-variant/30">
                    @forelse($notifikasis as $notif)
                        <div class="p-4 space-y-3 hover:bg-surface-container-hover transition-colors md:p-5 lg:p-6 
                                    {{ $notif->read_at ? 'opacity-75' : '' }}">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <!-- Konten Notifikasi -->
                                <div class="flex-1 min-w-0">
                                    <!-- Header -->
                                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                        @if(!$notif->read_at)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-warning/10 text-warning rounded-full text-xs font-medium">
                                                <span class="w-1.5 h-1.5 bg-warning rounded-full animate-pulse"></span>
                                                Baru
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-success/10 text-success rounded-full text-xs font-medium">
                                                <span class="w-1.5 h-1.5 bg-success rounded-full"></span>
                                                Sudah Dibaca
                                            </span>
                                        @endif
                                        <h3 class="text-sm font-semibold text-on-surface md:text-base lg:text-h3 {{ $notif->read_at ? 'text-on-surface-variant' : '' }}">
                                            {{ $notif->data['judul'] }}
                                        </h3>
                                    </div>
                                    
                                    <!-- Pesan -->
                                    <p class="text-sm text-on-surface-variant mb-2 md:text-base lg:text-body-regular">
                                        {{ $notif->data['pesan'] }}
                                    </p>
                                    
                                    <!-- Footer -->
                                    <div class="flex flex-wrap items-center gap-3 text-xs text-on-surface-variant md:text-sm">
                                        <span class="flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-xs md:text-sm">schedule</span>
                                            {{ $notif->created_at->diffForHumans() }}
                                        </span>
                                        <span class="flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-xs md:text-sm">calendar_today</span>
                                            {{ $notif->created_at->format('d M Y H:i') }}
                                        </span>
                                        @if($notif->read_at)
                                            <span class="flex items-center gap-0.5 text-success">
                                                <span class="material-symbols-outlined text-xs md:text-sm">check_circle</span>
                                                Dibaca {{ $notif->read_at->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Action Button -->
                                <div class="flex-shrink-0 mt-2 sm:mt-0">
                                    @if(!$notif->read_at)
                                        <form method="POST" action="{{ route('user.notifikasi.read', $notif->id) }}" class="w-full sm:w-auto">
                                            @csrf
                                            <button type="submit" 
                                                    class="inline-flex items-center justify-center gap-1.5 w-full px-4 py-2 bg-primary text-on-primary rounded-lg hover:bg-primary-hover hover:scale-105 hover:shadow-lg transition-all duration-300 font-medium text-sm md:px-5 md:py-2.5">
                                                <span class="material-symbols-outlined text-sm md:text-base">done_all</span>
                                                <span>Tandai Dibaca</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="inline-flex items-center justify-center gap-1.5 w-full px-4 py-2 bg-success/10 text-success rounded-lg border border-success/20 font-medium text-sm md:px-5 md:py-2.5">
                                            <span class="material-symbols-outlined text-sm md:text-base">check_circle</span>
                                            <span>Sudah Dibaca</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Empty State -->
                        <div class="p-8 text-center text-on-surface-variant/60 md:p-10 lg:p-12">
                            <div class="flex flex-col items-center gap-3">
                                <span class="material-symbols-outlined text-5xl opacity-40 md:text-6xl">notifications_off</span>
                                <p class="text-base font-medium md:text-lg">Tidak Ada Notifikasi</p>
                                <p class="text-sm md:text-base">Semua notifikasi sudah dibaca atau belum ada notifikasi baru.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Pagination -->
        @if($notifikasis->hasPages())
            <section>
                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 hover:shadow-lg transition-shadow duration-300 md:p-5">
                    {{ $notifikasis->links() }}
                </div>
            </section>
        @endif
    </main>

    <style>
        /* Mobile-first pagination */
        @media (max-width: 640px) {
            .pagination {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.25rem;
            }
            .pagination .page-item {
                margin: 0;
            }
            .pagination .page-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
            }
            .pagination .page-item:first-child .page-link,
            .pagination .page-item:last-child .page-link {
                padding: 0.5rem 0.75rem;
            }
            .pagination .page-item.active .page-link {
                background-color: #0D9488;
                border-color: #0D9488;
                color: white;
            }
        }

        /* Smooth transition untuk card */
        .transition-all {
            transition: all 0.3s ease;
        }

        /* Animasi pulse untuk badge "Baru" */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
@endsection