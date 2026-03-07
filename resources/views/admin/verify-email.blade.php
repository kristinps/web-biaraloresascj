<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email — Biara Loresa SCJ</title>
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
        @media (min-width: 900px) { .left-panel { display: flex; } }
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
            font-size: 11px; font-weight: 700;
            letter-spacing: 3px; text-transform: uppercase;
            color: #f0c14b; margin-bottom: 14px;
        }
        .left-panel h1 {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 48px; font-weight: 700;
            color: #fff; line-height: 1.15; margin-bottom: 8px;
        }
        .left-panel h1 span { color: #f0c14b; }
        .left-panel .tagline {
            font-size: 15px; color: rgba(255,255,255,0.75);
            line-height: 1.6; max-width: 320px; margin: 0 auto 40px;
        }
        .left-panel .divider {
            width: 60px; height: 2px;
            background: linear-gradient(90deg, transparent, #f0c14b, transparent);
            margin: 0 auto 32px;
        }
        .left-panel .quote {
            font-size: 14px; color: rgba(255,255,255,0.6);
            font-style: italic; max-width: 300px;
        }
        .left-panel .quote strong {
            display: block; font-style: normal; font-size: 12px;
            color: rgba(255,255,255,0.45); margin-top: 8px;
            letter-spacing: 1px; text-transform: uppercase;
        }

        /* ─── Right panel ─── */
        .right-panel {
            width: 100%; max-width: 480px;
            background: #fff;
            display: flex; flex-direction: column;
            justify-content: center;
            padding: 48px 44px;
            min-height: 100vh;
        }
        @media (max-width: 899px) {
            .right-panel {
                max-width: 100%;
                background: rgba(255,255,255,0.96);
                backdrop-filter: blur(16px);
                padding: 40px 28px;
            }
        }
        @media (max-width: 480px) { .right-panel { padding: 36px 20px; } }

        .mobile-brand {
            display: flex; align-items: center; gap: 12px; margin-bottom: 36px;
        }
        @media (min-width: 900px) { .mobile-brand { display: none; } }
        .mobile-brand .icon {
            width: 42px; height: 42px; background: #1e2685;
            border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .mobile-brand .icon svg { width: 22px; height: 22px; color: #fff; }
        .mobile-brand .name { font-weight: 700; font-size: 15px; color: #1e2685; }
        .mobile-brand .sub  { font-size: 11px; color: #d4a017; font-weight: 600; letter-spacing: 2px; }

        .gold-line {
            height: 3px;
            background: linear-gradient(90deg, #1e2685, #f0c14b, #1e2685);
            border-radius: 2px; margin-bottom: 28px;
        }

        /* ─── Email icon ─── */
        .email-icon-wrap {
            display: flex; justify-content: center; margin-bottom: 24px;
        }
        .email-icon-wrap .envelope {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            border: 2px solid #c7d2fe;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
        .email-icon-wrap .envelope svg { width: 34px; height: 34px; color: #1e2685; }

        .form-heading { text-align: center; margin-bottom: 8px; }
        .form-heading h2 {
            font-size: 22px; font-weight: 800; color: #1e2685; margin-bottom: 6px;
        }
        .form-heading p {
            font-size: 13.5px; color: #64748b; line-height: 1.6; margin-bottom: 0;
        }
        .form-heading .email-highlight {
            font-weight: 700; color: #1e2685;
        }

        /* ─── Steps ─── */
        .steps {
            background: #f8fafc; border: 1px solid #e2e8f0;
            border-radius: 12px; padding: 16px 18px;
            margin: 20px 0;
        }
        .steps p {
            font-size: 12.5px; color: #64748b; margin-bottom: 10px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .step-item {
            display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px;
        }
        .step-item:last-child { margin-bottom: 0; }
        .step-num {
            width: 22px; height: 22px; flex-shrink: 0;
            background: #1e2685; color: #fff;
            border-radius: 50%; font-size: 11px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .step-item span {
            font-size: 13px; color: #475569; line-height: 1.5; padding-top: 2px;
        }

        /* ─── Alert ─── */
        .alert {
            border-radius: 10px; padding: 12px 16px;
            font-size: 13.5px; margin-bottom: 20px;
            display: flex; align-items: flex-start; gap: 10px;
        }
        .alert-error  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-warning { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
        .alert svg { flex-shrink: 0; width: 16px; height: 16px; margin-top: 1px; }

        /* ─── Resend form ─── */
        .divider-text {
            text-align: center; font-size: 12px; color: #94a3b8;
            margin: 20px 0 16px; position: relative;
        }
        .divider-text::before, .divider-text::after {
            content: ''; position: absolute; top: 50%;
            width: calc(50% - 60px); height: 1px; background: #e2e8f0;
        }
        .divider-text::before { left: 0; }
        .divider-text::after  { right: 0; }

        .form-group { margin-bottom: 16px; }
        label {
            display: block; font-size: 13px; font-weight: 600;
            color: #374151; margin-bottom: 7px;
        }
        .input-wrap { position: relative; }
        .input-wrap .input-icon {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%); color: #94a3b8;
            width: 17px; height: 17px; pointer-events: none;
        }
        input[type="email"] {
            width: 100%; background: #f8fafc;
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            color: #1e293b; font-size: 14.5px;
            font-family: 'Inter', sans-serif;
            padding: 11px 13px 11px 42px;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        input::placeholder { color: #cbd5e1; }
        input:focus {
            border-color: #1e2685; background: #fff;
            box-shadow: 0 0 0 3px rgba(30,38,133,0.1);
        }
        .field-error {
            font-size: 12.5px; color: #dc2626; margin-top: 6px;
            display: flex; align-items: center; gap: 5px;
        }

        .btn-primary {
            width: 100%; padding: 12px; border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #1e2685 0%, #2b3fe8 100%);
            color: #fff; font-size: 14.5px; font-weight: 700;
            font-family: 'Inter', sans-serif; cursor: pointer;
            letter-spacing: 0.2px;
            box-shadow: 0 6px 20px rgba(30,38,133,0.35);
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-primary:hover {
            opacity: 0.92; transform: translateY(-1px);
            box-shadow: 0 10px 28px rgba(30,38,133,0.45);
        }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary svg { width: 16px; height: 16px; }

        .back-link {
            text-align: center; margin-top: 24px;
            font-size: 13px; color: #94a3b8;
        }
        .back-link a {
            color: #1e2685; text-decoration: none;
            font-weight: 600; transition: color 0.2s;
        }
        .back-link a:hover { color: #2b3fe8; text-decoration: underline; }

        .timer {
            text-align: center; font-size: 12px; color: #94a3b8; margin-top: 12px;
        }
        #countdown { font-weight: 700; color: #1e2685; }
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

    {{-- Right panel --}}
    <div class="right-panel">

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

        <div class="email-icon-wrap">
            <div class="envelope">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                </svg>
            </div>
        </div>

        <div class="form-heading">
            <h2>Cek Email Anda</h2>
            @if($email)
                <p>Link aktivasi telah dikirim ke<br>
                    <span class="email-highlight">{{ $email }}</span>
                </p>
            @else
                <p>Link aktivasi telah dikirim ke alamat email yang Anda daftarkan.</p>
            @endif
        </div>

        {{-- Alert messages --}}
        @if(session('error'))
            <div class="alert alert-error" style="margin-top:16px">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success" style="margin-top:16px">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="steps">
            <p>Langkah selanjutnya</p>
            <div class="step-item">
                <div class="step-num">1</div>
                <span>Buka aplikasi email Anda</span>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <span>Cari email dari <strong>Biara Loresa SCJ</strong> dengan subjek "Konfirmasi Email"</span>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <span>Klik tombol <strong>"Aktifkan Akun"</strong> di dalam email tersebut</span>
            </div>
        </div>

        <div class="divider-text">Tidak menerima email?</div>

        {{-- Resend form --}}
        <form method="POST" action="{{ route('verification.send') }}" novalidate>
            @csrf

            <div class="form-group">
                <label for="email">Kirim ulang ke alamat email</label>
                <div class="input-wrap">
                    <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $email) }}"
                           placeholder="email@contoh.com"
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

            <button type="submit" class="btn-primary" id="resend-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                </svg>
                Kirim Ulang Link Aktivasi
            </button>
        </form>

        <div class="timer" id="timer-wrap" style="display:none">
            Tunggu <span id="countdown">60</span> detik sebelum mengirim ulang.
        </div>

        <div class="back-link">
            <a href="{{ route('admin.register') }}">← Kembali ke Halaman Register</a>
        </div>

    </div>
</div>

<script>
    const btn = document.getElementById('resend-btn');
    const timerWrap = document.getElementById('timer-wrap');
    const countdown = document.getElementById('countdown');

    const form = btn.closest('form');
    form.addEventListener('submit', function () {
        btn.disabled = true;
        timerWrap.style.display = 'block';
        let seconds = 60;
        countdown.textContent = seconds;
        const interval = setInterval(() => {
            seconds--;
            countdown.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(interval);
                btn.disabled = false;
                timerWrap.style.display = 'none';
            }
        }, 1000);
    });

    @if(session('success') && str_contains(session('success'), 'tautan aktivasi'))
        btn.disabled = true;
        timerWrap.style.display = 'block';
        let s = 60;
        countdown.textContent = s;
        const iv = setInterval(() => {
            s--;
            countdown.textContent = s;
            if (s <= 0) { clearInterval(iv); btn.disabled = false; timerWrap.style.display = 'none'; }
        }, 1000);
    @endif
</script>
</body>
</html>
