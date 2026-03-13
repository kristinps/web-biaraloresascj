@extends('layouts.app')
@section('title', 'Pembayaran Berhasil - Kursus Pernikahan')

@section('content')
<section class="dashboard-banner-wrap sukses-page home-enter" data-home-animate>
    <div class="dashboard-banner-inner sukses-inner">
        <header class="dashboard-user-header sukses-header">
            <h1 class="dashboard-user-title">Pembayaran &amp; Pendaftaran Berhasil</h1>
            <p class="sukses-subtitle">Kursus Pernikahan — Biara Loresa SCJ</p>
        </header>

        @if(session('error'))
        <div class="toast toast-error mb-4">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
            <a href="{{ route('pembayaran.show', $pendaftaran->id) }}" class="ml-2 underline font-semibold">Coba Bayar Sekarang</a>
        </div>
        @endif
        @if(session('success'))
        <div class="toast toast-success mb-4">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        {{-- Kartu ringkasan (style admin stat) --}}
        <div class="admin-stats-grid sukses-stats home-enter" data-home-animate data-delay="2">
            <div class="admin-stat-card card">
                <div class="admin-stat-icon admin-stat-icon-period" aria-hidden="true"></div>
                <div class="admin-stat-body">
                    <span class="admin-stat-label">Status</span>
                    <span class="admin-stat-value">{{ $pendaftaran->status_pembayaran === 'lunas' ? 'Lunas' : ucfirst($pendaftaran->status_pembayaran) }}</span>
                </div>
            </div>
            <div class="admin-stat-card card">
                <div class="admin-stat-icon admin-stat-icon-done" aria-hidden="true"></div>
                <div class="admin-stat-body">
                    <span class="admin-stat-label">Total Pembayaran</span>
                    <span class="admin-stat-value">Rp {{ number_format(350000, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="admin-stat-card card">
                <div class="admin-stat-icon admin-stat-icon-active" aria-hidden="true"></div>
                <div class="admin-stat-body">
                    <span class="admin-stat-label">No. Invoice</span>
                    <span class="admin-stat-value sukses-invoice">{{ $pendaftaran->midtrans_order_id ?: 'KURSUS-' . $pendaftaran->id . '-' . $pendaftaran->created_at->timestamp }}</span>
                </div>
            </div>
        </div>

        {{-- Data Calon Pria & Calon Wanita --}}
        <div class="admin-charts-grid sukses-cards-grid home-enter" data-home-animate data-delay="3">
            <div class="admin-chart-card card sukses-bio-card">
                <h2 class="admin-chart-title">Calon Pria</h2>
                <div class="sukses-bio-list">
                    <div class="sukses-bio-row"><span class="sukses-bio-label">Nama</span><span class="sukses-bio-value">{{ $pendaftaran->nama_pria }}</span></div>
                    <div class="sukses-bio-row"><span class="sukses-bio-label">Tempat, Tanggal Lahir</span><span class="sukses-bio-value">{{ $pendaftaran->tempat_lahir_pria }}, {{ $pendaftaran->tanggal_lahir_pria ? $pendaftaran->tanggal_lahir_pria->translatedFormat('d F Y') : '-' }}</span></div>
                    <div class="sukses-bio-row"><span class="sukses-bio-label">NIK</span><span class="sukses-bio-value">{{ $pendaftaran->nik_pria ?? '-' }}</span></div>
                    <div class="sukses-bio-row"><span class="sukses-bio-label">Agama</span><span class="sukses-bio-value">{{ $pendaftaran->agama_pria ?? '-' }}</span></div>
                    <div class="sukses-bio-row"><span class="sukses-bio-label">Pekerjaan</span><span class="sukses-bio-value">{{ $pendaftaran->pekerjaan_pria ?? '-' }}</span></div>
                    <div class="sukses-bio-row"><span class="sukses-bio-label">Alamat</span><span class="sukses-bio-value">{{ $pendaftaran->alamat_pria ?? '-' }}</span></div>
                    <div class="sukses-bio-row"><span class="sukses-bio-label">Nama Ayah / Ibu</span><span class="sukses-bio-value">{{ $pendaftaran->nama_ayah_pria ?? '-' }} / {{ $pendaftaran->nama_ibu_pria ?? '-' }}</span></div>
                </div>
            </div>
            <div class="admin-chart-card card sukses-bio-card">
                <h2 class="admin-chart-title">Calon Wanita</h2>
                <div class="sukses-bio-list">
                    <div class="sukses-bio-row"><span class="sukses-bio-label">Nama</span><span class="sukses-bio-value">{{ $pendaftaran->nama_wanita }}</span></div>
                    <div class="sukses-bio-row"><span class="sukses-bio-label">Tempat, Tanggal Lahir</span><span class="sukses-bio-value">{{ $pendaftaran->tempat_lahir_wanita }}, {{ $pendaftaran->tanggal_lahir_wanita ? $pendaftaran->tanggal_lahir_wanita->translatedFormat('d F Y') : '-' }}</span></div>
                    <div class="sukses-bio-row"><span class="sukses-bio-label">NIK</span><span class="sukses-bio-value">{{ $pendaftaran->nik_wanita ?? '-' }}</span></div>
                    <div class="sukses-bio-row"><span class="sukses-bio-label">Agama</span><span class="sukses-bio-value">{{ $pendaftaran->agama_wanita ?? '-' }}</span></div>
                    <div class="sukses-bio-row"><span class="sukses-bio-label">Pekerjaan</span><span class="sukses-bio-value">{{ $pendaftaran->pekerjaan_wanita ?? '-' }}</span></div>
                    <div class="sukses-bio-row"><span class="sukses-bio-label">Alamat</span><span class="sukses-bio-value">{{ $pendaftaran->alamat_wanita ?? '-' }}</span></div>
                    <div class="sukses-bio-row"><span class="sukses-bio-label">Nama Ayah / Ibu</span><span class="sukses-bio-value">{{ $pendaftaran->nama_ayah_wanita ?? '-' }} / {{ $pendaftaran->nama_ibu_wanita ?? '-' }}</span></div>
                </div>
            </div>
        </div>

        {{-- Data Pembayaran & Sukses --}}
        <div class="admin-chart-card card admin-chart-card-full sukses-payment-card home-enter" data-home-animate data-delay="4">
            <h2 class="admin-chart-title">Data Pembayaran</h2>
            <div class="sukses-payment-grid">
                <div class="sukses-payment-item">
                    <span class="sukses-bio-label">No. Invoice</span>
                    <span class="sukses-bio-value font-mono">{{ $pendaftaran->midtrans_order_id ?: 'KURSUS-' . $pendaftaran->id . '-' . $pendaftaran->created_at->timestamp }}</span>
                </div>
                <div class="sukses-payment-item">
                    <span class="sukses-bio-label">Tanggal</span>
                    <span class="sukses-bio-value">{{ $pendaftaran->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                </div>
                <div class="sukses-payment-item">
                    <span class="sukses-bio-label">Total Pembayaran</span>
                    <span class="sukses-bio-value sukses-amount">Rp {{ number_format(350000, 0, ',', '.') }}</span>
                </div>
                <div class="sukses-payment-item">
                    <span class="sukses-bio-label">Status</span>
                    @if($pendaftaran->status_pembayaran === 'lunas')
                    <span class="sukses-badge sukses-badge-lunas">Lunas</span>
                    @elseif($pendaftaran->status_pembayaran === 'menunggu')
                    <span class="sukses-badge sukses-badge-wait">Menunggu</span>
                    @else
                    <span class="sukses-badge sukses-badge-default">Belum Bayar</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Informasi login: email & password dikirim, harap ubah kata sandi --}}
        <div class="admin-chart-card card admin-chart-card-full sukses-email-card home-enter" data-home-animate data-delay="5">
            <h2 class="admin-chart-title">Informasi Akun</h2>
            <div class="sukses-email-box">
                <p class="sukses-email-text">
                    <strong>Email dan kata sandi telah dikirim ke alamat email Anda ({{ $pendaftaran->email }}).</strong>
                    Silakan cek inbox (dan folder spam) untuk informasi login. Setelah login, <strong>harap segera mengubah kata sandi</strong> melalui menu Profil di dashboard.
                </p>
            </div>
        </div>

        {{-- CTA: Satu klik ke Dashboard User --}}
        <div class="sukses-cta-wrap home-enter" data-home-animate data-delay="6">
            <a href="{{ route('dashboard.user') }}" class="sukses-cta-btn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Masuk ke Dashboard
            </a>
            <p class="sukses-cta-hint">Satu klik untuk masuk ke dashboard peserta. Jika belum login, Anda akan diarahkan ke halaman login terlebih dahulu.</p>
            <a href="{{ route('home') }}" class="sukses-link-home">Kembali ke Beranda</a>
        </div>
    </div>
</section>

@push('styles')
<style>
.sukses-page.dashboard-banner-wrap {
    min-height: 100vh;
    position: relative;
    margin: 0;
    padding: 28px;
    overflow-x: hidden;
    overflow-y: auto;
}
.sukses-page.dashboard-banner-wrap::before,
.sukses-page.dashboard-banner-wrap::after { display:none; }
.sukses-inner { position: relative; z-index: 2; max-width: 960px; margin: 0 auto; }
.sukses-header { margin-bottom: 1.5rem; }
.sukses-header .dashboard-user-title { color: #ffffff; font-size: 1.5rem; }
.sukses-subtitle { color: rgba(255,255,255,0.85); font-size: 0.875rem; margin-top: 0.25rem; }
.admin-dashboard-content .dashboard-user-title,
.admin-dashboard-content .dashboard-user-header { color: #ffffff; }
.admin-stats-grid.sukses-stats {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1rem;
    margin-bottom: 1.75rem;
}
.admin-stat-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: linear-gradient(135deg,
        rgba(99,102,241,0.14),
        rgba(139,92,246,0.10),
        rgba(56,189,248,0.08)
    );
    border: 1px solid rgba(148,163,184,0.5);
    box-shadow: 0 8px 24px rgba(15,23,42,0.08);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
.admin-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    flex-shrink: 0;
}
.admin-stat-icon-period { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.admin-stat-icon-done { background: linear-gradient(135deg, #10b981, #059669); }
.admin-stat-icon-active { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.admin-stat-body { display: flex; flex-direction: column; gap: 0.25rem; min-width: 0; }
.admin-stat-label { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; color: #ffffff; }
.admin-stat-value { font-size: 1.25rem; font-weight: 700; color: #ffffff; line-height: 1.2; }
.admin-stat-value.sukses-invoice { font-size: 0.7rem; word-break: break-all; }
.admin-charts-grid.sukses-cards-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.25rem;
}
.admin-chart-card {
    padding: 1.25rem;
    background: linear-gradient(135deg,
        rgba(99,102,241,0.14),
        rgba(139,92,246,0.10),
        rgba(56,189,248,0.08)
    );
    border: 1px solid rgba(148,163,184,0.5);
    box-shadow: 0 8px 24px rgba(15,23,42,0.08);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
.admin-chart-card-full { grid-column: 1 / -1; }
.admin-chart-title { font-size: 0.95rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem; }
.sukses-bio-card .admin-chart-title { margin-bottom: 0.75rem; }
.sukses-bio-list { display: flex; flex-direction: column; gap: 0.5rem; }
.sukses-bio-row { display: flex; flex-direction: column; gap: 0.15rem; }
.sukses-bio-label { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; color: rgba(255,255,255,0.7); }
.sukses-bio-value { font-size: 0.875rem; color: #ffffff; }
.sukses-payment-card .sukses-payment-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}
.sukses-payment-item { display: flex; flex-direction: column; gap: 0.2rem; }
.sukses-amount { font-weight: 700; color: #86efac !important; }
.sukses-badge { display: inline-flex; align-items: center; padding: 0.25rem 0.6rem; border-radius: 8px; font-size: 0.75rem; font-weight: 600; width: fit-content; }
.sukses-badge-lunas { background: rgba(16,185,129,0.3); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.5); }
.sukses-badge-wait { background: rgba(245,158,11,0.3); color: #fcd34d; border: 1px solid rgba(245,158,11,0.5); }
.sukses-badge-default { background: rgba(148,163,184,0.3); color: #e2e8f0; border: 1px solid rgba(148,163,184,0.5); }
.sukses-email-card { margin-bottom: 1.25rem; }
.sukses-email-box { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.35); border-radius: 12px; padding: 1rem 1.25rem; }
.sukses-email-text { color: #ffffff; font-size: 0.9rem; line-height: 1.5; margin: 0; }
.sukses-cta-wrap { text-align: center; padding: 1.5rem 0; }
.sukses-cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.75rem;
    background: linear-gradient(135deg, #ffffff 0%, #f0f4ff 100%);
    color: #1e2685;
    font-weight: 700;
    font-size: 1rem;
    border-radius: 12px;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    transition: transform 0.2s, box-shadow 0.2s;
}
.sukses-cta-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,0.2); color: #1e2685; }
.sukses-cta-hint { color: rgba(255,255,255,0.85); font-size: 0.8rem; margin-top: 0.75rem; }
.sukses-link-home { color: rgba(255,255,255,0.8); font-size: 0.85rem; margin-top: 0.5rem; display: inline-block; text-decoration: none; }
.sukses-link-home:hover { color: #fff; text-decoration: underline; }
@media (max-width: 768px) {
    .admin-stats-grid.sukses-stats { grid-template-columns: 1fr; }
    .admin-charts-grid.sukses-cards-grid { grid-template-columns: 1fr; }
    .sukses-payment-card .sukses-payment-grid { grid-template-columns: 1fr; }
}
</style>
@endpush
@endsection
