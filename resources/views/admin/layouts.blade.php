
<!DOCTYPE html>
<html lang="id" style="width: 1280px; height: 1024px; position: relative;"><head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>Manajemen Pengguna - Damkar Admin</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-error-container": "#93000a",
                        "surface-variant": "#dfe3e9",
                        "on-tertiary-fixed-variant": "#624000",
                        "error": "#ba1a1a",
                        "surface-container-high": "#e4e8ef",
                        "on-secondary-fixed": "#001d31",
                        "on-surface-variant": "#3e4850",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-container": "#00456b",
                        "surface-tint": "#006493",
                        "on-tertiary": "#ffffff",
                        "surface-container": "#eaeef4",
                        "primary-container": "#38b6ff",
                        "tertiary": "#825500",
                        "secondary": "#006397",
                        "error-container": "#ffdad6",
                        "tertiary-fixed-dim": "#ffb94f",
                        "surface": "#f6f9ff",
                        "primary": "#006493",
                        "primary-fixed-dim": "#8ccdff",
                        "on-surface": "#171c21",
                        "secondary-container": "#4fb6ff",
                        "tertiary-container": "#e99d0c",
                        "surface-container-highest": "#dfe3e9",
                        "primary-fixed": "#cae6ff",
                        "surface-dim": "#d6dae0",
                        "on-primary-fixed": "#001e30",
                        "on-error": "#ffffff",
                        "on-primary-fixed-variant": "#004b70",
                        "secondary-fixed": "#cce5ff",
                        "on-tertiary-fixed": "#291800",
                        "on-background": "#171c21",
                        "on-secondary": "#ffffff",
                        "inverse-on-surface": "#edf1f7",
                        "on-tertiary-container": "#5a3a00",
                        "surface-container-low": "#f0f4fa",
                        "inverse-primary": "#8ccdff",
                        "on-primary": "#ffffff",
                        "background": "#f6f9ff",
                        "outline-variant": "#bec8d2",
                        "tertiary-fixed": "#ffddb3",
                        "secondary-fixed-dim": "#92ccff",
                        "on-primary-container": "#004566",
                        "surface-bright": "#f6f9ff",
                        "inverse-surface": "#2c3136",
                        "outline": "#6e7882",
                        "on-secondary-fixed-variant": "#004b73"
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
                        base: "4px",
                        gutter: "16px",
                        sm: "12px",
                        xl: "32px",
                        margin: "24px",
                        xs: "8px"
                    },
                    fontFamily: {
                        caption: ["Plus Jakarta Sans"],
                        "body-regular": ["Plus Jakarta Sans"],
                        h4: ["Plus Jakarta Sans"],
                        h1: ["Plus Jakarta Sans"],
                        h3: ["Plus Jakarta Sans"],
                        h2: ["Plus Jakarta Sans"],
                        small: ["Plus Jakarta Sans"]
                    },
                    fontSize: {
                        caption: ["11px", { lineHeight: "1.4", fontWeight: "400" }],
                        "body-regular": ["14px", { lineHeight: "1.6", fontWeight: "400" }],
                        h4: ["16px", { lineHeight: "1.5", fontWeight: "500" }],
                        h1: ["32px", { lineHeight: "1.2", fontWeight: "700" }],
                        h3: ["20px", { lineHeight: "1.4", fontWeight: "600" }],
                        h2: ["24px", { lineHeight: "1.3", fontWeight: "600" }],
                        small: ["12px", { lineHeight: "1.5", fontWeight: "400" }]
                    }
                }
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f6f9ff; }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-regular">
<!-- TopNavBar -->
<header class="flex justify-between items-center w-full px-lg py-md sticky top-0 z-40 lg:pl-[280px] bg-white dark:bg-surface-container-lowest border-b border-outline-variant dark:border-outline">
@yield('head')

</header>

<!-- SideNavBar -->
@include('admin.nav')
<!-- Main Content -->
@yield('navbar')
</body>
</html>