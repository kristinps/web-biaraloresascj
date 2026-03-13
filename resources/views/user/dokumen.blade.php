@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'layouts.dashboard')

@section('title', 'Kelengkapan Dokumen')
@section('page-title', 'Kelengkapan Dokumen')
@section('page-subtitle', 'Status dan kelengkapan dokumen tiap pendaftaran')

@push('styles')
<style>
    /* Body structure (sama seperti admin periode index) */
    .user-dokumen-page .dashboard-user-title,
    .user-dokumen-page .dashboard-user-header { color: #ffffff; }
    .user-dokumen-page .section-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #ffffff;
        margin: 28px 0 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .user-dokumen-page .section-label:first-of-type { margin-top: 0; }
    .user-dokumen-page .card {
        background: linear-gradient(135deg,
            rgba(99,102,241,0.14),
            rgba(139,92,246,0.10),
            rgba(56,189,248,0.08)
        );
        border-radius: 16px;
        border: 1px solid rgba(148,163,184,0.5);
        box-shadow: 0 8px 24px rgba(15,23,42,0.08);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        overflow: hidden;
        margin-bottom: 8px;
    }
    .user-dokumen-page .table-card { padding: 0; }
    .user-dokumen-page .table-wrap { overflow-x: auto; }
    .user-dokumen-page .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: rgba(255,255,255,0.9);
    }
    .user-dokumen-page .empty-state svg { width: 48px; height: 48px; margin: 0 auto 14px; }
    .user-dokumen-page .empty-state p { font-size: 14px; color: rgba(255,255,255,0.9); }

    .dokumen-toast { border-radius: 10px; padding: 12px 16px; font-size: 13px; margin-bottom: 16px; display: inline-flex; align-items: center; gap: 10px; max-width: 100%; }
    .dokumen-toast-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
    .dokumen-toast-success svg { color: #16a34a; flex-shrink: 0; }
    .dokumen-toast-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
    .dokumen-toast-error svg { color: #ef4444; flex-shrink: 0; }
    .dokumen-kotak {
        background: linear-gradient(135deg,
            rgba(99,102,241,0.14),
            rgba(139,92,246,0.10),
            rgba(56,189,248,0.08)
        );
        border-radius: 16px;
        border: 1px solid rgba(148,163,184,0.5);
        box-shadow: 0 8px 24px rgba(15,23,42,0.08);
        overflow: hidden;
        padding: 20px 24px;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .dokumen-summary {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .dokumen-summary-card {
        background: rgba(15,23,42,0.25);
        border-radius: 10px;
        padding: 10px 14px;
        border: 1px solid rgba(148,163,184,0.6);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .dokumen-summary-icon {
        width: 34px; height: 34px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .dokumen-summary-icon svg { width: 17px; height: 17px; color: #fff; }
    .dokumen-summary-icon.purple { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
    .dokumen-summary-icon.green { background: linear-gradient(135deg, #22c55e, #4ade80); }
    .dokumen-summary-icon.amber { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .dokumen-summary-icon.blue { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
    .dokumen-summary-body .val { font-size: 18px; font-weight: 800; color: #ffffff; line-height: 1; }
    .dokumen-summary-body .lbl { font-size: 11px; color: rgba(255,255,255,0.85); margin-top: 0; font-weight: 500; }

    /* Semua teks di dalam tabel pada halaman ini wajib putih */
    .user-dokumen-page table th,
    .user-dokumen-page table td,
    .user-dokumen-page .doc-status-name {
        color: #ffffff !important;
    }

    .doc-card {
        background: rgba(15,23,42,0.25);
        border-radius: 12px;
        border: 1px solid rgba(148,163,184,0.6);
        overflow: hidden;
        margin-bottom: 12px;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    .doc-card:last-child { margin-bottom: 0; }
    .doc-card-header {
        padding: 12px 18px;
        border-bottom: 1px solid rgba(148,163,184,0.4);
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px 12px;
    }
    .doc-card-periode {
        padding: 2px 8px;
        border-radius: 999px;
        background: rgba(129,140,248,0.35);
        color: #e0e7ff;
        font-size: 10.5px;
        font-weight: 700;
    }
    .doc-card-title { font-size: 15px; font-weight: 700; color: #ffffff; margin: 0; flex: 1; min-width: 120px; }
    .doc-card-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }
    .doc-card-status.lengkap { background: rgba(34,197,94,0.35); color: #bbf7d0; }
    .doc-card-status.tidak_lengkap { background: rgba(245,158,11,0.35); color: #fef3c7; }
    .doc-card-status.sedang { background: rgba(59,130,246,0.35); color: #bfdbfe; }
    .doc-card-status.belum { background: rgba(148,163,184,0.35); color: #e2e8f0; }
    .doc-card-catatan {
        font-size: 11.5px;
        color: rgba(255,255,255,0.9);
        width: 100%;
        margin: 2px 0 0;
    }

    .doc-list {
        padding: 8px 18px 12px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2px 16px;
    }
    .doc-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 6px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .doc-item:nth-last-child(-n+2) { border-bottom: none; }
    .doc-item-left {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
    }
    .doc-item-icon {
        width: 26px; height: 26px;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .doc-item-icon svg { width: 13px; height: 13px; }
    .doc-item-icon.uploaded { background: #f0fdf4; color: #16a34a; }
    .doc-item-icon.pending { background: #f1f5f9; color: #94a3b8; }
    .doc-name { font-size: 12.5px; color: #ffffff; font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .doc-badge {
        padding: 2px 8px;
        border-radius: 999px;
        font-size: 10.5px;
        font-weight: 600;
        flex-shrink: 0;
    }
    .doc-badge.uploaded { background: rgba(34,197,94,0.35); color: #bbf7d0; }
    .doc-badge.pending { background: rgba(148,163,184,0.35); color: #e2e8f0; }

    .doc-card-footer {
        padding: 8px 18px 12px;
        border-top: 1px solid rgba(148,163,184,0.4);
        background: transparent;
    }
    .doc-card-footer .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: rgba(255,255,255,0.2);
        color: #ffffff;
        border: 1px solid rgba(148,163,184,0.6);
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }
    .doc-card-footer .btn-detail svg { width: 14px; height: 14px; }
    .doc-perbaikan-wrap {
        padding: 14px 18px;
        border-top: 1px solid #f1f5f9;
        background: rgba(254,252,232,0.12);
        border-left: 3px solid #facc15;
    }
    .doc-perbaikan-label { font-size: 12px; color: #fef3c7; margin: 0 0 10px 0; font-weight: 600; }
    .doc-perbaikan-form { display: flex; flex-direction: column; gap: 10px; }
    .doc-perbaikan-input {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid rgba(148,163,184,0.6);
        border-radius: 8px;
        font-size: 13px;
        font-family: inherit;
        resize: vertical;
        min-height: 72px;
    }
    .doc-perbaikan-input:focus { outline: none; border-color: #6366f1; }
    .doc-perbaikan-error { font-size: 12px; color: #fecaca; margin: -4px 0 0 0; }
    .btn-kirim-perbaikan {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: opacity 0.2s, box-shadow 0.2s;
    }
    .btn-kirim-perbaikan:hover { opacity: 0.95; box-shadow: 0 4px 14px rgba(99,102,241,0.35); }

    .dokumen-empty {
        text-align: center;
        padding: 36px 24px;
    }
    .dokumen-empty-icon {
        width: 56px; height: 56px;
        margin: 0 auto 14px;
        border-radius: 14px;
        background: rgba(15,23,42,0.3);
        display: flex; align-items: center; justify-content: center;
    }
    .dokumen-empty-icon svg { width: 26px; height: 26px; color: #94a3b8; }
    .dokumen-empty h3 { font-size: 16px; font-weight: 700; color: #ffffff; margin-bottom: 4px; }
    .dokumen-empty p { font-size: 13px; color: rgba(255,255,255,0.9); margin-bottom: 16px; }
    .dokumen-empty .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: transform 0.15s, box-shadow 0.2s;
    }
    .dokumen-empty .btn-cta:hover { box-shadow: 0 4px 14px rgba(99,102,241,0.35); }

    /* Status Dokumen table */
    .doc-status-section { padding: 16px 18px; border-top: 1px solid rgba(148,163,184,0.35); }
    .doc-status-title { font-size: 13.5px; font-weight: 700; color: #ffffff; margin: 0 0 12px 0; }
    .user-dokumen-page .table-wrap .doc-status-table { margin: 0; }
    .doc-status-table { width: 100%; border-collapse: collapse; font-size: 12.5px; background: transparent; }
    .doc-status-table thead,
    .doc-status-table thead tr,
    .doc-status-table thead th {
        background: transparent !important;
        border: none;
        border-bottom: 1px solid rgba(148,163,184,0.4);
    }
    .doc-status-table th {
        padding: 10px 12px;
        text-align: left;
        font-weight: 700;
        color: #ffffff;
    }
    .doc-status-table td { padding: 10px 12px; border-bottom: 1px solid rgba(148,163,184,0.4); vertical-align: middle; color: #ffffff; }
    .doc-status-table tbody tr:hover { background: transparent !important; }
    .doc-status-name { font-weight: 500; }
    .doc-file-link { display: inline-flex; align-items: center; gap: 6px; color: #ffffff; font-weight: 600; text-decoration: none; }
    .doc-file-empty { color: #ffffff; font-style: italic; }
    .doc-status-ok { font-size: 16px; color: #bbf7d0; font-weight: bold; }
    .doc-status-no { font-size: 16px; color: #fecaca; font-weight: bold; }
    .doc-status-select { padding: 6px 10px; border: 1px solid rgba(148,163,184,0.5); border-radius: 8px; font-size: 12px; background: rgba(15,23,42,0.8); color: #ffffff; }
    .doc-status-actions { padding-top: 8px; }

    /* Form upload dokumen (saat status ✖) */
    .doc-upload-form { display: inline-flex; flex-wrap: wrap; align-items: center; gap: 8px; }
    .doc-upload-wrap { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .doc-file-input {
        font-size: 12px;
        padding: 4px 0;
        color: #ffffff;
        background: transparent;
    }
    .doc-file-input::file-selector-button {
        padding: 4px 10px;
        margin-right: 8px;
        border-radius: 6px;
        border: 1px solid rgba(148,163,184,0.6);
        background: rgba(15,23,42,0.6);
        color: #ffffff;
        font-size: 11.5px;
        cursor: pointer;
    }
    .btn-kirim-file {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 6px 12px; font-size: 11.5px; font-weight: 600;
        background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff;
        border: none; border-radius: 6px; cursor: pointer;
        transition: opacity 0.2s;
    }
    .btn-kirim-file:hover { opacity: 0.9; }

    @media (max-width: 640px) {
        .doc-list { grid-template-columns: 1fr; }
        .doc-item { border-bottom: 1px solid #f1f5f9; }
        .doc-item:nth-child(4n), .doc-item:nth-child(4n-1) { border-bottom: 1px solid #f1f5f9; }
        .doc-item:last-child { border-bottom: none; }
    }
    @media (max-width: 768px) {
        .doc-card-header, .doc-list, .doc-card-footer { padding-left: 14px; padding-right: 14px; }
    }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="dokumen-toast dokumen-toast-success">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="dokumen-toast dokumen-toast-error">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
        {{ session('error') }}
    </div>
@endif

<div class="dashboard-user-content user-dokumen-page">
    <header class="dashboard-user-header">
        <h1 class="dashboard-user-title">Kelengkapan Dokumen</h1>
    </header>

    @if($pendaftaranList->isEmpty())
        <div class="section-label">Kelengkapan Dokumen</div>
        <div class="card table-card">
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#cbd5e1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p>Belum ada pendaftaran. Silakan daftar terlebih dahulu untuk mengelola dokumen.</p>
            </div>
        </div>
    @else
        @foreach($pendaftaranList as $p)
            <div class="section-label">
                {{ $p->namaLengkap() }}
                @if($p->periode)
                    <span class="doc-card-periode">{{ $p->periode->nama ?? 'Periode ' . $p->periode->tahun }}</span>
                @endif
            </div>
            <div class="card table-card">
                <div class="table-wrap">
                    <table class="doc-status-table">
                        <thead>
                            <tr>
                                <th>Nama Dokumen</th>
                                <th>File Dokumen</th>
                                <th>Status Dokumen</th>
                                <th>Unggah File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $perFieldStatus = $p->dokumen_status_verifikasi ?? [];
                            @endphp
                            @foreach(\App\Models\PendaftaranPernikahan::dokumenFields() as $field => $label)
                                @php
                                    $filePath = $p->$field;
                                    $rawStatus = $perFieldStatus[$field] ?? null;
                                    $decided   = array_key_exists($field, $perFieldStatus);
                                    $accepted  = $decided && filter_var($rawStatus, FILTER_VALIDATE_BOOLEAN);
                                    $rejected  = $decided && !$accepted;
                                @endphp
                                <tr>
                                    <td class="doc-status-name">{{ $label }}</td>
                                    <td>
                                        @if(!empty($filePath))
                                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank" rel="noopener" class="doc-file-link">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                Lihat File
                                            </a>
                                        @else
                                            <span class="doc-file-empty">Belum diunggah</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(empty($filePath))
                                            <span class="doc-status-no" title="Belum diunggah">✖</span>
                                        @else
                                            @if($accepted)
                                                <span class="doc-status-ok" title="Dokumen diterima">✔ Diterima</span>
                                            @elseif($rejected)
                                                <span class="doc-status-no" title="Dokumen ditolak / perlu perbaikan">✖ Ditolak</span>
                                            @else
                                                <span class="doc-file-empty">Sedang diperiksa</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($accepted && !empty($filePath))
                                            <span class="doc-file-empty">—</span>
                                        @elseif($rejected || empty($filePath))
                                            <form class="doc-upload-form" action="{{ route('user.pendaftaran.upload-dokumen', $p->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="field" value="{{ $field }}">
                                                <div class="doc-upload-wrap">
                                                    <input type="file" name="file" class="doc-file-input" accept="{{ in_array($field, ['foto_pria', 'foto_wanita']) ? 'image/jpeg,image/png,image/jpg' : 'image/jpeg,image/png,image/jpg,.pdf' }}" required>
                                                    <button type="submit" class="btn-kirim-file">
                                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                        Kirim File
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <span class="doc-file-empty">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>

@endsection
