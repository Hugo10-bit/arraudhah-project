<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yayasan Cahaya Amanah Ar-Raudhah | Database Sekolah TPQ & RTQ</title>
    <meta name="description" content="Platform digital database sekolah, biodata & penilaian santri Taman Pendidikan Qur'an (TPQ) & Rumah Tahfidz Qur'an (RTQ) Ar-Raudhah, Yayasan Cahaya Amanah Ar-Raudhah Banjarbaru.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { colors: {
                blue: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#2563eb', 600: '#1d4ed8', 700: '#1e40af', 800: '#1e3a8a', 900: '#16285a', 950: '#081026' },
                red: { 50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171', 500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d', 950: '#450a0a' },
                rose: { 50: '#fff1f2', 100: '#ffe4e6', 200: '#fecdd3', 300: '#fda4af', 400: '#fb7185', 500: '#f43f5e', 600: '#e11d48', 700: '#be123c', 800: '#9f1239', 900: '#881337', 950: '#4c0519' }
            } } }
        };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Animated hero background matching official logo palette (Vibrant Royal Navy Dome) */
        .hero-bg {
            background: radial-gradient(circle at 50% 15%, #1e40af 0%, #1e3a8a 35%, #0f2256 70%, #071026 100%);
            background-size: 100% 100%;
        }

        /* Islamic SVG pattern overlay */
        .islamic-bg {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Feature card hover */
        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px -12px rgba(30, 58, 138, 0.2);
        }

        /* Stat counter card */
        .stat-card {
            background: rgba(14, 34, 84, 0.6);
            backdrop-filter: blur(12px);
            border: 1.5px solid rgba(96, 165, 250, 0.25);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            background: rgba(30, 58, 138, 0.4);
            transform: translateY(-3px);
            border-color: rgba(96, 165, 250, 0.6);
        }

        /* CTA button */
        .btn-cta {
            background: #1e3a8a;
            transition: all 0.2s ease;
        }
        .btn-cta:hover { background: #17317f; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(30,58,138,0.3); }

        /* Scroll reveal */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Navbar scroll effect */
        #navbar.scrolled {
            background: rgba(13, 26, 69, 0.97);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(30, 58, 138, 0.5);
            box-shadow: 0 2px 16px rgba(0,0,0,0.25);
        }
    </style>
</head>
<body class="bg-[#071026] text-slate-100 antialiased overflow-x-hidden">

    <!-- ===== NAVBAR ===== -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all bg-[#071026]/90 backdrop-blur-md border-b border-[#1e3a8a]/40 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <a href="#" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 bg-white rounded-2xl p-1 shadow-md border-2 border-[#1e3a8a] group-hover:border-blue-400 transition shrink-0 flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Yayasan" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <p class="text-sm sm:text-base font-black text-white tracking-tight leading-none">AR-RAUDHAH</p>
                        <p class="text-[10px] sm:text-xs text-blue-300 font-semibold leading-none mt-1">Yayasan Cahaya Amanah</p>
                    </div>
                </a>
                <div class="flex items-center gap-3 sm:gap-6">
                    <a href="#kategori" class="text-slate-200 hover:text-white text-xs sm:text-sm font-semibold transition hidden sm:block">Unit Lembaga</a>
                    <a href="#fitur" class="text-slate-200 hover:text-white text-xs sm:text-sm font-semibold transition hidden sm:block">Fitur Sistem</a>
                    <a href="#faq" class="text-slate-200 hover:text-white text-xs sm:text-sm font-semibold transition hidden sm:block">FAQ &amp; Bantuan</a>
                    <a href="{{ route('public.check') }}" class="text-white hover:text-amber-300 text-xs sm:text-sm font-bold transition inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#1e3a8a] border border-[#60a5fa]/50 shadow-md">
                        <i class="fa-solid fa-graduation-cap text-amber-300"></i> Cek Kelulusan
                    </a>
                    <a href="{{ route('login') }}"
                        class="btn-cta text-white font-bold text-xs sm:text-sm px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl flex items-center gap-2">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk Sistem
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ===== HERO SECTION ===== -->
    <section class="hero-bg min-h-screen flex flex-col items-center justify-center relative overflow-hidden pt-24 pb-16">
        <!-- Subtle Islamic pattern only -->
        <div class="absolute inset-0 islamic-bg"></div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
            <!-- Badge Yayasan -->
            <div class="inline-flex items-center gap-2.5 bg-[#0e2254]/90 border border-blue-400/40 rounded-full px-5 py-2 mb-6 backdrop-blur-md shadow-lg">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-5 h-5 object-contain bg-white rounded-full p-0.5 shadow">
                <span class="text-xs font-bold text-white uppercase tracking-widest">Yayasan Cahaya Amanah Ar-Raudhah</span>
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            </div>

            <!-- Arabic Bismillah -->
            <p class="amiri-text text-2xl sm:text-3xl lg:text-4xl mb-5 text-amber-200 font-bold" style="font-family:'Amiri',serif">بِسْمِ اللهِ الرَّحْمٰنِ الرَّحِيْمِ</p>

            <!-- Main Heading -->
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white leading-tight mb-4 tracking-tight">
                Database Sekolah
                <span class="block mt-2 text-white drop-shadow-sm">
                    TPQ &amp; RTQ Ar-Raudhah
                </span>
            </h1>

            <p class="text-blue-100 text-sm sm:text-base lg:text-lg max-w-2xl mx-auto leading-relaxed mb-8 font-normal">
                Platform digital resmi evaluasi, penilaian 9 mata uji, dan penerbitan surat kelulusan santri 
                <strong class="text-white font-bold">Taman Pendidikan Qur'an (TPQ)</strong> &amp; 
                <strong class="text-white font-bold">Rumah Tahfidz Qur'an (RTQ)</strong> Ar-Raudhah Banjarbaru.
            </p>

            <!-- Unit Pills -->
            <div class="flex flex-wrap items-center justify-center gap-3 mb-10">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white text-xs sm:text-sm font-semibold">
                    <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ" class="w-5 h-5 object-contain"> Taman Pendidikan Qur'an (TPQ)
                </span>
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 border border-white/20 text-white text-xs sm:text-sm font-semibold">
                    <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ" class="w-5 h-5 object-contain"> Rumah Tahfidz Qur'an (RTQ)
                </span>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                <a href="{{ route('login') }}"
                    class="btn-cta text-white font-black text-sm sm:text-base px-8 py-4 rounded-2xl flex items-center justify-center gap-2.5 shadow-2xl hover:scale-105 transition">
                    <i class="fa-solid fa-right-to-bracket text-lg"></i>
                    Masuk ke Sistem
                </a>
                <a href="{{ route('public.check') }}"
                    class="flex items-center justify-center gap-2.5 text-white font-black text-sm sm:text-base px-8 py-4 rounded-2xl border-2 border-[#60a5fa] bg-gradient-to-r from-[#1e3a8a] to-[#1d4ed8] hover:from-[#1d4ed8] hover:to-[#2563eb] shadow-xl shadow-[#1e3a8a]/40 hover:scale-105 transition">
                    <i class="fa-solid fa-graduation-cap text-amber-300 text-lg"></i>
                    Cek Kelulusan Santri
                </a>
                <a href="#fitur"
                    class="flex items-center justify-center gap-2 text-white/90 font-bold text-xs sm:text-sm px-6 py-4 rounded-2xl border-2 border-white/20 bg-white/10 backdrop-blur-sm hover:bg-white/20 transition">
                    <i class="fa-solid fa-circle-info"></i>
                    Fitur &amp; Mata Uji
                </a>
            </div>

            <!-- Scroll Indicator -->
            <div class="mt-14 flex flex-col items-center gap-2 animate-bounce">
                <span class="text-blue-300 text-xs font-semibold">Gulir ke bawah</span>
                <i class="fa-solid fa-chevron-down text-blue-300 text-xs"></i>
            </div>
        </div>
    </section>

    <!-- ===== STATS SECTION ===== -->
    <section class="bg-gradient-to-r from-[#071026] via-[#102456] to-[#071026] py-12 border-y-2 border-[#1e3a8a]/50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="stat-card rounded-2xl p-5 text-center bg-[#0d1e4a]/60 border border-[#3b82f6]/30 shadow-lg">
                    <p class="text-3xl sm:text-4xl font-black text-amber-400">2</p>
                    <p class="text-xs text-white font-bold uppercase tracking-wide mt-1">Lembaga Naungan</p>
                    <p class="text-[11px] text-blue-200 mt-0.5 font-semibold">TPQ &amp; RTQ Ar-Raudhah</p>
                </div>
                <div class="stat-card rounded-2xl p-5 text-center bg-[#0d1e4a]/60 border border-[#3b82f6]/30 shadow-lg">
                    <p class="text-3xl sm:text-4xl font-black text-amber-400">9</p>
                    <p class="text-xs text-white font-bold uppercase tracking-wide mt-1">Mata Uji Standar</p>
                    <p class="text-[11px] text-blue-200 mt-0.5 font-semibold">Tajwid, Gharib, &amp; Hafalan</p>
                </div>
                <div class="stat-card rounded-2xl p-5 text-center bg-[#0d1e4a]/60 border border-[#3b82f6]/30 shadow-lg">
                    <p class="text-3xl sm:text-4xl font-black text-amber-400">100%</p>
                    <p class="text-xs text-white font-bold uppercase tracking-wide mt-1">Digital &amp; Akurat</p>
                    <p class="text-[11px] text-blue-200 mt-0.5 font-semibold">Kalkulasi Otomatis</p>
                </div>
                <div class="stat-card rounded-2xl p-5 text-center bg-[#0d1e4a]/60 border border-[#3b82f6]/30 shadow-lg">
                    <p class="text-3xl sm:text-4xl font-black text-amber-400">1447 H</p>
                    <p class="text-xs text-white font-bold uppercase tracking-wide mt-1">Tahun Hijriyah</p>
                    <p class="text-[11px] text-blue-200 mt-0.5 font-semibold">1447 H / 2026 M</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== UNIT SECTION ===== -->
    <section id="kategori" class="py-20 bg-[#071026] relative">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-14 reveal">
                <span class="text-xs font-bold text-white uppercase tracking-widest bg-blue-700 px-4 py-1.5 rounded-full shadow-sm">Unit Pendidikan</span>
                <h2 class="text-2xl sm:text-4xl font-black text-white mt-4">
                    Lembaga Pendidikan Al-Qur'an Ar-Raudhah
                </h2>
                <p class="text-blue-200 text-sm mt-2 max-w-xl mx-auto">Membina generasi qur'ani yang berakhlak mulia melalui pembinaan tartil, tahsin, dan tahfidz yang terstruktur.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- TPQ Card (Official Royal Blue Identity) -->
                <div class="bg-gradient-to-br from-[#0c1a44] via-[#102560] to-[#183584] border border-blue-400/50 rounded-3xl p-8 shadow-xl shadow-[#1e3a8a]/20 hover:border-white transition reveal relative overflow-hidden">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-16 h-16 bg-white/10 backdrop-blur-xs border-2 border-[#60a5fa] rounded-2xl flex items-center justify-center p-1.5 shadow-lg overflow-hidden shrink-0">
                            <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ Ar-Raudhah" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <span class="text-[11px] font-bold text-blue-300 uppercase tracking-widest bg-blue-950/80 px-2.5 py-0.5 rounded-lg border border-blue-400/30">Unit 01 • TPQ</span>
                            <h3 class="text-xl sm:text-2xl font-black text-white mt-1">TPQ Ar-Raudhah</h3>
                            <p class="text-xs text-blue-200 font-semibold">Taman Pendidikan Qur'an Banjarbaru</p>
                        </div>
                    </div>
                    <p class="text-blue-100 text-sm leading-relaxed mb-6">
                        Fokus pada pembinaan dasar membaca Al-Qur'an dengan tartil, hukum tajwid praktis, makharijul huruf, gharib &amp; musykilat, adab harian, serta doa dan surat-surat pendek.
                    </p>
                    <div class="flex flex-wrap gap-2 text-xs font-bold text-white">
                        <span class="px-3 py-1.5 bg-[#0a1538] border border-[#3b82f6]/50 rounded-xl">Fashohah &amp; Tartil</span>
                        <span class="px-3 py-1.5 bg-[#0a1538] border border-[#3b82f6]/50 rounded-xl">Tajwid Praktis</span>
                        <span class="px-3 py-1.5 bg-[#0a1538] border border-[#3b82f6]/50 rounded-xl">Gharib Al-Qur'an</span>
                        <span class="px-3 py-1.5 bg-[#0a1538] border border-[#3b82f6]/50 rounded-xl">Hafalan Juz 'Amma</span>
                    </div>
                </div>

                <!-- RTQ Card (Official Islamic Emerald Identity) -->
                <div class="bg-gradient-to-br from-[#041a12] via-[#062b1e] to-[#0a3d2b] border border-emerald-500/50 rounded-3xl p-8 shadow-xl shadow-emerald-950/20 hover:border-white transition reveal relative overflow-hidden">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-16 h-16 bg-white border-2 border-emerald-400/50 rounded-2xl flex items-center justify-center p-1.5 shadow-lg overflow-hidden shrink-0">
                            <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ Ar-Raudhah" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <span class="text-[11px] font-bold text-emerald-300 uppercase tracking-widest bg-emerald-950/80 px-2.5 py-0.5 rounded-lg border border-emerald-400/30">Unit 02 • RTQ</span>
                            <h3 class="text-xl sm:text-2xl font-black text-white mt-1">RTQ Ar-Raudhah</h3>
                            <p class="text-xs text-emerald-200 font-semibold">Rumah Tahfidz Qur'an Banjarbaru</p>
                        </div>
                    </div>
                    <p class="text-emerald-100/90 text-sm leading-relaxed mb-6">
                        Program intensif penghafalan Al-Qur'an berjenjang dengan muraja'ah berkala, penguatan mutqin hafalan, dan pengujian kelayakan sanad hafalan santri binaan.
                    </p>
                    <div class="flex flex-wrap gap-2 text-xs font-bold text-white">
                        <span class="px-3 py-1.5 bg-[#03150e] border border-emerald-500/50 rounded-xl">Tahfidz Tematik</span>
                        <span class="px-3 py-1.5 bg-[#03150e] border border-emerald-500/50 rounded-xl">Tahfidz Juz 'Amma</span>
                        <span class="px-3 py-1.5 bg-[#03150e] border border-emerald-500/50 rounded-xl">Muraja'ah Berkala</span>
                        <span class="px-3 py-1.5 bg-[#03150e] border border-emerald-500/50 rounded-xl">Kelulusan Resmi</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FITUR SECTION (Clean Pure White & Royal Blue) ===== -->
    <section id="fitur" class="py-20 bg-gradient-to-b from-[#F0F5FF] via-white to-[#F0F5FF] text-slate-800 border-y-2 border-[#DBEAFE]">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-14 reveal">
                <span class="text-xs font-bold text-white uppercase tracking-widest bg-blue-800 px-4 py-1.5 rounded-full shadow-sm">Fitur Unggulan</span>
                <h2 class="text-3xl sm:text-4xl font-black text-[#0c1c46] mt-4 leading-tight">
                    Semua yang Dibutuhkan Penguji &amp; Panitia<br>
                    <span class="text-blue-700">dalam Satu Platform Terpadu</span>
                </h2>
                <p class="text-slate-600 mt-3 max-w-xl mx-auto text-sm">Dirancang khusus untuk Yayasan Cahaya Amanah Ar-Raudhah agar proses penilaian menjadi terstandar, objektif, dan efisien.</p>
            </div>

            <!-- Features Grid with Logo Color Accents -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- F1 -->
                <div class="feature-card bg-white rounded-3xl p-7 border border-slate-200 hover:border-blue-700 shadow-sm hover:shadow-xl transition-all duration-300 reveal">
                    <div class="w-14 h-14 bg-blue-800 text-white rounded-2xl flex items-center justify-center text-2xl mb-5 shadow-md shadow-blue-900/20">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-2">Penilaian 9 Mata Uji</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Form penilaian digital untuk 9 indikator resmi: Fashohah, Tajwid, Gharib, Dinul Islam, Ayat Pilihan, Praktek Sholat, Doa Harian, dan Tahfidz.</p>
                </div>
                <!-- F2 -->
                <div class="feature-card bg-white rounded-3xl p-7 border border-slate-200 hover:border-blue-700 shadow-sm hover:shadow-xl transition-all duration-300 reveal">
                    <div class="w-14 h-14 bg-blue-800 text-white rounded-2xl flex items-center justify-center text-2xl mb-5 shadow-md shadow-blue-900/20">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-2">Penentuan Kelulusan Otomatis</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Algoritma otomatis mengevaluasi nilai ambang batas kelulusan per mata uji secara transparan dan tanpa bias manusiawi.</p>
                </div>
                <!-- F3 -->
                <div class="feature-card bg-white rounded-3xl p-7 border border-slate-200 hover:border-blue-700 shadow-sm hover:shadow-xl transition-all duration-300 reveal">
                    <div class="w-14 h-14 bg-blue-800 text-white rounded-2xl flex items-center justify-center text-2xl mb-5 shadow-md shadow-blue-900/20">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-2">Surat Keterangan Kelulusan</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Penerbitan surat kelulusan resmi dengan kop yayasan, transkrip nilai 9 mata uji, pas foto santri, dan format siap cetak.</p>
                </div>
                <!-- F4 -->
                <div class="feature-card bg-white rounded-3xl p-7 border border-slate-200 hover:border-emerald-600 shadow-sm hover:shadow-xl transition-all duration-300 reveal">
                    <div class="w-14 h-14 bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-2xl mb-5 shadow-md shadow-emerald-600/20">
                        <i class="fa-solid fa-file-excel"></i>
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-2">Export Data Excel &amp; CSV</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Unduh seluruh rekapitulasi data santri database sekolah TPQ &amp; RTQ dalam format Excel/CSV dengan sekali klik.</p>
                </div>
                <!-- F5 -->
                <div class="feature-card bg-white rounded-3xl p-7 border border-slate-200 hover:border-blue-700 shadow-sm hover:shadow-xl transition-all duration-300 reveal">
                    <div class="w-14 h-14 bg-blue-800 text-white rounded-2xl flex items-center justify-center text-2xl mb-5 shadow-md shadow-blue-900/20">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-2">Upload Pas Foto Santri</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Manajemen foto santri resmi yang otomatis tersemat rapi pada surat keterangan kelulusan dan arsip database.</p>
                </div>
                <!-- F6 -->
                <div class="feature-card bg-white rounded-3xl p-7 border border-slate-200 hover:border-blue-700 shadow-sm hover:shadow-xl transition-all duration-300 reveal">
                    <div class="w-14 h-14 bg-blue-800 text-white rounded-2xl flex items-center justify-center text-2xl mb-5 shadow-md shadow-blue-900/20">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-2">Dashboard Statistik Real-Time</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Pantau grafik perolehan kelulusan, statistik santri lulus/tidak lulus, serta rekapitulasi nilai tertinggi &amp; terendah.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FAQ & TANYA JAWAB SECTION ===== -->
    <section id="faq" class="py-20 bg-[#071026] relative border-t-2 border-[#1e3a8a]/40">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-12 reveal">
                <span class="text-xs font-bold text-white uppercase tracking-widest bg-blue-700 px-4 py-1.5 rounded-full shadow-sm">
                    Pertanyaan Umum
                </span>
                <h2 class="text-2xl sm:text-4xl font-black text-white mt-4 leading-tight">
                    Frequently Asked Questions (FAQ)
                </h2>
                <p class="text-blue-200 text-xs sm:text-sm mt-2 max-w-lg mx-auto">
                    Temukan jawaban atas pertanyaan seputar penilaian, syarat kelulusan database sekolah santri, dan pengembang platform.
                </p>
            </div>

            <!-- FAQ List -->
            <div class="space-y-4 reveal">
                <!-- Q1: Pengelola -->
                <div class="bg-gradient-to-r from-[#0d1c44] to-[#1e3a8a]/50 border border-blue-400/30 rounded-2xl p-6 shadow-xl shadow-[#1e3a8a]/20">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-700 text-white flex items-center justify-center text-xl shrink-0 shadow-md">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white mb-1.5 flex items-center gap-2">
                                Siapa yang mengelola sistem database sekolah ini?
                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-blue-600 text-white uppercase shadow-sm">Pengelola</span>
                            </h3>
                            <p class="text-blue-100 text-xs sm:text-sm leading-relaxed">
                                Sistem ini dikelola dan dioperasikan secara resmi oleh Tim Manajemen Data dan Panitia <strong class="text-white">Yayasan Cahaya Amanah Ar-Raudhah Banjarbaru</strong> untuk standarisasi penilaian santri TPQ dan RTQ.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Q2: 9 Mata Uji -->
                <div class="bg-[#0b1636]/80 border border-blue-400/20 hover:border-blue-400/60 rounded-2xl p-6 transition shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-800 text-white flex items-center justify-center text-xl shrink-0 shadow-md">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white mb-1.5">Apa saja 9 mata uji standar yang dinilai?</h3>
                            <p class="text-blue-100 text-xs sm:text-sm leading-relaxed">
                                Sembilan mata uji resmi meliputi: <strong class="text-white">Fashohah</strong>, <strong class="text-white">Tajwid</strong>, <strong class="text-white">Gharib &amp; Musykilat</strong>, <strong class="text-white">Suara &amp; Lagu</strong>, <strong class="text-white">Ayat Pilihan</strong>, <strong class="text-white">Surah Pendek (Juz 'Amma)</strong>, <strong class="text-white">Doa Harian</strong>, <strong class="text-white">Bacaan Shalat</strong>, dan <strong class="text-white">Ujian Tertulis Dinul Islam</strong>.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Q3: Cetak Surat -->
                <div class="bg-[#0b1636]/80 border border-blue-400/20 hover:border-blue-400/60 rounded-2xl p-6 transition shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-800 text-white flex items-center justify-center text-xl shrink-0 shadow-md">
                            <i class="fa-solid fa-print"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white mb-1.5">Bagaimana cara menerbitkan surat keterangan kelulusan?</h3>
                            <p class="text-blue-100 text-xs sm:text-sm leading-relaxed">
                                Panitia atau penguji cukup membuka daftar nilai TPQ/RTQ, memilih santri terkait, lalu menekan tombol <strong class="text-amber-300">"Sertifikat"</strong>. Halaman surat kelulusan resmi dengan kop yayasan, transkrip 9 mata uji, dan pas foto santri akan langsung siap cetak atau disimpan ke format PDF.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Q4: Export Data -->
                <div class="bg-[#0b1636]/80 border border-blue-400/20 hover:border-blue-400/60 rounded-2xl p-6 transition shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-emerald-600/30">
                            <i class="fa-solid fa-file-excel"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white mb-1.5">Apakah data rekapitulasi bisa diunduh ke Excel?</h3>
                            <p class="text-blue-100 text-xs sm:text-sm leading-relaxed">
                                Ya, sistem menyediakan dua format unduhan: <strong class="text-white">Microsoft Excel (.xls)</strong> lengkap dengan format tabel formal, dan <strong class="text-white">CSV Spreadsheet (.csv)</strong> yang dapat dibuka langsung di Google Sheets kapan saja.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chatbot CTA Prompt -->
            <div class="mt-8 p-6 rounded-2xl bg-[#0b1636]/90 border border-blue-400/30 text-center reveal shadow-xl">
                <p class="text-white font-bold text-sm mb-1 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-robot text-blue-400"></i> Punya pertanyaan lain yang belum terjawab?
                </p>
                <p class="text-blue-200 text-xs mb-4">Gunakan Asisten Virtual Ar-Raudhah interaktif yang selalu siap menjawab 24/7.</p>
                <button type="button" onclick="toggleChatbot()"
                        class="btn-cta inline-flex items-center gap-2 text-white font-black text-xs sm:text-sm px-6 py-3 rounded-xl shadow-lg cursor-pointer">
                    <i class="fa-solid fa-comments"></i> Buka Chatbot Asisten
                </button>
            </div>
        </div>
    </section>

    <!-- ===== TENTANG SECTION ===== -->
    <section id="tentang" class="py-20 bg-gradient-to-br from-[#060e22] via-[#0d1d44] to-[#162d6b] relative overflow-hidden border-t-2 border-[#1e3a8a]/40">
        <div class="absolute inset-0 islamic-bg opacity-40"></div>
        <div class="max-w-4xl mx-auto px-4 relative z-10">
            <div class="text-center reveal">
                <p class="arabic-shimmer text-3xl font-bold mb-4">اِقْرَأْ بِاسْمِ رَبِّكَ الَّذِيْ خَلَقَ</p>
                <h2 class="text-3xl sm:text-4xl font-black text-white mb-4">
                    Yayasan Cahaya Amanah Ar-Raudhah
                </h2>
                <p class="text-blue-100 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto mb-10">
                    Berdedikasi dalam pendidikan Al-Qur'an di Banjarbaru melalui 
                    <strong class="text-amber-300 font-bold">Taman Pendidikan Qur'an (TPQ) Ar-Raudhah</strong> dan 
                    <strong class="text-emerald-300 font-bold">Rumah Tahfidz Qur'an (RTQ) Ar-Raudhah</strong>. 
                    Platform ini hadir untuk menjamin akuntabilitas, validitas, dan standar kualitas para santri lulusan.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-[#081330]/80 border-2 border-[#3b82f6]/30 rounded-2xl p-5 text-center backdrop-blur-sm shadow-lg">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/20 text-blue-300 border border-blue-400/40 flex items-center justify-center text-xl mx-auto mb-3">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <p class="font-bold text-white text-sm">Aman &amp; Terverifikasi</p>
                        <p class="text-blue-200 text-xs mt-1">Akses khusus akun panitia &amp; penguji</p>
                    </div>
                    <div class="bg-[#081330]/80 border-2 border-[#3b82f6]/30 rounded-2xl p-5 text-center backdrop-blur-sm shadow-lg">
                        <div class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-300 border border-amber-500/40 flex items-center justify-center text-xl mx-auto mb-3">
                            <i class="fa-solid fa-calculator"></i>
                        </div>
                        <p class="font-bold text-white text-sm">Kalkulasi Cepat</p>
                        <p class="text-blue-200 text-xs mt-1">Penghitungan nilai otomatis &amp; akurat</p>
                    </div>
                    <div class="bg-[#081330]/80 border-2 border-[#3b82f6]/30 rounded-2xl p-5 text-center backdrop-blur-sm shadow-lg">
                        <div class="w-12 h-12 rounded-xl bg-[#1e3a8a]/40 text-[#60a5fa] border border-[#3b82f6]/40 flex items-center justify-center text-xl mx-auto mb-3">
                            <i class="fa-solid fa-print"></i>
                        </div>
                        <p class="font-bold text-white text-sm">Cetak Surat Kelulusan</p>
                        <p class="text-blue-200 text-xs mt-1">Format siap cetak berkop resmi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA FINAL ===== -->
    <section class="py-16 bg-[#071026]">
        <div class="max-w-3xl mx-auto px-4 text-center reveal">
            <div class="bg-gradient-to-br from-[#091536] via-[#102456] to-[#183584] border-2 border-[#3b82f6]/50 rounded-3xl p-8 sm:p-12 shadow-2xl relative overflow-hidden">
                <div class="absolute inset-0 islamic-bg opacity-30"></div>
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-white rounded-2xl p-1.5 shadow-2xl mx-auto mb-5 border-2 border-[#1e3a8a] flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Yayasan" class="w-full h-full object-contain">
                    </div>
                    <h2 class="text-xl sm:text-3xl font-black text-white mb-2">Yayasan Cahaya Amanah Ar-Raudhah</h2>
                    <p class="text-blue-100 text-xs sm:text-sm mb-8 max-w-md mx-auto">
                        Taman Pendidikan Qur'an (TPQ) &amp; Rumah Tahfidz Qur'an (RTQ) Ar-Raudhah Banjarbaru.
                    </p>
                    <a href="{{ route('login') }}"
                        class="btn-cta inline-flex items-center gap-2.5 text-white font-black text-sm sm:text-base px-9 py-4 rounded-2xl shadow-xl hover:scale-105 transition">
                        <i class="fa-solid fa-right-to-bracket text-lg"></i>
                        Masuk ke Sistem Penilaian
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-[#040814] border-t-2 border-[#1e3a8a]/40 py-8 text-center text-slate-400">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-2">
                <div class="w-8 h-8 bg-white rounded-lg p-0.5 shadow flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Ar-Raudhah" class="w-full h-full object-contain">
                </div>
                <span class="text-white font-bold text-sm">Yayasan Cahaya Amanah Ar-Raudhah</span>
                <span class="hidden sm:inline text-slate-600">•</span>
                <span class="text-[#60a5fa] text-xs font-semibold">TPQ &amp; RTQ Ar-Raudhah Banjarbaru, Kalimantan Selatan</span>
            </div>
            <p class="text-xs text-slate-400">
                &copy; 2026 Database Sekolah Santri. Yayasan Cahaya Amanah Ar-Raudhah. Seluruh hak cipta dilindungi.
            </p>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 40);
        });

        // Scroll reveal
        const revealEls = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), i * 70);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        revealEls.forEach(el => observer.observe(el));
    </script>

    {{-- Floating FAQ Chatbot Widget --}}
    @include('partials.chatbot')
</body>
</html>
