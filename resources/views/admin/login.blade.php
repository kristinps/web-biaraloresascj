<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Biara Loresa SCJ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative blobs */
        body::before {
            content: '';
            position: fixed;
            top: -200px; left: -200px;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.25) 0%, transparent 70%);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -200px; right: -200px;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(168,85,247,0.2) 0%, transparent 70%);
            pointer-events: none;
        }

        .card {
            width: 100%;
            max-width: 440px;
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 24px;
            padding: 48px 40px 40px;
            box-shadow: 0 32px 80px rgba(0,0,0,0.5);
            position: relative;
            z-index: 1;
        }

        .logo-wrap {
            text-align: center;
            margin-bottom: 32px;
        }
        .logo-wrap .icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px; height: 72px;
            border-radius: 20px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            box-shadow: 0 12px 32px rgba(99,102,241,0.45);
            margin-bottom: 16px;
        }
        .logo-wrap .icon svg {
            width: 34px; height: 34px;
            color: #fff;
        }
        .logo-wrap h1 {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.4px;
            line-height: 1.3;
        }
        .logo-wrap p {
            font-size: 13px;
            color: rgba(255,255,255,0.55);
            margin-top: 5px;
        }

        .divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin-bottom: 28px;
        }

        /* Alert */
        .alert {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .alert-error {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5;
        }
        .alert-success {
            background: rgba(34,197,94,0.15);
            border: 1px solid rgba(34,197,94,0.3);
            color: #86efac;
        }
        .alert svg { flex-shrink: 0; width: 16px; height: 16px; margin-top: 1px; }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.75);
            margin-bottom: 8px;
            letter-spacing: 0.2px;
        }
        .input-wrap {
            position: relative;
        }
        .input-wrap .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.35);
            width: 18px; height: 18px;
            pointer-events: none;
        }
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            background: rgba(255,255,255,0.07);
            border: 1.5px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            color: #fff;
            font-size: 14.5px;
            font-family: 'Inter', sans-serif;
            padding: 12px 14px 12px 44px;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        input::placeholder { color: rgba(255,255,255,0.28); }
        input:focus {
            border-color: rgba(99,102,241,0.7);
            background: rgba(255,255,255,0.1);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.18);
        }
        input.is-invalid {
            border-color: rgba(239,68,68,0.6);
            box-shadow: 0 0 0 3px rgba(239,68,68,0.12);
        }
        .field-error {
            font-size: 12.5px;
            color: #fca5a5;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Password toggle */
        .eye-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255,255,255,0.35);
            padding: 4px;
            transition: color 0.2s;
        }
        .eye-btn:hover { color: rgba(255,255,255,0.7); }
        .eye-btn svg { width: 18px; height: 18px; }
        input[type="password"].has-eye,
        input[type="text"].has-eye { padding-right: 44px; }

        /* Remember me */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }
        .remember-row input[type="checkbox"] {
            width: 16px; height: 16px;
            padding: 0;
            cursor: pointer;
            accent-color: #6366f1;
            border-radius: 4px;
        }
        .remember-row label {
            margin: 0;
            font-size: 13.5px;
            color: rgba(255,255,255,0.65);
            font-weight: 400;
            cursor: pointer;
        }

        /* Submit */
        .btn-login {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            letter-spacing: 0.2px;
            box-shadow: 0 8px 24px rgba(99,102,241,0.4);
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-login:hover {
            opacity: 0.92;
            transform: translateY(-1px);
            box-shadow: 0 12px 32px rgba(99,102,241,0.5);
        }
        .btn-login:active { transform: translateY(0); }
        .btn-login svg { width: 17px; height: 17px; }

        .back-link {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: rgba(255,255,255,0.4);
        }
        .back-link a {
            color: rgba(139,92,246,0.9);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .back-link a:hover { color: #a78bfa; }

        @media (max-width: 480px) {
            .card { padding: 36px 24px 32px; }
        }
    </style>
</head>
<body>

<div class="card">
    <div class="logo-wrap">
        <div class="icon">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
            </svg>
        </div>
        <h1>Panel Administrator</h1>
        <p>Biara Loresa SCJ</p>
    </div>

    <div class="divider"></div>

    @if(session('error'))
        <div class="alert alert-error">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}" novalidate>
        @csrf

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

        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <div class="input-wrap">
                <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                </svg>
                <input type="password" id="password" name="password"
                       placeholder="••••••••••"
                       class="has-eye {{ $errors->has('password') ? 'is-invalid' : '' }}"
                       autocomplete="current-password" required>
                <button type="button" class="eye-btn" onclick="togglePassword()" id="eye-btn" aria-label="Tampilkan kata sandi">
                    <svg id="eye-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <div class="field-error">
                    <svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;flex-shrink:0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="remember-row">
            <input type="checkbox" id="remember" name="remember" value="1"
                   {{ old('remember') ? 'checked' : '' }}>
            <label for="remember">Ingat sesi login saya</label>
        </div>

        <button type="submit" class="btn-login">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
            </svg>
            Masuk ke Panel Admin
        </button>
    </form>

    <div class="back-link">
        <a href="{{ url('/') }}">← Kembali ke Beranda</a>
    </div>
</div>

<script>
    let visible = false;
    function togglePassword() {
        visible = !visible;
        const input = document.getElementById('password');
        const icon  = document.getElementById('eye-icon');
        input.type  = visible ? 'text' : 'password';
        icon.innerHTML = visible
            ? `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>`
            : `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
    }
</script>
</body>
</html>
