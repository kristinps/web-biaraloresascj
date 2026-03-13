@extends('layouts.dashboard')

@section('title', 'Dashboard Peserta')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Pesan dan informasi dari admin')

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
    /* List: couple blocks */
    .status-pendaftaran-wrap .card-list {
        position: relative;
        padding: 24px 28px 32px;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    /* Couple block: two cards + rings */
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
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
    }
    .status-pendaftaran-wrap .person-card-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .status-pendaftaran-wrap .person-card-male .person-card-icon {
        background: linear-gradient(135deg, #93c5fd 0%, #60a5fa 100%);
    }
    .status-pendaftaran-wrap .person-card-female .person-card-icon {
        background: linear-gradient(135deg, #fbcfe8 0%, #f472b6 100%);
    }
    .status-pendaftaran-wrap .person-card-icon svg { width: 28px; height: 28px; color: rgba(255,255,255,0.95); }
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
    .status-pendaftaran-wrap .person-card-orang-tua,
    .status-pendaftaran-wrap .person-card-extra {
        font-size: 12px;
        color: #1e293b;
        margin-top: 6px;
        padding-top: 6px;
        border-top: 1px solid rgba(0,0,0,0.08);
        font-weight: 500;
    }
    .status-pendaftaran-wrap .person-card-orang-tua strong,
    .status-pendaftaran-wrap .person-card-extra strong {
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
    }
</style>
@endpush

@section('content')
<div class="status-pendaftaran-wrap">
    <div class="status-pendaftaran-inner">

        @php
            $p = $pendaftaran->first();
        @endphp
        @if($p)
            <div class="card-list">
                <div class="couple-block">
                        {{-- Kartu pria --}}
                        <div class="person-card person-card-male">
                            <div class="person-card-body">
                                <div class="person-card-icon-wrap">
                                    @if($p->foto_pria ?? null)
                                    <div class="person-card-photo">
                                        <img src="{{ asset('storage/' . $p->foto_pria) }}" alt="{{ $p->nama_pria }}">
                                    </div>
                                    @else
                                    <div class="person-card-icon">
                                        {{ strtoupper(mb_substr($p->nama_pria ?? 'P', 0, 1)) }}
                                    </div>
                                    @endif
                                </div>
                                <div class="person-card-main">
                                    <div class="person-card-name">{{ $p->nama_pria ?? '—' }}</div>
                                    <div class="person-card-ttl">{{ $p->tempat_lahir_pria ?? '—' }}, {{ $p->tanggal_lahir_pria ? $p->tanggal_lahir_pria->locale('id')->translatedFormat('d F Y') : '—' }}</div>
                                    <div class="person-card-extra"><strong>Pekerjaan:</strong> {{ $p->pekerjaan_pria ?? '—' }}</div>
                                    <div class="person-card-extra" style="margin-top: 2px; padding-top: 2px; border-top: none;"><strong>Alamat:</strong> {{ $p->alamat_pria ?? '—' }}</div>
                                </div>
                            </div>
                        </div>
                        {{-- Cincin pernikahan --}}
                        <div class="rings-connector">
                            <svg class="rings-icon" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="goldDashboard" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:#ffd700"/>
                                        <stop offset="40%" style="stop-color:#ffec8b"/>
                                        <stop offset="100%" style="stop-color:#daa520"/>
                                    </linearGradient>
                                    <filter id="glowDashboard">
                                        <feGaussianBlur stdDeviation="0.5" result="coloredBlur"/>
                                        <feMerge>
                                            <feMergeNode in="coloredBlur"/>
                                            <feMergeNode in="SourceGraphic"/>
                                        </feMerge>
                                    </filter>
                                </defs>
                                <circle cx="20" cy="24" r="10" fill="none" stroke="url(#goldDashboard)" stroke-width="2.5" stroke-linecap="round" filter="url(#glowDashboard)"/>
                                <circle cx="28" cy="24" r="10" fill="none" stroke="url(#goldDashboard)" stroke-width="2.5" stroke-linecap="round" filter="url(#glowDashboard)"/>
                            </svg>
                        </div>
                        {{-- Kartu wanita --}}
                        <div class="person-card person-card-female">
                            <div class="person-card-body">
                                <div class="person-card-icon-wrap">
                                    @if($p->foto_wanita ?? null)
                                    <div class="person-card-photo">
                                        <img src="{{ asset('storage/' . $p->foto_wanita) }}" alt="{{ $p->nama_wanita }}">
                                    </div>
                                    @else
                                    <div class="person-card-icon">
                                        {{ strtoupper(mb_substr($p->nama_wanita ?? 'W', 0, 1)) }}
                                    </div>
                                    @endif
                                </div>
                                <div class="person-card-main">
                                    <div class="person-card-name">{{ $p->nama_wanita ?? '—' }}</div>
                                    <div class="person-card-ttl">{{ $p->tempat_lahir_wanita ?? '—' }}, {{ $p->tanggal_lahir_wanita ? $p->tanggal_lahir_wanita->locale('id')->translatedFormat('d F Y') : '—' }}</div>
                                    <div class="person-card-extra"><strong>Pekerjaan:</strong> {{ $p->pekerjaan_wanita ?? '—' }}</div>
                                    <div class="person-card-extra" style="margin-top: 2px; padding-top: 2px; border-top: none;"><strong>Alamat:</strong> {{ $p->alamat_wanita ?? '—' }}</div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                </div>
                <p>Anda belum memiliki data pendaftaran. Silakan daftar terlebih dahulu.</p>
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
