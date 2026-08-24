@extends('Pemantau.layouts.index')
@section('admin2')
    <!-- ===== WELCOME ===== -->
    <div class="mb-lg p-lg md:mb-xl md:p-xl bg-primary-container/10 border border-primary-container/30 rounded-xl">
        <h1 class="font-h2 text-h2 md:font-h1 md:text-h1 text-primary mb-xs">Selamat Datang, {{ $namaPemantau }}</h1>
        <p class="font-body-regular text-body-regular text-on-surface-variant max-w-3xl text-sm md:text-base">Pantau kesiapan armada, verifikasi laporan, dan kelola inventaris secara real-time dalam satu dasbor kendali.</p>
    </div>

    <!-- ===== STATISTICS (Mobile optimized) ===== -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-sm md:gap-md mb-lg md:mb-xl">

        <!-- Card 1: Total Pos -->
        <div class="bg-white p-md md:p-lg rounded-xl border border-outline-variant custom-shadow">
            <div class="flex items-center justify-between md:block">
                <p class="font-small text-small md:font-h4 md:text-h4 text-on-surface-variant mb-0 md:mb-base">Total Pos</p>
                <span class="md:hidden text-primary">
                    <span class="material-symbols-outlined text-sm">domain</span>
                </span>
            </div>
            <h2 class="font-h2 text-h2 md:font-h1 md:text-h1 text-on-surface">{{ $totalposko }}</h2>
            <div class="mt-xs md:mt-md hidden md:flex items-center gap-xs text-primary">
                <span class="material-symbols-outlined text-sm">domain</span>
                <span class="font-small text-small">Sektor Operasional</span>
            </div>
        </div>

        <!-- Card 2: Jenis Mobil -->
        <div class="bg-white p-md md:p-lg rounded-xl border border-outline-variant custom-shadow">
            <div class="flex items-center justify-between md:block">
                <p class="font-small text-small md:font-h4 md:text-h4 text-on-surface-variant mb-0 md:mb-base">Jenis Mobil</p>
                <span class="md:hidden text-primary">
                    <span class="material-symbols-outlined text-sm">category</span>
                </span>
            </div>
            <h2 class="font-h2 text-h2 md:font-h1 md:text-h1 text-on-surface">{{ $totalJenisMobil }}</h2>
            <div class="mt-xs md:mt-md hidden md:flex items-center gap-xs text-primary">
                <span class="material-symbols-outlined text-sm">category</span>
                <span class="font-small text-small">Kategori Aktif</span>
            </div>
        </div>

        <!-- Card 3: Kendaraan -->
        <div class="bg-white p-md md:p-lg rounded-xl border border-outline-variant custom-shadow">
            <div class="flex items-center justify-between md:block">
                <p class="font-small text-small md:font-h4 md:text-h4 text-on-surface-variant mb-0 md:mb-base">Kendaraan</p>
                <span class="md:hidden text-primary">
                    <span class="material-symbols-outlined text-sm">local_shipping</span>
                </span>
            </div>
            <h2 class="font-h2 text-h2 md:font-h1 md:text-h1 text-on-surface">{{ $totalKendaraan }}</h2>
            <div class="mt-xs md:mt-md hidden md:flex items-center gap-xs text-primary">
                <span class="material-symbols-outlined text-sm">local_shipping</span>
                <span class="font-small text-small">Siaga Beroperasi</span>
            </div>
        </div>

        <!-- Card 4: Laporan -->
        <div class="bg-white p-md md:p-lg rounded-xl border border-outline-variant custom-shadow">
            <div class="flex items-center justify-between md:block">
                <p class="font-small text-small md:font-h4 md:text-h4 text-on-surface-variant mb-0 md:mb-base">Laporan</p>
                <span class="md:hidden text-primary">
                    <span class="material-symbols-outlined text-sm">description</span>
                </span>
            </div>
            <h2 class="font-h2 text-h2 md:font-h1 md:text-h1 text-on-surface">{{ $totalLaporan }}</h2>
            <div class="mt-xs md:mt-md hidden md:flex items-center gap-xs text-primary">
                <span class="material-symbols-outlined text-sm">description</span>
                <span class="font-small text-small">Bulan Berjalan</span>
            </div>
        </div>

        <!-- Card 5: Peralatan Rusak -->
        <a href="{{ route('pemantau.dashboard.alat-rusak') }}" class="bg-white p-md md:p-lg rounded-xl border border-error/20 custom-shadow hover:border-error transition-colors group col-span-2 sm:col-span-1">
            <div class="flex items-center justify-between md:block">
                <p class="font-small text-small md:font-h4 md:text-h4 text-error mb-0 md:mb-base flex items-center justify-between">
                    Peralatan Rusak
                    <span class="material-symbols-outlined text-sm md:hidden">build</span>
                </p>
            </div>
            <h2 class="font-h2 text-h2 md:font-h1 md:text-h1 text-on-surface">{{ $jumlahPeralatanRusak }}</h2>
            <div class="mt-xs md:mt-md hidden md:flex items-center gap-xs text-error">
                <span class="material-symbols-outlined text-sm">build</span>
                <span class="font-small text-small">Perlu Perbaikan</span>
            </div>
        </a>

        <!-- Card 6: Kondisi Kendaraan -->
        <a href="{{ route('pemantau.dashboard.kondisi-masalah') }}" class="bg-white p-md md:p-lg rounded-xl border border-tertiary/20 custom-shadow hover:border-tertiary transition-colors group col-span-2 sm:col-span-1">
            <div class="flex items-center justify-between md:block">
                <p class="font-small text-small md:font-h4 md:text-h4 text-tertiary mb-0 md:mb-base">Kondisi Kendaraan</p>
                <span class="md:hidden text-tertiary">
                    <span class="material-symbols-outlined text-sm">warning</span>
                </span>
            </div>
            <h2 class="font-h2 text-h2 md:font-h1 md:text-h1 text-on-surface">{{ $jumlahKondisiPerhatian }}</h2>
            <div class="mt-xs md:mt-md hidden md:flex items-center gap-xs text-tertiary">
                <span class="material-symbols-outlined text-sm">warning</span>
                <span class="font-small text-small">Perlu Perhatian</span>
            </div>
        </a>
    </div>

    <!-- ===== CHART (Mobile optimized) ===== -->
    <div class="bg-white p-md md:p-xl rounded-xl border border-outline-variant custom-shadow mb-lg md:mb-xl">
        <div class="flex flex-wrap justify-between items-center mb-md md:mb-lg">
            <div>
                <h3 class="font-h3 text-h3 md:font-h2 md:text-h2 text-on-surface">Grafik Laporan Bulanan</h3>
                <p class="font-small text-small md:font-body-regular md:text-body-regular text-on-surface-variant">Statistik operasional dan kondisi unit per bulan</p>
            </div>
            <div class="flex flex-wrap gap-sm md:gap-md mt-2 sm:mt-0">
                <span class="flex items-center gap-xs">
                    <span class="w-2 h-2 md:w-3 md:h-3 rounded-full bg-primary"></span>
                    <span class="font-xxs text-xxs md:font-small md:text-small">Laporan</span>
                </span>
                <span class="flex items-center gap-xs">
                    <span class="w-2 h-2 md:w-3 md:h-3 rounded-full bg-error"></span>
                    <span class="font-xxs text-xxs md:font-small md:text-small">Alat Rusak</span>
                </span>
                <span class="flex items-center gap-xs">
                    <span class="w-2 h-2 md:w-3 md:h-3 rounded-full bg-green-700"></span>
                    <span class="font-xxs text-xxs md:font-small md:text-small">Kondisi Unit</span>
                </span>
            </div>
        </div>
        <div class="h-64 md:h-80 w-full relative">
            <canvas id="chartLaporan"></canvas>
        </div>
    </div>

    <!-- ===== BOTTOM GRID: Kendaraan + Laporan (Mobile optimized) ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-md md:gap-lg">

        <!-- Kendaraan Terbaru -->
        <div class="lg:col-span-4 bg-white rounded-xl border border-outline-variant custom-shadow overflow-hidden">
            <div class="p-md md:p-lg border-b border-outline-variant">
                <h3 class="font-h3 text-h3 md:font-h3 md:text-h3 text-on-surface text-base md:text-xl">Kendaraan Terbaru</h3>
            </div>
            <div class="overflow-x-auto overflow-y-auto max-h-64 md:max-h-none" style="overscroll-behavior: contain;">
                <table class="zebra-table w-full min-w-[280px] md:min-w-[320px]" style="table-layout:fixed;">
                    <colgroup>
                        <col style="width:50%;">
                        <col style="width:50%;">
                    </colgroup>
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="p-sm md:p-md font-small text-small md:font-h4 md:text-h4 whitespace-nowrap text-left">Nomor Polisi</th>
                            <th class="p-sm md:p-md font-small text-small md:font-h4 md:text-h4 whitespace-nowrap text-left">Pos</th>
                        </tr>
                    </thead>
                    <tbody class="font-small text-small md:font-body-regular md:text-body-regular">
                        @foreach($kendaraanTerbaru as $item)
                        <tr>
                            <td class="p-sm md:p-md border-b border-outline-variant whitespace-nowrap">{{ $item->nomor_polisi }}</td>
                            <td class="p-sm md:p-md border-b border-outline-variant whitespace-nowrap">{{ $item->jenisMobil->posko->nama_posko ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Laporan Terbaru -->
        <div class="lg:col-span-8 bg-white rounded-xl border border-outline-variant custom-shadow overflow-hidden">
            <div class="p-md md:p-lg border-b border-outline-variant">
                <h3 class="font-h3 text-h3 md:font-h3 md:text-h3 text-on-surface text-base md:text-xl">Laporan Terbaru</h3>
            </div>
            <div class="overflow-x-auto overflow-y-auto max-h-64 md:max-h-96" style="overscroll-behavior: contain;">
                <table class="zebra-table w-full min-w-[500px] md:min-w-[600px]">
                    <thead class="bg-primary text-white sticky top-0">
                        <tr>
                            <th class="p-sm md:p-md font-small text-small md:font-h4 md:text-h4 text-left">Nama Pelapor</th>
                            <th class="p-sm md:p-md font-small text-small md:font-h4 md:text-h4 text-left">Plat No</th>
                            <th class="p-sm md:p-md font-small text-small md:font-h4 md:text-h4 text-left">Tanggal Laporan</th>
                        </tr>
                    </thead>
                    <tbody class="font-small text-small md:font-body-regular md:text-body-regular">
                        @foreach($laporanTerbaru as $laporan)
                        <tr>
                            <td class="p-sm md:p-md border-b border-outline-variant">{{ $laporan->user?->name ?? 'Dinonaktifkan' }}</td>
                            <td class="p-sm md:p-md border-b border-outline-variant">{{ $laporan->kendaraan->nomor_polisi }}</td>
                            <td class="p-sm md:p-md border-b border-outline-variant">{{ $laporan->created_at->format('d-m-Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ===== CHART SCRIPT ===== -->
    <script>
        // Chart data from Laravel
        const laporanBulanan = @json($laporanBulanan);
        const peralatanRusakBulanan = @json($peralatanRusakBulanan);
        const kondisiPerhatianBulanan = @json($kondisiPerhatianBulanan);

        const labels = laporanBulanan.map(item => 'Bulan ' + item.bulan);
        const dataLaporan = laporanBulanan.map(item => item.total);

        const dataPeralatan = labels.map((_, idx) => {
            const bulan = laporanBulanan[idx].bulan;
            const found = peralatanRusakBulanan.find(item => item.bulan == bulan);
            return found ? found.total : 0;
        });

        const dataKondisi = labels.map((_, idx) => {
            const bulan = laporanBulanan[idx].bulan;
            const found = kondisiPerhatianBulanan.find(item => item.bulan == bulan);
            return found ? found.total : 0;
        });

        new Chart(document.getElementById('chartLaporan'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: dataLaporan,
                    backgroundColor: '#1976D2',
                    borderRadius: 4,
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                }, {
                    label: 'Peralatan Rusak',
                    data: dataPeralatan,
                    backgroundColor: '#D32F2F',
                    borderRadius: 4,
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                }, {
                    label: 'Kondisi Unit',
                    data: dataKondisi,
                    backgroundColor: '#2E7D32',
                    borderRadius: 4,
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            padding: 8,
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { 
                            precision: 0,
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 9
                            },
                            maxRotation: 45,
                            minRotation: 30
                        }
                    }
                }
            }
        });
    </script>

    <!-- Mobile responsive CSS overrides -->
    <style>
        @media (max-width: 640px) {
            .custom-shadow {
                box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            }
            .font-xxs {
                font-size: 0.65rem;
                line-height: 1rem;
            }
            .text-xxs {
                font-size: 0.65rem;
                line-height: 1rem;
            }
            .grid-cols-2 {
                gap: 0.5rem;
            }
            .p-md {
                padding: 0.75rem;
            }
            .mb-lg {
                margin-bottom: 1rem;
            }
        }
        
        @media (max-width: 480px) {
            .grid-cols-2 {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>

@endsection