@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Setujui Pendaftaran')
@section('page-title', 'Setujui Pendaftaran')
@section('page-subtitle', 'Pilih periode kursus untuk peserta dan setujui pendaftaran')

@push('styles')
<style>
    .page-header {
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
    }
    .page-header-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid rgba(255,255,255,0.25);
    }
    .page-header-icon svg { width: 26px; height: 26px; color: #fff; }
    .page-header h1 { font-size: 1.6rem; font-weight: 700; color: #fff; margin: 0 0 6px 0; }
    .page-header p { font-size: 0.95rem; color: rgba(255,255,255,0.92); margin: 0; }

    .layout-grid {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(0, 1.6fr);
        gap: 20px;
    }
    @media (max-width: 960px) {
        .layout-grid {
            grid-template-columns: minmax(0, 1fr);
        }
    }

    .card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(15,23,42,0.06);
        overflow: hidden;
    }
    .card-header {
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
    }
    .card-header.secondary {
        background: linear-gradient(135deg, #22c55e, #16a34a);
    }
    .card-header svg {
        width: 18px;
        height: 18px;
        color: rgba(255,255,255,0.9);
    }
    .card-header h3 {
        font-size: 14px;
        font-weight: 700;
        margin: 0;
    }
    .card-body {
        padding: 18px 20px 20px;
    }

    .info-row {
        display: flex;
        padding: 6px 0;
        font-size: 13.5px;
        gap: 10px;
    }
    .info-label {
        width: 34%;
        color: #94a3b8;
        flex-shrink: 0;
    }
    .info-value {
        flex: 1;
        color: #1e293b;
        font-weight: 600;
        word-break: break-word;
    }
    .info-value.muted {
        font-weight: 400;
        color: #94a3b8;
        font-style: italic;
    }

    .form-group {
        margin-bottom: 14px;
    }
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }
    .form-select {
        width: 100%;
        padding: 10px 12px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        font-size: 13.5px;
        color: #1e293b;
        background: #fff;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    }
    .text-danger {
        font-size: 12px;
        color: #dc2626;
        margin-top: 4px;
        display: block;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 20px;
        border-radius: 11px;
        border: none;
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: #fff;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(34,197,94,0.35);
        transition: opacity 0.15s, transform 0.1s, box-shadow 0.15s;
    }
    .btn-submit:hover {
        opacity: 0.95;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(22,163,74,0.45);
    }
    .btn-submit svg {
        width: 16px;
        height: 16px;
    }
    .note {
        font-size: 12px;
        color: #6b7280;
        margin-top: 8px;
    }

    .alert-info {
        padding: 10px 12px;
        border-radius: 10px;
        font-size: 12.5px;
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        margin-bottom: 10px;
    }
    .alert-warning {
        padding: 10px 12px;
        border-radius: 10px;
        font-size: 12.5px;
        background: #fffbeb;
        color: #92400e;
        border: 1px solid #fed7aa;
        margin-bottom: 12px;
    }
</style>
@endpush

@section('content')
@php
    $routePrefix = $routePrefix ?? (request()->routeIs('dashboard.*') ? 'dashboard' : 'admin');
@endphp

<div class="page-header">
    <div class="page-header-icon">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12A9 9 0 113 12a9 9 0 0118 0z"/>
        </svg>
    </div>
    <div>
        <h1>Setujui Pendaftaran</h1>
        <p>Pilih periode kursus untuk peserta lalu kirim persetujuan.</p>
    </div>
</div>

<div class="layout-grid">
    <div class="card">
        <div class="card-header">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118A7.5 7.5 0 0119.5 20.12 17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
            </svg>
            <h3>Data Pendaftar</h3>
        </div>
        <div class="card-body">
            <div class="info-row">
                <div class="info-label">Pasangan</div>
                <div class="info-value">
                    {{ $pendaftaran->nama_pria }} &amp; {{ $pendaftaran->nama_wanita }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $pendaftaran->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Pernikahan</div>
                <div class="info-value">
                    {{ $pendaftaran->tanggal_pernikahan?->translatedFormat('d F Y') ?? '-' }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Status Kursus</div>
                <div class="info-value">
                    {{ ucfirst(str_replace('_', ' ', $pendaftaran->status_kursus ?? 'menunggu')) }}
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header secondary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3>Pilih Periode & Setujui</h3>
        </div>
        <div class="card-body">
            @if($periodes->count() === 0)
                <div class="alert-warning">
                    Belum ada periode aktif. Buat periode terlebih dahulu di menu <strong>Periode Pernikahan</strong> sebelum menyetujui pendaftaran.
                </div>
            @else
                <div class="alert-info">
                    Peserta akan didaftarkan ke periode yang dipilih dan status kursus berubah menjadi <strong>Terjadwal</strong>. Email notifikasi akan dikirim otomatis.
                </div>
            @endif

            <form method="POST" action="{{ route($routePrefix . '.pendaftaran.setuju.store', $pendaftaran->id) }}">
                @csrf
                <div class="form-group">
                    <label for="periode_id" class="form-label">Periode Kursus</label>
                    <select id="periode_id" name="periode_id" class="form-select" {{ $periodes->count() === 0 ? 'disabled' : '' }}>
                        <option value="">Pilih periode aktif...</option>
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->id }}" {{ (string) old('periode_id', $pendaftaran->periode_id) === (string) $periode->id ? 'selected' : '' }}>
                                {{ $periode->nama }}
                                @if($periode->tanggal_mulai)
                                    — {{ $periode->tanggal_mulai->format('d M Y') }}
                                    @if($periode->tanggal_selesai)
                                        s/d {{ $periode->tanggal_selesai->format('d M Y') }}
                                    @endif
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('periode_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit" {{ $periodes->count() === 0 ? 'disabled' : '' }}>
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12A9 9 0 113 12a9 9 0 0118 0z"/>
                    </svg>
                    Setujui & Jadwalkan
                </button>
                <p class="note">
                    Setelah disetujui, pendaftaran akan hilang dari daftar "Pendaftaran Masuk" dan muncul di daftar peserta terjadwal.
                </p>
            </form>
        </div>
    </div>
</div>

@endsection

