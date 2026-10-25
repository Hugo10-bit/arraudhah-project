<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin-Only Middleware (Role-Based Access Control)
 * Hanya mengizinkan pengguna dengan role 'Administrator' mengakses
 * rute-rute sensitif seperti manajemen user, pengaturan, dan backup.
 */
class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (!session('logged_in')) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login terlebih dahulu.');
        }

        $userId = session('user_id');

        // Jika tidak ada user_id di session (misal: login via .env fallback lama)
        // tetap izinkan agar sistem tidak terkunci jika hanya ada 1 admin
        if (!$userId) {
            // Fallback: hanya izinkan jika session mengandung flag admin
            if (session('is_admin')) {
                return $next($request);
            }
            return $this->denyAccess($request);
        }

        // Ambil role dari database
        $user = \App\Models\User::find($userId);

        if (!$user || $user->role !== 'Administrator') {
            return $this->denyAccess($request);
        }

        return $next($request);
    }

    /**
     * Tolak akses dengan response yang sesuai
     */
    protected function denyAccess(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akses ditolak. Hanya Administrator yang diizinkan mengakses fitur ini.',
            ], 403);
        }

        return redirect()->route('dashboard')
            ->with('error', '🚫 Akses Ditolak: Hanya Administrator yang diizinkan mengakses halaman ini.');
    }
}
