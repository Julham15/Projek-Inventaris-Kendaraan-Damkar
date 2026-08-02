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
            <span class="font-h2 text-h2 font-bold text-primary">Mutasi Kendaraan</span>
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
                    <a href="{{ route('posko.jenis-mobil.kendaraan.index', [$posko->id, $jenis_mobil->id]) }}" 
                       class="flex items-center gap-1 text-secondary hover:text-primary transition-colors font-medium text-body-regular">
                        <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                        Kembali
                    </a>
                </div>
                <p class="font-body-regular text-body-regular text-on-surface-variant mt-1">
                    Mutasi kendaraan <span class="font-bold">{{ $kendaraan->nomor_polisi }}</span> 
                    dari <span class="font-bold">{{ $posko->nama_posko }}</span> ke posko tujuan.
                </p>
            </div>
           
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] overflow-hidden">
            <form method="POST" 
                  action="{{ route('posko.jenis-mobil.kendaraan.prosesMutasi', [$posko, $jenis_mobil, $kendaraan]) }}">
                @csrf
                @method('PUT')

                <div class="p-lg space-y-6">

                    <!-- Informasi Kendaraan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nomor Polisi -->
                        <div>
                            <label class="block font-medium text-on-surface text-body-regular mb-1.5">
                                <span class="material-symbols-outlined text-[18px] align-middle mr-1">badge</span>
                                Nomor Polisi
                            </label>
                            <input type="text"
                                   class="form-input w-full bg-[#F5FAFF] border-[#D1E9F6] rounded-lg px-4 py-2.5 text-body-regular text-on-surface cursor-not-allowed opacity-75"
                                   value="{{ $kendaraan->nomor_polisi }}"
                                   disabled>
                        </div>

                        <!-- Jenis Mobil -->
                        <div>
                            <label class="block font-medium text-on-surface text-body-regular mb-1.5">
                                <span class="material-symbols-outlined text-[18px] align-middle mr-1">directions_car</span>
                                Jenis Mobil
                            </label>
                            <input type="text"
                                   class="form-input w-full bg-[#F5FAFF] border-[#D1E9F6] rounded-lg px-4 py-2.5 text-body-regular text-on-surface cursor-not-allowed opacity-75"
                                   value="{{ $jenis_mobil->nama_jenis }}"
                                   disabled>
                        </div>
                    </div>

                    <!-- Posko Asal & Tujuan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Posko Saat Ini -->
                        <div>
                            <label class="block font-medium text-on-surface text-body-regular mb-1.5">
                                <span class="material-symbols-outlined text-[18px] align-middle mr-1">location_on</span>
                                Pos Asal
                            </label>
                            <div class="relative">
                                <input type="text"
                                       class="form-input w-full bg-[#E6F6FF] border-[#38B6FF] rounded-lg px-4 py-2.5 text-body-regular text-primary font-medium cursor-not-allowed"
                                       value="{{ $posko->nama_posko }}"
                                       disabled>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <span class="material-symbols-outlined text-primary text-[20px]">check_circle</span>
                                </span>
                            </div>
                        </div>

                        <!-- Posko Tujuan -->
                        <div>
                            <label class="block font-medium text-on-surface text-body-regular mb-1.5">
                                <span class="material-symbols-outlined text-[18px] align-middle mr-1">flag</span>
                                Pos Tujuan
                                <span class="text-error">*</span>
                            </label>
                            <select name="posko_tujuan"
                                    class="form-select w-full border-[#D1E9F6] rounded-lg px-4 py-2.5 text-body-regular text-on-surface focus:border-[#38B6FF] focus:ring-2 focus:ring-[#38B6FF]/20 transition-all"
                                    required>
                                <option value="">-- Pilih Pos Tujuan --</option>
                                @foreach($poskos as $item)
                                    <option value="{{ $item->id }}" 
                                        {{ $item->id == $posko->id ? 'disabled' : '' }}>
                                        {{ $item->nama_posko }}
                                        {{ $item->id == $posko->id ? '(Pos Asal)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('posko_tujuan')
                                <p class="text-error text-sm mt-1.5 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">error</span>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-on-surface-variant text-small mt-1.5 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">info</span>
                                Pilih posko tujuan untuk memindahkan kendaraan
                            </p>
                        </div>
                    </div>

                    <!-- Alert Informasi -->
                    <div class="bg-[#FFF8E1] border border-[#FFD54F] rounded-lg p-4 flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#FFA000]">warning</span>
                        <div class="text-sm text-on-surface">
                            <p class="font-medium">Perhatian!</p>
                            <p class="text-on-surface-variant">
                                Kendaraan akan dipindahkan dari <strong>{{ $posko->nama_posko }}</strong> 
                                ke posko tujuan yang dipilih. Pastikan data peralatan dan kondisi kendaraan sudah lengkap.
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Form Actions -->
                <div class="px-lg py-md border-t border-[#D1E9F6] bg-[#F8FBFF] flex flex-col sm:flex-row justify-between items-center gap-3">
                    <div class="flex items-center gap-2 text-on-surface-variant text-small">
                        <span class="material-symbols-outlined text-[16px]">info</span>
                        <span>Data laporan sebelumnya dari kendaraan ini tidak akan diperbarui setelah mutasi</span>
                    </div>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <a href="{{ route('posko.jenis-mobil.kendaraan.index', [$posko, $jenis_mobil]) }}"
                           class="flex-1 sm:flex-none button bg-white hover:bg-[#F5FAFF] text-on-surface font-medium text-body-regular px-lg py-2.5 rounded-lg border border-[#D1E9F6] transition-colors flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                            Batal
                        </a>
                        <button type="submit"
                                class="flex-1 sm:flex-none button bg-[#38B6FF] hover:bg-[#0A8FD6] text-white font-medium text-body-regular px-lg py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <span class="material-symbols-outlined text-[20px]">sync_alt</span>
                            Mutasikan
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</main>
@endsection