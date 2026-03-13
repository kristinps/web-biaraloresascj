@php
    $formatDate = function ($date) {
        return $date ? $date->locale('id')->isoFormat('D MMM YYYY') : '—';
    };
    $orangTua = function ($ayah, $ibu) {
        return trim(($ayah ?? '') . ' & ' . ($ibu ?? ''), ' &') ?: '—';
    };
    $statusPembayaran = $pendaftaran->status_pembayaran ?? '—';
    $isLunas = $statusPembayaran === 'lunas';
    $isMenunggu = in_array($statusPembayaran, ['pending', 'menunggu'], true);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Pembayaran &amp; Pendaftaran Berhasil – Biara Loresa SCJ</title>
</head>
<body style="margin:0;padding:0;background:#1e293b;font-family:'Helvetica Neue',Arial,sans-serif;-webkit-font-smoothing:antialiased;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#1e293b;">
  <tr>
    <td align="center" style="padding:32px 16px 48px;">

      <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;width:100%;">

        <!-- HEADER - tema dashboard admin (gradient indigo/violet/blue) -->
        <tr>
          <td style="background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 45%,#3b82f6 100%);border-radius:20px 20px 0 0;padding:44px 40px 48px;text-align:center;">
            <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 20px;">
              <tr>
                <td width="72" height="72" align="center" valign="middle"
                    style="width:72px;height:72px;background:rgba(255,255,255,0.2);border-radius:50%;">
                  <span style="font-size:34px;line-height:72px;">✓</span>
                </td>
              </tr>
            </table>
            <h1 style="color:#ffffff;font-size:24px;font-weight:800;margin:0 0 8px;letter-spacing:-0.3px;line-height:1.3;">
              Pembayaran &amp; Pendaftaran Berhasil!
            </h1>
            <p style="color:rgba(255,255,255,0.9);font-size:14px;margin:0;line-height:1.5;">
              Kursus Pernikahan &nbsp;·&nbsp; Biara Loresa SCJ
            </p>
          </td>
        </tr>

        <tr>
          <td style="line-height:0;background:#eef2ff;">
            <svg viewBox="0 0 600 20" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;height:20px;background:#eef2ff;">
              <path d="M0,0 C150,20 450,20 600,0 L600,0 L0,0 Z" fill="url(#headerGrad)"/>
              <defs>
                <linearGradient id="headerGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#6366f1"/><stop offset="50%" stop-color="#8b5cf6"/><stop offset="100%" stop-color="#3b82f6"/>
                </linearGradient>
              </defs>
            </svg>
          </td>
        </tr>

        <!-- BODY - background seperti dashboard -->
        <tr>
          <td style="background:#eef2ff;padding:28px 24px 32px;">

            <p style="font-size:16px;font-weight:700;color:#1e293b;margin:0 0 20px;line-height:1.4;">
              Yth. {{ $pendaftaran->nama_pria }} &amp; {{ $pendaftaran->nama_wanita }},
            </p>
            <p style="font-size:14px;color:#475569;line-height:1.7;margin:0 0 24px;">
              Selamat, pembayaran dan pendaftaran telah berhasil. Berikut ringkasan data Anda.
            </p>

            <!-- CARD: Data Calon Pria & Wanita (style status-pendaftaran + tema dashboard) -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:20px;">
              <tr>
                <td style="padding:20px;background:linear-gradient(135deg,rgba(99,102,241,0.12),rgba(139,92,246,0.08),rgba(56,189,248,0.06));border:1px solid rgba(148,163,184,0.5);border-radius:16px;box-shadow:0 8px 24px rgba(15,23,42,0.08);">
                  <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0 0 16px;text-transform:uppercase;letter-spacing:0.04em;">Data Calon Pengantin</p>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <!-- Calon Pria -->
                      <td width="48%" valign="top" style="padding:18px;background:linear-gradient(145deg,#dbeafe 0%,#bfdbfe 50%,#93c5fd 100%);border:1px solid rgba(147,197,253,0.6);border-radius:14px;box-shadow:0 4px 14px rgba(37,99,235,0.15);">
                        <p style="font-size:11px;font-weight:700;color:#1e40af;margin:0 0 6px;text-transform:uppercase;">Calon Pria</p>
                        <p style="font-size:15px;font-weight:700;color:#0f172a;margin:0 0 4px;">{{ $pendaftaran->nama_pria }}</p>
                        <p style="font-size:12px;color:#1e293b;margin:0 0 2px;">{{ $formatDate($pendaftaran->tanggal_pernikahan) }}</p>
                        <p style="font-size:11px;color:#334155;margin:0 0 6px;">{{ $pendaftaran->tempat_lahir_pria ?? '—' }}, {{ $formatDate($pendaftaran->tanggal_lahir_pria) }}</p>
                        <p style="font-size:11px;color:#1e293b;margin:0;padding-top:6px;border-top:1px solid rgba(0,0,0,0.08);"><strong>Orang tua:</strong> {{ $orangTua($pendaftaran->nama_ayah_pria, $pendaftaran->nama_ibu_pria) }}</p>
                      </td>
                      <td width="4%" align="center" valign="middle" style="padding:8px;">
                        <span style="font-size:20px;">💍</span>
                        @if($isLunas)
                        <div style="margin-top:8px;display:inline-block;padding:6px 12px;border-radius:999px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:11px;font-weight:700;">Lunas</div>
                        @elseif($isMenunggu)
                        <div style="margin-top:8px;display:inline-block;padding:6px 12px;border-radius:999px;background:linear-gradient(135deg,#fef3c7,#fde68a);color:#b45309;font-size:11px;font-weight:700;">Menunggu</div>
                        @else
                        <div style="margin-top:8px;display:inline-block;padding:6px 12px;border-radius:999px;background:#e2e8f0;color:#475569;font-size:11px;font-weight:700;">{{ ucfirst($statusPembayaran) }}</div>
                        @endif
                      </td>
                      <!-- Calon Wanita -->
                      <td width="48%" valign="top" style="padding:18px;background:linear-gradient(145deg,#fce7f3 0%,#fbcfe8 50%,#f9a8d4 100%);border:1px solid rgba(249,168,212,0.6);border-radius:14px;box-shadow:0 4px 14px rgba(236,72,153,0.15);">
                        <p style="font-size:11px;font-weight:700;color:#9d174d;margin:0 0 6px;text-transform:uppercase;">Calon Wanita</p>
                        <p style="font-size:15px;font-weight:700;color:#0f172a;margin:0 0 4px;">{{ $pendaftaran->nama_wanita }}</p>
                        <p style="font-size:12px;color:#1e293b;margin:0 0 2px;">{{ $formatDate($pendaftaran->tanggal_pernikahan) }}</p>
                        <p style="font-size:11px;color:#334155;margin:0 0 6px;">{{ $pendaftaran->tempat_lahir_wanita ?? '—' }}, {{ $formatDate($pendaftaran->tanggal_lahir_wanita) }}</p>
                        <p style="font-size:11px;color:#1e293b;margin:0;padding-top:6px;border-top:1px solid rgba(0,0,0,0.08);"><strong>Orang tua:</strong> {{ $orangTua($pendaftaran->nama_ayah_wanita, $pendaftaran->nama_ibu_wanita) }}</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

            <!-- CARD: Data Pembayaran (tema dashboard admin) -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:20px;">
              <tr>
                <td style="padding:20px;background:linear-gradient(135deg,rgba(99,102,241,0.12),rgba(139,92,246,0.08),rgba(56,189,248,0.06));border:1px solid rgba(148,163,184,0.5);border-radius:16px;box-shadow:0 8px 24px rgba(15,23,42,0.08);">
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td width="48" height="48" align="center" valign="middle" style="width:48px;height:48px;background:linear-gradient(135deg,#10b981,#059669);border-radius:12px;vertical-align:middle;">
                        <span style="font-size:20px;">💰</span>
                      </td>
                      <td style="padding-left:16px;vertical-align:middle;">
                        <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0 0 4px;">Data Pembayaran</p>
                        <p style="font-size:12px;color:#64748b;margin:0;">Status dan informasi pembayaran</p>
                      </td>
                    </tr>
                  </table>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:16px;background:rgba(255,255,255,0.6);border-radius:12px;border:1px solid rgba(226,232,240,0.8);">
                    <tr>
                      <td style="padding:14px 18px;">
                        <p style="margin:0 0 6px;font-size:11px;color:#64748b;">Status</p>
                        <p style="margin:0 0 12px;font-size:14px;font-weight:700;color:#1e293b;">
                          @if($isLunas)
                          <span style="display:inline-block;padding:4px 10px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;">Lunas</span>
                          @elseif($isMenunggu)
                          <span style="display:inline-block;padding:4px 10px;border-radius:8px;background:linear-gradient(135deg,#fef3c7,#fde68a);color:#b45309;">Menunggu</span>
                          @else
                          <span style="display:inline-block;padding:4px 10px;border-radius:8px;background:#e2e8f0;color:#475569;">{{ ucfirst($statusPembayaran) }}</span>
                          @endif
                        </p>
                        @if($pendaftaran->periode)
                        <p style="margin:0 0 6px;font-size:11px;color:#64748b;">Periode</p>
                        <p style="margin:0 0 12px;font-size:13px;font-weight:600;color:#1e293b;">{{ $pendaftaran->periode->nama }}</p>
                        @endif
                        <p style="margin:0;font-size:11px;color:#64748b;">Biaya kursus pernikahan · Konfirmasi telah tercatat</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

            <!-- CARD: Akun Login (tema dashboard admin) -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;">
              <tr>
                <td style="padding:20px;background:linear-gradient(135deg,rgba(99,102,241,0.12),rgba(139,92,246,0.08),rgba(56,189,248,0.06));border:1px solid rgba(148,163,184,0.5);border-radius:16px;box-shadow:0 8px 24px rgba(15,23,42,0.08);">
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td width="48" height="48" align="center" valign="middle" style="width:48px;height:48px;background:linear-gradient(135deg,#8b5cf6,#7c3aed);border-radius:12px;vertical-align:middle;">
                        <span style="font-size:20px;">🔐</span>
                      </td>
                      <td style="padding-left:16px;vertical-align:middle;">
                        <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0 0 4px;">Akun Login</p>
                        <p style="font-size:12px;color:#64748b;margin:0;">Gunakan data berikut untuk masuk ke dashboard</p>
                      </td>
                    </tr>
                  </table>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:16px;background:rgba(255,255,255,0.6);border-radius:12px;border:1px solid rgba(226,232,240,0.8);">
                    <tr>
                      <td style="padding:14px 18px;">
                        <p style="margin:0 0 6px;font-size:11px;color:#64748b;">Email login</p>
                        <p style="margin:0 0 14px;font-size:14px;font-weight:700;color:#1e293b;">{{ $pendaftaran->email }}</p>
                        @if($password)
                        <p style="margin:0 0 6px;font-size:11px;color:#64748b;">Kata sandi (segera ubah setelah login)</p>
                        <p style="margin:0;font-size:14px;font-weight:700;color:#1e293b;letter-spacing:1px;">{{ $password }}</p>
                        @else
                        <p style="margin:0;font-size:12px;color:#64748b;">Gunakan kata sandi yang Anda buat. Jika lupa, gunakan fitur "Lupa kata sandi" di halaman login.</p>
                        @endif
                      </td>
                    </tr>
                  </table>
                  <p style="margin:16px 0 0;">
                    <a href="{{ url('/login') }}"
                       style="display:inline-block;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#ffffff;font-size:13px;font-weight:700;padding:12px 28px;border-radius:12px;text-decoration:none;box-shadow:0 4px 14px rgba(99,102,241,0.35);">
                      Login ke Dashboard →
                    </a>
                  </p>
                </td>
              </tr>
            </table>

            <p style="font-size:13px;color:#64748b;line-height:1.6;margin:0 0 20px;">
              Silakan login ke dashboard dan ubah kata sandi jika baru pertama kali. Tunggu informasi lanjutan melalui email dan notifikasi dashboard.
            </p>

            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:24px;margin-bottom:20px;">
              <tr><td style="border-top:1px solid #e2e8f0;font-size:0;">&nbsp;</td></tr>
            </table>

            <table width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td style="text-align:center;padding:0 20px;">
                  <p style="font-size:13px;color:#64748b;margin:0;line-height:1.6;">
                    <strong style="color:#475569;">Biara Loresa SCJ</strong> &nbsp;·&nbsp; Kalimantan Timur, Indonesia
                  </p>
                  <p style="margin:8px 0 0;"><a href="{{ config('app.url') }}" style="color:#6366f1;font-size:13px;">{{ config('app.url') }}</a></p>
                </td>
              </tr>
            </table>

          </td>
        </tr>

        <!-- FOOTER - sama seperti dashboard (gelap) -->
        <tr>
          <td style="background:#1e293b;border-radius:0 0 20px 20px;padding:28px 36px;text-align:center;">
            <p style="color:#ffffff;font-size:15px;font-weight:800;margin:0 0 6px;">✝ Biara Loresa SCJ</p>
            <p style="color:#94a3b8;font-size:12px;margin:0;">Email ini dikirim otomatis setelah pembayaran berhasil. &copy; {{ date('Y') }}</p>
          </td>
        </tr>

      </table>

    </td>
  </tr>
</table>

</body>
</html>
