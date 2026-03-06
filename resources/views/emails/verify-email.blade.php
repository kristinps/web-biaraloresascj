<!DOCTYPE html>
<html lang="id" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Konfirmasi Email — Biara Loresa SCJ</title>
    <!--[if mso]>
    <noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript>
    <![endif]-->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: #f1f5f9;
            font-family: 'Inter', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            margin: 0; padding: 0;
        }

        .email-wrapper {
            width: 100%;
            background-color: #f1f5f9;
            padding: 40px 16px;
        }

        .email-container {
            max-width: 580px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
        }

        /* ─── HEADER ─── */
        .header {
            background: linear-gradient(135deg, #1e2685 0%, #2b3fe8 100%);
            padding: 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header-bg-overlay {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(240,193,75,0.12) 0%, transparent 60%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.06) 0%, transparent 50%);
        }
        .header-inner {
            position: relative;
            z-index: 1;
            padding: 40px 40px 32px;
        }
        .cross-circle {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.18);
            border: 2px solid rgba(255,255,255,0.40);
            border-radius: 50%;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .cross-circle svg {
            width: 32px;
            height: 32px;
            color: #ffffff;
        }
        .header-eyebrow {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #f0c14b;
            margin-bottom: 6px;
        }
        .header-title {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
        }
        .header-title span { color: #f0c14b; }

        /* Gold divider line */
        .gold-line {
            height: 3px;
            background: linear-gradient(90deg, transparent, #f0c14b, transparent);
        }

        /* ─── BODY ─── */
        .body {
            padding: 36px 40px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 800;
            color: #1e2685;
            margin-bottom: 12px;
        }

        .body p {
            font-size: 14.5px;
            color: #475569;
            line-height: 1.75;
            margin-bottom: 16px;
        }

        /* Info card */
        .info-card {
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
            border: 1px solid #c7d2fe;
            border-left: 4px solid #1e2685;
            border-radius: 10px;
            padding: 16px 18px;
            margin: 20px 0;
        }
        .info-card p {
            font-size: 13.5px;
            color: #3730a3;
            margin: 0;
            line-height: 1.6;
        }
        .info-card p strong { color: #1e2685; }

        /* CTA Button */
        .btn-wrap {
            text-align: center;
            margin: 28px 0;
        }
        .btn-activate {
            display: inline-block;
            background: linear-gradient(135deg, #1e2685 0%, #2b3fe8 100%);
            color: #ffffff !important;
            text-decoration: none !important;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Inter', Arial, sans-serif;
            letter-spacing: 0.3px;
            padding: 14px 36px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(30,38,133,0.40);
        }

        /* Steps */
        .steps-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 12px;
        }
        .step-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 10px;
        }
        .step-num {
            flex-shrink: 0;
            width: 22px;
            height: 22px;
            background: #1e2685;
            color: #fff;
            border-radius: 50%;
            font-size: 11px;
            font-weight: 700;
            text-align: center;
            line-height: 22px;
        }
        .step-text {
            font-size: 13.5px;
            color: #475569;
            line-height: 1.55;
            padding-top: 2px;
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 24px 0;
        }

        /* URL fallback */
        .url-fallback {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 14px;
            word-break: break-all;
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
        }
        .url-fallback a {
            color: #1e2685;
            word-break: break-all;
        }

        .disclaimer {
            font-size: 12.5px !important;
            color: #94a3b8 !important;
            font-style: italic;
        }

        /* ─── FOOTER ─── */
        .footer {
            background: #1e2234;
            padding: 28px 40px;
            text-align: center;
        }
        .footer-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }
        .footer-icon {
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .footer-icon svg {
            width: 16px;
            height: 16px;
            color: #f0c14b;
        }
        .footer-name {
            font-size: 14px;
            font-weight: 700;
            color: #ffffff;
        }
        .footer-sub {
            font-size: 10px;
            color: #f0c14b;
            letter-spacing: 2px;
            font-weight: 600;
        }
        .footer p {
            font-size: 12px;
            color: rgba(255,255,255,0.45);
            line-height: 1.6;
            margin-bottom: 4px;
        }
        .footer-verse {
            font-style: italic;
            font-size: 12px;
            color: rgba(240,193,75,0.7);
            margin-top: 8px !important;
        }

        @media only screen and (max-width: 480px) {
            .body        { padding: 28px 24px; }
            .header-inner { padding: 32px 24px 24px; }
            .footer      { padding: 24px; }
        }
    </style>
</head>
<body>

<div class="email-wrapper">
    <div class="email-container">

        {{-- ─── HEADER ─── --}}
        <div class="header">
            <div class="header-bg-overlay"></div>
            <div class="header-inner">
                <div class="cross-circle">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/>
                    </svg>
                </div>
                <p class="header-eyebrow">Serikat Imam-imam Hati Kudus Yesus</p>
                <h1 class="header-title">Biara Loresa <span>SCJ</span></h1>
            </div>
        </div>
        <div class="gold-line"></div>

        {{-- ─── BODY ─── --}}
        <div class="body">

            <p class="greeting">Halo, {{ $user->name }}!</p>

            <p>
                Terima kasih telah mendaftar sebagai administrator
                <strong style="color:#1e2685">Biara Loresa SCJ</strong>.
                Akun Anda sudah dibuat, namun perlu diaktifkan terlebih dahulu melalui verifikasi email.
            </p>

            <div class="info-card">
                <p>
                    <strong>⏱ Tautan ini berlaku selama 60 menit.</strong><br>
                    Jika sudah kadaluwarsa, Anda dapat meminta tautan baru melalui halaman verifikasi.
                </p>
            </div>

            <div class="btn-wrap">
                <a href="{{ $url }}" class="btn-activate" target="_blank">
                    ✔&nbsp; Aktifkan Akun Saya
                </a>
            </div>

            <div class="steps-title">Cara menggunakan email ini</div>

            <div class="step-row">
                <div class="step-num">1</div>
                <div class="step-text">Klik tombol <strong>"Aktifkan Akun Saya"</strong> di atas</div>
            </div>
            <div class="step-row">
                <div class="step-num">2</div>
                <div class="step-text">Anda akan diarahkan ke halaman konfirmasi di browser</div>
            </div>
            <div class="step-row">
                <div class="step-num">3</div>
                <div class="step-text">Setelah berhasil, masuk ke panel admin menggunakan email dan kata sandi Anda</div>
            </div>

            <hr class="divider">

            <p style="font-size:13px;color:#94a3b8;margin-bottom:8px">
                Jika tombol di atas tidak bekerja, salin dan tempel tautan berikut ke browser Anda:
            </p>
            <div class="url-fallback">
                <a href="{{ $url }}">{{ $url }}</a>
            </div>

            <hr class="divider">

            <p class="disclaimer">
                Jika Anda tidak merasa melakukan pendaftaran ini, abaikan saja email ini.
                Akun tidak akan aktif tanpa verifikasi.
            </p>

        </div>

        {{-- ─── FOOTER ─── --}}
        <div class="footer">
            <div style="text-align:center;margin-bottom:14px">
                <span style="display:inline-block;width:36px;height:36px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.25);border-radius:50%;text-align:center;line-height:34px">
                    <svg width="16" height="16" fill="#f0c14b" viewBox="0 0 24 24" style="vertical-align:middle">
                        <path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/>
                    </svg>
                </span>
                <div style="font-size:14px;font-weight:700;color:#fff;margin-top:6px">Biara Loresa SCJ</div>
                <div style="font-size:10px;color:#f0c14b;letter-spacing:2px;font-weight:600">SACERDOTES CORDIS JESU</div>
            </div>
            <p>Kalimantan Timur, Indonesia</p>
            <p>admin.biaraloresa.my.id</p>
            <p class="footer-verse">"Hati-Ku yang Kudus adalah sumber kasih yang tak pernah kering."</p>
        </div>

    </div>

    {{-- Pre-header hint (invisible in body, shown in email preview) --}}
    <p style="font-size:1px;color:#f1f5f9;max-height:0;overflow:hidden;">
        Aktifkan akun administrator Biara Loresa SCJ Anda — tautan berlaku 60 menit.
    </p>
</div>

</body>
</html>
