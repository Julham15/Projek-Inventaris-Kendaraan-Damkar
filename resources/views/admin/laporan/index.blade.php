@extends('admin.layouts')
<!-- Main Content Area -->
@section('navbar')
<main class="flex-1 flex flex-col lg:pl-[280px] w-full h-full overflow-y-auto relative">
<!-- TopNavBar -->
<header class="flex justify-between items-center w-full px-lg py-md sticky top-0 z-40 bg-white border-b border-outline-variant">
    <div class="flex items-center gap-md">
        <button class="lg:hidden text-on-surface-variant hover:text-primary transition-colors p-sm rounded-lg hover:bg-surface-container">
            <span class="material-symbols-outlined" data-icon="menu">menu</span>
        </button>
        <span class="font-h2 text-h2 font-bold text-primary">Laporan Masuk</span>
    </div>
    
    <div class="flex items-center gap-sm">
        <!-- Tambahkan tombol aksi di sini -->
    </div>
</header>
<!-- Page Content -->

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
<!-- Data Table Container -->
 <form method="GET"
      action="{{ route('admin.laporan.index') }}">
<div class="bg-white rounded-lg border border-outline-variant p-md mb-lg shadow-sm">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-md mb-md">
    
   
<!-- Search Input -->
<div class="flex flex-col gap-xs">
<label class="text-caption font-medium text-on-surface-variant">Pencarian</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-2 top-1/2 -translate-y-1/2 text-on-surface-variant text-h4">search</span>
<input class="w-full pl-8 pr-md py-2 border border-outline-variant rounded-lg text-body-regular focus:ring-primary focus:border-primary bg-surface-bright" placeholder="Cari pelapor / kendaraan..." type="text"    name="search" value="{{ request('search') }}">
</div>
</div>
<!-- Status Filter -->
<div class="flex flex-col gap-xs">
<label class="text-caption font-medium text-on-surface-variant">Status</label>
<select name="status" class="w-full px-md py-2 border border-outline-variant rounded-lg text-body-regular bg-surface-bright">
<option value="">Semua Status</option>
<option value="Diproses"
    {{ request('status') == 'Diproses' ? 'selected' : '' }}>
    Diproses
</option>
<option value="Selesai"
    {{ request('status') == 'Selesai' ? 'selected' : '' }}>
    Selesai
</option>
<option value="Diarsipkan"
            {{ request('status') == 'Diarsipkan' ? 'selected' : '' }}>
            Diarsipkan</option>
</select>
</div>
<!-- Posko Filter -->
<div class="flex flex-col gap-xs">
<label class="text-caption font-medium text-on-surface-variant">Pos</label>
<select name="posko" class="w-full px-md py-2 border border-outline-variant rounded-lg text-body-regular bg-surface-bright">
<option value="">Semua Pos</option>
 @foreach($poskos as $posko)
    <option value="{{ $posko->id }}"
            {{ request('posko') == $posko->id ? 'selected' : '' }}>

            {{ $posko->nama_posko }}
    </option>
@endforeach

</select>
</div>
<!-- Platon Filter -->
<div class="flex flex-col gap-xs">
<label class="text-caption font-medium text-on-surface-variant">Peleton</label>
<select name="platon" onchange="this.form.submit()" class="w-full px-md py-2 border border-outline-variant rounded-lg text-body-regular bg-surface-bright">
<option value="">Semua Peleton</option>
 @foreach($platons as $platon)
        <option value="{{ $platon->id }}"
            {{ request('platon') == $platon->id ? 'selected' : '' }}>
            {{ $platon->nama }}
        </option>
@endforeach
</select>
</div>
</div>
<div class="flex flex-col md:flex-row items-end justify-between gap-md">
<div class="flex flex-wrap items-center gap-md">
<!-- Regu Filter -->
<div class="flex flex-col gap-xs min-w-[150px]">
<label class="text-caption font-medium text-on-surface-variant">Regu</label>
<select name="regu" class="w-full px-md py-2 border border-outline-variant rounded-lg text-body-regular bg-surface-bright">
<option value="">Semua Regu</option>
@foreach($regus as $regu)
        <option value="{{ $regu->id }}"
            {{ request('regu') == $regu->id ? 'selected' : '' }}>
            {{ $regu->nama }}
        </option>
    @endforeach
</select>
</div>
<!-- Date Range -->
<div class="flex items-center gap-xs">
<div class="flex flex-col gap-xs">
<label class="text-caption font-medium text-on-surface-variant">Dari</label>
<input name="dari" class="px-md py-2 border border-outline-variant rounded-lg text-body-regular bg-surface-bright" type="date" value="{{ request('dari') }}">
</div>
<span class="mt-6 text-on-surface-variant">-</span>
<div class="flex flex-col gap-xs">
<label class="text-caption font-medium text-on-surface-variant">Sampai</label>
<input name="sampai" class="px-md py-2 border border-outline-variant rounded-lg text-body-regular bg-surface-bright" type="date" value="{{ request('sampai') }}">
</div>
</div>
</div>
<div class="flex items-center gap-md">
<a href="{{ route('admin.laporan.index') }}" class="text-primary font-medium hover:underline text-body-regular">Reset</a>
<button  type="submit"  class="bg-primary text-on-primary px-xl py-2 rounded-lg font-h4 hover:opacity-80 transition-colors shadow-sm flex items-center gap-xs">
<span class="material-symbols-outlined text-h4">filter_alt</span>
                Filter
            </button>
</div>
</div>
</form>
</div><div class="bg-white rounded-lg border border-outline-variant shadow-sm overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-primary text-on-primary">
<th class="py-sm px-md font-h4 text-h4 whitespace-nowrap">No</th>
<th class="py-sm px-md font-h4 text-h4 whitespace-nowrap">Pos</th>
<th class="py-sm px-md font-h4 text-h4 whitespace-nowrap">Peleton - Regu</th>
<th class="py-sm px-md font-h4 text-h4 whitespace-nowrap">Pelapor</th>
<th class="py-sm px-md font-h4 text-h4 whitespace-nowrap">Kendaraan</th>
<th class="text-center py-sm px-md font-h4 text-h4 whitespace-nowrap">Peralatan<br>Bermasalah</th>
<th class="text-center py-sm px-md font-h4 text-h4 whitespace-nowrap">Kondisi<br>Bermasalah</th>
<th class="py-sm px-md font-h4 text-h4 whitespace-nowrap">Status</th>
<th class="py-sm px-md font-h4 text-h4 whitespace-nowrap">Waktu Lapor</th>
<th class="py-sm px-md font-h4 text-h4 whitespace-nowrap text-center">Aksi</th>
</tr>
</thead>
<tbody class="divide-y divide-surface-variant font-body-regular text-body-regular text-center text-on-surface">
<!-- Row 1 -->
  @forelse($laporans as $item)
<tr class="hover:bg-surface transition-colors">
<td class="py-sm px-md"> {{ $loop->iteration }}</td>
<td class="py-sm px-md">  {{$item->nama_posko}}</td>
<td class="py-sm px-md">{{ $item->platon->nama }} - {{ $item->regu->nama }}</td>
<td class="py-sm px-md">
<div class="flex items-center gap-xs">
                                        {{ $item->user?->name ?? 'Dinonaktifkan' }}
                                    </div>
</td>
<td class="py-sm px-md">  {{ $item->kendaraan->nomor_polisi }}</td>
<td class="py-sm px-md">{{$item->laporanPeralatans->where('kondisi', 'Rusak Berat')->count()}}</td>
<td class="py-sm px-md">{{$item->laporanKondisis->where('status', 'Perlu Perhatian')->count()}}</td>
<td class="py-sm px-md">

      @if($item->status == 'Diproses')
                    <span style="background-color: rgb(255, 245, 48); padding: 5px 8px; border-radius: 8px;">
                        Diproses
                    </span>
                @elseif($item->status == 'Selesai')
                    <span style="background-color: rgb(48, 255, 96); padding: 5px 8px; border-radius: 8px;">
                        Selesai
                    </span>
                @elseif($item->status == 'Diarsipkan')
                    <span style="background-color: rgb(183, 190, 190); padding: 5px 8px; border-radius: 8px;">
                        Diarsipkan
                    </span>
                @else
                    <span style="color:red;">
                        Ditolak
                    </span>
                @endif
</td>
<td class="py-sm px-md text-on-surface-variant">{{ $item->created_at->format('d-m-Y') }}</td>
<td class="py-sm px-md text-center"> <a href="{{ route('admin.laporan.show', $item->id) }}" class="bg-primary-container text-on-primary-container px-md py-1 rounded-lg font-medium text-small hover:opacity-90 transition-colors flex items-center gap-xs mx-auto">Detail</a></td>
</tr>
 @empty
        <tr>
            <td colspan="7">
                Belum Ada Laporan

            </td>

        </tr>
    @endforelse
</tbody>
</table>
</div>
<!-- Pagination -->
<div class="bg-white px-md py-sm border-t border-outline-variant flex items-center justify-between">
    <p class="font-small text-small text-on-surface-variant">
        Menampilkan {{ $laporans->firstItem() ?? 0 }}-{{ $laporans->lastItem() ?? 0 }} dari {{ $laporans->total() ?? 0 }} laporan
    </p>
    <div class="flex items-center gap-xs">
        <button class="p-xs border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface-container disabled:opacity-50" 
                {{ $laporans->onFirstPage() ? 'disabled' : '' }}
                onclick="window.location='{{ $laporans->previousPageUrl() }}'">
            <span class="material-symbols-outlined text-small" data-icon="chevron_left">chevron_left</span>
        </button>
        
        @for($i = 1; $i <= $laporans->lastPage(); $i++)
            @if($i == $laporans->currentPage())
                <button class="w-8 h-8 rounded-lg bg-primary text-on-primary font-h4 text-small flex items-center justify-center">{{ $i }}</button>
            @elseif($i == 1 || $i == $laporans->lastPage() || abs($i - $laporans->currentPage()) <= 1)
                <button class="w-8 h-8 rounded-lg text-on-surface hover:bg-surface-container font-h4 text-small flex items-center justify-center"
                        onclick="window.location='{{ $laporans->url($i) }}'">{{ $i }}</button>
            @elseif($i == 2 || $i == $laporans->lastPage() - 1)
                <span class="text-on-surface-variant">...</span>
            @endif
        @endfor
        
        <button class="p-xs border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface-container"
                {{ $laporans->hasMorePages() ? '' : 'disabled' }}
                onclick="window.location='{{ $laporans->nextPageUrl() }}'">
            <span class="material-symbols-outlined text-small" data-icon="chevron_right">chevron_right</span>
        </button>
    </div>
</div>
</div>
</main>

@endsection