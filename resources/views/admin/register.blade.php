<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin — Biara Loresa SCJ</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Georgia:ital@0;1&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            position: relative;
            overflow: hidden;
        }

        .bg-hero {
            position: fixed;
            inset: 0;
            z-index: 0;
        }
        .bg-hero img {
            width: 100%; height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .bg-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(30,38,133,0.92) 0%, rgba(61,86,245,0.72) 100%);
        }

        .page-wrap {
            position: relative;
            z-index: 1;
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* ─── Left branding panel ─── */
        .left-panel {
            flex: 1;
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 48px;
            text-align: center;
        }
        @media (min-width: 900px) {
            .left-panel { display: flex; }
        }
        .left-panel .cross-icon {
            width: 80px; height: 80px;
            background: rgba(255,255,255,0.18);
            backdrop-filter: blur(8px);
            border: 2px solid rgba(255,255,255,0.4);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 28px;
        }
        .left-panel .cross-icon svg { width: 40px; height: 40px; color: #fff; }
        .left-panel .eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #f0c14b;
            margin-bottom: 14px;
        }
        .left-panel h1 {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 48px;
            font-weight: 700;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 8px;
        }
        .left-panel h1 span { color: #f0c14b; }
        .left-panel .tagline {
            font-size: 15px;
            color: rgba(255,255,255,0.75);
            line-height: 1.6;
            max-width: 320px;
            margin: 0 auto 40px;
        }
        .left-panel .divider {
            width: 60px; height: 2px;
            background: linear-gradient(90deg, transparent, #f0c14b, transparent);
            margin: 0 auto 32px;
        }
        .left-panel .quote {
            font-size: 14px;
            color: rgba(255,255,255,0.6);
            font-style: italic;
            max-width: 300px;
        }
        .left-panel .quote strong {
            display: block;
            font-style: normal;
            font-size: 12px;
            color: rgba(255,255,255,0.45);
            margin-top: 8px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* ─── Right form panel ─── */
        .right-panel {
            width: 100%;
            max-width: 480px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 44px;
            min-height: 100vh;
            position: relative;
        }
        @media (max-width: 899px) {
            .right-panel {
                max-width: 100%;
                background: rgba(255,255,255,0.96);
                backdrop-filter: blur(16px);
                padding: 40px 28px;
            }
        }
        @media (max-width: 480px) {
            .right-panel { padding: 36px 20px; }
        }

        /* Mobile brand */
        .mobile-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
        }
        @media (min-width: 900px) { .mobile-brand { display: none; } }
        .mobile-brand .icon {
            width: 42px; height: 42px;
            background: #1e2685;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .mobile-brand .icon svg { width: 22px; height: 22px; color: #fff; }
        .mobile-brand .name { font-weight: 700; font-size: 15px; color: #1e2685; }
        .mobile-brand .sub  { font-size: 11px; color: #d4a017; font-weight: 600; letter-spacing: 2px; }

        /* Form heading */
        .form-heading h2 {
            font-size: 24px;
            font-weight: 800;
            color: #1e2685;
            margin-bottom: 6px;
        }
        .form-heading p {
            font-size: 13.5px;
            color: #64748b;
            margin-bottom: 28px;
        }

        /* Alert */
        .alert {
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
        }
        .alert svg { flex-shrink: 0; width: 16px; height: 16px; margin-top: 1px; }

        /* Form */
        .form-group { margin-bottom: 18px; }
        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
        }
        .input-wrap { position: relative; }
        .input-wrap .input-icon {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            width: 17px; height: 17px;
            pointer-events: none;
        }
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            color: #1e293b;
            font-size: 14.5px;
            font-family: 'Inter', sans-serif;
            padding: 11px 13px 11px 42px;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        input::placeholder { color: #cbd5e1; }
        input:focus {
            border-color: #1e2685;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(30,38,133,0.1);
        }
        input.is-invalid {
            border-color: #f87171;
            box-shadow: 0 0 0 3px rgba(248,113,113,0.1);
        }
        .field-error {
            font-size: 12.5px;
            color: #dc2626;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Password toggle */
        .eye-btn {
            position: absolute;
            right: 13px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer; color: #94a3b8;
            padding: 4px; transition: color 0.2s;
        }
        .eye-btn:hover { color: #1e2685; }
        .eye-btn svg { width: 17px; height: 17px; }
        input.has-eye { padding-right: 42px; }

        /* Strength bar */
        .strength-bar {
            margin-top: 8px;
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
        }
        .strength-bar .fill {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: width 0.3s, background 0.3s;
        }
        .strength-label {
            font-size: 11.5px;
            margin-top: 4px;
            color: #94a3b8;
            transition: color 0.3s;
        }

        /* Submit */
        .btn-register {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #1e2685 0%, #2b3fe8 100%);
            color: #fff;
            font-size: 14.5px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            letter-spacing: 0.2px;
            box-shadow: 0 6px 20px rgba(30,38,133,0.35);
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 6px;
        }
        .btn-register:hover {
            opacity: 0.92;
            transform: translateY(-1px);
            box-shadow: 0 10px 28px rgba(30,38,133,0.45);
        }
        .btn-register:active { transform: translateY(0); }
        .btn-register svg { width: 16px; height: 16px; }

        /* Gold accent line */
        .gold-line {
            height: 3px;
            background: linear-gradient(90deg, #1e2685, #f0c14b, #1e2685);
            border-radius: 2px;
            margin-bottom: 28px;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #94a3b8;
        }
        .login-link a {
            color: #1e2685;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        .login-link a:hover { color: #2b3fe8; text-decoration: underline; }
    </style>
</head>
<body>

<div class="bg-hero">
    <img src="https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop"
         alt="Biara Loresa SCJ">
</div>

<div class="page-wrap">

    {{-- Left branding (desktop) --}}
    <div class="left-panel">
        <div class="cross-icon">
            <svg fill="currentColor" viewBox="0 0 24 24">
                <path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/>
            </svg>
        </div>
        <p class="eyebrow">Serikat Imam-imam Hati Kudus Yesus</p>
        <h1>Biara Loresa<br><span>SCJ</span></h1>
        <p class="tagline">
            Bersumber dari kasih Hati Kudus Yesus, kami hadir untuk melayani,
            mendampingi, dan mewartakan Injil kepada semua orang.
        </p>
        <div class="divider"></div>
        <p class="quote">
            "Hati-Ku yang Kudus adalah sumber kasih yang tak pernah kering."
            <strong>— Devosi SCJ</strong>
        </p>
    </div>

    {{-- Right form --}}
    <div class="right-panel">

        {{-- Mobile brand --}}
        <div class="mobile-brand">
            <div class="icon">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/>
                </svg>
            </div>
            <div>
                <div class="name">Biara Loresa</div>
                <div class="sub">SCJ</div>
            </div>
        </div>

        <div class="gold-line"></div>

        <div class="form-heading">
            <h2>Daftar Akun Admin</h2>
            <p>Buat akun administrator baru untuk panel pengelolaan</p>
        </div>

        @if(session('error'))
            <div class="alert alert-error">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any() && !$errors->has('name') && !$errors->has('email') && !$errors->has('password') && !$errors->has('password_confirmation'))
            <div class="alert alert-error">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
                Terjadi kesalahan, silakan periksa kembali form Anda.
            </div>
        @endif

        <form method="POST" action="{{ route('admin.register.post') }}" novalidate>
            @csrf

            {{-- Nama --}}
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <div class="input-wrap">
                    <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                    <input type="text" id="name" name="name"
                           value="{{ old('name') }}"
                           placeholder="Nama Lengkap"
                           class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                           autocomplete="name" required>
                </div>
                @error('name')
                    <div class="field-error">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;flex-shrink:0">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <div class="input-wrap">
                    <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="admin@biaraloresa.my.id"
                           class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                           autocomplete="email" required>
                </div>
                @error('email')
                    <div class="field-error">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;flex-shrink:0">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <div class="input-wrap">
                    <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                    <input type="password" id="password" name="password"
                           placeholder="Minimal 8 karakter"
                           class="has-eye {{ $errors->has('password') ? 'is-invalid' : '' }}"
                           autocomplete="new-password" required
                           oninput="checkStrength(this.value)">
                    <button type="button" class="eye-btn" onclick="togglePassword('password','eye-icon-1')" aria-label="Tampilkan kata sandi">
                        <svg id="eye-icon-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </button>
                </div>
                <div class="strength-bar"><div class="fill" id="strength-fill"></div></div>
                <div class="strength-label" id="strength-label">Masukkan kata sandi</div>
                @error('password')
                    <div class="field-error">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;flex-shrink:0">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                <div class="input-wrap">
                    <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                    </svg>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           placeholder="Ulangi kata sandi"
                           class="has-eye {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                           autocomplete="new-password" required>
                    <button type="button" class="eye-btn" onclick="togglePassword('password_confirmation','eye-icon-2')" aria-label="Tampilkan konfirmasi">
                        <svg id="eye-icon-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <div class="field-error">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;flex-shrink:0">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-register">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
                </svg>
                Buat Akun Admin
            </button>
        </form>

        <div class="login-link">
            Sudah punya akun? Verifikasi email Anda lalu akses panel admin.
        </div>
    </div>
</div>

<script>
    const eyeOpen  = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
    const eyeClose = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>`;

    const visibleMap = {};
    function togglePassword(inputId, iconId) {
        visibleMap[inputId] = !visibleMap[inputId];
        document.getElementById(inputId).type = visibleMap[inputId] ? 'text' : 'password';
        document.getElementById(iconId).innerHTML = visibleMap[inputId] ? eyeClose : eyeOpen;
    }

    function checkStrength(val) {
        const fill  = document.getElementById('strength-fill');
        const label = document.getElementById('strength-label');
        let score = 0;
        if (val.length >= 8)  score++;
        if (val.length >= 12) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [
            { pct: '0%',   color: '#e2e8f0', text: 'Masukkan kata sandi' },
            { pct: '20%',  color: '#ef4444', text: 'Sangat lemah' },
            { pct: '40%',  color: '#f97316', text: 'Lemah' },
            { pct: '60%',  color: '#eab308', text: 'Cukup' },
            { pct: '80%',  color: '#22c55e', text: 'Kuat' },
            { pct: '100%', color: '#16a34a', text: 'Sangat kuat' },
        ];
        const l = val.length === 0 ? levels[0] : levels[Math.min(score, 5)];
        fill.style.width      = l.pct;
        fill.style.background = l.color;
        label.textContent     = l.text;
        label.style.color     = l.color === '#e2e8f0' ? '#94a3b8' : l.color;
    }
</script>
</body>
</html>
