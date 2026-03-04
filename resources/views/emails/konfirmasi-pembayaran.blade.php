<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran Kursus Pernikahan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f1f5f9; color: #334155; }
        .wrapper { max-width: 600px; margin: 32px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }

        /* Header */
        .header { background: linear-gradient(135deg, #1e2685 0%, #3d56f5 50%, #be185d 100%); padding: 40px 32px; text-align: center; }
        .header-icon { width: 64px; height: 64px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; margin-bottom: 6px; }
        .header p { color: rgba(255,255,255,0.85); font-size: 14px; }

        /* Body */
        .body { padding: 32px; }
        .greeting { font-size: 16px; color: #1e293b; margin-bottom: 8px; font-weight: 600; }
        .intro { font-size: 14px; color: #64748b; line-height: 1.7; margin-bottom: 24px; }

        /* Status Badge */
        .status-badge { text-align: center; margin-bottom: 28px; }
        .status-badge .badge { display: inline-flex; align-items: center; gap: 8px; background: #ecfdf5; color: #065f46; border: 1.5px solid #6ee7b7; border-radius: 50px; padding: 10px 20px; font-weight: 700; font-size: 15px; }
        .status-badge .badge .dot { width: 10px; height: 10px; background: #10b981; border-radius: 50%; animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }

        /* Info Box */
        .info-box { background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 24px; }
        .info-box-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #94a3b8; margin-bottom: 14px; }
        .info-row { display: flex; justify-content: space-between; align-items: flex-start; padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: 13.5px; gap: 12px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #64748b; flex-shrink: 0; }
        .info-value { color: #1e293b; font-weight: 600; text-align: right; }

        /* Couple Cards */
        .couple-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px; }
        .couple-card { border-radius: 12px; padding: 16px; }
        .couple-card.pria { background: #eff6ff; border: 1.5px solid #bfdbfe; }
        .couple-card.wanita { background: #fdf2f8; border: 1.5px solid #fbcfe8; }
        .couple-card .role { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px; }
        .couple-card.pria .role { color: #3b82f6; }
        .couple-card.wanita .role { color: #ec4899; }
        .couple-card .name { font-size: 14px; font-weight: 700; color: #1e293b; }

        /* Payment Summary */
        .payment-box { background: linear-gradient(135deg, #faf5ff, #f5f3ff); border: 1.5px solid #e9d5ff; border-radius: 12px; padding: 20px; margin-bottom: 24px; }
        .payment-box-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #94a3b8; margin-bottom: 14px; }
        .payment-row { display: flex; justify-content: space-between; font-size: 13.5px; padding: 6px 0; color: #64748b; }
        .payment-total { display: flex; justify-content: space-between; font-size: 16px; font-weight: 800; padding-top: 12px; margin-top: 6px; border-top: 2px solid #e9d5ff; color: #1e293b; }
        .payment-total .amount { color: #7c3aed; }

        /* Next Steps */
        .steps { background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 12px; padding: 20px; margin-bottom: 24px; }
        .steps-title { font-size: 13px; font-weight: 700; color: #92400e; margin-bottom: 12px; }
        .step-item { display: flex; gap: 12px; margin-bottom: 10px; font-size: 13px; color: #78350f; }
        .step-item:last-child { margin-bottom: 0; }
        .step-num { width: 22px; height: 22px; background: #f59e0b; border-radius: 50%; color: white; font-size: 11px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }

        /* CTA Button */
        .cta { text-align: center; margin-bottom: 28px; }
        .cta a { display: inline-block; background: linear-gradient(135deg, #1e2685, #3d56f5); color: #ffffff; text-decoration: none; font-weight: 700; font-size: 14px; padding: 14px 32px; border-radius: 12px; }

        /* Divider */
        .divider { border: none; border-top: 1px solid #f1f5f9; margin: 24px 0; }

        /* Contact */
        .contact { text-align: center; font-size: 13px; color: #94a3b8; line-height: 1.8; }
        .contact strong { color: #64748b; }

        /* Footer */
        .footer { background: #f8fafc; padding: 24px 32px; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer p { font-size: 12px; color: #94a3b8; line-height: 1.8; }
        .footer .footer-logo { font-size: 14px; font-weight: 700; color: #1e2685; margin-bottom: 4px; }

        @media (max-width: 480px) {
            .wrapper { margin: 0; border-radius: 0; }
            .body { padding: 24px 20px; }
            .couple-grid { grid-template-columns: 1fr; }
            .info-row { flex-direction: column; gap: 2px; }
            .info-value { text-align: left; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- HEADER --}}
    <div class="header">
        <div style="text-align:center;margin-bottom:16px">
            <div style="width:64px;height:64px;background:rgba(255,255,255,0.2);border-radius:50%;margin:0 auto;display:flex;align-items:center;justify-content:center">
                <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <h1>Pembayaran Dikonfirmasi!</h1>
        <p>Kursus Pernikahan · Biara Loresa SCJ</p>
    </div>

    {{-- BODY --}}
    <div class="body">

        <p class="greeting">Yth. {{ $pendaftaran->nama_pria }} &amp; {{ $pendaftaran->nama_wanita }},</p>
        <p class="intro">
            Kami dengan sukacita memberitahukan bahwa pembayaran pendaftaran Kursus Pernikahan
            Anda telah kami terima dan dikonfirmasi. Selamat datang dalam program persiapan
            sakramen pernikahan di Biara Loresa SCJ.
        </p>

        {{-- Status Badge --}}
        <div class="status-badge">
            <span class="badge">
                <span class="dot"></span>
                Pembayaran Berhasil
            </span>
        </div>

        {{-- Informasi Pendaftaran --}}
        <div class="info-box">
            <div class="info-box-title">Informasi Pendaftaran</div>
            <div class="info-row">
                <span class="info-label">No. Pendaftaran</span>
                <span class="info-value" style="color:#7c3aed">#{{ str_pad($pendaftaran->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Rencana Pernikahan</span>
                <span class="info-value">{{ $pendaftaran->tanggal_pernikahan->locale('id')->isoFormat('D MMMM YYYY') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tempat Pernikahan</span>
                <span class="info-value">{{ $pendaftaran->tempat_pernikahan }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $pendaftaran->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">No. WhatsApp</span>
                <span class="info-value">{{ $pendaftaran->nomor_hp }}</span>
            </div>
        </div>

        {{-- Calon Mempelai --}}
        <div class="couple-grid">
            <div class="couple-card pria">
                <div class="role">Calon Pria</div>
                <div class="name">{{ $pendaftaran->nama_pria }}</div>
            </div>
            <div class="couple-card wanita">
                <div class="role">Calon Wanita</div>
                <div class="name">{{ $pendaftaran->nama_wanita }}</div>
            </div>
        </div>

        {{-- Rincian Pembayaran --}}
        <div class="payment-box">
            <div class="payment-box-title">Rincian Pembayaran</div>
            <div class="payment-row">
                <span>Biaya Kursus Pernikahan</span>
                <span>Rp 300.000</span>
            </div>
            <div class="payment-row">
                <span>Biaya Administrasi &amp; Materi</span>
                <span>Rp 50.000</span>
            </div>
            <div class="payment-total">
                <span>Total Dibayar</span>
                <span class="amount">Rp 350.000</span>
            </div>
        </div>

        {{-- Langkah Selanjutnya --}}
        <div class="steps">
            <div class="steps-title">📋 Langkah Selanjutnya</div>
            <div class="step-item">
                <span class="step-num">1</span>
                <span>Tim kami akan menghubungi Anda melalui WhatsApp <strong>{{ $pendaftaran->nomor_hp }}</strong> untuk konfirmasi jadwal kursus.</span>
            </div>
            <div class="step-item">
                <span class="step-num">2</span>
                <span>Siapkan dokumen asli: KTP, Surat Baptis, dan Surat Pengantar Kombas untuk dibawa saat pelaksanaan kursus.</span>
            </div>
            <div class="step-item">
                <span class="step-num">3</span>
                <span>Hadir tepat waktu sesuai jadwal yang telah disepakati. Kursus dilaksanakan di Biara Loresa SCJ, Kalimantan Timur.</span>
            </div>
        </div>

        {{-- CTA --}}
        <div class="cta">
            <a href="{{ config('app.url') }}">Kunjungi Website Biara Loresa SCJ</a>
        </div>

        <hr class="divider">

        {{-- Kontak --}}
        <div class="contact">
            <strong>Ada pertanyaan?</strong><br>
            Hubungi kami melalui halaman kontak website<br>
            atau WhatsApp kami langsung.<br><br>
            <strong>Biara Loresa SCJ</strong><br>
            Kalimantan Timur, Indonesia
        </div>

    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <div class="footer-logo">Biara Loresa SCJ</div>
        <p>
            Email ini dikirim otomatis sebagai konfirmasi pembayaran.<br>
            Harap simpan email ini sebagai bukti pendaftaran Anda.<br><br>
            &copy; {{ date('Y') }} Biara Loresa SCJ · Kalimantan Timur
        </p>
    </div>

</div>
</body>
</html>
