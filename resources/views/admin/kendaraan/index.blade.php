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
        <span class="font-h2 text-h2 font-bold text-primary">Kelola Kendaraan</span>
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

    <!-- Tampilkan hanya satu pesan (prioritas error) -->
@if(session('error'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 border border-red-300 text-red-700">
        {{ session('error') }}
    </div>
@elseif(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-300 text-green-700">
        {{ session('success') }}
    </div>
@endif
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-lg gap-md">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('posko.jenis-mobil.index',[$posko->id,$jenis_mobil->id]) }}" 
                   class="flex items-center gap-1 text-secondary hover:text-primary transition-colors font-medium text-body-regular">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    Kembali
                </a>
            </div>
            <p class="font-body-regular text-body-regular text-on-surface-variant mt-1">Daftar kendaraan <span class="font-bold">{{ $jenis_mobil->nama_jenis }}</span> di <span class="font-bold">{{ $posko->nama_posko }}</span>.</p>
        </div>
        <a href="{{ route('posko.jenis-mobil.kendaraan.create',[$posko->id,$jenis_mobil->id]) }}" 
           class="button bg-[#38B6FF] hover:bg-[#0A8FD6] text-white font-h4 text-h4 px-lg py-sm rounded-lg transition-colors flex items-center gap-xs shadow-sm">
            <span class="material-symbols-outlined" data-icon="add">add</span>
            Tambah Kendaraan
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="py-sm px-md font-h4 text-h4 w-16 text-center">No</th>
                        <th class="py-sm px-md font-h4 text-h4 w-24">Gambar</th>
                        <th class="py-sm px-md font-h4 text-h4 w-40">Plat Nomor</th>
                        <th class="py-sm px-md font-h4 text-h4">Deskripsi</th>
                        <th class="py-sm px-md font-h4 text-h4 w-80 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-body-regular text-body-regular text-on-surface">
                    @forelse ($kendaraan as $item)
                    <tr class="bg-white hover:bg-[#E6F6FF]/30 transition-colors border-b border-outline-variant/30">
                        <td class="py-sm px-md text-center">{{ $loop->iteration }}</td>
                        <td class="py-sm px-md">
                            @if ($item->gambar)
                            <div class="w-16 h-12 bg-surface-variant rounded flex items-center justify-center overflow-hidden border border-outline-variant">
                                <img class="w-full h-full object-cover" 
                                     src="{{ asset('storage/' . $item->gambar) }}" 
                                     alt="Gambar kendaraan">
                            </div>
                            @endif
                        </td>
                        <td class="py-sm px-md font-medium">{{ $item->nomor_polisi }}</td>
                        <td class="py-sm px-md">{{ $item->deskripsi }}</td>
                        <td class="py-sm px-md">
                            <div class="flex items-center justify-center gap-xs">
                                <a href="{{ route('posko.jenis-mobil.kendaraan.peralatan.index',[$posko->id,$jenis_mobil->id, $item->id]) }}" 
                                   class="text-[#38B6FF] hover:bg-[#E6F6FF] p-1.5 rounded transition-colors group relative" 
                                   title="Kelola Peralatan">
                                    <span class="material-symbols-outlined text-[20px]" data-icon="build">build</span>
                                    <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface px-2 py-1 rounded font-small text-small hidden group-hover:block whitespace-nowrap">
                                        Peralatan
                                    </span>
                                </a>
                                
                                <a href="{{ route('posko.jenis-mobil.kendaraan.kondisi.index',[$posko->id, $jenis_mobil->id, $item->id]) }}" 
                                   class="text-secondary hover:bg-secondary/10 p-1.5 rounded transition-colors group relative" 
                                   title="Cek Kondisi">
                                    <span class="material-symbols-outlined text-[20px]" data-icon="fact_check">fact_check</span>
                                    <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface px-2 py-1 rounded font-small text-small hidden group-hover:block whitespace-nowrap">
                                        Kondisi
                                    </span>
                                </a>
                                
                                <a href="{{ route('posko.jenis-mobil.kendaraan.edit',[$posko->id, $jenis_mobil->id, $item->id]) }}" 
                                   class="text-secondary hover:bg-secondary/10 p-1.5 rounded transition-colors group relative" 
                                   title="Edit Data">
                                    <span class="material-symbols-outlined text-[20px]" data-icon="edit">edit</span>
                                    <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface px-2 py-1 rounded font-small text-small hidden group-hover:block whitespace-nowrap">
                                        Edit
                                    </span>
                                </a>
                                <a href="{{ route('posko.jenis-mobil.kendaraan.mutasi',[$posko->id,$jenis_mobil->id,$item->id]) }}"
                                 class="text-primary hover:bg-primary/10 p-1.5 rounded transition-colors group relative" title="Mutasi Kendaraan">
                                    <span class="material-symbols-outlined text-[20px]">
                                        local_shipping
                                    </span>
                                    <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface px-2 py-1 rounded font-small text-small hidden group-hover:block whitespace-nowrap">
                                        Mutasi
                                    </span>
                                </a>
                                
                                <form action="{{ route('posko.jenis-mobil.kendaraan.destroy',[$posko->id, $jenis_mobil->id, $item->id]) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-error hover:bg-error/10 p-1.5 rounded transition-colors group relative" 
                                            title="Hapus Kendaraan"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?')">
                                        <span class="material-symbols-outlined text-[20px]" data-icon="delete">delete</span>
                                        <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface px-2 py-1 rounded font-small text-small hidden group-hover:block whitespace-nowrap">
                                            Hapus
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-sm px-md text-center text-on-surface-variant">
                            Belum ada data kendaraan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination / Footer Area (PERTAHANKAN DARI KODINGAN PERTAMA) -->
        <div class="py-sm px-md border-t border-[#D1E9F6] bg-surface-container-lowest flex justify-between items-center text-body-regular">
            <span class="text-on-surface-variant">Menampilkan {{ $kendaraan->firstItem() ?? 0 }}-{{ $kendaraan->lastItem() ?? 0 }} dari {{ $kendaraan->total() }} Kendaraan</span>
            <div class="flex gap-2">
                <!-- Tombol Previous -->
                @if($kendaraan->onFirstPage())
                <button class="p-1 rounded text-outline hover:bg-surface-container disabled:opacity-50" disabled>
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                @else
                <a href="{{ $kendaraan->previousPageUrl() }}" class="p-1 rounded text-primary hover:bg-primary-container/20 transition-colors">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
                @endif
                
                <!-- Tombol Next -->
                @if($kendaraan->hasMorePages())
                <a href="{{ $kendaraan->nextPageUrl() }}" class="p-1 rounded text-primary hover:bg-primary-container/20 transition-colors">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
                @else
                <button class="p-1 rounded text-outline hover:bg-surface-container disabled:opacity-50" disabled>
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
</main>
@endsection