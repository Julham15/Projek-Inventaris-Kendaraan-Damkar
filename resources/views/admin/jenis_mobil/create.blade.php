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
        <span class="font-h2 text-h2 font-bold text-primary">Tambah Jenis Mobil</span>
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
        <a href="{{ route('posko.jenis-mobil.index', $posko->id) }}" 
           class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-[#E6F6FF] transition-colors active:scale-90 group">
            <span class="material-symbols-outlined text-on-surface group-hover:text-[#38B6FF]">arrow_back</span>
        </a>
        <div>
            <h1 class="font-h1 text-h1 text-on-background">Tambah Jenis Mobil</h1>
            <p class="font-body-regular text-body-regular text-on-surface-variant mt-1">Silakan lengkapi formulir di bawah ini untuk menambahkan kategori armada baru ke dalam sistem.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-lg md:p-xl max-w-3xl">
        <form action="{{ route('posko.jenis-mobil.store', $posko) }}" method="POST" enctype="multipart/form-data" class="space-y-lg" id="addVehicleForm">
            @csrf
            
            <!-- Form Row: Nama Jenis Mobil -->
            <div class="space-y-xs">
                <label class="font-h4 text-h4 text-on-surface" for="nama_jenis">
                    Nama Jenis Mobil <span class="text-error">*</span>
                </label>
                <input type="text" 
                       name="nama_jenis" 
                       class="w-full px-md py-sm border border-outline-variant rounded-lg font-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all @error('nama_jenis') border-error @enderror" 
                       id="nama_jenis" 
                       placeholder="Contoh: Fire Truck Pumper, Water Tender"
                       value="{{ old('nama_jenis') }}"
                       required>
                @error('nama_jenis')
                <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">error</span>
                    {{ $message }}
                </p>
                @enderror
                <p class="font-caption text-caption text-on-surface-variant">Gunakan nama yang umum digunakan dalam operasional pemadam kebakaran.</p>
            </div>

            <!-- Form Row: Gambar Upload -->
            <div class="space-y-xs">
                <label class="font-h4 text-h4 text-on-surface">Gambar Kendaraan</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                    <!-- Image Preview Placeholder -->
                    <div class="aspect-video md:aspect-square bg-surface-container border-2 border-dashed border-outline-variant rounded-lg flex flex-col items-center justify-center text-on-surface-variant overflow-hidden">
                        <div class="flex flex-col items-center justify-center text-center p-sm w-full h-full" id="preview-container">
                            <span class="material-symbols-outlined text-[48px] text-outline mb-xs">image</span>
                            <p class="font-caption text-caption">Preview Gambar</p>
                        </div>
                    </div>
                    <!-- Upload Area -->
                    <div class="md:col-span-2 relative">
                        <label class="flex flex-col items-center justify-center w-full h-full min-h-[120px] border-2 border-dashed border-outline-variant rounded-lg bg-surface-bright cursor-pointer hover:bg-[#E6F6FF] transition-colors px-md text-center @error('gambar') border-error @enderror" for="car_image">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <span class="material-symbols-outlined text-[32px] text-[#38B6FF] mb-xs">cloud_upload</span>
                                <p class="font-h4 text-h4 text-[#38B6FF] font-bold">Pilih File</p>
                                <p class="font-caption text-caption text-on-surface-variant mt-xs">PNG, JPG atau WEBP (Maks. 2MB)</p>
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

            <!-- Additional Context Section -->
            <div class="bg-[#E6F6FF]/20 p-md rounded-lg border border-[#D1E9F6]">
                <div class="flex gap-sm">
                    <span class="material-symbols-outlined text-[#38B6FF]">info</span>
                    <div>
                        <p class="font-h4 text-h4 font-bold text-on-surface">Informasi Tambahan</p>
                        <p class="font-body-regular text-on-surface-variant">Pastikan gambar yang diunggah memiliki resolusi minimal 800x600 piksel untuk tampilan terbaik di aplikasi lapangan.</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col md:flex-row items-center gap-md pt-lg border-t border-[#D1E9F6]">
                <a href="{{ route('posko.jenis-mobil.index', $posko->id) }}" 
                   class="w-full md:w-auto px-xl py-3 rounded-lg border border-[#D1E9F6] text-on-surface-variant font-h4 text-h4 hover:bg-surface-container transition-colors text-center">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full md:w-auto px-xl py-3 rounded-lg bg-[#38B6FF] text-white font-h4 text-h4 hover:bg-[#0A8FD6] transition-colors shadow-md active:scale-[0.98] flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">save</span>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Information Cards -->
    <div class="mt-xl grid grid-cols-1 md:grid-cols-3 gap-gutter max-w-3xl">
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">info</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Kategori Armada</h4>
                <p class="font-small text-small text-on-surface-variant">Jenis mobil akan digunakan untuk mengelompokkan kendaraan.</p>
            </div>
        </div>
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">image</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Gambar Ilustrasi</h4>
                <p class="font-small text-small text-on-surface-variant">Gambar akan membantu identifikasi jenis mobil.</p>
            </div>
        </div>
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">verified_user</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Verifikasi</h4>
                <p class="font-small text-small text-on-surface-variant">Data akan diverifikasi sebelum digunakan.</p>
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
    const form = document.getElementById('addVehicleForm');
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
                Memproses...
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