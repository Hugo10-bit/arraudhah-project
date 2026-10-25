@extends('layouts.sidebar')

@section('title', 'Tambah User Baru | Yayasan Cahaya Amanah Ar-Raudhah')

@section('breadcrumb')
    <a href="{{ route('users.index') }}" class="hover:text-blue-900 font-semibold text-slate-500">Kelola Pengguna</a>
    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
    <span class="font-semibold text-slate-800">Tambah User</span>
@endsection

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header Card -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0 border border-blue-100">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <div>
                <h1 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">Tambah Pengguna Baru</h1>
                <p class="text-xs text-slate-500 mt-0.5">Daftarkan akun administrator, penguji, atau panitia database_sekolah.</p>
            </div>
        </div>
        <a href="{{ route('users.index') }}"
           class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition flex items-center gap-1.5 shrink-0">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <i class="fa-solid fa-id-card absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name') }}"
                           placeholder="Contoh: Ustadz Muhammad Syauqi"
                           class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm border @error('name') border-red-500 ring-2 ring-red-200 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition"
                           required>
                </div>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username & Email (Grid) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Username -->
                <div>
                    <label for="username" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-at absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text"
                               name="username"
                               id="username"
                               value="{{ old('username') }}"
                               placeholder="Contoh: ustadz_syauqi"
                               autocomplete="off"
                               class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm font-mono border @error('username') border-red-500 ring-2 ring-red-200 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition"
                               required>
                    </div>
                    @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @else
                        <p class="text-[11px] text-slate-400 mt-1">Digunakan untuk login ke sistem.</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               placeholder="Contoh: syauqi@arraudhah.id"
                               class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm border @error('email') border-red-500 ring-2 ring-red-200 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition"
                               required>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Role / Peran -->
            <div>
                <label for="role" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Peran / Role Pengguna <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="role"
                            id="role"
                            class="w-full px-4 py-2.5 rounded-xl text-sm border @error('role') border-red-500 ring-2 ring-red-200 @else border-slate-200 @enderror bg-white focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition"
                            required>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                {{ $role }}
                                @if($role === 'Administrator') (Akses Penuh Seluruh Menu)
                                @elseif($role === 'Penguji TPQ') (Fokus Penilaian TPQ Ar-Raudhah)
                                @elseif($role === 'Penguji RTQ') (Fokus Penilaian RTQ Ar-Raudhah)
                                @else (Input Data &amp; Rekapitulasi Nilai)
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password & Konfirmasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="password"
                               name="password"
                               id="password"
                               placeholder="Minimal 6 karakter"
                               class="w-full pl-9 pr-10 py-2.5 rounded-xl text-sm border @error('password') border-red-500 ring-2 ring-red-200 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition"
                               required>
                        <button type="button" onclick="togglePass('password', 'eye1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-eye text-xs" id="eye1"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Ulangi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-shield-halved absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               placeholder="Ketik ulang password"
                               class="w-full pl-9 pr-10 py-2.5 rounded-xl text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition"
                               required>
                        <button type="button" onclick="togglePass('password_confirmation', 'eye2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-eye text-xs" id="eye2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('users.index') }}"
                   class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endsection
