@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Detail Pendaftaran #' . str_pad($pendaftaran->id, 5, '0', STR_PAD_LEFT))
@section('page-title', 'Detail Pendaftaran')
@section('page-subtitle', 'Informasi lengkap pendaftaran #' . str_pad($pendaftaran->id, 5, '0', STR_PAD_LEFT))

@push('styles')
<style>
    .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        font-size: 13.5px; font-weight: 600; color: #64748b;
        text-decoration: none; margin-bottom: 20px;
        transition: color 0.2s;
    }
    .back-link:hover { color: #6366f1; }
    .back-link svg { width: 16px; height: 16px; }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: start;
    }
    @media (max-width: 900px) { .detail-grid { grid-template-columns: 1fr; } }

    .section-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        margin-bottom: 20px;
    }
    .section-head {
        padding: 16px 22px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex; align-items: center; gap: 10px;
    }
    .section-head svg { width: 18px; height: 18px; color: rgba(255,255,255,0.8); }
    .section-head h3 { font-size: 14px; font-weight: 700; color: #fff; }
    .section-body { padding: 0; }

    .info-row {
        display: flex;
        padding: 12px 22px;
        border-bottom: 1px solid #f8fafc;
        gap: 16px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label {
        width: 42%;
        font-size: 13px;
        color: #94a3b8;
        font-weight: 500;
        flex-shrink: 0;
        line-height: 1.5;
    }
    .info-value {
        flex: 1;
        font-size: 13.5px;
        color: #1e293b;
        font-weight: 600;
        line-height: 1.5;
        word-break: break-word;
    }
    .info-value.muted { color: #94a3b8; font-weight: 400; font-style: italic; }

    /* Payment badge */
    .pay-badge {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 6px 14px; border-radius: 99px;
        font-size: 13px; font-weight: 700;
    }
    .pay-badge-dot { width: 8px; height: 8px; border-radius: 50%; }
    .pay-green { background: #f0fdf4; color: #15803d; }
    .pay-green .pay-badge-dot { background: #22c55e; }
    .pay-amber { background: #fffbeb; color: #b45309; }
    .pay-amber .pay-badge-dot { background: #f59e0b; }
    .pay-slate { background: #f8fafc; color: #475569; }
    .pay-slate .pay-badge-dot { background: #94a3b8; }

    /* Dokumen */
    .doc-link {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 12px; border-radius: 8px;
        background: #f1f5f9; color: #4f46e5;
        font-size: 12.5px; font-weight: 600;
        text-decoration: none; transition: background 0.15s;
    }
    .doc-link:hover { background: #e0e7ff; }
    .doc-link svg { width: 13px; height: 13px; }

    .doc-table { width: 100%; border-collapse: collapse; }
    .doc-table thead th {
        padding: 10px 18px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6b7280;
        background: #f9fafb;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }
    .doc-table tbody td {
        padding: 10px 18px;
        font-size: 12.5px;
        color: #1f2933;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    .doc-table tbody tr:hover { background: #f9fafb; }
    .doc-table .doc-name { font-weight: 600; color: #111827; }
    .doc-table .doc-empty { color: #9ca3af; font-style: italic; }
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
    .icon-btn-approve { color: #16a34a; background: #ecfdf3; }
    .icon-btn-approve:hover { background: #bbf7d0; box-shadow: 0 2px 8px rgba(22,163,74,0.25); transform: translateY(-1px); }
    .icon-btn-reject { color: #dc2626; background: #fef2f2; }
    .icon-btn-reject:hover { background: #fecaca; box-shadow: 0 2px 8px rgba(220,38,38,0.25); transform: translateY(-1px); }

    /* Dokumen & kursus status badges */
    .dok-badge { display:inline-flex;align-items:center;gap:7px;padding:5px 13px;border-radius:99px;font-size:12.5px;font-weight:700; }
    .dok-badge-dot { width:7px;height:7px;border-radius:50%; }
    .dok-lengkap { background:#f0fdf4;color:#15803d; } .dok-lengkap .dok-badge-dot { background:#22c55e; }
    .dok-tidak   { background:#fef2f2;color:#dc2626; } .dok-tidak .dok-badge-dot   { background:#ef4444; }
    .dok-periksa { background:#fffbeb;color:#b45309; } .dok-periksa .dok-badge-dot { background:#f59e0b; }

    .kursus-badge { display:inline-flex;align-items:center;gap:6px;padding:4px 11px;border-radius:99px;font-size:12px;font-weight:700; }
    .kursus-badge-dot { width:6px;height:6px;border-radius:50%; }
    .kb-belum   { background:#f8fafc;color:#475569; } .kb-belum .kursus-badge-dot   { background:#94a3b8; }
    .kb-terjadwal { background:#eff6ff;color:#1d4ed8; } .kb-terjadwal .kursus-badge-dot { background:#3b82f6; }
    .kb-berjalan  { background:#fef3c7;color:#b45309; } .kb-berjalan .kursus-badge-dot  { background:#f59e0b; }
    .kb-lulus { background:#f0fdf4;color:#15803d; } .kb-lulus .kursus-badge-dot { background:#22c55e; }
    .kb-tidak { background:#fef2f2;color:#dc2626; } .kb-tidak .kursus-badge-dot { background:#ef4444; }

    .action-card { background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.04);margin-bottom:20px; }
    .action-head { padding:14px 22px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;gap:9px; }
    .action-head svg { width:17px;height:17px;color:rgba(255,255,255,0.85); }
    .action-head h3 { font-size:13.5px;font-weight:700;color:#fff; }
    .action-body { padding:20px 22px; }

    .form-group { margin-bottom:14px; }
    .form-label { display:block;font-size:12.5px;font-weight:600;color:#374151;margin-bottom:5px; }
    .form-select, .form-textarea { width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13.5px;color:#1e293b;background:#fff;outline:none;transition:border-color 0.2s;font-family:inherit; }
    .form-select:focus, .form-textarea:focus { border-color:#6366f1; }
    .form-textarea { resize:vertical;min-height:80px; }

    .btn-action { display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;border:none;transition:opacity 0.2s; }
    .btn-action:hover { opacity:0.88; }
    .btn-action svg { width:14px;height:14px; }
    .btn-indigo { background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff; }

    .check-row { display:flex;align-items:center;gap:8px;margin-top:10px; }
    .check-row input[type=checkbox] { width:15px;height:15px;cursor:pointer;accent-color:#6366f1; }
    .check-row label { font-size:13px;color:#374151;cursor:pointer; }

    /* Full-width top card */
    .top-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 22px 24px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }
    .top-card .reg-id { font-size: 22px; font-weight: 800; color: #1e293b; }
    .top-card .reg-id span { color: #6366f1; }
    .top-card .reg-date { font-size: 13px; color: #94a3b8; margin-top: 3px; }
</style>
@endpush

@section('content')
@php
    $routePrefix = $routePrefix ?? (request()->routeIs('dashboard.*') ? 'dashboard' : 'admin');
@endphp

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
            <span style="font-size:12px;color:#94a3b8;background:#f8fafc;padding:6px 12px;border-radius:8px;font-family:monospace">
                {{ $pendaftaran->midtrans_order_id }}
            </span>
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
                <p style="font-size:12px;color:#64748b;margin:0;">Email notifikasi akan otomatis dikirim ke peserta ({{ $pendaftaran->email }})</p>
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
                    $docs = [
                        ['label' => 'KTP Calon Pria',              'file' => $pendaftaran->ktp_pria],
                        ['label' => 'KTP Calon Wanita',            'file' => $pendaftaran->ktp_wanita],
                        ['label' => 'Surat Baptis Pria',           'file' => $pendaftaran->surat_baptis_pria],
                        ['label' => 'Surat Baptis Wanita',         'file' => $pendaftaran->surat_baptis_wanita],
                        ['label' => 'Surat Pengantar Kombas Pria', 'file' => $pendaftaran->surat_pengantar_kombas_pria],
                        ['label' => 'Surat Pengantar Kombas Wanita','file' => $pendaftaran->surat_pengantar_kombas_wanita],
                    ];
                @endphp
                <div style="overflow-x:auto">
                    <table class="doc-table">
                        <thead>
                            <tr>
                                <th>Nama Dokumen</th>
                                <th>File Dokumen</th>
                                <th style="width:120px">Aksi Dokumen</th>
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
                                    <div class="doc-aksi">
                                        <form method="POST" action="{{ $routePrefix === 'dashboard' ? route('dashboard.pendaftaran.dokumen-setuju', $pendaftaran->id) : route('admin.pendaftaran.dokumen-setuju', $pendaftaran->id) }}" onsubmit="return confirm('Setuju semua dokumen untuk pendaftaran ini? Email notifikasi akan dikirim ke peserta.');">
                                            @csrf
                                            <button type="submit" class="icon-btn icon-btn-approve" title="Setuju (dokumen diterima)">
                                                <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ $routePrefix === 'dashboard' ? route('dashboard.pendaftaran.dokumen-tolak', $pendaftaran->id) : route('admin.pendaftaran.dokumen-tolak', $pendaftaran->id) }}" onsubmit="return confirm('Tolak dokumen pendaftaran ini? Peserta akan melihat status Tidak Diterima dan dapat mengirim perbaikan.');">
                                            @csrf
                                            <button type="submit" class="icon-btn icon-btn-reject" title="Tolak (dokumen tidak diterima)">
                                                <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
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

@endsection
