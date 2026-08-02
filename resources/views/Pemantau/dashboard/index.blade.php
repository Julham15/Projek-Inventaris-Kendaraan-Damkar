@extends('Pemantau.layouts.index')
@section('admin2')
            <!-- ===== WELCOME ===== -->
            <div class="mb-xl p-lg bg-primary-container/10 border border-primary-container/30 rounded-xl">
                <h1 class="font-h1 text-h1 text-primary mb-xs">Selamat Datang, {{ $namaPemantau }}</h1>
                <p class="font-body-regular text-body-regular text-on-surface-variant max-w-3xl">Pantau kesiapan armada, verifikasi laporan, dan kelola inventaris secara real-time dalam satu dasbor kendali.</p>
            </div>

            <!-- ===== STATISTICS (5 cards) ===== -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-md mb-xl">

                <div class="bg-white p-lg rounded-xl border border-outline-variant custom-shadow">
                    <p class="font-h4 text-h4 text-on-surface-variant mb-base">Total Pos</p>
                    <h2 class="font-h1 text-h1 text-on-surface">{{ $totalposko }}</h2>
                    <div class="mt-md flex items-center gap-xs text-primary">
                        <span class="material-symbols-outlined text-sm">domain</span>
                        <span class="font-small text-small">Sektor Operasional</span>
                    </div>
                </div>

                <div class="bg-white p-lg rounded-xl border border-outline-variant custom-shadow">
                    <p class="font-h4 text-h4 text-on-surface-variant mb-base">Jenis Mobil</p>
                    <h2 class="font-h1 text-h1 text-on-surface">{{ $totalJenisMobil }}</h2>
                    <div class="mt-md flex items-center gap-xs text-primary">
                        <span class="material-symbols-outlined text-sm">category</span>
                        <span class="font-small text-small">Kategori Aktif</span>
                    </div>
                </div>

                <div class="bg-white p-lg rounded-xl border border-outline-variant custom-shadow">
                    <p class="font-h4 text-h4 text-on-surface-variant mb-base">Kendaraan</p>
                    <h2 class="font-h1 text-h1 text-on-surface">{{ $totalKendaraan }}</h2>
                    <div class="mt-md flex items-center gap-xs text-primary">
                        <span class="material-symbols-outlined text-sm">local_shipping</span>
                        <span class="font-small text-small">Siaga Beroperasi</span>
                    </div>
                </div>

                <div class="bg-white p-lg rounded-xl border border-outline-variant custom-shadow">
                    <p class="font-h4 text-h4 text-on-surface-variant mb-base">Laporan</p>
                    <h2 class="font-h1 text-h1 text-on-surface">{{ $totalLaporan }}</h2>
                    <div class="mt-md flex items-center gap-xs text-primary">
                        <span class="material-symbols-outlined text-sm">description</span>
                        <span class="font-small text-small">Bulan Berjalan</span>
                    </div>
                </div>

                <a href="{{ route('pemantau.dashboard.alat-rusak') }}" class="bg-white p-lg rounded-xl border border-error/20 custom-shadow hover:border-error transition-colors group">
                    <p class="font-h4 text-h4 text-error mb-base flex items-center justify-between">Peralatan Rusak</p>
                    <h2 class="font-h1 text-h1 text-on-surface">{{ $jumlahPeralatanRusak }}</h2>
                    <div class="mt-md flex items-center gap-xs text-error">
                        <span class="material-symbols-outlined text-sm">build</span>
                        <span class="font-small text-small">Perlu Perbaikan</span>
                    </div>
                </a>

                <a href="{{ route('pemantau.dashboard.kondisi-masalah') }}" class="bg-white p-lg rounded-xl border border-tertiary/20 custom-shadow hover:border-tertiary transition-colors group">
                    <p class="font-h4 text-h4 text-tertiary mb-base">Kondisi Kendaraan</p>
                    <h2 class="font-h1 text-h1 text-on-surface">{{ $jumlahKondisiPerhatian }}</h2>
                    <div class="mt-md flex items-center gap-xs text-tertiary">
                        <span class="material-symbols-outlined text-sm">warning</span>
                        <span class="font-small text-small">Perlu Perhatian</span>
                    </div>
                </a>
            </div>

            <!-- ===== CHART ===== -->
            <div class="bg-white p-xl rounded-xl border border-outline-variant custom-shadow mb-xl">
                <div class="flex flex-wrap justify-between items-center mb-lg">
                    <div>
                        <h3 class="font-h2 text-h2 text-on-surface">Grafik Laporan Bulanan</h3>
                        <p class="font-body-regular text-body-regular text-on-surface-variant">Statistik operasional dan kondisi unit per bulan</p>
                    </div>
                    <div class="flex gap-md mt-2 sm:mt-0">
                        <span class="flex items-center gap-xs"><span class="w-3 h-3 rounded-full bg-primary"></span><span class="font-small text-small">Laporan</span></span>
                        <span class="flex items-center gap-xs"><span class="w-3 h-3 rounded-full bg-error"></span><span class="font-small text-small">Alat Rusak</span></span>
                        <span class="flex items-center gap-xs"><span class="w-3 h-3 rounded-full bg-green-700"></span><span class="font-small text-small">Kondisi Unit</span></span>
                    </div>
                </div>
                <div class="h-80 w-full relative">
                    <canvas id="chartLaporan"></canvas>
                </div>
            </div>

            <!-- ===== BOTTOM GRID: Kendaraan + Laporan ===== -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">

                <!-- Kendaraan Terbaru -->
                <div class="lg:col-span-4 bg-white rounded-xl border border-outline-variant custom-shadow overflow-hidden">
                    <div class="p-lg border-b border-outline-variant">
                        <h3 class="font-h3 text-h3 text-on-surface">Kendaraan Terbaru</h3>
                    </div>
                    <div class="overflow-x-auto" style="overscroll-behavior: contain;">
                        <table class="zebra-table w-full min-w-[320px]" style="table-layout:fixed;">
                            <colgroup>
                                <col style="width:50%;">
                                <col style="width:50%;">
                            </colgroup>
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="p-md font-h4 text-h4 whitespace-nowrap text-left">Nomor Polisi</th>
                                    <th class="p-md font-h4 text-h4 whitespace-nowrap text-left">Pos</th>
                                </tr>
                            </thead>
                            <tbody class="font-body-regular text-body-regular">
                                @foreach($kendaraanTerbaru as $item)
                                <tr>
                                    <td class="p-md border-b border-outline-variant whitespace-nowrap">{{ $item->nomor_polisi }}</td>
                                    <td class="p-md border-b border-outline-variant whitespace-nowrap">{{ $item->jenisMobil->posko->nama_posko ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Laporan Terbaru -->
                <div class="lg:col-span-8 bg-white rounded-xl border border-outline-variant custom-shadow overflow-hidden">
                    <div class="p-lg border-b border-outline-variant">
                        <h3 class="font-h3 text-h3 text-on-surface">Laporan Terbaru</h3>
                    </div>
                    <div class="overflow-x-auto overflow-y-auto max-h-96" style="overscroll-behavior: contain;">
                        <table class="zebra-table w-full min-w-[600px]">
                            <thead class="bg-primary text-white sticky top-0">
                                <tr>
                                    <th class="p-md font-h4 text-h4 text-left">Nama Pelapor</th>
                                    <th class="p-md font-h4 text-h4 text-left">Plat No</th>
                                    <th class="p-md font-h4 text-h4 text-left">Tanggal Laporan</th>
                                </tr>
                            </thead>
                            <tbody class="font-body-regular text-body-regular">
                                @foreach($laporanTerbaru as $laporan)
                                <tr>
                                    <td class="p-md border-b border-outline-variant">{{ $laporan->user?->name ?? 'Dinonaktifkan' }}</td>
                                    <td class="p-md border-b border-outline-variant">{{ $laporan->kendaraan->nomor_polisi }}</td>
                                    <td class="p-md border-b border-outline-variant">{{ $laporan->created_at->format('d-m-Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- ===== CHART SCRIPT ===== -->
    <script>
        // Micro-interaction: button press feedback
       

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
                    borderRadius: 6
                }, {
                    label: 'Peralatan Rusak',
                    data: dataPeralatan,
                    backgroundColor: '#D32F2F',
                    borderRadius: 6
                }, {
                    label: 'Kondisi Unit',
                    data: dataKondisi,
                    backgroundColor: '#2E7D32',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    </script>

@endsection