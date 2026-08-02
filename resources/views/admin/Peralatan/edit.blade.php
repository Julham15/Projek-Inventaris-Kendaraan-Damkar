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
        <span class="font-h2 text-h2 font-bold text-primary">Edit Peralatan</span>
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
        <a href="{{ route('posko.jenis-mobil.kendaraan.peralatan.index', [$posko->id, $jenis_mobil->id, $kendaraan->id]) }}" 
           class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-[#E6F6FF] transition-colors active:scale-90 group">
            <span class="material-symbols-outlined text-on-surface group-hover:text-[#38B6FF]">arrow_back</span>
        </a>
        <div>
            <h1 class="font-h1 text-h1 text-on-background">Edit Peralatan</h1>
            <p class="font-body-regular text-body-regular text-on-surface-variant mt-1">
                Perbarui informasi peralatan untuk kendaraan <strong>{{ $kendaraan->nomor_polisi }}</strong>
            </p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-lg md:p-xl max-w-3xl">
        <form action="{{ route('posko.jenis-mobil.kendaraan.peralatan.update', [$posko->id, $jenis_mobil->id, $kendaraan->id, $peralatan->id]) }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="space-y-lg"
              id="editEquipmentForm">
            @csrf
            @method('PUT')
            
            <!-- Informasi Konteks -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter p-md bg-[#E6F6FF]/20 rounded-lg border border-[#D1E9F6]">
                <div>
                    <label class="block font-small text-small text-on-surface-variant">Pos</label>
                    <p class="font-body-regular text-body-regular text-on-surface font-semibold">{{ $posko->nama_posko }}</p>
                </div>
                <div>
                    <label class="block font-small text-small text-on-surface-variant">Jenis Mobil</label>
                    <p class="font-body-regular text-body-regular text-on-surface font-semibold">{{ $jenis_mobil->nama_jenis }}</p>
                </div>
                <div>
                    <label class="block font-small text-small text-on-surface-variant">Kendaraan</label>
                    <p class="font-body-regular text-body-regular text-on-surface font-semibold">{{ $kendaraan->nomor_polisi }}</p>
                </div>
            </div>

            <!-- Form Row: Nama Alat -->
            <div class="space-y-xs">
                <label class="font-h4 text-h4 text-on-surface" for="nama_alat">
                    Nama Alat <span class="text-error">*</span>
                </label>
                <input type="text" 
                       name="nama_alat" 
                       class="w-full px-md py-sm border border-outline-variant rounded-lg font-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all @error('nama_alat') border-error @enderror" 
                       id="nama_alat" 
                       placeholder="Contoh: Selang Pemadam, Alat Pemadam Api Ringan, Dll"
                       value="{{ old('nama_alat', $peralatan->nama_alat) }}"
                       required>
                @error('nama_alat')
                <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">error</span>
                    {{ $message }}
                </p>
                @enderror
                <p class="font-caption text-caption text-on-surface-variant">Masukkan nama peralatan yang akan diperbarui.</p>
            </div>

            <!-- Form Row: Jumlah & Kondisi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
                <!-- Jumlah -->
                <div class="space-y-xs">
                    <label class="font-h4 text-h4 text-on-surface" for="jumlah">
                        Jumlah <span class="text-error">*</span>
                    </label>
                    <input type="number" 
                           name="jumlah" 
                           class="w-full px-md py-sm border border-outline-variant rounded-lg font-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all @error('jumlah') border-error @enderror" 
                           id="jumlah" 
                           placeholder="Contoh: 2"
                           value="{{ old('jumlah', $peralatan->jumlah) }}"
                           min="1"
                           required>
                    @error('jumlah')
                    <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">error</span>
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="font-caption text-caption text-on-surface-variant">Masukkan jumlah peralatan yang tersedia.</p>
                </div>

                <!-- Kondisi -->
                <div class="space-y-xs">
                    <label class="font-h4 text-h4 text-on-surface" for="kondisi">
                        Kondisi <span class="text-error">*</span>
                    </label>
                    <select name="kondisi" 
                            class="w-full px-md py-sm border border-outline-variant rounded-lg font-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all appearance-none bg-white @error('kondisi') border-error @enderror" 
                            id="kondisi"
                            required>
                        <option value="Baik" {{ old('kondisi', $peralatan->kondisi) == 'Baik' ? 'selected' : '' }}>
                            Baik
                        </option>
                        <option value="Rusak Ringan" {{ old('kondisi', $peralatan->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>
                            Rusak Ringan
                        </option>
                        <option value="Rusak Berat" {{ old('kondisi', $peralatan->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>
                            Rusak Berat
                        </option>
                    </select>
                    @error('kondisi')
                    <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">error</span>
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="font-caption text-caption text-on-surface-variant">Pilih kondisi peralatan saat ini.</p>
                </div>
            </div>

            <!-- Form Row: Tanggal Pengadaan -->
            <div class="space-y-xs">
                <label class="font-h4 text-h4 text-on-surface" for="tanggal_pengadaan">
                    Tanggal Pengadaan <span class="text-error">*</span>
                </label>
                <input type="date" 
                       name="tanggal_pengadaan" 
                       class="w-full px-md py-sm border border-outline-variant rounded-lg font-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all @error('tanggal_pengadaan') border-error @enderror" 
                       id="tanggal_pengadaan" 
                       value="{{ old('tanggal_pengadaan', $peralatan->tanggal_pengadaan) }}"
                       required>
                @error('tanggal_pengadaan')
                <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">error</span>
                    {{ $message }}
                </p>
                @enderror
                <p class="font-caption text-caption text-on-surface-variant">Pilih tanggal pengadaan peralatan.</p>
            </div>

            <!-- Kondisi Preview dengan Warna -->
            <div class="p-md bg-[#E6F6FF]/20 rounded-lg border border-[#D1E9F6]">
                <p class="font-small text-small text-on-surface-variant mb-1">Preview Kondisi:</p>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium
                        @if($peralatan->kondisi == 'Baik') bg-green-100 text-green-800 border border-green-200
                        @elseif($peralatan->kondisi == 'Rusak Ringan') bg-yellow-100 text-yellow-800 border border-yellow-200
                        @elseif($peralatan->kondisi == 'Rusak Berat') bg-red-100 text-red-800 border border-red-200
                        @else bg-gray-100 text-gray-800 border border-gray-200
                        @endif" id="preview-condition">
                        <span class="w-2 h-2 rounded-full mr-1.5
                            @if($peralatan->kondisi == 'Baik') bg-green-500
                            @elseif($peralatan->kondisi == 'Rusak Ringan') bg-yellow-500
                            @elseif($peralatan->kondisi == 'Rusak Berat') bg-red-500
                            @else bg-gray-500
                            @endif" id="preview-dot">
                        </span>
                        {{ $peralatan->kondisi }}
                    </span>
                    <span class="font-small text-small text-on-surface-variant">(Kondisi saat ini)</span>
                </div>
            </div>

            <!-- Gambar Saat Ini -->
          
            <!-- Informasi Tambahan (Read-only) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter p-md bg-[#E6F6FF]/20 rounded-lg border border-[#D1E9F6]">
                <div>
                    <label class="block font-small text-small text-on-surface-variant">ID Peralatan</label>
                    <p class="font-body-regular text-body-regular text-on-surface">{{ $peralatan->id ?? '-' }}</p>
                </div>
                <div>
                    <label class="block font-small text-small text-on-surface-variant">Terakhir Diperbarui</label>
                    <p class="font-body-regular text-body-regular text-on-surface">{{ isset($peralatan->updated_at) ? $peralatan->updated_at->format('d M Y H:i') : '-' }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col md:flex-row items-center gap-md pt-lg border-t border-[#D1E9F6]">
                <a href="{{ route('posko.jenis-mobil.kendaraan.peralatan.index', [$posko->id, $jenis_mobil->id, $kendaraan->id]) }}" 
                   class="w-full md:w-auto px-xl py-3 rounded-lg border border-[#D1E9F6] text-on-surface-variant font-h4 text-h4 hover:bg-surface-container transition-colors text-center">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full md:w-auto px-xl py-3 rounded-lg bg-[#38B6FF] text-white font-h4 text-h4 hover:bg-[#0A8FD6] transition-colors shadow-md active:scale-[0.98] flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">save</span>
                    Update Peralatan
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Information Cards -->
    <div class="mt-xl grid grid-cols-1 md:grid-cols-3 gap-gutter max-w-3xl">
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">info</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Update Data</h4>
                <p class="font-small text-small text-on-surface-variant">Pastikan data peralatan diperbarui dengan benar.</p>
            </div>
        </div>
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">image</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Gambar Peralatan</h4>
                <p class="font-small text-small text-on-surface-variant">Upload gambar baru untuk memperbarui tampilan peralatan.</p>
            </div>
        </div>
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">history</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Riwayat</h4>
                <p class="font-small text-small text-on-surface-variant">Semua perubahan akan tercatat dalam sistem.</p>
            </div>
        </div>
    </div>
</div>
</main>

<style>
/* Styling untuk field dengan error */
.border-error {
    border-color: #DC2626 !important;
    background-color: #FEF2F2;
}

.border-error:focus {
    border-color: #DC2626 !important;
    ring-color: #DC2626 !important;
}

.text-error {
    color: #DC2626;
}

/* Animasi untuk loading */
@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Hover effect untuk card info */
.bg-\[\#E6F6FF\]\/20:hover {
    background-color: rgba(230, 246, 255, 0.4);
    transition: background-color 0.3s ease;
}

/* Styling untuk select */
select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    padding-right: 2.5rem;
}

select:focus {
    outline: none;
}

/* Styling untuk input date */
input[type="date"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

input[type="date"]::-webkit-calendar-picker-indicator {
    cursor: pointer;
    opacity: 0.6;
}

input[type="date"]::-webkit-calendar-picker-indicator:hover {
    opacity: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File Preview
    const fileInput = document.getElementById('equipment_image');
    const previewContainer = document.getElementById('preview-container');

    if (fileInput && previewContainer) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validasi ukuran file (maks 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB.');
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewContainer.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover">`;
                    previewContainer.className = "w-full h-full";
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Preview kondisi change
    const kondisiSelect = document.getElementById('kondisi');
    const previewCondition = document.getElementById('preview-condition');
    const previewDot = document.getElementById('preview-dot');
    
    if (kondisiSelect && previewCondition && previewDot) {
        kondisiSelect.addEventListener('change', function() {
            const value = this.value;
            const conditionClasses = {
                'Baik': 'bg-green-100 text-green-800 border-green-200',
                'Rusak Ringan': 'bg-yellow-100 text-yellow-800 border-yellow-200',
                'Rusak Berat': 'bg-red-100 text-red-800 border-red-200'
            };
            
            const dotClasses = {
                'Baik': 'bg-green-500',
                'Rusak Ringan': 'bg-yellow-500',
                'Rusak Berat': 'bg-red-500'
            };
            
            previewCondition.className = `inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium ${conditionClasses[value] || 'bg-gray-100 text-gray-800 border-gray-200'}`;
            previewDot.className = `w-2 h-2 rounded-full mr-1.5 ${dotClasses[value] || 'bg-gray-500'}`;
            previewCondition.innerHTML = `<span class="w-2 h-2 rounded-full mr-1.5 ${dotClasses[value] || 'bg-gray-500'}"></span> ${value}`;
        });
    }

    // Form Submission
    const form = document.getElementById('editEquipmentForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
            `;
            submitBtn.classList.add('opacity-70', 'cursor-not-allowed');
            
            // Form akan submit secara normal
            // Loading state akan hilang setelah halaman reload/redirect
        });
    }

    // Auto-hide error messages after 5 seconds
    setTimeout(function() {
        document.querySelectorAll('.text-error').forEach(error => {
            error.style.transition = 'opacity 0.5s';
            error.style.opacity = '0';
            setTimeout(() => error.style.display = 'none', 500);
        });
    }, 5000);
});
</script>
@endsection