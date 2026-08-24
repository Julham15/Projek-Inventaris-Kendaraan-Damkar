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

    <!-- Custom Styles -->
    <style>
        /* ===== SIDEBAR MOBILE STYLES ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 49;
            backdrop-filter: blur(4px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }
        
        .sidebar-mobile {
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: none !important;
        }
        
        .sidebar-mobile.open {
            transform: translateX(0);
        }
        
        /* Desktop sidebar */
        .sidebar-desktop {
            display: flex !important;
        }
        
        /* Hamburger button */
        .hamburger-btn {
            display: none !important;
        }
        
        /* Mobile header */
        .mobile-header {
            display: none !important;
        }
        
        /* Main content adjustment */
        .main-content-wrapper {
            margin-left: 256px; /* 64 = 16rem */
            flex: 1;
        }
        
        /* ===== MOBILE BREAKPOINT (< 1024px) ===== */
        @media (max-width: 1023px) {
            .sidebar-desktop {
                display: none !important;
            }
            
            .sidebar-mobile {
                display: flex !important;
            }
            
            .hamburger-btn {
                display: flex !important;
            }
            
            .mobile-header {
                display: flex !important;
            }
            
            .main-content-wrapper {
                margin-left: 0 !important;
            }
        }
        
        /* ===== HAMBURGER ANIMATION ===== */
        .hamburger-icon {
            width: 28px;
            height: 20px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
        }
        
        .hamburger-icon span {
            display: block;
            height: 3px;
            width: 100%;
            background: #1D1D1D;
            border-radius: 4px;
            transition: all 0.3s ease;
            transform-origin: center;
        }
        
        .hamburger-icon.active span:nth-child(1) {
            transform: translateY(8.5px) rotate(45deg);
        }
        
        .hamburger-icon.active span:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
        }
        
        .hamburger-icon.active span:nth-child(3) {
            transform: translateY(-8.5px) rotate(-45deg);
        }
        
        /* ===== OTHER STYLES ===== */
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
        
        /* Prevent scroll when sidebar open */
        .no-scroll {
            overflow: hidden;
        }
    </style>

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
</head>

<body class="bg-surface text-on-surface antialiased" style="overscroll-behavior-x: none;">

    <!-- ===== OVERLAY for mobile sidebar ===== -->
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="closeSidebar()"></div>

    <div class="flex min-h-screen">

        <!-- ===== SIDEBAR DESKTOP ===== -->
        <aside id="sidebarDesktop" class="sidebar-desktop fixed left-0 top-0 h-screen w-64 z-50 bg-white border-r border-outline-variant flex flex-col py-lg px-md">
            <!-- Brand -->
            <div class="flex items-center gap-md mb-xl px-xs">
                <div class="rounded-full overflow-hidden border-primary flex items-center justify-center shadow-sm">
                    <img src="{{ asset('assets/logo1.png') }}"
                         alt="Logo Damkar"
                         class="h-17 w-17" style="filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3))">
                </div>
                <div>
                    <p class="font-h4 text-h4 font-bold text-primary" style="font-size: 20px">
                        PEMADAM KEBAKARAN
                    </p>
                    <p class="text-small font-small text-on-surface-variant">
                        Damkar Manise
                    </p>
                </div>
            </div>

            @php
            function activeMenu($route){
                return request()->routeIs($route)
                    ? 'bg-surface-container-low text-primary font-bold'
                    : 'text-on-surface-variant hover:bg-surface-container-high';
            }
            @endphp

            <!-- Nav -->
            <nav class="flex-1 flex flex-col gap-xs">
                <a href="{{ route('dashboard-pemantau') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('dashboard-pemantau') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-body-regular text-body-regular">Dashboard</span>
                </a>
                <a href="{{ route('pemantau.laporan.index') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('pemantau.laporan.index') }}">
                    <span class="material-symbols-outlined">description</span>
                    <span class="font-body-regular text-body-regular">Laporan</span>
                </a>
                <a href="{{ route('pemantaunotifikasi.index') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('pemantaunotifikasi.index') }} relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="font-body-regular text-body-regular">Notifikasi</span>
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 bg-error text-white text-[10px] flex items-center justify-center rounded-full font-bold">{{ auth()->user()->unreadNotifications->count() }}</span>
                </a>
                <a href="{{ route('pemantau.profil') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('profile.edit') }}">
                    <span class="material-symbols-outlined">person</span>
                    <span class="font-body-regular text-body-regular">Profil</span>
                </a>
            </nav>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-lg border-t border-outline-variant">
                @csrf
                <button type="submit" class="w-full flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="font-body-regular text-body-regular">Keluar</span>
                </button>
            </form>
        </aside>

        <!-- ===== SIDEBAR MOBILE ===== -->
        <aside id="sidebarMobile" class="sidebar-mobile fixed left-0 top-0 h-screen w-72 z-50 bg-white border-r border-outline-variant flex-col py-lg px-md shadow-2xl">
            <!-- Close button -->
            <div class="flex justify-end mb-md">
                <button onclick="closeSidebar()" class="p-2 hover:bg-surface-container-high rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-2xl">close</span>
                </button>
            </div>

            <!-- Brand -->
            <div class="flex items-center gap-md mb-xl px-xs">
                <div class="rounded-full overflow-hidden border-primary flex items-center justify-center shadow-sm">
                    <img src="{{ asset('assets/logo1.png') }}"
                         alt="Logo Damkar"
                         class="h-14 w-14" style="filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3))">
                </div>
                <div>
                    <p class="font-h4 text-h4 font-bold text-primary" style="font-size: 18px">
                        PEMADAM KEBAKARAN
                    </p>
                    <p class="text-small font-small text-on-surface-variant">
                        Damkar Manise
                    </p>
                </div>
            </div>

            <!-- Nav -->
            <nav class="flex-1 flex flex-col gap-xs">
                <a href="{{ route('dashboard-pemantau') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('dashboard-pemantau') }}" onclick="closeSidebar()">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-body-regular text-body-regular">Dashboard</span>
                </a>
                <a href="{{ route('pemantau.laporan.index') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('pemantau.laporan.index') }}" onclick="closeSidebar()">
                    <span class="material-symbols-outlined">description</span>
                    <span class="font-body-regular text-body-regular">Laporan</span>
                </a>
                <a href="{{ route('pemantaunotifikasi.index') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('pemantaunotifikasi.index') }} relative" onclick="closeSidebar()">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="font-body-regular text-body-regular">Notifikasi</span>
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 bg-error text-white text-[10px] flex items-center justify-center rounded-full font-bold">{{ auth()->user()->unreadNotifications->count() }}</span>
                </a>
                <a href="{{ route('pemantau.profil') }}" class="flex items-center gap-md p-md rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors {{ activeMenu('profile.edit') }}" onclick="closeSidebar()">
                    <span class="material-symbols-outlined">person</span>
                    <span class="font-body-regular text-body-regular">Profil</span>
                </a>
                <div style="margin-top: 10%; color: rgb(254, 60, 60)!important;">
                    <form method="POST" action="{{ route('logout') }}" class="border-t border-outline-variant">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-md p-md rounded-lg hover:bg-surface-container-high transition-colors">
                            <span class="material-symbols-outlined">logout</span>
                            <span class="font-body-regular text-body-regular">Keluar</span>
                        </button>
                    </form>
                </div>
                 
            </nav>

        </aside>

        <!-- ===== MAIN CONTENT WRAPPER ===== -->
        <div class="main-content-wrapper flex-1 min-h-screen">

            <!-- ===== MOBILE HEADER ===== -->
           <header class="mobile-header" id="mobileHeader">
    <div class="flex items-center justify-between w-full">
        <!-- Bagian Kiri: Hamburger + Logo -->
        <div class="flex items-center gap-3">
            <!-- Hamburger Button -->
            <button id="hamburgerBtn" class="hamburger-btn p-2 rounded-lg hover:bg-surface-container-high transition-colors" onclick="toggleSidebar()">
                <div class="hamburger-icon" id="hamburgerIcon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
            
            <!-- Logo kecil di header mobile -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/logo1.png') }}"
                     alt="Logo"
                     class="h-8 w-8">
                <span class="font-bold text-primary text-sm">Damkar Manise</span>
            </div>
        </div>

        <!-- Bagian Kanan: Nama + Foto Profil -->
        <div class="flex items-center gap-2 md:gap-3">
            <!-- Nama User (sembunyi di layar sangat kecil) -->
            <div class="text-right xs:block">
                <div class="font-h4 text-on-surface leading-none text-xs sm:text-sm font-semibold">
                    {{ $namaPemantau ?? Auth::user()->name }}
                </div>
                <div class="font-caption text-on-surface-variant text-[10px] sm:text-xs">
                    {{ Auth::user()->jabatan ?? 'Staff' }}
                </div>
            </div>

            <!-- Foto Profil -->
            <a href="{{ route('pemantau.profil') }}" class="flex-shrink-0">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-primary-container flex items-center justify-center overflow-hidden border-2 border-primary group relative hover:border-primary/70 transition-colors">
                    @if(isset($user) && $user->photo)
                        <img src="{{ asset('storage/profile/' . $user->photo) }}" 
                             alt="Foto Profil {{ $user->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&size=128&background=006493&color=fff&bold=true" 
                             alt="Avatar" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    @endif
                </div>
            </a>

          
            
        </div>
    </div>
</header>

            <!-- ===== MAIN CONTENT ===== -->
            <main class="p-lg md:p-xl">
                <!-- ===== TOP BAR (Desktop) ===== -->
                <header class="hidden md:flex sticky top-0 z-40 w-full mb-lg justify-between items-center px-lg py-sm bg-surface rounded-xl custom-shadow border border-outline-variant/30">
                    <div class="flex items-center gap-md">
                        <!-- bisa tambahkan search / breadcrumb -->
                    </div>
                    <div class="flex items-center gap-lg">
                        <div class="flex items-center gap-md border-l border-outline-variant/30 pl-lg">
                            <div class="text-right">
                                <div class="font-h4 text-h4 text-on-surface leading-none">{{ $namaPemantau ?? Auth::user()->name }}</div>
                                <div class="font-caption text-caption text-on-surface-variant">{{ Auth::user()->jabatan ?? 'Staff' }}</div>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center overflow-hidden border border-outline-variant group relative">
                                @if(isset($user) && $user->photo)
                                    <img src="{{ asset('storage/profile/' . $user->photo) }}" 
                                         alt="Foto Profil {{ $user->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&size=128&background=006493&color=fff&bold=true" 
                                         alt="Avatar" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @endif
                            </div>
                        </div>
                    </div>
                </header>

                <!-- ===== PAGE CONTENT ===== -->
                @yield('admin2')
            </main>
        </div>
    </div>

    <!-- ===== JAVASCRIPT ===== -->
    <script>
        // ===== SIDEBAR TOGGLE =====
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarMobile');
            const overlay = document.getElementById('sidebarOverlay');
            const hamburgerIcon = document.getElementById('hamburgerIcon');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
            hamburgerIcon.classList.toggle('active');
            
            // Prevent body scroll when sidebar is open
            if (sidebar.classList.contains('open')) {
                document.body.classList.add('no-scroll');
            } else {
                document.body.classList.remove('no-scroll');
            }
        }
        
        function closeSidebar() {
            const sidebar = document.getElementById('sidebarMobile');
            const overlay = document.getElementById('sidebarOverlay');
            const hamburgerIcon = document.getElementById('hamburgerIcon');
            
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            hamburgerIcon.classList.remove('active');
            document.body.classList.remove('no-scroll');
        }
        
        // Close sidebar when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });
        
        // Close sidebar when resizing to desktop
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            }, 250);
        });

        // ===== MICRO-INTERACTIONS =====
        document.querySelectorAll('button, a[role="button"]').forEach(el => {
            el.addEventListener('mousedown', () => { el.style.transform = 'scale(0.98)'; });
            el.addEventListener('mouseup', () => { el.style.transform = 'scale(1)'; });
            el.addEventListener('mouseleave', () => { el.style.transform = 'scale(1)'; });
        });
    </script>

    @stack('scripts')
</body>
</html>