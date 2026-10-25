@extends('layouts.sidebar')

@section('title', 'Profil Santri: ' . $santri->nama)

@section('breadcrumb')
    <a href="{{ route('santri.index') }}" class="hover:text-blue-900 transition">Biodata Santri</a>
    <i class="fa-solid fa-chevron-right text-[9px]"></i>
    <span class="text-blue-950 font-bold truncate max-w-xs">{{ $santri->nama }}</span>
@endsection

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">

    <!-- TOP BAR ACTIONS -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-0.5 rounded-full {{ $santri->jenis === 'TPQ' ? 'bg-blue-100 text-blue-900' : 'bg-emerald-100 text-emerald-900' }}">
                    @if($santri->jenis === 'TPQ')
                        <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ" class="w-3.5 h-3.5 object-contain">
                    @elseif($santri->jenis === 'RTQ')
                        <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ" class="w-3.5 h-3.5 object-contain">
                    @endif
                    {{ $santri->jenis }} Ar-Raudhah
                </span>
                <span class="text-xs text-slate-400 font-mono">ID #{{ $santri->id }}</span>
            </div>
            <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 mt-1">Kartu Identitas Biodata Santri</h1>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('santri.index') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 border border-slate-200 transition">
                <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
            </a>
            <a href="{{ route('santri.edit', $santri->id) }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 border border-slate-200 transition">
                <i class="fa-solid fa-pen-to-square text-xs text-blue-700"></i> Edit Biodata
            </a>
            <a href="{{ route('database_sekolah.edit', $santri->id) }}" 
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-blue-900 hover:bg-blue-800 text-white shadow-xs transition">
                <i class="fa-solid fa-calculator text-xs text-blue-200"></i> {{ $santri->penilaian ? 'Edit Nilai' : '+ Input Nilai' }}
            </a>
            @if($santri->penilaian)
            <a href="{{ route('database_sekolah.kelulusan', $santri->id) }}" target="_blank"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white shadow-xs transition">
                <i class="fa-solid fa-print text-xs"></i> Cetak Surat Kelulusan
            </a>
            @endif

            @php
                $pSantri = $santri->penilaian;
                if ($pSantri) {
                    $waTextSantri = "Assalamu'alaikum Wr. Wb. Yth. Wali Santri dari *" . $santri->nama . "* (No. Peserta: " . ($santri->no_peserta ?? '-') . ").%0A%0AInformasi Hasil Ujian Database Sekolah Yayasan Cahaya Amanah Ar-Raudhah:%0A- Status: *" . $santri->status_kelulusan . "*%0A- Predikat: *" . ($pSantri->predikat ?? '-') . "*%0A- Rata-rata: *" . number_format($pSantri->rata_rata, 2) . "*%0A%0ABerikut tautan resmi Surat Keterangan Kelulusan dan nilai lengkap:%0A" . urlencode(route('public.check.cetak', $santri->id)) . "%0A%0ABarakallahu fiikum.%0A_Panitia Database Sekolah Ar-Raudhah_";
                } else {
                    $waTextSantri = "Assalamu'alaikum Wr. Wb. Yth. Wali Santri dari *" . $santri->nama . "* (No. Peserta: " . ($santri->no_peserta ?? '-') . ").%0A%0AInformasi Pendaftaran Ujian Database Sekolah Yayasan Cahaya Amanah Ar-Raudhah:%0A- No. Peserta: " . ($santri->no_peserta ?? '-') . "%0A- Lembaga: " . ($santri->nama_unit ?? '-') . "%0A- Status: *" . $santri->status_kelulusan . "*%0A%0ABarakallahu fiikum.%0A_Panitia Database Sekolah Ar-Raudhah_";
                }
            @endphp
            <a href="https://api.whatsapp.com/send?text={{ $waTextSantri }}" target="_blank" rel="noopener"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-xs transition" title="Kirim Info ke WhatsApp">
                <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
            </a>

            @if(session('user_role') === 'Administrator')
            <button type="button" 
                    onclick="openGlobalDeleteModal('{{ route('santri.destroy', $santri->id) }}', '{{ addslashes($santri->nama) }}', '{{ $santri->no_peserta ?? '-' }}', '{{ $santri->nama_unit ?? $santri->jenis }}')"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-rose-700 hover:text-white bg-rose-50 hover:bg-rose-600 border border-rose-200 transition"
                    title="Hapus Santri">
                <i class="fa-solid fa-trash-can text-xs"></i> Hapus
            </button>
            @endif
        </div>
    </div>

    <!-- MAIN PROFILE CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="h-28 sm:h-32 bg-slate-800 relative p-6 flex items-end justify-end">
            <div class="relative z-10 flex items-center gap-2">
                @if($santri->status_kelulusan === 'LULUS')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-emerald-500 text-white shadow-md">
                        <i class="fa-solid fa-circle-check"></i> LULUS DATABASE SEKOLAH
                    </span>
                @elseif($santri->status_kelulusan === 'TIDAK LULUS')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-rose-600 text-white shadow-md">
                        <i class="fa-solid fa-circle-xmark"></i> TIDAK LULUS
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-500 text-white shadow-md">
                        <i class="fa-solid fa-clock"></i> PENDING
                    </span>
                @endif
            </div>
        </div>

        <div class="px-6 sm:px-8 pb-8 pt-0 relative">
            <div class="flex flex-col sm:flex-row gap-5 sm:gap-6 items-start sm:items-end mb-6">
                <!-- Foto Profil Santri (Hanya foto yang overlap ke banner) -->
                <div class="-mt-16 sm:-mt-20 w-28 h-36 sm:w-32 sm:h-40 rounded-2xl bg-white p-1.5 border-2 border-slate-200 shadow-xl shrink-0 overflow-hidden relative z-20">
                    <img src="{{ $santri->foto_url }}" alt="{{ $santri->nama }}" class="w-full h-full object-cover rounded-xl" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($santri->nama) }}&background=0D8ABC&color=fff&size=256';">
                    @if(!$santri->foto)
                        <div class="absolute bottom-2.5 inset-x-2.5 bg-slate-900/75 backdrop-blur-xs text-white text-[9px] font-bold py-0.5 px-1 rounded-md text-center shadow-xs">
                            Avatar Default
                        </div>
                    @endif
                </div>

                <!-- Info Header Santri (Berada bersih di area putih) -->
                <div class="flex-1 min-w-0 pt-2 sm:pt-4 sm:pb-1">
                    <div class="flex items-center gap-2 flex-wrap mb-1.5">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-bold {{ $santri->jenis === 'TPQ' ? 'bg-blue-100 text-blue-900 border border-blue-200' : 'bg-emerald-100 text-emerald-900 border border-emerald-200' }}">
                            @if($santri->jenis === 'TPQ')
                                <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ" class="w-3.5 h-3.5 object-contain">
                            @elseif($santri->jenis === 'RTQ')
                                <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ" class="w-3.5 h-3.5 object-contain">
                            @endif
                            {{ $santri->jenis }}
                        </span>
                        <span class="text-xs font-mono font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200">
                            No. Peserta: <strong class="text-slate-800">{{ $santri->no_peserta ?? '-' }}</strong>
                        </span>
                        <span class="text-slate-300">•</span>
                        <span class="text-xs font-mono text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200">
                            NISN: <strong class="text-slate-800">{{ $santri->nisn ?? 'Belum ada' }}</strong>
                        </span>
                    </div>

                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight leading-snug">
                        {{ $santri->nama }}
                    </h2>

                    <p class="text-xs sm:text-sm font-semibold text-slate-600 mt-1 flex items-center gap-2">
                        <i class="fa-solid fa-school text-slate-400"></i>
                        {{ $santri->nama_unit }} 
                        <span class="text-slate-400 font-normal font-mono">(Unit: {{ $santri->no_unit ?? '-' }})</span>
                    </p>
                </div>
            </div>

            <!-- DETAIL GRID BIODATA -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-4 border-t border-slate-100">
                <!-- Jenis Kelamin -->
                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80">
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Jenis Kelamin</p>
                    <p class="text-sm font-bold text-slate-800 mt-1 flex items-center gap-1.5">
                        @if($santri->jenis_kelamin === 'L')
                            <i class="fa-solid fa-mars text-sky-600"></i> Laki-laki
                        @elseif($santri->jenis_kelamin === 'P')
                            <i class="fa-solid fa-venus text-rose-500"></i> Perempuan
                        @else
                            -
                        @endif
                    </p>
                </div>

                <!-- TTL -->
                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80">
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Tempat, Tanggal Lahir</p>
                    <p class="text-sm font-bold text-slate-800 mt-1">
                        {{ $santri->tempat_lahir ?? '-' }}, 
                        {{ $santri->tanggal_lahir ? date('d F Y', strtotime($santri->tanggal_lahir)) : '-' }}
                    </p>
                </div>

                <!-- Orang Tua / Wali -->
                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80">
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Orang Tua / Wali</p>
                    <p class="text-sm font-bold text-slate-800 mt-1">
                        {{ $santri->nama_wali ?? '-' }}
                    </p>
                </div>

                <!-- Tahun Database Sekolah -->
                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80">
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Tahun Database Sekolah</p>
                    <p class="text-sm font-bold text-slate-800 mt-1 font-mono">
                        {{ $santri->tahun_munaqasyah ?? '2026' }}
                    </p>
                </div>

                <!-- Lembaga Naungan -->
                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80">
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Yayasan Naungan</p>
                    <p class="text-sm font-bold text-slate-800 mt-1">
                        Yayasan Cahaya Amanah Ar-Raudhah
                    </p>
                </div>

                <!-- Catatan / Keterangan -->
                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80">
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Catatan Keterangan</p>
                    <p class="text-sm font-medium text-slate-700 mt-1 italic">
                        {{ $santri->keterangan ?? 'Tidak ada catatan tambahan' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- SEKSI CATATAN PENILAIAN DATABASE SEKOLAH -->
    @if($santri->penilaian)
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs font-black">
                        <i class="fa-solid fa-award"></i>
                    </span>
                    <h3 class="text-base font-extrabold text-slate-900">Hasil Penilaian Database Sekolah</h3>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">Ringkasan perolehan nilai dari 9 mata uji database_sekolah.</p>
            </div>
            <a href="{{ route('database_sekolah.edit', $santri->id) }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold text-blue-900 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition shrink-0">
                <i class="fa-solid fa-pen-to-square text-xs"></i> Edit Lembar Nilai
            </a>
        </div>

        <!-- 3 KPI Skor -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-blue-950 to-blue-900 rounded-2xl p-4 text-white text-center shadow-md">
                <p class="text-xs text-blue-200 font-semibold uppercase tracking-wider">Total Nilai</p>
                <p class="text-3xl sm:text-4xl font-black font-mono mt-1 text-white">
                    {{ number_format($santri->penilaian->total_nilai ?? 0, 1) }}
                </p>
                <p class="text-[11px] text-blue-300 mt-1">Skala Maksimal 900</p>
            </div>

            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-4 text-white text-center shadow-md">
                <p class="text-xs text-slate-300 font-semibold uppercase tracking-wider">Rata-Rata</p>
                <p class="text-3xl sm:text-4xl font-black font-mono mt-1 text-amber-300">
                    {{ number_format($santri->penilaian->rata_rata ?? 0, 1) }}
                </p>
                <p class="text-[11px] text-slate-400 mt-1">Skala Nilai 0 - 100</p>
            </div>

            <div class="bg-gradient-to-br from-emerald-950 to-emerald-800 rounded-2xl p-4 text-white text-center shadow-md">
                <p class="text-xs text-emerald-200 font-semibold uppercase tracking-wider">Predikat Kelulusan</p>
                <p class="text-2xl sm:text-3xl font-black mt-1 text-white">
                    {{ $santri->penilaian->predikat ?? '-' }}
                </p>
                <p class="text-[11px] text-emerald-300 mt-1">Kualifikasi Hasil Ujian</p>
            </div>
        </div>

        <!-- Rincian 9 Mata Uji -->
        <div>
            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Rincian Per Mata Uji</h4>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-3">
                @php
                    $p = $santri->penilaian;
                    $mapNilai = [
                        ['label' => 'Tadarus / Tahfidz', 'val' => $p->tadarus_tahfidz],
                        ['label' => 'Ilmu Tajwid', 'val' => $p->ilmu_tajwid],
                        ['label' => 'Fasholatan & Sholat', 'val' => $p->fasholatan_sholat],
                        ['label' => "Do'a Harian", 'val' => $p->doa_harian],
                        ['label' => 'Bacaan Gharib', 'val' => $p->bacaan_gharib],
                        ['label' => 'Dinul Islam', 'val' => $p->dinul_islam],
                        ['label' => 'Ayat Pilihan', 'val' => $p->surah_pendek_ayat_pilihan],
                        ['label' => 'Praktik Wudhu', 'val' => $p->praktik_wudhu],
                        ['label' => 'Adab & Sikap', 'val' => $p->adab_sikap],
                    ];
                @endphp
                @foreach($mapNilai as $item)
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-700 truncate pr-2">{{ $item['label'] }}</span>
                    <span class="font-mono text-xs font-black px-2 py-0.5 rounded bg-white border border-slate-200 text-slate-900">
                        {{ number_format($item['val'] ?? 0, 1) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <!-- Belum Dinilai Banner -->
    <div class="bg-white rounded-3xl border-2 border-dashed border-amber-300 p-6 sm:p-8 text-center space-y-3">
        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto text-2xl border border-amber-200">
            <i class="fa-solid fa-file-pen"></i>
        </div>
        <h3 class="text-base font-extrabold text-slate-900">Santri Belum Memiliki Nilai Database Sekolah</h3>
        <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
            Santri ini sudah terdaftar dalam direktori biodata, namun lembar nilai 9 mata uji database sekolah belum diisi atau disimpan.
        </p>
        <div class="pt-2">
            <a href="{{ route('database_sekolah.edit', $santri->id) }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white shadow-md shadow-blue-900/20 transition active:scale-95">
                <i class="fa-solid fa-calculator"></i>
                <span>Mulai Isi Nilai Database Sekolah</span>
            </a>
        </div>
    </div>
    @endif

</div>
@endsection
