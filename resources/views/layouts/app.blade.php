@php
    $rawCookieTheme = $_COOKIE['theme'] ?? request()->cookie('theme', 'light');
    $isDarkServer = $rawCookieTheme === 'dark';
@endphp
<!DOCTYPE html>
<html lang="id" class="{{ $isDarkServer ? 'dark' : '' }}" style="{{ $isDarkServer ? 'color-scheme: dark; background-color: #0b1120;' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Database Sekolah TPQ & RTQ')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        arabic: ['Amiri', 'serif'],
                    },
                    colors: {
                        blue: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#2563eb',
                            600: '#1d4ed8',
                            700: '#1e40af',
                            800: '#1e3a8a',
                            900: '#16285a',
                            950: '#081026',
                        },
                        red: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                            950: '#450a0a',
                        },
                        rose: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            300: '#fda4af',
                            400: '#fb7185',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239',
                            900: '#881337',
                            950: '#4c0519',
                        },
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#2563eb',
                            600: '#1d4ed8',
                            700: '#1e40af',
                            800: '#1e3a8a',
                            900: '#16285a',
                        },
                        munaqasyah: {
                            yellow: '#FEF08A',
                            yellowDark: '#EAB308',
                        }
                    }
                }
            }
        };

        // Inisialisasi tema instan sebelum render untuk mencegah efek kedip (FOUC)
        (function() {
            try {
                let theme = localStorage.getItem('theme');
                if (!theme) {
                    const match = document.cookie.match(/(^|; )theme=([^;]+)/);
                    if (match) theme = decodeURIComponent(match[2]);
                }
                if (!theme) {
                    theme = '{{ $isDarkServer ? "dark" : "light" }}';
                }
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                    document.documentElement.style.colorScheme = 'dark';
                    document.documentElement.style.backgroundColor = '#0b1120';
                } else {
                    document.documentElement.classList.remove('dark');
                    document.documentElement.style.colorScheme = 'light';
                    document.documentElement.style.backgroundColor = '';
                }
            } catch (e) {}
        })();
    </script>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
            .print-full { width: 100% !important; margin: 0 !important; padding: 0 !important; }
        }
        .table-custom th, .table-custom td {
            border: 1px solid #cbd5e1;
            padding: 6px 10px;
            font-size: 0.85rem;
        }

        /* ===== PAGE TRANSITION ===== */
        #page-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            pointer-events: none;
            background: #fff;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        #page-overlay.fade-in  { opacity: 0.5; pointer-events: all; }
        #page-overlay.fade-out { opacity: 0; pointer-events: none; }

        /* Progress bar */
        #page-progress {
            position: fixed;
            top: 0; left: 0;
            height: 2px;
            width: 0%;
            background: #2563eb;
            z-index: 10000;
            transition: width 0.3s ease;
            border-radius: 0 2px 2px 0;
        }

        /* Content fade-in on load */
        #main-content {
            animation: contentAppear 0.35s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        @keyframes contentAppear {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== LOGOUT MODAL ===== */
        #logout-modal {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
        }
        #logout-modal.show {
            opacity: 1;
            pointer-events: all;
        }
        #logout-modal .modal-card {
            transform: scale(0.92) translateY(16px);
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        #logout-modal.show .modal-card {
            transform: scale(1) translateY(0);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col antialiased">

    <!-- Page Transition Overlay -->
    <div id="page-overlay"></div>
    <!-- Progress Bar -->
    <div id="page-progress"></div>

    <!-- ===== LOGOUT CONFIRM MODAL ===== -->
    <div id="logout-modal" class="fixed inset-0 z-[9998] flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeLogoutModal()"></div>
        <!-- Card -->
        <div class="modal-card relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">
            <!-- Top accent bar -->
            <div class="h-1.5 bg-slate-700"></div>
            <div class="p-6">
                <!-- Icon -->
                <div class="flex items-center justify-center mb-4">
                    <div class="w-16 h-16 rounded-2xl bg-red-50 border-2 border-red-100 flex items-center justify-center">
                        <i class="fa-solid fa-right-from-bracket text-2xl text-red-500"></i>
                    </div>
                </div>
                <!-- Text -->
                <div class="text-center mb-6">
                    <h3 class="text-lg font-black text-slate-800">Keluar dari Sistem?</h3>
                    <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">
                        Kamu akan keluar dari <span class="font-bold text-blue-900">Database Sekolah</span>.<br>
                        Pastikan semua data sudah tersimpan sebelum keluar.
                    </p>
                </div>
                <!-- Actions -->
                <div class="flex gap-3">
                    <button onclick="closeLogoutModal()"
                        class="flex-1 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-xmark"></i> Batal
                    </button>
                    <button onclick="confirmLogout()"
                        id="confirmLogoutBtn"
                        class="flex-1 py-2.5 rounded-xl text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-sm transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-right-from-bracket" id="logoutBtnIcon"></i>
                        <span id="logoutBtnText">Ya, Keluar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <!-- Navbar -->
    <header class="bg-white border-b border-slate-200 text-slate-800 shadow-sm sticky top-0 z-50 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-15" style="height:60px">
                <div class="flex items-center gap-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 mr-3 group">
                        <div class="w-9 h-9 rounded-lg bg-slate-50 border border-slate-200 p-1.5 flex items-center justify-center group-hover:border-blue-300 transition">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h1 class="text-sm font-black text-slate-800 leading-tight tracking-tight">AR-RAUDHAH</h1>
                            <p class="text-[10px] text-slate-400 leading-none">Yayasan Cahaya Amanah</p>
                        </div>
                    </a>

                    <div class="w-px h-6 bg-slate-200 mx-1"></div>

                    <a href="{{ route('dashboard') }}" title="Dashboard"
                       class="px-3 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                        <i class="fa-solid fa-gauge-high text-[11px]"></i> Dashboard
                    </a>
                    <a href="{{ route('santri.index') }}" title="Biodata Santri"
                       class="px-3 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 {{ request()->routeIs('santri.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                        <i class="fa-solid fa-address-card text-[11px]"></i> Biodata Santri
                    </a>
                </div>

                <div class="flex items-center gap-1.5">
                    {{-- Tab Switch TPQ / RTQ --}}
                    <div class="inline-flex bg-slate-100 p-0.5 rounded-lg border border-slate-200 mr-1">
                        <a href="{{ route('database_sekolah.index', ['jenis' => 'TPQ']) }}"
                           class="px-3 py-1.5 rounded-md text-xs font-semibold transition flex items-center gap-1.5 {{ request('jenis', 'TPQ') == 'TPQ' ? 'bg-white text-blue-700 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-700' }}">
                            <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ" class="w-4 h-4 object-contain inline-block"> TPQ
                        </a>
                        <a href="{{ route('database_sekolah.index', ['jenis' => 'RTQ']) }}"
                           class="px-3 py-1.5 rounded-md text-xs font-semibold transition flex items-center gap-1.5 {{ request('jenis') == 'RTQ' ? 'bg-white text-emerald-700 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-700' }}">
                            <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ" class="w-4 h-4 object-contain inline-block"> RTQ
                        </a>
                    </div>

                    {{-- Export Buttons --}}
                    @php $navJenis = request('jenis', 'TPQ'); $navUnit = request('unit'); @endphp
                    <a href="{{ route('database_sekolah.export.excel', ['jenis' => $navJenis, 'unit' => $navUnit]) }}"
                       class="text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 px-3 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5"
                       title="Download Excel">
                        <i class="fa-solid fa-file-excel text-[11px]"></i> Excel
                    </a>
                    <a href="{{ route('database_sekolah.export.csv', ['jenis' => $navJenis, 'unit' => $navUnit]) }}"
                       class="text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-3 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5"
                       title="Download Spreadsheet / CSV">
                        <i class="fa-solid fa-table text-[11px]"></i> CSV
                    </a>

                    {{-- Input Santri --}}
                    <a href="{{ route('database_sekolah.create', ['jenis' => $navJenis]) }}"
                       class="bg-blue-700 hover:bg-blue-800 text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-user-plus text-[11px]"></i> Input Santri
                    </a>

                    {{-- Logout Button --}}
                    <div class="border-l border-slate-200 pl-1.5 ml-0.5">
                        <button type="button" onclick="openLogoutModal()" title="Keluar dari sistem"
                            class="flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition">
                            <i class="fa-solid fa-right-from-bracket"></i> Keluar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6" id="main-content">
        @if(session('success'))
            <div class="mb-5 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between no-print" id="flash-success">
                <div class="flex items-center">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-xl mr-3"></i>
                    <p class="text-sm font-medium text-emerald-900">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-3.5 px-6 text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2 no-print transition-colors">
        <div class="flex items-center gap-2 text-center sm:text-left">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Ar-Raudhah" class="w-5 h-5 object-contain inline-block shrink-0">
            <span>&copy; 2026 <strong class="text-slate-700 font-semibold">Yayasan Cahaya Amanah Ar-Raudhah</strong> • Banjarbaru, Kalimantan Selatan</span>
        </div>
        <div class="text-[11px] text-slate-400 text-center sm:text-right">
            Sistem Manajemen Database &amp; Penilaian Munaqasyah
        </div>
    </footer>

    @yield('scripts')

    <script>
        // =============================================
        // LOGOUT MODAL
        // =============================================
        function openLogoutModal() {
            const modal = document.getElementById('logout-modal');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logout-modal');
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }

        function confirmLogout() {
            const btn = document.getElementById('confirmLogoutBtn');
            const icon = document.getElementById('logoutBtnIcon');
            const text = document.getElementById('logoutBtnText');
            icon.className = 'fa-solid fa-spinner fa-spin';
            text.textContent = 'Keluar...';
            btn.disabled = true;
            // Submit the hidden form
            document.getElementById('logout-form').submit();
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLogoutModal();
        });

        // =============================================
        // PAGE TRANSITION
        // =============================================
        const overlay   = document.getElementById('page-overlay');
        const progress  = document.getElementById('page-progress');

        function startTransition(href) {
            // Start progress bar
            progress.style.width = '0%';
            progress.style.opacity = '1';
            setTimeout(() => { progress.style.width = '70%'; }, 10);

            // Fade overlay in
            overlay.classList.add('fade-in');
            overlay.classList.remove('fade-out');

            setTimeout(() => {
                progress.style.width = '100%';
                setTimeout(() => {
                    window.location.href = href;
                }, 150);
            }, 280);
        }

        // Intercept all internal navigation links
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('a[href]');
            links.forEach(link => {
                const href = link.getAttribute('href');
                // Skip: external, hash-only, download, mailto, tel, print, export
                if (!href
                    || href.startsWith('http') && !href.includes(window.location.host)
                    || href.startsWith('#')
                    || href.startsWith('mailto:')
                    || href.startsWith('tel:')
                    || link.hasAttribute('download')
                    || link.getAttribute('target') === '_blank'
                    || href.includes('/export/')
                ) return;

                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    startTransition(href);
                });
            });

            // Handle browser back/forward: remove overlay
            window.addEventListener('pageshow', function (e) {
                if (e.persisted) {
                    overlay.classList.remove('fade-in');
                    overlay.classList.add('fade-out');
                    progress.style.width = '0%';
                    progress.style.opacity = '0';
                }
            });
        });

        // Page enter: finish progress bar
        window.addEventListener('load', function () {
            progress.style.width = '100%';
            setTimeout(() => {
                progress.style.opacity = '0';
                progress.style.transition = 'opacity 0.4s ease, width 0.3s ease';
            }, 400);

            // Remove overlay on page load
            overlay.classList.remove('fade-in');
            overlay.classList.add('fade-out');
        });

        // Flash message auto-dismiss after 5s
        setTimeout(() => {
            const flash = document.getElementById('flash-success');
            if (flash) {
                flash.style.transition = 'opacity 0.5s ease, max-height 0.5s ease';
                flash.style.opacity = '0';
                setTimeout(() => flash.remove(), 500);
            }
        }, 5000);

        // Paksa refresh saat navigasi back/forward cache setelah logout
        window.addEventListener('pageshow', function (e) {
            if (e.persisted || (window.performance && window.performance.navigation && window.performance.navigation.type === 2) || (window.performance && window.performance.getEntriesByType && window.performance.getEntriesByType('navigation')[0]?.type === 'back_forward')) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>
