@extends('layouts.sidebar')

@section('title', 'Edit User | Yayasan Cahaya Amanah Ar-Raudhah')

@section('breadcrumb')
    <a href="{{ route('users.index') }}" class="hover:text-blue-900 font-semibold text-slate-500">Kelola Pengguna</a>
    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
    <span class="font-semibold text-slate-800">Edit: {{ $user->name }}</span>
@endsection

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header Card -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl shrink-0 border border-blue-100">
                <i class="fa-solid fa-user-pen"></i>
            </div>
            <div>
                <h1 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">Edit Data Pengguna</h1>
                <p class="text-xs text-slate-500 mt-0.5">Memperbarui akun: <strong class="text-slate-800">{{ $user->name }}</strong> (@<span>{{ $user->username }}</span>)</p>
            </div>
        </div>
        <a href="{{ route('users.index') }}"
           class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition flex items-center gap-1.5 shrink-0">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs">
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

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
                           value="{{ old('name', $user->name) }}"
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
                               value="{{ old('username', $user->username) }}"
                               autocomplete="off"
                               class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm font-mono border @error('username') border-red-500 ring-2 ring-red-200 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition"
                               required>
                    </div>
                    @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
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
                               value="{{ old('email', $user->email) }}"
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
                            <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>
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

            <!-- Ganti Password (Opsional) -->
            <div class="pt-4 border-t border-slate-100 space-y-4">
                <div class="bg-amber-50/70 border border-amber-200/80 rounded-2xl p-3.5 flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-info text-amber-600 mt-0.5 shrink-0 text-sm"></i>
                    <p class="text-xs text-amber-900 leading-relaxed">
                        <strong>Ganti Password:</strong> Biarkan kedua kolom password di bawah ini <strong>kosong</strong> jika Anda tidak ingin mengubah password akun ini.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Password Baru -->
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Password Baru (Opsional)
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-key absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   placeholder="Kosongkan jika tidak diganti"
                                   class="w-full pl-9 pr-10 py-2.5 rounded-xl text-sm border @error('password') border-red-500 ring-2 ring-red-200 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition">
                            <button type="button" onclick="togglePass('password', 'eye1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <i class="fa-solid fa-eye text-xs" id="eye1"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Ulangi Password Baru
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-shield-halved absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   placeholder="Ulangi password baru"
                                   class="w-full pl-9 pr-10 py-2.5 rounded-xl text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition">
                            <button type="button" onclick="togglePass('password_confirmation', 'eye2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <i class="fa-solid fa-eye text-xs" id="eye2"></i>
                            </button>
                        </div>
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
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
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
