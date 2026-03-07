@extends('user.layouts.app')

@section('title', 'Biaya Pendaftaran')
@section('page-title', 'Biaya Pendaftaran')
@section('page-subtitle', 'Informasi biaya dan cara pembayaran kursus pernikahan')

@push('styles')
<style>
    .card { background:#fff; border-radius:16px; border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,0.04); overflow:hidden; margin-bottom:20px; }
    .card-body { padding:24px; }
    .price-box { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border-radius:16px; padding:28px; text-align:center; margin-bottom:24px; }
    .price-box .amount { font-size:36px; font-weight:800; }
    .price-box .label { font-size:14px; opacity:0.9; margin-top:4px; }
    .list { list-style:none; padding:0; margin:0; }
    .list li { padding:10px 0; border-bottom:1px solid #f1f5f9; display:flex; align-items:flex-start; gap:10px; font-size:14px; color:#374151; }
    .list li:last-child { border-bottom:none; }
    .list li::before { content:'✓'; color:#22c55e; font-weight:700; }
    .info-section h3 { font-size:15px; font-weight:700; color:#1e293b; margin-bottom:10px; }
    .info-section p { font-size:14px; color:#64748b; line-height:1.6; margin:0 0 16px; }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <div class="price-box">
            <div class="amount">Rp 350.000</div>
            <div class="label">/ pasang (termasuk modul)</div>
        </div>
        <div class="info-section">
            <h3>Yang termasuk</h3>
            <ul class="list">
                <li>Modul kursus pernikahan</li>
                <li>Materi dan sesi kursus selama 3 hari (Jumat–Minggu)</li>
                <li>Lokasi: Biara Loresa SCJ, Kecamatan Damai</li>
            </ul>
        </div>
        <div class="info-section">
            <h3>Cara pembayaran</h3>
            <p>Setelah mendaftar, Anda akan mendapat tautan pembayaran (QRIS). Pembayaran dapat dilakukan via GoPay, OVO, DANA, ShopeePay, atau transfer bank. Setelah pembayaran berhasil, status akan otomatis berubah menjadi <strong>Lunas</strong> di dashboard.</p>
        </div>
        <div class="info-section">
            <h3>Pendaftaran</h3>
            <p>Minimal 2 bulan sebelum tanggal pernikahan. Untuk mendaftar, gunakan menu <a href="{{ route('kursus-pernikahan') }}" style="color:#6366f1;font-weight:600;text-decoration:none">Daftar Kursus Pernikahan</a> atau dari halaman <a href="{{ route('kursus-pernikahan') }}" style="color:#6366f1;font-weight:600;text-decoration:none">Daftar Kursus Pernikahan</a>.</p>
        </div>
    </div>
</div>
@endsection
