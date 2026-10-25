<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

/**
 * Controller autentikasi panitia dan penguji.
 */
class AuthController extends Controller
{
    public function showLogin()
    {
        // Jika sudah login, langsung ke dashboard
        if (session('logged_in')) {
            return redirect()->route('dashboard');
        }
        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-cache, private, no-store, must-revalidate, max-stale=0, post-check=0, pre-check=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:100',
            'password' => 'required|string|max:200',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');
        $ip       = $request->ip();

        // Autentikasi dari database
        $user = User::where('username', $username)
                    ->orWhere('email', $username)
                    ->first();

        if ($user && Hash::check($password, $user->password)) {

            // Regenerate session ID untuk mencegah session fixation
            Session::regenerate();

            session([
                'logged_in'   => true,
                'user_id'     => $user->id,
                'user_name'   => $user->name ?? $user->username,
                'user_role'   => $user->role,
                'login_ip'    => $ip,
                'login_at'    => now()->toDateTimeString(),
            ]);

            // Perpanjang lifetime session jika user centang "ingat saya"
            if ($request->boolean('remember')) {
                config(['session.lifetime' => 60 * 24 * 7]); // 7 hari
            }

            // Audit log login berhasil
            Log::info("LOGIN BERHASIL: user={$user->username} role={$user->role} ip={$ip}");

            return redirect()->route('dashboard')
                ->with('success', 'Selamat datang, ' . ($user->name ?? $user->username) . '!');
        }

        // Audit log percobaan login gagal
        Log::warning("LOGIN GAGAL: username={$username} ip={$ip}");

        return back()
            ->withInput($request->only('username'))
            ->with('error', 'Username atau password salah. Silakan coba lagi.');
    }

    public function logout(Request $request)
    {
        $userName = session('user_name', 'unknown');
        $ip       = $request->ip();

        // Audit log logout
        Log::info("LOGOUT: user={$userName} ip={$ip}");

        // Flush dan invalidate seluruh session serta regenerate token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar dari sistem.')
            ->withHeaders([
                'Cache-Control' => 'no-cache, private, no-store, must-revalidate, max-stale=0, post-check=0, pre-check=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sun, 02 Jan 1990 00:00:00 GMT',
            ]);
    }
}
