@extends('user.layouts.index')
@section('user')
    <!-- Main Content - Mobile First -->
    <main class="px-4 py-4 pb-24 max-w-full space-y-5 sm:px-6 md:px-8 lg:ml-64 lg:max-w-7xl lg:mx-auto lg:space-y-7">
        <!-- Header -->
        <section class="mt-2 flex flex-col items-start gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div class="w-full">
                <h1 class="text-2xl font-bold text-primary md:text-3xl lg:text-h1">Detail Laporan</h1>
                <p class="text-sm text-on-surface-variant mt-1 md:text-base lg:text-body-regular">Informasi lengkap laporan kendaraan dan peralatan.</p>
            </div>
        </section>

        <!-- Alert Success -->
        @if(session('success'))
            <div class="p-3 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3 md:p-4">
                <span class="material-symbols-outlined text-green-600 text-lg">check_circle</span>
                <p class="text-sm text-green-700 md:text-base">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Header Laporan -->
        <div class="text-center">
            <h2 class="text-xl font-bold text-primary uppercase md:text-2xl lg:text-h2">
                Mobil - {{ $laporan->kendaraan->nomor_polisi }}
            </h2>
        </div>

        <!-- Card Informasi Laporan -->
       <div class="bg-white rounded-xl border border-outline-variant overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="p-3 bg-surface-container border-b border-outline-variant md:p-4">
        <h3 class="text-base font-semibold text-on-surface flex items-center gap-2 md:text-lg lg:text-h3">
            <span class="material-symbols-outlined text-primary text-xl md:text-2xl">description</span>
            Detail Laporan
        </h3>
    </div>
    <div class="p-3 md:p-4 lg:p-5">
        <!-- Grid Informasi - 2 Baris -->
        <div class="grid grid-cols-2 gap-x-4 gap-y-3">
            <!-- Baris 1: Waktu Laporan & Status -->
            <div class="space-y-0.5">
                <label class="text-xs text-on-surface-variant md:text-sm">Waktu Laporan</label>
                <p class="text-sm text-on-surface font-semibold md:text-base">{{ $laporan->created_at->format('d-m-Y / H:i') }}</p>
            </div>
            <div class="space-y-0.5">
                <label class="text-xs text-on-surface-variant md:text-sm">Status</label>
                <div class="text-sm font-semibold md:text-base">
                    @if($laporan->status == 'Diproses')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-warning/10 text-warning rounded-full text-xs md:text-sm">
                            <span class="w-1.5 h-1.5 bg-warning rounded-full animate-pulse"></span>
                            Diproses
                        </span>
                    @elseif($laporan->status == 'Selesai')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-success/10 text-success rounded-full text-xs md:text-sm">
                            <span class="w-1.5 h-1.5 bg-success rounded-full"></span>
                            Selesai
                        </span>
                    @elseif($laporan->status == 'Diarsipkan')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-surface-container/50 text-on-surface-variant rounded-full text-xs md:text-sm">
                            <span class="w-1.5 h-1.5 bg-on-surface-variant rounded-full"></span>
                            Diarsipkan
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-error/10 text-error rounded-full text-xs md:text-sm">
                            <span class="w-1.5 h-1.5 bg-error rounded-full"></span>
                            Ditolak
                        </span>
                    @endif
                </div>
            </div>

            <!-- Baris 2: Pos & Jenis Mobil -->
            <div class="space-y-0.5">
                <label class="text-xs text-on-surface-variant md:text-sm">Pos</label>
                <p class="text-sm text-on-surface font-semibold md:text-base">{{ $laporan->nama_posko }}</p>
            </div>
            <div class="space-y-0.5">
                <label class="text-xs text-on-surface-variant md:text-sm">Jenis Mobil</label>
                <p class="text-sm text-on-surface font-semibold md:text-base">{{ $laporan->kendaraan->jenisMobil->nama_jenis ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

        <!-- Tabel Data Peralatan - Mobile Optimized -->
        <div class="bg-white rounded-xl border border-outline-variant shadow-sm overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="p-3 bg-surface-container border-b border-outline-variant flex flex-col items-start gap-2 sm:flex-row sm:justify-between sm:items-center md:p-4">
                <h3 class="text-base font-semibold text-on-surface flex items-center gap-2 md:text-lg lg:text-h3">
                    <span class="material-symbols-outlined text-primary text-xl md:text-2xl">construction</span>
                    Peralatan & Deskripsi
                </h3>
                <span class="text-xs text-on-surface-variant bg-surface-bright px-3 py-1 rounded-full border border-outline-variant md:text-sm">
                    Total: {{ $laporan->laporanPeralatans->count() }} item
                </span>
            </div>

            <!-- Mobile Card View -->
            <div class="block lg:hidden divide-y divide-outline-variant/30">
                @forelse($laporan->laporanPeralatans as $item)
                    <div class="p-3 space-y-2 hover:bg-surface-container-hover transition-colors md:p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-on-surface md:text-base">{{ $item->nama_peralatan }}</p>
                                <p class="text-xs text-on-surface-variant mt-0.5 md:text-sm">
                                    Jumlah: <span class="font-medium text-on-surface">{{ $item->jumlah }}</span>
                                </p>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                @if($item->kondisi == 'Baik') bg-green-100 text-green-800 border border-green-200
                                @elseif($item->kondisi == 'Rusak Ringan') bg-yellow-100 text-yellow-800 border border-yellow-200
                                @elseif($item->kondisi == 'Rusak Berat') bg-red-100 text-red-800 border border-red-200
                                @else bg-gray-100 text-gray-800 border border-gray-200
                                @endif">
                                <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block
                                    @if($item->kondisi == 'Baik') bg-green-500
                                    @elseif($item->kondisi == 'Rusak Ringan') bg-yellow-500
                                    @elseif($item->kondisi == 'Rusak Berat') bg-red-500
                                    @else bg-gray-500
                                    @endif">
                                </span>
                                {{ $item->kondisi }}
                            </span>
                        </div>
                        
                        <!-- Foto & Deskripsi -->
                        <div class="flex flex-wrap items-center gap-2 pt-1">
                            @if($item->foto)
                                <button onclick="openModal('peralatan-{{ $item->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 border border-primary rounded-lg text-primary hover:bg-primary-container hover:text-on-primary transition-all duration-200 text-xs md:text-sm">
                                    <span class="material-symbols-outlined text-sm">photo</span>
                                    Lihat Foto
                                </button>
                            @elseif($item->foto_dihapus_admin)
                                <button onclick="openModal('peralatan-{{ $item->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 border border-red-500 rounded-lg text-red-500 hover:bg-red-500 hover:text-white transition-all duration-200 text-xs md:text-sm">
                                    <span class="material-symbols-outlined text-sm">photo</span>
                                    Lihat Foto
                                </button>
                            @else
                                <button onclick="openModal('peralatan-{{ $item->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 border border-gray-400 rounded-lg text-gray-500 hover:bg-gray-200 transition-all duration-200 text-xs md:text-sm">
                                    <span class="material-symbols-outlined text-sm">photo</span>
                                    Lihat Foto
                                </button>
                            @endif
                            <span class="text-xs text-on-surface-variant flex-1 md:text-sm">
                                {{ $item->deskripsi ?? '-' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-on-surface-variant">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-5xl opacity-40">inventory_2</span>
                            <p class="text-sm md:text-base">Tidak ada data peralatan</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-primary text-on-primary">
                            <th class="py-2 px-3 text-xs font-bold text-center w-16">No</th>
                            <th class="py-2 px-3 text-xs font-bold">Nama Alat</th>
                            <th class="py-2 px-3 text-xs font-bold text-center w-24">Jumlah</th>
                            <th class="py-2 px-3 text-xs font-bold text-center w-40">Kondisi</th>
                            <th class="py-2 px-3 text-xs font-bold text-center w-48">Foto</th>
                            <th class="py-2 px-3 text-xs font-bold text-center min-w-[250px]">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-variant text-sm text-on-surface">
                        @forelse($laporan->laporanPeralatans as $item)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="py-2 px-3 text-center">{{ $loop->iteration }}</td>
                            <td class="py-2 px-3 font-medium">{{ $item->nama_peralatan }}</td>
                            <td class="py-2 px-3 text-center">{{ $item->jumlah }}</td>
                            <td class="py-2 px-3 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    @if($item->kondisi == 'Baik') bg-green-100 text-green-800 border border-green-200
                                    @elseif($item->kondisi == 'Rusak Ringan') bg-yellow-100 text-yellow-800 border border-yellow-200
                                    @elseif($item->kondisi == 'Rusak Berat') bg-red-100 text-red-800 border border-red-200
                                    @else bg-gray-100 text-gray-800 border border-gray-200
                                    @endif">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block
                                        @if($item->kondisi == 'Baik') bg-green-500
                                        @elseif($item->kondisi == 'Rusak Ringan') bg-yellow-500
                                        @elseif($item->kondisi == 'Rusak Berat') bg-red-500
                                        @else bg-gray-500
                                        @endif">
                                    </span>
                                    {{ $item->kondisi }}
                                </span>
                            </td>
                            <td class="py-2 px-3 text-center">
                                @if($item->foto)
                                    <button onclick="openModal('peralatan-{{ $item->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 border border-primary rounded-lg text-primary hover:bg-primary-container hover:text-on-primary transition-all duration-200 text-xs">
                                        <span class="material-symbols-outlined text-sm">photo</span>
                                        Lihat
                                    </button>
                                @elseif($item->foto_dihapus_admin)
                                    <button onclick="openModal('peralatan-{{ $item->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 border border-red-500 rounded-lg text-red-500 hover:bg-red-500 hover:text-white transition-all duration-200 text-xs">
                                        <span class="material-symbols-outlined text-sm">photo</span>
                                        Lihat
                                    </button>
                                @else
                                    <button onclick="openModal('peralatan-{{ $item->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 border border-gray-400 rounded-lg text-gray-500 hover:bg-gray-200 transition-all duration-200 text-xs">
                                        <span class="material-symbols-outlined text-sm">photo</span>
                                        Lihat
                                    </button>
                                @endif
                            </td>
                            <td class="py-2 px-3">{{ $item->deskripsi ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-on-surface-variant">
                                <div class="flex flex-col items-center">
                                    <span class="material-symbols-outlined text-4xl text-outline mb-2">inventory_2</span>
                                    <p class="text-sm">Tidak ada data peralatan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Data Kondisi - Mobile Optimized -->
        <div class="bg-white rounded-xl border border-outline-variant shadow-sm overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="p-3 bg-surface-container border-b border-outline-variant flex flex-col items-start gap-2 sm:flex-row sm:justify-between sm:items-center md:p-4">
                <h3 class="text-base font-semibold text-on-surface flex items-center gap-2 md:text-lg lg:text-h3">
                    <span class="material-symbols-outlined text-primary text-xl md:text-2xl">health_metrics</span>
                    Kondisi & Keterangan
                </h3>
                <span class="text-xs text-on-surface-variant bg-surface-bright px-3 py-1 rounded-full border border-outline-variant md:text-sm">
                    Total: {{ $laporan->laporanKondisis->count() }} item
                </span>
            </div>

            <!-- Mobile Card View -->
            <div class="block lg:hidden divide-y divide-outline-variant/30">
                @forelse($laporan->laporanKondisis as $item)
                    <div class="p-3 space-y-2 hover:bg-surface-container-hover transition-colors md:p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-on-surface md:text-base">{{ $item->nama_kondisi }}</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                @if($item->status == 'Baik') bg-green-100 text-green-800 border border-green-200
                                @elseif($item->status == 'Perlu Perhatian') bg-yellow-100 text-yellow-800 border border-yellow-200
                                @else bg-red-100 text-red-800 border border-red-200
                                @endif">
                                <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block
                                    @if($item->status == 'Baik') bg-green-500
                                    @elseif($item->status == 'Perlu Perhatian') bg-yellow-500
                                    @else bg-red-500
                                    @endif">
                                </span>
                                {{ $item->status }}
                            </span>
                        </div>
                        
                        <!-- Foto & Deskripsi -->
                        <div class="flex flex-wrap items-center gap-2 pt-1">
                            @if($item->foto)
                                <button onclick="openModal('kondisi-{{ $item->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 border border-primary rounded-lg text-primary hover:bg-primary-container hover:text-on-primary transition-all duration-200 text-xs md:text-sm">
                                    <span class="material-symbols-outlined text-sm">photo</span>
                                    Lihat Foto
                                </button>
                            @elseif($item->foto_dihapus_admin)
                                <button onclick="openModal('kondisi-{{ $item->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 border border-red-500 rounded-lg text-red-500 hover:bg-red-500 hover:text-white transition-all duration-200 text-xs md:text-sm">
                                    <span class="material-symbols-outlined text-sm">photo</span>
                                    Lihat Foto
                                </button>
                            @else
                                <button onclick="openModal('kondisi-{{ $item->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 border border-gray-400 rounded-lg text-gray-500 hover:bg-gray-200 transition-all duration-200 text-xs md:text-sm">
                                    <span class="material-symbols-outlined text-sm">photo</span>
                                    Lihat Foto
                                </button>
                            @endif
                            <span class="text-xs text-on-surface-variant flex-1 md:text-sm">
                                {{ $item->deskripsi ?? '-' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-on-surface-variant">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-5xl opacity-40">checklist</span>
                            <p class="text-sm md:text-base">Tidak ada data kondisi</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-primary text-on-primary">
                            <th class="py-2 px-3 text-xs font-bold text-center w-16">No</th>
                            <th class="py-2 px-3 text-xs font-bold">Nama Kondisi</th>
                            <th class="py-2 px-3 text-xs font-bold text-center w-40">Status</th>
                            <th class="py-2 px-3 text-xs font-bold text-center w-48">Foto</th>
                            <th class="py-2 px-3 text-xs font-bold text-center min-w-[250px]">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-variant text-sm text-on-surface">
                        @forelse($laporan->laporanKondisis as $item)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="py-2 px-3 text-center">{{ $loop->iteration }}</td>
                            <td class="py-2 px-3 font-medium">{{ $item->nama_kondisi }}</td>
                            <td class="py-2 px-3 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    @if($item->status == 'Baik') bg-green-100 text-green-800 border border-green-200
                                    @elseif($item->status == 'Perlu Perhatian') bg-yellow-100 text-yellow-800 border border-yellow-200
                                    @else bg-red-100 text-red-800 border border-red-200
                                    @endif">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block
                                        @if($item->status == 'Baik') bg-green-500
                                        @elseif($item->status == 'Perlu Perhatian') bg-yellow-500
                                        @else bg-red-500
                                        @endif">
                                    </span>
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-2 px-3 text-center">
                                @if($item->foto)
                                    <button onclick="openModal('kondisi-{{ $item->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 border border-primary rounded-lg text-primary hover:bg-primary-container hover:text-on-primary transition-all duration-200 text-xs">
                                        <span class="material-symbols-outlined text-sm">photo</span>
                                        Lihat
                                    </button>
                                @elseif($item->foto_dihapus_admin)
                                    <button onclick="openModal('kondisi-{{ $item->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 border border-red-500 rounded-lg text-red-500 hover:bg-red-500 hover:text-white transition-all duration-200 text-xs">
                                        <span class="material-symbols-outlined text-sm">photo</span>
                                        Lihat
                                    </button>
                                @else
                                    <button onclick="openModal('kondisi-{{ $item->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 border border-gray-400 rounded-lg text-gray-500 hover:bg-gray-200 transition-all duration-200 text-xs">
                                        <span class="material-symbols-outlined text-sm">photo</span>
                                        Lihat
                                    </button>
                                @endif
                            </td>
                            <td class="py-2 px-3">{{ $item->deskripsi ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-on-surface-variant">
                                <div class="flex flex-col items-center">
                                    <span class="material-symbols-outlined text-4xl text-outline mb-2">checklist</span>
                                    <p class="text-sm">Tidak ada data kondisi</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tombol Aksi - Mobile Optimized -->
        <div class="flex flex-col-reverse items-stretch gap-3 pt-3 border-t-2 border-outline-variant/30 sm:flex-row sm:items-center sm:justify-end sm:gap-4 md:pt-4">
            <a href="{{ route('laporan.index') }}" 
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-surface-container border-2 border-outline-variant text-on-surface-variant rounded-lg hover:bg-surface-container-hover transition-colors font-medium text-sm md:text-base md:px-6 md:py-3">
                <span class="material-symbols-outlined text-base md:text-xl">arrow_back</span>
                Kembali
            </a>
            @if($laporan->user_id == auth()->id() && $laporan->status == 'Diproses')
                <a href="{{ route('laporan.edit', $laporan) }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-warning text-on-warning rounded-lg hover:bg-warning-hover hover:scale-105 hover:shadow-lg transition-all duration-300 font-medium text-sm md:text-base md:px-6 md:py-3">
                    <span class="material-symbols-outlined text-base md:text-xl">edit</span>
                    Edit Laporan
                </a>
            @endif
        </div>
    </main>

    <!-- Modal Foto Peralatan - Mobile Optimized -->
    @foreach($laporan->laporanPeralatans as $item)
        <div id="peralatan-{{ $item->id }}"
             class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 backdrop-blur-sm p-4"
             onclick="closeModal('peralatan-{{ $item->id }}')">
            <div class="max-w-3xl w-full max-h-[90vh] bg-white rounded-2xl overflow-hidden shadow-2xl"
                 onclick="event.stopPropagation()">
                <div class="flex justify-between items-center p-3 border-b md:p-4">
                    <h3 class="text-sm font-semibold text-gray-800 md:text-base lg:text-lg">
                        {{ $item->nama_peralatan }}
                    </h3>
                    <button onclick="closeModal('peralatan-{{ $item->id }}')" 
                            class="text-gray-500 hover:text-gray-700 transition-colors p-1">
                        <span class="material-symbols-outlined text-xl md:text-2xl">close</span>
                    </button>
                </div>
                <div class="p-3 md:p-4">
                    @if($item->foto)
                        <img src="{{ asset('storage/'.$item->foto) }}"
                             class="w-full max-h-[60vh] object-contain mx-auto md:max-h-[75vh]">
                    @elseif($item->foto_dihapus_admin)
                        <div class="flex flex-col items-center justify-center h-[300px] text-center md:h-[400px]">
                            <span class="material-symbols-outlined text-6xl text-red-400 md:text-7xl">
                                hide_image
                            </span>
                            <h3 class="mt-3 text-base font-semibold text-red-600 md:text-xl">
                                Foto telah dihapus oleh Admin
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 md:text-base">
                                File gambar sudah tidak tersedia.
                            </p>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-[300px] text-center md:h-[400px]">
                            <span class="material-symbols-outlined text-6xl text-gray-400 md:text-7xl">
                                image_not_supported
                            </span>
                            <h3 class="mt-3 text-base font-semibold text-gray-700 md:text-xl">
                                Foto tidak diunggah
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 md:text-base">
                                Anda tidak mengunggah foto untuk item ini.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Foto Kondisi - Mobile Optimized -->
    @foreach($laporan->laporanKondisis as $item)
        <div id="kondisi-{{ $item->id }}"
             class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 backdrop-blur-sm p-4"
             onclick="closeModal('kondisi-{{ $item->id }}')">
            <div class="max-w-3xl w-full max-h-[90vh] bg-white rounded-2xl overflow-hidden shadow-2xl"
                 onclick="event.stopPropagation()">
                <div class="flex justify-between items-center p-3 border-b md:p-4">
                    <h3 class="text-sm font-semibold text-gray-800 md:text-base lg:text-lg">
                        {{ $item->nama_kondisi }}
                    </h3>
                    <button onclick="closeModal('kondisi-{{ $item->id }}')" 
                            class="text-gray-500 hover:text-gray-700 transition-colors p-1">
                        <span class="material-symbols-outlined text-xl md:text-2xl">close</span>
                    </button>
                </div>
                <div class="p-3 md:p-4">
                    @if($item->foto)
                        <img src="{{ asset('storage/'.$item->foto) }}"
                             class="w-full max-h-[60vh] object-contain mx-auto md:max-h-[75vh]">
                    @elseif($item->foto_dihapus_admin)
                        <div class="flex flex-col items-center justify-center h-[300px] text-center md:h-[400px]">
                            <span class="material-symbols-outlined text-6xl text-red-400 md:text-7xl">
                                hide_image
                            </span>
                            <h3 class="mt-3 text-base font-semibold text-red-600 md:text-xl">
                                Foto telah dihapus oleh Admin
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 md:text-base">
                                File gambar sudah tidak tersedia.
                            </p>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-[300px] text-center md:h-[400px]">
                            <span class="material-symbols-outlined text-6xl text-gray-400 md:text-7xl">
                                image_not_supported
                            </span>
                            <h3 class="mt-3 text-base font-semibold text-gray-700 md:text-xl">
                                Foto tidak diunggah
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 md:text-base">
                                Anda tidak mengunggah foto untuk item ini.
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

        .fixed.inset-0.z-50 {
            animation: fadeIn 0.2s ease-out;
        }

        /* Styling untuk select */
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding-right: 2.5rem;
        }

        select:focus {
            outline: none;
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
                document.querySelectorAll('.fixed.inset-0.z-50').forEach(modal => {
                    if (!modal.classList.contains('hidden')) {
                        closeModal(modal.id);
                    }
                });
            }
        });

        // Klik di luar modal juga menutup
        document.querySelectorAll('.fixed.inset-0.z-50').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });
    </script>
@endsection