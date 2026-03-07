<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Pendaftaran &amp; Akun Login – Biara Loresa SCJ</title>
</head>
<body style="margin:0;padding:0;background:#eef2ff;font-family:'Helvetica Neue',Arial,sans-serif;-webkit-font-smoothing:antialiased;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#eef2ff;">
  <tr>
    <td align="center" style="padding:32px 16px 48px;">

      <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;width:100%;">

        <!-- HEADER -->
        <tr>
          <td style="background:linear-gradient(135deg,#1a237e 0%,#3949ab 45%,#880e4f 100%);border-radius:20px 20px 0 0;padding:50px 40px 56px;text-align:center;">
            <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto 22px;">
              <tr>
                <td width="76" height="76" align="center" valign="middle"
                    style="width:76px;height:76px;background:rgba(255,255,255,0.2);border-radius:50%;">
                  <span style="font-size:36px;line-height:76px;">📋</span>
                </td>
              </tr>
            </table>
            <h1 style="color:#ffffff;font-size:26px;font-weight:800;margin:0 0 10px;letter-spacing:-0.3px;line-height:1.3;">
              Pendaftaran Berhasil!
            </h1>
            <p style="color:rgba(255,255,255,0.82);font-size:14px;margin:0;line-height:1.5;">
              Kursus Pernikahan &nbsp;·&nbsp; Biara Loresa SCJ
            </p>
          </td>
        </tr>

        <tr>
          <td style="line-height:0;background:#ffffff;">
            <svg viewBox="0 0 600 24" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;height:24px;background:#ffffff;">
              <path d="M0,0 C150,24 450,24 600,0 L600,0 L0,0 Z" fill="url(#wg2)"/>
              <defs>
                <linearGradient id="wg2" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#1a237e"/><stop offset="50%" stop-color="#3949ab"/><stop offset="100%" stop-color="#880e4f"/>
                </linearGradient>
              </defs>
            </svg>
          </td>
        </tr>

        <!-- BODY -->
        <tr>
          <td style="background:#ffffff;padding:40px 36px 36px;">

            <p style="font-size:18px;font-weight:700;color:#1e293b;margin:0 0 12px;line-height:1.4;">
              Yth. {{ $pendaftaran->nama_pria }} &amp; {{ $pendaftaran->nama_wanita }},
            </p>
            <p style="font-size:14px;color:#64748b;line-height:1.9;margin:0 0 24px;">
              Pendaftaran <strong style="color:#1e293b;">Kursus Pernikahan</strong> Anda telah berhasil tercatat.
              Dalam satu email ini Anda menerima: <strong>Invoice</strong>, <strong>Data Pendaftaran</strong>, dan <strong>Akun Login</strong>. Simpan untuk arsip.
            </p>

            <!-- Invoice -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1.5px solid #e2e8f0;border-radius:16px;overflow:hidden;margin-bottom:24px;">
              <tr>
                <td style="background:linear-gradient(135deg,#1e293b,#334155);padding:14px 22px;border-radius:14px 14px 0 0;">
                  <p style="color:#ffffff;font-size:14px;font-weight:700;margin:0;">📄 Invoice</p>
                </td>
              </tr>
              <tr>
                <td style="padding:0 22px;background:#f8fafc;">
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td style="padding:10px 0;border-bottom:1px solid #e2e8f0;width:45%;"><span style="font-size:13px;color:#64748b;">No. Invoice / Pendaftaran</span></td>
                      <td style="padding:10px 0 10px 12px;border-bottom:1px solid #e2e8f0;text-align:right;"><span style="font-size:13px;font-weight:700;color:#1e293b;">#{{ str_pad($pendaftaran->id, 6, '0', STR_PAD_LEFT) }}</span></td>
                    </tr>
                    <tr>
                      <td style="padding:10px 0;border-bottom:1px solid #e2e8f0;"><span style="font-size:13px;color:#64748b;">Tanggal</span></td>
                      <td style="padding:10px 0 10px 12px;border-bottom:1px solid #e2e8f0;text-align:right;"><span style="font-size:13px;font-weight:600;color:#1e293b;">{{ $pendaftaran->created_at->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WIB</span></td>
                    </tr>
                    <tr>
                      <td style="padding:10px 0;border-bottom:1px solid #e2e8f0;"><span style="font-size:13px;color:#64748b;">Total Pembayaran</span></td>
                      <td style="padding:10px 0 10px 12px;border-bottom:1px solid #e2e8f0;text-align:right;"><span style="font-size:16px;font-weight:800;color:#1e293b;">Rp 350.000</span></td>
                    </tr>
                    <tr>
                      <td style="padding:10px 0;width:45%;"><span style="font-size:13px;color:#64748b;">Status</span></td>
                      <td style="padding:10px 0 10px 12px;text-align:right;"><span style="font-size:13px;font-weight:700;color:#64748b;">Menunggu pembayaran</span></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

            <!-- Detail Pendaftaran -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                   style="border:1.5px solid #e2e8f0;border-radius:16px;overflow:hidden;margin-bottom:32px;">
              <tr>
                <td style="background:linear-gradient(135deg,#1a237e,#3949ab);padding:16px 22px;border-radius:14px 14px 0 0;">
                  <p style="color:#ffffff;font-size:14px;font-weight:700;margin:0;">Detail Pendaftaran</p>
                </td>
              </tr>
              <tr>
                <td style="padding:0 22px;background:#ffffff;">
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td style="padding:13px 0;border-bottom:1px solid #f1f5f9;width:45%;"><span style="font-size:13.5px;color:#94a3b8;">Nomor Pendaftaran</span></td>
                      <td style="padding:13px 0 13px 16px;border-bottom:1px solid #f1f5f9;text-align:right;"><span style="font-size:13.5px;font-weight:700;color:#3949ab;">#{{ str_pad($pendaftaran->id, 6, '0', STR_PAD_LEFT) }}</span></td>
                    </tr>
                    <tr>
                      <td style="padding:13px 0;border-bottom:1px solid #f1f5f9;"><span style="font-size:13.5px;color:#94a3b8;">Tanggal Pernikahan</span></td>
                      <td style="padding:13px 0 13px 16px;border-bottom:1px solid #f1f5f9;text-align:right;"><span style="font-size:13.5px;font-weight:700;color:#1e293b;">{{ $pendaftaran->tanggal_pernikahan->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span></td>
                    </tr>
                    <tr>
                      <td style="padding:13px 0;border-bottom:1px solid #f1f5f9;"><span style="font-size:13.5px;color:#94a3b8;">Tempat Pernikahan</span></td>
                      <td style="padding:13px 0 13px 16px;border-bottom:1px solid #f1f5f9;text-align:right;"><span style="font-size:13.5px;font-weight:700;color:#1e293b;">{{ $pendaftaran->tempat_pernikahan }}</span></td>
                    </tr>
                    <tr>
                      <td style="padding:13px 0;border-bottom:1px solid #f1f5f9;"><span style="font-size:13.5px;color:#94a3b8;">Email</span></td>
                      <td style="padding:13px 0 13px 16px;border-bottom:1px solid #f1f5f9;text-align:right;"><span style="font-size:13.5px;font-weight:700;color:#1e293b;">{{ $pendaftaran->email }}</span></td>
                    </tr>
                    <tr>
                      <td style="padding:13px 0;width:45%;"><span style="font-size:13.5px;color:#94a3b8;">No. WhatsApp</span></td>
                      <td style="padding:13px 0 13px 16px;text-align:right;"><span style="font-size:13.5px;font-weight:700;color:#1e293b;">{{ $pendaftaran->nomor_hp }}</span></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

            <!-- Calon Mempelai -->
            <p style="font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 14px;">Calon Mempelai</p>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
              <tr>
                <td width="48%" valign="top" style="padding-right:8px;">
                  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:14px;">
                    <tr><td style="padding:16px;text-align:center;"><p style="font-size:15px;font-weight:800;color:#1e293b;margin:0;">{{ $pendaftaran->nama_pria }}</p><p style="font-size:10px;color:#3b82f6;margin:4px 0 0;">Calon Pria</p></td></tr>
                  </table>
                </td>
                <td width="48%" valign="top" style="padding-left:8px;">
                  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#fdf2f8;border:1.5px solid #fbcfe8;border-radius:14px;">
                    <tr><td style="padding:16px;text-align:center;"><p style="font-size:15px;font-weight:800;color:#1e293b;margin:0;">{{ $pendaftaran->nama_wanita }}</p><p style="font-size:10px;color:#ec4899;margin:4px 0 0;">Calon Wanita</p></td></tr>
                  </table>
                </td>
              </tr>
            </table>

            <!-- Informasi Pembayaran -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1.5px solid #e9d5ff;border-radius:16px;overflow:hidden;margin-bottom:32px;">
              <tr>
                <td style="background:linear-gradient(135deg,#6d28d9,#7c3aed);padding:14px 22px;border-radius:14px 14px 0 0;">
                  <p style="color:#ffffff;font-size:13.5px;font-weight:700;margin:0;">💳 Informasi Pembayaran Pendaftaran</p>
                </td>
              </tr>
              <tr>
                <td style="background:#faf5ff;padding:16px 22px;">
                  <p style="font-size:13.5px;color:#1e293b;margin:0 0 8px;">Total yang harus dibayar: <strong style="color:#6d28d9;font-size:18px;">Rp 350.000</strong></p>
                  <p style="font-size:13px;color:#64748b;margin:0 0 16px;">Silakan selesaikan pembayaran melalui link berikut (QRIS / transfer):</p>
                  <a href="{{ config('app.url') }}/pembayaran/{{ $pendaftaran->id }}"
                     style="display:inline-block;background:linear-gradient(135deg,#6d28d9,#7c3aed);color:#ffffff;font-size:13px;font-weight:700;padding:12px 24px;border-radius:10px;text-decoration:none;">
                    Halaman Pembayaran →
                  </a>
                </td>
              </tr>
            </table>

            <!-- Akun Login (Email + Password) -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                   style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);border:1.5px solid #6ee7b7;border-radius:16px;margin-bottom:32px;">
              <tr>
                <td style="padding:24px;">
                  <p style="font-size:14px;font-weight:800;color:#065f46;margin:0 0 16px;">🔐 Akun Login Anda</p>
                  <p style="font-size:13px;color:#047857;margin:0 0 8px;">Sistem telah membuat akun untuk Anda. Gunakan data berikut untuk login:</p>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:rgba(255,255,255,0.7);border-radius:12px;margin:12px 0;">
                    <tr>
                      <td style="padding:14px 18px;">
                        <p style="margin:0 0 6px;font-size:12px;color:#047857;">Email login</p>
                        <p style="margin:0 0 14px;font-size:15px;font-weight:700;color:#1e293b;">{{ $pendaftaran->email }}</p>
                        <p style="margin:0 0 6px;font-size:12px;color:#047857;">Kata sandi</p>
                        <p style="margin:0;font-size:15px;font-weight:700;color:#1e293b;letter-spacing:1px;">{{ $password }}</p>
                      </td>
                    </tr>
                  </table>
                  <p style="font-size:12px;color:#065f46;margin:0 0 12px;">Simpan email ini untuk keperluan konfirmasi dan informasi kursus.</p>
                  <a href="{{ config('app.url') }}"
                     style="display:inline-block;background:linear-gradient(135deg,#059669,#10b981);color:#ffffff;font-size:13px;font-weight:700;padding:12px 28px;border-radius:10px;text-decoration:none;">
                    Kunjungi website kami →
                  </a>
                </td>
              </tr>
            </table>

            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">
              <tr><td style="border-top:1px solid #f1f5f9;font-size:0;">&nbsp;</td></tr>
            </table>

            <table width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td style="text-align:center;padding:0 20px;">
                  <p style="font-size:13px;color:#94a3b8;margin:0;line-height:1.6;">
                    <strong style="color:#64748b;">Biara Loresa SCJ</strong> &nbsp;·&nbsp; Kalimantan Timur, Indonesia
                  </p>
                  <p style="margin:8px 0 0;"><a href="{{ config('app.url') }}" style="color:#3949ab;font-size:13px;">{{ config('app.url') }}</a></p>
                </td>
              </tr>
            </table>

          </td>
        </tr>

        <!-- FOOTER -->
        <tr>
          <td style="background:#1e293b;border-radius:0 0 20px 20px;padding:28px 36px;text-align:center;">
            <p style="color:#ffffff;font-size:15px;font-weight:800;margin:0 0 6px;">✝ Biara Loresa SCJ</p>
            <p style="color:#94a3b8;font-size:12px;margin:0;">Email ini dikirim otomatis. Simpan untuk referensi akun dan pembayaran. &copy; {{ date('Y') }}</p>
          </td>
        </tr>

      </table>

    </td>
  </tr>
</table>

</body>
</html>
