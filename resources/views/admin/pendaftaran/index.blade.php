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
    .filter-bar {
        background: rgba(255,255,255,0.98);
        border: 1px solid rgba(255,255,255,0.4);
        border-radius: 14px;
        padding: 18px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }
    .search-wrap {
        position: relative;
        flex: 1;
        min-width: 220px;
    }
    .search-wrap svg {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        width: 18px; height: 18px; color: #94a3b8; pointer-events: none;
    }
    .search-wrap input {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        outline: none;
        color: #374151;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-wrap input::placeholder { color: #94a3b8; }
    .search-wrap input:focus {
        border-color: var(--primary, #2230ce);
        box-shadow: 0 0 0 3px rgba(34,48,206,0.12);
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
    .btn-filter:hover { opacity: 0.95; box-shadow: 0 4px 14px rgba(34,48,206,0.35); transform: translateY(-1px); }
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
    .btn-reset:hover { background: #e2e8f0; color: #475569; }
    .card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,0.5);
        box-shadow: 0 6px 24px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .table-info {
        padding: 14px 22px;
        font-size: 13px;
        color: #64748b;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
    }
    .table-info strong { color: #475569; }
    .pendaftaran-page table { width: 100%; border-collapse: collapse; }
    .pendaftaran-page td { vertical-align: middle; }
    .pendaftaran-page tbody tr { transition: background 0.15s; }
    .pendaftaran-page tbody tr:hover { background: #f8faff; }
    .td-names { font-weight: 600; color: #1e293b; font-size: 14px; }
    .td-names small { display: block; font-size: 12px; font-weight: 400; color: #64748b; margin-top: 2px; }
    .badge {
        display: inline-block;
        padding: 5px 11px;
        border-radius: 10px;
        font-size: 11.5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .badge-terjadwal { background: #e0e7ff; color: #3730a3; }
    .badge-sedang_berjalan { background: #dbeafe; color: #1d4ed8; }
    .badge-lulus { background: #d1fae5; color: #047857; }
    .badge-tidak_lulus { background: #fee2e2; color: #b91c1c; }
    .btn-detail {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 16px; border-radius: 10px;
        background: linear-gradient(180deg, #f0f4ff 0%, #eef2ff 100%);
        color: #2129a7;
        font-size: 13px; font-weight: 600;
        text-decoration: none;
        border: 1px solid #bfd0ff;
        transition: background 0.15s, color 0.15s, box-shadow 0.15s;
    }
    .btn-detail:hover { background: #dce6ff; color: #1e2685; box-shadow: 0 2px 8px rgba(34,48,206,0.15); }
    .btn-detail svg { width: 15px; height: 15px; }
    .empty-state {
        text-align: center;
        padding: 64px 28px;
        color: #64748b;
        font-size: 15px;
    }
    .empty-state-icon {
        width: 80px; height: 80px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #94a3b8;
    }
    .empty-state-icon svg { width: 40px; height: 40px; }
    .empty-state p { margin: 0 0 8px 0; }
    .empty-state .hint { font-size: 14px; color: #94a3b8; line-height: 1.5; }
    .dashboard-table-footer {
        padding: 16px 22px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        background: #fafbfc;
    }
    .pagination-info { font-size: 13px; color: #64748b; }
    .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }
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
    $hasFilter = request('search');
@endphp

<div class="page-header">
    <div class="page-header-icon">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
    </div>
    <div>
        <h1>Daftar Pendaftaran</h1>
        <p>Kelola semua pendaftaran kursus pernikahan dari satu tempat</p>
    </div>
</div>

<div class="filter-bar">
    <form method="GET" action="{{ route($routePrefix . '.pendaftaran.index') }}" class="filter-form" style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;flex:1;">
        <div class="search-wrap">
            <label for="search" class="sr-only">Cari</label>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <input type="text" id="search" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama pasangan atau email...">
        </div>
        <button type="submit" class="btn-filter">Cari</button>
        @if($hasFilter)
            <a href="{{ route($routePrefix . '.pendaftaran.index') }}" class="btn-reset">Reset</a>
        @endif
    </form>
</div>

<div class="card pendaftaran-page">
    @if($pendaftaran->count() > 0)
        @php
            $start = ($pendaftaran->currentPage() - 1) * $pendaftaran->perPage() + 1;
            $end = min($pendaftaran->currentPage() * $pendaftaran->perPage(), $pendaftaran->total());
        @endphp
        <div class="table-info">
            Menampilkan <strong>{{ $start }}–{{ $end }}</strong> dari <strong>{{ $pendaftaran->total() }}</strong> pendaftaran
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:52px">No</th>
                        <th>Pasangan</th>
                        <th class="hide-mobile">Tanggal Nikah</th>
                        <th class="hide-mobile">Tanggal Daftar</th>
                        <th class="hide-mobile">Status Kursus</th>
                        <th style="width:110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaran as $index => $item)
                    <tr>
                        <td style="color:#64748b;font-size:13px">{{ $start + $index }}</td>
                        <td>
                            <div class="td-names">
                                {{ $item->nama_pria }} &amp; {{ $item->nama_wanita }}
                                <small>{{ $item->email }}</small>
                            </div>
                        </td>
                        <td class="hide-mobile" style="color:#64748b;font-size:13px">
                            {{ $item->tanggal_pernikahan ? $item->tanggal_pernikahan->format('d M Y') : '–' }}
                        </td>
                        <td class="hide-mobile" style="color:#64748b;font-size:13px">
                            {{ $item->created_at->format('d M Y') }}
                        </td>
                        <td class="hide-mobile">
                            @php
                                $sk = $item->status_kursus ?? 'terjadwal';
                                $skLabel = match($sk) { 'lulus' => 'Lulus', 'tidak_lulus' => 'Tidak lulus', 'sedang_berjalan' => 'Berjalan', default => 'Terjadwal' };
                            @endphp
                            <span class="badge badge-{{ $sk }}">{{ $skLabel }}</span>
                        </td>
                        <td>
                            <a href="{{ route($routePrefix . '.pendaftaran.show', $item->id) }}" class="btn-detail">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="dashboard-table-footer">
            <span class="pagination-info">Halaman {{ $pendaftaran->currentPage() }} dari {{ $pendaftaran->lastPage() }}</span>
            {{ $pendaftaran->appends(request()->query())->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
            </div>
            <p><strong>Tidak ada data pendaftaran</strong></p>
            <p class="hint">{{ $hasFilter ? 'Coba ubah kata kunci atau reset filter pencarian.' : 'Belum ada peserta yang mendaftar kursus pernikahan.' }}</p>
        </div>
    @endif
</div>

@endsection
