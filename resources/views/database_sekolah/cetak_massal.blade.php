<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Massal Surat Kelulusan Database Sekolah {{ $jenis }} | Yayasan Cahaya Amanah Ar-Raudhah</title>
    <script>
        window.tailwind = window.tailwind || {};
        window.tailwind.config = { theme: { extend: { colors: {
            blue: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#2563eb', 600: '#1d4ed8', 700: '#1e40af', 800: '#1e3a8a', 900: '#16285a', 950: '#081026' },
            red: { 50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171', 500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d', 950: '#450a0a' },
            rose: { 50: '#fff1f2', 100: '#ffe4e6', 200: '#fecdd3', 300: '#fda4af', 400: '#fb7185', 500: '#f43f5e', 600: '#e11d48', 700: '#be123c', 800: '#9f1239', 900: '#881337', 950: '#4c0519' }
        } } } };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; margin: 0 !important; padding: 0 !important; }
            .sheet-page {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 1.5cm 1.5cm !important;
                width: 100% !important;
                max-width: 100% !important;
                page-break-after: always !important;
                break-after: page !important;
            }
            .sheet-page:last-of-type {
                page-break-after: auto !important;
                break-after: auto !important;
            }
        }
        @page {
            size: A4 portrait;
            margin: 0;
        }
        .table-nilai th, .table-nilai td {
            border: 1px solid #0f172a;
            padding: 3px 6px;
            text-align: center;
        }
        .table-nilai th {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen">

    <!-- Top Action Bar (Floating, No-Print) -->
    <div class="no-print sticky top-0 z-50 bg-slate-900/95 backdrop-blur-md text-white border-b border-slate-800 px-4 py-3 shadow-xl">
        <div class="max-w-4xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('database_sekolah.index', ['jenis' => $jenis]) }}"
                   class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-slate-300 hover:text-white transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-sm font-black leading-tight flex items-center gap-2">
                        <span>Cetak Massal Surat Kelulusan</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-600 text-white uppercase">{{ $jenis }}</span>
                    </h1>
                    <p class="text-xs text-slate-400">Total: <strong class="text-white">{{ $santris->count() }} Dokumen Santri</strong> siap cetak / simpan ke PDF.</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="window.print()"
                        class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-md transition flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Semua ({{ $santris->count() }} Lembar)</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Container of Multi-Page Sheets -->
    <div class="py-6 sm:py-10 space-y-8 print:py-0 print:space-y-0">
        @foreach($santris as $index => $santri)
        @php
            $p = $santri->penilaian;
            $unitText = $santri->jenis == 'TPQ' ? "Taman Pendidikan Qur'an Ar-Raudhah (TPQ)" : "Rumah Tahfidz Qur'an Ar-Raudhah (RTQ)";
            $kepalaNama = $santri->jenis == 'TPQ' ? ($settings['kepala_tpq'] ?? 'Ustadz Muhammad Syauqi, S.Ag') : ($settings['kepala_rtq'] ?? 'Ustadzah Nurul Fatimah, S.Pd');
        @endphp

        <!-- Single Sheet Page (A4) -->
        <div class="sheet-page max-w-3xl mx-auto bg-white p-8 sm:p-12 shadow-lg border border-slate-200 rounded-2xl relative overflow-hidden">

            <!-- Watermark Logo Resmi Yayasan / Unit -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none z-0">
                <img src="{{ $santri->jenis === 'TPQ' ? asset('images/logo_tpq.png') : ($santri->jenis === 'RTQ' ? asset('images/logo_rtq.png') : asset('images/logo.png')) }}" alt="Watermark" class="w-80 h-80 sm:w-96 sm:h-96 object-contain opacity-[0.05] grayscale">
            </div>

            <!-- Header Kop Surat -->
            <div class="border-b-2 border-slate-900 pb-4 mb-4 text-center">
                <div class="flex items-center justify-center gap-4">
                    <img src="{{ $santri->jenis === 'TPQ' ? asset('images/logo_tpq.png') : ($santri->jenis === 'RTQ' ? asset('images/logo_rtq.png') : asset('images/logo.png')) }}" alt="Logo" class="w-16 h-16 object-contain shrink-0">
                    <div>
                        <h3 class="text-xs font-black tracking-wider text-blue-950 uppercase">{{ $settings['nama_yayasan'] ?? 'YAYASAN CAHAYA AMANAH AR-RAUDHAH' }}</h3>
                        <h1 class="text-lg font-black text-slate-900 tracking-tight">PANITIA DATABASE SEKOLAH BANJARBARU</h1>
                        <p class="text-[11px] text-slate-600 font-semibold">{{ $settings['alamat_yayasan'] ?? 'Banjarbaru, Kalimantan Selatan' }} • Periode {{ $settings['tahun_ajaran'] ?? '1447 H / 2026 M' }}</p>
                    </div>
                </div>
            </div>

            <!-- Judul Surat -->
            <div class="text-center mb-5">
                <h2 class="text-sm font-extrabold uppercase text-slate-900 tracking-wide underline decoration-slate-900 decoration-2 underline-offset-4">
                    SURAT KETERANGAN HASIL UJIAN DATABASE SEKOLAH
                </h2>
                <p class="text-[11px] text-slate-500 mt-0.5 font-mono">
                    Nomor: {{ $settings['nomor_sk_munaqasyah'] ?? $settings['nomor_sk_database sekolah'] ?? ('SKM/' . $santri->jenis . '/2026/' . str_pad($santri->no_peserta ?? $santri->id, 4, '0', STR_PAD_LEFT)) }}
                </p>
            </div>

            <!-- Biodata & Pas Foto -->
            <div class="flex items-start justify-between gap-5 mb-5 p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-xs">
                <div class="flex-1 space-y-1">
                    <div class="flex">
                        <span class="w-32 font-semibold text-slate-600 shrink-0">Nomor Peserta</span>
                        <span class="w-3 text-center shrink-0">:</span>
                        <span class="font-bold text-slate-900 font-mono">{{ $santri->no_peserta ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 font-semibold text-slate-600 shrink-0">Nomor Unit</span>
                        <span class="w-3 text-center shrink-0">:</span>
                        <span class="font-bold text-slate-900">{{ $santri->no_unit ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 font-semibold text-slate-600 shrink-0">Nama Lengkap</span>
                        <span class="w-3 text-center shrink-0">:</span>
                        <span class="font-extrabold text-slate-900 uppercase text-xs sm:text-sm tracking-wide">{{ $santri->nama }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 font-semibold text-slate-600 shrink-0">Lembaga Naungan</span>
                        <span class="w-3 text-center shrink-0">:</span>
                        <span class="font-bold text-slate-900">{{ $santri->nama_unit ?? 'AL-FALAH' }} • {{ $unitText }}</span>
                    </div>
                </div>

                <!-- Pas Foto -->
                <div class="w-20 h-26 shrink-0 border border-slate-300 bg-white rounded-lg p-1 shadow-2xs text-center flex flex-col items-center justify-center">
                    @if($santri->foto)
                        <img src="{{ asset('storage/' . $santri->foto) }}" alt="Foto {{ $santri->nama }}" class="w-full h-full object-cover rounded">
                    @else
                        <div class="w-full h-full border border-dashed border-slate-300 rounded flex flex-col items-center justify-center bg-slate-50 text-[9px] text-slate-400 font-bold p-1">
                            <span>PAS FOTO</span>
                            <span>3 x 4</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tabel 9 Mata Uji -->
            <div class="mb-5">
                <table class="w-full table-nilai text-xs">
                    <thead>
                        <tr class="bg-slate-900 text-white">
                            <th class="w-8">NO</th>
                            <th class="text-left pl-3">MATA UJI DATABASE SEKOLAH</th>
                            <th class="w-24">NILAI</th>
                            <th class="w-28">STANDAR</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr class="bg-slate-100 font-bold text-slate-800 text-left">
                            <td colspan="4" class="px-2 py-0.5 text-[10px]">A. KELOMPOK AL-QUR'AN / TARTIL</td>
                        </tr>
                        <tr><td>1</td><td class="text-left pl-3">Fashohah / Kelancaran</td><td class="font-bold font-mono">{{ $p ? number_format($p->fashohah, 0) : '-' }}</td><td class="text-slate-500 text-[10px]">Min. 60</td></tr>
                        <tr><td>2</td><td class="text-left pl-3">Tajwid Al-Qur'an</td><td class="font-bold font-mono">{{ $p ? number_format($p->tajwid, 0) : '-' }}</td><td class="text-slate-500 text-[10px]">Min. 60</td></tr>
                        <tr><td>3</td><td class="text-left pl-3">Gharib &amp; Musykilat</td><td class="font-bold font-mono">{{ $p ? number_format($p->gharib_musykilat, 0) : '-' }}</td><td class="text-slate-500 text-[10px]">Min. 60</td></tr>
                        <tr><td>4</td><td class="text-left pl-3">Suara &amp; Irama Lagu</td><td class="font-bold font-mono">{{ $p ? number_format($p->suara_lagu, 0) : '-' }}</td><td class="text-slate-500 text-[10px]">Min. 60</td></tr>

                        <tr class="bg-slate-100 font-bold text-slate-800 text-left">
                            <td colspan="4" class="px-2 py-0.5 text-[10px]">B. KELOMPOK HAFALAN &amp; PRAKTEK</td>
                        </tr>
                        <tr><td>5</td><td class="text-left pl-3">Ayat-ayat Pilihan</td><td class="font-bold font-mono">{{ $p ? number_format($p->ayat_pilihan, 0) : '-' }}</td><td class="text-slate-500 text-[10px]">Min. 60</td></tr>
                        <tr><td>6</td><td class="text-left pl-3">Surah-surah Pendek (Juz 'Amma)</td><td class="font-bold font-mono">{{ $p ? number_format($p->surah_pendek, 0) : '-' }}</td><td class="text-slate-500 text-[10px]">Min. 60</td></tr>
                        <tr><td>7</td><td class="text-left pl-3">Doa-doa Harian</td><td class="font-bold font-mono">{{ $p ? number_format($p->doa_harian, 0) : '-' }}</td><td class="text-slate-500 text-[10px]">Min. 60</td></tr>
                        <tr><td>8</td><td class="text-left pl-3">Bacaan &amp; Praktek Shalat</td><td class="font-bold font-mono">{{ $p ? number_format($p->bacaan_shalat, 0) : '-' }}</td><td class="text-slate-500 text-[10px]">Min. 60</td></tr>

                        <tr class="bg-slate-100 font-bold text-slate-800 text-left">
                            <td colspan="4" class="px-2 py-0.5 text-[10px]">C. KELOMPOK TERTULIS</td>
                        </tr>
                        <tr><td>9</td><td class="text-left pl-3">Ujian Tertulis (Dinul Islam / Teori)</td><td class="font-bold font-mono">{{ $p ? number_format($p->ujian_tertulis, 0) : '-' }}</td><td class="text-slate-500 text-[10px]">Min. 60</td></tr>

                        <tr class="bg-amber-100 font-bold">
                            <td colspan="2" class="text-right pr-3 uppercase text-[11px]">JUMLAH NILAI (TOTAL)</td>
                            <td class="font-mono text-xs">{{ $p ? number_format($p->jumlah_nilai, 0) : '-' }}</td>
                            <td>-</td>
                        </tr>
                        <tr class="bg-amber-200 font-black">
                            <td colspan="2" class="text-right pr-3 uppercase text-[11px]">RATA - RATA NILAI</td>
                            <td class="font-mono text-xs text-blue-950">{{ $p ? number_format($p->rata_rata, 2) : '-' }}</td>
                            <td class="text-[10px]">Min. 60.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Keputusan Status Kelulusan -->
            <div class="border-2 {{ $santri->status_kelulusan == 'LULUS' ? 'border-emerald-600 bg-emerald-50/40' : 'border-rose-600 bg-rose-50/40' }} rounded-xl p-2.5 mb-6 text-center">
                <p class="text-[10px] uppercase font-semibold text-slate-600">Berdasarkan hasil sidang database sekolah, santri yang bersangkutan dinyatakan:</p>
                <h3 class="text-base font-black {{ $santri->status_kelulusan == 'LULUS' ? 'text-emerald-700' : 'text-rose-700' }} tracking-widest uppercase my-0.5">
                    {{ $santri->status_kelulusan }}
                </h3>
                <p class="text-xs text-slate-800 font-bold">
                    Predikat: <span class="underline">{{ $p ? $p->predikat : '-' }}</span>
                </p>
            </div>

            <!-- Tanggal & Tanda Tangan -->
            <div class="text-right text-xs text-slate-700 mb-2">
                <p>{{ $settings['alamat_yayasan'] ?? 'Banjarbaru' }}, {{ $settings['tanggal_surat_masehi'] ?? '08 September 2026' }} M / {{ $settings['tanggal_surat_hijriyah'] ?? '25 Rabiul Awwal 1448 H' }}</p>
            </div>

            <!-- Tanda Tangan, Stempel Resmi & QR Code Verifikasi -->
            <div class="grid grid-cols-3 gap-2 sm:gap-4 items-end text-center text-xs mt-6 relative z-10">
                <!-- Kepala Unit -->
                <div>
                    <p class="text-slate-600 mb-14">Kepala {{ $santri->jenis == 'TPQ' ? 'TPQ Ar-Raudhah' : 'RTQ Ar-Raudhah' }},</p>
                    <p class="font-bold text-slate-900 underline uppercase text-xs">{{ $kepalaNama }}</p>
                    <p class="text-[10px] text-slate-500">Kepala Unit {{ $santri->jenis }}</p>
                </div>

                <!-- QR Code Verifikasi Keaslian -->
                <div class="flex flex-col items-center justify-center">
                    @php
                        $verifyUrl = route('public.check.cetak', $santri->id);
                        $qrSrc = "https://api.qrserver.com/v1/create-qr-code/?size=110x110&margin=2&data=" . urlencode($verifyUrl);
                    @endphp
                    <div class="p-1.5 bg-white border border-slate-300 rounded-xl shadow-xs inline-block">
                        <img src="{{ $qrSrc }}" alt="QR Code Verifikasi" class="w-16 h-16 sm:w-18 sm:h-18 object-contain mx-auto" loading="lazy">
                    </div>
                    <p class="text-[8.5px] font-black text-slate-800 uppercase tracking-tighter mt-1">VERIFIKASI RESMI</p>
                    <p class="text-[7.5px] text-slate-500 font-mono">Scan QR untuk verifikasi</p>
                </div>

                <!-- Ketua Yayasan + Stempel Digital -->
                <div class="relative">
                    <p class="text-slate-600 mb-14">Ketua Yayasan,</p>
                    <!-- Stempel Digital Resmi Yayasan -->
                    <div class="absolute left-1/2 -translate-x-1/2 top-3 w-22 h-22 sm:w-26 sm:h-26 pointer-events-none select-none opacity-85 -rotate-12">
                        <svg viewBox="0 0 120 120" class="w-full h-full text-blue-800" fill="currentColor">
                            <circle cx="60" cy="60" r="54" fill="none" stroke="currentColor" stroke-width="2.5" stroke-dasharray="3 1.5"/>
                            <circle cx="60" cy="60" r="50" fill="none" stroke="currentColor" stroke-width="1.5"/>
                            <circle cx="60" cy="60" r="34" fill="none" stroke="currentColor" stroke-width="1"/>
                            <path id="stampPathTopM" d="M 18,60 A 42,42 0 0,1 102,60" fill="none" stroke="none"/>
                            <path id="stampPathBottomM" d="M 102,60 A 42,42 0 0,1 18,60" fill="none" stroke="none"/>
                            <text font-size="8" font-weight="bold" fill="currentColor" letter-spacing="1">
                                <textPath href="#stampPathTopM" startOffset="50%" text-anchor="middle">
                                    YAYASAN AR-RAUDHAH
                                </textPath>
                            </text>
                            <text font-size="7.5" font-weight="bold" fill="currentColor" letter-spacing="1">
                                <textPath href="#stampPathBottomM" startOffset="50%" text-anchor="middle">
                                    ★ PANITIA DATABASE SEKOLAH ★
                                </textPath>
                            </text>
                            <text x="60" y="55" font-size="9" font-weight="black" text-anchor="middle" fill="currentColor">SAH</text>
                            <text x="60" y="68" font-size="7" font-weight="bold" text-anchor="middle" fill="currentColor">2026 / 1447 H</text>
                        </svg>
                    </div>
                    <p class="font-bold text-slate-900 underline uppercase text-xs relative z-10">{{ $settings['ketua_yayasan'] ?? 'Ustadz H. Ahmad Ridhani, S.Pd.I' }}</p>
                    <p class="text-[10px] text-slate-500">{{ $settings['nama_yayasan'] ?? 'Yayasan Cahaya Amanah Ar-Raudhah' }}</p>
                </div>
            </div>

        </div>
        @endforeach
    </div>

</body>
</html>
