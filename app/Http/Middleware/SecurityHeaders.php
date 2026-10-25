<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Security Headers Middleware
 * Menambahkan HTTP Security Headers standar industri pada setiap response
 * untuk mencegah XSS, clickjacking, MIME-sniffing, dan serangan lainnya.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya tambahkan header pada HTML response (bukan JSON/file download)
        $contentType = $response->headers->get('Content-Type', '');
        $isHtml = str_contains($contentType, 'text/html') || empty($contentType);

        // Anti-Clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Anti MIME-Type Sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // XSS Filter
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Content Security Policy (CSP)
        // Izinkan CDN Tailwind, FontAwesome, Google Fonts, Chart.js, QR code libs
        if ($isHtml) {
            $csp = implode('; ', [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://cdn.chart.js",
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.tailwindcss.com",
                "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com data:",
                "img-src 'self' data: https://ui-avatars.com https://api.qrserver.com https://*.wikipedia.org storage.googleapis.com",
                "connect-src 'self' https://id.wikipedia.org https://equran.id https://api.aladhan.com https://generativelanguage.googleapis.com https://*.ngrok-free.app https://*.ngrok.io https://*.trycloudflare.com https://*.onrender.com",
                "media-src 'self' https://cdn.equran.id",
                "frame-ancestors 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "object-src 'none'",
            ]);
            $response->headers->set('Content-Security-Policy', $csp);
        }

        // Permissions Policy
        $response->headers->set('Permissions-Policy', 'camera=(), payment=(), usb=(), geolocation=()');

        // HSTS (Strict Transport Security) aktifkan jika menggunakan HTTPS
        // $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // Remove Server Information
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
