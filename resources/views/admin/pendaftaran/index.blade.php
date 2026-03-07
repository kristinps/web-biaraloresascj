@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Daftar Pendaftaran')
@section('page-title', 'Daftar Pendaftaran')
@section('page-subtitle', 'Semua pendaftaran kursus pernikahan')

@push('styles')
<style>
    .filter-bar {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .search-wrap {
        position: relative;
        flex: 1;
        min-width: 220px;
    }
    .search-wrap svg {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        width: 16px; height: 16px; color: #94a3b8; pointer-events: none;
    }
    .search-wrap input {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13.5px;
        font-family: 'Inter', sans-serif;
        outline: none;
        color: #374151;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-wrap input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }
    .card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        padding: 12px 18px;
        font-size: 11.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.5px;
        color: #94a3b8; background: #f8fafc;
        text-align: left; border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }
    tbody tr { border-bottom: 1px solid #f8fafc; transition: background 0.15s; }
    tbody tr:hover { background: #f8fafc; }
    tbody tr:last-child { border-bottom: none; }
    td { padding: 13px 18px; font-size: 13.5px; color: #374151; vertical-align: middle; }
    .td-names { font-weight: 600; color: #1e293b; }
    .td-names small { display: block; font-size: 12px; font-weight: 400; color: #94a3b8; margin-top: 1px; }
    .btn-detail {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 12px; border-radius: 8px;
        background: #f1f5f9; color: #475569;
        font-size: 12.5px; font-weight: 600;
        text-decoration: none; transition: background 0.15s, color 0.15s;
    }
    .btn-detail:hover { background: #e0e7ff; color: #4f46e5; }
    .btn-detail svg { width: 13px; height: 13px; }
    .empty-state { text-align: center; padding: 56px 24px; color: #94a3b8; }
    .empty-state svg { width: 48px; height: 48px; margin: 0 auto 14px; }
    .pagination-wrap { padding: 16px 20px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; }

    @media (max-width: 768px) { .hide-mobile { display: none; } }
</style>
@endpush

@section('content')

<div class="filter-bar">
    <form method="GET" action="{{ route($routePrefix . '.pendaftaran.index') }}"
          style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;flex:1">
        <div class="search-wrap">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau email...">
        </div>
        <button type="submit" style="padding:9px 18px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border:none;border-radius:10px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif">
            Filter
        </button>
        @if(request('search'))
            <a href="{{ route($routePrefix . '.pendaftaran.index') }}" style="padding:9px 14px;background:#f1f5f9;color:#64748b;border-radius:10px;font-size:13.5px;font-weight:500;text-decoration:none">
                Reset
            </a>
        @endif
    </form>
</div>

<div class="card">
    @if($pendaftaran->count() > 0)
        <div style="overflow-x:auto">
            <table>
                <thead>
                    <tr>
                        <th>Pasangan</th>
                        <th class="hide-mobile">Tanggal Nikah</th>
                        <th class="hide-mobile">Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaran as $item)
                    <tr>
                        <td>
                            <div class="td-names">
                                {{ $item->nama_pria }} &amp; {{ $item->nama_wanita }}
                                <small>{{ $item->email }}</small>
                            </div>
                        </td>
                        <td class="hide-mobile" style="color:#64748b;font-size:13px">
                            {{ $item->tanggal_pernikahan ? $item->tanggal_pernikahan->format('d M Y') : '-' }}
                        </td>
                        <td class="hide-mobile" style="color:#64748b;font-size:13px">
                            {{ $item->created_at->format('d M Y') }}
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
        <div class="pagination-wrap">
            {{ $pendaftaran->appends(request()->query())->links() }}
        </div>
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#cbd5e1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
            </svg>
            <p>Tidak ada data yang ditemukan.</p>
        </div>
    @endif
</div>

@endsection
