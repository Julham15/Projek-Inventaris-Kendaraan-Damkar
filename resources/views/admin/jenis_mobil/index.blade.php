@extends('admin.layouts')
@section('navbar')
<!-- Main Content Wrapper -->

<div class="flex-1 flex flex-col lg:pl-[280px] w-full h-full overflow-y-auto relative">
<!-- TopNavBar -->
<header class="bg-white dark:bg-surface-container-lowest border-b border-outline-variant dark:border-outline flex justify-between items-center w-full px-lg py-md sticky top-0 z-40">
<div class="flex items-center gap-md">
<button class="lg:hidden text-primary dark:text-inverse-primary hover:text-primary dark:hover:text-inverse-primary transition-colors">
<span class="material-symbols-outlined">menu</span>
</button>
<div class="relative hidden sm:block">
<span class="font-h2 text-h2 font-bold text-primary">Data Jenis Mobil</span>

</div>
</div>
<div class="flex items-center gap-md">

<button class="text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-inverse-primary transition-colors active:opacity-80 p-2 rounded-full hover:bg-surface-container-low">

</button>
</div>
</header>
<!-- Page Content -->
<main class="flex-1 p-lg overflow-x-hidden">
<!-- Page Header -->
<div class="mb-margin">
 
  <div class="mt-md border-b border-outline-variant"></div>
</div><div class="mb-margin flex flex-col sm:flex-row justify-between items-start sm:items-center gap-md"><p class="font-body-regular text-body-regular text-on-surface-variant">Kelola daftar klasifikasi kendaraan pemadam kebakaran operasional di <span class="font-bold">{{ $posko->nama_posko }}</span>.</p>
<a href="{{ route('posko.jenis-mobil.create',$posko) }}" class="bg-primary-container text-on-primary font-h4 text-h4 px-md py-sm rounded-lg flex items-center gap-xs hover:bg-[#0A8FD6] transition-colors shadow-sm active:scale-95">
        <span class="material-symbols-outlined text-on-primary">add</span>
        Tambah Jenis Mobil</a>
</div>
<!-- Data Table Card -->
<div class="bg-white rounded-lg border border-[#D1E9F6] shadow-sm overflow-hidden">
<div class="p-md border-b border-[#D1E9F6] bg-surface-bright flex justify-between items-center">
<h3 class="font-h3 text-h3 text-on-surface">Daftar Klasifikasi Kendaraan</h3>
<div class="flex gap-sm">
<button class="text-on-surface-variant hover:text-primary transition-colors p-1 rounded hover:bg-surface-container-low">

</button>
</div>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-primary-container text-on-primary border-b border-outline-variant">
<th class="py-sm px-md font-h4 text-h4 font-medium w-16 text-center">No</th>
<th class="py-sm px-md font-h4 text-h4 font-medium w-32">Gambar</th>
<th class="py-sm px-md font-h4 text-h4 font-medium">Nama Jenis Mobil</th>
<th class="py-sm px-md font-h4 text-h4 font-medium text-center">Jumlah Kendaraan</th>
<th class="py-sm px-md font-h4 text-h4 font-medium text-center w-64">Aksi</th>
</tr>
</thead>
<tbody class="divide-y divide-[#D1E9F6]">
<!-- Row 1 -->
 @foreach ($data as $item)
<tr class="hover:bg-surface-container-low transition-colors bg-white">
<td class="py-sm px-md font-body-regular text-body-regular text-center text-on-surface-variant">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
<td class="py-sm px-md">@if ($item->gambar)
<div class="w-20 h-14 bg-surface-variant rounded flex items-center justify-center overflow-hidden border border-outline-variant">
<img class="w-full h-full object-cover" data-alt="A modern red fire engine truck parked in a well-lit fire station garage. The vehicle features gleaming chrome details, bright white reflective striping, and large rugged tires. The lighting is bright and clean, emphasizing the professional and ready-for-action aesthetic of the emergency services environment. High definition photography, clear and crisp." src="{{ asset('storage/' . $item->gambar) }}">
</div>@endif
</td>
<td class="py-sm px-md font-h4 text-h4 text-on-surface">{{ $item->nama_jenis }}</td>
<td class="py-sm px-md font-body-regular text-body-regular text-center">
<span class="inline-flex items-center justify-center bg-secondary-fixed text-on-secondary-fixed px-3 py-1 rounded-full font-medium">{{ $item->jumlah_mobil}}</span>
</td>
<td class="py-sm px-md text-center">
<div class="flex items-center justify-center gap-xs">
<a href="{{ route('posko.jenis-mobil.edit', [$posko->id, $item->id]) }}" class="text-on-surface-variant hover:text-primary transition-colors p-2 rounded-lg hover:bg-surface-container" title="Edit">
<span class="material-symbols-outlined" style="font-size: 20px;">edit</span>
</a>
<form action="{{ route('posko.jenis-mobil.destroy',[$posko->id, $item->id]) }}"
                  method="POST"
                  onsubmit="return confirmDelete(event, '{{ $item->nama_jenis }}')">
          @csrf
        @method('DELETE')
<button type="submit" class="text-on-surface-variant hover:text-error transition-colors p-2 rounded-lg hover:bg-error-container" title="Hapus">
<span class="material-symbols-outlined" style="font-size: 20px;">delete</span>
</button>
</form>

<a href="{{ route('posko.jenis-mobil.kendaraan.index',[$posko->id,$item->id]) }}" class="text-tertiary hover:text-on-tertiary-container transition-colors p-2 rounded-lg hover:bg-tertiary-container/20 active:scale-95" title="Kelola Kendaraan"><span class="material-symbols-outlined" style="font-size: 20px;">minor_crash</span></a>
</div>
</td>
</tr>
 @endforeach
</tbody>
</table>
</div>
<!-- Pagination -->
<div class="p-md border-t border-[#D1E9F6] flex items-center justify-between bg-white flex-wrap gap-md">
<span class="font-small text-small text-on-surface-variant">
    Menampilkan {{ $data->firstItem() ?? 0 }}-{{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} data
</span>
<div class="flex items-center gap-base">
    <!-- Previous Page Link -->
    @if ($data->onFirstPage())
        <button class="p-1 rounded text-outline hover:bg-surface-container disabled:opacity-50" disabled>
            <span class="material-symbols-outlined">chevron_left</span>
        </button>
    @else
        <a href="{{ $data->previousPageUrl() }}" class="p-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined">chevron_left</span>
        </a>
    @endif

    <!-- Pagination Elements -->
    @php
        $currentPage = $data->currentPage();
        $lastPage = $data->lastPage();
        $start = max(1, $currentPage - 2);
        $end = min($lastPage, $currentPage + 2);
        
        if ($start > 1) {
            $start = max(1, $lastPage - 4);
            $end = $lastPage;
        }
    @endphp

    @if ($start > 1)
        <a href="{{ $data->url(1) }}" class="w-8 h-8 rounded text-on-surface-variant hover:bg-surface-container font-body-regular text-body-regular flex items-center justify-center transition-colors">1</a>
        @if ($start > 2)
            <span class="text-on-surface-variant">...</span>
        @endif
    @endif

    @for ($i = $start; $i <= $end; $i++)
        @if ($i == $currentPage)
            <span class="w-8 h-8 rounded bg-primary text-on-primary font-body-regular text-body-regular flex items-center justify-center">{{ $i }}</span>
        @else
            <a href="{{ $data->url($i) }}" class="w-8 h-8 rounded text-on-surface-variant hover:bg-surface-container font-body-regular text-body-regular flex items-center justify-center transition-colors">{{ $i }}</a>
        @endif
    @endfor

    @if ($end < $lastPage)
        @if ($end < $lastPage - 1)
            <span class="text-on-surface-variant">...</span>
        @endif
        <a href="{{ $data->url($lastPage) }}" class="w-8 h-8 rounded text-on-surface-variant hover:bg-surface-container font-body-regular text-body-regular flex items-center justify-center transition-colors">{{ $lastPage }}</a>
    @endif

    <!-- Next Page Link -->
    @if ($data->hasMorePages())
        <a href="{{ $data->nextPageUrl() }}" class="p-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors">
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
</main>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fungsi konfirmasi hapus dengan peringatan
    

    // Tambahkan CSS kustom untuk SweetAlert
    const style = document.createElement('style');
    style.textContent = `
        .swal2-title-custom {
            font-size: 24px !important;
            font-weight: bold !important;
        }
        .swal2-html-custom {
            font-size: 14px !important;
        }
        .swal2-confirm-custom {
            padding: 12px 24px !important;
            font-weight: bold !important;
        }
        .swal2-cancel-custom {
            padding: 12px 24px !important;
            font-weight: bold !important;
        }
        .swal2-popup {
            border-radius: 12px !important;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2) !important;
        }
        .swal2-popup .swal2-icon {
            margin: 20px auto 10px !important;
        }
    `;
    document.head.appendChild(style);

    // Auto-hide success message jika ada session
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            showClass: {
                popup: 'animate__animated animate__fadeInRight'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutRight'
            }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'OK'
        });
    @endif
</script>

<style>
    /* Animasi hover untuk tombol pagination */
    .pagination-btn {
        transition: all 0.2s ease;
    }
    .pagination-btn:hover {
        transform: scale(1.05);
    }
    .pagination-btn:active {
        transform: scale(0.95);
    }
    
    /* Styling untuk tabel */
    tbody tr {
        transition: background-color 0.2s ease;
    }
    tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Styling untuk tombol aksi */
    .action-btn {
        transition: all 0.2s ease;
        border-radius: 8px;
    }
    .action-btn:hover {
        transform: scale(1.1);
    }
    .action-btn:active {
        transform: scale(0.95);
    }
</style>

@endsection