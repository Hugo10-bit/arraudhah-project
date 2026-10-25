<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Cek Kelulusan Santri | Yayasan Cahaya Amanah Ar-Raudhah</title>
    <meta name="description" content="Portal mandiri pengecekan kelulusan dan nilai database sekolah santri TPQ & RTQ Ar-Raudhah Yayasan Cahaya Amanah Ar-Raudhah Banjarbaru.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <script>
        window.tailwind = window.tailwind || {};
        window.tailwind.config = {
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
        .hero-bg {
            background: linear-gradient(135deg, #070d1e 0%, #0c1836 30%, #152c64 65%, #070d1e 100%);
        }
        .islamic-bg {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .text-shimmer {
            background: linear-gradient(90deg, #fde68a, #fbbf24, #f59e0b, #fbbf24, #fde68a);
            background-size: 250% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 4s linear infinite;
        }
        @keyframes shimmer { from{background-position:0%} to{background-position:250%} }
        .btn-cta {
            background: #2563eb;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
            transition: all 0.2s ease;
        }
        .btn-cta:hover { background: #1d4ed8; transform:translateY(-1px); box-shadow:0 6px 20px rgba(37, 99, 235, 0.4); }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col justify-between selection:bg-amber-400 selection:text-slate-900">

    {{-- ===== NAVBAR ===== --}}
    <nav class="bg-slate-950/80 backdrop-blur-md border-b border-white/10 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Yayasan" class="w-10 h-10 object-contain bg-white rounded-xl p-1 shadow-md group-hover:scale-105 transition">
                <div>
                    <p class="text-sm font-black text-white leading-none">AR-RAUDHAH</p>
                    <p class="text-[10px] text-slate-400 font-semibold leading-none mt-1">Yayasan Cahaya Amanah</p>
                </div>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('landing') }}" class="text-xs text-slate-300 hover:text-white font-semibold transition hidden sm:inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-house text-[10px]"></i> Beranda
                </a>
                <a href="{{ route('login') }}" class="text-xs font-bold text-slate-200 hover:text-white bg-white/10 hover:bg-white/15 px-3.5 py-2 rounded-xl border border-white/10 transition">
                    <i class="fa-solid fa-lock mr-1"></i> Login Panitia
                </a>
            </div>
        </div>
    </nav>

    {{-- ===== MAIN SECTION ===== --}}
    <main class="hero-bg relative flex-1 py-12 px-4 overflow-hidden">
        <div class="absolute inset-0 islamic-bg pointer-events-none"></div>

        <div class="relative z-10 max-w-4xl mx-auto space-y-8">

            {{-- Title Header --}}
            <div class="text-center space-y-2">
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3.5 py-1 text-xs font-bold text-amber-300 backdrop-blur-sm">
                    <i class="fa-solid fa-graduation-cap"></i> Portal Publik Wali Santri
                </div>
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    Cek Pengumuman &amp; Nilai Kelulusan
                    <span class="text-shimmer block text-xl sm:text-3xl mt-1">Database Sekolah Santri 2026</span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto">
                    Masukkan nomor peserta ujian atau nama lengkap santri untuk melihat hasil kelulusan dan transkrip nilai resmi.
                </p>
            </div>

            {{-- Search Box Card --}}
            <div class="bg-slate-900/90 backdrop-blur-xl border border-white/15 rounded-3xl p-5 sm:p-7 shadow-2xl">
                <form action="{{ route('public.check') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                        <div class="sm:col-span-8 relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="q" value="{{ $keyword }}" required autofocus
                                placeholder="Contoh: 001 atau Muhammad Rayhan..."
                                class="w-full bg-slate-950/70 border border-slate-700 text-white rounded-2xl pl-11 pr-4 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition placeholder:text-slate-500">
                        </div>
                        <div class="sm:col-span-4">
                            <select name="jenis"
                                class="w-full bg-slate-950/70 border border-slate-700 text-white rounded-2xl px-4 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition">
                                <option value="" {{ empty($jenis) ? 'selected' : '' }}>Semua Jenjang (TPQ &amp; RTQ)</option>
                                <option value="TPQ" {{ $jenis == 'TPQ' ? 'selected' : '' }}>TPQ Ar-Raudhah</option>
                                <option value="RTQ" {{ $jenis == 'RTQ' ? 'selected' : '' }}>RTQ Ar-Raudhah</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <p class="text-[11px] text-slate-400">
                            *Pencarian peka terhadap nomor dada atau nama santri
                        </p>
                        <button type="submit" class="btn-cta text-white font-extrabold text-xs sm:text-sm px-6 py-3 rounded-xl flex items-center gap-2">
                            <i class="fa-solid fa-search"></i> Cek Sekarang
                        </button>
                    </div>
                </form>
            </div>

            {{-- ===== SEARCH RESULTS ===== --}}
            @if($searched)
                @if($santri)
                    {{-- SINGLE DIRECT RESULT --}}
                    @php
                        $p = $santri->penilaian;
                        $isLulus = $santri->status_kelulusan === 'LULUS';
                    @endphp
                    <div class="bg-white text-slate-900 rounded-3xl shadow-2xl overflow-hidden border border-slate-200">
                        {{-- Banner Status --}}
                        <div class="{{ $isLulus ? 'bg-gradient-to-r from-emerald-600 to-teal-700' : 'bg-gradient-to-r from-rose-600 to-red-700' }} text-white px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-xl shrink-0">
                                    <i class="fa-solid {{ $isLulus ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold tracking-widest text-white/80">Hasil Database Sekolah 2026</p>
                                    <h3 class="text-lg font-black tracking-tight">
                                        {{ $isLulus ? 'ALHAMDULILLAH, DINYATAKAN LULUS' : 'DINYATAKAN BELUM LULUS (PERBAIKAN)' }}
                                    </h3>
                                </div>
                            </div>
                            <span class="text-xs font-black bg-white text-slate-900 px-3.5 py-1.5 rounded-xl shadow-xs self-start sm:self-auto">
                                {{ $p->predikat ?? ($isLulus ? 'LULUS' : 'PERBAIKAN') }}
                            </span>
                        </div>

                        {{-- Body Santri Info --}}
                        <div class="p-6 sm:p-8 space-y-6">
                            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 pb-6 border-b border-slate-100">
                                <div class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-slate-200 shadow-md bg-slate-50 shrink-0">
                                    <img src="{{ $santri->foto_url }}" alt="{{ $santri->nama }}" class="w-full h-full object-cover">
                                </div>
                                <div class="text-center sm:text-left flex-1 min-w-0">
                                    <div class="flex items-center justify-center sm:justify-start gap-2 flex-wrap mb-1">
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[10px] font-black rounded-lg {{ $santri->jenis == 'TPQ' ? 'bg-amber-100 text-amber-900' : 'bg-blue-100 text-blue-900' }}">
                                            @if($santri->jenis == 'TPQ')
                                                <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ" class="w-3.5 h-3.5 object-contain">
                                            @elseif($santri->jenis == 'RTQ')
                                                <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ" class="w-3.5 h-3.5 object-contain">
                                            @endif
                                            {{ $santri->jenis == 'TPQ' ? "Taman Pendidikan Qur'an (TPQ)" : "Rumah Tahfidz Qur'an (RTQ)" }}
                                        </span>
                                        <span class="font-mono text-[10px] bg-slate-100 text-slate-700 px-2 py-0.5 rounded-lg font-bold">
                                            No. Peserta: #{{ $santri->no_peserta }}
                                        </span>
                                    </div>
                                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">{{ $santri->nama }}</h2>
                                    <p class="text-xs text-slate-500 mt-1">
                                        Asal Unit: <strong class="text-slate-800">{{ $santri->nama_unit ?? '-' }}</strong> (Kode: {{ $santri->no_unit ?? '01' }})
                                    </p>
                                </div>
                                <div class="text-center sm:text-right bg-slate-50 p-4 rounded-2xl border border-slate-200 shrink-0 min-w-[120px]">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Nilai Rata-Rata</p>
                                    <p class="text-3xl font-black text-blue-950 mt-0.5">{{ number_format($p?->rata_rata ?? 0, 1) }}</p>
                                    <p class="text-[10px] text-slate-500">Total: {{ $p?->jumlah_nilai ?? 0 }}</p>
                                </div>
                            </div>

                            {{-- Scores Breakdown Table --}}
                            <div>
                                <h4 class="text-xs font-black uppercase text-slate-700 mb-3 flex items-center gap-1.5">
                                    <i class="fa-solid fa-list-check text-blue-900"></i> Rincian 9 Komponen Nilai Database Sekolah
                                </h4>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    {{-- Kelompok 1: Bacaan --}}
                                    <div class="bg-amber-50/70 border border-amber-200 rounded-2xl p-4 space-y-2">
                                        <p class="text-[11px] font-black text-amber-900 uppercase">Database Sekolah Bacaan</p>
                                        <div class="flex justify-between text-xs text-slate-700"><span>Fashohah</span><strong class="font-mono">{{ $p?->fashohah ?? 0 }}</strong></div>
                                        <div class="flex justify-between text-xs text-slate-700"><span>Tajwid</span><strong class="font-mono">{{ $p?->tajwid ?? 0 }}</strong></div>
                                        <div class="flex justify-between text-xs text-slate-700"><span>Gharib &amp; Musykilat</span><strong class="font-mono">{{ $p?->gharib_musykilat ?? 0 }}</strong></div>
                                        <div class="flex justify-between text-xs text-slate-700"><span>Suara &amp; Lagu</span><strong class="font-mono">{{ $p?->suara_lagu ?? 0 }}</strong></div>
                                    </div>

                                    {{-- Kelompok 2: Hafalan --}}
                                    <div class="bg-blue-50/70 border border-blue-200 rounded-2xl p-4 space-y-2">
                                        <p class="text-[11px] font-black text-blue-900 uppercase">Database Sekolah Hafalan</p>
                                        <div class="flex justify-between text-xs text-slate-700"><span>Ayat-ayat Pilihan</span><strong class="font-mono">{{ $p?->ayat_pilihan ?? 0 }}</strong></div>
                                        <div class="flex justify-between text-xs text-slate-700"><span>Surah-surah Pendek</span><strong class="font-mono">{{ $p?->surah_pendek ?? 0 }}</strong></div>
                                        <div class="flex justify-between text-xs text-slate-700"><span>Do'a Harian</span><strong class="font-mono">{{ $p?->doa_harian ?? 0 }}</strong></div>
                                        <div class="flex justify-between text-xs text-slate-700"><span>Bacaan Shalat</span><strong class="font-mono">{{ $p?->bacaan_shalat ?? 0 }}</strong></div>
                                    </div>

                                    {{-- Kelompok 3: Ujian Tertulis & Ringkasan --}}
                                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-3 flex flex-col justify-between">
                                        <div>
                                            <p class="text-[11px] font-black text-slate-800 uppercase">Ujian Tertulis</p>
                                            <div class="flex justify-between text-xs text-slate-700 mt-2"><span>Ujian Tulis</span><strong class="font-mono">{{ $p?->ujian_tertulis ?? 0 }}</strong></div>
                                        </div>
                                        <div class="pt-3 border-t border-slate-200">
                                            <p class="text-[10px] text-slate-400 uppercase font-bold">Catatan Penguji</p>
                                            <p class="text-xs italic text-slate-600 mt-0.5">{{ $p?->catatan ?: 'Pertahankan prestasi belajar Al-Qur\'an.' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                                <p class="text-[11px] text-slate-500 text-center sm:text-left">
                                    <i class="fa-solid fa-shield-halved text-emerald-600 mr-1"></i>
                                    Terverifikasi resmi oleh Database Sekolah Yayasan Cahaya Amanah Ar-Raudhah
                                </p>
                                <a href="{{ route('public.check.cetak', $santri->id) }}" target="_blank"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-950 to-slate-900 hover:from-slate-900 hover:to-blue-950 text-white font-extrabold text-xs px-6 py-3 rounded-xl shadow-md hover:shadow-lg transition active:scale-95">
                                    <i class="fa-solid fa-print"></i> Lihat &amp; Cetak Surat Kelulusan
                                </a>
                            </div>
                        </div>
                    </div>
                @elseif($allResults->count() > 1)
                    {{-- MULTIPLE MATCHES FOUND --}}
                    <div class="bg-slate-900/90 border border-white/15 rounded-3xl p-6 shadow-2xl space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-extrabold text-white flex items-center gap-2">
                                <i class="fa-solid fa-users text-amber-400"></i> Ditemukan {{ $allResults->count() }} Data Santri
                            </h3>
                            <span class="text-xs text-slate-400">Pilih salah satu di bawah</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($allResults as $s)
                                <a href="{{ route('public.check', ['q' => $s->no_peserta, 'jenis' => $s->jenis]) }}"
                                    class="p-4 bg-slate-800/80 hover:bg-slate-800 border border-slate-700 hover:border-amber-400/50 rounded-2xl transition flex items-center gap-3.5 group">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-700 shrink-0 border border-slate-600">
                                        <img src="{{ $s->foto_url }}" alt="{{ $s->nama }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded {{ $s->jenis == 'TPQ' ? 'bg-amber-400/20 text-amber-300' : 'bg-blue-400/20 text-blue-300' }}">{{ $s->jenis }}</span>
                                            <span class="text-[10px] font-mono text-slate-400">#{{ $s->no_peserta }}</span>
                                        </div>
                                        <p class="text-sm font-bold text-white group-hover:text-amber-300 truncate mt-0.5">{{ $s->nama }}</p>
                                        <p class="text-[11px] text-slate-400 truncate">{{ $s->nama_unit ?? '-' }}</p>
                                    </div>
                                    <div class="shrink-0 text-right">
                                        <span class="text-xs font-black {{ $s->status_kelulusan == 'LULUS' ? 'text-emerald-400' : 'text-rose-400' }}">
                                            {{ $s->status_kelulusan }}
                                        </span>
                                        <i class="fa-solid fa-chevron-right text-xs text-slate-500 block mt-1"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- NOT FOUND --}}
                    <div class="bg-slate-900/90 border border-white/15 rounded-3xl p-10 text-center shadow-2xl space-y-3">
                        <div class="w-16 h-16 rounded-full bg-rose-500/10 text-rose-400 mx-auto flex items-center justify-center text-2xl border border-rose-500/20">
                            <i class="fa-solid fa-user-slash"></i>
                        </div>
                        <h3 class="text-lg font-black text-white">Data Santri Tidak Ditemukan</h3>
                        <p class="text-xs text-slate-400 max-w-md mx-auto">
                            Tidak ada data database sekolah yang cocok dengan kata kunci "<strong>{{ $keyword }}</strong>". Silakan periksa kembali ejaan nama atau nomor peserta yang dimasukkan.
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('public.check') }}" class="text-xs font-bold text-amber-400 hover:underline">
                                <i class="fa-solid fa-arrow-rotate-left mr-1"></i> Reset Pencarian
                            </a>
                        </div>
                    </div>
                @endif
            @endif

        </div>
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-slate-950 border-t border-white/10 py-6 px-4 text-center text-xs text-slate-400">
        <div class="flex items-center justify-center gap-2 mb-1.5 flex-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Ar-Raudhah" class="w-5 h-5 object-contain inline-block">
            <span class="text-white font-semibold">&copy; 2026 Yayasan Cahaya Amanah Ar-Raudhah</span>
            <span class="text-slate-600">•</span>
            <span class="text-blue-400 text-xs font-medium">TPQ &amp; RTQ Ar-Raudhah Banjarbaru, Kalimantan Selatan</span>
        </div>
        <p class="text-[11px] text-slate-500">
            Sistem Informasi Kelulusan &amp; Database Santri • Seluruh hak cipta dilindungi.
        </p>
    </footer>

</body>
</html>
