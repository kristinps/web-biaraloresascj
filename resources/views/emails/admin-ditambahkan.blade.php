<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Selamat, Anda Ditambahkan sebagai Admin – Biara Loresa SCJ</title>
</head>
<body style="margin:0;padding:0;background:#f0f4ff;font-family:'Helvetica Neue',Arial,sans-serif;-webkit-font-smoothing:antialiased;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f0f4ff;">
  <tr>
    <td align="center" style="padding:32px 16px 48px;">

      <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;width:100%;">

        <!-- HEADER – Tema Beranda: gradient primary + gold -->
        <tr>
          <td style="background:linear-gradient(135deg, #1e2685 0%, #2129a7 40%, #3d56f5 100%);border-radius:20px 20px 0 0;padding:44px 40px 48px;text-align:center;">
            <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 20px;">
              <tr>
                <td width="76" height="76" align="center" valign="middle"
                    style="width:76px;height:76px;background:rgba(255,255,255,0.2);border-radius:50%;border:2px solid rgba(255,255,255,0.5);">
                  <span style="font-size:28px;line-height:76px;color:#ffffff;">✝</span>
                </td>
              </tr>
            </table>
            <p style="color:#f0c14b;font-size:11px;font-weight:600;letter-spacing:0.15em;text-transform:uppercase;margin:0 0 8px;">
              Serikat Imam-imam Hati Kudus Yesus
            </p>
            <h1 style="color:#ffffff;font-size:26px;font-weight:800;margin:0 0 6px;letter-spacing:-0.3px;line-height:1.3;font-family:Georgia,'Times New Roman',serif;">
              Biara Loresa <span style="color:#f0c14b;">SCJ</span>
            </h1>
            <p style="color:rgba(255,255,255,0.88);font-size:13px;margin:0;line-height:1.5;">
              Selamat, Anda ditambahkan sebagai Admin
            </p>
          </td>
        </tr>

        <tr>
          <td style="line-height:0;background:#ffffff;">
            <svg viewBox="0 0 600 24" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;height:24px;background:#ffffff;">
              <path d="M0,0 C150,24 450,24 600,0 L600,0 L0,0 Z" fill="url(#berandaGrad)"/>
              <defs>
                <linearGradient id="berandaGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#1e2685"/><stop offset="50%" stop-color="#3d56f5"/><stop offset="100%" stop-color="#2129a7"/>
                </linearGradient>
              </defs>
            </svg>
          </td>
        </tr>

        <!-- BODY -->
        <tr>
          <td style="background:#ffffff;padding:40px 36px 36px;">

            <p style="font-size:18px;font-weight:700;color:#1e293b;margin:0 0 12px;line-height:1.4;">
              Yth. {{ $user->name }},
            </p>
            <p style="font-size:14px;color:#64748b;line-height:1.9;margin:0 0 24px;">
              Selamat! Anda telah <strong style="color:#1e293b;">ditambahkan sebagai Admin</strong> di website Biara Loresa SCJ.
              Gunakan data login berikut untuk masuk ke dashboard.
            </p>

            <!-- Data Login -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                   style="background:linear-gradient(135deg,#f0f4ff,#dce6ff);border:1.5px solid #93aeff;border-radius:16px;margin-bottom:28px;">
              <tr>
                <td style="padding:24px;">
                  <p style="font-size:14px;font-weight:800;color:#1e2685;margin:0 0 16px;">🔐 Data Login Anda</p>
                  <p style="font-size:13px;color:#2129a7;margin:0 0 8px;">Simpan informasi ini untuk masuk ke dashboard:</p>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:rgba(255,255,255,0.9);border-radius:12px;margin:12px 0;">
                    <tr>
                      <td style="padding:16px 20px;">
                        <p style="margin:0 0 6px;font-size:12px;color:#64748b;">Email</p>
                        <p style="margin:0 0 14px;font-size:15px;font-weight:700;color:#1e293b;">{{ $user->email }}</p>
                        <p style="margin:0 0 6px;font-size:12px;color:#64748b;">Kata sandi</p>
                        <p style="margin:0;font-size:15px;font-weight:700;color:#1e293b;letter-spacing:1px;">{{ $password }}</p>
                      </td>
                    </tr>
                  </table>
                  <p style="font-size:12px;color:#2129a7;margin:0 0 14px;">Untuk keamanan, disarankan mengganti kata sandi setelah login pertama.</p>
                  <a href="{{ config('app.url') }}/login"
                     style="display:inline-block;background:linear-gradient(135deg,#2230ce,#3d56f5);color:#ffffff;font-size:13px;font-weight:700;padding:12px 28px;border-radius:10px;text-decoration:none;">
                    Masuk ke Dashboard →
                  </a>
                </td>
              </tr>
            </table>

            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">
              <tr><td style="border-top:1px solid #f1f5f9;font-size:0;">&nbsp;</td></tr>
            </table>

            <p style="font-size:13px;color:#94a3b8;line-height:1.6;margin:0;">
              <strong style="color:#64748b;">Biara Loresa SCJ</strong> – Serikat Imam-imam Hati Kudus Yesus. Kalimantan Timur, Indonesia.
            </p>
            <p style="margin:8px 0 0;"><a href="{{ config('app.url') }}" style="color:#3d56f5;font-size:13px;">{{ config('app.url') }}</a></p>

          </td>
        </tr>

        <!-- FOOTER – tema beranda -->
        <tr>
          <td style="background:linear-gradient(135deg,#1e2685,#2129a7);border-radius:0 0 20px 20px;padding:28px 36px;text-align:center;">
            <p style="color:#ffffff;font-size:15px;font-weight:800;margin:0 0 4px;">Biara Loresa <span style="color:#f0c14b;">SCJ</span></p>
            <p style="color:rgba(255,255,255,0.8);font-size:12px;margin:0;">Serikat Imam-imam Hati Kudus Yesus. Email ini dikirim otomatis. &copy; {{ date('Y') }}</p>
          </td>
        </tr>

      </table>

    </td>
  </tr>
</table>

</body>
</html>
