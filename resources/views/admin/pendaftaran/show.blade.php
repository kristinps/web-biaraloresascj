@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Detail Pendaftaran #' . str_pad($pendaftaran->id, 5, '0', STR_PAD_LEFT))
@section('page-title', 'Detail Pendaftaran')
@section('page-subtitle', 'Informasi lengkap pendaftaran #' . str_pad($pendaftaran->id, 5, '0', STR_PAD_LEFT))

@push('styles')
<style>
    .pendaftaran-show-page .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        font-size: 13.5px; font-weight: 600; color: #ffffff;
        text-decoration: none; margin-bottom: 20px;
    }
    .back-link svg { width: 16px; height: 16px; }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: start;
    }
    @media (max-width: 900px) { .detail-grid { grid-template-columns: 1fr; } }

    .pendaftaran-show-page .section-card {
        background: linear-gradient(135deg, rgba(99,102,241,0.14), rgba(139,92,246,0.10), rgba(56,189,248,0.08));
        border: 1px solid rgba(148,163,184,0.5);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15,23,42,0.08);
        margin-bottom: 20px;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .section-head {
        padding: 16px 22px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex; align-items: center; gap: 10px;
    }
    .section-head svg { width: 18px; height: 18px; color: #ffffff; }
    .section-head h3 { font-size: 14px; font-weight: 700; color: #fff; }
    .section-body { padding: 0; }

    .info-row {
        display: flex;
        padding: 12px 22px;
        border-bottom: 1px solid rgba(148,163,184,0.35);
        gap: 16px;
    }
    .info-row:last-child { border-bottom: none; }
    .pendaftaran-show-page .info-label {
        width: 42%;
        font-size: 13px;
        color: #ffffff;
        font-weight: 500;
        flex-shrink: 0;
        line-height: 1.5;
    }
    .pendaftaran-show-page .info-value {
        flex: 1;
        font-size: 13.5px;
        color: #ffffff;
        font-weight: 600;
        line-height: 1.5;
        word-break: break-word;
    }
    .pendaftaran-show-page .info-value.muted { color: rgba(255,255,255,0.85); font-weight: 400; font-style: italic; }

    .pay-badge {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 6px 14px; border-radius: 99px;
        font-size: 13px; font-weight: 700;
    }
    .pay-badge-dot { width: 8px; height: 8px; border-radius: 50%; }
    .pendaftaran-show-page .pay-green { background: rgba(34,197,94,0.35); color: #bbf7d0; }
    .pay-green .pay-badge-dot { background: #22c55e; }
    .pendaftaran-show-page .pay-amber { background: rgba(245,158,11,0.35); color: #fef3c7; }
    .pay-amber .pay-badge-dot { background: #f59e0b; }
    .pendaftaran-show-page .pay-slate { background: rgba(148,163,184,0.35); color: #e2e8f0; }
    .pay-slate .pay-badge-dot { background: #94a3b8; }

    .pendaftaran-show-page .doc-link {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 12px; border-radius: 8px;
        background: rgba(255,255,255,0.2); color: #ffffff;
        font-size: 12.5px; font-weight: 600;
        text-decoration: none;
    }
    .doc-link svg { width: 13px; height: 13px; }

    .doc-table { width: 100%; border-collapse: collapse; }
    .pendaftaran-show-page .doc-table thead th {
        padding: 10px 18px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #ffffff;
        background: rgba(99,102,241,0.15);
        text-align: left;
        border-bottom: 1px solid rgba(148,163,184,0.35);
    }
    .pendaftaran-show-page .doc-table tbody td {
        padding: 10px 18px;
        font-size: 12.5px;
        color: #ffffff;
        border-bottom: 1px solid rgba(148,163,184,0.35);
        vertical-align: middle;
    }
    .pendaftaran-show-page .doc-table tbody tr:hover { background: transparent !important; }
    .pendaftaran-show-page .doc-table .doc-name { font-weight: 600; color: #ffffff; }
    .pendaftaran-show-page .doc-table .doc-empty { color: rgba(255,255,255,0.8); font-style: italic; }
    .doc-aksi {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 999px;
        border: none;
        cursor: pointer;
        background: #f9fafb;
        transition: background 0.15s, box-shadow 0.15s, transform 0.1s;
    }
    .icon-btn svg { width: 15px; height: 15px; }
    .pendaftaran-show-page .icon-btn-approve { color: #bbf7d0; background: rgba(34,197,94,0.35); }
    .pendaftaran-show-page .icon-btn-reject { color: #fecaca; background: rgba(239,68,68,0.35); }

    .dok-badge { display:inline-flex;align-items:center;gap:7px;padding:5px 13px;border-radius:99px;font-size:12.5px;font-weight:700; }
    .dok-badge-dot { width:7px;height:7px;border-radius:50%; }
    .pendaftaran-show-page .dok-lengkap { background:rgba(34,197,94,0.35);color:#bbf7d0; } .dok-lengkap .dok-badge-dot { background:#22c55e; }
    .pendaftaran-show-page .dok-tidak   { background:rgba(239,68,68,0.35);color:#fecaca; } .dok-tidak .dok-badge-dot   { background:#ef4444; }
    .pendaftaran-show-page .dok-periksa { background:rgba(245,158,11,0.35);color:#fef3c7; } .dok-periksa .dok-badge-dot { background:#f59e0b; }

    .kursus-badge { display:inline-flex;align-items:center;gap:6px;padding:4px 11px;border-radius:99px;font-size:12px;font-weight:700; }
    .kursus-badge-dot { width:6px;height:6px;border-radius:50%; }
    .pendaftaran-show-page .kb-belum   { background:rgba(148,163,184,0.35);color:#e2e8f0; } .kb-belum .kursus-badge-dot   { background:#94a3b8; }
    .pendaftaran-show-page .kb-terjadwal { background:rgba(59,130,246,0.35);color:#bfdbfe; } .kb-terjadwal .kursus-badge-dot { background:#3b82f6; }
    .pendaftaran-show-page .kb-berjalan  { background:rgba(245,158,11,0.35);color:#fef3c7; } .kb-berjalan .kursus-badge-dot  { background:#f59e0b; }
    .pendaftaran-show-page .kb-lulus { background:rgba(34,197,94,0.35);color:#bbf7d0; } .kb-lulus .kursus-badge-dot { background:#22c55e; }
    .pendaftaran-show-page .kb-tidak { background:rgba(239,68,68,0.35);color:#fecaca; } .kb-tidak .kursus-badge-dot { background:#ef4444; }

    .pendaftaran-show-page .action-card {
        background: linear-gradient(135deg, rgba(99,102,241,0.14), rgba(139,92,246,0.10), rgba(56,189,248,0.08));
        border: 1px solid rgba(148,163,184,0.5);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15,23,42,0.08);
        margin-bottom: 20px;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .action-head { padding:14px 22px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;gap:9px; }
    .action-head svg { width:17px;height:17px;color:#fff; }
    .action-head h3 { font-size:13.5px;font-weight:700;color:#fff; }
    .action-body { padding:20px 22px; }

    .form-group { margin-bottom:14px; }
    .pendaftaran-show-page .action-body .form-label { display:block;font-size:12.5px;font-weight:600;color:#ffffff;margin-bottom:5px; }
    .pendaftaran-show-page .action-body .form-select,
    .pendaftaran-show-page .action-body .form-textarea {
        width:100%;padding:9px 12px;border:1.5px solid rgba(148,163,184,0.5);border-radius:9px;
        font-size:13.5px;color:#ffffff;background:rgba(255,255,255,0.12);outline:none;font-family:inherit;
    }
    .pendaftaran-show-page .action-body .form-select:focus,
    .pendaftaran-show-page .action-body .form-textarea:focus { border-color:#6366f1; }
    .form-textarea { resize:vertical;min-height:80px; }
    .pendaftaran-show-page .action-body .form-textarea::placeholder { color:rgba(255,255,255,0.5); }

    .btn-action { display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;border:none; }
    .btn-action svg { width:14px;height:14px; }
    .btn-indigo { background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff; }

    .pendaftaran-show-page .check-row label { font-size:13px;color:#ffffff;cursor:pointer; }
    .check-row { display:flex;align-items:center;gap:8px;margin-top:10px; }
    .check-row input[type=checkbox] { width:15px;height:15px;cursor:pointer;accent-color:#6366f1; }

    .pendaftaran-show-page .top-card {
        background: linear-gradient(135deg, rgba(99,102,241,0.14), rgba(139,92,246,0.10), rgba(56,189,248,0.08));
        border: 1px solid rgba(148,163,184,0.5);
        border-radius: 16px;
        padding: 22px 24px;
        box-shadow: 0 8px 24px rgba(15,23,42,0.08);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .pendaftaran-show-page .top-card .reg-id { font-size: 22px; font-weight: 800; color: #ffffff; }
    .pendaftaran-show-page .top-card .reg-id span { color: #c7d2fe; }
    .pendaftaran-show-page .top-card .reg-date { font-size: 13px; color: #ffffff; margin-top: 3px; }

    .btn-check-show {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 16px; border-radius: 10px; border: none;
        background: linear-gradient(135deg, #22c55e, #16a34a); color: #fff;
        font-size: 13px; font-weight: 600; cursor: pointer;
        box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
    }
    .btn-check-show svg { width: 18px; height: 18px; }

    .modal-backdrop { position: fixed; inset: 0; background: rgba(15,23,42,0.45); display: none; align-items: center; justify-content: center; z-index: 120; }
    .modal-backdrop.open { display: flex; }
    .pendaftaran-show-page .modal-box {
        background: linear-gradient(135deg, rgba(99,102,241,0.14), rgba(139,92,246,0.10), rgba(56,189,248,0.08));
        border: 1px solid rgba(148,163,184,0.5);
        border-radius: 18px;
        max-width: 460px;
        width: 100%;
        padding: 22px;
        box-shadow: 0 18px 45px rgba(15,23,42,0.35);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .pendaftaran-show-page .modal-box .modal-close { background: none; border: none; cursor: pointer; color: rgba(255,255,255,0.9); float: right; }
    .pendaftaran-show-page .modal-box .form-group label { display: block; font-size: 13px; font-weight: 500; color: #ffffff; margin-bottom: 4px; }
    .pendaftaran-show-page .modal-box .form-group select {
        width: 100%; border-radius: 10px; border: 1px solid rgba(148,163,184,0.5);
        padding: 10px 12px; font-size: 14px; color: #ffffff; background: rgba(255,255,255,0.12);
    }
    .pendaftaran-show-page .modal-box .modal-footer { display: flex; justify-content: flex-end; gap: 8px; margin-top: 16px; }
    .pendaftaran-show-page .modal-box .btn-secondary {
        padding: 8px 14px; border-radius: 999px; border: 1px solid rgba(148,163,184,0.5);
        background: rgba(255,255,255,0.2); font-size: 13px; color: #ffffff; cursor: pointer;
    }
    .pendaftaran-show-page .modal-box .btn-primary {
        padding: 8px 18px; border-radius: 999px; border: none;
        background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer;
    }
</style>
@endpush

@section('content')
@php
    $routePrefix = $routePrefix ?? (request()->routeIs('dashboard.*') ? 'dashboard' : 'admin');
@endphp
<div class="pendaftaran-show-page">
<a href="{{ route($routePrefix . '.pendaftaran.index') }}" class="back-link">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
    </svg>
    Kembali ke Daftar
</a>

{{-- Top card --}}
<div class="top-card">
    <div>
        <div class="reg-id">Pendaftaran <span>#{{ str_pad($pendaftaran->id, 5, '0', STR_PAD_LEFT) }}</span></div>
        <div class="reg-date">Didaftarkan pada {{ $pendaftaran->created_at->translatedFormat('d F Y, H:i') }} WIB</div>
    </div>
    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
        @if($pendaftaran->status_pembayaran === 'lunas')
            <span class="pay-badge pay-green"><span class="pay-badge-dot"></span>Pembayaran Lunas</span>
        @elseif($pendaftaran->status_pembayaran === 'menunggu')
            <span class="pay-badge pay-amber"><span class="pay-badge-dot"></span>Menunggu Pembayaran</span>
        @else
            <span class="pay-badge pay-slate"><span class="pay-badge-dot"></span>Belum Bayar</span>
        @endif

        @if($pendaftaran->midtrans_order_id)
            <span style="font-size:12px;color:#ffffff;background:rgba(255,255,255,0.15);padding:6px 12px;border-radius:8px;font-family:monospace">
                {{ $pendaftaran->midtrans_order_id }}
            </span>
        @endif

        @if(!$pendaftaran->periode_id && isset($periodes) && $periodes->isNotEmpty())
            <button type="button" class="btn-check" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;width:auto;border-radius:10px" onclick="document.getElementById('periodeModalShow').classList.add('open')" title="Pilih Periode">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Centang
            </button>
        @endif
    </div>
</div>

{{-- Aksi Pemeriksaan Dokumen --}}
<div class="action-card">
    <div class="action-head">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
        </svg>
        <h3>Pemeriksaan Kelengkapan Dokumen</h3>
        <div style="margin-left:auto;display:flex;align-items:center;gap:8px;flex-wrap:wrap">
            @php $statusDok = $pendaftaran->status_dokumen ?? 'belum_diperiksa'; @endphp
            @if($statusDok === 'lengkap')
                <span class="dok-badge dok-lengkap"><span class="dok-badge-dot"></span>Dokumen Diterima</span>
            @elseif($statusDok === 'tidak_lengkap')
                <span class="dok-badge dok-tidak"><span class="dok-badge-dot"></span>Perlu Perbaikan</span>
            @elseif($statusDok === 'sedang_diperiksa')
                <span class="dok-badge dok-periksa"><span class="dok-badge-dot"></span>Sedang Diperiksa</span>
            @else
                <span class="dok-badge dok-periksa"><span class="dok-badge-dot"></span>Belum Diperiksa</span>
            @endif
            @php $statusKursus = $pendaftaran->status_kursus ?? 'belum_dijadwalkan'; @endphp
            @if($statusKursus === 'lulus')
                <span class="kursus-badge kb-lulus"><span class="kursus-badge-dot"></span>Lulus Kursus</span>
            @elseif($statusKursus === 'tidak_lulus')
                <span class="kursus-badge kb-tidak"><span class="kursus-badge-dot"></span>Tidak Lulus</span>
            @elseif($statusKursus === 'terjadwal')
                <span class="kursus-badge kb-terjadwal"><span class="kursus-badge-dot"></span>Terjadwal</span>
            @elseif($statusKursus === 'sedang_berjalan')
                <span class="kursus-badge kb-berjalan"><span class="kursus-badge-dot"></span>Sedang Berjalan</span>
            @else
                <span class="kursus-badge kb-belum"><span class="kursus-badge-dot"></span>Belum Dijadwalkan</span>
            @endif
        </div>
    </div>
    <div class="action-body">
        <form action="{{ $routePrefix === 'dashboard' ? route('dashboard.pendaftaran.dokumen', $pendaftaran->id) : route('admin.dokumen.update', $pendaftaran->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 2fr;gap:16px;align-items:start">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Status Dokumen</label>
                    <select name="status_dokumen" class="form-select">
                        <option value="belum_diperiksa" {{ $statusDok === 'belum_diperiksa' ? 'selected' : '' }}>Belum Diperiksa</option>
                        <option value="sedang_diperiksa" {{ $statusDok === 'sedang_diperiksa' ? 'selected' : '' }}>Sedang Diperiksa</option>
                        <option value="lengkap"         {{ $statusDok === 'lengkap'         ? 'selected' : '' }}>✅ Dokumen Diterima</option>
                        <option value="tidak_lengkap"   {{ $statusDok === 'tidak_lengkap'   ? 'selected' : '' }}>⚠️ Tidak Lengkap / Perlu Perbaikan</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Pesan / Catatan untuk Peserta</label>
                    <textarea name="catatan_dokumen" class="form-textarea" rows="2"
                        placeholder="Contoh: Surat baptis pria belum diunggah. Mohon segera melengkapi...">{{ $pendaftaran->catatan_dokumen }}</textarea>
                </div>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:14px;flex-wrap:wrap;gap:10px">
                <p style="font-size:12px;color:#ffffff;margin:0;">Email notifikasi akan otomatis dikirim ke peserta ({{ $pendaftaran->email }})</p>
                <button type="submit" class="btn-action btn-indigo">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 10-2.636 6.364M16.5 12V8.25"/>
                    </svg>
                    Simpan & Kirim
                </button>
            </div>
        </form>
    </div>
</div>

<div class="detail-grid">
    {{-- Kiri --}}
    <div>
        {{-- Calon Pria --}}
        <div class="section-card">
            <div class="section-head">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
                <h3>Biodata Calon Pria</h3>
            </div>
            <div class="section-body">
                <div class="info-row"><span class="info-label">Nama Lengkap</span><span class="info-value">{{ $pendaftaran->nama_pria }}</span></div>
                <div class="info-row"><span class="info-label">Tempat, Tgl Lahir</span><span class="info-value">{{ $pendaftaran->tempat_lahir_pria }}, {{ $pendaftaran->tanggal_lahir_pria?->format('d M Y') }}</span></div>
                <div class="info-row"><span class="info-label">NIK</span><span class="info-value" style="font-family:monospace;letter-spacing:0.5px">{{ $pendaftaran->nik_pria }}</span></div>
                <div class="info-row"><span class="info-label">Agama</span><span class="info-value">{{ $pendaftaran->agama_pria }}</span></div>
                <div class="info-row"><span class="info-label">Pekerjaan</span><span class="info-value">{{ $pendaftaran->pekerjaan_pria }}</span></div>
                <div class="info-row"><span class="info-label">Alamat</span><span class="info-value">{{ $pendaftaran->alamat_pria }}</span></div>
                <div class="info-row"><span class="info-label">Nama Ayah</span><span class="info-value">{{ $pendaftaran->nama_ayah_pria }}</span></div>
                <div class="info-row"><span class="info-label">Nama Ibu</span><span class="info-value">{{ $pendaftaran->nama_ibu_pria }}</span></div>
            </div>
        </div>

        {{-- Rencana Pernikahan --}}
        <div class="section-card">
            <div class="section-head" style="background:linear-gradient(135deg,#ec4899,#f43f5e)">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
                <h3>Rencana Pernikahan</h3>
            </div>
            <div class="section-body">
                <div class="info-row"><span class="info-label">Tanggal Pernikahan</span><span class="info-value">{{ $pendaftaran->tanggal_pernikahan?->translatedFormat('d F Y') }}</span></div>
                <div class="info-row"><span class="info-label">Tempat Pernikahan</span><span class="info-value">{{ $pendaftaran->tempat_pernikahan }}</span></div>
            </div>
        </div>

        {{-- Kontak --}}
        <div class="section-card">
            <div class="section-head" style="background:linear-gradient(135deg,#0ea5e9,#38bdf8)">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                </svg>
                <h3>Kontak</h3>
            </div>
            <div class="section-body">
                <div class="info-row"><span class="info-label">Email</span><span class="info-value">{{ $pendaftaran->email }}</span></div>
                <div class="info-row"><span class="info-label">Nomor HP</span><span class="info-value">{{ $pendaftaran->nomor_hp ?? $pendaftaran->no_hp }}</span></div>
            </div>
        </div>
    </div>

    {{-- Kanan --}}
    <div>
        {{-- Calon Wanita --}}
        <div class="section-card">
            <div class="section-head" style="background:linear-gradient(135deg,#f472b6,#ec4899)">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
                <h3>Biodata Calon Wanita</h3>
            </div>
            <div class="section-body">
                <div class="info-row"><span class="info-label">Nama Lengkap</span><span class="info-value">{{ $pendaftaran->nama_wanita }}</span></div>
                <div class="info-row"><span class="info-label">Tempat, Tgl Lahir</span><span class="info-value">{{ $pendaftaran->tempat_lahir_wanita }}, {{ $pendaftaran->tanggal_lahir_wanita?->format('d M Y') }}</span></div>
                <div class="info-row"><span class="info-label">NIK</span><span class="info-value" style="font-family:monospace;letter-spacing:0.5px">{{ $pendaftaran->nik_wanita }}</span></div>
                <div class="info-row"><span class="info-label">Agama</span><span class="info-value">{{ $pendaftaran->agama_wanita }}</span></div>
                <div class="info-row"><span class="info-label">Pekerjaan</span><span class="info-value">{{ $pendaftaran->pekerjaan_wanita }}</span></div>
                <div class="info-row"><span class="info-label">Alamat</span><span class="info-value">{{ $pendaftaran->alamat_wanita }}</span></div>
                <div class="info-row"><span class="info-label">Nama Ayah</span><span class="info-value">{{ $pendaftaran->nama_ayah_wanita }}</span></div>
                <div class="info-row"><span class="info-label">Nama Ibu</span><span class="info-value">{{ $pendaftaran->nama_ibu_wanita }}</span></div>
            </div>
        </div>

        {{-- Dokumen --}}
        <div class="section-card">
            <div class="section-head" style="background:linear-gradient(135deg,#f59e0b,#fbbf24)">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
                <h3>Dokumen Upload</h3>
            </div>
            <div class="section-body">
                @php
                    $docs = [];
                    $perFieldStatus = $pendaftaran->dokumen_status_verifikasi ?? [];
                    foreach (\App\Models\PendaftaranPernikahan::dokumenFields() as $field => $label) {
                        $file = $pendaftaran->$field;
                        $raw  = $perFieldStatus[$field] ?? null;
                        $decided = array_key_exists($field, $perFieldStatus);
                        $accepted = $decided && filter_var($raw, FILTER_VALIDATE_BOOLEAN);
                        $rejected = $decided && !$accepted;
                        $docs[] = [
                            'field'    => $field,
                            'label'    => $label,
                            'file'     => $file,
                            'accepted' => $accepted,
                            'rejected' => $rejected,
                        ];
                    }
                @endphp
                <div style="overflow-x:auto">
                    <table class="doc-table">
                        <thead>
                            <tr>
                                <th>Nama Dokumen</th>
                                <th>File Dokumen</th>
                                <th>Status</th>
                                <th style="width:160px">Aksi Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($docs as $doc)
                            <tr>
                                <td class="doc-name">{{ $doc['label'] }}</td>
                                <td>
                                    @if($doc['file'])
                                        <a href="{{ asset('storage/' . $doc['file']) }}" target="_blank" class="doc-link">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                            </svg>
                                            Lihat Dokumen
                                        </a>
                                    @else
                                        <span class="muted doc-empty">Tidak diunggah</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$doc['file'])
                                        <span class="muted doc-empty">Belum diunggah</span>
                                    @elseif($doc['accepted'])
                                        <span class="dok-badge dok-lengkap">
                                            <span class="dok-badge-dot"></span>Diterima
                                        </span>
                                    @elseif($doc['rejected'])
                                        <span class="dok-badge dok-tidak">
                                            <span class="dok-badge-dot"></span>Ditolak
                                        </span>
                                    @else
                                        <span class="dok-badge dok-periksa">
                                            <span class="dok-badge-dot"></span>Sedang diperiksa
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($doc['file'])
                                        @if($doc['accepted'])
                                            <span class="muted">Sudah diterima</span>
                                        @elseif($doc['rejected'])
                                            <span class="muted">Sudah ditolak</span>
                                        @else
                                            <div class="doc-aksi">
                                                <form method="POST" action="{{ $routePrefix === 'dashboard'
                                                        ? route('dashboard.pendaftaran.dokumen-item-setuju', [$pendaftaran->id, $doc['field']])
                                                        : route('admin.pendaftaran.dokumen-item-setuju', [$pendaftaran->id, $doc['field']]) }}"
                                                      onsubmit="return confirm('Setuju dokumen {{ $doc['label'] }}? Peserta akan mendapat email bahwa dokumen ini diterima.');">
                                                    @csrf
                                                    <button type="submit" class="icon-btn icon-btn-approve" title="Setuju dokumen ini">
                                                        <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ $routePrefix === 'dashboard'
                                                        ? route('dashboard.pendaftaran.dokumen-item-tolak', [$pendaftaran->id, $doc['field']])
                                                        : route('admin.pendaftaran.dokumen-item-tolak', [$pendaftaran->id, $doc['field']]) }}"
                                                      onsubmit="return confirm('Tolak dokumen {{ $doc['label'] }}? Peserta akan mendapat email bahwa dokumen ini perlu perbaikan.');">
                                                    @csrf
                                                    <button type="submit" class="icon-btn icon-btn-reject" title="Tolak dokumen ini">
                                                        <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @else
                                        <span class="muted">Menunggu upload</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Info Pembayaran --}}
        <div class="section-card">
            <div class="section-head" style="background:linear-gradient(135deg,#22c55e,#16a34a)">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                </svg>
                <h3>Informasi Pembayaran</h3>
            </div>
            <div class="section-body">
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @if($pendaftaran->status_pembayaran === 'lunas')
                            <span class="pay-badge pay-green" style="font-size:12px"><span class="pay-badge-dot"></span>Lunas</span>
                        @elseif($pendaftaran->status_pembayaran === 'menunggu')
                            <span class="pay-badge pay-amber" style="font-size:12px"><span class="pay-badge-dot"></span>Menunggu</span>
                        @else
                            <span class="pay-badge pay-slate" style="font-size:12px"><span class="pay-badge-dot"></span>Belum Bayar</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Order ID</span>
                    <span class="info-value" style="font-family:monospace;font-size:12.5px">
                        {{ $pendaftaran->midtrans_order_id ?? '-' }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Transaction ID</span>
                    <span class="info-value" style="font-family:monospace;font-size:12.5px">
                        {{ $pendaftaran->midtrans_transaction_id ?? '-' }}
                    </span>
                </div>
                @if($pendaftaran->qris_expired_at)
                <div class="info-row">
                    <span class="info-label">QRIS Expired</span>
                    <span class="info-value" style="font-size:13px">
                        {{ $pendaftaran->qris_expired_at->format('d M Y, H:i') }} WIB
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(!$pendaftaran->periode_id && isset($periodes) && $periodes->isNotEmpty())
{{-- Modal Pilih Periode (tombol Centang di halaman detail) --}}
<div id="periodeModalShow" class="modal-backdrop" role="dialog" aria-labelledby="modalTitleShow" aria-modal="true">
    <div class="modal-box">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
            <h3 id="modalTitleShow" style="font-size:1.05rem;font-weight:700;color:#ffffff">Pilih Periode</h3>
            <button type="button" class="modal-close" onclick="document.getElementById('periodeModalShow').classList.remove('open')" aria-label="Tutup">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ $routePrefix === 'dashboard' ? route('dashboard.pendaftaran.assign-periode', $pendaftaran->id) : route('admin.pendaftaran.assign-periode', $pendaftaran->id) }}">
            @csrf
            <div class="form-group">
                <label for="periode_id_show">Periode</label>
                <select name="periode_id" id="periode_id_show" required>
                    <option value="">-- Pilih Periode --</option>
                    @foreach($periodes as $per)
                    <option value="{{ $per->id }}">{{ $per->nama }} ({{ $per->tanggal_mulai?->format('d M Y') }} – {{ $per->tanggal_selesai?->format('d M Y') }})</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="document.getElementById('periodeModalShow').classList.remove('open')">Batal</button>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('periodeModalShow')?.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
</script>
@endif
</div>

@endsection
