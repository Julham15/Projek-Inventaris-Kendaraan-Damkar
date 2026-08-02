@extends('Pemantau.layouts.index')
@section('admin2')
<!-- ===== MAIN CONTENT ===== -->
<main class="lg:ml-5 p-lg max-w-5xl mx-auto space-y-xl">

    <!-- ===== HEADER ===== -->
    <div class="mb-xl p-lg bg-primary-container/10 border border-primary-container/30 rounded-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-h1 text-h1 text-primary mb-xs flex items-center gap-sm">
                    <span class="material-symbols-outlined text-3xl">account_circle</span>
                    Profil Saya
                </h1>
                <p class="font-body-regular text-body-regular text-on-surface-variant max-w-2xl">
                    Kelola informasi profil dan keamanan akun Anda.
                </p>
            </div>
           
        </div>
    </div>

    <!-- ===== PROFIL INFORMATION ===== -->
    <div class="bg-white rounded-xl border border-outline-variant custom-shadow overflow-hidden">
        <div class="p-lg border-b border-outline-variant">
            <h2 class="font-h2 text-h2 text-on-surface flex items-center gap-sm">
                
                Informasi Profile
            </h2>
            <p class="font-body-regular text-body-regular text-on-surface-variant mt-xs">
                Perbarui informasi profil dan alamat email Anda.
            </p>
        </div>

        <form method="post" 
              action="{{ route('profile.update') }}" 
              enctype="multipart/form-data" 
              class="p-lg space-y-lg">
            @csrf
            @method('patch')

            <!-- ===== FOTO PROFIL ===== -->
            <div class="flex flex-col items-center space-y-4 pb-lg border-b border-outline-variant/30">
                <div class="relative group">
                    @if($user->photo)
                        <img id="preview"
                             src="{{ asset('storage/profile/' . $user->photo) }}"
                             class="w-32 h-32 rounded-full object-cover border-4 border-primary/20 group-hover:border-primary/40 transition-all">
                    @else
                        <img id="preview"
                             src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128&background=006493&color=fff"
                             class="w-32 h-32 rounded-full object-cover border-4 border-primary/20 group-hover:border-primary/40 transition-all">
                    @endif
                    
                    <input id="photo"
                           name="photo"
                           type="file"
                           class="hidden"
                           accept="image/*">
                    
                    <label for="photo"
                           class="absolute bottom-0 right-0 bg-primary rounded-full p-2.5 border-2 border-white cursor-pointer hover:bg-primary/90 transition-all shadow-lg hover:scale-105">
                        <span class="material-symbols-outlined text-sm text-white">
                            camera_alt
                        </span>
                    </label>
                </div>
                <p class="font-caption text-caption text-on-surface-variant">
                    Klik ikon kamera untuk mengganti foto profil
                </p>
                @error('photo')
                    <p class="text-error text-small text-center">{{ $message }}</p>
                @enderror
            </div>

            <!-- ===== FORM FIELDS ===== -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
                <!-- Nama -->
                <div class="space-y-1">
                    <label for="name" class="font-small text-small text-on-surface-variant font-medium">
                        Nama Lengkap <span class="text-error">*</span>
                    </label>
                    <input id="name" 
                           name="name" 
                           type="text" 
                           class="w-full px-md py-sm bg-surface-container border border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                           value="{{ old('name', $user->name) }}" 
                           required autofocus autocomplete="name">
                    @error('name')
                        <p class="text-error text-small mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label for="email" class="font-small text-small text-on-surface-variant font-medium">
                        Alamat Email <span class="text-error">*</span>
                    </label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           class="w-full px-md py-sm bg-surface-container border border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                           value="{{ old('email', $user->email) }}" 
                           required autocomplete="username">
                    @error('email')
                        <p class="text-error text-small mt-1">{{ $message }}</p>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2 p-md bg-orange-50 border border-orange-200 rounded-lg">
                            <p class="text-small text-orange-700 flex items-center gap-xs">
                                <span class="material-symbols-outlined text-sm">warning</span>
                                Alamat email Anda belum diverifikasi.
                                <button form="send-verification" 
                                        class="underline text-orange-700 hover:text-orange-900 font-medium ml-xs">
                                    Kirim ulang verifikasi
                                </button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-1 text-small text-green-600 flex items-center gap-xs">
                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                    Link verifikasi baru telah dikirim.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Nomor HP -->
                <div class="space-y-1">
                    <label for="phone" class="font-small text-small text-on-surface-variant font-medium">
                        Nomor HP
                    </label>
                    <input id="phone"
                           name="phone"
                           type="text"
                           class="w-full px-md py-sm bg-surface-container border border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                           value="{{ old('phone', $user->phone) }}"
                           placeholder="08xxxxxxxxxx">
                    @error('phone')
                        <p class="text-error text-small mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jabatan (khusus admin2) -->
                @if(Auth::user()->role == 'admin2')
                <div class="space-y-1">
                    <label for="jabatan" class="font-small text-small text-on-surface-variant font-medium">
                        Jabatan
                    </label>
                    <input id="jabatan"
                           name="jabatan"
                           type="text"
                           class="w-full px-md py-sm bg-surface-container/50 border border-outline-variant rounded-lg text-on-surface/60 cursor-not-allowed"
                           value="{{ old('jabatan', $user->jabatan) }}"
                           readonly>
                    <p class="font-caption text-caption text-on-surface-variant/60 flex items-center gap-xs">
                        <span class="material-symbols-outlined text-sm">info</span>
                        Jabatan tidak dapat diubah
                    </p>
                    @error('jabatan')
                        <p class="text-error text-small mt-1">{{ $message }}</p>
                    @enderror
                </div>
                @endif
            </div>

            <!-- ===== BUTTON SAVE ===== -->
            <div class="flex items-center gap-md pt-lg border-t border-outline-variant/30">
                <button type="submit" 
                        class="inline-flex items-center gap-xs px-lg py-sm bg-primary text-white rounded-lg hover:bg-primary/90 transition-all font-body-regular shadow-sm hover:shadow-md">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Simpan Perubahan
                </button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }"
                       x-show="show"
                       x-transition
                       x-init="setTimeout(() => show = false, 3000)"
                       class="text-small text-green-600 flex items-center gap-xs">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                        Profil berhasil diperbarui!
                    </p>
                @endif
            </div>
        </form>
    </div>

    <!-- ===== UPDATE PASSWORD ===== -->
    <!-- Tambahkan ID password-section untuk di-scroll -->
    <div id="password-section" class="bg-white rounded-xl border border-outline-variant custom-shadow overflow-hidden scroll-mt-24">
        <div class="p-lg border-b border-outline-variant">
            <h2 class="font-h2 text-h2 text-on-surface flex items-center gap-sm">
                <span class="material-symbols-outlined text-error">lock</span>
                Perbarui Password
            </h2>
            <p class="font-body-regular text-body-regular text-on-surface-variant mt-xs">
                Pastikan akun Anda menggunakan password yang panjang dan aman.
            </p>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="p-lg space-y-lg">
            @csrf
            @method('put')

            <!-- TAMPILAN ERROR GLOBAL -->
            @if ($errors->updatePassword->any())
                <div class="bg-error/10 border border-error/20 rounded-lg p-md space-y-1 animate-shake">
                    <div class="flex items-start gap-sm">
                        <span class="material-symbols-outlined text-error text-sm mt-0.5">error</span>
                        <div>
                            <p class="font-medium text-error text-small">Terjadi kesalahan:</p>
                            <ul class="text-error/80 text-small list-disc list-inside space-y-0.5">
                                @foreach ($errors->updatePassword->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
                <!-- Current Password -->
                <div class="space-y-1">
                    <label for="update_password_current_password" class="font-small text-small text-on-surface-variant font-medium">
                        Password Saat Ini <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <input id="update_password_current_password" 
                               name="current_password" 
                               type="password" 
                               class="w-full px-md py-sm bg-surface-container border rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all
                                      @error('current_password', 'updatePassword') border-error ring-2 ring-error/20 @enderror"
                               autocomplete="current-password"
                               placeholder="Masukkan password saat ini">
                        
                    </div>
                    @error('current_password', 'updatePassword')
                        <div class="flex items-start gap-1 mt-1">
                            <span class="material-symbols-outlined text-error text-sm mt-0.5">error</span>
                            <p class="text-error text-small">{{ $message }}</p>
                        </div>
                    @enderror
                    @if(session('error'))
                        <div class="flex items-start gap-1 mt-1">
                            <span class="material-symbols-outlined text-error text-sm mt-0.5">error</span>
                            <p class="text-error text-small">{{ session('error') }}</p>
                        </div>
                    @endif
                </div>

                <!-- New Password -->
                <div class="space-y-1">
                    <label for="update_password_password" class="font-small text-small text-on-surface-variant font-medium">
                        Password Baru <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <input id="update_password_password" 
                               name="password" 
                               type="password" 
                               class="w-full px-md py-sm bg-surface-container border rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all
                                      @error('password', 'updatePassword') border-error ring-2 ring-error/20 @enderror"
                               autocomplete="new-password"
                               placeholder="Minimal 8 karakter">
                      
                    </div>
                    @error('password', 'updatePassword')
                        <div class="flex items-start gap-1 mt-1">
                            <span class="material-symbols-outlined text-error text-sm mt-0.5">error</span>
                            <p class="text-error text-small">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1 md:col-span-2">
                    <label for="update_password_password_confirmation" class="font-small text-small text-on-surface-variant font-medium">
                        Konfirmasi Password Baru <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <input id="update_password_password_confirmation" 
                               name="password_confirmation" 
                               type="password" 
                               class="w-full px-md py-sm bg-surface-container border rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all
                                      @error('password_confirmation', 'updatePassword') border-error ring-2 ring-error/20 @enderror"
                               autocomplete="new-password"
                               placeholder="Konfirmasi password baru">
                       
                    </div>
                    @error('password_confirmation', 'updatePassword')
                        <div class="flex items-start gap-1 mt-1">
                            <span class="material-symbols-outlined text-error text-sm mt-0.5">error</span>
                            <p class="text-error text-small">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Password Strength Indicator -->
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <div class="flex-1 h-1.5 bg-surface-container rounded-full overflow-hidden">
                        <div id="password-strength" class="h-full bg-error rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                    <span id="password-text" class="text-caption text-on-surface-variant/60 min-w-[60px]">Lemah</span>
                </div>
            </div>

            <!-- ===== BUTTON UPDATE PASSWORD ===== -->
            <div class="flex items-center gap-md pt-lg border-t border-outline-variant/30">
                <button type="submit" 
                        class="inline-flex items-center gap-xs px-lg py-sm bg-error text-white rounded-lg hover:bg-error/90 transition-all font-body-regular shadow-sm hover:shadow-md">
                    <span class="material-symbols-outlined text-sm">lock_reset</span>
                    Perbarui Password
                </button>

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }"
                       x-show="show"
                       x-transition
                       x-init="setTimeout(() => show = false, 3000)"
                       class="text-small text-green-600 flex items-center gap-xs">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                        Password berhasil diperbarui!
                    </p>
                @endif
            </div>
        </form>
    </div>

    <!-- Script untuk toggle password visibility -->


</main>

<!-- ===== SCRIPT PREVIEW FOTO ===== -->
<script>
    document.getElementById('photo')?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('preview').src = event.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
   
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('.material-symbols-outlined');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }

    // Password strength indicator
    document.getElementById('update_password_password')?.addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.getElementById('password-strength');
        const strengthText = document.getElementById('password-text');
        
        let strength = 0;
        let text = 'Lemah';
        let color = 'bg-error';
        
        if (password.length >= 8) strength += 25;
        if (/[a-z]/.test(password)) strength += 25;
        if (/[A-Z]/.test(password)) strength += 25;
        if (/[0-9]/.test(password)) strength += 12.5;
        if (/[^a-zA-Z0-9]/.test(password)) strength += 12.5;
        
        if (strength >= 75) {
            text = 'Kuat';
            color = 'bg-success';
        } else if (strength >= 50) {
            text = 'Sedang';
            color = 'bg-warning';
        } else if (strength >= 25) {
            text = 'Lemah';
            color = 'bg-error';
        } else {
            text = 'Sangat Lemah';
            color = 'bg-error';
        }
        
        strengthBar.style.width = strength + '%';
        strengthBar.className = 'h-full rounded-full transition-all duration-500 ' + color;
        strengthText.textContent = text;
        strengthText.className = 'text-caption min-w-[60px] text-' + (color === 'bg-success' ? 'success' : color === 'bg-warning' ? 'warning' : 'error');
    });

    // ===== SCROLL TO PASSWORD SECTION IF ERROR =====
    @if ($errors->updatePassword->any())
        document.addEventListener('DOMContentLoaded', function() {
            // Scroll ke section password
            const passwordSection = document.getElementById('password-section');
            if (passwordSection) {
                // Tambahkan offset untuk navbar
                const offset = 100;
                const elementPosition = passwordSection.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - offset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                // Highlight section dengan efek ring
                passwordSection.classList.add('ring-2', 'ring-error/50', 'shadow-lg', 'transition-all', 'duration-300');
                setTimeout(() => {
                    passwordSection.classList.remove('ring-2', 'ring-error/50', 'shadow-lg');
                }, 3000);
            }
            
            // Fokus ke input pertama yang error
            const firstErrorInput = document.querySelector('.border-error');
            if (firstErrorInput) {
                setTimeout(() => {
                    firstErrorInput.focus();
                    firstErrorInput.classList.add('ring-2', 'ring-error/50');
                }, 800);
            }
        });
    @endif
</script>

<!-- ===== FORM VERIFIKASI EMAIL ===== -->
<form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
    @csrf
</form>

<!-- ===== STYLE TAMBAHAN ===== -->
<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .animate-shake {
        animation: shake 0.3s ease-in-out;
    }
    .scroll-mt-24 {
        scroll-margin-top: 6rem;
    }
</style>

@endsection