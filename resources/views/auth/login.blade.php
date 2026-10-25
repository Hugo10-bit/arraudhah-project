<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Panitia | Database Sekolah Ar-Raudhah</title>
    <meta name="description" content="Halaman login panitia dan penguji database sekolah Yayasan Cahaya Amanah Ar-Raudhah Banjarbaru.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            width: 100%;
            height: 100%;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #081026;
            color: #0f172a;
            overflow-x: hidden;
        }

        /* ===== FULLSCREEN LAYOUT WRAPPER ===== */
        .login-screen {
            display: flex;
            width: 100vw;
            min-height: 100vh;
            height: 100vh;
            overflow: hidden;
            background: #ffffff;
        }

        /* ===== LEFT BRANDING PANEL (FULL HEIGHT HERO) ===== */
        .login-left {
            flex: 1.15;
            background: linear-gradient(145deg, #081026 0%, #0d1733 50%, #11224d 100%);
            padding: 56px 64px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            color: #ffffff;
        }

        /* Islamic Lattice Geometry Pattern */
        .login-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.035' fill-rule='evenodd'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 1;
        }

        .left-content-wrapper {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Brand Header */
        .brand-header {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand-logo-card {
            width: 52px;
            height: 52px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 16px;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease;
        }
        .brand-logo-card:hover { transform: scale(1.05); }
        .brand-logo-card img { width: 100%; height: 100%; object-fit: contain; }

        .brand-title-group h2 {
            font-size: 1.15rem;
            font-weight: 900;
            letter-spacing: 0.04em;
            color: #ffffff;
            line-height: 1.2;
        }

        .brand-title-group p {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 500;
            margin-top: 2px;
        }

        /* Main Center Message */
        .left-main-body {
            max-width: 540px;
            padding: 32px 0;
        }

        .arabic-shimmer {
            font-family: 'Amiri', serif;
            font-size: 2.1rem;
            line-height: 1.8;
            background: linear-gradient(90deg, #fef08a, #f59e0b, #fbbf24, #fef08a);
            background-size: 250% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 18px;
            display: block;
        }

        .left-main-body h1 {
            font-size: 2.5rem;
            font-weight: 900;
            line-height: 1.15;
            color: #ffffff;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
        }

        .left-main-body h1 span {
            color: #60a5fa;
            display: block;
        }

        .left-main-body p {
            font-size: 0.95rem;
            line-height: 1.65;
            color: #cbd5e1;
            margin-bottom: 28px;
        }

        /* Feature Bullets Card */
        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 10px 16px;
            border-radius: 14px;
            font-size: 12.5px;
            font-weight: 600;
            color: #e2e8f0;
            width: fit-content;
        }

        .feature-item i {
            color: #fbbf24;
            font-size: 13px;
        }

        /* Units & Footer */
        .left-footer {
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .unit-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            margin-right: 10px;
            transition: all 0.2s ease;
        }
        .unit-pill:hover {
            background: rgba(255, 255, 255, 0.14);
            transform: translateY(-1px);
        }

        .copyright-text {
            color: #64748b;
            font-size: 11.5px;
            font-weight: 500;
        }

        /* ===== RIGHT FORM PANEL (FULL HEIGHT FORM) ===== */
        .login-right {
            flex: 0.95;
            min-width: 440px;
            max-width: 580px;
            background: #ffffff;
            padding: 56px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100vh;
            overflow-y: auto;
            position: relative;
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.06);
            z-index: 3;
        }

        .form-container {
            max-width: 420px;
            width: 100%;
            margin: auto;
        }

        .right-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 14px;
            border-radius: 9999px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 16px;
        }

        .right-header h3 {
            font-size: 1.85rem;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .right-header p {
            font-size: 13.5px;
            color: #64748b;
            margin-top: 6px;
            margin-bottom: 28px;
        }

        /* Alerts */
        .alert {
            border-radius: 14px;
            padding: 12px 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 13px;
            line-height: 1.5;
        }
        .alert-ok {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }
        .alert-err {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        .alert-lock {
            background: #fef2f2;
            border: 1.5px solid #fca5a5;
            border-radius: 16px;
            padding: 22px;
            text-align: center;
            margin-bottom: 22px;
        }

        /* Inputs & Form Fields */
        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11.5px;
            font-weight: 800;
            color: #334155;
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .input-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
            transition: color 0.18s;
        }

        .input-box input {
            width: 100%;
            padding: 13px 16px 13px 44px;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            font-size: 14px;
            font-family: inherit;
            color: #0f172a;
            background: #f8fafc;
            outline: none;
            font-weight: 600;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-box input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .input-box input:focus {
            border-color: #2563eb;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
        }

        .input-box input:focus ~ .input-icon {
            color: #2563eb;
        }

        .input-box input.err {
            border-color: #f43f5e;
            background: #fff1f2;
            box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.15);
        }

        .pw-toggle {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            padding: 6px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.15s;
        }
        .pw-toggle:hover { color: #334155; }

        .field-alert {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 10px 14px;
            margin-top: 8px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .field-alert p {
            font-size: 12px;
            color: #b91c1c;
            line-height: 1.5;
            margin: 0;
            font-weight: 500;
        }

        .attempt-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 700;
            color: #92400e;
            margin-top: 6px;
        }

        /* Remember Me Row */
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            font-size: 13px;
            color: #475569;
            font-weight: 600;
            cursor: pointer;
            user-select: none;
        }

        .remember-label input {
            width: 17px;
            height: 17px;
            accent-color: #2563eb;
            cursor: pointer;
            border-radius: 4px;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 14px 20px;
            font-size: 14.5px;
            font-weight: 800;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 16px rgba(30, 58, 138, 0.28);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #172554 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(30, 58, 138, 0.36);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.65;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Footer Links */
        .login-footer-nav {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #f1f5f9;
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .login-footer-nav a {
            font-size: 12.5px;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: color 0.15s ease;
        }
        .login-footer-nav a:hover {
            color: #1d4ed8;
        }

        .security-badge {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* ===== RESPONSIVE BREAKPOINTS ===== */
        @media (max-width: 1024px) {
            .login-left {
                padding: 40px 48px;
            }
            .login-right {
                padding: 40px 48px;
                min-width: 380px;
            }
            .left-main-body h1 {
                font-size: 2.1rem;
            }
        }

        @media (max-width: 860px) {
            .login-screen {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
                overflow-y: auto;
            }
            .login-left {
                flex: none;
                width: 100%;
                min-height: auto;
                padding: 40px 24px;
            }
            .left-main-body h1 {
                font-size: 1.8rem;
            }
            .arabic-shimmer {
                font-size: 1.6rem;
            }
            .feature-list {
                display: none;
            }
            .login-right {
                flex: 1;
                width: 100%;
                max-width: 100%;
                min-width: 100%;
                height: auto;
                padding: 40px 24px 48px;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>

<div class="login-screen">

    <!-- ===== LEFT BRANDING PANEL (HERO) ===== -->
    <div class="login-left">
        <div class="left-content-wrapper">
            <!-- Brand Header -->
            <div class="brand-header">
                <a href="{{ route('landing') }}" class="brand-logo-card" title="Kembali ke Beranda">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Yayasan Ar-Raudhah">
                </a>
                <div class="brand-title-group">
                    <h2>AR-RAUDHAH</h2>
                    <p>Yayasan Cahaya Amanah · Banjarbaru</p>
                </div>
            </div>

            <!-- Hero Message -->
            <div class="left-main-body">
                <span class="arabic-shimmer">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</span>
                <h1>
                    Database Sekolah
                    <span>TPQ &amp; RTQ Ar-Raudhah</span>
                </h1>
                <p>
                    Portal resmi penginputan penilaian 9 mata uji, penerbitan sertifikat kelulusan, transkrip nilai terverifikasi, dan manajemen database santri Banjarbaru.
                </p>

                <div class="feature-list">
                    <div class="feature-item">
                        <i class="fa-solid fa-calculator"></i>
                        <span>Kalkulasi Otomatis Rata-rata &amp; Predikat Mumtaz</span>
                    </div>
                    <div class="feature-item">
                        <i class="fa-solid fa-qrcode"></i>
                        <span>Verifikasi QR Code &amp; Sertifikat Resmi Kelulusan</span>
                    </div>
                    <div class="feature-item">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Keamanan Berlapis Anti-Brute Force Protection</span>
                    </div>
                </div>
            </div>

            <!-- Footer & Unit Badges -->
            <div class="left-footer">
                <div>
                    <span class="unit-pill">
                        <img src="{{ asset('images/logo_tpq.png') }}" alt="Logo TPQ" style="width:18px;height:18px;object-fit:contain;">
                        <span>TPQ Ar-Raudhah</span>
                    </span>
                    <span class="unit-pill">
                        <img src="{{ asset('images/logo_rtq.png') }}" alt="Logo RTQ" style="width:18px;height:18px;object-fit:contain;">
                        <span>RTQ Ar-Raudhah</span>
                    </span>
                </div>
                <p class="copyright-text">
                    &copy; 2026 Yayasan Cahaya Amanah Ar-Raudhah • Banjarbaru
                </p>
            </div>
        </div>
    </div>

    <!-- ===== RIGHT FORM PANEL ===== -->
    <div class="login-right">
        <div class="form-container">

            <div class="right-header">
                <div class="right-badge">
                    <i class="fa-solid fa-lock"></i>
                    <span>Portal Khusus Panitia</span>
                </div>
                <h3>Selamat Datang</h3>
                <p>Masukkan username dan kata sandi akun panitia Anda.</p>
            </div>

            {{-- Flash Success Alert --}}
            @if(session('success'))
            <div class="alert alert-ok">
                <i class="fa-solid fa-circle-check" style="flex-shrink:0;margin-top:2px;"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            {{-- Rate Limiting Lockout Alert --}}
            @if(session('is_locked'))
            <div class="alert-lock">
                <div style="width:44px;height:44px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                    <i class="fa-solid fa-lock" style="color:#dc2626;font-size:18px;"></i>
                </div>
                <p style="font-weight:800;color:#991b1b;font-size:14px;margin-bottom:4px;">Akses Dikunci Sementara</p>
                <p style="color:#64748b;font-size:12.5px;margin-bottom:14px;">Terlalu banyak percobaan gagal. Silakan tunggu:</p>
                <div style="display:inline-block;padding:8px 24px;background:#fff;border:1.5px solid #fca5a5;border-radius:10px;font-family:monospace;font-size:1.35rem;font-weight:900;color:#dc2626;" id="countdownBox">
                    <span id="countdownTimer">--:--</span>
                </div>
            </div>
            @endif

            {{-- Form Validation Errors --}}
            @if($errors->any())
            <div class="alert alert-err">
                <i class="fa-solid fa-circle-exclamation" style="flex-shrink:0;margin-top:2px;"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                @csrf

                <!-- Username -->
                <div class="field">
                    <label for="username">Username</label>
                    <div class="input-box">
                        <i class="fa-solid fa-user input-icon"></i>
                        <input type="text" name="username" id="username" value="{{ old('username') }}"
                               placeholder="Masukkan username Anda" autocomplete="username" required autofocus>
                    </div>
                </div>

                <!-- Password -->
                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-box">
                        <i class="fa-solid fa-key input-icon"></i>
                        <input type="password" name="password" id="password"
                               placeholder="••••••••" autocomplete="current-password"
                               class="{{ session('error') && !session('is_locked') ? 'err' : '' }}" required>
                        <button type="button" class="pw-toggle" onclick="togglePass()" title="Tampilkan / Sembunyikan Password">
                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>

                    @if(session('error') && !session('is_locked'))
                    <div class="field-alert">
                        <i class="fa-solid fa-triangle-exclamation" style="color:#f43f5e;flex-shrink:0;margin-top:2px;font-size:13px;"></i>
                        <div>
                            <p>{!! session('error') !!}</p>
                            @if(session('remaining_attempts'))
                            <div class="attempt-badge">
                                <i class="fa-solid fa-shield-halved"></i>
                                <span>Tersisa {{ session('remaining_attempts') }}x kesempatan percobaan</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="remember-row">
                    <label class="remember-label" for="remember">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Ingat saya selama 7 hari</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="loginBtn" class="btn-submit">
                    <i class="fa-solid fa-right-to-bracket" id="loginIcon"></i>
                    <span id="loginText">Masuk ke Sistem</span>
                </button>
            </form>

            <!-- Bottom Navigation -->
            <div class="login-footer-nav">
                <a href="{{ route('landing') }}">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

        </div>
    </div>

</div>

<script>
    function togglePass() {
        const p = document.getElementById('password');
        const i = document.getElementById('eyeIcon');
        if (!p || !i) return;
        p.type = p.type === 'password' ? 'text' : 'password';
        i.className = p.type === 'text' ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
    }

    document.getElementById('loginForm').addEventListener('submit', function() {
        const btn = document.getElementById('loginBtn');
        const text = document.getElementById('loginText');
        const icon = document.getElementById('loginIcon');
        if (text) text.textContent = 'Memverifikasi...';
        if (icon) icon.className = 'fa-solid fa-circle-notch fa-spin';
        if (btn) btn.disabled = true;
    });

    @if(session('is_locked'))
    (function() {
        let s = {{ (int) session('lockout_seconds', 900) }};
        const d = document.getElementById('countdownTimer');
        const btn = document.getElementById('loginBtn');
        const u = document.getElementById('username');
        const p = document.getElementById('password');
        if (btn) { btn.disabled = true; document.getElementById('loginText').textContent = 'Terkunci'; }
        if (u) u.disabled = true;
        if (p) p.disabled = true;
        function tick() {
            if (s <= 0) {
                if (d) d.textContent = 'Silakan Refresh';
                if (btn) { btn.disabled = false; document.getElementById('loginText').textContent = 'Coba Lagi'; }
                if (u) u.disabled = false;
                if (p) p.disabled = false;
                return;
            }
            const m = Math.floor(s/60), sec = s%60;
            if (d) d.textContent = `${String(m).padStart(2,'0')}:${String(sec).padStart(2,'0')}`;
            s--; setTimeout(tick, 1000);
        }
        tick();
    })();
    @endif
</script>
</body>
</html>
