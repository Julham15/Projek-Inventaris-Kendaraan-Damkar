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
        <span class="font-h2 text-h2 font-bold text-primary">Edit Pos</span>
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
        <a href="/posko" 
           class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-[#E6F6FF] transition-colors active:scale-90 group">
            <span class="material-symbols-outlined text-on-surface group-hover:text-[#38B6FF]">arrow_back</span>
        </a>
        <div>
          
            <p class="font-body-regular text-body-regular text-on-surface-variant mt-1">Perbarui informasi posko pemadam kebakaran.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-lg md:p-xl max-w-3xl">
        <form action="{{ route('posko.update', $posko) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Field: Nama Posko -->
            <div class="space-y-xs mb-lg">
                <label class="block font-h4 text-h4 text-on-surface" for="nama_posko">
                    Nama Pos <span class="text-error">*</span>
                </label>
                <div class="relative">
                    <input class="w-full bg-white border border-outline-variant rounded-lg py-3 px-md focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all text-body-regular placeholder:text-outline/50 @error('nama_posko') border-error @enderror" 
                           id="nama_posko" 
                           placeholder="Masukkan nama posko" 
                           type="text" 
                           name="nama_posko"
                           value="{{ old('nama_posko', $posko->nama_posko ?? '') }}"
                           required>
                    @error('nama_posko')
                    <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">error</span>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>

            <!-- Field: Alamat -->
            <div class="space-y-xs mb-lg">
                <label class="block font-h4 text-h4 text-on-surface" for="alamat">
                    Alamat <span class="text-error">*</span>
                </label>
                <div class="relative">
                    <textarea class="w-full bg-white border border-outline-variant rounded-lg py-3 px-md focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all text-body-regular placeholder:text-outline/50 @error('alamat') border-error @enderror" 
                              id="alamat" 
                              placeholder="Masukkan alamat lengkap posko" 
                              rows="4" 
                              name="alamat">{{ old('alamat', $posko->alamat ?? '') }}</textarea>
                    @error('alamat')
                    <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">error</span>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>

          

            <!-- Action Buttons -->
            <div class="flex flex-col md:flex-row items-center gap-md justify-end pt-lg border-t border-[#D1E9F6] mt-xl">
                <a href="{{ route('posko.index') }}" 
                   class="w-full md:w-auto px-xl py-3 rounded-lg border border-[#D1E9F6] text-on-surface-variant font-h4 text-h4 hover:bg-surface-container transition-colors text-center">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full md:w-auto px-xl py-3 rounded-lg bg-[#38B6FF] text-white font-h4 text-h4 hover:bg-[#0A8FD6] transition-colors shadow-md active:scale-[0.98] flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">save</span>
                    Update Pos
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
                <p class="font-small text-small text-on-surface-variant">Pastikan data posko diperbarui dengan benar.</p>
            </div>
        </div>
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">history</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Riwayat Perubahan</h4>
                <p class="font-small text-small text-on-surface-variant">Semua perubahan akan tercatat dalam sistem.</p>
            </div>
        </div>
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">verified_user</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Verifikasi</h4>
                <p class="font-small text-small text-on-surface-variant">Data akan diverifikasi sebelum disimpan.</p>
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

/* Transisi untuk tombol */
button {
    transition: all 0.2s ease-in-out;
}

/* Hover effect untuk card info */
.bg-\[\#E6F6FF\]\/20:hover {
    background-color: rgba(230, 246, 255, 0.4);
    transition: background-color 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission handling
    const form = document.querySelector('form');
    const updateBtn = form ? form.querySelector('button[type="submit"]') : null;
    
    if (form && updateBtn) {
        form.addEventListener('submit', function(e) {
            // Tampilkan loading state
            const originalContent = updateBtn.innerHTML;
            updateBtn.disabled = true;
            updateBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
            `;
            updateBtn.classList.add('opacity-70', 'cursor-not-allowed');
            
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