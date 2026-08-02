<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Lupa Password - Damkar Admin</title>
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
        .btn-reset {
            background: linear-gradient(135deg, #006493 0%, #004b70 100%);
            transition: all 0.3s ease;
        }
        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 100, 147, 0.35);
        }
        .btn-reset:active {
            transform: translateY(0);
        }
        .btn-back {
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid #e4e8ef;
            transition: all 0.3s ease;
            color: #171c21;
        }
        .btn-back:hover {
            background: #ffffff;
            border-color: #006493;
            color: #006493;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 100, 147, 0.15);
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
        .success-message {
            background: #e8f5e9;
            border: 1px solid #a5d6a7;
            color: #1b5e20;
            padding: 12px 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }
        .success-message .material-symbols-outlined {
            color: #2e7d32;
            font-size: 22px;
        }
        .info-text {
            background: #e3f2fd;
            border: 1px solid #90caf9;
            color: #0d47a1;
            padding: 14px 16px;
            border-radius: 12px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 14px;
            line-height: 1.6;
        }
        .info-text .material-symbols-outlined {
            color: #1565c0;
            font-size: 22px;
            flex-shrink: 0;
            margin-top: 1px;
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

    <!-- Main Forgot Password Container -->
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
                <h2 class="font-h3 text-h3 font-bold text-[#171c21]">Lupa Password</h2>
                <p class="font-body-regular text-body-regular text-[#6e7882] mt-1">Reset kata sandi akun Anda</p>
            </div>

            <!-- Info Text -->
            <div class="info-text mb-6">
                <span class="material-symbols-outlined">info</span>
                <span>Lupa password? Masukkan alamat email Anda dan kami akan mengirimkan link reset password yang memungkinkan Anda membuat password baru.</span>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="success-message mb-6">
                    <span class="material-symbols-outlined">check_circle</span>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

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
                            autofocus
                            placeholder="admin@damkar.go.id"
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

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
    <a href="{{ route('login') }}" class="btn-back w-full sm:w-auto px-6 py-3 rounded-xl font-h4 text-h4 font-semibold flex items-center justify-center gap-2">
        <span class="material-symbols-outlined text-xl">arrow_back</span>
        Kembali
    </a>
    <button
        type="submit"
        class="btn-reset w-full sm:w-auto px-6 py-3 rounded-xl text-white font-h4 text-h4 font-semibold flex items-center justify-center gap-2"
    >
        <span class="material-symbols-outlined text-xl">send</span>
        Kirim Link
    </button>
</div>
            </form>

            <!-- Additional Help -->
            <div class="mt-6 text-center border-t border-[#e4e8ef] pt-5">
                <p class="font-small text-small text-[#6e7882]">
                    Sudah ingat password?
                    <a href="{{ route('login') }}" class="login-link">
                        Masuk di sini
                    </a>
                </p>
            </div>

            <!-- Footer -->
            <div class="mt-5 text-center">
                <p class="font-caption text-caption text-[#6e7882]">
                    &copy; {{ date('Y') }} Pemadam Kebakaran. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <!-- Auto-hide session status after 5 seconds -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusDiv = document.querySelector('.success-message');
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