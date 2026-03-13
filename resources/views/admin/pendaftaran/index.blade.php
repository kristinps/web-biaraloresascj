@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Daftar Pendaftaran')
@section('page-title', 'Daftar Pendaftaran')
@section('page-subtitle', 'Semua pendaftaran kursus pernikahan')

@push('styles')
<style>
    .page-header {
        margin-bottom: 28px;
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
    .page-header h1 { font-size: 1.6rem; font-weight: 700; color: #fff; margin: 0 0 6px 0; text-shadow: 0 1px 3px rgba(0,0,0,0.2); letter-spacing: -0.02em; }
    .page-header p { font-size: 0.95rem; color: rgba(255,255,255,0.92); margin: 0; line-height: 1.4; }
    .pendaftaran-page .filter-bar {
        background: linear-gradient(135deg, rgba(99,102,241,0.14), rgba(139,92,246,0.10), rgba(56,189,248,0.08));
        border: 1px solid rgba(148,163,184,0.5);
        border-radius: 14px;
        padding: 18px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        box-shadow: 0 8px 24px rgba(15,23,42,0.08);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .search-wrap {
        position: relative;
        flex: 1;
        min-width: 220px;
    }
    .pendaftaran-page .search-wrap svg {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        width: 18px; height: 18px; color: #ffffff; pointer-events: none;
    }
    .pendaftaran-page .search-wrap input {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border: 1.5px solid rgba(148,163,184,0.5);
        border-radius: 12px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        outline: none;
        color: #ffffff;
        background: rgba(255,255,255,0.12);
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .pendaftaran-page .search-wrap input::placeholder { color: #ffffff; }
    .pendaftaran-page .search-wrap input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.25);
    }
    .btn-filter {
        padding: 12px 22px;
        background: linear-gradient(135deg, var(--primary, #2230ce), var(--primary-light, #3d56f5));
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: opacity 0.2s, box-shadow 0.2s, transform 0.15s;
    }
    .btn-reset {
        padding: 12px 18px;
        background: #f1f5f9;
        color: #64748b;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid #e2e8f0;
        transition: background 0.2s, color 0.2s;
    }
    .pendaftaran-page .btn-reset {
        background: rgba(255,255,255,0.2);
        color: #ffffff;
        border: 1px solid rgba(148,163,184,0.5);
    }
    .pendaftaran-page .card {
        background: linear-gradient(135deg, rgba(99,102,241,0.14), rgba(139,92,246,0.10), rgba(56,189,248,0.08));
        border-radius: 18px;
        border: 1px solid rgba(148,163,184,0.5);
        box-shadow: 0 8px 24px rgba(15,23,42,0.08);
        overflow: hidden;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .pendaftaran-page .table-info {
        padding: 14px 22px;
        font-size: 13px;
        color: #ffffff;
        background: rgba(99,102,241,0.15);
        border-bottom: 1px solid rgba(148,163,184,0.35);
    }
    .pendaftaran-page .table-info strong { color: #ffffff; }
    .pendaftaran-page table { width: 100%; border-collapse: collapse; }
    .pendaftaran-page td { vertical-align: middle; color: #ffffff; }
    .pendaftaran-page td small { color: #ffffff; }
    .pendaftaran-page tbody tr { vertical-align: middle; }
    .pendaftaran-page tbody tr:hover { background: transparent !important; }
    .pendaftaran-page .td-names { font-weight: 600; color: #ffffff; font-size: 14px; }
    .pendaftaran-page .td-names small { display: block; font-size: 12px; font-weight: 400; color: #ffffff; margin-top: 2px; }
    .pendaftaran-page .badge {
        display: inline-block;
        padding: 5px 11px;
        border-radius: 10px;
        font-size: 11.5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .pendaftaran-page .badge-terjadwal { background: rgba(99,102,241,0.35); color: #c7d2fe; }
    .pendaftaran-page .badge-sedang_berjalan { background: rgba(59,130,246,0.35); color: #bfdbfe; }
    .pendaftaran-page .badge-lulus { background: rgba(34,197,94,0.35); color: #bbf7d0; }
    .pendaftaran-page .badge-tidak_lulus { background: rgba(239,68,68,0.35); color: #fecaca; }
    .pendaftaran-page .btn-detail {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 16px; border-radius: 10px;
        background: rgba(255,255,255,0.2);
        color: #ffffff;
        font-size: 13px; font-weight: 600;
        text-decoration: none;
        border: 1px solid rgba(148,163,184,0.4);
        transition: background 0.15s, color 0.15s, box-shadow 0.15s;
    }
    .btn-detail svg { width: 15px; height: 15px; }
    .btn-approve {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 14px; border-radius: 10px;
        background: linear-gradient(135deg, #059669, #10b981);
        color: #fff;
        font-size: 13px; font-weight: 600;
        text-decoration: none;
        border: none;
        margin-left: 6px;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
        transition: opacity 0.15s, box-shadow 0.15s, transform 0.1s;
    }
    .btn-approve svg { width: 14px; height: 14px; }
    .pendaftaran-page .empty-state {
        text-align: center;
        padding: 64px 28px;
        color: #ffffff;
        font-size: 15px;
    }
    .pendaftaran-page .empty-state-icon {
        width: 80px; height: 80px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        background: rgba(255,255,255,0.12);
        color: #ffffff;
    }
    .empty-state-icon svg { width: 40px; height: 40px; }
    .pendaftaran-page .empty-state p { margin: 0 0 8px 0; color: #ffffff; }
    .pendaftaran-page .empty-state .hint { font-size: 14px; color: #ffffff; line-height: 1.5; }
    .pendaftaran-page .dashboard-table-footer {
        padding: 16px 22px;
        border-top: 1px solid rgba(148,163,184,0.35);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        background: rgba(99,102,241,0.08);
    }
    .pendaftaran-page .pagination-info { font-size: 13px; color: #ffffff; }
    .pendaftaran-page .dashboard-table-footer a,
    .pendaftaran-page .dashboard-table-footer span { color: #ffffff !important; }
    .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }
    .section-title {
        margin-top: 28px;
        margin-bottom: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }
    .pendaftaran-page .section-title h2 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: -0.01em;
    }
    .pendaftaran-page .section-title small {
        display: block;
        font-size: 0.8rem;
        color: #ffffff;
        margin-top: 2px;
    }
    .btn-primary-soft {
        padding: 9px 16px;
        border-radius: 999px;
        border: none;
        background: linear-gradient(135deg, #2230ce, #3d56f5);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 12px rgba(34,48,206,0.28);
    }
    .btn-primary-soft svg { width: 16px; height: 16px; }
    .badge-status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .pendaftaran-page .badge-status-aktif {
        background: rgba(34,197,94,0.35);
        color: #bbf7d0;
    }
    .pendaftaran-page .badge-status-selesai {
        background: rgba(248,250,252,0.25);
        color: #e5e7eb;
    }
    .pendaftaran-page .table-periode table {
        width: 100%;
        border-collapse: collapse;
    }
    .pendaftaran-page .table-periode th,
    .pendaftaran-page .table-periode td {
        padding: 10px 16px;
        font-size: 13px;
        border-bottom: 1px solid rgba(148,163,184,0.35);
        text-align: left;
        vertical-align: middle;
        white-space: nowrap;
    }
    .pendaftaran-page .table-periode th {
        background: rgba(99,102,241,0.18);
        font-weight: 600;
        color: #ffffff;
    }
    .pendaftaran-page .table-periode td {
        color: #ffffff;
    }
    .pendaftaran-page .table-periode tbody tr:hover {
        background: transparent;
    }
    .pendaftaran-page .btn-link {
        font-size: 12px;
        color: #c7d2fe;
        text-decoration: none;
        font-weight: 500;
        margin-right: 8px;
    }
    .pendaftaran-page .btn-link-danger {
        color: #fecaca;
    }
    .pendaftaran-page .subsection-title {
        margin-top: 24px;
        margin-bottom: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        color: #ffffff;
    }
    .pendaftaran-page .table-peserta-small {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .pendaftaran-page .table-peserta-small th,
    .pendaftaran-page .table-peserta-small td {
        padding: 8px 10px;
        border-bottom: 1px solid rgba(148,163,184,0.35);
        vertical-align: middle;
    }
    .pendaftaran-page .table-peserta-small th {
        background: rgba(99,102,241,0.18);
        font-weight: 600;
        color: #ffffff;
        text-align: left;
    }
    .pendaftaran-page .table-peserta-small td {
        color: #ffffff;
    }
    .btn-check {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 999px;
        border: none;
        background: #22c55e;
        color: #fff;
        cursor: pointer;
    }
    .btn-check svg {
        width: 18px;
        height: 18px;
    }
    .btn-check[disabled] {
        opacity: 0.4;
        cursor: default;
    }
    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15,23,42,0.45);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 120;
    }
    .modal-backdrop.open {
        display: flex;
    }
    .modal {
        background: linear-gradient(135deg, rgba(99,102,241,0.14), rgba(139,92,246,0.10), rgba(56,189,248,0.08));
        border: 1px solid rgba(148,163,184,0.5);
        border-radius: 18px;
        max-width: 460px;
        width: 100%;
        padding: 22px 22px 20px;
        box-shadow: 0 18px 45px rgba(15,23,42,0.35);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }
    .modal-header h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #ffffff;
    }
    .modal-close {
        background: none;
        border: none;
        cursor: pointer;
        color: rgba(255,255,255,0.8);
    }
    .modal-close svg {
        width: 18px;
        height: 18px;
    }
    .modal-body {
        margin-bottom: 12px;
    }
    .modal .form-group {
        margin-bottom: 10px;
    }
    .modal .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #ffffff;
        margin-bottom: 4px;
    }
    .modal .form-group input,
    .modal .form-group textarea,
    .modal .form-group select {
        width: 100%;
        border-radius: 10px;
        border: 1px solid rgba(148,163,184,0.5);
        padding: 8px 11px;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        color: #ffffff;
        background: rgba(255,255,255,0.12);
    }
    .modal .form-group input::placeholder,
    .modal .form-group textarea::placeholder { color: rgba(255,255,255,0.5); }
    .modal .form-group textarea {
        min-height: 70px;
        resize: vertical;
    }
    .modal .form-group select option { background: #1e293b; color: #ffffff; }
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 4px;
    }
    .modal .btn-secondary {
        padding: 8px 14px;
        border-radius: 999px;
        border: 1px solid rgba(148,163,184,0.5);
        background: rgba(255,255,255,0.2);
        font-size: 13px;
        color: #ffffff;
        cursor: pointer;
    }
    .modal .btn-primary {
        padding: 8px 18px;
        border-radius: 999px;
        border: none;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }
    @media (max-width: 768px) {
        .hide-mobile { display: none !important; }
        .filter-bar { padding: 14px 16px; }
        .page-header h1 { font-size: 1.35rem; }
        .page-header-icon { width: 44px; height: 44px; }
        .page-header-icon svg { width: 22px; height: 22px; }
    }
</style>
@endpush

@section('content')
@php
    $routePrefix = $routePrefix ?? (request()->routeIs('dashboard.*') ? 'dashboard' : 'admin');
@endphp
<div class="dashboard-user-content pendaftaran-page">
    <header class="dashboard-user-header">
        <h1 class="dashboard-user-title" style="color:#ffffff">Daftar Pendaftaran</h1>
        <p style="margin:8px 0 0 0;color:#ffffff;font-size:0.95rem">Pendaftaran yang belum memiliki periode</p>
    </header>

    @if(session('success'))
        <div style="margin-bottom:16px;padding:12px 18px;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:12px;color:#bbf7d0;font-size:14px">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="margin-bottom:16px;padding:12px 18px;background:rgba(239,68,68,0.2);border:1px solid rgba(239,68,68,0.4);border-radius:12px;color:#fecaca;font-size:14px">
            {{ session('error') }}
        </div>
    @endif

    <form method="GET" action="{{ $routePrefix === 'dashboard' ? route('dashboard.pendaftaran.index') : route('admin.pendaftaran.index') }}" class="filter-bar">
        <div class="search-wrap">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pasangan atau email..." aria-label="Cari">
        </div>
        <button type="submit" class="btn-filter">Cari</button>
        @if(request('search'))
            <a href="{{ $routePrefix === 'dashboard' ? route('dashboard.pendaftaran.index') : route('admin.pendaftaran.index') }}" class="btn-reset">Reset</a>
        @endif
    </form>

    <div class="card">
        @if($pendaftaran->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <p>Tidak ada pendaftaran yang belum memiliki periode</p>
                <p class="hint">Semua pendaftaran yang sudah memiliki periode tidak ditampilkan di sini.</p>
            </div>
        @else
            <div class="table-info">
                Menampilkan <strong>{{ $pendaftaran->firstItem() ?? 0 }}</strong> – <strong>{{ $pendaftaran->lastItem() ?? 0 }}</strong> dari <strong>{{ $pendaftaran->total() }}</strong> pendaftaran
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="padding:14px 22px;text-align:left;font-size:12px;text-transform:uppercase;letter-spacing:0.05em;color:#ffffff;background:rgba(99,102,241,0.15);border-bottom:1px solid rgba(148,163,184,0.35)">Nama Pasangan</th>
                        <th style="padding:14px 22px;text-align:left;font-size:12px;text-transform:uppercase;letter-spacing:0.05em;color:#ffffff;background:rgba(99,102,241,0.15);border-bottom:1px solid rgba(148,163,184,0.35);width:200px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaran as $p)
                    <tr>
                        <td style="padding:14px 22px;border-bottom:1px solid rgba(148,163,184,0.35)">
                            <span class="td-names">{{ $p->nama_pria }} &amp; {{ $p->nama_wanita }}</span>
                            <small>{{ $p->email }}</small>
                        </td>
                        <td style="padding:14px 22px;border-bottom:1px solid rgba(148,163,184,0.35)">
                            <a href="{{ $routePrefix === 'dashboard' ? route('dashboard.pendaftaran.show', $p->id) : route('admin.pendaftaran.show', $p->id) }}" class="btn-detail">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                            <button type="button" class="btn-check" onclick="openPeriodeModal('{{ $p->id }}', '{{ addslashes($p->nama_pria . ' & ' . $p->nama_wanita) }}')" title="Pilih Periode">
                                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="dashboard-table-footer">
                <span class="pagination-info">{{ $pendaftaran->firstItem() ?? 0 }}-{{ $pendaftaran->lastItem() ?? 0 }} dari {{ $pendaftaran->total() }}</span>
                <div>{{ $pendaftaran->withQueryString()->links() }}</div>
            </div>
        @endif
    </div>
</div>

{{-- Modal Pilih Periode (untuk tombol Centang) --}}
<div id="periodeModal" class="modal-backdrop" role="dialog" aria-labelledby="modalTitle" aria-modal="true">
    <div class="modal">
        <div class="modal-header">
            <h3 id="modalTitle">Pilih Periode</h3>
            <button type="button" class="modal-close" onclick="closePeriodeModal()" aria-label="Tutup">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="formAssignPeriode" method="POST" action="">
            @csrf
            <div class="modal-body">
                <p id="modalPasanganName" style="font-size:13px;color:#ffffff;margin-bottom:12px"></p>
                <div class="form-group">
                    <label for="periode_id">Periode</label>
                    <select name="periode_id" id="periode_id" required class="form-control" style="width:100%;padding:10px 12px;font-size:14px">
                        <option value="">-- Pilih Periode --</option>
                        @foreach($periodes ?? [] as $per)
                        <option value="{{ $per->id }}">{{ $per->nama }} ({{ $per->tanggal_mulai?->format('d M Y') }} – {{ $per->tanggal_selesai?->format('d M Y') }})</option>
                        @endforeach
                    </select>
                    @if(empty($periodes) || $periodes->isEmpty())
                        <p style="font-size:12px;color:#fecaca;margin-top:6px">Tidak ada periode aktif. Buat periode baru terlebih dahulu.</p>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closePeriodeModal()">Batal</button>
                <button type="submit" class="btn-primary" @if(empty($periodes) || $periodes->isEmpty()) disabled @endif>Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var assignPeriodeUrlTemplate = '{{ ($routePrefix === "dashboard" ? route("dashboard.pendaftaran.assign-periode", ["id" => "__ID__"]) : route("admin.pendaftaran.assign-periode", ["id" => "__ID__"])) }}';
    function openPeriodeModal(pendaftaranId, namaPasangan) {
        var modal = document.getElementById('periodeModal');
        var form = document.getElementById('formAssignPeriode');
        var nameEl = document.getElementById('modalPasanganName');
        if (modal && form && nameEl) {
            form.action = assignPeriodeUrlTemplate.replace('__ID__', pendaftaranId);
            nameEl.textContent = 'Pasangan: ' + (namaPasangan || '');
            var sel = document.getElementById('periode_id');
            if (sel) sel.value = '';
            modal.classList.add('open');
        }
    }
    function closePeriodeModal() {
        var modal = document.getElementById('periodeModal');
        if (modal) modal.classList.remove('open');
    }
    document.getElementById('periodeModal')?.addEventListener('click', function(e) {
        if (e.target === this) closePeriodeModal();
    });
</script>
@endpush
