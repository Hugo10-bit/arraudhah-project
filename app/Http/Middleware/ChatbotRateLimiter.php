<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Chatbot Rate Limiter Middleware
 * Membatasi request ke endpoint chatbot maksimal 20 kali per menit per IP
 * untuk mencegah penyalahgunaan (abuse/spam) pada API chatbot publik.
 */
class ChatbotRateLimiter
{
    /** Maksimal request per jendela waktu */
    protected int $maxRequests = 20;

    /** Jendela waktu dalam detik */
    protected int $decaySeconds = 60;

    public function handle(Request $request, Closure $next): Response
    {
        $key = 'chatbot_rate_' . sha1($request->ip());
        $requests = (int) Cache::get($key, 0);

        if ($requests >= $this->maxRequests) {
            $ttl = Cache::getStore() instanceof \Illuminate\Cache\FileStore
                ? $this->decaySeconds
                : Cache::getMultiple([$key]); // fallback

            return response()->json([
                'status' => 'error',
                'source' => 'rate_limit',
                'reply'  => "
                    <div class='space-y-1.5 text-xs text-slate-700'>
                        <p class='font-bold text-rose-900'>⏳ Terlalu Banyak Pertanyaan!</p>
                        <p>Anda telah mengirim terlalu banyak pesan dalam waktu singkat. Mohon tunggu <strong>1 menit</strong> sebelum bertanya kembali.</p>
                        <p class='text-[10px] text-slate-500'>Batas: {$this->maxRequests} pertanyaan per menit per perangkat.</p>
                    </div>
                ",
            ], 429, [
                'Retry-After'           => $this->decaySeconds,
                'X-RateLimit-Limit'     => $this->maxRequests,
                'X-RateLimit-Remaining' => 0,
            ]);
        }

        // Tambah counter dengan TTL jendela waktu
        if ($requests === 0) {
            Cache::put($key, 1, now()->addSeconds($this->decaySeconds));
        } else {
            Cache::increment($key);
        }

        $response = $next($request);

        // Tambahkan header info rate limit pada response sukses
        $remaining = max(0, $this->maxRequests - $requests - 1);
        $response->headers->set('X-RateLimit-Limit', $this->maxRequests);
        $response->headers->set('X-RateLimit-Remaining', $remaining);

        return $response;
    }
}
