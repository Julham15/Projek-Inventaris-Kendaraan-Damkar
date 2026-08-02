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
        <span class="font-h2 text-h2 font-bold text-primary">Tambah Kondisi Kendaraan</span>
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
        <a href="{{ route('posko.jenis-mobil.kendaraan.kondisi.index', [$posko->id, $jenis_mobil->id, $kendaraan->id]) }}" 
           class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-[#E6F6FF] transition-colors active:scale-90 group">
            <span class="material-symbols-outlined text-on-surface group-hover:text-[#38B6FF]">arrow_back</span>
        </a>
        <div>
            
            <p class="font-body-regular text-body-regular text-on-surface-variant mt-1">
                Tambahkan kondisi baru untuk kendaraan <strong>{{ $kendaraan->nomor_polisi }}</strong>
            </p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-lg md:p-xl max-w-3xl">
        <form action="{{ route('posko.jenis-mobil.kendaraan.kondisi.store', [$posko->id, $jenis_mobil->id, $kendaraan->id]) }}" 
              method="POST" 
              class="space-y-lg"
              id="addConditionForm">
            @csrf
            
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

            <!-- Form Row: Nama Kondisi -->
            <div class="space-y-xs">
                <label class="font-h4 text-h4 text-on-surface" for="nama_kondisi">
                    Nama Kondisi <span class="text-error">*</span>
                </label>
                <input type="text" 
                       name="nama_kondisi" 
                       class="w-full px-md py-sm border border-outline-variant rounded-lg font-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all @error('nama_kondisi') border-error @enderror" 
                       id="nama_kondisi" 
                       placeholder="Contoh: Mesin, Ban, Rem, Sistem Kelistrikan, Dll"
                       value="{{ old('nama_kondisi') }}"
                       required>
                @error('nama_kondisi')
                <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">error</span>
                    {{ $message }}
                </p>
                @enderror
                <p class="font-caption text-caption text-on-surface-variant">Masukkan nama komponen atau bagian kendaraan yang akan dinilai kondisinya.</p>
            </div>

            <!-- Form Row: Status -->
            <div class="space-y-xs">
                <label class="font-h4 text-h4 text-on-surface" for="status">
                    Status <span class="text-error">*</span>
                </label>
                <select name="status" 
                        class="w-full px-md py-sm border border-outline-variant rounded-lg font-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all appearance-none bg-white @error('status') border-error @enderror" 
                        id="status"
                        required>
                    <option value="">--Pilih Status--</option>
                    <option value="Baik" {{ old('status') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Cukup" {{ old('status') == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                    <option value="Perlu Perhatian" {{ old('status') == 'Perlu Perhatian' ? 'selected' : '' }}>Perlu Perhatian</option>
                </select>
                @error('status')
                <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">error</span>
                    {{ $message }}
                </p>
                @enderror
                <p class="font-caption text-caption text-on-surface-variant">Pilih status kondisi komponen kendaraan saat ini.</p>
            </div>

            <!-- Status Preview dengan Warna -->
            <div class="p-md bg-[#E6F6FF]/20 rounded-lg border border-[#D1E9F6]">
                <p class="font-small text-small text-on-surface-variant mb-1">Preview Status:</p>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800 border border-gray-200" id="preview-status">
                        <span class="w-2 h-2 rounded-full mr-1.5 bg-gray-500" id="preview-dot"></span>
                        Belum dipilih
                    </span>
                    <span class="font-small text-small text-on-surface-variant">(Akan berubah sesuai pilihan)</span>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="bg-[#E6F6FF]/20 p-md rounded-lg border border-[#D1E9F6]">
                <div class="flex gap-sm">
                    <span class="material-symbols-outlined text-[#38B6FF]">info</span>
                    <div>
                        <p class="font-h4 text-h4 font-bold text-on-surface">Informasi Tambahan</p>
                        <p class="font-body-regular text-on-surface-variant">Pastikan data kondisi kendaraan diisi dengan benar untuk keperluan monitoring dan evaluasi.</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col md:flex-row items-center gap-md pt-lg border-t border-[#D1E9F6]">
                <a href="{{ route('posko.jenis-mobil.kendaraan.kondisi.index', [$posko->id, $jenis_mobil->id, $kendaraan->id]) }}" 
                   class="w-full md:w-auto px-xl py-3 rounded-lg border border-[#D1E9F6] text-on-surface-variant font-h4 text-h4 hover:bg-surface-container transition-colors text-center">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full md:w-auto px-xl py-3 rounded-lg bg-[#38B6FF] text-white font-h4 text-h4 hover:bg-[#0A8FD6] transition-colors shadow-md active:scale-[0.98] flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">save</span>
                    Simpan Kondisi
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Information Cards -->
    <div class="mt-xl grid grid-cols-1 md:grid-cols-3 gap-gutter max-w-3xl">
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">info</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Data Kondisi</h4>
                <p class="font-small text-small text-on-surface-variant">Pastikan data kondisi kendaraan diisi dengan benar dan lengkap.</p>
            </div>
        </div>
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">health_metrics</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Monitoring</h4>
                <p class="font-small text-small text-on-surface-variant">Kondisi akan digunakan untuk memantau kesiapan kendaraan.</p>
            </div>
        </div>
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">verified_user</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Verifikasi</h4>
                <p class="font-small text-small text-on-surface-variant">Data akan diverifikasi sebelum digunakan dalam sistem.</p>
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview status change
    const statusSelect = document.getElementById('status');
    const previewStatus = document.getElementById('preview-status');
    const previewDot = document.getElementById('preview-dot');
    
    if (statusSelect && previewStatus && previewDot) {
        statusSelect.addEventListener('change', function() {
            const value = this.value;
            
            if (value === '') {
                previewStatus.className = 'inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800 border border-gray-200';
                previewDot.className = 'w-2 h-2 rounded-full mr-1.5 bg-gray-500';
                previewStatus.innerHTML = '<span class="w-2 h-2 rounded-full mr-1.5 bg-gray-500"></span> Belum dipilih';
                return;
            }
            
            const statusClasses = {
                'Baik': 'bg-green-100 text-green-800 border-green-200',
                'Cukup': 'bg-yellow-100 text-yellow-800 border-yellow-200',
                'Perlu Perhatian': 'bg-orange-100 text-orange-800 border-orange-200'
            };
            
            const dotClasses = {
                'Baik': 'bg-green-500',
                'Cukup': 'bg-yellow-500',
                'Perlu Perhatian': 'bg-orange-500'
            };
            
            previewStatus.className = `inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium ${statusClasses[value] || 'bg-gray-100 text-gray-800 border-gray-200'}`;
            previewDot.className = `w-2 h-2 rounded-full mr-1.5 ${dotClasses[value] || 'bg-gray-500'}`;
            previewStatus.innerHTML = `<span class="w-2 h-2 rounded-full mr-1.5 ${dotClasses[value] || 'bg-gray-500'}"></span> ${value}`;
        });
    }

    // Form Submission
    const form = document.getElementById('addConditionForm');
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