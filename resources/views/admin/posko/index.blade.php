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
<span class="font-h2 text-h2 font-bold text-primary">Data Pos</span>
</div>
<div class="flex-1 max-w-md mx-lg hidden md:block">
<div class="relative">


</div>
</div>
<div class="flex items-center gap-sm">

<button class="text-on-surface-variant hover:text-primary transition-colors p-sm rounded-full hover:bg-surface-container active:opacity-80">

</button>
</div>
</header>
@if(session('success'))
<div class="mb-5 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 shadow-sm">
    <span class="material-symbols-outlined text-green-600 text-3xl">
        check_circle
    </span>

    <div>
        <h3 class="font-semibold text-green-700">
            Berhasil
        </h3>

        <p class="text-green-600">
            {{ session('success') }}
        </p>
    </div>
</div>
@endif

@if(session('error'))
<div class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 shadow-sm animate-pulse">
    <span class="material-symbols-outlined text-red-600 text-3xl">
        error
    </span>

    <div>
        <h3 class="font-semibold text-red-700">
            Pos Tidak Dapat Dihapus 
        </h3>

        <p class="text-red-600 mt-1">
            {{ session('error') }}
        </p>

        <p class="text-sm text-red-500 mt-2">
            Hapus seluruh <strong>Jenis Mobil</strong> yang masih berada pada posko ini terlebih dahulu.
        </p>
    </div>
</div>
@endif
<!-- Page Content -->
<div class="p-lg md:p-margin flex-1 overflow-x-hidden">
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-lg gap-md">
<div>
{{-- <h2 class="font-h1 text-h1 text-on-background">Data Posko</h2> --}}
<p class="font-body-regular text-body-regular text-on-surface-variant mt-1">Kelola data posko pemadam kebakaran di wilayah operasional.</p>
</div>
<a href="{{ route('posko.create') }}" class="button bg-[#38B6FF] hover:bg-[#0A8FD6] text-white font-h4 text-h4 px-lg py-sm rounded-lg transition-colors flex items-center gap-xs shadow-sm">
<span class="material-symbols-outlined" data-icon="add">add</span>
                    Tambah Pos
                </a>
</div>
<!-- Bento Grid Context Image -->

<!-- Data Table Card -->
<div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-primary text-white">
<th class="py-sm px-md font-h4 text-h4 w-16">No</th>
<th class="py-sm px-md font-h4 text-h4">Nama Pos</th>
<th class="py-sm px-md font-h4 text-h4">Alamat</th>
<th class="py-sm px-md font-h4 text-h4 w-64 text-center">Aksi</th>
</tr>
</thead>
<tbody class="font-body-regular text-body-regular text-on-surface">
 @forelse($poskos as $posko)
<tr class="bg-white hover:bg-[#E6F6FF]/30 transition-colors border-b border-outline-variant/30">
<td class="py-sm px-md">{{ $loop->iteration }}</td>
<td class="py-sm px-md font-medium">{{ $posko->nama_posko }}</td>
<td class="py-sm px-md">{{ $posko->alamat }}</td>
<td class="py-sm px-md flex justify-center gap-xs">
<a href="{{ route('posko.jenis-mobil.index', $posko) }}" class="button text-[#38B6FF] hover:bg-[#E6F6FF] p-1.5 rounded transition-colors" title="Jenis Mobil">
<span class="material-symbols-outlined text-[20px]" data-icon="fire_truck">fire_truck</span>
</a>
<a href="{{ route('posko.edit', $posko) }}" class="text-secondary hover:bg-secondary/10 p-1.5 rounded transition-colors" title="Edit">
<span class="material-symbols-outlined text-[20px]" data-icon="edit">edit</span>
</a>
<button type="button"
        onclick="openDeleteModal('{{ $posko->id }}')"
        class="text-error hover:bg-error/10 p-1.5 rounded transition-colors group relative"
        title="Hapus">
    <span class="material-symbols-outlined text-[20px]">delete</span>
    <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface px-2 py-1 rounded font-small text-small hidden group-hover:block whitespace-nowrap">
        Hapus
    </span>
</button>

<!-- Modal Konfirmasi Hapus -->
<dialog id="deleteModal{{ $posko->id }}" class="rounded-xl shadow-xl backdrop:bg-black/50 p-0 max-w-sm w-full">
    <div class="bg-surface p-6 rounded-xl">
        <!-- Icon dan Pesan -->
        <div class="flex flex-col items-center text-center mb-6">
            <div class="bg-error/10 p-4 rounded-full mb-4">
                <span class="material-symbols-outlined text-error text-5xl">warning</span>
            </div>
            <h3 class="font-h3 text-h3 text-on-surface mb-2">Hapus Pos?</h3>
            <p class="text-on-surface-variant font-body text-body">
    Apakah Anda yakin ingin menghapus
    <strong class="text-on-surface">
        {{ $posko->nama_posko }}
    </strong>?
</p>

<div class="mt-4 rounded-lg bg-yellow-50 border border-yellow-200 p-3">
    <div class="flex gap-2">
        <span class="material-symbols-outlined text-yellow-600">
            info
        </span>

        <p class="text-sm text-yellow-700">
            Pos hanya dapat dihapus apabila sudah tidak memiliki
            <strong>Jenis Mobil</strong>.
        </p>
    </div>
</div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end gap-2">
            <button type="button"
                    onclick="document.getElementById('deleteModal{{ $posko->id }}').close()"
                    class="px-4 py-2 rounded-lg border border-outline text-on-surface-variant hover:bg-surface-container transition-colors">
                Batal
            </button>
            
            <form action="{{ route('posko.destroy', $posko) }}"
                  method="POST"
                  style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-error text-on-error hover:bg-error-fixed hover:text-on-error-fixed transition-colors">
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                        Hapus
                    </span>
                </button>
            </form>
        </div>
    </div>
</dialog>

</td>
</tr>
 @empty
        <tr>
            <td colspan="4" class="border p-2 text-center">
                Belum ada data posko.
            </td>
        </tr>
@endforelse
</tbody>
</table>
</div>
<!-- Pagination -->

<div class="flex items-center gap-1 mt-4">
    <!-- Tombol Previous -->
    @if($poskos->onFirstPage())
        <button class="p-1 rounded text-on-surface-variant/50 cursor-not-allowed" disabled>
            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
        </button>
    @else
        <a href="{{ $poskos->previousPageUrl() }}" 
           class="p-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
        </a>
    @endif

    <!-- Nomor Halaman -->
    @foreach($poskos->getUrlRange(1, $poskos->lastPage()) as $page => $url)
        @if($page == $poskos->currentPage())
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
    @if($poskos->hasMorePages())
        <a href="{{ $poskos->nextPageUrl() }}" 
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
</div>
</div>
</div>
</main>
<script>
function openDeleteModal(poskoId) {
    const modal = document.getElementById('deleteModal' + poskoId);
    if (modal) {
        modal.showModal();
    }
}
</script>
@endsection
