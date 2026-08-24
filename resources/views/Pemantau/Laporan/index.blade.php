@extends('Pemantau.layouts.index')
@section('admin2')

<!-- ===== WELCOME ===== -->
<div class="mb-lg md:mb-xl p-md md:p-lg bg-primary-container/10 border border-primary-container/30 rounded-xl">
    <h1 class="font-h2 md:font-h1 text-h2 md:text-h1 text-primary mb-xs">Data Laporan User</h1>
    <p class="font-small md:font-body-regular text-small md:text-body-regular text-on-surface-variant max-w-3xl">Kelola dan filter seluruh laporan yang masuk dari berbagai posko dan unit operasional.</p>
</div>

<div class="flex-1 overflow-x-auto p-sm md:p-lg">
    <!-- Stats/Summary Cards -->
    <div class="overflow-x-auto pb-2 md:pb-0 -mx-sm md:mx-0">
    <div class="grid grid-cols-3 gap-sm md:gap-gutter min-w-[300px] md:min-w-0 px-sm md:px-0">
        <!-- Card Total Laporan -->
        <div class="bg-white rounded-lg p-md border border-outline-variant flex items-center gap-md">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed flex-shrink-0">
                <span class="material-symbols-outlined text-sm sm:text-base" data-icon="description">description</span>
            </div>
            <div class="min-w-0">
                <p class="font-small text-small text-on-surface-variant whitespace-nowrap">Total</p>
                <p class="font-h2 text-h2 md:font-h2 md:text-h2 text-on-background">{{ $total }}</p>
            </div>
        </div>

        <!-- Card Sedang Proses -->
        <div class="bg-white rounded-lg p-md border border-outline-variant flex items-center gap-md">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-tertiary-fixed flex items-center justify-center text-on-tertiary-fixed flex-shrink-0">
                <span class="material-symbols-outlined text-sm sm:text-base" data-icon="build">build</span>
            </div>
            <div class="min-w-0">
                <p class="font-small text-small text-on-surface-variant whitespace-nowrap">Diproses</p>
                <p class="font-h2 text-h2 md:font-h2 md:text-h2 text-on-background">{{ $laporanproses }}</p>
            </div>
        </div>

        <!-- Card Selesai -->
        <div class="bg-white rounded-lg p-md border border-outline-variant flex items-center gap-md">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed flex-shrink-0">
                <span class="material-symbols-outlined text-sm sm:text-base" data-icon="check_circle">check_circle</span>
            </div>
            <div class="min-w-0">
                <p class="font-small text-small text-on-surface-variant whitespace-nowrap">Selesai</p>
                <p class="font-h2 text-h2 md:font-h2 md:text-h2 text-on-background">{{ $laporanselesai }}</p>
            </div>
        </div>
    </div>
</div>

    <!-- ===== FILTER SECTION (Mobile Optimized) ===== -->
    <div class="bg-white p-md md:p-xl rounded-xl border border-outline-variant custom-shadow mb-md md:mb-xl">
        <form method="GET" action="{{ route('pemantau.laporan.index') }}" class="space-y-md">
            <!-- Filter Header dengan Toggle untuk Mobile -->
            <div class="flex items-center justify-between md:hidden mb-md">
                <h3 class="font-h3 text-h3 text-on-surface">Filter</h3>
                <button type="button" 
                        onclick="toggleFilter()" 
                        class="p-2 rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined" id="filterIcon">expand_more</span>
                </button>
            </div>

            <!-- Filter Content (Collapsible di Mobile) -->
           <div id="filterContent" class="space-y-md">
    <!-- Baris 1: 4 Kolom (Cari Pelapor, Status, Pos, Peleton) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-sm md:gap-md">
        <!-- Search -->
        <div>
            <label class="font-small text-small text-on-surface-variant block mb-xs">Cari Pelapor</label>
            <input type="text" 
                   name="search" 
                   placeholder="Cari pelapor / Kendaraan..." 
                   value="{{ request('search') }}"
                   class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm">
        </div>

        <!-- Status -->
        <div>
            <label class="font-small text-small text-on-surface-variant block mb-xs">Status</label>
            <select name="status" class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition bg-white text-sm">
                <option value="">Semua Status</option>
                <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Diarsipkan" {{ request('status') == 'Diarsipkan' ? 'selected' : '' }}>Diarsipkan</option>
            </select>
        </div>

        <!-- Pos -->
        <div>
            <label class="font-small text-small text-on-surface-variant block mb-xs">Pos</label>
            <select name="posko" 
                    class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition bg-white text-sm">
                <option value="">Semua Pos</option>
                @foreach($poskos as $posko)
                    <option value="{{ $posko->id }}" {{ request('posko') == $posko->id ? 'selected' : '' }}>
                        {{ $posko->nama_posko }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Peleton -->
        <div>
            <label class="font-small text-small text-on-surface-variant block mb-xs">Peleton</label>
            <select name="platon" 
                    class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition bg-white text-sm">
                <option value="">Semua Peleton</option>
                @foreach($platons as $platon)
                    <option value="{{ $platon->id }}" {{ request('platon') == $platon->id ? 'selected' : '' }}>
                        {{ $platon->nama }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Baris 2: 4 Kolom (Regu, Tanggal Awal, Tanggal Akhir, Tombol Filter & Reset) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-sm md:gap-md">
        <!-- Regu -->
        <div>
            <label class="font-small text-small text-on-surface-variant block mb-xs">Regu</label>
            <select name="regu" 
                    class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition bg-white text-sm">
                <option value="">Semua Regu</option>
                @foreach($regus as $regu)
                    <option value="{{ $regu->id }}" {{ request('regu') == $regu->id ? 'selected' : '' }}>
                        {{ $regu->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tanggal Awal -->
        <div>
            <label class="font-small text-small text-on-surface-variant block mb-xs">Tanggal Awal</label>
            <input type="date" 
                   name="dari" 
                   value="{{ request('dari') }}"
                   class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm">
        </div>

        <!-- Tanggal Akhir -->
        <div>
            <label class="font-small text-small text-on-surface-variant block mb-xs">Tanggal Akhir</label>
            <input type="date" 
                   name="sampai" 
                   value="{{ request('sampai') }}"
                   class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm">
        </div>

        <!-- Tombol Filter & Reset (digabung dalam 1 kolom) -->
        <div class="flex items-end gap-sm">
            <button type="submit" 
                    class="flex-1 px-lg py-sm bg-primary text-white rounded-lg font-body-regular hover:bg-primary/90 transition-colors flex items-center justify-center gap-xs text-sm">
                <span class="material-symbols-outlined text-sm">filter_alt</span>
                Filter
            </button>
            <a href="{{ route('pemantau.laporan.index') }}" 
               class="flex-1 px-lg py-sm bg-surface-container-low text-on-surface-variant rounded-lg font-body-regular hover:bg-surface-container-high transition-colors flex items-center justify-center gap-xs text-sm">
                <span class="material-symbols-outlined text-sm">refresh</span>
                Reset
            </a>
        </div>
    </div>
</div>

               
                
            </div>
        </form>
    </div>

    <!-- ===== TABLE SECTION (Mobile Optimized) ===== -->
    <div class="bg-white rounded-xl border border-outline-variant custom-shadow overflow-hidden">
        <!-- Mobile Card View -->
        <div class="block md:hidden">
            @forelse($laporans as $laporan)
            <div class="p-md border-b border-outline-variant hover:bg-surface-container-low transition-colors">
                <div class="flex justify-between items-start mb-sm">
                    <div>
                        <span class="font-bold text-on-surface">{{ $laporan->nama_posko }}</span>
                        <span class="text-xs text-on-surface-variant block">{{ $laporan->platon->nama ?? '-' }} / {{ $laporan->regu->nama ?? '-' }}</span>
                    </div>
                    <!-- Status Badge -->
                    @if($laporan->status == 'Diproses')
                        <span class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-orange-100 text-orange-700 font-bold text-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                            Diproses
                        </span>
                    @elseif($laporan->status == 'Selesai')
                        <span class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-green-100 text-green-700 font-bold text-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            Selesai
                        </span>
                    @elseif($laporan->status == 'Diarsipkan')
                        <span class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-gray-100 text-gray-600 font-bold text-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                            Diarsipkan
                        </span>
                    @else
                        <span class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-red-100 text-red-700 font-bold text-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                            Ditolak
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-y-2 text-sm">
                    <div>
                        <span class="text-on-surface-variant text-xs">Pelapor</span>
                        <p class="font-medium">{{ $laporan->user?->name ?? 'Dinonaktifkan' }}</p>
                    </div>
                    <div>
                        <span class="text-on-surface-variant text-xs">Plat Nomor</span>
                        <p class="font-medium">{{ $laporan->kendaraan->nomor_polisi }}</p>
                    </div>
                    <div>
                        <span class="text-on-surface-variant text-xs">Peralatan Rusak</span>
                        <p class="font-medium text-error">{{ $laporan->laporanPeralatans->where('kondisi', 'Rusak Berat')->count() }} item</p>
                    </div>
                    <div>
                        <span class="text-on-surface-variant text-xs">Kondisi Bermasalah</span>
                        <p class="font-medium text-tertiary">{{ $laporan->laporanKondisis->where('status', 'Perlu Perhatian')->count() }} item</p>
                    </div>
                    <div class="col-span-2">
                        <span class="text-on-surface-variant text-xs">Waktu Lapor</span>
                        <p class="font-medium">{{ $laporan->created_at->format('d-m-Y H:i') }}</p>
                    </div>
                </div>

                <div class="mt-sm pt-sm border-t border-outline-variant">
                    <a href="{{ route('pemantau.laporan.show', $laporan->id) }}" 
                       class="inline-flex items-center justify-center w-full gap-xs px-md py-sm bg-primary/10 text-primary rounded-lg hover:bg-primary/20 transition-colors font-medium text-sm">
                        <span class="material-symbols-outlined text-sm">visibility</span>
                        Lihat Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="p-xl text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-4xl block mb-sm">inbox</span>
                <span class="font-body-regular">Tidak ada data laporan yang ditemukan</span>
            </div>
            @endforelse
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto overflow-y-auto max-h-[600px]" style="overscroll-behavior: contain;">
            <table class="w-full min-w-[1200px] zebra-table">
                <thead class="bg-primary text-white sticky top-0 z-10">
                    <tr>
                        <th class="p-md font-h4 text-h4 text-left whitespace-nowrap">Pos</th>
                        <th class="p-md font-h4 text-h4 text-left whitespace-nowrap">Peleton / Regu</th>
                        <th class="p-md font-h4 text-h4 text-left whitespace-nowrap">Pelapor</th>
                        <th class="p-md font-h4 text-h4 text-left whitespace-nowrap">Plat Nomor</th>
                        <th class="p-md font-h4 text-h4 text-center whitespace-nowrap">Peralatan Rusak</th>
                        <th class="p-md font-h4 text-h4 text-center whitespace-nowrap">Kondisi Bermasalah</th>
                        <th class="p-md font-h4 text-h4 text-left whitespace-nowrap">Waktu Lapor</th>
                        <th class="p-md font-h4 text-h4 text-left whitespace-nowrap">Status</th>
                        <th class="p-md font-h4 text-h4 text-left whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-body-regular text-body-regular">
                    @forelse($laporans as $laporan)
                    <tr>
                        <td class="p-md border-b border-outline-variant">
                            {{$laporan->nama_posko}}
                        </td>
                        <td class="p-md border-b border-outline-variant">
                            {{ $laporan->platon->nama ?? '-' }} / {{ $laporan->regu->nama ?? '-' }}
                        </td>
                        <td class="p-md border-b border-outline-variant">
                            {{ $laporan->user?->name ?? 'Dinonaktifkan' }}         
                        </td>
                        <td class="p-md border-b border-outline-variant">
                            {{ $laporan->kendaraan->nomor_polisi }}
                        </td>
                        <td class="p-md border-b border-outline-variant text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-error/10 text-error font-bold">
                                {{ $laporan->laporanPeralatans->where('kondisi', 'Rusak Berat')->count() }}
                            </span>
                        </td>
                        <td class="p-md border-b border-outline-variant text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-tertiary/10 text-tertiary font-bold">
                                {{ $laporan->laporanKondisis->where('status', 'Perlu Perhatian')->count() }}
                            </span>
                        </td>
                        <td class="p-md border-b border-outline-variant">
                            {{ $laporan->created_at->format('d-m-Y') }}
                        </td>
                        <td class="p-md border-b border-outline-variant">
                            @if($laporan->status == 'Diproses')
                                <span class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-orange-100 text-orange-700 font-bold text-small">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                    Diproses
                                </span>
                            @elseif($laporan->status == 'Selesai')
                                <span class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-green-100 text-green-700 font-bold text-small">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Selesai
                                </span>
                            @elseif($laporan->status == 'Diarsipkan')
                                <span class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-gray-100 text-gray-600 font-bold text-small">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    Diarsipkan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-red-100 text-red-700 font-bold text-small">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="p-md border-b border-outline-variant">
                            <a href="{{ route('pemantau.laporan.show', $laporan->id) }}" 
                               class="inline-flex items-center gap-xs px-md py-sm bg-primary/10 text-primary rounded-lg hover:bg-primary/20 transition-colors font-medium text-small">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="p-xl text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl block mb-sm">inbox</span>
                            <span class="font-body-regular">Tidak ada data laporan yang ditemukan</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== PAGINATION ===== -->
    <div class="mt-xl">
        {{ $laporans->links() }}
    </div>
</div>

<!-- ===== MOBILE FILTER TOGGLE SCRIPT ===== -->
<script>
    function toggleFilter() {
        const content = document.getElementById('filterContent');
        const icon = document.getElementById('filterIcon');
        
        if (content.style.display === 'none') {
            content.style.display = 'block';
            icon.textContent = 'expand_less';
        } else {
            content.style.display = 'none';
            icon.textContent = 'expand_more';
        }
    }

    // Set initial state for mobile
    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth < 768) {
            document.getElementById('filterContent').style.display = 'none';
        }
    });

    // Handle resize
    window.addEventListener('resize', function() {
        const content = document.getElementById('filterContent');
        if (window.innerWidth >= 768) {
            content.style.display = 'block';
        } else {
            // Only hide if not explicitly opened
            if (!content.style.display || content.style.display === 'block') {
                // Check if it was manually opened
                const icon = document.getElementById('filterIcon');
                if (icon.textContent === 'expand_more') {
                    content.style.display = 'none';
                }
            }
        }
    });
</script>

@endsection