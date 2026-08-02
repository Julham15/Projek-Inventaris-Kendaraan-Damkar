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
        <span class="font-h2 text-h2 font-bold text-primary">Tambah Pemantau</span>
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
    <!-- Header Section with Back Button -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-lg">
        <div>
            <h1 class="font-h1 text-h1 text-on-background">Tambah Pemantau</h1>
            <p class="font-body-regular text-body-regular text-on-surface-variant mt-1">Tambahkan pemantau baru untuk memonitor laporan kejadian.</p>
        </div>
        <a href="{{ route('pengguna.index') }}" 
           class="flex items-center gap-1 text-secondary hover:text-primary transition-colors font-medium text-body-regular">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            Kembali
        </a>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-[#D1E9F6] p-lg md:p-xl relative overflow-hidden">
        <!-- Atmospheric background element -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-[#38B6FF]/10 rounded-full -mr-16 -mt-16 blur-3xl"></div>
        
        <form action="{{ route('pengguna.storePemantau') }}" method="POST" class="space-y-gutter relative z-10">
            @csrf
            
            <!-- Name & Email Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
                <div class="space-y-xs">
                    <label class="font-h4 text-h4 text-on-surface" for="name">Nama Lengkap <span class="text-error">*</span></label>
                    <input type="text" 
                           id="name"
                           class="w-full p-md border border-outline-variant rounded-lg font-body-regular text-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all @error('name') border-error @enderror" 
                           placeholder="Nama lengkap pemantau" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required>
                    @error('name')
                    <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">error</span>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                
                <div class="space-y-xs">
                    <label class="font-h4 text-h4 text-on-surface" for="email">Email <span class="text-error">*</span></label>
                    <div class="relative">
                        <input type="email" 
                               id="email"
                               class="w-full p-md border rounded-lg font-body-regular text-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all @error('email') border-error bg-error-container/10 @else border-outline-variant @enderror" 
                               placeholder="Alamat email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required>
                        @error('email')
                        <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">error</span>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Phone & Role Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
                <div class="space-y-xs">
                    <label class="font-h4 text-h4 text-on-surface" for="phone">Nomor HP <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="absolute left-md top-1/2 -translate-y-1/2 text-on-surface-variant font-body-regular">+62</span>
                        <input type="text" 
                               id="phone"
                               class="w-full p-md pl-[54px] border border-outline-variant rounded-lg font-body-regular text-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all @error('phone') border-error @enderror" 
                               placeholder="Nomor telepon" 
                               name="phone" 
                               value="{{ old('phone') }}">
                        @error('phone')
                        <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">error</span>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
                
                <div class="space-y-xs">
                    <label class="font-h4 text-h4 text-on-surface" for="jabatan">Jabatan <span class="text-error">*</span></label>
                    <select name="jabatan" 
                            id="jabatan"
                            class="w-full p-md border border-outline-variant rounded-lg font-body-regular text-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all appearance-none bg-white @error('jabatan') border-error @enderror" 
                            required>
                        <option disabled selected value="">Pilih Jabatan</option>
                        <option value="Kepala Dinas" {{ old('jabatan') == 'Kepala Dinas' ? 'selected' : '' }}>Kepala Dinas</option>
                        <option value="Sekretaris" {{ old('jabatan') == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                        <option value="Kepala Bidang" {{ old('jabatan') == 'Kepala Bidang' ? 'selected' : '' }}>Kepala Bidang</option>
                        <option value="Kepala Seksi" {{ old('jabatan') == 'Kepala Seksi' ? 'selected' : '' }}>Kepala Seksi</option>
                    </select>
                    @error('jabatan')
                    <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">error</span>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>

            <!-- Password Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
                <div class="space-y-xs">
                    <label class="font-h4 text-h4 text-on-surface" for="password">Password <span class="text-error">*</span></label>
                    <div class="relative">
                        <input type="password" 
                               id="password"
                               class="w-full p-md border border-outline-variant rounded-lg font-body-regular text-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all pr-xl @error('password') border-error @enderror" 
                               placeholder="Kata sandi (min 8 karakter)" 
                               name="password" 
                               required>
                        <button type="button" 
                                class="absolute right-md top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors toggle-password z-10"
                                onclick="togglePasswordVisibility('password')">
                            <span class="material-symbols-outlined" id="password-icon">visibility</span>
                        </button>
                        @error('password')
                        <p class="text-error font-small text-small mt-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">error</span>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
                
                <div class="space-y-xs">
                    <label class="font-h4 text-h4 text-on-surface" for="password_confirmation">Konfirmasi Password <span class="text-error">*</span></label>
                    <div class="relative">
                        <input type="password" 
                               id="password_confirmation"
                               class="w-full p-md border border-outline-variant rounded-lg font-body-regular text-body-regular focus:ring-2 focus:ring-[#38B6FF] focus:border-transparent transition-all pr-xl" 
                               placeholder="Ulangi kata sandi" 
                               name="password_confirmation" 
                               required>
                        <button type="button" 
                                class="absolute right-md top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors toggle-password z-10"
                                onclick="togglePasswordVisibility('password_confirmation')">
                            <span class="material-symbols-outlined" id="password_confirmation-icon">visibility</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Password Strength Indicator -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
                <div class="space-y-xs">
                    <div class="flex gap-1 mt-1" id="password-strength">
                        <div class="h-1 flex-1 bg-outline-variant rounded-full"></div>
                        <div class="h-1 flex-1 bg-outline-variant rounded-full"></div>
                        <div class="h-1 flex-1 bg-outline-variant rounded-full"></div>
                        <div class="h-1 flex-1 bg-outline-variant rounded-full"></div>
                    </div>
                    <p class="font-small text-small text-on-surface-variant" id="password-text">Minimal 8 karakter</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-xl flex flex-col md:flex-row items-center gap-md justify-end border-t border-[#D1E9F6] mt-xl">
                <a href="{{ route('pengguna.index') }}" 
                   class="w-full md:w-auto px-xl py-3 rounded-lg border border-[#D1E9F6] text-on-surface-variant font-h4 text-h4 hover:bg-surface-container transition-colors text-center">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full md:w-auto px-xl py-3 rounded-lg bg-[#38B6FF] text-white font-h4 text-h4 hover:bg-[#0A8FD6] transition-colors shadow-md active:scale-[0.98] flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Simpan Pemantau
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Information Cards -->
    <div class="mt-xl grid grid-cols-1 md:grid-cols-3 gap-gutter">
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">info</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Privasi Akun</h4>
                <p class="font-small text-small text-on-surface-variant">Password minimal 8 karakter dengan kombinasi angka dan huruf.</p>
            </div>
        </div>
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">security</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Akses Data</h4>
                <p class="font-small text-small text-on-surface-variant">Pemantau akan memiliki akses ke seluruh laporan kejadian aktif.</p>
            </div>
        </div>
        <div class="bg-[#E6F6FF]/20 p-md rounded-lg flex items-start gap-md border border-[#D1E9F6]">
            <span class="material-symbols-outlined text-[#38B6FF]" style="font-variation-settings: 'FILL' 1;">verified_user</span>
            <div>
                <h4 class="font-h4 text-h4 text-on-secondary-fixed">Verifikasi</h4>
                <p class="font-small text-small text-on-surface-variant">Email verifikasi akan dikirimkan otomatis setelah pendaftaran.</p>
            </div>
        </div>
    </div>
</div>
</main>

<style>
/* ============================================
   MENYEMBUNYIKAN ICON MATA AUTOFILL BROWSER
   ============================================ */

/* Chrome, Safari, Edge */
input[type="password"]::-webkit-credentials-auto-fill-button,
input[type="password"]::-webkit-credentials-auto-fill-button:focus,
input[type="password"]::-webkit-credentials-auto-fill-button:active,
input[type="password"]::-webkit-credentials-auto-fill-button:hover {
    display: none !important;
    opacity: 0 !important;
    pointer-events: none !important;
    visibility: hidden !important;
    width: 0 !important;
    height: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
}

/* Firefox */
input[type="password"]::-moz-credentials-auto-fill-button {
    display: none !important;
}

/* Internet Explorer / Edge Legacy */
input[type="password"]::-ms-clear,
input[type="password"]::-ms-reveal {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
}

/* Mengatasi autofill background */
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px white inset !important;
    box-shadow: 0 0 0 30px white inset !important;
    -webkit-text-fill-color: #1a1a1a !important;
}

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

.bg-error-container\/10 {
    background-color: rgba(220, 38, 38, 0.1);
}
</style>

<script>
// Toggle Password Visibility
function togglePasswordVisibility(fieldId) {
    const input = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (!input || !icon) return;
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility';
    }
}

// Password Strength Indicator
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const strengthBars = document.querySelectorAll('#password-strength .flex-1');
    const strengthText = document.getElementById('password-text');
    
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (/\d/.test(password)) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
            
            const maxStrength = 5;
            const strengthLevel = Math.min(strength, maxStrength);
            
            strengthBars.forEach((bar, index) => {
                bar.classList.remove('bg-red-500', 'bg-yellow-500', 'bg-green-500', 'bg-outline-variant');
                if (index < strengthLevel) {
                    if (strengthLevel <= 2) {
                        bar.classList.add('bg-red-500');
                    } else if (strengthLevel <= 3) {
                        bar.classList.add('bg-yellow-500');
                    } else {
                        bar.classList.add('bg-green-500');
                    }
                } else {
                    bar.classList.add('bg-outline-variant');
                }
            });
            
            if (password.length === 0) {
                strengthText.textContent = 'Minimal 8 karakter';
                strengthText.className = 'font-small text-small text-on-surface-variant';
            } else if (strengthLevel <= 2) {
                strengthText.textContent = 'Password lemah';
                strengthText.className = 'font-small text-small text-red-500';
            } else if (strengthLevel <= 3) {
                strengthText.textContent = 'Password sedang';
                strengthText.className = 'font-small text-small text-yellow-500';
            } else {
                strengthText.textContent = 'Password kuat';
                strengthText.className = 'font-small text-small text-green-500';
            }
        });
    }
});
</script>
@endsection