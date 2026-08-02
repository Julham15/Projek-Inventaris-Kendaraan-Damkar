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
        <span class="font-h2 text-h2 font-bold text-primary">Pencarian Cepat</span>
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
    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-lg mb-lg">
        <form method="GET" action="{{ route('pencarian.index') }}" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-md items-end">
                <!-- Pilih Posko -->
                <div class="flex flex-col gap-xs">
                    <label class="font-h4 text-h4 text-on-surface-variant" for="posko_id">Pos</label>
                    <select name="posko_id" 
                            id="posko_id" 
                            class="form-select w-full bg-surface-container-low border-outline-variant rounded-lg text-body-regular py-sm focus:ring-primary focus:border-primary">
                        <option value="">--Pilih Pos--</option>
                        @foreach($poskos as $item)
                        <option value="{{ $item->id }}" {{ request('posko_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_posko }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Jenis Mobil -->
                <div class="flex flex-col gap-xs">
                    <label class="font-h4 text-h4 text-on-surface-variant" for="jenis_mobil_id">Jenis Mobil</label>
                    <select name="jenis_mobil_id" 
                            id="jenis_mobil_id" 
                            class="form-select w-full bg-surface-container-low border-outline-variant rounded-lg text-body-regular py-sm focus:ring-primary focus:border-primary">
                        <option value="">--Pilih Jenis Mobil--</option>
                        @foreach($jenisMobil as $item)
                        <option value="{{ $item->id }}" {{ request('jenis_mobil_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_jenis }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Kendaraan -->
                <div class="flex flex-col gap-xs">
                    <label class="font-h4 text-h4 text-on-surface-variant" for="kendaraan_id">Kendaraan</label>
                    <select name="kendaraan_id" 
                            id="kendaraan_id" 
                            class="form-select w-full bg-surface-container-low border-outline-variant rounded-lg text-body-regular py-sm focus:ring-primary focus:border-primary">
                        <option value="">--Pilih Kendaraan--</option>
                        @foreach($kendaraans as $item)
                        <option value="{{ $item->id }}" {{ request('kendaraan_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nomor_polisi }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Cari -->
                <button type="submit" 
                        class="w-full h-[46px] bg-[#38B6FF] hover:bg-[#0A8FD6] text-white rounded-lg font-h4 text-h4 transition-all shadow-sm flex items-center justify-center gap-xs">
                    <span class="material-symbols-outlined">search</span>
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Results Section -->
    <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] overflow-hidden">
        <div class="p-md border-b border-[#D1E9F6] flex items-center justify-between bg-surface-container-low">
            <h3 class="font-h3 text-h3 text-on-surface">Hasil Pencarian</h3>
            @if(request()->has('posko_id') || request()->has('jenis_mobil_id') || request()->has('kendaraan_id'))
            <span class="text-sm text-on-surface-variant">
                Filter aktif: 
                @if(request('posko_id')) 
                    <span class="inline-flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded-full text-xs">
                        Pos: {{ $poskos->where('id', request('posko_id'))->first()->nama_posko ?? '' }}
                    </span>
                @endif
                @if(request('jenis_mobil_id'))
                    <span class="inline-flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded-full text-xs">
                        Jenis: {{ $jenisMobil->where('id', request('jenis_mobil_id'))->first()->nama_jenis ?? '' }}
                    </span>
                @endif
                @if(request('kendaraan_id'))
                    <span class="inline-flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded-full text-xs">
                        Kendaraan: {{ $kendaraans->where('id', request('kendaraan_id'))->first()->nomor_polisi ?? '' }}
                    </span>
                @endif
            </span>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="py-sm px-md font-h4 text-h4 w-16 text-center">No</th>
                        <th class="py-sm px-md font-h4 text-h4">Nama Peralatan</th>
                        <th class="py-sm px-md font-h4 text-h4">Kendaraan</th>
                        <th class="py-sm px-md font-h4 text-h4">Kondisi Peralatan</th>
                        <th class="py-sm px-md font-h4 text-h4 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-body-regular text-body-regular text-on-surface">
                    @forelse($peralatans as $item)
                    <tr class="bg-white hover:bg-[#E6F6FF]/30 transition-colors border-b border-outline-variant/30">
                        <td class="py-sm px-md text-center">{{ $loop->iteration }}</td>
                        <td class="py-sm px-md font-medium">{{ $item->nama_alat }}</td>
                        <td class="py-sm px-md">{{ $item->kendaraan->nomor_polisi ?? '-' }}</td>
                        <td class="py-sm px-md">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($item->kondisi == 'Baik') bg-green-100 text-green-800 border border-green-200
                                @elseif($item->kondisi == 'Rusak') bg-red-100 text-red-800 border border-red-200
                                @else bg-yellow-100 text-yellow-800 border border-yellow-200
                                @endif">
                                {{ $item->kondisi }}
                            </span>
                        </td>
                        <td class="py-sm px-md text-center">
                            <a href="{{ route('pencarian.show', $item->kendaraan_id) }}" 
   class="inline-flex items-center gap-1 px-2 py-1 bg-[#38B6FF]/10 text-[#38B6FF] rounded-md text-xs hover:bg-[#38B6FF] hover:text-white transition-all group relative">
    <span class="material-symbols-outlined text-[16px]">visibility</span>

                                Lihat
                                <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface px-2 py-1 rounded font-small text-small hidden group-hover:block whitespace-nowrap">
                                    Detail Kendaraan
                                </span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-sm px-md text-center text-on-surface-variant">
                            <div class="flex flex-col items-center justify-center py-8">
                                <span class="material-symbols-outlined text-6xl text-outline mb-2">search_off</span>
                                <p class="font-h4 text-h4 text-on-surface-variant">Data tidak ditemukan</p>
                                <p class="text-sm text-on-surface-variant">Silakan pilih filter yang berbeda atau reset filter</p>
                                @if(request()->has('posko_id') || request()->has('jenis_mobil_id') || request()->has('kendaraan_id'))
                                <a href="{{ route('pencarian.index') }}" class="mt-4 text-primary hover:text-[#0A8FD6] font-medium">
                                    Reset Filter
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($peralatans instanceof \Illuminate\Pagination\LengthAwarePaginator && $peralatans->total() > 0)
        <div class="py-sm px-md border-t border-[#D1E9F6] bg-surface-container-lowest flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="font-small text-small text-on-surface-variant">
                Menampilkan {{ $peralatans->firstItem() ?? 0 }} hingga {{ $peralatans->lastItem() ?? 0 }} dari {{ $peralatans->total() }} hasil
            </p>
            <div class="flex items-center gap-1">
                <!-- Tombol Previous -->
                @if($peralatans->onFirstPage())
                <button class="p-1 rounded text-on-surface-variant/50 cursor-not-allowed" disabled>
                    <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                </button>
                @else
                <a href="{{ $peralatans->previousPageUrl() }}" 
                   class="p-1 rounded text-on-surface-variant hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                </a>
                @endif

                <!-- Nomor Halaman -->
                @foreach($peralatans->getUrlRange(1, $peralatans->lastPage()) as $page => $url)
                    @if($page == $peralatans->currentPage())
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
                @if($peralatans->hasMorePages())
                <a href="{{ $peralatans->nextPageUrl() }}" 
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
        @elseif($peralatans->count() > 0)
        <!-- Untuk Collection tanpa pagination -->
        <div class="py-sm px-md border-t border-[#D1E9F6] bg-surface-container-lowest flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="font-small text-small text-on-surface-variant">
                Menampilkan 1 hingga {{ $peralatans->count() }} dari {{ $peralatans->count() }} hasil
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Element references
    const poskoSelect = document.getElementById('posko_id');
    const jenisMobilSelect = document.getElementById('jenis_mobil_id');
    const kendaraanSelect = document.getElementById('kendaraan_id');

    // Function to load jenis mobil based on posko
    function loadJenisMobil(poskoId, selectedJenisId = null) {
        if (poskoId) {
            fetch(`/api/jenis-mobil?posko_id=${poskoId}`)
                .then(response => response.json())
                .then(data => {
                    jenisMobilSelect.innerHTML = '<option value="">--Pilih Jenis Mobil--</option>';
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.nama_jenis;
                        if (selectedJenisId && selectedJenisId == item.id) {
                            option.selected = true;
                        }
                        jenisMobilSelect.appendChild(option);
                    });
                    // Trigger load kendaraan after jenis mobil loaded
                    const currentJenisId = jenisMobilSelect.value;
                    if (currentJenisId) {
                        loadKendaraan(currentJenisId);
                    } else {
                        kendaraanSelect.innerHTML = '<option value="">--Pilih Kendaraan--</option>';
                    }
                });
        } else {
            jenisMobilSelect.innerHTML = '<option value="">--Pilih Jenis Mobil--</option>';
            kendaraanSelect.innerHTML = '<option value="">--Pilih Kendaraan--</option>';
        }
    }

    // Function to load kendaraan based on jenis mobil
    function loadKendaraan(jenisMobilId, selectedKendaraanId = null) {
        if (jenisMobilId) {
            fetch(`/api/kendaraan?jenis_mobil_id=${jenisMobilId}`)
                .then(response => response.json())
                .then(data => {
                    kendaraanSelect.innerHTML = '<option value="">--Pilih Kendaraan--</option>';
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.nomor_polisi;
                        if (selectedKendaraanId && selectedKendaraanId == item.id) {
                            option.selected = true;
                        }
                        kendaraanSelect.appendChild(option);
                    });
                });
        } else {
            kendaraanSelect.innerHTML = '<option value="">--Pilih Kendaraan--</option>';
        }
    }

    // Event listener for posko change
    poskoSelect.addEventListener('change', function() {
        const poskoId = this.value;
        const currentJenisId = jenisMobilSelect.value;
        loadJenisMobil(poskoId, currentJenisId);
    });

    // Event listener for jenis mobil change
    jenisMobilSelect.addEventListener('change', function() {
        const jenisMobilId = this.value;
        const currentKendaraanId = kendaraanSelect.value;
        loadKendaraan(jenisMobilId, currentKendaraanId);
    });

    // Load initial data if posko is selected
    const initialPoskoId = poskoSelect.value;
    const initialJenisId = jenisMobilSelect.value;
    const initialKendaraanId = kendaraanSelect.value;
    
    if (initialPoskoId) {
        loadJenisMobil(initialPoskoId, initialJenisId);
    }
    
    // Jika jenis mobil sudah dipilih di awal, load kendaraan
    if (initialJenisId) {
        loadKendaraan(initialJenisId, initialKendaraanId);
    }
});
</script>
@endsection