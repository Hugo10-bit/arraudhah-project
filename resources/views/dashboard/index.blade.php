@extends('layouts.sidebar')

@section('title', 'Dashboard | Yayasan Cahaya Amanah Ar-Raudhah')

@section('breadcrumb')
    <span class="text-blue-950 font-bold">Dashboard</span>
@endsection

@section('content')
<div class="space-y-6">
    {{-- ===== HERO WELCOME BANNER ===== --}}
    <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start sm:items-center gap-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Yayasan" class="w-12 h-12 sm:w-14 sm:h-14 object-contain bg-slate-50 border border-slate-200 rounded-xl p-1 shrink-0">
            <div>
                <div class="flex items-center gap-2 mb-1 flex-wrap">
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200">
                        Database Sekolah
                    </span>
                    <span class="text-xs text-slate-500 font-medium">Tahun 2026</span>
                </div>
                <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">Yayasan Cahaya Amanah Ar-Raudhah</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Selamat datang, <span class="font-semibold text-slate-800">{{ session('user_name', 'Panitia') }}</span>! Pantau data penilaian santri TPQ &amp; RTQ Ar-Raudhah Banjarbaru.
                </p>
            </div>
        </div>
        <div class="flex sm:flex-col items-center sm:items-end justify-between gap-2 shrink-0 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100">
            <div class="sm:text-right">
                <p class="text-xs text-slate-500" id="dashDate"></p>
                <p class="text-base sm:text-lg font-bold text-slate-800 font-mono" id="dashTime"></p>
            </div>
            <div class="inline-flex items-center gap-1.5 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                <span class="text-xs text-emerald-700 font-semibold">Sistem Aktif</span>
            </div>
        </div>
    </div>


    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Total Peserta --}}
        <div class="group bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 bg-blue-50 text-blue-900 border border-blue-100 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users"></i>
                </div>
                <span class="text-xs text-slate-500 font-medium bg-slate-100 px-2 py-0.5 rounded-full">Total</span>
            </div>
            <p class="text-3xl font-black text-slate-800">{{ $totalSemua }}</p>
            <p class="text-xs font-semibold text-slate-500 mt-0.5 uppercase tracking-wide">Total Peserta</p>
            <div class="mt-3 flex items-center gap-2">
                <span class="text-[10px] text-amber-700 font-bold bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">
                    {{ $totalTPQ }} TPQ Ar-Raudhah
                </span>
                <span class="text-[10px] text-blue-700 font-bold bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full">
                    {{ $totalRTQ }} RTQ Ar-Raudhah
                </span>
            </div>
        </div>

        {{-- Total Lulus --}}
        <div class="group bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full">LULUS</span>
            </div>
            <p class="text-3xl font-black text-emerald-600">{{ $totalLulus }}</p>
            <p class="text-xs font-semibold text-slate-500 mt-0.5 uppercase tracking-wide">Peserta Lulus</p>
            <div class="mt-3">
                <div class="w-full bg-slate-100 rounded-full h-1.5">
                    <div class="bg-emerald-500 h-1.5 rounded-full transition-all duration-700"
                        style="width: {{ $totalSemua > 0 ? round(($totalLulus / $totalSemua) * 100) : 0 }}%"></div>
                </div>
                <p class="text-[10px] text-slate-500 mt-1">
                    {{ $totalSemua > 0 ? round(($totalLulus / $totalSemua) * 100) : 0 }}% tingkat kelulusan
                </p>
            </div>
        </div>

        {{-- Belum Lulus --}}
        <div class="group bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <span class="text-xs text-rose-600 font-bold bg-rose-50 px-2 py-0.5 rounded-full">TIDAK LULUS</span>
            </div>
            <p class="text-3xl font-black text-rose-600">{{ $totalTidakLulus }}</p>
            <p class="text-xs font-semibold text-slate-500 mt-0.5 uppercase tracking-wide">Tidak Lulus</p>
            <div class="mt-3">
                <div class="w-full bg-slate-100 rounded-full h-1.5">
                    <div class="bg-rose-500 h-1.5 rounded-full transition-all duration-700"
                        style="width: {{ $totalSemua > 0 ? round(($totalTidakLulus / $totalSemua) * 100) : 0 }}%"></div>
                </div>
                <p class="text-[10px] text-slate-500 mt-1">
                    {{ $totalSemua > 0 ? round(($totalTidakLulus / $totalSemua) * 100) : 0 }}% dari total
                </p>
            </div>
        </div>

        {{-- Rata-rata Nilai --}}
        <div class="group bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <span class="text-xs text-amber-600 font-bold bg-amber-50 px-2 py-0.5 rounded-full">AVG</span>
            </div>
            <p class="text-3xl font-black text-amber-600">{{ number_format($rataRataGlobal, 1) }}</p>
            <p class="text-xs font-semibold text-slate-500 mt-0.5 uppercase tracking-wide">Rata-rata Nilai</p>
            <div class="mt-3 flex items-center gap-1 text-[10px] text-slate-500">
                <i class="fa-solid fa-circle-info text-amber-400"></i>
                Rata-rata semua peserta
            </div>
        </div>
    </div>

    {{-- ===== VISUAL ANALYTICS (CHART.JS) ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        {{-- Chart 1: Distribusi Predikat --}}
        <div class="lg:col-span-5 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm border border-amber-200">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-800 text-sm">Distribusi Predikat</h3>
                            <p class="text-[10px] text-slate-400">Tingkat capaian predikat kelulusan santri</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full">Total: {{ $totalSemua }}</span>
                </div>
                <div class="relative mt-4 flex items-center justify-center" style="height: 220px;">
                    <canvas id="predikatChart"></canvas>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 pt-3 border-t border-slate-100 text-[10px] mt-2">
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                    <span class="text-slate-600 truncate">Mumtaz ({{ $predikatCounts['Mumtaz (Istimewa)'] ?? 0 }})</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500 shrink-0"></span>
                    <span class="text-slate-600 truncate">Jayyid J. ({{ $predikatCounts['Jayyid Jiddan (Sangat Baik)'] ?? 0 }})</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 shrink-0"></span>
                    <span class="text-slate-600 truncate">Jayyid ({{ $predikatCounts['Jayyid (Baik)'] ?? 0 }})</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-purple-500 shrink-0"></span>
                    <span class="text-slate-600 truncate">Maqbul ({{ $predikatCounts['Maqbul (Cukup)'] ?? 0 }})</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500 shrink-0"></span>
                    <span class="text-slate-600 truncate">Rasib ({{ $predikatCounts['Rasib (Kurang)'] ?? 0 }})</span>
                </div>
            </div>
        </div>

        {{-- Chart 2: Komparasi 9 Mata Uji --}}
        <div class="lg:col-span-7 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center text-sm border border-blue-200">
                            <i class="fa-solid fa-chart-column"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-800 text-sm">Rata-Rata 9 Komponen Nilai</h3>
                            <p class="text-[10px] text-slate-400">Komparasi nilai rata-rata TPQ vs RTQ</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-[10px] font-bold">
                        <span class="inline-flex items-center gap-1 text-amber-700">
                            <span class="w-2 h-2 rounded bg-amber-500"></span> TPQ
                        </span>
                        <span class="inline-flex items-center gap-1 text-blue-800">
                            <span class="w-2 h-2 rounded bg-blue-900"></span> RTQ
                        </span>
                    </div>
                </div>
                <div class="relative mt-4" style="height: 240px;">
                    <canvas id="komponenChart"></canvas>
                </div>
            </div>
            <p class="text-[10px] text-slate-400 text-center mt-2">
                *Skala nilai 0 – 100. Evaluasi mata uji mencakup bidang Database Sekolah Bacaan, Hafalan, &amp; Ujian Tertulis.
            </p>
        </div>
    </div>

    {{-- ===== LEADERBOARD / SANTRI BERPRESTASI ===== --}}
    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-slate-50/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-trophy"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-sm sm:text-base flex items-center gap-2">
                        <span>Santri Berprestasi Database Sekolah 2026</span>
                        <span class="text-[9px] px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 border border-amber-200 font-bold uppercase">Top Nilai</span>
                    </h3>
                    <p class="text-[11px] text-slate-500">Santri peraih nilai database sekolah tertinggi untuk unit TPQ &amp; RTQ Ar-Raudhah</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-xs">
                <span class="text-[10px] text-slate-400 font-medium">Diperbarui Otomatis</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-slate-100">
            {{-- Kolom Top TPQ --}}
            <div class="p-4 sm:p-5 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-amber-100">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wide">Top Santri TPQ Ar-Raudhah</h4>
                    </div>
                    <span class="text-[10px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">Unit TPQ</span>
                </div>

                <div class="space-y-2">
                    @forelse($topSantriTPQ as $idx => $santri)
                        @php
                            $p = $santri->penilaian;
                            $medals = ['🥇', '🥈', '🥉', '4️⃣', '5️⃣'];
                            $medalIco = $medals[$idx] ?? ($idx + 1);
                        @endphp
                        <div class="flex items-center justify-between p-2.5 rounded-xl border transition-all duration-200 {{ $idx === 0 ? 'bg-gradient-to-r from-amber-50 to-yellow-50/50 border-amber-200 shadow-2xs' : 'bg-slate-50/70 hover:bg-slate-50 border-slate-200' }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="text-base select-none shrink-0 w-6 text-center">{{ $medalIco }}</span>
                                <div class="w-8 h-8 rounded-lg overflow-hidden border border-slate-200 bg-white shrink-0">
                                    <img src="{{ $santri->foto_url }}" alt="{{ $santri->nama }}" class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-900 text-xs truncate leading-tight">{{ $santri->nama }}</p>
                                    <p class="text-[10px] text-slate-500 truncate font-mono">No: {{ $santri->no_peserta ?? '-' }} • {{ $santri->nama_unit ?? 'TPQ' }}</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0 pl-2">
                                <div class="font-black text-amber-700 text-xs font-mono">{{ $p ? number_format($p->rata_rata, 2) : '-' }}</div>
                                <span class="text-[9px] font-bold px-1.5 py-0.2 rounded {{ ($p && $p->predikat == 'Mumtaz (Istimewa)') ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $p ? explode(' ', $p->predikat)[0] : '-' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-400 text-xs text-center py-4">Belum ada data nilai TPQ</p>
                    @endforelse
                </div>
            </div>

            {{-- Kolom Top RTQ --}}
            <div class="p-4 sm:p-5 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-blue-100">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-900"></span>
                        <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wide">Top Santri RTQ Ar-Raudhah</h4>
                    </div>
                    <span class="text-[10px] font-bold text-blue-900 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200">Unit RTQ (Tahfidz)</span>
                </div>

                <div class="space-y-2">
                    @forelse($topSantriRTQ as $idx => $santri)
                        @php
                            $p = $santri->penilaian;
                            $medals = ['🥇', '🥈', '🥉', '4️⃣', '5️⃣'];
                            $medalIco = $medals[$idx] ?? ($idx + 1);
                        @endphp
                        <div class="flex items-center justify-between p-2.5 rounded-xl border transition-all duration-200 {{ $idx === 0 ? 'bg-gradient-to-r from-blue-50 to-indigo-50/50 border-blue-200 shadow-2xs' : 'bg-slate-50/70 hover:bg-slate-50 border-slate-200' }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="text-base select-none shrink-0 w-6 text-center">{{ $medalIco }}</span>
                                <div class="w-8 h-8 rounded-lg overflow-hidden border border-slate-200 bg-white shrink-0">
                                    <img src="{{ $santri->foto_url }}" alt="{{ $santri->nama }}" class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-900 text-xs truncate leading-tight">{{ $santri->nama }}</p>
                                    <p class="text-[10px] text-slate-500 truncate font-mono">No: {{ $santri->no_peserta ?? '-' }} • {{ $santri->nama_unit ?? 'RTQ' }}</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0 pl-2">
                                <div class="font-black text-blue-900 text-xs font-mono">{{ $p ? number_format($p->rata_rata, 2) : '-' }}</div>
                                <span class="text-[9px] font-bold px-1.5 py-0.2 rounded {{ ($p && $p->predikat == 'Mumtaz (Istimewa)') ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $p ? explode(' ', $p->predikat)[0] : '-' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-400 text-xs text-center py-4">Belum ada data nilai RTQ</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ===== GRID: Breakdown TPQ/RTQ + Aksi Cepat ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Breakdown per Jenis --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-blue-900"></i>
                    <h3 class="font-bold text-slate-800 text-sm">Rekapitulasi Lembaga Ar-Raudhah</h3>
                </div>
                <span class="text-xs text-slate-400">TPQ &amp; RTQ Ar-Raudhah</span>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- TPQ Card --}}
                <div class="bg-amber-50/50 rounded-2xl p-4 border border-amber-200/80">
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-amber-200 shadow-xs p-1 shrink-0 overflow-hidden">
                            <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-amber-800 uppercase tracking-wide leading-none">Lembaga</p>
                            <p class="text-sm font-black text-slate-900 leading-tight">TPQ Ar-Raudhah</p>
                            <p class="text-[10px] text-slate-500 font-medium">Taman Pendidikan Qur'an</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Total Peserta</span>
                            <span class="font-bold text-slate-800">{{ $totalTPQ }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Lulus</span>
                            <span class="font-bold text-emerald-600">{{ $lulusTPQ }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Tidak Lulus</span>
                            <span class="font-bold text-rose-600">{{ $tidakLulusTPQ }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Rata-rata Nilai</span>
                            <span class="font-bold text-amber-700">{{ number_format($rataTPQ, 1) }}</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="w-full bg-amber-100 rounded-full h-2">
                            <div class="bg-amber-500 h-2 rounded-full"
                                style="width: {{ $totalTPQ > 0 ? round(($lulusTPQ / $totalTPQ) * 100) : 0 }}%"></div>
                        </div>
                        <p class="text-[10px] text-slate-500 mt-1">
                            {{ $totalTPQ > 0 ? round(($lulusTPQ / $totalTPQ) * 100) : 0 }}% lulus
                        </p>
                    </div>
                    <a href="{{ route('database_sekolah.index', ['jenis' => 'TPQ']) }}"
                        class="mt-3 w-full inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-amber-900 bg-amber-100 hover:bg-amber-200 border border-amber-300 py-2 rounded-xl transition">
                        <i class="fa-solid fa-arrow-right text-[10px]"></i> Lihat Data TPQ
                    </a>
                </div>

                {{-- RTQ Card --}}
                <div class="bg-blue-50/50 rounded-2xl p-4 border border-blue-200/80">
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-blue-200 shadow-xs p-1 shrink-0 overflow-hidden">
                            <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-blue-800 uppercase tracking-wide leading-none">Lembaga</p>
                            <p class="text-sm font-black text-slate-900 leading-tight">RTQ Ar-Raudhah</p>
                            <p class="text-[10px] text-slate-500 font-medium">Rumah Tahfidz Qur'an</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Total Peserta</span>
                            <span class="font-bold text-slate-800">{{ $totalRTQ }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Lulus</span>
                            <span class="font-bold text-emerald-600">{{ $lulusRTQ }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Tidak Lulus</span>
                            <span class="font-bold text-rose-600">{{ $tidakLulusRTQ }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Rata-rata Nilai</span>
                            <span class="font-bold text-blue-700">{{ number_format($rataRTQ, 1) }}</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="w-full bg-blue-100 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full"
                                style="width: {{ $totalRTQ > 0 ? round(($lulusRTQ / $totalRTQ) * 100) : 0 }}%"></div>
                        </div>
                        <p class="text-[10px] text-slate-500 mt-1">
                            {{ $totalRTQ > 0 ? round(($lulusRTQ / $totalRTQ) * 100) : 0 }}% lulus
                        </p>
                    </div>
                    <a href="{{ route('database_sekolah.index', ['jenis' => 'RTQ']) }}"
                        class="mt-3 w-full inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-blue-900 bg-blue-100 hover:bg-blue-200 border border-blue-300 py-2 rounded-xl transition">
                        <i class="fa-solid fa-arrow-right text-[10px]"></i> Lihat Data RTQ
                    </a>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-bolt text-amber-500"></i>
                <h3 class="font-bold text-slate-800 text-sm">Aksi Cepat</h3>
            </div>
            <div class="p-4 space-y-2">
                <a href="{{ route('database_sekolah.create', ['jenis' => 'TPQ']) }}"
                    class="flex items-center gap-3 p-3 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-200 transition group">
                    <div class="w-9 h-9 bg-amber-400 rounded-lg flex items-center justify-center text-slate-900 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-user-plus text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Input TPQ Ar-Raudhah</p>
                        <p class="text-[10px] text-slate-500">Taman Pendidikan Qur'an</p>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400 ml-auto"></i>
                </a>

                <a href="{{ route('database_sekolah.create', ['jenis' => 'RTQ']) }}"
                    class="flex items-center gap-3 p-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition group">
                    <div class="w-9 h-9 bg-emerald-600 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-user-plus text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Input RTQ Ar-Raudhah</p>
                        <p class="text-[10px] text-slate-500">Rumah Tahfidz Qur'an</p>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400 ml-auto"></i>
                </a>

                <a href="{{ route('database_sekolah.index', ['jenis' => 'TPQ']) }}"
                    class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 transition group">
                    <div class="w-9 h-9 bg-amber-500 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-table-list text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Rekapitulasi TPQ Ar-Raudhah</p>
                        <p class="text-[10px] text-slate-500">Daftar nilai database sekolah</p>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400 ml-auto"></i>
                </a>

                <a href="{{ route('database_sekolah.index', ['jenis' => 'RTQ']) }}"
                    class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 transition group">
                    <div class="w-9 h-9 bg-emerald-600 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-table-list text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Rekapitulasi RTQ Ar-Raudhah</p>
                        <p class="text-[10px] text-slate-500">Daftar nilai database sekolah</p>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400 ml-auto"></i>
                </a>

                <a href="{{ route('database_sekolah.export.excel', ['jenis' => 'TPQ']) }}"
                    class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 transition group">
                    <div class="w-9 h-9 bg-emerald-600 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-file-excel text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Export Laporan Excel</p>
                        <p class="text-[10px] text-slate-500">Download rekapitulasi nilai</p>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400 ml-auto"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- ===== 10 Santri Terbaru ===== --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-slate-500"></i>
                <h3 class="font-bold text-slate-800 text-sm">Santri Terbaru Ditambahkan</h3>
            </div>
            <a href="{{ route('database_sekolah.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">Lihat Semua</a>
        </div>

        {{-- Mobile card list --}}
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse($santriTerbaru as $santri)
            <div class="flex items-center gap-3 p-3.5 hover:bg-slate-50 transition">
                <div class="shrink-0">
                    <span class="text-[10px] font-mono font-bold text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded">#{{ $santri->no_peserta ?? '-' }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-800 truncate">{{ $santri->nama }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ $santri->nama_unit ?? '-' }}</p>
                </div>
                <div class="shrink-0 text-right">
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $santri->jenis == 'TPQ' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $santri->jenis }}
                    </span>
                    <div class="mt-1">
                        @if($santri->status_kelulusan == 'LULUS')
                            <span class="text-[10px] font-bold text-emerald-600">✓ LULUS</span>
                        @elseif($santri->status_kelulusan == 'TIDAK LULUS')
                            <span class="text-[10px] font-bold text-rose-600">✗ TDK LULUS</span>
                        @else
                            <span class="text-[10px] font-bold text-slate-400">Belum dinilai</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('database_sekolah.edit', $santri->id) }}" class="shrink-0 w-8 h-8 flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition">
                    <i class="fa-solid fa-pen text-xs"></i>
                </a>
            </div>
            @empty
            <div class="p-10 text-center text-slate-400 text-sm">
                <i class="fa-solid fa-inbox text-3xl mb-2 block text-slate-300"></i>
                Belum ada data santri
            </div>
            @endforelse
        </div>

        {{-- Desktop table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold uppercase tracking-wide">No. Peserta</th>
                        <th class="text-left px-4 py-3 text-slate-500 font-semibold uppercase tracking-wide">Nama Santri</th>
                        <th class="text-left px-4 py-3 text-slate-500 font-semibold uppercase tracking-wide">Unit / Lembaga</th>
                        <th class="text-center px-4 py-3 text-slate-500 font-semibold uppercase tracking-wide">Kategori</th>
                        <th class="text-center px-4 py-3 text-slate-500 font-semibold uppercase tracking-wide">Status</th>
                        <th class="text-center px-4 py-3 text-slate-500 font-semibold uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($santriTerbaru as $santri)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-3 font-mono font-bold text-slate-700">{{ $santri->no_peserta ?? '-' }}</td>
                        <td class="px-4 py-3 font-semibold text-slate-800">{{ $santri->nama }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $santri->nama_unit ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $santri->jenis == 'TPQ' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $santri->jenis }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($santri->status_kelulusan == 'LULUS')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> LULUS
                                </span>
                            @elseif($santri->status_kelulusan == 'TIDAK LULUS')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">
                                    <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> TIDAK LULUS
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">BELUM DINILAI</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('database_sekolah.edit', $santri->id) }}"
                                class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-2 py-1 rounded-lg transition">
                                <i class="fa-solid fa-pen"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-slate-400 text-sm">
                            <i class="fa-solid fa-inbox text-3xl mb-2 block text-slate-300"></i>
                            Belum ada data santri
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Live clock
    function updateClock() {
        const now = new Date();
        const dateEl = document.getElementById('dashDate');
        const timeEl = document.getElementById('dashTime');
        if (!dateEl || !timeEl) return;

        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        dateEl.textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
        timeEl.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Theme Colors Helper for Chart.js
    let predikatChartInstance = null;
    let komponenChartInstance = null;

    function getChartThemeColors(isDark) {
        return {
            doughnutBorder: isDark ? '#111b33' : '#ffffff',
            gridColor: isDark ? 'rgba(255, 255, 255, 0.08)' : '#f1f5f9',
            tickColor: isDark ? '#94a3b8' : '#64748b',
            rtqBarBg: isDark ? 'rgba(59, 130, 246, 0.85)' : 'rgba(23, 37, 84, 0.9)',
            rtqBarBorder: isDark ? '#3b82f6' : '#0f172a'
        };
    }

    const isDarkInitial = document.documentElement.classList.contains('dark');
    const initialColors = getChartThemeColors(isDarkInitial);

    // Chart.js: Distribusi Predikat (Doughnut)
    const ctxPredikat = document.getElementById('predikatChart');
    if (ctxPredikat) {
        predikatChartInstance = new Chart(ctxPredikat, {
            type: 'doughnut',
            data: {
                labels: ['Mumtaz (Istimewa)', 'Jayyid Jiddan (Sangat Baik)', 'Jayyid (Baik)', 'Maqbul (Cukup)', 'Rasib (Kurang)'],
                datasets: [{
                    data: [
                        {{ $predikatCounts['Mumtaz (Istimewa)'] ?? 0 }},
                        {{ $predikatCounts['Jayyid Jiddan (Sangat Baik)'] ?? 0 }},
                        {{ $predikatCounts['Jayyid (Baik)'] ?? 0 }},
                        {{ $predikatCounts['Maqbul (Cukup)'] ?? 0 }},
                        {{ $predikatCounts['Rasib (Kurang)'] ?? 0 }}
                    ],
                    backgroundColor: [
                        '#10b981', // Emerald
                        '#3b82f6', // Blue
                        '#f59e0b', // Amber
                        '#a855f7', // Purple
                        '#f43f5e'  // Rose
                    ],
                    borderWidth: 2,
                    borderColor: initialColors.doughnutBorder,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const val = context.parsed;
                                const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                return ` ${context.label}: ${val} santri (${pct}%)`;
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }

    // Chart.js: Komparasi 9 Komponen Nilai (Bar Chart)
    const ctxKomponen = document.getElementById('komponenChart');
    if (ctxKomponen) {
        komponenChartInstance = new Chart(ctxKomponen, {
            type: 'bar',
            data: {
                labels: {!! json_encode($komponenLabels) !!},
                datasets: [
                    {
                        label: 'TPQ Ar-Raudhah',
                        data: {!! json_encode($avgKomponenTPQ) !!},
                        backgroundColor: 'rgba(245, 158, 11, 0.85)', // Amber
                        borderColor: '#d97706',
                        borderWidth: 1,
                        borderRadius: 6,
                    },
                    {
                        label: 'RTQ Ar-Raudhah',
                        data: {!! json_encode($avgKomponenRTQ) !!},
                        backgroundColor: initialColors.rtqBarBg,
                        borderColor: initialColors.rtqBarBorder,
                        borderWidth: 1,
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: initialColors.gridColor
                        },
                        ticks: {
                            color: initialColors.tickColor,
                            font: { size: 10 },
                            stepSize: 20
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: initialColors.tickColor,
                            font: { size: 10 },
                            maxRotation: 45,
                            minRotation: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ` ${context.dataset.label}: ${context.parsed.y} / 100`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Listener saat tema berubah (Light <-> Dark)
    window.addEventListener('themeChanged', function (e) {
        const isDark = e.detail ? e.detail.isDark : document.documentElement.classList.contains('dark');
        const c = getChartThemeColors(isDark);

        if (predikatChartInstance) {
            predikatChartInstance.data.datasets[0].borderColor = c.doughnutBorder;
            predikatChartInstance.update();
        }

        if (komponenChartInstance) {
            komponenChartInstance.options.scales.y.grid.color = c.gridColor;
            komponenChartInstance.options.scales.y.ticks.color = c.tickColor;
            komponenChartInstance.options.scales.x.ticks.color = c.tickColor;
            komponenChartInstance.data.datasets[1].backgroundColor = c.rtqBarBg;
            komponenChartInstance.data.datasets[1].borderColor = c.rtqBarBorder;
            komponenChartInstance.update();
        }
    });
</script>
@endsection
