@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Periode Pernikahan')
@section('page-title', 'Periode Pernikahan')
@section('page-subtitle', 'Kelola periode/batch kursus persiapan pernikahan')

@push('styles')
<style>
    .page-actions {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 24px;
    }
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 20px;
        background: linear-gradient(135deg,#6366f1,#8b5cf6);
        color: #fff;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(99,102,241,0.3);
        transition: opacity 0.2s;
    }
    .btn-primary:hover { opacity: 0.88; }
    .btn-primary svg { width: 16px; height: 16px; }

    .admin-periode-page .dashboard-user-title,
    .admin-periode-page .dashboard-user-header { color: #ffffff; }
    .section-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #ffffff;
        margin: 28px 0 12px;
    }
    .section-label:first-child { margin-top: 0; }

    .admin-periode-page .card {
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

    .table-card { padding: 0; }
    .table-wrap { overflow-x: auto; }
    .periode-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    .admin-periode-page .periode-table th,
    .admin-periode-page .periode-table td {
        padding: 14px 18px;
        text-align: left;
        border-bottom: 1px solid rgba(148,163,184,0.35);
        vertical-align: middle;
        color: #ffffff;
    }
    .admin-periode-page .periode-table thead th {
        background: rgba(99,102,241,0.15);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #ffffff;
    }
    .admin-periode-page .periode-table tbody tr {
        transition: background 0.15s ease;
    }
    .admin-periode-page .periode-table tbody tr:hover {
        background: rgba(255,255,255,0.08);
    }
    .periode-table .th-actions,
    .periode-table .td-actions { white-space: nowrap; text-align: right; }
    .btn-action-form { display: inline; }

    .badge-status {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 99px;
        font-size: 12px; font-weight: 600; white-space: nowrap;
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .badge-aktif  { background: rgba(34,197,94,0.35); color: #bbf7d0; }
    .badge-aktif .badge-dot  { background: #22c55e; }
    .badge-selesai { background: rgba(148,163,184,0.35); color: #e2e8f0; }
    .badge-selesai .badge-dot { background: #94a3b8; }

    .count-pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 99px;
        background: rgba(139,92,246,0.35); color: #e9d5ff;
        font-size: 12px; font-weight: 600;
    }

    .actions-group {
        display: flex; gap: 6px; align-items: center; flex-shrink: 0;
    }
    .admin-periode-page .btn-action {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 13px; border-radius: 8px;
        font-size: 12.5px; font-weight: 600;
        text-decoration: none; transition: background 0.15s, color 0.15s;
        border: none; cursor: pointer; background: rgba(255,255,255,0.2); color: #ffffff;
    }
    .admin-periode-page .btn-action:hover { background: rgba(99,102,241,0.5); color: #fff; }
    .admin-periode-page .btn-action.danger:hover { background: rgba(239,68,68,0.4); color: #fecaca; }
    .admin-periode-page .btn-action.success { background: rgba(34,197,94,0.35); color: #bbf7d0; }
    .admin-periode-page .btn-action.success:hover { background: rgba(34,197,94,0.5); color: #fff; }
    .admin-periode-page .btn-action.warning { background: rgba(245,158,11,0.35); color: #fef3c7; }
    .admin-periode-page .btn-action.warning:hover { background: rgba(245,158,11,0.5); color: #fff; }
    .btn-action svg { width: 13px; height: 13px; }

    .admin-periode-page .empty-state {
        text-align: center; padding: 48px 24px; color: rgba(255,255,255,0.9);
    }
    .empty-state svg { width: 48px; height: 48px; margin: 0 auto 14px; }
    .admin-periode-page .empty-state p { font-size: 14px; color: rgba(255,255,255,0.9); }
    .admin-periode-page .empty-state a { color: #c7d2fe; font-weight: 600; }

    .admin-periode-page .pagination-wrap {
        padding: 14px 24px;
        border-top: 1px solid rgba(148,163,184,0.35);
        display: flex; justify-content: flex-end;
    }
    .admin-periode-page .pagination-wrap a,
    .admin-periode-page .pagination-wrap span { color: #ffffff !important; }
</style>
@endpush

@section('content')
<div class="dashboard-user-content admin-periode-page">
    <header class="dashboard-user-header">
        <h1 class="dashboard-user-title">Periode Pernikahan</h1>
    </header>
    <div class="page-actions">
        <a href="{{ route($routePrefix . '.periode.create') }}" class="btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah Periode
        </a>
    </div>
    {{-- Daftar Periode Aktif --}}
    <div class="section-label">Daftar Periode Aktif</div>
    <div class="card table-card">
        @if($periodeAktif->count() > 0)
            <div class="table-wrap">
                <table class="periode-table">
                    <thead>
                        <tr>
                            <th>Nama Periode</th>
                            <th>Status Periode</th>
                            <th>Jumlah Peserta</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                            <th>Keterangan Periode</th>
                            <th class="th-actions">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($periodeAktif as $p)
                        <tr>
                            <td><strong>{{ $p->nama }}</strong></td>
                            <td>
                                <span class="badge-status badge-aktif">
                                    <span class="badge-dot"></span>Aktif
                                </span>
                            </td>
                            <td>{{ $p->pendaftaran_count }} peserta</td>
                            <td>{{ $p->tanggal_mulai->format('d M Y') }}</td>
                            <td>{{ $p->tanggal_selesai ? $p->tanggal_selesai->format('d M Y') : '–' }}</td>
                            <td>{{ Str::limit($p->catatan ?? '–', 40) }}</td>
                            <td class="td-actions">
                                <div class="actions-group">
                                    <a href="{{ route($routePrefix . '.periode.show', $p) }}" class="btn-action" title="Lihat detail & peserta">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        Lihat Detail
                                    </a>
                                    <a href="{{ route($routePrefix . '.periode.edit', $p) }}" class="btn-action" title="Edit">Edit</a>
                                    <form action="{{ route($routePrefix . '.periode.destroy', $p) }}" method="POST" class="btn-action-form"
                                        onsubmit="return confirm('Hapus periode {{ addslashes($p->nama) }}? Periode yang masih memiliki peserta tidak dapat dihapus.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action danger">Hapus</button>
                                    </form>
                                    <form action="{{ route($routePrefix . '.periode.tutup', $p) }}" method="POST" class="btn-action-form"
                                        onsubmit="return confirm('Tutup periode {{ addslashes($p->nama) }}? Periode tidak akan menerima pendaftaran baru.')">
                                        @csrf
                                        <button type="submit" class="btn-action warning">Tutup Periode</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#cbd5e1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
                <p>Belum ada periode aktif. <a href="{{ route($routePrefix . '.periode.create') }}" style="color:#6366f1;font-weight:600">Tambah periode</a> terlebih dahulu.</p>
            </div>
        @endif
    </div>

    {{-- Daftar Periode Selesai --}}
    <div class="section-label" style="margin-top:32px">Daftar Periode Selesai</div>
    <div class="card table-card">
        @if($periodeSelesai->count() > 0)
            <div class="table-wrap">
                <table class="periode-table">
                    <thead>
                        <tr>
                            <th>Nama Periode</th>
                            <th>Status Periode</th>
                            <th>Jumlah Peserta</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                            <th>Keterangan Periode</th>
                            <th class="th-actions">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($periodeSelesai as $p)
                        <tr>
                            <td><strong>{{ $p->nama }}</strong></td>
                            <td>
                                <span class="badge-status badge-selesai">
                                    <span class="badge-dot"></span>Selesai
                                </span>
                            </td>
                            <td>{{ $p->pendaftaran_count }} peserta</td>
                            <td>{{ $p->tanggal_mulai->format('d M Y') }}</td>
                            <td>{{ $p->tanggal_selesai ? $p->tanggal_selesai->format('d M Y') : '–' }}</td>
                            <td>{{ Str::limit($p->catatan ?? '–', 40) }}</td>
                            <td class="td-actions">
                                <div class="actions-group">
                                    <a href="{{ route($routePrefix . '.periode.show', $p) }}" class="btn-action" title="Lihat detail & peserta">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        Lihat Detail
                                    </a>
                                    <a href="{{ route($routePrefix . '.periode.edit', $p) }}" class="btn-action" title="Edit">Edit</a>
                                    <form action="{{ route($routePrefix . '.periode.destroy', $p) }}" method="POST" class="btn-action-form"
                                        onsubmit="return confirm('Hapus periode ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action danger">Hapus</button>
                                    </form>
                                    <form action="{{ route($routePrefix . '.periode.buka', $p) }}" method="POST" class="btn-action-form"
                                        onsubmit="return confirm('Aktifkan kembali periode ini?')">
                                        @csrf
                                        <button type="submit" class="btn-action success">Aktifkan</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($periodeSelesai->hasPages())
            <div class="pagination-wrap">{{ $periodeSelesai->links() }}</div>
            @endif
        @else
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#cbd5e1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                </svg>
                <p>Belum ada periode yang selesai.</p>
            </div>
        @endif
    </div>
</div>
@endsection


