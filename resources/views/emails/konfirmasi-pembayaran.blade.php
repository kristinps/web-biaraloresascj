<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Konfirmasi Pembayaran – Biara Loresa SCJ</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { background: #eef2ff; font-family: 'Helvetica Neue', Arial, sans-serif; color: #334155; -webkit-font-smoothing: antialiased; }
  img { border: 0; display: block; max-width: 100%; }
  a { text-decoration: none; }
  table { border-collapse: collapse; }

  .wrap { max-width: 600px; margin: 0 auto; padding: 32px 16px 48px; }

  /* ───── HEADER ───── */
  .hd {
    background: linear-gradient(135deg, #1a237e 0%, #3949ab 45%, #880e4f 100%);
    border-radius: 20px 20px 0 0;
    padding: 50px 40px 60px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  .hd-ring1 { position: absolute; top: -70px; right: -70px; width: 220px; height: 220px; border-radius: 50%; border: 45px solid rgba(255,255,255,.07); }
  .hd-ring2 { position: absolute; bottom: -90px; left: -60px; width: 240px; height: 240px; border-radius: 50%; border: 55px solid rgba(255,255,255,.05); }
  .hd-inner { position: relative; }
  .hd-icon {
    width: 76px; height: 76px;
    background: rgba(255,255,255,.2);
    border-radius: 50%;
    margin: 0 auto 22px;
    display: flex; align-items: center; justify-content: center;
  }
  .hd h1 { color: #fff; font-size: 26px; font-weight: 800; letter-spacing: -.3px; line-height: 1.3; }
  .hd .sub { color: rgba(255,255,255,.8); font-size: 14px; margin-top: 8px; letter-spacing: .2px; }
  .hd-badge {
    display: inline-flex; align-items: center; gap: 9px;
    background: rgba(255,255,255,.15);
    border: 1.5px solid rgba(255,255,255,.3);
    border-radius: 50px;
    padding: 9px 20px;
    margin-top: 24px;
  }
  .hd-badge .dot { width: 9px; height: 9px; background: #4ade80; border-radius: 50%; }
  .hd-badge span { color: #fff; font-size: 13px; font-weight: 700; letter-spacing: .1px; }

  /* ───── WAVE ───── */
  .wave-wrap { line-height: 0; background: #fff; }
  .wave-wrap svg { display: block; width: 100%; height: 28px; }

  /* ───── BODY ───── */
  .bd { background: #fff; padding: 40px 36px 36px; }

  .greeting { font-size: 18px; font-weight: 700; color: #1e293b; line-height: 1.4; margin-bottom: 12px; }
  .intro { font-size: 14px; color: #64748b; line-height: 1.9; margin-bottom: 36px; }
  .intro strong { color: #1e293b; }

  /* ───── SECTION LABEL ───── */
  .sec-label {
    font-size: 11px; font-weight: 800;
    text-transform: uppercase; letter-spacing: .1em;
    color: #94a3b8;
    margin-bottom: 14px;
  }

  /* ───── ORDER CARD ───── */
  .order-card { border: 1.5px solid #e2e8f0; border-radius: 16px; overflow: hidden; margin-bottom: 32px; }
  .order-hd {
    background: linear-gradient(135deg, #1a237e, #3949ab);
    padding: 16px 22px;
    display: flex; align-items: center; gap: 14px;
  }
  .order-hd .ico {
    width: 38px; height: 38px;
    background: rgba(255,255,255,.2);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .order-hd-text h3 { color: #fff; font-size: 14px; font-weight: 700; line-height: 1.4; }
  .order-hd-text p  { color: rgba(255,255,255,.72); font-size: 12px; margin-top: 2px; line-height: 1.4; }
  .order-body { padding: 6px 22px 10px; }
  .info-row {
    display: flex; justify-content: space-between; align-items: baseline;
    padding: 11px 0;
    border-bottom: 1px solid #f1f5f9;
    gap: 16px;
    font-size: 13.5px;
  }
  .info-row:last-child { border-bottom: none; }
  .lbl { color: #94a3b8; flex-shrink: 0; line-height: 1.5; }
  .val { color: #1e293b; font-weight: 600; text-align: right; line-height: 1.5; }
  .val.accent { color: #3949ab; }
  .val.green   { color: #16a34a; }

  /* ───── COUPLE ───── */
  .couple-wrap { margin-bottom: 32px; }
  .couple-tbl { width: 100%; border-spacing: 0; }
  .couple-tbl td { width: 50%; vertical-align: top; }
  .couple-tbl td:first-child { padding-right: 8px; }
  .couple-tbl td:last-child  { padding-left:  8px; }
  .c-card { border-radius: 14px; padding: 20px 16px; text-align: center; }
  .c-card.pria   { background: linear-gradient(135deg,#eff6ff,#dbeafe); border: 1.5px solid #bfdbfe; }
  .c-card.wanita { background: linear-gradient(135deg,#fdf2f8,#fce7f3); border: 1.5px solid #fbcfe8; }
  .c-card .emoji { font-size: 26px; margin-bottom: 10px; line-height: 1; }
  .c-card .role  { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .1em; margin-bottom: 6px; line-height: 1.4; }
  .c-card.pria   .role { color: #3b82f6; }
  .c-card.wanita .role { color: #ec4899; }
  .c-card .name  { font-size: 15px; font-weight: 800; color: #1e293b; line-height: 1.4; }

  /* ───── PAYMENT BOX ───── */
  .pay-box { border: 1.5px solid #e9d5ff; border-radius: 16px; overflow: hidden; margin-bottom: 32px; }
  .pay-hd  {
    background: linear-gradient(135deg, #6d28d9, #7c3aed);
    padding: 14px 22px;
    display: flex; align-items: center; gap: 12px;
  }
  .pay-hd span { color: #fff; font-size: 13.5px; font-weight: 700; line-height: 1.4; }
  .pay-rows { padding: 4px 22px 8px; background: #faf5ff; }
  .pay-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 11px 0;
    border-bottom: 1px dashed #ede9fe;
    font-size: 13.5px;
    gap: 16px;
  }
  .pay-row:last-child { border-bottom: none; }
  .pay-row .desc { color: #6b7280; line-height: 1.5; }
  .pay-row .price { color: #4c1d95; font-weight: 600; flex-shrink: 0; line-height: 1.5; }
  .pay-total {
    display: flex; justify-content: space-between; align-items: center;
    padding: 16px 22px;
    background: linear-gradient(135deg, #ede9fe, #faf5ff);
    border-top: 2px solid #ddd6fe;
    gap: 16px;
  }
  .pay-total .tot-lbl   { font-size: 14px; font-weight: 700; color: #4c1d95; line-height: 1.4; }
  .pay-total .tot-amount { font-size: 24px; font-weight: 900; color: #6d28d9; line-height: 1.3; }

  /* ───── STEPS ───── */
  .steps-box { background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 16px; padding: 24px 24px 20px; margin-bottom: 32px; }
  .steps-title { font-size: 14px; font-weight: 800; color: #92400e; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; line-height: 1.4; }
  .step { display: flex; gap: 16px; margin-bottom: 18px; align-items: flex-start; }
  .step:last-child { margin-bottom: 0; }
  .step-num {
    min-width: 30px; height: 30px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 13px; font-weight: 800;
    flex-shrink: 0; margin-top: 1px;
  }
  .step-text { font-size: 13.5px; color: #78350f; line-height: 1.8; padding-top: 4px; }
  .step-text strong { color: #92400e; }

  /* ───── CTA ───── */
  .cta-wrap { text-align: center; margin-bottom: 36px; }
  .cta-btn {
    display: inline-block;
    background: linear-gradient(135deg, #1a237e, #3949ab);
    color: #fff !important;
    font-size: 14px; font-weight: 700;
    padding: 16px 40px;
    border-radius: 12px;
    letter-spacing: .3px;
    line-height: 1.4;
  }

  /* ───── DIVIDER ───── */
  .divider { border: none; border-top: 1px solid #f1f5f9; margin: 0 0 28px; }

  /* ───── CONTACT ───── */
  .contact { text-align: center; font-size: 13.5px; color: #94a3b8; line-height: 2.1; }
  .contact strong { color: #64748b; }
  .contact a { color: #3949ab; font-weight: 600; }

  /* ───── FOOTER ───── */
  .ft { background: #1e293b; border-radius: 0 0 20px 20px; padding: 32px 36px; text-align: center; }
  .ft-logo { font-size: 16px; font-weight: 800; color: #fff; margin-bottom: 8px; letter-spacing: .2px; }
  .ft-loc  { font-size: 13px; color: #94a3b8; margin-bottom: 4px; line-height: 1.7; }
  .ft-link { font-size: 13px; color: #64748b; margin-bottom: 20px; }
  .ft-link a { color: #7c9fdb; }
  .ft-copy { font-size: 11.5px; color: #475569; line-height: 1.8; }

  @media (max-width: 480px) {
    .wrap { padding: 16px 8px 40px; }
    .hd   { padding: 36px 24px 48px; }
    .bd   { padding: 32px 24px 28px; }
    .ft   { padding: 28px 24px; }
    .couple-tbl td:first-child { padding-right: 5px; }
    .couple-tbl td:last-child  { padding-left:  5px; }
  }
</style>
</head>
<body>
<div class="wrap">

  {{-- ═══ HEADER ═══ --}}
  <div class="hd">
    <div class="hd-ring1"></div>
    <div class="hd-ring2"></div>
    <div class="hd-inner">

      <div class="hd-icon">
        <svg width="36" height="36" fill="none" stroke="white" stroke-width="2.2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>

      <h1>Pembayaran Dikonfirmasi!</h1>
      <p class="sub">Kursus Pernikahan &nbsp;·&nbsp; Biara Loresa SCJ</p>

      <div class="hd-badge">
        <span class="dot"></span>
        <span>Pembayaran Berhasil &amp; Terverifikasi</span>
      </div>

    </div>
  </div>

  {{-- Wave --}}
  <div class="wave-wrap">
    <svg viewBox="0 0 600 28" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
      <defs>
        <linearGradient id="wg" x1="0%" y1="0%" x2="100%" y2="0%">
          <stop offset="0%"   stop-color="#1a237e"/>
          <stop offset="50%"  stop-color="#3949ab"/>
          <stop offset="100%" stop-color="#880e4f"/>
        </linearGradient>
      </defs>
      <path d="M0,0 C150,28 450,28 600,0 L600,0 L0,0 Z" fill="url(#wg)"/>
    </svg>
  </div>

  {{-- ═══ BODY ═══ --}}
  <div class="bd">

    <p class="greeting">Yth. {{ $pendaftaran->nama_pria }} &amp; {{ $pendaftaran->nama_wanita }},</p>

    <p class="intro">
      Dengan penuh sukacita kami sampaikan bahwa pembayaran pendaftaran
      <strong>Kursus Pernikahan</strong> Anda telah diterima dan dikonfirmasi.
      Selamat datang dalam program persiapan Sakramen Pernikahan di
      <strong>Biara Loresa SCJ</strong>, Kalimantan Timur.
    </p>

    {{-- Detail Pendaftaran --}}
    <div class="order-card">
      <div class="order-hd">
        <div class="ico">
          <svg width="18" height="18" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
        </div>
        <div class="order-hd-text">
          <h3>Detail Pendaftaran</h3>
          <p>Simpan email ini sebagai bukti resmi</p>
        </div>
      </div>
      <div class="order-body">
        <div class="info-row">
          <span class="lbl">Nomor Pendaftaran</span>
          <span class="val accent">#{{ str_pad($pendaftaran->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="info-row">
          <span class="lbl">Tanggal Pernikahan</span>
          <span class="val">{{ $pendaftaran->tanggal_pernikahan->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
        </div>
        <div class="info-row">
          <span class="lbl">Tempat Pernikahan</span>
          <span class="val">{{ $pendaftaran->tempat_pernikahan }}</span>
        </div>
        <div class="info-row">
          <span class="lbl">Email</span>
          <span class="val">{{ $pendaftaran->email }}</span>
        </div>
        <div class="info-row">
          <span class="lbl">No. WhatsApp</span>
          <span class="val">{{ $pendaftaran->nomor_hp }}</span>
        </div>
        <div class="info-row">
          <span class="lbl">Status Pembayaran</span>
          <span class="val green">✓ &nbsp;Lunas</span>
        </div>
      </div>
    </div>

    {{-- Calon Mempelai --}}
    <p class="sec-label">Calon Mempelai</p>
    <div class="couple-wrap">
      <table class="couple-tbl" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <div class="c-card pria">
              <div class="emoji">💙</div>
              <div class="role">Calon Pria</div>
              <div class="name">{{ $pendaftaran->nama_pria }}</div>
            </div>
          </td>
          <td>
            <div class="c-card wanita">
              <div class="emoji">🌸</div>
              <div class="role">Calon Wanita</div>
              <div class="name">{{ $pendaftaran->nama_wanita }}</div>
            </div>
          </td>
        </tr>
      </table>
    </div>

    {{-- Rincian Pembayaran --}}
    <div class="pay-box">
      <div class="pay-hd">
        <svg width="18" height="18" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
        </svg>
        <span>Rincian Pembayaran</span>
      </div>
      <div class="pay-rows">
        <div class="pay-row">
          <span class="desc">Biaya Kursus Pernikahan</span>
          <span class="price">Rp 300.000</span>
        </div>
        <div class="pay-row">
          <span class="desc">Biaya Administrasi &amp; Materi</span>
          <span class="price">Rp 50.000</span>
        </div>
      </div>
      <div class="pay-total">
        <span class="tot-lbl">Total Dibayar</span>
        <span class="tot-amount">Rp 350.000</span>
      </div>
    </div>

    {{-- Langkah Selanjutnya --}}
    <div class="steps-box">
      <div class="steps-title">
        <span>📋</span>
        <span>Langkah Selanjutnya</span>
      </div>

      <div class="step">
        <div class="step-num">1</div>
        <p class="step-text">
          Tim kami akan menghubungi Anda melalui WhatsApp
          <strong>{{ $pendaftaran->nomor_hp }}</strong>
          untuk konfirmasi jadwal dan lokasi pelaksanaan kursus.
        </p>
      </div>

      <div class="step">
        <div class="step-num">2</div>
        <p class="step-text">
          Siapkan dokumen <strong>asli dan fotokopi</strong> :
          KTP, Surat Baptis, dan Surat Pengantar Kombas
          untuk diserahkan saat pelaksanaan kursus.
        </p>
      </div>

      <div class="step">
        <div class="step-num">3</div>
        <p class="step-text">
          Hadir <strong>tepat waktu</strong> sesuai jadwal yang telah disepakati.
          Kursus dilaksanakan di <strong>Biara Loresa SCJ, Kalimantan Timur</strong>.
        </p>
      </div>
    </div>

    {{-- CTA --}}
    <div class="cta-wrap">
      <a href="{{ config('app.url') }}" class="cta-btn">
        🌐 &nbsp; Kunjungi Website Biara Loresa SCJ
      </a>
    </div>

    <hr class="divider">

    <div class="contact">
      <strong>Ada pertanyaan?</strong><br><br>
      Kunjungi halaman kontak kami di :<br>
      <a href="{{ config('app.url') }}/kontak">{{ config('app.url') }}/kontak</a>
      <br><br>
      <strong>Biara Loresa SCJ</strong> &nbsp;·&nbsp; Kalimantan Timur, Indonesia
    </div>

  </div>

  {{-- ═══ FOOTER ═══ --}}
  <div class="ft">
    <div class="ft-logo">✝ &nbsp; Biara Loresa SCJ</div>
    <div class="ft-loc">Kalimantan Timur, Indonesia</div>
    <div class="ft-link">
      <a href="{{ config('app.url') }}">biaraloresa.my.id</a>
    </div>
    <div class="ft-copy">
      Email ini dikirim secara otomatis sebagai konfirmasi pembayaran.<br>
      Harap simpan email ini sebagai bukti resmi pendaftaran Anda.<br>
      &copy; {{ date('Y') }} &nbsp; Biara Loresa SCJ &nbsp;·&nbsp; Semua hak dilindungi.
    </div>
  </div>

</div>
</body>
</html>
