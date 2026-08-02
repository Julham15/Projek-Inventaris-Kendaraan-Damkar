<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Login - Damkar Manise</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f6f9ff 0%, #d6e8f5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 60px rgba(0, 100, 147, 0.15);
        }
        .input-field {
            transition: all 0.3s ease;
            border: 2px solid #e4e8ef;
        }
        .input-field:focus {
            border-color: #006493;
            box-shadow: 0 0 0 4px rgba(0, 100, 147, 0.1);
            outline: none;
        }
        .input-field.error {
            border-color: #ba1a1a;
            box-shadow: 0 0 0 4px rgba(186, 26, 26, 0.1);
        }
        .btn-login {
            background: linear-gradient(135deg, #006493 0%, #004b70 100%);
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 100, 147, 0.35);
        }
        .btn-login:active {
            transform: translateY(0);
        }
        .brand-icon {
            background: linear-gradient(135deg, #38b6ff 0%, #006493 100%);
        }
        .floating-shapes {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.08;
        }
        .shape-1 {
            width: 400px;
            height: 400px;
            background: #006493;
            top: -100px;
            right: -100px;
        }
        .shape-2 {
            width: 300px;
            height: 300px;
            background: #38b6ff;
            bottom: -50px;
            left: -50px;
        }
        .shape-3 {
            width: 200px;
            height: 200px;
            background: #ffb94f;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .register-link {
            color: #006493;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .register-link:hover {
            color: #004b70;
            text-decoration: underline;
        }
        .forgot-link {
            color: #6e7882;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 14px;
        }
        .forgot-link:hover {
            color: #006493;
            text-decoration: underline;
        }
        .checkbox-custom {
            accent-color: #006493;
            width: 18px;
            height: 18px;
            cursor: pointer;
            border-radius: 4px;
            border: 2px solid #bec8d2;
            transition: all 0.2s ease;
        }
        .checkbox-custom:checked {
            border-color: #006493;
            background-color: #006493;
        }
        .error-message {
            color: #ba1a1a;
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .error-message .material-symbols-outlined {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <!-- Main Login Container -->
    <div class="relative z-10 w-full max-w-md px-4">
        <div class="glass-card rounded-2xl p-8 md:p-10">
            <!-- Brand Header -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <div class="brand-icon w-14 h-14 rounded-full flex items-center justify-center shadow-lg">
                        <img 
                            src="{{ asset('assets/logo1.png') }}" 
                            alt="Logo Pemadam Kebakaran" 
                            class="logo-img"
                        />
                    </div>
                    <div class="text-left">
                        <h1 class="font-h2 text-h2 font-bold text-[#006493]">PEMADAM KEBAKARAN</h1>
                        <p class="font-small text-small text-[#6e7882]">Damkar Manise</p>
                    </div>
                </div>
                <h2 class="font-h3 text-h3 font-bold text-[#171c21]">Selamat Datang Kembali</h2>
                <p class="font-body-regular text-body-regular text-[#6e7882] mt-1">Silakan masuk ke akun Anda</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-green-500 text-sm">check_circle</span>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block font-small text-small font-medium text-[#171c21] mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#6e7882] text-xl">
                            email
                        </span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="admin@damkar.go.id"
                            class="input-field w-full pl-11 pr-4 py-3 rounded-xl bg-white/70 text-[#171c21] placeholder-[#6e7882] font-body-regular text-body-regular {{ $errors->has('email') ? 'error' : '' }}"
                        />
                    </div>
                    @if ($errors->has('email'))
                        <div class="error-message">
                            <span class="material-symbols-outlined">error</span>
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="password" class="block font-small text-small font-medium text-[#171c21]">
                            Kata Sandi
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                Lupa sandi?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#6e7882] text-xl">
                            lock
                        </span>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan kata sandi Anda"
                            class="input-field w-full pl-11 pr-4 py-3 rounded-xl bg-white/70 text-[#171c21] placeholder-[#6e7882] font-body-regular text-body-regular {{ $errors->has('password') ? 'error' : '' }}"
                        />
                    </div>
                    @if ($errors->has('password'))
                        <div class="error-message">
                            <span class="material-symbols-outlined">error</span>
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <!-- Remember Me & Register -->
                <div class="flex items-center justify-between pt-1">
                    <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="checkbox-custom rounded"
                        />
                        <span class="font-small text-small text-[#6e7882]">Ingat saya</span>
                    </label>
                    <a href="{{ route('register') }}" class="register-link font-small text-small">
                        Daftar Akun
                    </a>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="btn-login w-full py-3.5 rounded-xl text-white font-h4 text-h4 font-semibold flex items-center justify-center gap-2"
                >
                    <span class="material-symbols-outlined text-xl">login</span>
                    Masuk
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="font-caption text-caption text-[#6e7882]">
                    &copy; {{ date('Y') }} Pemadam Kebakaran. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <!-- Auto-hide session status after 5 seconds -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusDiv = document.querySelector('.bg-green-50');
            if (statusDiv) {
                setTimeout(() => {
                    statusDiv.style.transition = 'opacity 0.5s ease';
                    statusDiv.style.opacity = '0';
                    setTimeout(() => {
                        statusDiv.style.display = 'none';
                    }, 500);
                }, 5000);
            }
        });
    </script>
</body>
</html>