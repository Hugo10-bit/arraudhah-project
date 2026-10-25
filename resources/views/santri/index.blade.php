@extends('layouts.sidebar')

@section('title', 'Direktori Biodata Santri | Yayasan Cahaya Amanah Ar-Raudhah')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-blue-900 transition">Dashboard</a>
    <i class="fa-solid fa-chevron-right text-[9px]"></i>
    <span class="text-blue-950 font-bold">Biodata Santri</span>
@endsection

@section('content')
<div class="space-y-6">

    <!-- TOP HEADER -->
    <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200">
                    MANAJEMEN BIODATA
                </span>
                <span class="text-xs text-slate-500 font-medium">
                    Data Pokok Santri
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2.5">
                <i class="fa-solid fa-address-card text-blue-700"></i>
                Direktori Biodata Santri
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl">
                Kelola data identitas peserta database sekolah TPQ &amp; RTQ Ar-Raudhah secara mandiri dan terstruktur.
            </p>
        </div>

        <div class="flex items-center gap-2.5 shrink-0 flex-wrap">
            <a href="{{ route('santri.create', ['jenis' => $jenis ?? 'TPQ']) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-700 text-white shadow-xs transition active:scale-95">
                <i class="fa-solid fa-user-plus text-xs"></i>
                <span>+ Tambah Santri</span>
            </a>
            <a href="{{ route('database_sekolah.index', ['jenis' => $jenis ?? 'TPQ']) }}" 
               class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 transition">
                <i class="fa-solid fa-table-list text-xs text-slate-500"></i>
                <span>Lembar Penilaian</span>
            </a>
        </div>
    </div>

    <!-- STATISTIK CEPAT -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 sm:gap-4">
        <!-- Total Santri -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-900 shrink-0">
                <i class="fa-solid fa-users text-lg"></i>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Total Santri</p>
                <p class="text-xl font-extrabold text-slate-900">{{ number_format($totalSantri) }}</p>
                <div class="flex items-center gap-1.5 mt-0.5 text-[10px] font-bold text-slate-500">
                    <span class="text-blue-700">{{ $totalTPQ }} TPQ</span> • <span class="text-rose-700">{{ $totalRTQ }} RTQ</span>
                </div>
            </div>
        </div>

        <!-- Gender -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-700 shrink-0">
                <i class="fa-solid fa-venus-mars text-lg"></i>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Gender</p>
                <p class="text-xl font-extrabold text-slate-900">{{ $totalLaki + $totalPerem }}</p>
                <div class="flex items-center gap-1.5 mt-0.5 text-[10px] font-bold">
                    <span class="text-sky-600"><i class="fa-solid fa-mars"></i> {{ $totalLaki }}</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-rose-500"><i class="fa-solid fa-venus"></i> {{ $totalPerem }}</span>
                </div>
            </div>
        </div>

        <!-- Status Dinilai -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                <i class="fa-solid fa-file-circle-check text-lg"></i>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Sudah Dinilai</p>
                <p class="text-xl font-extrabold text-emerald-600">{{ number_format($sudahNilai) }}</p>
                <p class="text-[10px] text-slate-500 mt-0.5 font-medium">Tersedia nilai skoring</p>
            </div>
        </div>

        <!-- Belum Dinilai -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                <i class="fa-solid fa-clock text-lg"></i>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Belum Dinilai</p>
                <p class="text-xl font-extrabold text-amber-600">{{ number_format($belumNilai) }}</p>
                <p class="text-[10px] text-slate-500 mt-0.5 font-medium">Menunggu ujian</p>
            </div>
        </div>

        <!-- Unit Lembaga -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3.5 col-span-2 sm:col-span-1">
            <div class="w-11 h-11 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                <i class="fa-solid fa-school text-lg"></i>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Lembaga / Unit</p>
                <p class="text-xl font-extrabold text-slate-900">{{ $units->count() }}</p>
                <p class="text-[10px] text-slate-500 mt-0.5 font-medium">Unit mendaftar</p>
            </div>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs space-y-3">
        <form action="{{ route('santri.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            
            <!-- Tab Filter TPQ / RTQ -->
            <div class="lg:col-span-3 flex items-center p-1 bg-slate-100 rounded-xl border border-slate-200">
                <a href="{{ route('santri.index', array_merge(request()->query(), ['jenis' => null])) }}" 
                   class="flex-1 py-1.5 text-center text-xs font-bold rounded-lg transition {{ empty($jenis) ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                    Semua
                </a>
                <a href="{{ route('santri.index', array_merge(request()->query(), ['jenis' => 'TPQ'])) }}" 
                   class="flex-1 py-1.5 text-center text-xs font-bold rounded-lg transition flex items-center justify-center gap-1.5 {{ $jenis === 'TPQ' ? 'bg-blue-900 text-white shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                    <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ" class="w-3.5 h-3.5 object-contain inline-block">
                    <span>TPQ</span>
                </a>
                <a href="{{ route('santri.index', array_merge(request()->query(), ['jenis' => 'RTQ'])) }}" 
                   class="flex-1 py-1.5 text-center text-xs font-bold rounded-lg transition flex items-center justify-center gap-1.5 {{ $jenis === 'RTQ' ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                    <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ" class="w-3.5 h-3.5 object-contain inline-block">
                    <span>RTQ</span>
                </a>
            </div>

            <!-- Unit Filter -->
            <div class="lg:col-span-3">
                <select name="unit" onchange="this.form.submit()" 
                        class="w-full text-xs font-semibold p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    <option value="">Semua Unit / Lembaga</option>
                    @foreach($units as $u)
                        <option value="{{ $u->nama_unit }}" {{ $unitFilter == $u->nama_unit ? 'selected' : '' }}>
                            {{ $u->nama_unit }} ({{ $u->jenis }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Kelulusan Filter -->
            <div class="lg:col-span-2">
                <select name="status" onchange="this.form.submit()"
                        class="w-full text-xs font-semibold p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    <option value="">Status Kelulusan</option>
                    <option value="LULUS" {{ $statusFilter === 'LULUS' ? 'selected' : '' }}>🟢 LULUS</option>
                    <option value="TIDAK LULUS" {{ $statusFilter === 'TIDAK LULUS' ? 'selected' : '' }}>🔴 TIDAK LULUS</option>
                    <option value="PENDING" {{ $statusFilter === 'PENDING' ? 'selected' : '' }}>🟡 PENDING</option>
                </select>
            </div>

            <!-- Search Input -->
            <div class="lg:col-span-4 flex items-center gap-2">
                @if($jenis)
                    <input type="hidden" name="jenis" value="{{ $jenis }}">
                @endif
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, NISN, wali..."
                           class="w-full pl-8 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition">
                </div>
                <button type="submit" class="px-3.5 py-2 bg-blue-900 hover:bg-blue-800 text-white text-xs font-bold rounded-xl transition shrink-0">
                    Cari
                </button>
                @if($search || $unitFilter || $statusFilter || $jenis)
                <a href="{{ route('santri.index') }}" title="Reset Filter" 
                   class="px-2.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs rounded-xl transition shrink-0">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
                @endif
            </div>

        </form>
    </div>

    <!-- TABEL BIODATA SANTRI -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between flex-wrap gap-2">
            <div>
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-blue-900"></i>
                    Daftar Santri Terdaftar
                    <span class="text-xs font-extrabold text-blue-950 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full">
                        {{ $santris->count() }} Data
                    </span>
                </h2>
            </div>
            <p class="text-xs text-slate-500">Klik nama untuk melihat profil lengkap atau tombol aksi untuk mengubah data.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                        <th class="py-3 px-3 text-center w-12">No</th>
                        <th class="py-3 px-3">Santri</th>
                        <th class="py-3 px-3">No Peserta / NISN</th>
                        <th class="py-3 px-3">Lembaga / Unit</th>
                        <th class="py-3 px-3">Gender / TTL</th>
                        <th class="py-3 px-3">Orang Tua / Wali</th>
                        <th class="py-3 px-3 text-center">Penilaian</th>
                        <th class="py-3 px-3 text-center">Status</th>
                        <th class="py-3 px-3 text-center w-44">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($santris as $index => $s)
                    <tr class="hover:bg-slate-50/80 transition group">
                        <!-- No Urut -->
                        <td class="py-3 px-3 text-center font-bold text-slate-400">
                            {{ $index + 1 }}
                        </td>

                        <!-- Foto & Nama Santri -->
                        <td class="py-3 px-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-12 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden shrink-0 shadow-2xs">
                                    <img src="{{ $s->foto_url }}" alt="{{ $s->nama }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($s->nama) }}&background=0D8ABC&color=fff&size=128';">
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('santri.show', $s->id) }}" class="font-extrabold text-slate-900 hover:text-blue-600 transition truncate block max-w-xs text-xs">
                                        {{ $s->nama }}
                                    </a>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="text-[9px] font-black px-1.5 py-0.5 rounded {{ $s->jenis === 'TPQ' ? 'bg-blue-100 text-blue-900' : 'bg-emerald-100 text-emerald-900' }}">
                                            {{ $s->jenis }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-medium">Tahun {{ $s->tahun_munaqasyah ?? '2026' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- No Peserta / NISN -->
                        <td class="py-3 px-3">
                            <div class="font-mono text-xs font-bold text-slate-800">
                                {{ $s->no_peserta ?? '-' }}
                            </div>
                            <div class="text-[10px] text-slate-500 font-mono mt-0.5">
                                NISN: {{ $s->nisn ?? 'Belum ada' }}
                            </div>
                        </td>

                        <!-- Lembaga / Unit -->
                        <td class="py-3 px-3">
                            <p class="font-bold text-slate-800 truncate max-w-[160px]">{{ $s->nama_unit }}</p>
                            <p class="text-[10px] text-slate-500 font-mono">No. Unit: {{ $s->no_unit ?? '-' }}</p>
                        </td>

                        <!-- Gender / TTL -->
                        <td class="py-3 px-3">
                            <div class="flex items-center gap-1.5">
                                @if($s->jenis_kelamin === 'L')
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-sky-50 border border-sky-200 text-sky-700 font-bold text-[10px]">
                                        <i class="fa-solid fa-mars text-[9px]"></i> Laki-laki
                                    </span>
                                @elseif($s->jenis_kelamin === 'P')
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-rose-50 border border-rose-200 text-rose-700 font-bold text-[10px]">
                                        <i class="fa-solid fa-venus text-[9px]"></i> Perempuan
                                    </span>
                                @else
                                    <span class="text-slate-400 text-[10px]">-</span>
                                @endif
                            </div>
                            <p class="text-[10px] text-slate-500 mt-1 truncate max-w-[140px]">
                                {{ $s->tempat_lahir ? $s->tempat_lahir . ', ' : '' }}{{ $s->tanggal_lahir ? date('d/m/Y', strtotime($s->tanggal_lahir)) : '-' }}
                            </p>
                        </td>

                        <!-- Orang Tua / Wali -->
                        <td class="py-3 px-3">
                            <p class="font-medium text-slate-800 truncate max-w-[150px]">{{ $s->nama_wali ?? '-' }}</p>
                            @if($s->keterangan)
                                <p class="text-[10px] text-slate-400 italic truncate max-w-[150px]">{{ $s->keterangan }}</p>
                            @endif
                        </td>

                        <!-- Status Penilaian -->
                        <td class="py-3 px-3 text-center">
                            @if($s->penilaian)
                                <span class="inline-flex flex-col items-center">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        Sudah Dinilai
                                    </span>
                                    <span class="font-mono text-[10px] font-extrabold text-slate-700 mt-0.5">
                                        Skor: {{ number_format($s->penilaian->total_nilai ?? 0, 1) }}
                                    </span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300">
                                    <i class="fa-regular fa-clock text-[9px]"></i> Belum
                                </span>
                            @endif
                        </td>

                        <!-- Status Kelulusan -->
                        <td class="py-3 px-3 text-center">
                            @if($s->status_kelulusan === 'LULUS')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-600 text-white shadow-2xs">
                                    LULUS
                                </span>
                            @elseif($s->status_kelulusan === 'TIDAK LULUS')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-600 text-white shadow-2xs">
                                    TIDAK LULUS
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-300">
                                    PENDING
                                </span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="py-3 px-3 text-center">
                            <div class="inline-flex items-center gap-1">
                                <!-- Lihat Profil -->
                                <a href="{{ route('santri.show', $s->id) }}" title="Lihat Profil Lengkap"
                                   class="w-7 h-7 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-900 flex items-center justify-center transition">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>

                                <!-- Edit Biodata -->
                                <a href="{{ route('santri.edit', $s->id) }}" title="Edit Biodata Santri"
                                   class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </a>

                                <!-- Input / Edit Nilai -->
                                <a href="{{ route('database_sekolah.edit', $s->id) }}" title="Kelola Nilai Database Sekolah"
                                   class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition">
                                     <i class="fa-solid fa-calculator text-xs"></i>
                                 </a>

                                <!-- Kirim WhatsApp -->
                                @php
                                    $pRow = $s->penilaian;
                                    if ($pRow) {
                                        $waText = "Assalamu'alaikum Wr. Wb. Yth. Wali Santri dari *" . $s->nama . "* (No. Peserta: " . ($s->no_peserta ?? '-') . ").%0A%0AInformasi Hasil Ujian Database Sekolah Yayasan Cahaya Amanah Ar-Raudhah:%0A- Status: *" . $s->status_kelulusan . "*%0A- Predikat: *" . ($pRow->predikat ?? '-') . "*%0A- Rata-rata: *" . number_format($pRow->rata_rata, 2) . "*%0A%0ABerikut tautan resmi Surat Keterangan Kelulusan dan nilai lengkap:%0A" . urlencode(route('public.check.cetak', $s->id)) . "%0A%0ABarakallahu fiikum.%0A_Panitia Database Sekolah Ar-Raudhah_";
                                    } else {
                                        $waText = "Assalamu'alaikum Wr. Wb. Yth. Wali Santri dari *" . $s->nama . "* (No. Peserta: " . ($s->no_peserta ?? '-') . ").%0A%0AInformasi Pendaftaran Ujian Database Sekolah Yayasan Cahaya Amanah Ar-Raudhah:%0A- No. Peserta: " . ($s->no_peserta ?? '-') . "%0A- Lembaga: " . ($s->nama_unit ?? '-') . "%0A- Status: *" . $s->status_kelulusan . "*%0A%0ABarakallahu fiikum.%0A_Panitia Database Sekolah Ar-Raudhah_";
                                    }
                                @endphp
                                <a href="https://api.whatsapp.com/send?text={{ $waText }}" target="_blank" rel="noopener"
                                   title="Kirim Info via WhatsApp"
                                   class="w-7 h-7 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center transition shadow-2xs">
                                    <i class="fa-brands fa-whatsapp text-xs"></i>
                                </a>

                                <!-- Hapus -->
                                <button type="button" onclick="openGlobalDeleteModal('{{ route('santri.destroy', $s->id) }}', '{{ addslashes($s->nama) }}', '{{ $s->no_peserta ?? '-' }}', '{{ $s->nama_unit ?? $s->jenis }}')" 
                                        title="Hapus Data Santri"
                                        class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-12 text-center">
                            <div class="max-w-sm mx-auto space-y-3">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl">
                                    <i class="fa-solid fa-user-slash"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-800">Tidak Ada Data Santri Ditemukan</h3>
                                <p class="text-xs text-slate-500">
                                    @if($search || $unitFilter || $statusFilter)
                                        Pencarian dengan filter saat ini tidak membuahkan hasil. Silakan reset filter atau gunakan kata kunci lain.
                                    @else
                                        Belum ada data santri yang didaftarkan. Mulai tambahkan biodata santri baru sekarang.
                                    @endif
                                </p>
                                <div class="pt-2">
                                    <a href="{{ route('santri.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white transition">
                                        <i class="fa-solid fa-plus"></i> Tambah Santri Baru
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
