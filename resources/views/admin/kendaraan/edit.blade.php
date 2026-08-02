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
        <span class="font-h2 text-h2 font-bold text-primary">Edit Kendaraan</span>
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
        <a href="{{ route('posko.jenis-mobil.kendaraan.index', [$posko->id, $jenis_mobil->id]) }}" 
           class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-[#E6F6FF] transition-colors active:scale-90 group">
            <span class="material-symbols-outlined text-on-surface group-hover:text-[#38B6FF]">arrow_back</span>
        </a>
        <div>
           
            <p class="font-body-regular text-body-regular text-on-surface-variant mt-1">
                Perbarui informasi kendaraan <strong>{{ $kendaraan->nomor_polisi }}</strong> pada jenis <strong>{{ $jenis_mobil->nama_jenis }}</strong>
            </p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-lg md:p-xl max-w-3xl">
        <form action="{{ route('posko.jenis-mobil.kendaraan.update', [$posko->id, $jenis_mobil->id, $kendaraan->id]) }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="space-y-lg"
              id="editVehicleForm">
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
                
            </div>

            <!-- Form Row: Nomor Polisi -->
            <div class="space-y-xs">
                <label class="font-h4 text-h4 text-on-surface" for="nomor_polisi">
                    Nomor Polisi <span class="text-error">*</span>
                </label>
                <input type="text" 
                       name="nomor_polisi" 
                       class="w-full px-md py-sm border border-outline-variant rounded-lg font-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all @error('nomor_polisi') border-error @enderror" 
                       id="nomor_polisi" 
                       placeholder="Contoh: B 1234 XYZ"
                       value="{{ old('nomor_polisi', $kendaraan->nomor_polisi) }}"
                       required>
                @error('nomor_polisi')
                <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">error</span>
                    {{ $message }}
                </p>
                @enderror
                <p class="font-caption text-caption text-on-surface-variant">Masukkan nomor polisi kendaraan sesuai dengan STNK.</p>
            </div>

            <!-- Form Row: Deskripsi -->
            <div class="space-y-xs">
                <label class="font-h4 text-h4 text-on-surface" for="deskripsi">
                    Deskripsi <span class="text-error">*</span>
                </label>
                <textarea name="deskripsi" 
                          class="w-full px-md py-sm border border-outline-variant rounded-lg font-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all @error('deskripsi') border-error @enderror" 
                          id="deskripsi" 
                          placeholder="Masukkan deskripsi kendaraan (contoh: spesifikasi, tahun pembuatan, dll)"
                          rows="4"
                          required>{{ old('deskripsi', $kendaraan->deskripsi) }}</textarea>
                @error('deskripsi')
                <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">error</span>
                    {{ $message }}
                </p>
                @enderror
                <p class="font-caption text-caption text-on-surface-variant">Deskripsikan kendaraan secara lengkap untuk memudahkan identifikasi.</p>
            </div>

            <!-- Form Row: Status -->
            

            <!-- Status Preview dengan Warna -->
           

            <!-- Gambar Saat Ini -->
            <div class="space-y-xs">
                <label class="font-h4 text-h4 text-on-surface">Gambar Saat Ini</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                    <div class="aspect-video md:aspect-square bg-surface-container border-2 border-outline-variant rounded-lg overflow-hidden">
                        @if ($kendaraan->gambar)
                        <img src="{{ asset('storage/' . $kendaraan->gambar) }}" 
                             class="w-full h-full object-cover" 
                             alt="Gambar {{ $kendaraan->nomor_polisi }}">
                        @else
                        <div class="flex flex-col items-center justify-center text-center p-sm w-full h-full">
                            <span class="material-symbols-outlined text-[48px] text-outline mb-xs">image_not_supported</span>
                            <p class="font-caption text-caption">Tidak ada gambar</p>
                        </div>
                        @endif
                    </div>
                    <div class="md:col-span-2">
                        <div class="bg-[#E6F6FF]/20 p-md rounded-lg border border-[#D1E9F6] h-full flex items-center">
                            <div class="flex items-start gap-sm">
                                <span class="material-symbols-outlined text-[#38B6FF]">info</span>
                                <div>
                                    <p class="font-body-regular text-body-regular text-on-surface">
                                        @if ($kendaraan->gambar)
                                        <strong>{{ basename($kendaraan->gambar) }}</strong>
                                        <br>
                                        <span class="font-small text-small text-on-surface-variant">Upload gambar baru untuk mengganti gambar saat ini.</span>
                                        @else
                                        <span class="text-on-surface-variant">Belum ada gambar yang diunggah untuk kendaraan ini.</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Row: Ganti Gambar -->
            <div class="space-y-xs">
                <label class="font-h4 text-h4 text-on-surface">Ganti Gambar</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                    <!-- Image Preview Placeholder -->
                    <div class="aspect-video md:aspect-square bg-surface-container border-2 border-dashed border-outline-variant rounded-lg flex flex-col items-center justify-center text-on-surface-variant overflow-hidden">
                        <div class="flex flex-col items-center justify-center text-center p-sm w-full h-full" id="preview-container">
                            <span class="material-symbols-outlined text-[48px] text-outline mb-xs">image</span>
                            <p class="font-caption text-caption">Preview Gambar Baru</p>
                        </div>
                    </div>
                    <!-- Upload Area -->
                    <div class="md:col-span-2 relative">
                        <label class="flex flex-col items-center justify-center w-full h-full min-h-[120px] border-2 border-dashed border-outline-variant rounded-lg bg-surface-bright cursor-pointer hover:bg-[#E6F6FF] transition-colors px-md text-center @error('gambar') border-error @enderror" for="car_image">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <span class="material-symbols-outlined text-[32px] text-[#38B6FF] mb-xs">cloud_upload</span>
                                <p class="font-h4 text-h4 text-[#38B6FF] font-bold">Pilih File</p>
                                <p class="font-caption text-caption text-on-surface-variant mt-xs">PNG, JPG atau WEBP (Maks. 2MB)</p>
                                @if ($kendaraan->gambar)
                                <p class="font-small text-small text-on-surface-variant mt-1">Kosongkan jika tidak ingin mengubah gambar</p>
                                @endif
                            </div>
                            <input name="gambar" accept="image/*" class="hidden" id="car_image" type="file">
                        </label>
                        @error('gambar')
                        <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">error</span>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan (Read-only) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter p-md bg-[#E6F6FF]/20 rounded-lg border border-[#D1E9F6]">
                <div>
                    <label class="block font-small text-small text-on-surface-variant">Tanggal Dibuat</label>
                    <p class="font-body-regular text-body-regular text-on-surface">{{ isset($kendaraan->created_at) ? $kendaraan->created_at->format('d M Y H:i') : '-' }}</p>
                </div>
                <div>
                    <label class="block font-small text-small text-on-surface-variant">Terakhir Diperbarui</label>
                    <p class="font-body-regular text-body-regular text-on-surface">{{ isset($kendaraan->updated_at) ? $kendaraan->updated_at->format('d M Y H:i') : '-' }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col md:flex-row items-center gap-md pt-lg border-t border-[#D1E9F6]">
                <a href="{{ route('posko.jenis-mobil.kendaraan.index', [$posko->id, $jenis_mobil->id]) }}" 
                   class="w-full md:w-auto px-xl py-3 rounded-lg border border-[#D1E9F6] text-on-surface-variant font-h4 text-h4 hover:bg-surface-container transition-colors text-center">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full md:w-auto px-xl py-3 rounded-lg bg-[#38B6FF] text-white font-h4 text-h4 hover:bg-[#0A8FD6] transition-colors shadow-md active:scale-[0.98] flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">save</span>
                    Update Kendaraan
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
                <p class="font-small text-small text-on-surface-variant">Pastikan data kendaraan diperbarui dengan benar.</p>
            </div>
        </div>
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">image</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Gambar Kendaraan</h4>
                <p class="font-small text-small text-on-surface-variant">Upload gambar baru untuk memperbarui tampilan kendaraan.</p>
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File Preview
    const fileInput = document.getElementById('car_image');
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

    // Form Submission
    const form = document.getElementById('editVehicleForm');
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

    // Preview status change
    
});
</script>
@endsection