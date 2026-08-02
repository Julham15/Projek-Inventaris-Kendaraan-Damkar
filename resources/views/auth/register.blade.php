<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Register - Damkar Manise</title>
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
            padding: 20px;
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
        .btn-register {
            background: linear-gradient(135deg, #006493 0%, #004b70 100%);
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 100, 147, 0.35);
        }
        .btn-register:active {
            transform: translateY(0);
        }
        .brand-icon {
            background: linear-gradient(135deg, #38b6ff 0%, #006493 100%);
            overflow: hidden;
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
        .login-link {
            color: #006493;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .login-link:hover {
            color: #004b70;
            text-decoration: underline;
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
        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        .password-toggle {
            cursor: pointer;
            transition: color 0.3s ease;
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6e7882;
            z-index: 2;
        }
        .password-toggle:hover {
            color: #006493;
        }
        .register-form {
            max-height: 65vh;
            overflow-y: auto;
            padding-right: 4px;
        }
        .register-form::-webkit-scrollbar {
            width: 4px;
        }
        .register-form::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .register-form::-webkit-scrollbar-thumb {
            background: #006493;
            border-radius: 10px;
        }
        .register-form::-webkit-scrollbar-thumb:hover {
            background: #004b70;
        }
        /* Icon di dalam input - sebelah kiri */
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6e7882;
            font-size: 22px;
            pointer-events: none;
            z-index: 2;
        }
        .input-with-icon {
            padding-left: 46px !important;
        }
        .input-with-password-toggle {
            padding-right: 46px !important;
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

    <!-- Main Register Container -->
    <div class="relative z-10 w-full max-w-md px-4">
        <div class="glass-card rounded-2xl p-8 md:p-10">
            <!-- Brand Header -->
            <div class="text-center mb-6">
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
                <h2 class="font-h3 text-h3 font-bold text-[#171c21]">Buat Akun Baru</h2>
                <p class="font-body-regular text-body-regular text-[#6e7882] mt-1">Daftar untuk mengakses sistem</p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4 register-form">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block font-small text-small font-medium text-[#171c21] mb-1.5">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined input-icon">person</span>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Masukkan nama lengkap"
                            class="input-field w-full input-with-icon pr-4 py-3 rounded-xl bg-white/70 text-[#171c21] placeholder-[#6e7882] font-body-regular text-body-regular {{ $errors->has('name') ? 'error' : '' }}"
                        />
                    </div>
                    @if ($errors->has('name'))
                        <div class="error-message">
                            <span class="material-symbols-outlined">error</span>
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block font-small text-small font-medium text-[#171c21] mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined input-icon">email</span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            placeholder="user@damkar.go.id"
                            class="input-field w-full input-with-icon pr-4 py-3 rounded-xl bg-white/70 text-[#171c21] placeholder-[#6e7882] font-body-regular text-body-regular {{ $errors->has('email') ? 'error' : '' }}"
                        />
                    </div>
                    @if ($errors->has('email'))
                        <div class="error-message">
                            <span class="material-symbols-outlined">error</span>
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block font-small text-small font-medium text-[#171c21] mb-1.5">
                        Nomor HP
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined input-icon">phone</span>
                        <input
                            id="phone"
                            type="tel"
                            name="phone"
                            value="{{ old('phone') }}"
                            required
                            pattern="^(?:\+62|62|0)[0-9]{9,13}$"
                            placeholder="08xx.."
                            autocomplete="tel"
                            class="input-field w-full input-with-icon pr-4 py-3 rounded-xl bg-white/70 text-[#171c21] placeholder-[#6e7882] font-body-regular text-body-regular {{ $errors->has('phone') ? 'error' : '' }}"
                        />
                    </div>
                    @if ($errors->has('phone'))
                        <div class="error-message">
                            <span class="material-symbols-outlined">error</span>
                            {{ $errors->first('phone') }}
                        </div>
                    @endif
                    <p class="font-caption text-caption text-[#6e7882] mt-1">
                        
                    </p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block font-small text-small font-medium text-[#171c21] mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined input-icon">lock</span>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="input-field w-full input-with-icon input-with-password py-3 rounded-xl bg-white/70 text-[#171c21] placeholder-[#6e7882] font-body-regular text-body-regular {{ $errors->has('password') ? 'error' : '' }}"
                        />
                        {{-- <span class="material-symbols-outlined password-toggle" onclick="togglePassword('password', this)">
                            visibility
                        </span> --}}
                    </div>
                    @if ($errors->has('password'))
                        <div class="error-message">
                            <span class="material-symbols-outlined">error</span>
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block font-small text-small font-medium text-[#171c21] mb-1.5">
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined input-icon">lock</span>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Ketik ulang kata sandi"
                            class="input-field w-full input-with-icon input-with-password py-3 rounded-xl bg-white/70 text-[#171c21] placeholder-[#6e7882] font-body-regular text-body-regular {{ $errors->has('password_confirmation') ? 'error' : '' }}"
                        />
                        {{-- <span class="material-symbols-outlined password-toggle" onclick="togglePassword('password_confirmation', this)">
                            visibility
                        </span> --}}
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <div class="error-message">
                            <span class="material-symbols-outlined">error</span>
                            {{ $errors->first('password_confirmation') }}
                        </div>
                    @endif
                </div>

                <!-- Already Registered & Register Button -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                    <a href="{{ route('login') }}" class="login-link font-small text-small flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Sudah punya akun?
                    </a>
                    <button
                        type="submit"
                        class="btn-register w-full sm:w-auto px-8 py-3 rounded-xl text-white font-h4 text-h4 font-semibold flex items-center justify-center gap-2"
                    >
                        <span class="material-symbols-outlined text-xl">app_registration</span>
                        Daftar
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="font-caption text-caption text-[#6e7882]">
                    &copy; {{ date('Y') }} Pemadam Kebakaran. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <!-- Toggle Password Visibility -->
    <script>
        function togglePassword(inputId, iconElement) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                iconElement.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                iconElement.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>