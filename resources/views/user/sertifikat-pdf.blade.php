<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Kelulusan — {{ $pendaftaran->nama_pria }} & {{ $pendaftaran->nama_wanita }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #1e293b; }
        .page { width: 210mm; min-height: 297mm; padding: 24mm; margin: 0 auto; }
        .border { border: 3px solid #6366f1; border-radius: 8px; padding: 20mm; min-height: 240mm; position: relative; }
        .header { text-align: center; margin-bottom: 28px; }
        .org { font-size: 14px; color: #64748b; margin-bottom: 4px; }
        .brand { font-size: 22px; font-weight: bold; color: #1e293b; }
        .sub { font-size: 11px; color: #94a3b8; margin-top: 2px; }
        .title { text-align: center; margin: 32px 0 24px; }
        .title h1 { font-size: 20px; font-weight: bold; color: #4f46e5; letter-spacing: 1px; }
        .title p { font-size: 12px; color: #64748b; margin-top: 6px; }
        .nama { text-align: center; margin: 28px 0; padding: 16px 0; border-bottom: 2px solid #e2e8f0; border-top: 2px solid #e2e8f0; }
        .nama span { font-size: 22px; font-weight: bold; color: #1e293b; }
        .detail { text-align: center; font-size: 13px; color: #475569; line-height: 1.8; margin-bottom: 24px; }
        .footer { position: absolute; bottom: 20mm; left: 20mm; right: 20mm; text-align: center; font-size: 11px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="page">
        <div class="border">
            <div class="header">
                <div class="org">Serikat Imam-imam Hati Kudus Yesus</div>
                <div class="brand">Biara Loresa SCJ</div>
                <div class="sub">Kursus Persiapan Pernikahan</div>
            </div>
            <div class="title">
                <h1>SERTIFIKAT KELULUSAN</h1>
                <p>Diberikan kepada peserta yang telah menyelesaikan Kursus Persiapan Pernikahan dengan memenuhi syarat kehadiran</p>
            </div>
            <div class="nama">
                <span>{{ $pendaftaran->nama_pria }} &amp; {{ $pendaftaran->nama_wanita }}</span>
            </div>
            <div class="detail">
                <p>Periode: <strong>{{ $pendaftaran->periode ? $pendaftaran->periode->nama : '—' }}</strong></p>
                @if($pendaftaran->tanggal_pernikahan)
                <p>Tanggal pernikahan: {{ $pendaftaran->tanggal_pernikahan->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                @endif
            </div>
            <div class="footer">
                Diterbitkan oleh Biara Loresa SCJ · Sertifikat ini sah sebagai bukti kelulusan kursus pernikahan.
            </div>
        </div>
    </div>
</body>
</html>
