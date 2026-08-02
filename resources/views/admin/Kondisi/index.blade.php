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
        <span class="font-h2 text-h2 font-bold text-primary">Kelola Kondisi</span>
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
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-lg gap-md">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('posko.jenis-mobil.kendaraan.index',[$posko->id,$jenis_mobil->id, $kendaraan->id]) }}" 
                   class="flex items-center gap-1 text-secondary hover:text-primary transition-colors font-medium text-body-regular">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    Kembali
                </a>
            </div>
            
            <p class="font-body-regular text-body-regular text-on-surface-variant mt-1">Manajemen daftar kondisi pada kendaraan <span style="font-weight: bold;">{{ $kendaraan->nomor_polisi }}</span> operasional <span style="font-weight: bold;">{{ $kendaraan->jenisMobil->nama_jenis }}</span>.</p>
        </div>
        <a href="{{ route('posko.jenis-mobil.kendaraan.kondisi.create', [$posko->id,$jenis_mobil->id, $kendaraan->id]) }}" 
           class="button bg-[#38B6FF] hover:bg-[#0A8FD6] text-white font-h4 text-h4 px-lg py-sm rounded-lg transition-colors flex items-center gap-xs shadow-sm">
            <span class="material-symbols-outlined" data-icon="add">add</span>
            Tambah Kondisi
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="py-sm px-md font-h4 text-h4 w-16 text-center">No</th>
                        <th class="py-sm px-md font-h4 text-h4">Nama Kondisi</th>
                        <th class="py-sm px-md font-h4 text-h4">Status</th>
                        <th class="py-sm px-md font-h4 text-h4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-body-regular text-body-regular text-on-surface">
                    @forelse($kondisis as $item)
                    <tr class="bg-white hover:bg-[#E6F6FF]/30 transition-colors border-b border-outline-variant/30">
                        <td class="py-sm px-md text-center">{{ $loop->iteration }}</td>
                        <td class="py-sm px-md font-medium">{{ $item->nama_kondisi }}</td>
                        <td class="py-sm px-md">
                            <span class="inline-flex items-center text-center gap-xs px-xs py-base rounded-full bg-secondary-fixed text-on-secondary-fixed-variant font-small text-small font-medium">
                                <span class="w-2 h-2 rounded-full bg-primary-container"></span>
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="py-sm px-md">
                            <div class="flex items-center justify-center gap-xs">
                                <a href="{{ route('posko.jenis-mobil.kendaraan.kondisi.edit', [$posko->id,$jenis_mobil->id, $kendaraan->id, $item->id]) }}" 
                                   class="text-secondary hover:bg-secondary/10 p-1.5 rounded transition-colors group relative" 
                                   title="Edit Data">
                                    <span class="material-symbols-outlined text-[20px]" data-icon="edit">edit</span>
                                    <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface px-2 py-1 rounded font-small text-small hidden group-hover:block whitespace-nowrap">
                                        Edit
                                    </span>
                                </a>
                                
                                <form action="{{ route('posko.jenis-mobil.kendaraan.kondisi.destroy', [$posko->id,$jenis_mobil->id, $kendaraan->id, $item->id]) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-error hover:bg-error/10 p-1.5 rounded transition-colors group relative" 
                                            title="Hapus Kondisi"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kondisi ini?')">
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
                        <td colspan="4" class="py-sm px-md text-center text-on-surface-variant">
                            Belum ada data kondisi kendaraan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination / Footer Area -->
        @if($kondisis instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="py-sm px-md border-t border-[#D1E9F6] bg-surface-container-lowest flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="font-small text-small text-on-surface-variant">
                Menampilkan {{ $kondisis->firstItem() ?? 0 }} hingga {{ $kondisis->lastItem() ?? 0 }} dari {{ $kondisis->total() }} data
            </p>
            <div class="flex items-center gap-1">
                <!-- Tombol Previous -->
                @if($kondisis->onFirstPage())
                <button class="p-1 rounded text-on-surface-variant/50 cursor-not-allowed" disabled>
                    <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                </button>
                @else
                <a href="{{ $kondisis->previousPageUrl() }}" 
                   class="p-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                </a>
                @endif

                <!-- Nomor Halaman -->
                @foreach($kondisis->getUrlRange(1, $kondisis->lastPage()) as $page => $url)
                    @if($page == $kondisis->currentPage())
                        <button class="w-8 h-8 rounded bg-[#38B6FF] text-white font-body-regular text-body-regular flex items-center justify-center">
                            {{ $page }}
                        </button>
                    @else
                        <a href="{{ $url }}" 
                           class="w-8 h-8 rounded hover:bg-surface-container text-on-surface-variant font-body-regular text-body-regular flex items-center justify-center transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                <!-- Tombol Next -->
                @if($kondisis->hasMorePages())
                <a href="{{ $kondisis->nextPageUrl() }}" 
                   class="p-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                </a>
                @else
                <button class="p-1 rounded text-on-surface-variant/50 cursor-not-allowed" disabled>
                    <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                </button>
                @endif
            </div>
        </div>
        @else
        <!-- Untuk Collection tanpa pagination -->
        <div class="py-sm px-md border-t border-[#D1E9F6] bg-surface-container-lowest flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="font-small text-small text-on-surface-variant">
                Menampilkan 1 hingga {{ $kondisis->count() }} dari {{ $kondisis->count() }} data
            </p>
            <div class="flex items-center gap-1">
                <button class="p-1 rounded text-on-surface-variant/50 cursor-not-allowed" disabled>
                    <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                </button>
                <button class="w-8 h-8 rounded bg-[#38B6FF] text-white font-body-regular text-body-regular flex items-center justify-center">
                    1
                </button>
                <button class="p-1 rounded text-on-surface-variant/50 cursor-not-allowed" disabled>
                    <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                </button>
            </div>
        </div>
        @endif
    </div>
</div>
</main>
@endsection