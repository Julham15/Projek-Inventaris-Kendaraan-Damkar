@extends('admin.layouts')
@section('navbar')
<!-- Main Content Area -->
<main class="flex-1 flex flex-col lg:pl-[280px] w-full h-full overflow-hidden relative">
<!-- TopNavBar -->
<header class="flex justify-between items-center w-full px-lg py-md sticky top-0 z-40 bg-white border-b border-outline-variant">
    <div class="flex items-center gap-md">
        <button class="lg:hidden text-on-surface-variant hover:text-primary transition-colors p-sm rounded-lg hover:bg-surface-container">
            <span class="material-symbols-outlined" data-icon="menu">menu</span>
        </button>
        <span class="font-h2 text-h2 font-bold text-primary">Detail Kendaraan</span>
    </div>
    <div class="flex-1 max-w-md mx-lg hidden md:block">
        <div class="relative">
            <!-- Search bar jika diperlukan -->
        </div>
    </div>
    <div class="flex items-center gap-sm">
        <!-- Tombol tambahan jika diperlukan -->
    </div>
</header>

<!-- Page Content -->
<div class="p-lg md:p-margin flex-1 overflow-x-hidden">
    <!-- Back Button -->
    <div class="mb-lg">
        <a href="{{ route('pencarian.index') }}" 
           class="flex items-center gap-1 text-secondary hover:text-primary transition-colors font-medium text-body-regular w-fit group">
            <span class="material-symbols-outlined text-[20px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
            Kembali
        </a>
    </div>

    <!-- Bento Grid Content -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-lg">
        <!-- Section: Informasi Kendaraan -->
        <section class="md:col-span-12">
            <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-lg">
                <div class="flex items-center gap-md mb-lg border-b border-[#D1E9F6] pb-md">
                    <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">fire_truck</span>
                    <h3 class="font-h3 text-h3 text-on-surface">Informasi Kendaraan</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-xl">
                    <div class="flex flex-col gap-xs">
                        <label class="font-h4 text-h4 text-on-surface-variant">Nomor Polisi</label>
                        <div class="bg-surface-container-low px-lg py-md rounded-lg font-h2 text-h2 text-[#38B6FF] font-bold border border-[#D1E9F6]">
                            {{ $kendaraan->nomor_polisi }}
                        </div>
                    </div>
                    <div class="flex flex-col gap-xs">
                        <label class="font-h4 text-h4 text-on-surface-variant">Jenis Mobil</label>
                        <div class="bg-surface-container-low px-lg py-md rounded-lg font-h2 text-h2 text-on-surface font-semibold border border-[#D1E9F6]">
                            {{ $kendaraan->jenisMobil->nama_jenis }}
                        </div>
                    </div>
                    <div class="flex flex-col gap-xs">
                        <label class="font-h4 text-h4 text-on-surface-variant">Pos</label>
                        <div class="bg-surface-container-low px-lg py-md rounded-lg font-h2 text-h2 text-on-surface font-semibold border border-[#D1E9F6]">
                            {{ $kendaraan->jenisMobil->posko->nama_posko }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Data Peralatan -->
        <section class="md:col-span-6">
            <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] flex flex-col h-full overflow-hidden">
                <div class="p-lg flex justify-between items-center border-b border-[#D1E9F6]">
                    <div class="flex items-center gap-md">
                        <span class="material-symbols-outlined text-[#38B6FF]">construction</span>
                        <h3 class="font-h3 text-h3">Data Peralatan</h3>
                    </div>
                    <span class="text-sm text-on-surface-variant bg-surface-container-low px-3 py-1 rounded-full">
                        {{ $kendaraan->peralatans->count() }} item
                    </span>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="px-lg py-md font-h4 text-h4 w-16 text-center">No</th>
                                <th class="px-lg py-md font-h4 text-h4">Nama Peralatan</th>
                                <th class="px-lg py-md font-h4 text-h4 text-center w-32">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody class="font-body-regular text-body-regular text-on-surface">
                            @forelse($kendaraan->peralatans as $item)
                            <tr class="border-b border-[#D1E9F6] hover:bg-[#E6F6FF]/30 transition-colors">
                                <td class="px-lg py-md text-center">{{ $loop->iteration }}</td>
                                <td class="px-lg py-md font-semibold">{{ $item->nama_alat }}</td>
                                <td class="px-lg py-md text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($item->kondisi == 'Baik') bg-green-100 text-green-800 border border-green-200
                                        @elseif($item->kondisi == 'Rusak') bg-red-100 text-red-800 border border-red-200
                                        @else bg-yellow-100 text-yellow-800 border border-yellow-200
                                        @endif">
                                        {{ $item->kondisi }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-lg py-md text-center text-on-surface-variant">
                                    <div class="flex flex-col items-center py-8">
                                        <span class="material-symbols-outlined text-4xl text-outline mb-2">inventory_2</span>
                                        <p>Tidak ada peralatan</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-lg border-t border-[#D1E9F6]">
                    <a href="{{ route('posko.jenis-mobil.kendaraan.peralatan.create', [
                        $kendaraan->jenisMobil->posko->id,
                        $kendaraan->jenisMobil->id,
                        $kendaraan->id
                    ]) }}" 
                       class="w-full py-md bg-[#38B6FF] text-white font-h4 text-h4 rounded-lg flex items-center justify-center gap-md hover:bg-[#0A8FD6] transition-all active:scale-95 shadow-sm">
                        <span class="material-symbols-outlined">add_circle</span>
                        Tambah Peralatan
                    </a>
                </div>
            </div>
        </section>

        <!-- Section: Kondisi Kendaraan -->
        <section class="md:col-span-6">
            <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] flex flex-col h-full overflow-hidden">
                <div class="p-lg flex justify-between items-center border-b border-[#D1E9F6]">
                    <div class="flex items-center gap-md">
                        <span class="material-symbols-outlined text-[#38B6FF]">health_metrics</span>
                        <h3 class="font-h3 text-h3">Kondisi Kendaraan</h3>
                    </div>
                    <span class="text-sm text-on-surface-variant bg-surface-container-low px-3 py-1 rounded-full">
                        {{ $kendaraan->kondisis->count() }} item
                    </span>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="px-lg py-md font-h4 text-h4 w-16 text-center">No</th>
                                <th class="px-lg py-md font-h4 text-h4">Nama Alat/Bahan</th>
                                <th class="px-lg py-md font-h4 text-h4 text-center w-32">Status</th>
                            </tr>
                        </thead>
                        <tbody class="font-body-regular text-body-regular text-on-surface">
                            @forelse($kendaraan->kondisis as $i)
                            <tr class="border-b border-[#D1E9F6] hover:bg-[#E6F6FF]/30 transition-colors">
                                <td class="px-lg py-md text-center">{{ $loop->iteration }}</td>
                                <td class="px-lg py-md font-semibold">{{ $i->nama_kondisi }}</td>
                                <td class="px-lg py-md text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($i->status == 'Baik') bg-green-100 text-green-800 border border-green-200
                                        @elseif($i->status == 'Rusak') bg-red-100 text-red-800 border border-red-200
                                        @elseif($i->status == 'Perbaikan') bg-yellow-100 text-yellow-800 border border-yellow-200
                                        @else bg-blue-100 text-blue-800 border border-blue-200
                                        @endif">
                                        {{ $i->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-lg py-md text-center text-on-surface-variant">
                                    <div class="flex flex-col items-center py-8">
                                        <span class="material-symbols-outlined text-4xl text-outline mb-2">checklist</span>
                                        <p>Tidak ada kondisi</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-lg border-t border-[#D1E9F6]">
                    <a href="{{ route('posko.jenis-mobil.kendaraan.kondisi.create', [
                        $kendaraan->jenisMobil->posko->id,
                        $kendaraan->jenisMobil->id,
                        $kendaraan->id
                    ]) }}" 
                       class="w-full py-md bg-[#38B6FF] text-white font-h4 text-h4 rounded-lg flex items-center justify-center gap-md hover:bg-[#0A8FD6] transition-all active:scale-95 shadow-sm">
                        <span class="material-symbols-outlined">analytics</span>
                        Tambah Kondisi
                    </a>
                </div>
            </div>
        </section>
    </div>
</div>
</main>
@endsection