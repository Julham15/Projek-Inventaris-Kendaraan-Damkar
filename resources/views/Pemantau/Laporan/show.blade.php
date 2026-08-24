@extends('Pemantau.layouts.index')
@section('admin2')

<!-- ===== WELCOME ===== -->
<div class="mb-md md:mb-xl p-md md:p-lg bg-primary-container/10 border border-primary-container/30 rounded-xl">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-sm">
        <div>
            <h1 class="font-h2 md:font-h1 text-h2 md:text-h1 text-primary mb-xs">Detail Laporan Peralatan & Kondisi</h1>
            <p class="font-small md:font-body-regular text-small md:text-body-regular text-on-surface-variant max-w-3xl">Informasi lengkap mengenai peralatan rusak dan kondisi kendaraan yang dilaporkan.</p>
        </div>
        <a href="{{ route('pemantau.laporan.index') }}" 
           class="inline-flex items-center gap-xs px-md md:px-lg py-sm bg-surface-container-low text-on-surface-variant rounded-lg hover:bg-surface-container-high transition-colors font-small md:font-body-regular text-small md:text-body-regular flex-shrink-0">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali
        </a>
    </div>
</div>

<!-- ===== PLAT NOMOR ===== -->
<div class="flex justify-center my-3 md:my-4">
    <h2 class="text-h3 md:text-h2 text-center w-auto min-w-[180px] md:min-w-[200px] border border-primary from-secondary to-secondary/60 font-bold py-2 md:py-3 px-4 md:px-6 rounded-xl text-sm md:text-base">
        {{ $laporan->kendaraan->nomor_polisi }}
    </h2>
</div>

<!-- ===== DETAIL LAPORAN ===== -->
<div class="bg-white rounded-lg border border-outline-variant overflow-hidden">
    <div class="p-sm md:p-md bg-surface-container border-b border-outline-variant flex items-center justify-between">
        <h3 class="font-h3 text-h3 text-on-surface flex items-center gap-2 text-sm md:text-base">
            <span class="material-symbols-outlined text-primary text-base md:text-xl">description</span>
            Detail Laporan
        </h3>
        <!-- Status di sebelah kanan -->
        <div class="text-body-regular font-semibold">
            @if($laporan->status == 'Diproses')
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20">
                    <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block bg-primary animate-pulse"></span>
                    Diproses
                </span>
            @elseif($laporan->status == 'Selesai')
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                    <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block bg-green-500"></span>
                    Selesai
                </span>
            @elseif($laporan->status == 'Diarsipkan')
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-surface-container/50 text-on-surface-variant border border-outline-variant">
                    <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block bg-on-surface-variant"></span>
                    Diarsipkan
                </span>
            @endif
        </div>
    </div>
    
    <div class="p-md md:p-lg">
    <!-- Grid 2 Baris x 2 Kolom -->
    <div class="grid grid-cols-2 grid-rows-2 gap-3 md:gap-4">
        <!-- Baris 1 Kolom 1: Pelapor -->
        <div class="space-y-1">
            <label class="font-small text-small text-on-surface-variant text-xs md:text-sm">Pelapor</label>
            <p class="font-body-regular text-body-regular text-on-surface font-semibold text-sm md:text-base">{{ $laporan->user?->name ?? 'Dinonaktifkan' }}</p>
        </div>
        
        <!-- Baris 1 Kolom 2: Waktu Laporan -->
        <div class="space-y-1">
            <label class="font-small text-small text-on-surface-variant text-xs md:text-sm">Waktu Laporan</label>
            <p class="font-body-regular text-body-regular text-on-surface font-semibold text-sm md:text-base">{{ $laporan->created_at->format('d-m-Y / H:i') }}</p>
        </div>
        
        <!-- Baris 2 Kolom 1: Pos -->
        <div class="space-y-1">
            <label class="font-small text-small text-on-surface-variant text-xs md:text-sm">Pos</label>
            <p class="font-body-regular text-body-regular text-on-surface font-semibold text-sm md:text-base">{{ $laporan->nama_posko }}</p>
        </div>
        
        <!-- Baris 2 Kolom 2: Peleton - Regu -->
        <div class="space-y-1">
            <label class="font-small text-small text-on-surface-variant text-xs md:text-sm">Peleton - Regu</label>
            <p class="font-body-regular text-body-regular text-on-surface font-semibold text-sm md:text-base">{{ $laporan->platon->nama }} - {{ $laporan->regu->nama }}</p>
        </div>
    </div>
</div>
</div>

<!-- ===== DATA PERALATAN ===== -->
<div class="mt-md md:mt-lg bg-white rounded-lg border border-outline-variant shadow-sm overflow-hidden">
    <div class="p-sm md:p-md bg-surface-container border-b border-outline-variant flex flex-wrap items-center justify-between gap-2">
        <h3 class="font-h3 text-h3 text-on-surface flex items-center gap-2 text-sm md:text-base">
            <span class="material-symbols-outlined text-primary text-base md:text-xl">construction</span>
            Data Peralatan
        </h3>
        <span class="text-xs md:text-small text-on-surface-variant bg-surface-bright px-2 md:px-3 py-0.5 md:py-1 rounded-full border border-outline-variant">
            Total: {{ $laporan->laporanPeralatans->count() }} item
        </span>
    </div>

    @if($laporan->laporanPeralatans->count())
   <!-- Mobile Card View -->
<div class="block md:hidden p-sm space-y-3">
    @foreach($laporan->laporanPeralatans as $item)
    <div class="bg-surface-container/30 rounded-lg border border-outline-variant p-3 hover:shadow-md transition-shadow">
        <!-- Baris 1: No(#) dan Jumlah Real (background primary) -->
        <div class="grid grid-cols-2 gap-2 mb-2 bg-primary text-on-primary rounded-lg p-2">
            <div>
                <span class="text-xs text-on-primary/80">No</span>
                <p class="font-bold text-sm text-on-primary">#{{ $loop->iteration }}</p>
            </div>
            <div>
                <span class="text-xs text-on-primary/80">Jumlah Real</span>
                <p class="font-bold text-on-primary">{{ $item->jumlah_awal }}</p>
            </div>
        </div>
        
        <!-- Baris 2: Nama Alat dan Jumlah Dilaporkan -->
        <div class="grid grid-cols-2 gap-2 mb-2">
            <div>
                <span class="text-xs text-on-surface-variant">Nama Alat</span>
                <p class="font-medium text-sm">{{ $item->nama_peralatan }}</p>
            </div>
            <div>
                <span class="text-xs text-on-surface-variant">Jumlah Dilaporkan</span>
                <p class="font-bold text-sm">{{ $item->jumlah }}</p>
            </div>
        </div>
        
        <!-- Baris 3: Kondisi dan Lihat Foto -->
        <div class="grid grid-cols-2 gap-2 mb-2">
            <div>
                <span class="text-xs text-on-surface-variant">Kondisi</span>
                <div class="mt-0.5">
                    @if($item->kondisi == 'Baik')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block bg-green-500"></span>
                            {{ $item->kondisi }}
                        </span>
                    @elseif($item->kondisi == 'Rusak Ringan')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                            <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block bg-yellow-500"></span>
                            {{ $item->kondisi }}
                        </span>
                    @elseif($item->kondisi == 'Rusak Berat')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                            <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block bg-red-500"></span>
                            {{ $item->kondisi }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block bg-gray-500"></span>
                            {{ $item->kondisi }}
                        </span>
                    @endif
                </div>
            </div>
            <div>
                <span class="text-xs text-on-surface-variant">Foto</span>
                <div class="mt-0.5">
                    @if($item->foto)
                        <button onclick="openModal('peralatan-{{ $item->id }}')"
                            class="inline-flex items-center gap-1 px-3 py-1.5 border border-primary rounded-lg text-primary hover:bg-primary-container hover:text-on-primary transition-all duration-200 text-xs">
                            <span class="material-symbols-outlined text-[18px]">photo</span>
                            Lihat
                        </button>
                    @elseif($item->foto_dihapus_admin)
                        <button onclick="openModal('peralatan-{{ $item->id }}')"
                            class="inline-flex items-center gap-1 px-3 py-1.5 border border-red-500 rounded-lg text-red-500 hover:bg-red-500 hover:text-white transition-all duration-200 text-xs">
                            <span class="material-symbols-outlined text-[18px]">photo</span>
                            Lihat
                        </button>
                    @else
                        <button onclick="openModal('peralatan-{{ $item->id }}')"
                            class="inline-flex items-center gap-1 px-3 py-1.5 border border-gray-400 rounded-lg text-gray-500 hover:bg-gray-200 transition-all duration-200 text-xs">
                            <span class="material-symbols-outlined text-[18px]">photo</span>
                            Lihat
                        </button>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Baris 4: Keterangan (full width) -->
        <div class="pt-2 border-t border-outline-variant">
            <span class="text-xs text-on-surface-variant">Keterangan</span>
            <p class="text-sm">{{ $item->deskripsi ?? '-' }}</p>
        </div>
    </div>
    @endforeach
</div>

    <!-- Desktop Table View -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-primary text-on-primary">
                    <th class="py-sm px-md font-h4 text-h4 w-16 text-center">No</th>
                    <th class="py-sm px-md font-h4 w-[200px] text-center text-h4">Nama Alat</th>
                    <th class="py-sm px-md font-h4 text-h4 w-25 text-center">Jumlah <br> Real</th>
                    <th class="py-sm px-md font-h4 text-h4 w-25 text-center">Jumlah <br> Dilaporkan</th>
                    <th class="py-sm px-md font-h4 text-h4 w-40 text-center">Kondisi</th>
                    <th class="py-sm px-md font-h4 text-h4 w-48 text-center">Foto</th>
                    <th class="py-sm px-md font-h4 text-h4 min-w-[200px]">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-variant font-body-regular text-body-regular text-center text-on-surface">
                @foreach($laporan->laporanPeralatans as $item)
                <tr class="hover:bg-surface transition-colors">
                    <td class="py-sm px-md text-center">{{ $loop->iteration }}</td>
                    <td class="py-sm px-md font-medium">{{ $item->nama_peralatan }}</td>
                    <td class="py-sm px-md text-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10 text-primary font-bold">
                            {{ $item->jumlah_awal }}
                        </span>
                    </td>
                    <td class="py-sm px-md text-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10 text-primary font-bold">
                            {{ $item->jumlah }}
                        </span>
                    </td>
                    <td class="py-sm px-md text-center">
                        @if($item->kondisi == 'Baik')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-green-500"></span>
                                {{ $item->kondisi }}
                            </span>
                        @elseif($item->kondisi == 'Rusak Ringan')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-yellow-500"></span>
                                {{ $item->kondisi }}
                            </span>
                        @elseif($item->kondisi == 'Rusak Berat')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-red-500"></span>
                                {{ $item->kondisi }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-gray-500"></span>
                                {{ $item->kondisi }}
                            </span>
                        @endif
                    </td>
                    <td class="py-sm px-md text-center">
                        <button onclick="openModal('peralatan-{{ $item->id }}')"
                            class="inline-flex items-center gap-1 mx-auto px-3 py-2 border border-primary rounded-lg text-primary hover:bg-primary-container hover:text-on-primary transition-all duration-200">
                            <span class="material-symbols-outlined text-[20px]">photo</span>
                            <span class="font-small text-small">Lihat</span>
                        </button>
                    </td>
                    <td class="py-sm px-md text-left">
                        {{ $item->deskripsi ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-xl text-center text-on-surface-variant">
        <div class="flex flex-col items-center py-8">
            <span class="material-symbols-outlined text-4xl text-outline mb-2">inventory_2</span>
            <p>Tidak ada data peralatan</p>
        </div>
    </div>
    @endif
</div>

<!-- ===== DATA KONDISI ===== -->
<div class="mt-md md:mt-lg bg-white rounded-lg border border-outline-variant shadow-sm overflow-hidden">
    <div class="p-sm md:p-md bg-surface-container border-b border-outline-variant flex flex-wrap items-center justify-between gap-2">
        <h3 class="font-h3 text-h3 text-on-surface flex items-center gap-2 text-sm md:text-base">
            <span class="material-symbols-outlined text-primary text-base md:text-xl">health_metrics</span>
            Data Kondisi Kendaraan
        </h3>
        <span class="text-xs md:text-small text-on-surface-variant bg-surface-bright px-2 md:px-3 py-0.5 md:py-1 rounded-full border border-outline-variant">
            Total: {{ $laporan->laporanKondisis->count() }} item
        </span>
    </div>

    @if($laporan->laporanKondisis->count())
   <!-- Mobile Card View -->
<div class="block md:hidden p-sm space-y-3">
    @foreach($laporan->laporanKondisis as $item)
    <div class="bg-surface-container/30 rounded-lg border border-outline-variant p-3 hover:shadow-md transition-shadow">
        <!-- Baris 1: No(#) dan Status (background primary) -->
        <div class="grid grid-cols-2 gap-2 mb-2 bg-primary text-on-primary rounded-lg p-2">
            <div>
                <span class="text-xs text-on-primary/80">No</span>
                <p class="font-bold text-sm text-on-primary">#{{ $loop->iteration }}</p>
            </div>
            <div>
                <span class="text-xs text-on-primary/80">Status</span>
                <div class="mt-0.5">
                    @if($item->status == 'Baik')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium text-on-primary">
                            <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block bg-green-400"></span>
                            {{ $item->status }}
                        </span>
                    @elseif($item->status == 'Perlu Perhatian')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium text-on-primary">
                            <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block bg-yellow-400"></span>
                            {{ $item->status }}
                        </span>
                    @elseif($item->status == 'Rusak')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium text-on-primary">
                            <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block bg-red-400"></span>
                            {{ $item->status }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium text-on-primary">
                            <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block bg-gray-400"></span>
                            {{ $item->status }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Baris 2: Nama Kondisi dan Foto -->
        <div class="grid grid-cols-2 gap-2 mb-2">
            <div>
                <span class="text-xs text-on-surface-variant">Nama Kondisi</span>
                <p class="font-medium text-sm">{{ $item->nama_kondisi }}</p>
            </div>
            <div>
                <span class="text-xs text-on-surface-variant">Foto</span>
                <div class="mt-0.5">
                    @if($item->foto)
                        <button onclick="openModal('kondisi-{{ $item->id }}')"
                            class="inline-flex items-center gap-1 px-3 py-1.5 border border-primary rounded-lg text-primary hover:bg-primary-container hover:text-on-primary transition-all duration-200 text-xs">
                            <span class="material-symbols-outlined text-[18px]">photo</span>
                            Lihat
                        </button>
                    @elseif($item->foto_dihapus_admin)
                        <button onclick="openModal('kondisi-{{ $item->id }}')"
                            class="inline-flex items-center gap-1 px-3 py-1.5 border border-red-500 rounded-lg text-red-500 hover:bg-red-500 hover:text-white transition-all duration-200 text-xs">
                            <span class="material-symbols-outlined text-[18px]">photo</span>
                            Lihat
                        </button>
                    @else
                        <button onclick="openModal('kondisi-{{ $item->id }}')"
                            class="inline-flex items-center gap-1 px-3 py-1.5 border border-gray-400 rounded-lg text-gray-500 hover:bg-gray-200 transition-all duration-200 text-xs">
                            <span class="material-symbols-outlined text-[18px]">photo</span>
                            Lihat
                        </button>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Baris 3: Keterangan (full width) -->
        <div class="pt-2 border-t border-outline-variant">
            <span class="text-xs text-on-surface-variant">Keterangan</span>
            <p class="text-sm">{{ $item->deskripsi ?? '-' }}</p>
        </div>
    </div>
    @endforeach
</div>

    <!-- Desktop Table View -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-primary text-on-primary">
                    <th class="py-sm px-md font-h4 text-h4 w-16 text-center">No</th>
                    <th class="py-sm px-md font-h4 text-h4 text-center">Nama Kondisi</th>
                    <th class="py-sm px-md font-h4 text-h4 text-center">Status</th>
                    <th class="py-sm px-md font-h4 text-h4 text-center">Foto</th>
                    <th class="py-sm px-md font-h4 text-h4 min-w-[200px]">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-variant text-center font-body-regular text-body-regular text-on-surface">
                @foreach($laporan->laporanKondisis as $item)
                <tr class="hover:bg-surface transition-colors">
                    <td class="py-sm px-md text-center">{{ $loop->iteration }}</td>
                    <td class="py-sm px-md font-medium">{{ $item->nama_kondisi }}</td>
                    <td class="py-sm px-md text-center">
                        @if($item->status == 'Baik')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-green-500"></span>
                                {{ $item->status }}
                            </span>
                        @elseif($item->status == 'Perlu Perhatian')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-yellow-500"></span>
                                {{ $item->status }}
                            </span>
                        @elseif($item->status == 'Rusak')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-red-500"></span>
                                {{ $item->status }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 inline-block bg-gray-500"></span>
                                {{ $item->status }}
                            </span>
                        @endif
                    </td>
                    <td class="py-sm px-md text-center">
                        <button onclick="openModal('kondisi-{{ $item->id }}')"
                            class="inline-flex items-center gap-1 mx-auto px-3 py-2 border border-primary rounded-lg text-primary hover:bg-primary-container hover:text-on-primary transition-all duration-200">
                            <span class="material-symbols-outlined text-[20px]">photo</span>
                            <span class="font-small text-small">Lihat</span>
                        </button>
                    </td>
                    <td class="py-sm text-left px-md">
                        {{ $item->deskripsi ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-xl text-center text-on-surface-variant">
        <div class="flex flex-col items-center py-8">
            <span class="material-symbols-outlined text-4xl text-outline mb-2">checklist</span>
            <p>Tidak ada data kondisi</p>
        </div>
    </div>
    @endif
</div>

<!-- ===== MODALS ===== -->
<!-- Modal Foto Peralatan -->
@foreach($laporan->laporanPeralatans as $item)
<div id="peralatan-{{ $item->id }}"
     class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 backdrop-blur-sm p-4"
     onclick="closeModal('peralatan-{{ $item->id }}')">
    <div class="max-w-3xl max-h-[90vh] bg-white rounded-xl overflow-hidden shadow-2xl w-full"
         onclick="event.stopPropagation()">
        <div class="flex justify-between items-center p-3 md:p-4 border-b">
            <h3 class="font-h3 text-sm md:text-base truncate max-w-[200px] md:max-w-none">
                {{ $item->nama_peralatan }}
            </h3>
            <button onclick="closeModal('peralatan-{{ $item->id }}')" class="text-2xl hover:text-primary transition-colors p-1">
                ✕
            </button>
        </div>
        <div class="p-3 md:p-4">
            @if($item->foto)
                <img src="{{ asset('storage/'.$item->foto) }}"
                     class="max-w-full max-h-[65vh] md:max-h-[75vh] object-contain mx-auto">
            @elseif($item->foto_dihapus_admin)
                <div class="flex flex-col items-center justify-center h-[300px] md:h-[400px] text-center">
                    <span class="material-symbols-outlined text-6xl md:text-7xl text-red-400">
                        hide_image
                    </span>
                    <h3 class="mt-4 text-lg md:text-xl font-semibold text-red-600">
                        Foto telah dihapus oleh Admin
                    </h3>
                    <p class="mt-2 text-sm md:text-base text-gray-500">
                        File gambar sudah tidak tersedia.
                    </p>
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-[300px] md:h-[400px] text-center">
                    <span class="material-symbols-outlined text-6xl md:text-7xl text-gray-400">
                        image_not_supported
                    </span>
                    <h3 class="mt-4 text-lg md:text-xl font-semibold text-gray-700">
                        Foto tidak diunggah
                    </h3>
                    <p class="mt-2 text-sm md:text-base text-gray-500">
                        {{ $laporan->user?->name ?? 'Dinonaktifkan'}} tidak mengunggah foto untuk item ini.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endforeach

<!-- Modal Foto Kondisi -->
@foreach($laporan->laporanKondisis as $item)
<div id="kondisi-{{ $item->id }}"
     class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 backdrop-blur-sm p-4"
     onclick="closeModal('kondisi-{{ $item->id }}')">
    <div class="max-w-3xl max-h-[90vh] bg-white rounded-xl overflow-hidden shadow-2xl w-full"
         onclick="event.stopPropagation()">
        <div class="flex justify-between items-center p-3 md:p-4 border-b">
            <h3 class="font-h3 text-sm md:text-base truncate max-w-[200px] md:max-w-none">
                {{ $item->nama_kondisi }}
            </h3>
            <button onclick="closeModal('kondisi-{{ $item->id }}')" class="text-2xl hover:text-primary transition-colors p-1">
                ✕
            </button>
        </div>
        <div class="p-3 md:p-4">
            @if($item->foto)
                <img src="{{ asset('storage/'.$item->foto) }}"
                     class="max-w-full max-h-[65vh] md:max-h-[75vh] object-contain mx-auto">
            @elseif($item->foto_dihapus_admin)
                <div class="flex flex-col items-center justify-center h-[300px] md:h-[400px] text-center">
                    <span class="material-symbols-outlined text-6xl md:text-7xl text-red-400">
                        hide_image
                    </span>
                    <h3 class="mt-4 text-lg md:text-xl font-semibold text-red-600">
                        Foto telah dihapus oleh Admin
                    </h3>
                    <p class="mt-2 text-sm md:text-base text-gray-500">
                        File gambar sudah tidak tersedia.
                    </p>
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-[300px] md:h-[400px] text-center">
                    <span class="material-symbols-outlined text-6xl md:text-7xl text-gray-400">
                        image_not_supported
                    </span>
                    <h3 class="mt-4 text-lg md:text-xl font-semibold text-gray-700">
                        Foto tidak diunggah
                    </h3>
                    <p class="mt-2 text-sm md:text-base text-gray-500">
                        {{ $laporan->user?->name ?? 'Dinonaktifkan'}} tidak mengunggah foto untuk item ini.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endforeach

<style>
    /* Styling untuk modal */
    .modal-open {
        overflow: hidden;
    }

    /* Animasi fade in untuk modal */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .fixed.inset-0.flex {
        animation: fadeIn 0.2s ease-out;
    }
</style>

<script>
    // Fungsi untuk membuka modal
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('modal-open');
        }
    }

    // Fungsi untuk menutup modal
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('modal-open');
        }
    }

    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="peralatan-"], [id^="kondisi-"]').forEach(modal => {
                if (!modal.classList.contains('hidden')) {
                    closeModal(modal.id);
                }
            });
        }
    });
</script>
@endsection