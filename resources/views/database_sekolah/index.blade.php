@extends('layouts.sidebar')

@section('title', 'Database Sekolah ' . ($jenis == 'TPQ' ? "Taman Pendidikan Qur'an Ar-Raudhah" : "Rumah Tahfidz Qur'an Ar-Raudhah") . ' 2026')

@section('breadcrumb')
    <span class="text-blue-950 font-bold">Database Sekolah {{ $jenis == 'TPQ' ? "Taman Pendidikan Qur'an Ar-Raudhah (TPQ)" : "Rumah Tahfidz Qur'an Ar-Raudhah (RTQ)" }}</span>
@endsection

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 flex-wrap">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-lg {{ $jenis == 'TPQ' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-blue-100 text-blue-950 border border-blue-300' }}">
                    @if($jenis == 'TPQ')
                        <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ" class="w-4 h-4 object-contain">
                    @elseif($jenis == 'RTQ')
                        <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ" class="w-4 h-4 object-contain">
                    @endif
                    {{ $jenis }}
                </span>
                <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">{{ $jenis == 'TPQ' ? "Taman Pendidikan Qur'an Ar-Raudhah" : "Rumah Tahfidz Qur'an Ar-Raudhah" }}</h2>
            </div>
            <p class="text-xs text-slate-500 mt-1">Database Sekolah nilai bacaan &amp; hafalan <strong class="text-slate-700">{{ $jenis == 'TPQ' ? "Taman Pendidikan Qur'an Ar-Raudhah" : "Rumah Tahfidz Qur'an Ar-Raudhah" }}</strong> · Periode Tahun 2026</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 self-start sm:self-auto">
            <a href="{{ route('database_sekolah.cetak.massal', ['jenis' => $jenis, 'unit' => request('unit')]) }}" target="_blank" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3.5 py-2.5 rounded-xl shadow-xs transition"><i class="fa-solid fa-print"></i> Cetak Massal</a>
            <a href="{{ route('database_sekolah.import', ['jenis' => $jenis]) }}" class="inline-flex items-center gap-1.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs px-3.5 py-2.5 rounded-xl shadow-xs transition"><i class="fa-solid fa-file-excel text-emerald-400"></i> Import Data</a>
            <a href="{{ route('database_sekolah.create', ['jenis' => $jenis]) }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2.5 rounded-xl shadow-xs transition"><i class="fa-solid fa-user-plus"></i> Tambah Santri</a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-3">
        <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-sm flex items-center gap-3"><div class="w-9 h-9 sm:w-11 sm:h-11 bg-blue-50 text-blue-900 border border-blue-100 rounded-xl flex items-center justify-center shrink-0"><i class="fa-solid fa-users"></i></div><div class="min-w-0"><p class="text-xl sm:text-2xl font-black text-slate-900 leading-none">{{ $totalSantri }}</p><p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase mt-0.5 truncate">Total Peserta</p></div></div>
        <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-sm flex items-center gap-3"><div class="w-9 h-9 sm:w-11 sm:h-11 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl flex items-center justify-center shrink-0"><i class="fa-solid fa-graduation-cap"></i></div><div class="min-w-0"><p class="text-xl sm:text-2xl font-black text-emerald-600 leading-none">{{ $totalLulus }}</p><p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase mt-0.5 truncate">Lulus</p></div></div>
        <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-sm flex items-center gap-3"><div class="w-9 h-9 sm:w-11 sm:h-11 bg-amber-50 text-amber-600 border border-amber-100 rounded-xl flex items-center justify-center shrink-0"><i class="fa-solid fa-chart-line"></i></div><div class="min-w-0"><p class="text-xl sm:text-2xl font-black text-amber-600 leading-none">{{ number_format($rataRataKeseluruhan, 1) }}</p><p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase mt-0.5 truncate">Rata-rata</p></div></div>
    </div>

    <div class="bg-white p-3 sm:p-4 rounded-xl border border-slate-200 shadow-sm">
        <form action="{{ route('database_sekolah.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center gap-2">
            <input type="hidden" name="jenis" value="{{ $jenis }}">
            <div class="relative flex-1"><i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i><input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama santri..." class="pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none w-full"></div>
            <select name="unit" onchange="this.form.submit()" class="py-2 px-3 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none w-full sm:w-auto font-medium"><option value="">Semua Unit</option>@foreach($units as $u)<option value="{{ $u->nama_unit }}" {{ request('unit') == $u->nama_unit ? 'selected' : '' }}>{{ $u->nama_unit }}</option>@endforeach</select>
            <div class="flex items-center gap-2"><button type="submit" class="flex-1 sm:flex-none bg-blue-950 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-slate-900 transition"><i class="fa-solid fa-filter mr-1"></i>Filter</button>@if(request('search') || request('unit'))<a href="{{ route('database_sekolah.index', ['jenis' => $jenis]) }}" class="text-center text-xs text-rose-600 font-semibold py-2 px-3 bg-rose-50 rounded-lg">Reset</a>@endif<a href="{{ route('database_sekolah.export.excel', ['jenis' => $jenis, 'unit' => request('unit')]) }}" class="hidden sm:inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-800 border border-emerald-300 px-3 py-2 rounded-lg text-xs font-bold"><i class="fa-solid fa-file-excel text-emerald-600"></i> Excel</a><a href="{{ route('database_sekolah.export.csv', ['jenis' => $jenis, 'unit' => request('unit')]) }}" class="hidden sm:inline-flex items-center gap-1.5 bg-slate-100 text-slate-800 border border-slate-300 px-3 py-2 rounded-lg text-xs font-bold"><i class="fa-solid fa-file-csv text-slate-600"></i> CSV</a></div>
        </form>
    </div>

    <div class="block md:hidden space-y-3">
        @forelse($santris as $santri)
            @php $p = $santri->penilaian; $isRed = ($p && $p->rata_rata < 60) || ($santri->status_kelulusan == 'TIDAK LULUS'); $isLulus = $santri->status_kelulusan == 'LULUS'; @endphp
            <div class="bg-white rounded-xl border {{ $isRed ? 'border-rose-200' : 'border-slate-200' }} shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 p-3 {{ $isRed ? 'bg-rose-50' : 'bg-slate-50' }} border-b {{ $isRed ? 'border-rose-100' : 'border-slate-100' }}"><div class="w-12 h-12 rounded-xl overflow-hidden border-2 bg-slate-100 shrink-0"><img src="{{ $santri->foto_url }}" alt="{{ $santri->nama }}" class="w-full h-full object-cover"></div><div class="flex-1 min-w-0"><div class="flex items-center gap-1.5 flex-wrap"><p class="font-extrabold text-slate-900 text-sm truncate">{{ $santri->nama }}</p>@if($santri->jenis_kelamin)<span class="text-[9px] px-1.5 py-0.5 rounded font-bold {{ $santri->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">{{ $santri->jenis_kelamin }}</span>@endif</div><p class="text-xs text-slate-500 truncate">{{ $santri->nama_unit ?? '-' }}</p><div class="flex items-center gap-1.5 mt-1 flex-wrap"><span class="text-[10px] font-mono font-bold text-slate-600 bg-slate-200 px-1.5 py-0.5 rounded">#{{ $santri->no_peserta ?? '-' }}</span><span class="text-[10px] font-bold text-amber-800 bg-amber-100 border border-amber-200 px-1.5 py-0.5 rounded">{{ $santri->tahun_munaqasyah ?? '2026' }}</span></div></div><div class="text-right shrink-0"><p class="text-2xl font-black {{ $isRed ? 'text-rose-600' : 'text-emerald-600' }}">{{ $p ? number_format($p->rata_rata, 1) : '-' }}</p><p class="text-[9px] text-slate-400">Rata-rata</p></div></div>
                @if($p)<div class="grid grid-cols-3 gap-px bg-slate-100 border-b border-slate-100">@foreach([['Fashohah',$p->fashohah],['Tajwid',$p->tajwid],['Gharib',$p->gharib_musykilat],['Suara & Lagu',$p->suara_lagu],['Ayat Pilihan',$p->ayat_pilihan],['Surah Pendek',$p->surah_pendek],['Doa Harian',$p->doa_harian],['Bac. Shalat',$p->bacaan_shalat],['Tertulis',$p->ujian_tertulis]] as [$label,$val])<div class="bg-white p-2 text-center"><p class="text-[9px] text-slate-400">{{ $label }}</p><p class="text-sm font-bold font-mono">{{ $val !== null ? number_format($val,0) : '-' }}</p></div>@endforeach</div>@else<div class="p-3 text-center text-xs text-slate-400 italic">Belum ada penilaian</div>@endif
                @php $waTextSantri = "Assalamu'alaikum Wr. Wb. Yth. Wali Santri dari *" . $santri->nama . "* (No. Peserta: " . ($santri->no_peserta ?? '-') . ").%0A%0AAlhamdulillah, ananda dinyatakan *" . $santri->status_kelulusan . "* pada Ujian Database Sekolah Yayasan Cahaya Amanah Ar-Raudhah dengan Predikat *" . ($p ? $p->predikat : '-') . "* (Rata-rata: " . ($p ? number_format($p->rata_rata, 2) : '-') . ").%0A%0ABerikut tautan resmi Surat Keterangan Kelulusan dan nilai lengkap:%0A" . urlencode(route('public.check.cetak', $santri->id)) . "%0A%0ABarakallahu fiikum.%0A_Panitia Database Sekolah Ar-Raudhah_"; @endphp
                <div class="flex items-center gap-2 p-2.5 bg-white"><a href="https://api.whatsapp.com/send?text={{ $waTextSantri }}" target="_blank" rel="noopener" class="p-2 bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-200"><i class="fa-brands fa-whatsapp"></i></a><a href="{{ route('database_sekolah.kelulusan',$santri->id) }}" target="_blank" class="flex-1 text-center text-xs font-bold bg-blue-50 text-blue-900 py-2 rounded-lg border border-blue-200"><i class="fa-solid fa-id-card"></i> Sertifikat</a><a href="{{ route('database_sekolah.edit',$santri->id) }}" class="flex-1 text-center text-xs font-bold bg-slate-100 text-slate-800 py-2 rounded-lg"><i class="fa-solid fa-pen-to-square"></i> Edit</a><button type="button" onclick="openGlobalDeleteModal('{{ route('database_sekolah.destroy', $santri->id) }}', '{{ addslashes($santri->nama) }}', '{{ $santri->no_peserta ?? '-' }}', '{{ $santri->nama_unit ?? $santri->jenis }}')" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg transition" title="Hapus Data Santri"><i class="fa-solid fa-trash-can"></i></button></div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-slate-200 p-10 text-center"><i class="fa-solid fa-inbox text-4xl text-slate-300 mb-3 block"></i><p class="text-slate-600 text-sm font-semibold">Belum ada data santri.</p></div>
        @endforelse
    </div>

    <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse table-custom min-w-[1550px]">
                <thead>
                    <tr class="bg-slate-800 text-white font-bold uppercase tracking-wider text-[11px]">
                        <th rowspan="2" class="w-12 bg-slate-900 text-slate-200">NO. PESERTA</th><th rowspan="2" class="w-10 bg-slate-900 text-slate-200">UNIT</th><th rowspan="2" class="text-left w-56 bg-slate-800 text-white">NAMA SANTRI</th><th rowspan="2" class="w-14 bg-slate-800 text-slate-200">FOTO</th><th rowspan="2" class="w-24 bg-slate-800 text-slate-200">LEMBAGA</th>
                        <th colspan="4" class="bg-slate-700 text-slate-100 border-b border-slate-600">NILAI BACAAN</th><th colspan="4" class="bg-slate-700 text-slate-100 border-b border-slate-600">NILAI HAFALAN</th>
                        <th rowspan="2" class="w-14 bg-slate-800 text-slate-200">TERTULIS</th><th rowspan="2" class="w-16 bg-slate-900 text-white">JUMLAH</th><th rowspan="2" class="w-16 bg-blue-950 text-white font-black">RATA²</th><th rowspan="2" class="w-20 bg-slate-800 text-slate-200">ANGKATAN</th><th rowspan="2" class="w-32 bg-slate-800 text-slate-200 no-print">AKSI</th>
                    </tr>
                    <tr class="bg-slate-100 text-slate-700 font-bold text-[10px] uppercase"><th class="w-12">FASHOHAH</th><th class="w-12">TAJWID</th><th class="w-14">GHARIB</th><th class="w-14">SUARA</th><th class="w-14">AYAT</th><th class="w-12">S.PENDEK</th><th class="w-12">DOA</th><th class="w-14">BAC. SHALAT</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-xs">
                    @forelse($santris as $santri)
                        @php
                            $p = $santri->penilaian;
                            $isRed = ($p && $p->rata_rata < 60) || ($santri->status_kelulusan == 'TIDAK LULUS');
                            $waTextSantri = "Assalamu'alaikum Wr. Wb. Yth. Wali Santri dari *" . $santri->nama . "* (No. Peserta: " . ($santri->no_peserta ?? '-') . ").%0A%0AAlhamdulillah, ananda dinyatakan *" . $santri->status_kelulusan . "* pada Ujian Database Sekolah Yayasan Cahaya Amanah Ar-Raudhah dengan Predikat *" . ($p ? $p->predikat : '-') . "* (Rata-rata: " . ($p ? number_format($p->rata_rata, 2) : '-') . ").%0A%0ABerikut tautan resmi Surat Keterangan Kelulusan dan nilai lengkap:%0A" . urlencode(route('public.check.cetak', $santri->id)) . "%0A%0ABarakallahu fiikum.%0A_Panitia Database Sekolah Ar-Raudhah_";
                        @endphp
                        <tr class="hover:bg-slate-50 transition {{ $isRed ? 'bg-rose-50 text-rose-900' : '' }}">
                            <td class="font-bold text-slate-700 bg-slate-50/50">{{ $santri->no_peserta ?? '-' }}</td><td class="text-slate-600">{{ $santri->no_unit ?? '-' }}</td><td class="text-left font-semibold text-slate-900 px-3">{{ $santri->nama }} @if($santri->jenis_kelamin)<span class="ml-1 text-[9px] px-1.5 py-0.5 rounded font-bold {{ $santri->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">{{ $santri->jenis_kelamin }}</span>@endif</td>
                            <td class="p-1"><div class="w-10 h-10 mx-auto rounded-lg overflow-hidden border border-slate-200 shadow-sm bg-slate-100"><img src="{{ $santri->foto_url }}" alt="{{ $santri->nama }}" class="w-full h-full object-cover"></div></td><td class="font-medium text-slate-700">{{ $santri->nama_unit ?? '-' }}</td>
                            <td class="font-mono text-slate-800">{{ $p ? number_format($p->fashohah,0) : '-' }}</td><td class="font-mono text-slate-800">{{ $p ? number_format($p->tajwid,0) : '-' }}</td><td class="font-mono text-slate-800">{{ $p ? number_format($p->gharib_musykilat,0) : '-' }}</td><td class="font-mono text-slate-800">{{ $p ? number_format($p->suara_lagu,0) : '-' }}</td><td class="font-mono text-slate-800">{{ $p ? number_format($p->ayat_pilihan,0) : '-' }}</td><td class="font-mono text-slate-800">{{ $p ? number_format($p->surah_pendek,0) : '-' }}</td><td class="font-mono text-slate-800">{{ $p ? number_format($p->doa_harian,0) : '-' }}</td><td class="font-mono text-slate-800">{{ $p ? number_format($p->bacaan_shalat,0) : '-' }}</td><td class="font-mono text-slate-800 bg-slate-50/50">{{ $p ? number_format($p->ujian_tertulis,0) : '-' }}</td>
                            <td class="font-mono font-bold text-slate-900 bg-slate-100/60">{{ $p ? number_format($p->jumlah_nilai,0) : '-' }}</td>
                            <td class="font-mono font-black text-blue-950 bg-blue-50">{{ $p ? number_format($p->rata_rata,1) : '-' }}</td>
                            <td class="font-bold text-amber-800 bg-amber-50/70">{{ $santri->tahun_munaqasyah ?? '2026' }}</td>
                            <td class="no-print"><div class="flex items-center justify-center gap-1.5 whitespace-nowrap"><a href="https://api.whatsapp.com/send?text={{ $waTextSantri }}" target="_blank" rel="noopener" class="w-8 h-8 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 border border-emerald-200 rounded-lg text-xs flex items-center justify-center transition" title="Kirim Hasil ke WhatsApp"><i class="fa-brands fa-whatsapp"></i></a><a href="{{ route('database_sekolah.kelulusan',$santri->id) }}" target="_blank" class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-900 border border-blue-200 rounded-lg text-xs flex items-center justify-center transition" title="Lihat Surat Kelulusan"><i class="fa-solid fa-id-card"></i></a><a href="{{ route('database_sekolah.edit',$santri->id) }}" class="w-8 h-8 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs flex items-center justify-center transition" title="Edit Data Santri"><i class="fa-solid fa-pen-to-square"></i></a><button type="button" onclick="openGlobalDeleteModal('{{ route('database_sekolah.destroy', $santri->id) }}', '{{ addslashes($santri->nama) }}', '{{ $santri->no_peserta ?? '-' }}', '{{ $santri->nama_unit ?? $santri->jenis }}')" class="w-8 h-8 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs flex items-center justify-center transition" title="Hapus Data Santri"><i class="fa-solid fa-trash-can"></i></button></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="18" class="py-12 text-center text-slate-400"><i class="fa-solid fa-inbox text-4xl mb-3 block text-slate-300"></i><p class="text-sm font-semibold text-slate-600">Belum ada data santri untuk kategori {{ $jenis == 'TPQ' ? "Taman Pendidikan Qur'an Ar-Raudhah (TPQ)" : "Rumah Tahfidz Qur'an Ar-Raudhah (RTQ)" }}</p><a href="{{ route('database_sekolah.create', ['jenis' => $jenis]) }}" class="mt-2 inline-block text-blue-600 font-bold hover:underline text-xs">+ Tambah Santri {{ $jenis }} Sekarang</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-2 bg-slate-50 border-t border-slate-100 text-[10px] text-slate-400 flex items-center gap-1.5"><i class="fa-solid fa-arrows-left-right"></i> Geser tabel ke kanan untuk melihat semua kolom</div>
    </div>
</div>
@endsection
