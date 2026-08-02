<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAMKAR MANISE · Dashboard</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=block" rel="stylesheet">

    <!-- Tailwind + Chart.js -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind Custom Config -->
    <script id="tailwind-config">
        try {
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            "surface-variant": "#dfe3e9",
                            "surface-container-high": "#e4e8ef",
                            "surface-container": "#eaeef4",
                            "surface-bright": "#f6f9ff",
                            "on-primary-container": "#004566",
                            "tertiary-fixed-dim": "#ffb94f",
                            "on-secondary-fixed": "#001d31",
                            "error": "#ba1a1a",
                            "on-secondary-fixed-variant": "#004b73",
                            "secondary": "#006397",
                            "on-secondary-container": "#00456b",
                            "primary-fixed-dim": "#8ccdff",
                            "inverse-primary": "#8ccdff",
                            "tertiary-fixed": "#ffddb3",
                            "outline": "#6e7882",
                            "surface-dim": "#d6dae0",
                            "on-tertiary-fixed-variant": "#624000",
                            "inverse-on-surface": "#edf1f7",
                            "primary": "#006493",
                            "on-tertiary-container": "#5a3a00",
                            "on-error-container": "#93000a",
                            "tertiary": "#825500",
                            "secondary-fixed": "#cce5ff",
                            "primary-fixed": "#cae6ff",
                            "on-background": "#171c21",
                            "surface-container-highest": "#dfe3e9",
                            "on-tertiary": "#ffffff",
                            "secondary-fixed-dim": "#92ccff",
                            "on-tertiary-fixed": "#291800",
                            "background": "#f6f9ff",
                            "surface": "#f6f9ff",
                            "error-container": "#ffdad6",
                            "on-primary-fixed": "#001e30",
                            "on-surface": "#171c21",
                            "surface-tint": "#006493",
                            "outline-variant": "#bec8d2",
                            "on-secondary": "#ffffff",
                            "on-primary": "#ffffff",
                            "primary-container": "#38b6ff",
                            "on-surface-variant": "#3e4850",
                            "on-error": "#ffffff",
                            "inverse-surface": "#2c3136",
                            "surface-container-lowest": "#ffffff",
                            "secondary-container": "#4fb6ff",
                            "on-primary-fixed-variant": "#004b70",
                            "tertiary-container": "#e99d0c",
                            "surface-container-low": "#f0f4fa"
                        },
                        borderRadius: {
                            DEFAULT: "0.25rem",
                            lg: "0.5rem",
                            xl: "0.75rem",
                            full: "9999px"
                        },
                        spacing: {
                            xs: "8px",
                            sm: "12px",
                            lg: "24px",
                            base: "4px",
                            md: "16px",
                            xl: "32px",
                            margin: "24px",
                            gutter: "16px"
                        },
                        fontFamily: {
                            small: ["Plus Jakarta Sans"],
                            h1: ["Plus Jakarta Sans"],
                            "body-regular": ["Plus Jakarta Sans"],
                            h4: ["Plus Jakarta Sans"],
                            h2: ["Plus Jakarta Sans"],
                            caption: ["Plus Jakarta Sans"],
                            h3: ["Plus Jakarta Sans"]
                        },
                        fontSize: {
                            small: ["12px", { lineHeight: "1.5", fontWeight: "400" }],
                            h1: ["32px", { lineHeight: "1.2", fontWeight: "700" }],
                            "body-regular": ["14px", { lineHeight: "1.6", fontWeight: "400" }],
                            h4: ["16px", { lineHeight: "1.5", fontWeight: "500" }],
                            h2: ["24px", { lineHeight: "1.3", fontWeight: "600" }],
                            caption: ["11px", { lineHeight: "1.4", fontWeight: "400" }],
                            h3: ["20px", { lineHeight: "1.4", fontWeight: "600" }]
                        }
                    }
                }
            }
        } catch (_e) { }
    </script>

    <style>
        /* minor polish */
        .custom-shadow {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }
        .zebra-table tbody tr:nth-child(even) {
            background-color: #f8faff;
        }
        .zebra-table tbody tr:hover {
            background-color: #eef3fc;
            transition: 0.15s;
        }
        .sticky {
            z-index: 5;
        }
    </style>
</head>

<body class="bg-surface text-on-surface antialiased" style="overscroll-behavior-x: none;">

    <div class="flex min-h-screen">

        <!-- ===== SIDEBAR (fixed) ===== -->
        @include('Pemantau.layouts.nav')

        <!-- ===== MAIN CONTENT ===== -->
        <main class="flex-1 ml-64 p-lg">

            <!-- ===== TOP BAR ===== -->
            <header class="sticky top-0 z-40 w-full mb-lg flex justify-between items-center px-lg py-sm bg-surface rounded-xl custom-shadow border border-outline-variant/30">
                <div class="flex items-center gap-md">
                    <!-- bisa tambahkan search / breadcrumb -->
                </div>
                <div class="flex items-center gap-lg">
                    <div class="flex items-center gap-md border-l border-outline-variant/30 pl-lg">
                        <div class="text-right">
                            <div class="font-h4 text-h4 text-on-surface leading-none">{{ $namaPemantau }}</div>
                            <div class="font-caption text-caption text-on-surface-variant"> {{ Auth::user()->jabatan ?? 'Staff' }}</div>
                        </div>
    <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center overflow-hidden border border-outline-variant group relative">
    @if($user->photo)
        <img src="{{ asset('storage/profile/' . $user->photo) }}" 
             alt="Foto Profil {{ $user->name }}" 
             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
    @else
        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128&background=006493&color=fff&bold=true" 
             alt="Avatar {{ $user->name }}" 
             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
    @endif
</div>
                    </div>
                </div>
            </header>

            <!-- ===== WELCOME ===== -->
            @yield('admin2')

    <!-- ===== CHART SCRIPT ===== -->
    <script>
        // Micro-interaction: button press feedback
        document.querySelectorAll('button, a[role="button"]').forEach(el => {
            el.addEventListener('mousedown', () => { el.style.transform = 'scale(0.98)'; });
            el.addEventListener('mouseup', () => { el.style.transform = 'scale(1)'; });
            el.addEventListener('mouseleave', () => { el.style.transform = 'scale(1)'; });
        });

        // Chart data from Laravel
      
    </script>

</body>
</html>