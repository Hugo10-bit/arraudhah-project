@extends('layouts.sidebar')

@section('title', 'Tambah Biodata Santri | Yayasan Cahaya Amanah Ar-Raudhah')

@section('breadcrumb')
    <a href="{{ route('santri.index') }}" class="hover:text-blue-900 transition">Biodata Santri</a>
    <i class="fa-solid fa-chevron-right text-[9px]"></i>
    <span class="text-blue-950 font-bold">Pendaftaran Siswa Baru</span>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-5 sm:space-y-6">

    <!-- Header Card -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-0.5 rounded-full {{ ($jenis ?? 'TPQ') === 'RTQ' ? 'bg-emerald-100 text-emerald-950 border border-emerald-300' : 'bg-blue-100 text-blue-950 border border-blue-300' }}">
                    <img src="{{ ($jenis ?? 'TPQ') === 'RTQ' ? asset('images/logo_rtq.png') : asset('images/logo_tpq.png') }}" alt="Logo {{ $jenis ?? 'TPQ' }}" class="w-3.5 h-3.5 object-contain">
                    Form Pendaftaran Siswa ({{ $jenis ?? 'TPQ' }})
                </span>
                <h2 class="text-base sm:text-lg font-extrabold text-slate-900">Tambah Biodata Santri Baru</h2>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Isi data diri santri, foto kelulusan, dan data wali secara terpisah dari lembar penilaian database_sekolah.
            </p>
        </div>
        <a href="{{ route('santri.index') }}" 
           class="inline-flex items-center justify-center gap-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 border border-slate-200 px-3.5 py-2 rounded-xl transition shrink-0">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Direktori
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl text-rose-800 text-xs shadow-xs">
            <div class="flex items-center gap-2 font-bold mb-1.5">
                <i class="fa-solid fa-circle-exclamation text-rose-600 text-sm"></i>
                <span>Terdapat kesalahan pengisian formulir:</span>
            </div>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('santri.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 sm:space-y-6">
        @csrf

        <!-- CARD 1: FOTO & IDENTITAS UTAMA -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-950 flex items-center justify-center text-xs font-black">1</span>
                    Identitas Pokok &amp; Pas Foto
                </h3>
                <span class="text-[11px] text-slate-400 font-semibold">* Wajib diisi</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">
                <!-- Upload Pas Foto -->
                <div class="md:col-span-1 flex flex-col items-center justify-center p-4 bg-slate-50 border-2 border-dashed border-slate-300 hover:border-blue-500 rounded-2xl transition">
                    <div class="w-32 h-40 bg-slate-200 rounded-xl overflow-hidden border border-slate-300 shadow-inner flex items-center justify-center relative mb-3">
                        <img id="photo-preview" src="https://ui-avatars.com/api/?name=Foto+Santri&background=e2e8f0&color=64748b&size=250" 
                             alt="Preview Pas Foto" class="w-full h-full object-cover">
                    </div>
                    <label class="cursor-pointer bg-blue-950 hover:bg-slate-900 text-white text-xs font-bold px-3.5 py-2 rounded-xl shadow-xs transition inline-flex items-center gap-1.5 active:scale-95">
                        <i class="fa-solid fa-camera"></i> Unggah Pas Foto
                        <input type="file" name="foto" id="foto-input" accept="image/*" class="hidden" onchange="previewImage(this)">
                    </label>
                    <p class="text-[10px] text-slate-400 mt-2 text-center leading-tight">Format JPG/PNG/WEBP (Maks 2MB). Foto akan dicetak pada piagam &amp; sertifikat.</p>
                </div>

                <!-- Kolom Input Identitas -->
                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                    <!-- Jenjang Pendidikan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Jenjang Pendidikan <span class="text-rose-500">*</span>
                        </label>
                        <select name="jenis" id="jenisSelect" class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition font-bold">
                            <option value="TPQ" {{ old('jenis', $jenis) === 'TPQ' ? 'selected' : '' }}>TPQ - Taman Pendidikan Qur'an</option>
                            <option value="RTQ" {{ old('jenis', $jenis) === 'RTQ' ? 'selected' : '' }}>RTQ - Rumah Tahfidz Qur'an</option>
                        </select>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Nama Lengkap Santri <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="cth: MUHAMMAD SYAUQI"
                               class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition uppercase font-semibold">
                    </div>

                    <!-- No Peserta -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Peserta Ujian</label>
                        <input type="text" name="no_peserta" value="{{ old('no_peserta') }}" placeholder="cth: 001 atau TPQ-01"
                               class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition font-mono">
                    </div>

                    <!-- NISN -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">NISN (Nomor Induk Santri Nasional)</label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="cth: 0123456789"
                               class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition font-mono">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin</label>
                        <div class="flex items-center gap-4 pt-1">
                            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                                <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', 'L') === 'L' ? 'checked' : '' }} class="accent-blue-900 w-4 h-4">
                                <span><i class="fa-solid fa-mars text-sky-600"></i> Laki-laki</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                                <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') === 'P' ? 'checked' : '' }} class="accent-rose-600 w-4 h-4">
                                <span><i class="fa-solid fa-venus text-rose-500"></i> Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <!-- Tahun Database Sekolah -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tahun Angkatan / Database Sekolah</label>
                        <input type="text" name="tahun_munaqasyah" value="{{ old('tahun_munaqasyah', '2026') }}" placeholder="2026"
                               class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition font-mono">
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 2: KELAHIRAN & LEMBAGA -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center text-xs font-black">2</span>
                    Tempat Tanggal Lahir &amp; Lembaga Asal
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Tempat Lahir -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="cth: Banjarbaru"
                           class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                           class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition">
                </div>

                <!-- Nama Unit / Lembaga -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Nama Lembaga / Unit <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_unit" id="nama_unit" value="{{ old('nama_unit', 'AL-FALAH') }}" list="unitList" required placeholder="cth: AL-FALAH"
                           class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition uppercase font-semibold">
                    <datalist id="unitList">
                        @foreach($units as $u)
                            <option value="{{ $u->nama_unit }}">{{ $u->nama_unit }} ({{ $u->jenis }})</option>
                        @endforeach
                    </datalist>
                    <p class="text-[10px] text-slate-400 mt-1">Pilih dari rekomendasi unit atau ketik nama lembaga baru.</p>
                </div>

                <!-- No Unit -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Unit Lembaga</label>
                    <input type="text" name="no_unit" value="{{ old('no_unit', '01') }}" placeholder="cth: 01"
                           class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition font-mono">
                </div>
            </div>
        </div>

        <!-- CARD 3: ORANG TUA / WALI & KETERANGAN -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-900 flex items-center justify-center text-xs font-black">3</span>
                    Informasi Orang Tua / Wali &amp; Catatan
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nama Wali -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Orang Tua / Wali Santri</label>
                    <input type="text" name="nama_wali" value="{{ old('nama_wali') }}" placeholder="cth: AHMAD SUBAGIO"
                           class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition uppercase">
                </div>

                <!-- Keterangan Tambahan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan Tambahan (Opsional)</label>
                    <input type="text" name="keterangan" value="{{ old('keterangan') }}" placeholder="Catatan berkas, status beasiswa, dll."
                           class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition">
                </div>
            </div>
        </div>

        <!-- TOMBOL AKSI SIMPAN -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3">
            <a href="{{ route('santri.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition">
                <i class="fa-solid fa-xmark mr-1"></i> Batalkan
            </a>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                <!-- Simpan Saja -->
                <button type="submit" name="action" value="save_only"
                        class="flex-1 sm:flex-none px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center justify-center gap-2 active:scale-95">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Simpan Biodata</span>
                </button>

                <!-- Simpan & Lanjut Isi Nilai -->
                <button type="submit" name="action" value="save_and_grade"
                        class="flex-1 sm:flex-none px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition shadow-md shadow-blue-900/20 flex items-center justify-center gap-2 active:scale-95">
                    <i class="fa-solid fa-clipboard-check text-xs"></i>
                    <span>Simpan &amp; Lanjut Isi Nilai</span>
                </button>
            </div>
        </div>

    </form>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('photo-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
