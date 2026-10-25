@extends('layouts.sidebar')

@section('title', 'Kelola Pengguna | Yayasan Cahaya Amanah Ar-Raudhah')

@section('breadcrumb')
    <a href="{{ route('users.index') }}" class="hover:text-blue-900 font-semibold text-slate-700">Kelola Pengguna</a>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                <span class="text-xs font-bold uppercase tracking-wider text-blue-700">Manajemen Akun</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Data Pengguna Sistem</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola akun administrator, penguji TPQ/RTQ, dan panitia database_sekolah.</p>
        </div>
        <a href="{{ route('users.create') }}"
           class="inline-flex items-center gap-2 px-4 sm:px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-xs transition shrink-0">
            <i class="fa-solid fa-user-plus text-sm"></i>
            Tambah User Baru
        </a>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
        <!-- Total -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total User</p>
                <p class="text-lg sm:text-xl font-black text-slate-900">{{ $stats['total'] }}</p>
            </div>
        </div>

        <!-- Administrator -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-lg shrink-0 border border-slate-200">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Administrator</p>
                <p class="text-lg sm:text-xl font-black text-slate-800">{{ $stats['admin'] }}</p>
            </div>
        </div>

        <!-- Penguji TPQ -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white p-1 flex items-center justify-center shrink-0 border border-blue-100 shadow-xs overflow-hidden">
                <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ" class="w-full h-full object-contain">
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Penguji TPQ</p>
                <p class="text-lg sm:text-xl font-black text-blue-800">{{ $stats['penguji_tpq'] }}</p>
            </div>
        </div>

        <!-- Penguji RTQ -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white p-1 flex items-center justify-center shrink-0 border border-amber-100 shadow-xs overflow-hidden">
                <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ" class="w-full h-full object-contain">
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Penguji RTQ</p>
                <p class="text-lg sm:text-xl font-black text-amber-700">{{ $stats['penguji_rtq'] }}</p>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <!-- Search -->
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Cari nama, username, atau email user..."
                       class="w-full pl-9 pr-4 py-2.5 rounded-xl text-xs sm:text-sm border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition">
            </div>

            <!-- Role Filter -->
            <div class="w-full sm:w-56">
                <select name="role"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2.5 rounded-xl text-xs sm:text-sm border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-blue-600/30 focus:border-blue-600 transition">
                    <option value="">Semua Peran / Role</option>
                    <option value="Administrator" {{ $roleFilter == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                    <option value="Penguji TPQ" {{ $roleFilter == 'Penguji TPQ' ? 'selected' : '' }}>Penguji TPQ</option>
                    <option value="Penguji RTQ" {{ $roleFilter == 'Penguji RTQ' ? 'selected' : '' }}>Penguji RTQ</option>
                    <option value="Panitia" {{ $roleFilter == 'Panitia' ? 'selected' : '' }}>Panitia</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit"
                        class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 transition flex items-center justify-center gap-2 shrink-0">
                    <i class="fa-solid fa-filter text-xs"></i> Filter
                </button>
                @if($search || $roleFilter)
                <a href="{{ route('users.index') }}"
                   class="px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-500 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 transition shrink-0"
                   title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table (Desktop) & Cards (Mobile) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white text-xs uppercase tracking-wider font-bold">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Nama Lengkap &amp; Email</th>
                        <th class="py-3.5 px-4">Username</th>
                        <th class="py-3.5 px-4">Role / Peran</th>
                        <th class="py-3.5 px-4">Terdaftar</th>
                        <th class="py-3.5 px-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $index => $user)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-4 text-center text-xs font-semibold text-slate-400">
                            {{ $users->firstItem() + $index }}
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 leading-tight">
                                        {{ $user->name }}
                                        @if(session('user_id') == $user->id)
                                        <span class="ml-1.5 px-2 py-0.5 rounded-md text-[9px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">Anda</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                <i class="fa-solid fa-at text-[10px] text-slate-400"></i>
                                {{ $user->username ?? '-' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            @if($user->role === 'Administrator')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                    <i class="fa-solid fa-shield-halved text-[10px]"></i> Administrator
                                </span>
                            @elseif($user->role === 'Penguji TPQ')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                    <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ" class="w-3.5 h-3.5 object-contain"> Penguji TPQ
                                </span>
                            @elseif($user->role === 'Penguji RTQ')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ" class="w-3.5 h-3.5 object-contain"> Penguji RTQ
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200">
                                    <i class="fa-solid fa-user-gear text-[10px]"></i> {{ $user->role ?? 'Panitia' }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-xs text-slate-500 font-medium">
                            {{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="p-2 rounded-lg text-blue-700 hover:bg-blue-50 transition"
                                   title="Edit Data User">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                @if(session('user_id') != $user->id)
                                <button type="button"
                                        onclick="confirmDeleteUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->username) }}')"
                                        class="p-2 rounded-lg text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                                        title="Hapus User">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                @else
                                <span class="p-2 text-slate-300 cursor-not-allowed" title="Tidak dapat menghapus akun sendiri">
                                    <i class="fa-solid fa-trash-can"></i>
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-user-slash text-4xl text-slate-300 mb-3 block"></i>
                            <p class="font-bold text-slate-600">Tidak ada user ditemukan</p>
                            <p class="text-xs mt-1">Coba gunakan kata kunci pencarian atau filter yang lain.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden divide-y divide-slate-100">
            @forelse($users as $user)
            <div class="p-4 space-y-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">
                                {{ $user->name }}
                                @if(session('user_id') == $user->id)
                                <span class="ml-1 px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-100 text-emerald-700">Anda</span>
                                @endif
                            </p>
                            <p class="text-xs text-slate-400 font-mono">@<span>{{ $user->username ?? '-' }}</span></p>
                        </div>
                    </div>
                    <div>
                        @if($user->role === 'Administrator')
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">Admin</span>
                        @elseif($user->role === 'Penguji TPQ')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ" class="w-3 h-3 object-contain"> TPQ
                            </span>
                        @elseif($user->role === 'Penguji RTQ')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ" class="w-3 h-3 object-contain"> RTQ
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-teal-50 text-teal-700 border border-teal-200">Panitia</span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-400 pt-1">
                    <span class="truncate max-w-[200px]">{{ $user->email }}</span>
                    <span>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</span>
                </div>

                <div class="flex items-center gap-2 pt-1 border-t border-slate-50">
                    <a href="{{ route('users.edit', $user->id) }}"
                       class="flex-1 py-2 rounded-xl text-xs font-bold text-center text-blue-700 bg-blue-50 hover:bg-blue-100 transition flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    @if(session('user_id') != $user->id)
                    <button type="button"
                            onclick="confirmDeleteUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->username) }}')"
                            class="flex-1 py-2 rounded-xl text-xs font-bold text-center text-rose-600 bg-rose-50 hover:bg-rose-100 transition flex items-center justify-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-trash-can"></i> Hapus
                    </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="py-10 text-center text-slate-400">
                <p class="font-bold">Tidak ada data user</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Hapus User -->
<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200 p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-7 max-w-sm w-full shadow-2xl border border-slate-200 transform scale-95 transition-transform duration-200" id="deleteModalCard">
        <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mx-auto mb-4 border border-rose-100">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="text-center mb-6">
            <h3 class="text-lg font-black text-slate-800">Hapus Pengguna?</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                Anda yakin ingin menghapus akun <span class="font-bold text-slate-800" id="deleteUserName"></span> (<span class="font-mono text-slate-700" id="deleteUserUsername"></span>)?
            </p>
            <p class="text-[11px] text-rose-500 font-semibold mt-2">Aksi ini tidak dapat dibatalkan.</p>
        </div>
        <form id="deleteUserForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-md transition">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function confirmDeleteUser(id, name, username) {
        const form = document.getElementById('deleteUserForm');
        form.action = "{{ url('users') }}/" + id;
        document.getElementById('deleteUserName').textContent = name;
        document.getElementById('deleteUserUsername').textContent = '@' + username;

        const modal = document.getElementById('deleteModal');
        const card = document.getElementById('deleteModalCard');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        card.classList.remove('scale-95');
        card.classList.add('scale-100');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const card = document.getElementById('deleteModalCard');
        modal.classList.add('opacity-0', 'pointer-events-none');
        card.classList.add('scale-95');
        card.classList.remove('scale-100');
    }
</script>
@endsection
