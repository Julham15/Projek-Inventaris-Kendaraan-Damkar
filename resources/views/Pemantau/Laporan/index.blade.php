@extends('Pemantau.layouts.index')
@section('admin2')

<!-- ===== WELCOME ===== -->
<div class="mb-xl p-lg bg-primary-container/10 border border-primary-container/30 rounded-xl">
    <h1 class="font-h1 text-h1 text-primary mb-xs">Data Laporan User</h1>
    <p class="font-body-regular text-body-regular text-on-surface-variant max-w-3xl">Kelola dan filter seluruh laporan yang masuk dari berbagai posko dan unit operasional.</p>
</div>

<div class="flex-1 overflow-x-auto p-lg md:p-margin">
<!-- Stats/Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter mb-lg">
<div class="bg-white rounded-lg p-md border border-outline-variant flex items-center gap-md">
<div class="w-12 h-12 rounded-full bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed">
<span class="material-symbols-outlined" data-icon="description">description</span>
</div>
<div>
<p class="font-small text-small text-on-surface-variant">Total Laporan</p>
<p class="font-h2 text-h2 text-on-background">{{ $total }}</p>
</div>
</div>
<div class="bg-white rounded-lg p-md border border-outline-variant flex items-center gap-md">
<div class="w-12 h-12 rounded-full bg-tertiary-fixed flex items-center justify-center text-on-tertiary-fixed">
<span class="material-symbols-outlined" data-icon="build">build</span>
</div>
<div>
<p class="font-small text-small text-on-surface-variant">Sedang Proses</p>
<p class="font-h2 text-h2 text-on-background">{{ $laporanproses }}</p>
</div>
</div>
<div class="bg-white rounded-lg p-md border border-outline-variant flex items-center gap-md">
<div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed">
<span class="material-symbols-outlined" data-icon="check_circle">check_circle</span>
</div>
<div>
<p class="font-small text-small text-on-surface-variant">Selesai</p>
<p class="font-h2 text-h2 text-on-background">{{ $laporanselesai }}</p>
</div>
</div>
</div>
<!-- ===== FILTER SECTION ===== -->
<div class="bg-white p-xl rounded-xl border border-outline-variant custom-shadow mb-xl">
    <form method="GET" action="{{ route('pemantau.laporan.index') }}" class="space-y-md">
        <!-- Baris 1: Cari Pelapor, Status, Pos, Peleton -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-md">
            <!-- Search -->
            <div>
                <label class="font-small text-small text-on-surface-variant block mb-xs">Cari Pelapor</label>
                <input type="text" 
                       name="search" 
                       placeholder="Cari pelapor" 
                       value="{{ request('search') }}"
                       class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">
            </div>

            <!-- Status -->
            <div>
                <label class="font-small text-small text-on-surface-variant block mb-xs">Status</label>
                <select name="status" class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition bg-white">
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
                        class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition bg-white">
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
                        class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition bg-white">
                    <option value="">Semua Peleton</option>
                    @foreach($platons as $platon)
                        <option value="{{ $platon->id }}" {{ request('platon') == $platon->id ? 'selected' : '' }}>
                            {{ $platon->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Baris 2: Regu, Tanggal Awal, Tanggal Akhir, Filter & Reset -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-md">
            <!-- Regu -->
            <div>
                <label class="font-small text-small text-on-surface-variant block mb-xs">Regu</label>
                <select name="regu" 
                        class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition bg-white">
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
                       class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">
            </div>

            <!-- Tanggal Akhir -->
            <div>
                <label class="font-small text-small text-on-surface-variant block mb-xs">Tanggal Akhir</label>
                <input type="date" 
                       name="sampai" 
                       value="{{ request('sampai') }}"
                       class="w-full px-md py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">
            </div>

            <!-- Filter & Reset -->
            <div class="flex items-end gap-sm">
                <button type="submit" 
                        class="px-lg py-sm bg-primary text-white rounded-lg font-body-regular hover:bg-primary/90 transition-colors flex items-center gap-xs">
                    <span class="material-symbols-outlined text-sm">filter_alt</span>
                    Filter
                </button>
                <a href="{{ route('pemantau.laporan.index') }}" 
                   class="px-lg py-sm bg-surface-container-low text-on-surface-variant rounded-lg font-body-regular hover:bg-surface-container-high transition-colors flex items-center gap-xs">
                    <span class="material-symbols-outlined text-sm">refresh</span>
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- ===== TABLE SECTION ===== -->
<div class="bg-white rounded-xl border border-outline-variant custom-shadow overflow-hidden">
    <div class="overflow-x-auto overflow-y-auto max-h-[600px]" style="overscroll-behavior: contain;">
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

@endsection