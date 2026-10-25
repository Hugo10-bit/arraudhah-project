@extends('layouts.sidebar')

@section('title', 'Edit Biodata Santri: ' . $santri->nama)

@section('breadcrumb')
    <a href="{{ route('santri.index') }}" class="hover:text-blue-900 transition">Biodata Santri</a>
    <i class="fa-solid fa-chevron-right text-[9px]"></i>
    <a href="{{ route('santri.show', $santri->id) }}" class="hover:text-blue-900 transition">{{ $santri->nama }}</a>
    <i class="fa-solid fa-chevron-right text-[9px]"></i>
    <span class="text-blue-950 font-bold">Edit</span>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-5 sm:space-y-6">

    <!-- Header Card -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-0.5 rounded-full {{ $santri->jenis === 'TPQ' ? 'bg-blue-100 text-blue-900' : 'bg-emerald-100 text-emerald-900' }}">
                    @if($santri->jenis === 'TPQ')
                        <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ" class="w-3.5 h-3.5 object-contain">
                    @elseif($santri->jenis === 'RTQ')
                        <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ" class="w-3.5 h-3.5 object-contain">
                    @endif
                    {{ $santri->jenis }}
                </span>
                <h2 class="text-base sm:text-lg font-extrabold text-slate-900">Edit Biodata Santri</h2>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Perbarui identitas <strong class="text-slate-800">{{ $santri->nama }}</strong> tanpa memengaruhi catatan penilaian database_sekolah.
            </p>
        </div>
        <div class="flex items-center gap-2">
            @if(session('user_role') === 'Administrator')
            <button type="button"
                    onclick="openGlobalDeleteModal('{{ route('santri.destroy', $santri->id) }}', '{{ addslashes($santri->nama) }}', '{{ $santri->no_peserta ?? '-' }}', '{{ $santri->nama_unit ?? $santri->jenis }}')"
                    class="inline-flex items-center justify-center gap-1.5 text-xs font-bold text-rose-700 hover:text-white bg-rose-50 hover:bg-rose-600 border border-rose-200 px-3.5 py-2 rounded-xl transition shrink-0"
                    title="Hapus Santri">
                <i class="fa-solid fa-trash-can text-xs"></i> Hapus
            </button>
            @endif
            <a href="{{ route('santri.show', $santri->id) }}" 
               class="inline-flex items-center justify-center gap-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 border border-slate-200 px-3.5 py-2 rounded-xl transition shrink-0">
                <i class="fa-solid fa-eye text-xs"></i> Lihat Profil
            </a>
            <a href="{{ route('database_sekolah.edit', $santri->id) }}" 
               class="inline-flex items-center justify-center gap-2 text-xs font-semibold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 px-3.5 py-2 rounded-xl transition shrink-0">
                <i class="fa-solid fa-calculator text-xs"></i> Form Nilai
            </a>
        </div>
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

    <form action="{{ route('santri.update', $santri->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 sm:space-y-6">
        @csrf
        @method('PUT')

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
                        <img id="photo-preview" src="{{ $santri->foto_url }}" 
                             alt="Pas Foto {{ $santri->nama }}" class="w-full h-full object-cover">
                    </div>
                    <label class="cursor-pointer bg-blue-950 hover:bg-slate-900 text-white text-xs font-bold px-3.5 py-2 rounded-xl shadow-xs transition inline-flex items-center gap-1.5 active:scale-95">
                        <i class="fa-solid fa-camera"></i> Ganti Pas Foto
                        <input type="file" name="foto" id="foto-input" accept="image/*" class="hidden" onchange="previewImage(this)">
                    </label>
                    <p class="text-[10px] text-slate-400 mt-2 text-center leading-tight">Biarkan kosong jika tidak ingin mengubah foto saat ini.</p>
                </div>

                <!-- Kolom Input Identitas -->
                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                    <!-- Jenjang Pendidikan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Jenjang Pendidikan <span class="text-rose-500">*</span>
                        </label>
                        <select name="jenis" class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition font-bold">
                            <option value="TPQ" {{ old('jenis', $santri->jenis) === 'TPQ' ? 'selected' : '' }}>TPQ - Taman Pendidikan Qur'an</option>
                            <option value="RTQ" {{ old('jenis', $santri->jenis) === 'RTQ' ? 'selected' : '' }}>RTQ - Rumah Tahfidz Qur'an</option>
                        </select>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Nama Lengkap Santri <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama" value="{{ old('nama', $santri->nama) }}" required
                               class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition uppercase font-semibold">
                    </div>

                    <!-- No Peserta -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Peserta Ujian</label>
                        <input type="text" name="no_peserta" value="{{ old('no_peserta', $santri->no_peserta) }}"
                               class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition font-mono">
                    </div>

                    <!-- NISN -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">NISN (Nomor Induk Santri Nasional)</label>
                        <input type="text" name="nisn" value="{{ old('nisn', $santri->nisn) }}"
                               class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition font-mono">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin</label>
                        <div class="flex items-center gap-4 pt-1">
                            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                                <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', $santri->jenis_kelamin) === 'L' ? 'checked' : '' }} class="accent-blue-900 w-4 h-4">
                                <span><i class="fa-solid fa-mars text-sky-600"></i> Laki-laki</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                                <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin', $santri->jenis_kelamin) === 'P' ? 'checked' : '' }} class="accent-rose-600 w-4 h-4">
                                <span><i class="fa-solid fa-venus text-rose-500"></i> Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <!-- Tahun Database Sekolah -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tahun Angkatan / Database Sekolah</label>
                        <input type="text" name="tahun_munaqasyah" value="{{ old('tahun_munaqasyah', $santri->tahun_munaqasyah ?? '2026') }}"
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
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $santri->tempat_lahir) }}"
                           class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $santri->tanggal_lahir) }}"
                           class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition">
                </div>

                <!-- Nama Unit / Lembaga -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Nama Lembaga / Unit <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_unit" id="nama_unit" value="{{ old('nama_unit', $santri->nama_unit) }}" list="unitList" required
                           class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition uppercase font-semibold">
                    <datalist id="unitList">
                        @foreach($units as $u)
                            <option value="{{ $u->nama_unit }}">{{ $u->nama_unit }} ({{ $u->jenis }})</option>
                        @endforeach
                    </datalist>
                </div>

                <!-- No Unit -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Unit Lembaga</label>
                    <input type="text" name="no_unit" value="{{ old('no_unit', $santri->no_unit) }}"
                           class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition font-mono">
                </div>
            </div>
        </div>

        <!-- CARD 3: ORANG TUA / WALI & STATUS -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-900 flex items-center justify-center text-xs font-black">3</span>
                    Informasi Orang Tua, Status &amp; Catatan
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nama Wali -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Orang Tua / Wali Santri</label>
                    <input type="text" name="nama_wali" value="{{ old('nama_wali', $santri->nama_wali) }}"
                           class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition uppercase">
                </div>

                <!-- Status Kelulusan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Kelulusan</label>
                    <select name="status_kelulusan" class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition font-bold">
                        <option value="PENDING" {{ old('status_kelulusan', $santri->status_kelulusan) === 'PENDING' ? 'selected' : '' }}>🟡 PENDING (Menunggu Hasil)</option>
                        <option value="LULUS" {{ old('status_kelulusan', $santri->status_kelulusan) === 'LULUS' ? 'selected' : '' }}>🟢 LULUS</option>
                        <option value="TIDAK LULUS" {{ old('status_kelulusan', $santri->status_kelulusan) === 'TIDAK LULUS' ? 'selected' : '' }}>🔴 TIDAK LULUS</option>
                    </select>
                </div>

                <!-- Keterangan Tambahan -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan Tambahan (Opsional)</label>
                    <input type="text" name="keterangan" value="{{ old('keterangan', $santri->keterangan) }}" placeholder="Catatan khusus berkas atau status ujian santri"
                           class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white focus:outline-none transition">
                </div>
            </div>
        </div>

        <!-- TOMBOL AKSI SIMPAN -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3">
            <a href="{{ route('santri.show', $santri->id) }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition">
                <i class="fa-solid fa-xmark mr-1"></i> Batalkan Perubahan
            </a>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                <button type="submit"
                        class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-blue-950 to-blue-900 hover:from-slate-900 hover:to-blue-950 text-white text-xs font-bold rounded-xl transition shadow-md flex items-center justify-center gap-2 active:scale-95">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Simpan Perubahan Biodata</span>
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
