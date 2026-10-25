@extends('layouts.sidebar')

@section('title', 'Import Data Nilai Database Sekolah ' . $jenis . ' | Ar-Raudhah')

@section('breadcrumb')
    <a href="{{ route('database_sekolah.index', ['jenis' => $jenis]) }}" class="hover:underline">Database Sekolah {{ $jenis }}</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
    <span class="text-blue-950 font-bold">Import Spreadsheet</span>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 text-xs font-bold rounded-lg {{ $jenis == 'TPQ' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-blue-100 text-blue-950 border border-blue-300' }}">
                    {{ $jenis }}
                </span>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Import Data Nilai Database Sekolah</h2>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Unggah berkas spreadsheet CSV untuk mengimpor atau memperbarui data santri dan nilai secara massal.
            </p>
        </div>
        <a href="{{ route('database_sekolah.index', ['jenis' => $jenis]) }}"
            class="self-start sm:self-auto inline-flex items-center gap-2 text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 px-3.5 py-2 rounded-xl transition shadow-xs">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-rose-600 text-sm shrink-0"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Left Form (2 cols) --}}
        <div class="md:col-span-2 space-y-5">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-sm font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up text-blue-900"></i> Form Unggah Berkas
                </h3>

                <form action="{{ route('database_sekolah.import.post') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Lembaga / Jenjang</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-2.5 p-3 rounded-xl border {{ $jenis == 'TPQ' ? 'border-amber-500 bg-amber-50/60 ring-2 ring-amber-400/30' : 'border-slate-200 bg-slate-50' }} cursor-pointer transition">
                                <input type="radio" name="jenis" value="TPQ" {{ $jenis == 'TPQ' ? 'checked' : '' }} onchange="window.location.href='{{ route('database_sekolah.import', ['jenis' => 'TPQ']) }}'" class="text-amber-600 focus:ring-amber-500">
                                <div>
                                    <p class="text-xs font-bold text-slate-900">TPQ Ar-Raudhah</p>
                                    <p class="text-[10px] text-slate-500">Taman Pendidikan Qur'an</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-2.5 p-3 rounded-xl border {{ $jenis == 'RTQ' ? 'border-blue-900 bg-blue-50/60 ring-2 ring-blue-900/30' : 'border-slate-200 bg-slate-50' }} cursor-pointer transition">
                                <input type="radio" name="jenis" value="RTQ" {{ $jenis == 'RTQ' ? 'checked' : '' }} onchange="window.location.href='{{ route('database_sekolah.import', ['jenis' => 'RTQ']) }}'" class="text-blue-900 focus:ring-blue-900">
                                <div>
                                    <p class="text-xs font-bold text-slate-900">RTQ Ar-Raudhah</p>
                                    <p class="text-[10px] text-slate-500">Rumah Tahfidz Qur'an</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilih File Spreadsheet (CSV)</label>
                        <div class="border-2 border-dashed border-slate-300 hover:border-blue-900 rounded-2xl p-6 text-center transition bg-slate-50/60 hover:bg-blue-50/30 group">
                            <input type="file" name="file" id="fileInput" accept=".csv,.txt" required class="hidden" onchange="updateFilename(this)">
                            <label for="fileInput" class="cursor-pointer block">
                                <div class="w-12 h-12 mx-auto mb-2 bg-blue-100 text-blue-900 rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-file-csv"></i>
                                </div>
                                <p class="text-xs font-bold text-slate-800" id="fileNameLabel">Klik untuk memilih file CSV</p>
                                <p class="text-[10px] text-slate-400 mt-1">Mendukung format .csv (terpisah koma atau titik-koma). Maks. 5 MB</p>
                            </label>
                        </div>
                        @error('file')
                            <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                        <a href="{{ route('database_sekolah.index', ['jenis' => $jenis]) }}" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-950 to-slate-900 hover:from-slate-900 hover:to-blue-950 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition active:scale-95">
                            <i class="fa-solid fa-upload"></i> Proses &amp; Impor Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right Column: Download Template & Help --}}
        <div class="space-y-4">
            {{-- Template Download Card --}}
            <div class="bg-gradient-to-br from-emerald-500 to-teal-700 text-white rounded-2xl p-5 shadow-sm space-y-3">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-xs rounded-xl flex items-center justify-center text-lg">
                    <i class="fa-solid fa-download"></i>
                </div>
                <div>
                    <h4 class="font-black text-sm">Download Template CSV</h4>
                    <p class="text-[11px] text-emerald-100 mt-0.5">Gunakan format resmi berikut agar struktur kolom terisi dengan tepat.</p>
                </div>
                <a href="{{ route('database_sekolah.import.template', ['jenis' => $jenis]) }}"
                    class="w-full inline-flex items-center justify-center gap-2 bg-white text-emerald-800 hover:bg-emerald-50 font-extrabold text-xs py-2.5 rounded-xl shadow-sm transition">
                    <i class="fa-solid fa-file-excel"></i> Unduh Format {{ $jenis }} (.csv)
                </a>
            </div>

            {{-- Guide Card --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm text-xs space-y-3">
                <h4 class="font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-blue-900"></i> Petunjuk Pengisian
                </h4>
                <ol class="list-decimal list-inside space-y-1.5 text-slate-600 text-[11px] leading-relaxed">
                    <li>Gunakan software Excel, Calc, atau Google Sheets lalu simpan sebagai <strong>CSV (Comma Delimited)</strong>.</li>
                    <li>Kolom <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-800">NO_PESERTA</code> dan <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-800">NAMA_SANTRI</code> wajib diisi.</li>
                    <li>Kolom <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-800">JENIS_KELAMIN</code> diisi dengan <strong>L</strong> atau <strong>P</strong>.</li>
                    <li>Nilai komponen (Fashohah, Tajwid, dll.) diisi angka rentang <strong>0 – 100</strong>.</li>
                    <li>Jika santri dengan nomor peserta sudah ada di sistem, maka data nilai akan diperbarui (update otomatis).</li>
                </ol>
            </div>
        </div>

    </div>

    {{-- Format Columns Specification Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h4 class="font-extrabold text-xs text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-table-columns text-slate-600"></i> Struktur Header Kolom CSV
            </h4>
            <span class="text-[10px] text-slate-400">Total 14 Kolom</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-[11px] text-left">
                <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200">
                    <tr>
                        <th class="px-3 py-2">No</th>
                        <th class="px-3 py-2">Nama Kolom Header</th>
                        <th class="px-3 py-2">Keterangan</th>
                        <th class="px-3 py-2">Contoh Nilai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-mono">
                    <tr><td class="px-3 py-1.5 font-sans text-slate-400">1</td><td class="px-3 py-1.5 font-bold text-blue-900">NO_PESERTA</td><td class="px-3 py-1.5 font-sans">Nomor dada/ujian peserta</td><td class="px-3 py-1.5">001</td></tr>
                    <tr><td class="px-3 py-1.5 font-sans text-slate-400">2</td><td class="px-3 py-1.5 font-bold text-blue-900">NO_UNIT</td><td class="px-3 py-1.5 font-sans">Nomor kode unit lembaga</td><td class="px-3 py-1.5">01</td></tr>
                    <tr><td class="px-3 py-1.5 font-sans text-slate-400">3</td><td class="px-3 py-1.5 font-bold text-blue-900">NAMA_SANTRI</td><td class="px-3 py-1.5 font-sans">Nama lengkap santri</td><td class="px-3 py-1.5 font-sans">Muhammad Rayhan</td></tr>
                    <tr><td class="px-3 py-1.5 font-sans text-slate-400">4</td><td class="px-3 py-1.5 font-bold text-blue-900">JENIS_KELAMIN</td><td class="px-3 py-1.5 font-sans">Laki-laki (L) / Perempuan (P)</td><td class="px-3 py-1.5">L</td></tr>
                    <tr><td class="px-3 py-1.5 font-sans text-slate-400">5</td><td class="px-3 py-1.5 font-bold text-blue-900">NAMA_UNIT</td><td class="px-3 py-1.5 font-sans">Nama unit atau asal sekolah</td><td class="px-3 py-1.5 font-sans">Unit Ar-Raudhah Pusat</td></tr>
                    <tr><td class="px-3 py-1.5 font-sans text-slate-400">6..9</td><td class="px-3 py-1.5 font-bold text-amber-700">FASHOHAH, TAJWID, GHARIB_MUSYKILAT, SUARA_LAGU</td><td class="px-3 py-1.5 font-sans">4 Aspek Database Sekolah Bacaan (0-100)</td><td class="px-3 py-1.5">85, 88, 84, 82</td></tr>
                    <tr><td class="px-3 py-1.5 font-sans text-slate-400">10..13</td><td class="px-3 py-1.5 font-bold text-emerald-700">AYAT_PILIHAN, SURAH_PENDEK, DOA_HARIAN, BACAAN_SHALAT</td><td class="px-3 py-1.5 font-sans">4 Aspek Database Sekolah Hafalan (0-100)</td><td class="px-3 py-1.5">86, 90, 88, 85</td></tr>
                    <tr><td class="px-3 py-1.5 font-sans text-slate-400">14</td><td class="px-3 py-1.5 font-bold text-purple-700">UJIAN_TERTULIS</td><td class="px-3 py-1.5 font-sans">Aspek Ujian Tulis (0-100)</td><td class="px-3 py-1.5">87</td></tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function updateFilename(input) {
        if (input.files && input.files[0]) {
            document.getElementById('fileNameLabel').innerHTML = '<span class="text-emerald-700 font-extrabold"><i class="fa-solid fa-circle-check mr-1"></i> ' + input.files[0].name + '</span> (' + (input.files[0].size / 1024).toFixed(1) + ' KB)';
        }
    }
</script>
@endsection
