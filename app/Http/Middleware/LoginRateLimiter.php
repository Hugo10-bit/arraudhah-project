<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Login Rate Limiter Middleware
 * Melindungi endpoint login dari serangan brute-force.
 * Maksimal 5 percobaan gagal per IP per 15 menit.
 */
class LoginRateLimiter
{
    /** Maksimal percobaan login gagal sebelum dikunci */
    protected int $maxAttempts = 5;

    /** Durasi kunci dalam menit */
    protected int $decayMinutes = 15;

    public function handle(Request $request, Closure $next): Response
    {
        // Hanya proses pada POST request login
        if ($request->isMethod('POST')) {
            $key = $this->throttleKey($request);

            // Cek apakah IP sudah terkunci
            if ($this->isLocked($key)) {
                $seconds = $this->lockoutSeconds($key);
                $minutes = ceil($seconds / 60);

                return back()
                    ->withInput($request->only('username'))
                    ->with('error', "🔒 Terlalu banyak percobaan login. Akses dikunci selama <strong>{$minutes} menit</strong> lagi. Silakan coba lagi setelah jeda tersebut.")
                    ->with('is_locked', true)
                    ->with('lockout_seconds', $seconds);
            }
        }

        $response = $next($request);

        // Jika login GAGAL (redirect back dengan error), tambah hitungan
        if ($request->isMethod('POST')) {
            $hasError = session()->has('error');
            $isSuccess = session()->has('logged_in') || session()->has('success');

            if ($hasError && !$isSuccess) {
                $key = $this->throttleKey($request);
                $attempts = $this->incrementAttempts($key);
                $remaining = max(0, $this->maxAttempts - $attempts);
                
                if ($remaining > 0) {
                    session()->flash('remaining_attempts', $remaining);
                }
            } elseif ($isSuccess) {
                $key = $this->throttleKey($request);
                $this->clearAttempts($key);
            }
        }

        return $response;
    }

    /**
     * Buat cache key unik berdasarkan IP + nama route
     */
    protected function throttleKey(Request $request): string
    {
        return 'login_attempts_' . sha1($request->ip());
    }

    /**
     * Cek apakah IP sudah dalam status lockout
     */
    protected function isLocked(string $key): bool
    {
        return Cache::has($key . '_locked');
    }

    /**
     * Dapatkan sisa detik kunci
     */
    protected function lockoutSeconds(string $key): int
    {
        return max(0, (int) Cache::get($key . '_locked', 0) - time());
    }

    /**
     * Tambah hitungan percobaan gagal
     */
    protected function incrementAttempts(string $key): int
    {
        $attempts = (int) Cache::get($key, 0) + 1;
        Cache::put($key, $attempts, now()->addMinutes($this->decayMinutes));

        if ($attempts >= $this->maxAttempts) {
            // Set lockout timestamp
            Cache::put($key . '_locked', time() + ($this->decayMinutes * 60), now()->addMinutes($this->decayMinutes));
        }

        return $attempts;
    }

    /**
     * Reset semua counter setelah login berhasil
     */
    protected function clearAttempts(string $key): void
    {
        Cache::forget($key);
        Cache::forget($key . '_locked');
    }
}
