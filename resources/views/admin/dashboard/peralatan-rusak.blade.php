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
        <span class="font-h2 text-h2 font-bold text-primary">Peralatan Rusak</span>
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
    <!-- Page Header with Back Button -->
    <div class="flex items-center gap-md mb-lg">
        <a href="{{ url()->previous() }}" 
           class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-[#E6F6FF] transition-colors active:scale-90 group">
            <span class="material-symbols-outlined text-on-surface group-hover:text-[#38B6FF]">arrow_back</span>
        </a>
        <div>
            <h1 class="font-h1 text-h1 text-on-background">Peralatan Rusak</h1>
            <p class="font-body-regular text-body-regular text-on-surface-variant mt-1">
                Daftar peralatan yang sedang dalam kondisi rusak
            </p>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] overflow-hidden">
        <div class="p-md border-b border-[#D1E9F6] flex items-center justify-between bg-surface-container-low">
            <h3 class="font-h3 text-h3 text-on-surface">Daftar Peralatan Rusak</h3>
            <span class="text-sm text-on-surface-variant bg-surface-container-low px-3 py-1 rounded-full">
                Total: {{ $data->count() }} item
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="py-sm px-md font-h4 text-h4 w-16 text-center">No</th>
                        <th class="py-sm px-md font-h4 text-h4">Kendaraan</th>
                        <th class="py-sm px-md font-h4 text-h4">Peralatan</th>
                        <th class="py-sm px-md font-h4 text-h4">Pos</th>
                        <th class="py-sm px-md font-h4 text-h4 text-center w-32">Status</th>
                    </tr>
                </thead>
                <tbody class="font-body-regular text-body-regular text-on-surface">
                    @forelse($data as $item)
                    <tr class="bg-white hover:bg-[#E6F6FF]/30 transition-colors border-b border-outline-variant/30">
                        <td class="py-sm px-md text-center">{{ $loop->iteration }}</td>
                        <td class="py-sm px-md font-medium">{{ $item->kendaraan->nomor_polisi ?? '-' }}</td>
                        <td class="py-sm px-md">{{ $item->peralatan->nama_alat ?? '-' }}</td>
                        <td class="py-sm px-md font-medium">{{ $item->kendaraan->jenisMobil->posko->nama_posko ?? '-' }}</td>
                        <td class="py-sm px-md text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                {{ $item->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-sm px-md text-center text-on-surface-variant">
                            <div class="flex flex-col items-center justify-center py-12">
                                <span class="material-symbols-outlined text-6xl text-outline mb-3">check_circle</span>
                                <p class="font-h4 text-h4 text-on-surface-variant">Tidak ada peralatan rusak</p>
                                <p class="text-sm text-on-surface-variant mt-1">Semua peralatan dalam kondisi baik</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination / Footer -->
        @if($data instanceof \Illuminate\Pagination\LengthAwarePaginator && $data->total() > 0)
        <div class="py-sm px-md border-t border-[#D1E9F6] bg-surface-container-lowest flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="font-small text-small text-on-surface-variant">
                Menampilkan {{ $data->firstItem() ?? 0 }} hingga {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} data
            </p>
            <div class="flex items-center gap-1">
                <!-- Tombol Previous -->
                @if($data->onFirstPage())
                <button class="p-1 rounded text-on-surface-variant/50 cursor-not-allowed" disabled>
                    <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                </button>
                @else
                <a href="{{ $data->previousPageUrl() }}" 
                   class="p-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                </a>
                @endif

                <!-- Nomor Halaman -->
                @foreach($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                    @if($page == $data->currentPage())
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
                @if($data->hasMorePages())
                <a href="{{ $data->nextPageUrl() }}" 
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
        @elseif($data->count() > 0)
        <!-- Untuk Collection tanpa pagination -->
        <div class="py-sm px-md border-t border-[#D1E9F6] bg-surface-container-lowest flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="font-small text-small text-on-surface-variant">
                Menampilkan 1 hingga {{ $data->count() }} dari {{ $data->count() }} data
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

    <!-- Quick Information Cards -->
    <div class="mt-xl grid grid-cols-1 md:grid-cols-3 gap-gutter">
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Total Peralatan Rusak</h4>
                <p class="font-h2 text-h2 text-[#38B6FF] font-bold">{{ $data->count() }}</p>
                <p class="font-small text-small text-on-surface-variant">Peralatan yang perlu perbaikan</p>
            </div>
        </div>
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">build</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Tindakan</h4>
                <p class="font-small text-small text-on-surface-variant">Segera lakukan perbaikan atau penggantian peralatan rusak.</p>
            </div>
        </div>
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">warning</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Perhatian</h4>
                <p class="font-small text-small text-on-surface-variant">Peralatan rusak dapat mempengaruhi kinerja operasional.</p>
            </div>
        </div>
    </div>
</div>
</main>

<style>
/* Animasi untuk loading jika diperlukan */
@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

/* Hover effect untuk card info */
.bg-\[\#E6F6FF\]\/20:hover {
    background-color: rgba(230, 246, 255, 0.4);
    transition: background-color 0.3s ease;
}

/* Styling untuk status badge */
.bg-red-100 {
    background-color: #FEE2E2;
}

.text-red-800 {
    color: #991B1B;
}

.border-red-200 {
    border-color: #FECACA;
}

.bg-red-500 {
    background-color: #EF4444;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide any flash messages jika ada
    setTimeout(function() {
        document.querySelectorAll('.flash-message').forEach(msg => {
            msg.style.transition = 'opacity 0.5s';
            msg.style.opacity = '0';
            setTimeout(() => msg.style.display = 'none', 500);
        });
    }, 5000);
});
</script>
@endsection