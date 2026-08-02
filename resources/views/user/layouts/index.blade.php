<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DAMKAR MANISE</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=block" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "inverse-primary": "#8ccdff",
                        "secondary": "#006397",
                        "on-primary-container": "#004566",
                        "surface-container-highest": "#dfe3e9",
                        "secondary-container": "#4fb6ff",
                        "surface-tint": "#006493",
                        "inverse-surface": "#2c3136",
                        "on-secondary-fixed": "#001d31",
                        "primary-fixed": "#cae6ff",
                        "on-primary-fixed": "#001e30",
                        "tertiary-container": "#e99d0c",
                        "on-surface": "#171c21",
                        "tertiary": "#825500",
                        "on-secondary-fixed-variant": "#004b73",
                        "on-background": "#171c21",
                        "on-secondary-container": "#00456b",
                        "tertiary-fixed": "#ffddb3",
                        "error-container": "#ffdad6",
                        "surface-container-high": "#e4e8ef",
                        "inverse-on-surface": "#edf1f7",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#006493",
                        "background": "#f6f9ff",
                        "secondary-fixed-dim": "#92ccff",
                        "on-tertiary-container": "#5a3a00",
                        "secondary-fixed": "#cce5ff",
                        "primary-fixed-dim": "#8ccdff",
                        "surface-bright": "#f6f9ff",
                        "on-tertiary-fixed-variant": "#624000",
                        "on-error-container": "#93000a",
                        "on-surface-variant": "#3e4850",
                        "on-tertiary-fixed": "#291800",
                        "on-tertiary": "#ffffff",
                        "surface-variant": "#dfe3e9",
                        "surface": "#f6f9ff",
                        "outline": "#6e7882",
                        "on-secondary": "#ffffff",
                        "on-error": "#ffffff",
                        "surface-container": "#eaeef4",
                        "error": "#ba1a1a",
                        "tertiary-fixed-dim": "#ffb94f",
                        "primary-container": "#38b6ff",
                        "on-primary-fixed-variant": "#004b70",
                        "surface-dim": "#d6dae0",
                        "on-primary": "#ffffff",
                        "outline-variant": "#bec8d2",
                        "surface-container-low": "#f0f4fa"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    spacing: {
                        md: "16px",
                        lg: "24px",
                        xl: "32px",
                        xs: "8px",
                        gutter: "16px",
                        margin: "24px",
                        sm: "12px",
                        base: "4px"
                    },
                    fontFamily: {
                        "body-regular": ["Plus Jakarta Sans"],
                        "h4": ["Plus Jakarta Sans"],
                        "h3": ["Plus Jakarta Sans"],
                        "small": ["Plus Jakarta Sans"],
                        "h2": ["Plus Jakarta Sans"],
                        "h1": ["Plus Jakarta Sans"],
                        "caption": ["Plus Jakarta Sans"]
                    },
                    fontSize: {
                        "body-regular": ["14px", { "lineHeight": "1.6", "fontWeight": "400" }],
                        "h4": ["16px", { "lineHeight": "1.5", "fontWeight": "500" }],
                        "h3": ["20px", { "lineHeight": "1.4", "fontWeight": "600" }],
                        "small": ["12px", { "lineHeight": "1.5", "fontWeight": "400" }],
                        "h2": ["24px", { "lineHeight": "1.3", "fontWeight": "600" }],
                        "h1": ["32px", { "lineHeight": "1.2", "fontWeight": "700" }],
                        "caption": ["11px", { "lineHeight": "1.4", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
    <style>
        .chart-bar {
            transition: height 0.8s cubic-bezier(0.22, 1, 0.36, 1);
            min-height: 4px;
        }
        .bar-label {
            transition: opacity 0.3s ease;
        }
        .stat-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 100, 147, 0.12);
        }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen">

    <!-- TopNavBar -->
<nav class="bg-surface border-b border-outline-variant sticky top-0 z-50 shadow-sm">
    <div class="flex justify-between items-center w-full px-lg" style="padding: 5px;">

        {{-- Bagian kiri (opsional) --}}
        <div></div>

        {{-- Bagian kanan --}}
        <div class="flex items-center gap-3">

            {{-- Nama & Platon --}}
            <div class="text-right">
                <p class="font-h4 text-h4 font-bold text-primary">
                    {{ $user->name ?? 'Petugas' }}
                </p>

                <p class="text-small font-small text-on-surface-variant">
                    @if($user->platon && $user->regu)
                        {{ $user->platon->nama }} - Regu {{ $user->regu->nama }}
                    @else
                        <span class="text-red-600 font-semibold">
                            Belum memiliki Platon & Regu
                        </span>
                    @endif
                </p>
            </div>

            {{-- Foto Profil --}}
            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-primary bg-primary-container/20 flex items-center justify-center flex-shrink-0">

                @if($user->photo)
                    <img src="{{ asset('storage/profile/' . $user->photo) }}"
                         alt="{{ $user->name }}"
                         class="w-full h-full object-cover">
                @else
                    @php
                        $words = explode(' ', trim($user->name));
                        $initials = strtoupper($words[0][0] ?? '');

                        if(count($words) > 1){
                            $initials .= strtoupper(substr(end($words),0,1));
                        }
                    @endphp

                    <span class="text-primary font-bold text-lg">
                        {{ $initials }}
                    </span>
                @endif

            </div>

        </div>

    </div>
</nav>

    <!-- SideNavBar -->
   @include('user.layouts.nav')

@yield('user')
    </body>
</html>