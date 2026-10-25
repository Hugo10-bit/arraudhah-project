@extends('layouts.sidebar')

@section('title', 'Pengaturan Surat & Identitas | Yayasan Cahaya Amanah Ar-Raudhah')

@section('breadcrumb')
    <a href="{{ route('settings.index') }}" class="hover:text-blue-900 font-semibold text-slate-700">Pengaturan Surat</a>
@endsection

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header Card -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-slate-900 to-blue-900 text-white flex items-center justify-center text-xl shrink-0 shadow-md">
                <i class="fa-solid fa-sliders"></i>
            </div>
            <div>
                <h1 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">Pengaturan Identitas &amp; Surat</h1>
                <p class="text-xs text-slate-500 mt-0.5">Kelola penandatangan, kop surat, nomor SK, dan tanggal kelulusan dinamis.</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs">
        <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Section 1: Identitas Lembaga & Yayasan -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i class="fa-solid fa-building-columns text-blue-600 text-sm"></i>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Identitas Lembaga &amp; Kop</h2>
                </div>

                <div>
                    <label for="nama_yayasan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nama Resmi Yayasan <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="nama_yayasan"
                           id="nama_yayasan"
                           value="{{ old('nama_yayasan', $settings['nama_yayasan'] ?? 'Yayasan Cahaya Amanah Ar-Raudhah') }}"
                           class="w-full px-4 py-2.5 rounded-xl text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition font-semibold"
                           required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="alamat_yayasan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Alamat / Kota Lembaga
                        </label>
                        <input type="text"
                               name="alamat_yayasan"
                               id="alamat_yayasan"
                               value="{{ old('alamat_yayasan', $settings['alamat_yayasan'] ?? 'Banjarbaru, Kalimantan Selatan') }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition">
                    </div>
                    <div>
                        <label for="tahun_ajaran" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tahun Database Sekolah / Periode
                        </label>
                        <input type="text"
                               name="tahun_ajaran"
                               id="tahun_ajaran"
                               value="{{ old('tahun_ajaran', $settings['tahun_ajaran'] ?? '2025/2026') }}"
                               placeholder="Contoh: 2025/2026"
                               class="w-full px-4 py-2.5 rounded-xl text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition">
                    </div>
                </div>

                <div>
                    <label for="nomor_sk_munaqasyah" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nomor SK / Format Sertifikat
                    </label>
                    <input type="text"
                           name="nomor_sk_munaqasyah"
                           id="nomor_sk_munaqasyah"
                           value="{{ old('nomor_sk_munaqasyah', $settings['nomor_sk_munaqasyah'] ?? $settings['nomor_sk_database sekolah'] ?? '045/SK-MUN/YCA-AR/IX/2026') }}"
                           class="w-full px-4 py-2.5 rounded-xl text-sm font-mono border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition">
                </div>
            </div>

            <!-- Section 2: Pejabat Penandatangan -->
            <div class="space-y-4 pt-2">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i class="fa-solid fa-signature text-blue-600 text-sm"></i>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Pejabat Penandatangan Surat</h2>
                </div>

                <div>
                    <label for="ketua_yayasan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nama Ketua Yayasan &amp; Gelar <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="ketua_yayasan"
                           id="ketua_yayasan"
                           value="{{ old('ketua_yayasan', $settings['ketua_yayasan'] ?? 'Ustadz H. Ahmad Ridhani, S.Pd.I') }}"
                           class="w-full px-4 py-2.5 rounded-xl text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition font-semibold"
                           required>
                    <p class="text-[11px] text-slate-400 mt-1">Muncul sebagai penandatangan utama di bagian tengah bawah surat kelulusan.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="kepala_tpq" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Kepala Unit TPQ Ar-Raudhah <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="kepala_tpq"
                               id="kepala_tpq"
                               value="{{ old('kepala_tpq', $settings['kepala_tpq'] ?? 'Ustadz Muhammad Syauqi, S.Ag') }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition font-semibold"
                               required>
                    </div>
                    <div>
                        <label for="kepala_rtq" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Kepala Unit RTQ Ar-Raudhah <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="kepala_rtq"
                               id="kepala_rtq"
                               value="{{ old('kepala_rtq', $settings['kepala_rtq'] ?? 'Ustadzah Nurul Fatimah, S.Pd') }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition font-semibold"
                               required>
                    </div>
                </div>
            </div>

            <!-- Section 3: Tanggal Surat Kelulusan -->
            <div class="space-y-4 pt-2">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i class="fa-solid fa-calendar-days text-amber-500 text-sm"></i>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Tanggal Terbit Surat</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_surat_masehi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tanggal Masehi <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="tanggal_surat_masehi"
                               id="tanggal_surat_masehi"
                               value="{{ old('tanggal_surat_masehi', $settings['tanggal_surat_masehi'] ?? '08 September 2026') }}"
                               placeholder="Contoh: 08 September 2026"
                               class="w-full px-4 py-2.5 rounded-xl text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition"
                               required>
                    </div>
                    <div>
                        <label for="tanggal_surat_hijriyah" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tanggal Hijriyah <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="tanggal_surat_hijriyah"
                               id="tanggal_surat_hijriyah"
                               value="{{ old('tanggal_surat_hijriyah', $settings['tanggal_surat_hijriyah'] ?? '25 Rabiul Awwal 1448 H') }}"
                               placeholder="Contoh: 25 Rabiul Awwal 1448 H"
                               class="w-full px-4 py-2.5 rounded-xl text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition"
                               required>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-100">
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    <!-- Backup Database Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-4">
        <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
            <i class="fa-solid fa-database text-blue-900 text-sm"></i>
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Cadangan Data &amp; Arsip (Backup)</h2>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200">
            <div class="space-y-1">
                <p class="text-xs font-bold text-slate-800">Unduh Salinan Cadangan Sistem</p>
                <p class="text-[11px] text-slate-500">Mencadangkan seluruh data santri, nilai 9 mata uji, data unit, dan pengaturan sistem ke file JSON terenkapsulasi rapi.</p>
            </div>
            <a href="{{ route('settings.backup') }}" 
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 shadow-md transition shrink-0 active:scale-95">
                <i class="fa-solid fa-download"></i> Unduh Cadangan Data (.json)
            </a>
        </div>
    </div>
</div>
@endsection
