@extends('user.layouts.index')
@section('user')
    <!-- Main Content - Mobile First -->
    <main class="px-4 py-4 pb-24 max-w-full space-y-5 sm:px-6 md:px-8 lg:ml-64 lg:max-w-7xl lg:mx-auto lg:space-y-7">
        <!-- Welcome - Mobile Optimized -->
        <section class="mt-2">
            <h1 class="text-2xl font-bold text-primary md:text-3xl lg:text-h1">Selamat Datang, {{ $user->name ?? 'Petugas' }}</h1>
            <p class="text-sm text-on-surface-variant mt-1 md:text-base lg:text-body-regular">Ringkasan operasional harian dan mingguan unit pemadam kebakaran.</p>
        </section>

        <!-- Statistik Harian - Mobile Optimized -->
        <section>
            <div class="flex flex-col items-start gap-2 mb-3 sm:flex-row sm:items-center sm:justify-between sm:gap-0 md:mb-4">
                <h2 class="text-lg font-semibold text-on-surface md:text-xl lg:text-h2">Statistik Harian</h2>
                <span class="text-xs font-medium bg-primary-container/20 text-primary px-3 py-1 rounded-full md:text-sm md:px-4">Hari Ini: {{ date('d F Y') }}</span>
            </div>
            <div class="grid grid-cols-2 gap-2 sm:grid-cols-2 lg:grid-cols-4 md:gap-3 lg:gap-4">
                <!-- Total Laporan -->
                <div class="stat-card bg-surface-container-lowest border border-outline-variant p-3 rounded-lg hover:shadow-lg transition-shadow duration-300 md:p-4 lg:p-5">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 bg-primary-container/20 text-primary rounded-lg flex items-center justify-center mb-2 md:w-12 md:h-12">
                            <span class="material-symbols-outlined text-lg md:text-2xl">assignment_late</span>
                        </div>
                        <p class="text-xs text-on-surface-variant md:text-sm">Total Laporan</p>
                        <p class="text-xl font-bold text-primary md:text-2xl lg:text-h1">{{ $laporanHarian ?? 12 }}</p>
                    </div>
                </div>
                <!-- Kendaraan Dilaporkan -->
                <div class="stat-card bg-surface-container-lowest border border-outline-variant p-3 rounded-lg hover:shadow-lg transition-shadow duration-300 md:p-4 lg:p-5">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 bg-primary-container/20 text-primary rounded-lg flex items-center justify-center mb-2 md:w-12 md:h-12">
                            <span class="material-symbols-outlined text-lg md:text-2xl">fire_truck</span>
                        </div>
                        <p class="text-xs text-on-surface-variant md:text-sm">Kendaraan</p>
                        <p class="text-xl font-bold text-primary md:text-2xl lg:text-h1">{{ $kendaraanHarian ?? 8 }}</p>
                    </div>
                </div>
                <!-- Peralatan Rusak -->
                <div class="stat-card bg-surface-container-lowest border border-outline-variant p-3 rounded-lg hover:shadow-lg transition-shadow duration-300 md:p-4 lg:p-5">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 bg-primary-container/20 text-primary rounded-lg flex items-center justify-center mb-2 md:w-12 md:h-12">
                            <span class="material-symbols-outlined text-lg md:text-2xl">build</span>
                        </div>
                        <p class="text-xs text-on-surface-variant md:text-sm">Peralatan Rusak</p>
                        <p class="text-xl font-bold text-primary md:text-2xl lg:text-h1">{{ $peralatanRusakHarian ?? 5 }}</p>
                    </div>
                </div>
                <!-- Kondisi Bermasalah -->
                <div class="stat-card bg-surface-container-lowest border border-outline-variant p-3 rounded-lg hover:shadow-lg transition-shadow duration-300 md:p-4 lg:p-5">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 bg-primary-container/20 text-primary rounded-lg flex items-center justify-center mb-2 md:w-12 md:h-12">
                            <span class="material-symbols-outlined text-lg md:text-2xl">warning</span>
                        </div>
                        <p class="text-xs text-on-surface-variant md:text-sm">Kondisi Bermasalah</p>
                        <p class="text-xl font-bold text-primary md:text-2xl lg:text-h1">{{ $kondisiBermasalahHarian ?? 3 }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Diagram Batang Utama - Mobile Optimized -->
        <section>
            <h2 class="text-lg font-semibold text-on-surface mb-3 md:text-xl lg:text-h2 md:mb-4">Diagram Batang - Statistik Mingguan</h2>
            <div class="bg-surface-container-lowest border border-outline-variant p-3 rounded-lg md:p-4 lg:p-6">
                <!-- Canvas area -->
                <div class="relative h-56 w-full md:h-64 lg:h-72">
                    <!-- Grid garis bantu horizontal -->
                    <div class="absolute inset-0 flex flex-col justify-between px-2 pb-6 pointer-events-none md:pb-8">
                        <div class="border-b border-outline-variant/30 h-0 w-full"></div>
                        <div class="border-b border-outline-variant/30 h-0 w-full"></div>
                        <div class="border-b border-outline-variant/30 h-0 w-full"></div>
                        <div class="border-b border-outline-variant/30 h-0 w-full"></div>
                        <div class="border-b border-outline-variant/30 h-0 w-full"></div>
                    </div>

                    <!-- Bar container -->
                    <div class="absolute inset-0 flex items-end justify-around px-2 pb-6 gap-1 md:px-4 md:pb-8 md:gap-2">
                        <!-- Laporan Mingguan -->
                        <div class="flex flex-col items-center gap-0.5 flex-1 min-w-0 md:gap-1">
                            <div class="w-full max-w-[40px] bg-primary rounded-t-lg chart-bar transition-all duration-1000" style="height: 0%;" data-target="85"></div>
                            <span class="text-xs font-bold text-primary md:text-sm">{{ $laporanMingguan ?? 42 }}</span>
                            <span class="text-[10px] text-on-surface-variant text-center truncate w-full md:text-xs">Laporan</span>
                        </div>
                        <!-- Kendaraan Mingguan -->
                        <div class="flex flex-col items-center gap-0.5 flex-1 min-w-0 md:gap-1">
                            <div class="w-full max-w-[40px] bg-primary-container rounded-t-lg chart-bar transition-all duration-1000" style="height: 0%;" data-target="65"></div>
                            <span class="text-xs font-bold text-primary md:text-sm">{{ $kendaraanMingguan ?? 32 }}</span>
                            <span class="text-[10px] text-on-surface-variant text-center truncate w-full md:text-xs">Kendaraan</span>
                        </div>
                        <!-- Peralatan Rusak Mingguan -->
                        <div class="flex flex-col items-center gap-0.5 flex-1 min-w-0 md:gap-1">
                            <div class="w-full max-w-[40px] bg-tertiary rounded-t-lg chart-bar transition-all duration-1000" style="height: 0%;" data-target="45"></div>
                            <span class="text-xs font-bold text-tertiary md:text-sm">{{ $peralatanRusakMingguan ?? 22 }}</span>
                            <span class="text-[10px] text-on-surface-variant text-center truncate w-full md:text-xs">Peralatan Rusak</span>
                        </div>
                        <!-- Kondisi Bermasalah Mingguan -->
                        <div class="flex flex-col items-center gap-0.5 flex-1 min-w-0 md:gap-1">
                            <div class="w-full max-w-[40px] bg-error rounded-t-lg chart-bar transition-all duration-1000" style="height: 0%;" data-target="25"></div>
                            <span class="text-xs font-bold text-error md:text-sm">{{ $kondisiBermasalahMingguan ?? 12 }}</span>
                            <span class="text-[10px] text-on-surface-variant text-center truncate w-full md:text-xs">Kondisi Bermasalah</span>
                        </div>
                    </div>

                    <!-- Label sumbu Y -->
                    <div class="absolute left-0 top-0 h-full flex flex-col justify-between pb-6 text-[10px] text-on-surface-variant/60 md:pb-8 md:text-xs">
                        <span>100%</span>
                        <span>75%</span>
                        <span>50%</span>
                        <span>25%</span>
                        <span>0%</span>
                    </div>
                </div>
                <!-- Legenda -->
                <div class="flex flex-wrap items-center justify-center gap-2 mt-3 pt-2 border-t border-outline-variant/40 md:gap-4 md:mt-4 md:pt-3">
                    <div class="flex items-center gap-0.5 md:gap-1">
                        <span class="w-2.5 h-2.5 rounded-sm bg-primary md:w-3 md:h-3"></span>
                        <span class="text-[10px] text-on-surface-variant md:text-xs">Laporan</span>
                    </div>
                    <div class="flex items-center gap-0.5 md:gap-1">
                        <span class="w-2.5 h-2.5 rounded-sm bg-primary-container md:w-3 md:h-3"></span>
                        <span class="text-[10px] text-on-surface-variant md:text-xs">Kendaraan</span>
                    </div>
                    <div class="flex items-center gap-0.5 md:gap-1">
                        <span class="w-2.5 h-2.5 rounded-sm bg-tertiary md:w-3 md:h-3"></span>
                        <span class="text-[10px] text-on-surface-variant md:text-xs">Peralatan Rusak</span>
                    </div>
                    <div class="flex items-center gap-0.5 md:gap-1">
                        <span class="w-2.5 h-2.5 rounded-sm bg-error md:w-3 md:h-3"></span>
                        <span class="text-[10px] text-on-surface-variant md:text-xs">Kondisi Bermasalah</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Ringkasan Mingguan + Perbandingan - Mobile Optimized -->
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-6">
            <!-- Kartu ringkasan -->
            <section class="lg:col-span-1 space-y-3 md:space-y-4">
    <h2 class="text-lg font-semibold text-on-surface md:text-xl lg:text-h2">Ringkasan Mingguan</h2>
    <div class="grid grid-cols-2 gap-2 md:gap-3">
        <!-- Total Laporan -->
        <div class="bg-surface-container text-on-primary-container p-3 rounded-lg flex flex-col items-center justify-center text-center md:p-4">
            <div class="flex flex-col items-center">
                <span class="material-symbols-outlined text-2xl md:text-3xl lg:text-h1">monitoring</span>
                <p class="text-[10px] uppercase tracking-wider opacity-80 mt-1 md:text-xs">Total Laporan</p>
                <p class="text-xl font-bold md:text-2xl lg:text-h2">{{ $laporanMingguan ?? 42 }}</p>
            </div>
        </div>
        
        <!-- Kendaraan -->
        <div class="bg-surface-container-low border border-outline-variant p-3 rounded-lg flex flex-col items-center justify-center text-center md:p-4">
            <div class="flex flex-col items-center">
                <span class="material-symbols-outlined text-2xl text-primary/60 md:text-3xl lg:text-h2">fire_truck</span>
                <p class="text-[10px] uppercase tracking-wider text-on-surface-variant mt-1 md:text-xs">Kendaraan</p>
                <p class="text-lg font-bold text-primary md:text-xl lg:text-h3">{{ $kendaraanMingguan ?? 32 }}</p>
            </div>
        </div>
        
        <!-- Peralatan Rusak -->
        <div class="bg-surface-container-low border border-outline-variant p-3 rounded-lg flex flex-col items-center justify-center text-center md:p-4">
            <div class="flex flex-col items-center">
                <span class="material-symbols-outlined text-2xl text-tertiary/60 md:text-3xl lg:text-h2">construction</span>
                <p class="text-[10px] uppercase tracking-wider text-on-surface-variant mt-1 md:text-xs">Peralatan Rusak</p>
                <p class="text-lg font-bold text-tertiary md:text-xl lg:text-h3">{{ $peralatanRusakMingguan ?? 22 }}</p>
            </div>
        </div>
        
        <!-- Kondisi Bermasalah -->
        <div class="bg-surface-container-low border border-outline-variant p-3 rounded-lg flex flex-col items-center justify-center text-center md:p-4">
            <div class="flex flex-col items-center">
                <span class="material-symbols-outlined text-2xl text-error/60 md:text-3xl lg:text-h2">error_outline</span>
                <p class="text-[10px] uppercase tracking-wider text-on-surface-variant mt-1 md:text-xs">Kondisi Bermasalah</p>
                <p class="text-lg font-bold text-error md:text-xl lg:text-h3">{{ $kondisiBermasalahMingguan ?? 12 }}</p>
            </div>
        </div>
    </div>
</section>

            <!-- Perbandingan Harian vs Mingguan - Mobile Optimized -->
            <section class="lg:col-span-2">
                <h2 class="text-lg font-semibold text-on-surface mb-3 md:text-xl lg:text-h2 md:mb-4">Perbandingan Harian &amp; Mingguan</h2>
                <div class="bg-surface-container-lowest border border-outline-variant p-3 rounded-lg h-full md:p-4 lg:p-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 h-full">
                        <!-- Rata-rata Harian -->
                        <div class="flex flex-col items-center justify-center border-b border-outline-variant/30 pb-4 sm:border-b-0 sm:border-r sm:pr-4 sm:pb-0">
                            <span class="text-[10px] uppercase tracking-wider text-on-surface-variant md:text-xs">Rata-rata Harian</span>
                            <div class="flex items-end gap-2 mt-2 h-16 md:h-20 md:gap-3">
                                <div class="flex flex-col items-center">
                                    <div class="w-5 bg-primary rounded-t md:w-6" style="height: 12px;"></div>
                                    <span class="text-[10px] mt-0.5 md:text-xs">Lap</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-5 bg-primary-container rounded-t md:w-6" style="height: 8px;"></div>
                                    <span class="text-[10px] mt-0.5 md:text-xs">Kend</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-5 bg-tertiary rounded-t md:w-6" style="height: 6px;"></div>
                                    <span class="text-[10px] mt-0.5 md:text-xs">Rusak</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-5 bg-error rounded-t md:w-6" style="height: 4px;"></div>
                                    <span class="text-[10px] mt-0.5 md:text-xs">Masalah</span>
                                </div>
                            </div>
                        </div>
                        <!-- Total Mingguan -->
                        <div class="flex flex-col items-center justify-center pt-4 sm:pt-0 sm:pl-4">
                            <span class="text-[10px] uppercase tracking-wider text-on-surface-variant md:text-xs">Total Mingguan</span>
                            <div class="flex items-end gap-2 mt-2 h-16 md:h-20 md:gap-3">
                                <div class="flex flex-col items-center">
                                    <div class="w-5 bg-primary rounded-t md:w-6" style="height: 42px;"></div>
                                    <span class="text-[10px] mt-0.5 md:text-xs">Lap</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-5 bg-primary-container rounded-t md:w-6" style="height: 32px;"></div>
                                    <span class="text-[10px] mt-0.5 md:text-xs">Kend</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-5 bg-tertiary rounded-t md:w-6" style="height: 22px;"></div>
                                    <span class="text-[10px] mt-0.5 md:text-xs">Rusak</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-5 bg-error rounded-t md:w-6" style="height: 12px;"></div>
                                    <span class="text-[10px] mt-0.5 md:text-xs">Masalah</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi bar chart
            const bars = document.querySelectorAll('.chart-bar');
            bars.forEach((bar, index) => {
                const target = parseInt(bar.dataset.target) || 0;
                // Batasi maks 100%
                const height = Math.min(target, 100);
                setTimeout(() => {
                    bar.style.height = height + '%';
                }, 200 + (index * 100));
            });

            // Feedback klik pada stat card
            const cards = document.querySelectorAll('.stat-card');
            cards.forEach(card => {
                card.addEventListener('click', function() {
                    this.style.transition = 'transform 0.1s';
                    this.style.transform = 'scale(0.96)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                });
            });
        });
    </script>
@endsection