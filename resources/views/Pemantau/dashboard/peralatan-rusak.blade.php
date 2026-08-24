@extends('Pemantau.layouts.index')
@section('admin2')

<!-- ===== WELCOME ===== -->
<div class="mb-md md:mb-xl p-md md:p-lg bg-primary-container/10 border border-primary-container/30 rounded-xl">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-sm">
        <div>
            <h1 class="font-h2 md:font-h1 text-h2 md:text-h1 text-primary mb-xs flex items-center gap-sm">
                <span class="material-symbols-outlined text-2xl md:text-3xl">build</span>
                Peralatan Rusak
            </h1>
            <p class="font-small md:font-body-regular text-small md:text-body-regular text-on-surface-variant max-w-3xl">
                Daftar seluruh peralatan yang mengalami kerusakan dan memerlukan perbaikan segera.
            </p>
        </div>
        <a href="{{ url()->previous() }}" 
           class="inline-flex items-center gap-xs px-md md:px-lg py-sm bg-surface-container-low text-on-surface-variant rounded-lg hover:bg-surface-container-high transition-colors font-small md:font-body-regular text-small md:text-body-regular flex-shrink-0">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali
        </a>
    </div>
</div>

<!-- ===== STATISTICS SUMMARY (Mobile Optimized) ===== -->
<div class="grid grid-cols-1 gap-sm md:gap-md mb-md md:mb-xl">
    <!-- Rusak Berat -->
    <div class="bg-white p-md md:p-lg rounded-xl border border-outline-variant custom-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="font-small md:font-h4 text-small md:text-h4 text-on-surface-variant mb-xs">Rusak Berat</p>
                <h2 class="font-h1 md:font-h1 text-h1 md:text-h1 text-error">{{ $data->where('status', 'Rusak Berat')->count() }}</h2>
            </div>
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-error/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl md:text-3xl text-error">error</span>
            </div>
        </div>
        <div class="mt-md flex items-center gap-xs text-error">
            <span class="material-symbols-outlined text-sm">info</span>
            <span class="font-small text-small">Perlu Penggantian</span>
        </div>
    </div>
</div>

<!-- ===== TABLE / CARD SECTION ===== -->
<div class="bg-white rounded-xl border border-outline-variant custom-shadow overflow-hidden">
    <div class="p-md md:p-lg border-b border-outline-variant flex flex-wrap items-center justify-between gap-2">
        <h3 class="font-h3 text-h3 text-on-surface flex items-center gap-sm text-sm md:text-base">
            <span class="material-symbols-outlined text-error text-base md:text-xl">list_alt</span>
            Daftar Peralatan Rusak
        </h3>
        <span class="inline-flex items-center gap-xs px-2 md:px-4 py-0.5 md:py-2 bg-surface-container-low rounded-full text-[10px] md:text-small text-on-surface-variant">
            <span class="material-symbols-outlined text-sm">info</span>
            {{ $data->count() }} data
        </span>
    </div>
    
    <!-- Mobile Card View -->
    <div class="block md:hidden p-3 space-y-3">
        @forelse($data as $item)
        <div class="bg-surface-container/30 rounded-lg border border-outline-variant p-3 hover:shadow-md transition-shadow">
            <!-- Header: Plat Nomor -->
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-sm">directions_car</span>
                    <span class="font-bold text-sm text-on-surface">{{ $item->kendaraan->nomor_polisi }}</span>
                </div>
                <!-- Status Badge -->
                @if($item->status == 'Rusak Berat')
                    <span class="inline-flex items-center gap-xs px-2 py-0.5 rounded-full bg-error/10 text-error font-bold text-[10px]">
                        <span class="w-1.5 h-1.5 rounded-full bg-error animate-pulse"></span>
                        Rusak Berat
                    </span>
                @elseif($item->status == 'Rusak Ringan')
                    <span class="inline-flex items-center gap-xs px-2 py-0.5 rounded-full bg-orange-100 text-orange-700 font-bold text-[10px]">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                        Rusak Ringan
                    </span>
                @elseif($item->status == 'Baik')
                    <span class="inline-flex items-center gap-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700 font-bold text-[10px]">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        Baik
                    </span>
                @else
                    <span class="inline-flex items-center gap-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 font-bold text-[10px]">
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                        {{ $item->status }}
                    </span>
                @endif
            </div>
            
            <!-- Detail -->
            <div class="space-y-1.5">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm text-on-surface-variant">handyman</span>
                    <span class="text-sm">{{ $item->peralatan->nama_alat }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm text-on-surface-variant">location_on</span>
                    <span class="text-sm">{{ $item->kendaraan->jenisMobil->posko->nama_posko ?? '-' }}</span>
                </div>
            </div>
        </div>
        @empty
        <div class="p-xl text-center text-on-surface-variant">
            <span class="material-symbols-outlined text-4xl block mb-sm">check_circle_outline</span>
            <span class="font-h4 text-h4 block mb-xs">Semua Peralatan Baik</span>
            <span class="font-body-regular text-body-regular">Tidak ada peralatan yang mengalami kerusakan.</span>
        </div>
        @endforelse
    </div>

    <!-- Desktop Table View -->
    <div class="hidden md:block overflow-x-auto overflow-y-auto max-h-[500px]" style="overscroll-behavior: contain;">
        <table class="w-full min-w-[900px] zebra-table">
            <thead class="bg-primary text-white sticky top-0 z-10">
                <tr>
                    <th class="p-md font-h4 text-h4 text-left whitespace-nowrap">
                        <span class="flex items-center gap-xs">
                            <span class="material-symbols-outlined text-sm">directions_car</span>
                            Kendaraan
                        </span>
                    </th>
                    <th class="p-md font-h4 text-h4 text-left whitespace-nowrap">
                        <span class="flex items-center gap-xs">
                            <span class="material-symbols-outlined text-sm">handyman</span>
                            Peralatan
                        </span>
                    </th>
                    <th class="p-md font-h4 text-h4 text-left whitespace-nowrap">
                        <span class="flex items-center gap-xs">
                            <span class="material-symbols-outlined text-sm">domain</span>
                            Pos
                        </span>
                    </th>
                    <th class="p-md font-h4 text-h4 text-left whitespace-nowrap">
                        <span class="flex items-center gap-xs">
                            <span class="material-symbols-outlined text-sm">info</span>
                            Status
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody class="font-body-regular text-body-regular">
                @forelse($data as $item)
                <tr class="hover:bg-surface-container-high transition-colors">
                    <td class="p-md border-b border-outline-variant">
                        <div class="flex items-center gap-sm">
                            <span class="material-symbols-outlined text-primary text-sm">directions_car</span>
                            <span class="font-semibold">{{ $item->kendaraan->nomor_polisi }}</span>
                        </div>
                    </td>
                    <td class="p-md border-b border-outline-variant">
                        <div class="flex items-center gap-sm">
                            <span class="material-symbols-outlined text-sm text-on-surface-variant">build</span>
                            {{ $item->peralatan->nama_alat }}
                        </div>
                    </td>
                    <td class="p-md border-b border-outline-variant">
                        <span class="inline-flex items-center gap-xs">
                            <span class="material-symbols-outlined text-sm text-on-surface-variant">location_on</span>
                            {{ $item->kendaraan->jenisMobil->posko->nama_posko ?? '-' }}
                        </span>
                    </td>
                    <td class="p-md border-b border-outline-variant">
                        @if($item->status == 'Rusak Berat')
                            <span class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-error/10 text-error font-bold text-small">
                                <span class="w-1.5 h-1.5 rounded-full bg-error animate-pulse"></span>
                                Rusak Berat
                            </span>
                        @elseif($item->status == 'Rusak Ringan')
                            <span class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-orange-100 text-orange-700 font-bold text-small">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                Rusak Ringan
                            </span>
                        @elseif($item->status == 'Baik')
                            <span class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-green-100 text-green-700 font-bold text-small">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Baik
                            </span>
                        @else
                            <span class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-gray-100 text-gray-600 font-bold text-small">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                {{ $item->status }}
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-xl text-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-4xl block mb-sm">check_circle_outline</span>
                        <span class="font-h4 text-h4 block mb-xs">Semua Peralatan Baik</span>
                        <span class="font-body-regular text-body-regular">Tidak ada peralatan yang mengalami kerusakan.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ===== PAGINATION ===== -->
@if(isset($data) && method_exists($data, 'links') && $data->hasPages())
<div class="mt-md md:mt-xl">
    {{ $data->links() }}
</div>
@endif

@endsection