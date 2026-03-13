@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'layouts.dashboard')

@section('title', 'Status Pendaftaran')
@section('page-title', 'Status Pendaftaran')
@section('page-subtitle', 'Status tiap pendaftaran kursus pernikahan Anda')

@push('styles')
<style>
    .status-pendaftaran-wrap {
        position: relative;
        width: 100%;
        min-height: calc(100vh - 120px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    .status-pendaftaran-wrap .status-pendaftaran-inner {
        width: 100%;
        max-width: 920px;
    }
    /* Main card - glassmorphism, tidak tempel background */
    .status-pendaftaran-wrap .card {
        position: relative;
        background: linear-gradient(135deg, rgba(255,255,255,0.92) 0%, rgba(248,250,255,0.88) 50%, rgba(240,245,255,0.9) 100%);
        border-radius: 24px;
        border: 1px solid rgba(255,255,255,0.6);
        box-shadow: 0 12px 40px rgba(30,41,59,0.12), 0 4px 16px rgba(99,102,241,0.08);
        overflow: hidden;
        backdrop-filter: blur(16px);
    }
    .status-pendaftaran-wrap .card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image:
            radial-gradient(circle at 15% 20%, rgba(255,255,255,0.5) 0%, transparent 10%),
            radial-gradient(circle at 85% 80%, rgba(147,197,253,0.12) 0%, transparent 12%),
            radial-gradient(circle at 70% 15%, rgba(255,255,255,0.35) 0%, transparent 8%);
        pointer-events: none;
    }
    /* Header */
    .status-pendaftaran-wrap .card-header {
        position: relative;
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 26px 28px;
        border-bottom: 1px solid rgba(226,232,240,0.8);
    }
    .status-pendaftaran-wrap .card-header-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(145deg, #3b82f6, #2563eb);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 8px 24px rgba(37,99,235,0.35);
    }
    .status-pendaftaran-wrap .card-header-icon svg { width: 26px; height: 26px; color: #fff; }
    .status-pendaftaran-wrap .card-header h2 { font-size: 1.35rem; font-weight: 700; color: #1e293b; margin: 0; letter-spacing: -0.02em; }
    .status-pendaftaran-wrap .card-header p { font-size: 13px; color: #64748b; margin-top: 2px; }
    /* List: couple blocks - dalam card */
    .status-pendaftaran-wrap .card-list {
        position: relative;
        padding: 24px 28px 32px;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    /* Couple block: two cards + rings + badge */
    .status-pendaftaran-wrap .couple-block {
        display: flex;
        align-items: stretch;
        justify-content: center;
        gap: 0;
        flex-wrap: wrap;
        position: relative;
        width: 100%;
        max-width: 920px;
        margin: 0 auto;
    }
    /* Person card - glassmorphism */
    .status-pendaftaran-wrap .person-card {
        flex: 1;
        min-width: 280px;
        width: 320px;
        max-width: 380px;
        padding: 26px 24px;
        border-radius: 20px;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,0.4);
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .status-pendaftaran-wrap .person-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 48px rgba(0,0,0,0.2);
    }
    .status-pendaftaran-wrap .person-card.person-card-male {
        background: linear-gradient(145deg, rgba(147,197,253,0.85) 0%, rgba(96,165,250,0.75) 50%, rgba(59,130,246,0.7) 100%);
    }
    .status-pendaftaran-wrap .person-card.person-card-female {
        background: linear-gradient(145deg, rgba(251,207,232,0.9) 0%, rgba(249,168,212,0.8) 50%, rgba(236,72,153,0.7) 100%);
    }
    /* Person card content */
    .status-pendaftaran-wrap .person-card-body {
        display: flex;
        align-items: center;
        gap: 18px;
    }
    .status-pendaftaran-wrap .person-card-icon-wrap {
        flex-shrink: 0;
        position: relative;
    }
    .status-pendaftaran-wrap .person-card-icon,
    .status-pendaftaran-wrap .person-card-photo {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        overflow: hidden;
        flex-shrink: 0;
    }
    .status-pendaftaran-wrap .person-card-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .status-pendaftaran-wrap .person-card-male .person-card-icon {
        background: linear-gradient(135deg, #93c5fd 0%, #86efac 100%);
    }
    .status-pendaftaran-wrap .person-card-female .person-card-icon {
        background: linear-gradient(135deg, #fbcfe8 0%, #86efac 100%);
    }
    .status-pendaftaran-wrap .person-card-icon svg { width: 28px; height: 28px; color: rgba(255,255,255,0.95); }
    .status-pendaftaran-wrap .person-card-icon-check {
        position: absolute;
        bottom: -4px;
        right: -4px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #22c55e, #16a34a);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(34,197,94,0.5);
    }
    .status-pendaftaran-wrap .person-card-icon-check svg { width: 12px; height: 12px; color: #fff; }
    .status-pendaftaran-wrap .person-card-main {
        flex: 1;
        min-width: 0;
    }
    .status-pendaftaran-wrap .person-card-name {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
        letter-spacing: -0.01em;
    }
    .status-pendaftaran-wrap .person-card-date {
        font-size: 13px;
        color: #334155;
        font-weight: 500;
    }
    .status-pendaftaran-wrap .person-card-ttl {
        font-size: 12px;
        color: #334155;
        margin-top: 2px;
        font-weight: 500;
    }
    .status-pendaftaran-wrap .person-card-orang-tua {
        font-size: 12px;
        color: #1e293b;
        margin-top: 6px;
        padding-top: 6px;
        border-top: 1px solid rgba(0,0,0,0.08);
        font-weight: 500;
    }
    .status-pendaftaran-wrap .person-card-orang-tua strong {
        color: #0f172a;
        font-weight: 600;
    }
    /* Wedding rings connector */
    .status-pendaftaran-wrap .rings-connector {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 0 16px;
        min-width: 80px;
    }
    .status-pendaftaran-wrap .rings-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
    }
    /* Lunas badge - centered below rings */
    .status-pendaftaran-wrap .badge-wrap {
        display: flex;
        justify-content: center;
        margin-top: 12px;
    }
    .status-pendaftaran-wrap .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        text-shadow: 0 1px 1px rgba(0,0,0,0.15);
        box-shadow: 0 2px 12px rgba(34,197,94,0.35);
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, rgba(34,197,94,0.95) 0%, rgba(22,163,74,0.9) 100%);
        border: 1px solid rgba(255,255,255,0.5);
    }
    .status-pendaftaran-wrap .badge .badge-check {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
    }
    .status-pendaftaran-wrap .badge-amber {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #b45309;
        border: 1px solid rgba(245,158,11,0.2);
    }
    .status-pendaftaran-wrap .badge-slate {
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        color: #475569;
        border: 1px solid rgba(148,163,184,0.2);
    }
    .status-pendaftaran-wrap .badge-blue {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1d4ed8;
        border: 1px solid rgba(59,130,246,0.2);
    }
    /* Empty state */
    .status-pendaftaran-wrap .empty-state {
        position: relative;
        text-align: center;
        padding: 56px 28px;
        color: #64748b;
    }
    .status-pendaftaran-wrap .empty-state .empty-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .status-pendaftaran-wrap .empty-state .empty-icon svg { width: 28px; height: 28px; color: #6366f1; }
    .status-pendaftaran-wrap .empty-state p { font-size: 14px; margin-bottom: 0; }
    .status-pendaftaran-wrap .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #2230ce, #3d56f5);
        color: #fff;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 6px 20px rgba(34,48,206,0.35);
        transition: all 0.2s ease;
    }
    .status-pendaftaran-wrap .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(34,48,206,0.4);
        opacity: 0.95;
    }
    @media (max-width: 768px) {
        .status-pendaftaran-wrap { min-height: calc(100vh - 100px); padding: 20px 0; }
        .status-pendaftaran-wrap .status-pendaftaran-inner { max-width: 100%; }
        .status-pendaftaran-wrap .card-header { padding: 20px 20px; }
        .status-pendaftaran-wrap .card-list { padding: 20px 20px 24px; gap: 1.5rem; }
        .status-pendaftaran-wrap .couple-block {
            flex-direction: column;
            align-items: center;
            max-width: 100%;
        }
        .status-pendaftaran-wrap .person-card {
            max-width: 100%;
            width: 100%;
            min-width: 0;
            padding: 20px 18px;
        }
        .status-pendaftaran-wrap .rings-connector {
            padding: 16px 0;
        }
        .status-pendaftaran-wrap .person-card-icon,
        .status-pendaftaran-wrap .person-card-photo { width: 52px; height: 52px; }
        .status-pendaftaran-wrap .person-card-icon svg { width: 24px; height: 24px; }
        .status-pendaftaran-wrap .person-card-icon-check { width: 20px; height: 20px; }
    }
</style>
@endpush

@section('content')
<div class="status-pendaftaran-wrap">
    <div class="status-pendaftaran-inner">

        @if($pendaftaran)
            <div class="card-list">
                <div class="couple-block">
                    {{-- Kartu pria --}}
                    <div class="person-card person-card-male">
                        <div class="person-card-body">
                            <div class="person-card-icon-wrap">
                                @if($pendaftaran->foto_pria)
                                <div class="person-card-photo">
                                    <img src="{{ asset('storage/' . $pendaftaran->foto_pria) }}" alt="{{ $pendaftaran->nama_pria }}">
                                </div>
                                <div class="person-card-icon-check">
                                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                </div>
                                @else
                                <div class="person-card-icon">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                    </svg>
                                </div>
                                <div class="person-card-icon-check">
                                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="person-card-main">
                                <div class="person-card-name">{{ $pendaftaran->nama_pria }}</div>
                                <div class="person-card-date">{{ $pendaftaran->tanggal_pernikahan ? $pendaftaran->tanggal_pernikahan->locale('id')->isoFormat('D MMM YYYY') : '—' }}</div>
                                <div class="person-card-ttl">{{ $pendaftaran->tempat_lahir_pria ?? '—' }}, {{ $pendaftaran->tanggal_lahir_pria ? $pendaftaran->tanggal_lahir_pria->locale('id')->isoFormat('D MMM YYYY') : '—' }}</div>
                                <div class="person-card-orang-tua"><strong>Orang tua:</strong> {{ trim(($pendaftaran->nama_ayah_pria ?? '') . ' & ' . ($pendaftaran->nama_ibu_pria ?? ''), ' &') ?: '—' }}</div>
                            </div>
                        </div>
                    </div>
                    {{-- Cincin pernikahan --}}
                    <div class="rings-connector">
                        <svg class="rings-icon" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="gold1" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#ffd700"/>
                                    <stop offset="40%" style="stop-color:#ffec8b"/>
                                    <stop offset="100%" style="stop-color:#daa520"/>
                                </linearGradient>
                                <filter id="glow1">
                                    <feGaussianBlur stdDeviation="0.5" result="coloredBlur"/>
                                    <feMerge>
                                        <feMergeNode in="coloredBlur"/>
                                        <feMergeNode in="SourceGraphic"/>
                                    </feMerge>
                                </filter>
                            </defs>
                            {{-- Dua cincin saling melingkupi --}}
                            <circle cx="20" cy="24" r="10" fill="none" stroke="url(#gold1)" stroke-width="2.5" stroke-linecap="round" filter="url(#glow1)"/>
                            <circle cx="28" cy="24" r="10" fill="none" stroke="url(#gold1)" stroke-width="2.5" stroke-linecap="round" filter="url(#glow1)"/>
                        </svg>
                        @if($pendaftaran->status_pembayaran === 'lunas')
                        <span class="badge">
                            <svg class="badge-check" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            Lunas
                        </span>
                        @elseif($pendaftaran->status_pembayaran === 'pending' || $pendaftaran->status_pembayaran === 'menunggu')
                        <span class="badge badge-amber">Menunggu</span>
                        @else
                        <span class="badge badge-slate">{{ ucfirst($pendaftaran->status_pembayaran ?? '—') }}</span>
                        @endif
                    </div>
                    {{-- Kartu wanita --}}
                    <div class="person-card person-card-female">
                        <div class="person-card-body">
                            <div class="person-card-icon-wrap">
                                @if($pendaftaran->foto_wanita)
                                <div class="person-card-photo">
                                    <img src="{{ asset('storage/' . $pendaftaran->foto_wanita) }}" alt="{{ $pendaftaran->nama_wanita }}">
                                </div>
                                <div class="person-card-icon-check">
                                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                </div>
                                @else
                                <div class="person-card-icon">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                    </svg>
                                </div>
                                <div class="person-card-icon-check">
                                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="person-card-main">
                                <div class="person-card-name">{{ $pendaftaran->nama_wanita }}</div>
                                <div class="person-card-date">{{ $pendaftaran->tanggal_pernikahan ? $pendaftaran->tanggal_pernikahan->locale('id')->isoFormat('D MMM YYYY') : '—' }}</div>
                                <div class="person-card-ttl">{{ $pendaftaran->tempat_lahir_wanita ?? '—' }}, {{ $pendaftaran->tanggal_lahir_wanita ? $pendaftaran->tanggal_lahir_wanita->locale('id')->isoFormat('D MMM YYYY') : '—' }}</div>
                                <div class="person-card-orang-tua"><strong>Orang tua:</strong> {{ trim(($pendaftaran->nama_ayah_wanita ?? '') . ' & ' . ($pendaftaran->nama_ibu_wanita ?? ''), ' &') ?: '—' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pembayaran QRIS — tampilan gambar QR saat belum lunas --}}
                @if($pendaftaran && $pendaftaran->status_pembayaran !== 'lunas')
                <div class="card" style="margin-top: 1.5rem;">
                    <div class="card-header">
                        <div class="card-header-icon" style="background: linear-gradient(145deg, #059669, #10b981);">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h2>Pembayaran QRIS</h2>
                            <p>Scan gambar QR di bawah atau klik untuk halaman pembayaran lengkap</p>
                        </div>
                    </div>
                    <div class="card-list" style="padding: 20px 28px 28px;">
                        @if($pendaftaran->qris_url)
                        <div class="text-center" style="margin-bottom: 16px;">
                            <p class="text-sm font-semibold text-gray-700 mb-3">📱 Gambar QRIS Pembayaran · Rp 350.000</p>
                            <div class="inline-block p-5 rounded-2xl" style="background: #f8fafc; border: 2px solid #e2e8f0; box-shadow: 0 4px 16px rgba(0,0,0,0.06);">
                                <img src="{{ route('pembayaran.qr-image', $pendaftaran->id) }}?t={{ time() }}"
                                     alt="QR Code QRIS Pembayaran - Rp 350.000"
                                     class="mx-auto rounded-lg"
                                     style="width: 260px; height: 260px; object-fit: contain; display: block;"
                                     loading="eager"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="hidden items-center justify-center text-gray-400 rounded-lg" style="width: 280px; height: 280px; flex-direction: column; margin: 0 auto;"
                                     onload="var i=this.previousElementSibling; if(i && !i.complete) this.style.display='flex';">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <p class="text-xs text-center">QR tidak tersedia. Klik tombol di bawah.</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">GoPay, OVO, DANA, ShopeePay, mobile banking</p>
                        </div>
                        @endif
                        <a href="{{ route('pembayaran.show', $pendaftaran->id) }}" class="btn-cta" style="width: 100%; justify-content: center;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            {{ $pendaftaran->qris_url ? 'Halaman Pembayaran Lengkap' : 'Bayar Sekarang / Lihat QRIS' }}
                        </a>
                    </div>
                </div>
                @endif
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                </div>
                <p>Belum ada data pendaftaran.</p>
                <a href="{{ route('kursus-pernikahan') }}" class="btn-cta">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Daftar Kursus Pernikahan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
