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
        <span class="font-h2 text-h2 font-bold text-primary">Tambah Pos</span>
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
           class="w-5 h-5 rounded-full flex items-center justify-center hover:bg-[#E6F6FF] transition-colors active:scale-50 group">
            <span class="material-symbols-outlined text-on-surface group-hover:text-[#38B6FF]">arrow_back</span>
        </a>
        <div>
            
            <p class="font-body-regular text-body-regular text-on-surface-variant mt-1">Tambahkan posko pemadam kebakaran baru ke dalam sistem.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-lg md:p-xl max-w-3xl">
        <form action="{{ route('posko.store') }}" method="POST" class="space-y-lg">
            @csrf
            
            <!-- Field: Nama Posko -->
            <div class="space-y-xs">
                <label class="block font-h4 text-h4 text-on-surface" for="nama_posko">
                    Nama Pos <span class="text-error">*</span>
                </label>
                <div class="relative">
                    <input class="w-full bg-white border border-outline-variant rounded-lg py-3 px-md focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all text-body-regular placeholder:text-outline/50 @error('nama_posko') border-error @enderror" 
                           id="nama_posko" 
                           placeholder="Masukkan nama posko" 
                           type="text" 
                           name="nama_posko"
                           value="{{ old('nama_posko') }}"
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
            <div class="space-y-xs">
                <label class="block font-h4 text-h4 text-on-surface" for="alamat">
                    Alamat <span class="text-error">*</span>
                </label>
                <div class="relative">
                    <textarea class="w-full bg-white border border-outline-variant rounded-lg py-3 px-md focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all text-body-regular placeholder:text-outline/50 @error('alamat') border-error @enderror" 
                              id="alamat" 
                              placeholder="Masukkan alamat lengkap posko" 
                              rows="4" 
                              name="alamat">{{ old('alamat') }}</textarea>
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
                    Simpan Posko
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Information Cards -->
    <div class="mt-xl grid grid-cols-1 md:grid-cols-3 gap-gutter max-w-3xl">
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">info</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Data Posko</h4>
                <p class="font-small text-small text-on-surface-variant">Pastikan data posko diisi dengan benar dan lengkap.</p>
            </div>
        </div>
      
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">verified_user</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Verifikasi</h4>
                <p class="font-small text-small text-on-surface-variant">Data posko akan diverifikasi oleh admin sebelum aktif.</p>
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

/* Animasi untuk tombol */
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission handling
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const saveBtn = this.querySelector('button[type="submit"]');
            const originalContent = saveBtn.innerHTML;
            
            // Disable button and show loading state
            saveBtn.disabled = true;
            saveBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
            `;
            saveBtn.classList.add('opacity-70', 'cursor-not-allowed');

            // Re-enable after 3 seconds (for demo purposes)
            // In production, this will be handled by the server response
            setTimeout(() => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalContent;
                saveBtn.classList.remove('opacity-70', 'cursor-not-allowed');
            }, 3000);
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