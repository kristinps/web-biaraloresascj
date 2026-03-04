@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data pendaftaran kursus pernikahan')

@push('styles')
<style>
    /* ─── Stat Cards ─── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }
    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 22px 24px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .stat-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .stat-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon svg { width: 24px; height: 24px; color: #fff; }
    .stat-icon.blue   { background: linear-gradient(135deg,#6366f1,#818cf8); box-shadow: 0 6px 16px rgba(99,102,241,0.3); }
    .stat-icon.green  { background: linear-gradient(135deg,#22c55e,#4ade80); box-shadow: 0 6px 16px rgba(34,197,94,0.3); }
    .stat-icon.amber  { background: linear-gradient(135deg,#f59e0b,#fbbf24); box-shadow: 0 6px 16px rgba(245,158,11,0.3); }
    .stat-icon.slate  { background: linear-gradient(135deg,#64748b,#94a3b8); box-shadow: 0 6px 16px rgba(100,116,139,0.25); }
    .stat-body .val   { font-size: 28px; font-weight: 800; color: #1e293b; line-height: 1; }
    .stat-body .lbl   { font-size: 13px; color: #64748b; margin-top: 4px; font-weight: 500; }

    /* ─── Table Card ─── */
    .card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .card-header {
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }
    .card-header h2 {
        font-size: 15.5px;
        font-weight: 700;
        color: #1e293b;
    }
    .card-header p {
        font-size: 12.5px;
        color: #94a3b8;
        margin-top: 2px;
    }
    .btn-sm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: linear-gradient(135deg,#6366f1,#8b5cf6);
        color: #fff;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(99,102,241,0.3);
        transition: opacity 0.2s;
    }
    .btn-sm:hover { opacity: 0.88; }
    .btn-sm svg { width: 14px; height: 14px; }

    /* Table */
    table { width: 100%; border-collapse: collapse; }
    thead th {
        padding: 12px 20px;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        background: #f8fafc;
        text-align: left;
        border-bottom: 1px solid #f1f5f9;
    }
    tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background 0.15s;
    }
    tbody tr:hover { background: #f8fafc; }
    tbody tr:last-child { border-bottom: none; }
    td {
        padding: 14px 20px;
        font-size: 13.5px;
        color: #374151;
        vertical-align: middle;
    }
    .td-num { color: #6366f1; font-weight: 700; font-size: 13px; }
    .td-names { font-weight: 600; color: #1e293b; font-size: 13.5px; }
    .td-names small { display: block; font-size: 12px; font-weight: 400; color: #94a3b8; margin-top: 1px; }

    /* Badge */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 99px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .badge-green  { background: #f0fdf4; color: #15803d; }
    .badge-green .badge-dot  { background: #22c55e; }
    .badge-amber  { background: #fffbeb; color: #b45309; }
    .badge-amber .badge-dot  { background: #f59e0b; }
    .badge-slate  { background: #f8fafc; color: #475569; }
    .badge-slate .badge-dot  { background: #94a3b8; }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 13px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #475569;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
        border: none; cursor: pointer;
    }
    .btn-detail:hover { background: #e0e7ff; color: #4f46e5; }
    .btn-detail svg { width: 13px; height: 13px; }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 56px 24px;
        color: #94a3b8;
    }
    .empty-state svg { width: 48px; height: 48px; margin: 0 auto 14px; }
    .empty-state p { font-size: 14px; }

    /* Pagination */
    .pagination-wrap {
        padding: 16px 24px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
    }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr 1fr; }
        .hide-mobile { display: none; }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
            </svg>
        </div>
        <div class="stat-body">
            <div class="val">{{ $stats['total'] }}</div>
            <div class="lbl">Total Pendaftaran</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="stat-body">
            <div class="val">{{ $stats['lunas'] }}</div>
            <div class="lbl">Pembayaran Lunas</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="stat-body">
            <div class="val">{{ $stats['menunggu'] }}</div>
            <div class="lbl">Menunggu Pembayaran</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon slate">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
            </svg>
        </div>
        <div class="stat-body">
            <div class="val">{{ $stats['belum_bayar'] }}</div>
            <div class="lbl">Belum Bayar</div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header">
        <div>
            <h2>Pendaftaran Terbaru</h2>
            <p>10 pendaftaran terbaru yang masuk</p>
        </div>
        <a href="https://admin.biaraloresa.my.id/pendaftaran" class="btn-sm">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
            </svg>
            Lihat Semua
        </a>
    </div>

    @if($pendaftaran->count() > 0)
        <div style="overflow-x:auto">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pasangan</th>
                        <th class="hide-mobile">Tanggal Daftar</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaran as $item)
                    <tr>
                        <td class="td-num">#{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="td-names">
                                {{ $item->nama_pria }} &amp; {{ $item->nama_wanita }}
                                <small>{{ $item->email }}</small>
                            </div>
                        </td>
                        <td class="hide-mobile" style="color:#64748b;font-size:13px">
                            {{ $item->created_at->format('d M Y') }}
                        </td>
                        <td>
                            @if($item->status_pembayaran === 'lunas')
                                <span class="badge badge-green">
                                    <span class="badge-dot"></span>Lunas
                                </span>
                            @elseif($item->status_pembayaran === 'menunggu')
                                <span class="badge badge-amber">
                                    <span class="badge-dot"></span>Menunggu
                                </span>
                            @else
                                <span class="badge badge-slate">
                                    <span class="badge-dot"></span>Belum Bayar
                                </span>
                            @endif
                        </td>
                        <td>
                            <a href="https://admin.biaraloresa.my.id/pendaftaran/{{ $item->id }}" class="btn-detail">
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
        <div class="pagination-wrap">
            {{ $pendaftaran->links() }}
        </div>
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#cbd5e1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
            </svg>
            <p>Belum ada data pendaftaran.</p>
        </div>
    @endif
</div>

@endsection
