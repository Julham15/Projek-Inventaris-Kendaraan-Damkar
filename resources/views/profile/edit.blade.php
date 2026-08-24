@extends('user.layouts.index')
@section('user')
    <!-- Main Content - Mobile First -->
    <main class="px-3 py-3 pb-24 max-w-full space-y-4 sm:px-4 sm:py-4 md:px-6 lg:ml-64 lg:max-w-7xl lg:mx-auto lg:space-y-6">
        <!-- Header -->
        <section class="mt-1 mb-3 flex flex-col items-start gap-1 sm:mt-2 sm:mb-4">
            <div class="w-full">
                <h1 class="text-xl font-bold text-primary sm:text-2xl md:text-3xl lg:text-h1">Profil Saya</h1>
                <p class="text-xs text-on-surface-variant mt-0.5 sm:text-sm md:text-base lg:text-body-regular">Kelola informasi profil dan keamanan akun Anda.</p>
            </div>
        </section>

        <!-- Profile Information -->
        <section>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-3 space-y-3 hover:shadow-lg transition-shadow duration-300 sm:p-4 md:p-6 lg:p-8 lg:space-y-5">
                <header class="space-y-0.5">
                    <h2 class="text-base font-semibold text-on-surface flex items-center gap-1.5 sm:text-lg md:text-xl lg:text-h2">
                        <span class="material-symbols-outlined text-primary text-lg sm:text-xl md:text-2xl">person</span>
                        Informasi Profil
                    </h2>
                    <p class="text-xs text-on-surface-variant sm:text-sm md:text-base lg:text-body-regular">Perbarui informasi profil dan alamat email Anda.</p>
                </header>

                <form method="post"
                      action="{{ route('profile.update') }}"
                      enctype="multipart/form-data"
                      class="space-y-3 sm:space-y-4 md:space-y-5 lg:space-y-6">
                    @csrf
                    @method('patch')

                    <!-- Foto Profil - Mobile Optimized -->
                    <div class="flex flex-col items-center space-y-2">
                        <div class="relative group">
                            @if($user->photo)
                                <img id="preview"
                                     src="{{ asset('storage/profile/' . $user->photo) }}"
                                     class="w-20 h-20 rounded-full object-cover border-4 border-primary/20 group-hover:border-primary/40 transition-all duration-300 group-hover:scale-105 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32">
                            @else
                                <img id="preview"
                                     src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128&background=0D9488&color=fff"
                                     class="w-20 h-20 rounded-full object-cover border-4 border-primary/20 group-hover:border-primary/40 transition-all duration-300 group-hover:scale-105 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32">
                            @endif
                            
                            <input id="photo"
                                   name="photo"
                                   type="file"
                                   class="hidden"
                                   accept="image/*">

                            <label for="photo"
                                   class="absolute bottom-0 right-0 bg-primary rounded-full p-1.5 border-2 border-surface-container-lowest cursor-pointer hover:bg-primary-hover hover:scale-110 transition-all duration-300 shadow-lg hover:shadow-xl sm:p-2">
                                <span class="material-symbols-outlined text-xs text-on-primary sm:text-sm md:text-base">
                                    camera_alt
                                </span>
                            </label>
                        </div>
                        <p class="text-[10px] text-on-surface-variant/60 text-center sm:text-xs md:text-sm">Klik ikon kamera untuk mengganti foto</p>
                    </div>

                    <!-- Nama - Mobile Optimized -->
                    <div class="space-y-0.5 group">
                        <label for="name" class="block text-xs font-medium text-on-surface-variant group-focus-within:text-primary transition-colors duration-300 sm:text-sm">
                            <span class="material-symbols-outlined text-xs align-middle mr-1 sm:text-sm">badge</span>
                            Nama Lengkap
                        </label>
                        <input id="name" 
                               name="name" 
                               type="text" 
                               class="w-full px-3 py-2 bg-surface-container border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 hover:border-primary/50 text-sm sm:text-base sm:px-4 sm:py-2.5" 
                               value="{{ old('name', $user->name) }}" 
                               required autofocus autocomplete="name">
                        <x-input-error class="mt-0.5 text-error text-[10px] sm:text-xs" :messages="$errors->get('name')" />
                    </div>

                    <!-- Email - Mobile Optimized -->
                    <div class="space-y-0.5 group">
                        <label for="email" class="block text-xs font-medium text-on-surface-variant group-focus-within:text-primary transition-colors duration-300 sm:text-sm">
                            <span class="material-symbols-outlined text-xs align-middle mr-1 sm:text-sm">email</span>
                            Alamat Email
                        </label>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               class="w-full px-3 py-2 bg-surface-container border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 hover:border-primary/50 text-sm sm:text-base sm:px-4 sm:py-2.5" 
                               value="{{ old('email', $user->email) }}" 
                               required autocomplete="username">
                        <x-input-error class="mt-0.5 text-error text-[10px] sm:text-xs" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-1.5 p-2 bg-warning/10 border border-warning/20 rounded-lg hover:bg-warning/20 transition-colors duration-300 sm:p-2.5 md:p-3">
                                <p class="text-[10px] text-warning flex items-center gap-1.5 sm:text-xs md:text-sm">
                                    <span class="material-symbols-outlined text-sm">warning</span>
                                    <span class="flex-1">Email belum diverifikasi.</span>
                                    <button form="send-verification" 
                                            class="underline text-warning hover:text-warning-hover hover:no-underline font-medium transition-all duration-300 text-[10px] sm:text-xs md:text-sm whitespace-nowrap">
                                        Kirim ulang
                                    </button>
                                </p>
                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-0.5 text-[10px] text-success flex items-center gap-0.5 sm:text-xs">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                        Link verifikasi baru telah dikirim.
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Nomor HP - Mobile Optimized -->
                    <div class="space-y-0.5 group">
                        <label for="phone" class="block text-xs font-medium text-on-surface-variant group-focus-within:text-primary transition-colors duration-300 sm:text-sm">
                            <span class="material-symbols-outlined text-xs align-middle mr-1 sm:text-sm">phone</span>
                            Nomor HP
                        </label>
                        <input id="phone"
                               name="phone"
                               type="text"
                               class="w-full px-3 py-2 bg-surface-container border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 hover:border-primary/50 text-sm sm:text-base sm:px-4 sm:py-2.5"
                               value="{{ old('phone', $user->phone) }}">
                        <x-input-error class="mt-0.5 text-error text-[10px] sm:text-xs" :messages="$errors->get('phone')" />
                    </div>

                    <!-- Jabatan (khusus admin2) - Mobile Optimized -->
                    @if(Auth::user()->role == 'admin2')
                        <div class="space-y-0.5">
                            <label for="jabatan" class="block text-xs font-medium text-on-surface-variant sm:text-sm">
                                <span class="material-symbols-outlined text-xs align-middle mr-1 sm:text-sm">work</span>
                                Jabatan
                            </label>
                            <input id="jabatan"
                                   name="jabatan"
                                   type="text"
                                   class="w-full px-3 py-2 bg-surface-container/50 border-2 border-outline-variant rounded-lg text-on-surface/60 cursor-not-allowed text-sm sm:text-base sm:px-4 sm:py-2.5"
                                   value="{{ old('jabatan', $user->jabatan) }}"
                                   readonly>
                            <p class="text-[10px] text-on-surface-variant/60 flex items-center gap-0.5 sm:text-xs">
                                <span class="material-symbols-outlined text-sm">info</span>
                                Jabatan tidak dapat diubah
                            </p>
                            <x-input-error class="mt-0.5 text-error text-[10px] sm:text-xs" :messages="$errors->get('jabatan')" />
                        </div>
                    @endif

                    <!-- Tombol Simpan - Mobile Optimized -->
                    <div class="flex flex-col items-stretch gap-2 pt-2 border-t-2 border-outline-variant/30 sm:flex-row sm:items-center sm:gap-3 sm:pt-3 md:pt-4">
                        <button type="submit" 
                                class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-primary text-on-primary rounded-lg hover:bg-primary-hover hover:scale-105 hover:shadow-lg transition-all duration-300 font-medium text-sm sm:gap-2 sm:px-4 sm:py-2.5 md:text-base md:px-6 md:py-3">
                            <span class="material-symbols-outlined text-sm sm:text-base md:text-xl">save</span>
                            Simpan Perubahan
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }"
                               x-show="show"
                               x-transition
                               x-init="setTimeout(() => show = false, 3000)"
                               class="text-[10px] text-success flex items-center justify-center gap-0.5 bg-success/10 px-2 py-1 rounded-full sm:text-xs sm:gap-1 sm:px-3 sm:py-1.5">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                Tersimpan!
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </section>

        <!-- Update Password -->
        <section>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-3 space-y-3 hover:shadow-lg transition-shadow duration-300 sm:p-4 md:p-6 lg:p-8 lg:space-y-5">
                <header class="space-y-0.5">
                    <h2 class="text-base font-semibold text-on-surface flex items-center gap-1.5 sm:text-lg md:text-xl lg:text-h2">
                        <span class="material-symbols-outlined text-primary text-lg sm:text-xl md:text-2xl">lock</span>
                        Perbarui Password
                    </h2>
                    <p class="text-xs text-on-surface-variant sm:text-sm md:text-base lg:text-body-regular">Pastikan akun Anda menggunakan password yang panjang dan aman.</p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="space-y-3 sm:space-y-4 md:space-y-5 lg:space-y-6">
                    @csrf
                    @method('put')

                    <!-- Current Password - Mobile Optimized -->
                    <div class="space-y-0.5 group">
                        <label for="update_password_current_password" class="block text-xs font-medium text-on-surface-variant group-focus-within:text-primary transition-colors duration-300 sm:text-sm">
                            <span class="material-symbols-outlined text-xs align-middle mr-1 sm:text-sm">lock_open</span>
                            Password Saat Ini
                        </label>
                        <div class="relative">
                            <input id="update_password_current_password" 
                                   name="current_password" 
                                   type="password" 
                                   class="w-full px-3 py-2 bg-surface-container border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 hover:border-primary/50 pr-8 text-sm sm:text-base sm:px-4 sm:py-2.5 sm:pr-10" 
                                   autocomplete="current-password">
                            <button type="button" 
                                    onclick="togglePassword('update_password_current_password', this)"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-on-surface-variant/60 hover:text-primary transition-colors duration-300 sm:right-3">
                                <span class="material-symbols-outlined text-sm sm:text-base">visibility</span>
                            </button>
                        </div>
                        <x-input-error class="mt-0.5 text-error text-[10px] sm:text-xs" :messages="$errors->updatePassword->get('current_password')" />
                    </div>

                    <!-- New Password - Mobile Optimized -->
                    <div class="space-y-0.5 group">
                        <label for="update_password_password" class="block text-xs font-medium text-on-surface-variant group-focus-within:text-primary transition-colors duration-300 sm:text-sm">
                            <span class="material-symbols-outlined text-xs align-middle mr-1 sm:text-sm">password</span>
                            Password Baru
                        </label>
                        <div class="relative">
                            <input id="update_password_password" 
                                   name="password" 
                                   type="password" 
                                   class="w-full px-3 py-2 bg-surface-container border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 hover:border-primary/50 pr-8 text-sm sm:text-base sm:px-4 sm:py-2.5 sm:pr-10" 
                                   autocomplete="new-password">
                            <button type="button" 
                                    onclick="togglePassword('update_password_password', this)"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-on-surface-variant/60 hover:text-primary transition-colors duration-300 sm:right-3">
                                <span class="material-symbols-outlined text-sm sm:text-base">visibility</span>
                            </button>
                        </div>
                        <div class="mt-1 flex items-center gap-1.5 sm:gap-2">
                            <div class="flex-1 h-1 bg-surface-container rounded-full overflow-hidden sm:h-1.5">
                                <div id="password-strength" class="h-full bg-error rounded-full transition-all duration-500" style="width: 0%"></div>
                            </div>
                            <span id="password-text" class="text-[10px] text-on-surface-variant/60 min-w-[40px] sm:text-xs sm:min-w-[50px]">Lemah</span>
                        </div>
                        <x-input-error class="mt-0.5 text-error text-[10px] sm:text-xs" :messages="$errors->updatePassword->get('password')" />
                    </div>

                    <!-- Confirm Password - Mobile Optimized -->
                    <div class="space-y-0.5 group">
                        <label for="update_password_password_confirmation" class="block text-xs font-medium text-on-surface-variant group-focus-within:text-primary transition-colors duration-300 sm:text-sm">
                            <span class="material-symbols-outlined text-xs align-middle mr-1 sm:text-sm">check_circle</span>
                            Konfirmasi Password Baru
                        </label>
                        <div class="relative">
                            <input id="update_password_password_confirmation" 
                                   name="password_confirmation" 
                                   type="password" 
                                   class="w-full px-3 py-2 bg-surface-container border-2 border-outline-variant rounded-lg text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 hover:border-primary/50 pr-8 text-sm sm:text-base sm:px-4 sm:py-2.5 sm:pr-10" 
                                   autocomplete="new-password">
                            <button type="button" 
                                    onclick="togglePassword('update_password_password_confirmation', this)"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-on-surface-variant/60 hover:text-primary transition-colors duration-300 sm:right-3">
                                <span class="material-symbols-outlined text-sm sm:text-base">visibility</span>
                            </button>
                        </div>
                        <x-input-error class="mt-0.5 text-error text-[10px] sm:text-xs" :messages="$errors->updatePassword->get('password_confirmation')" />
                    </div>

                    <!-- Tombol Simpan - Mobile Optimized -->
                    <div class="flex flex-col items-stretch gap-2 pt-2 border-t-2 border-outline-variant/30 sm:flex-row sm:items-center sm:gap-3 sm:pt-3 md:pt-4">
                        <button type="submit" 
                                class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-primary text-on-primary rounded-lg hover:bg-primary-hover hover:scale-105 hover:shadow-lg transition-all duration-300 font-medium text-sm sm:gap-2 sm:px-4 sm:py-2.5 md:text-base md:px-6 md:py-3">
                            <span class="material-symbols-outlined text-sm sm:text-base md:text-xl">lock</span>
                            Perbarui Password
                        </button>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }"
                               x-show="show"
                               x-transition
                               x-init="setTimeout(() => show = false, 3000)"
                               class="text-[10px] text-success flex items-center justify-center gap-0.5 bg-success/10 px-2 py-1 rounded-full sm:text-xs sm:gap-1 sm:px-3 sm:py-1.5">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                Password berhasil diperbarui!
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </section>

        <!-- Logout Button - Mobile Optimized -->
        <section class="mt-4 sm:mt-5 md:mt-6">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-3 hover:shadow-lg transition-shadow duration-300 sm:p-4 md:p-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-on-surface-variant flex items-center justify-center gap-1.5 hover:bg-error-container hover:text-error rounded-lg transition-all py-2 sm:py-2.5 sm:gap-2 md:py-3 md:gap-3">
                        <span class="material-symbols-outlined text-sm sm:text-base md:text-xl">logout</span>
                        <span class="font-semibold text-sm sm:text-base">Keluar</span>
                    </button>
                </form>
            </div>
        </section>
    </main>

    <script>
        // Preview foto profil
        document.getElementById('photo')?.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('preview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Toggle password visibility
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
            strengthText.className = 'text-[10px] min-w-[40px] text-' + (color === 'bg-success' ? 'success' : color === 'bg-warning' ? 'warning' : 'error') + ' sm:text-xs sm:min-w-[50px]';
        });
    </script>

    <!-- Form untuk verifikasi email -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
        @csrf
    </form>
@endsection