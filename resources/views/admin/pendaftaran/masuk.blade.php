@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Pendaftaran Masuk')
@section('page-title', 'Pendaftaran Masuk')
@section('page-subtitle', 'Pendaftaran baru menunggu persetujuan admin')

@push('styles')
<style>
    .page-header { margin-bottom: 28px; display: flex; align-items: flex-start; gap: 16px; flex-wrap: wrap; }
    .page-header-icon { width: 52px; height: 52px; border-radius: 14px; background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(255,255,255,0.25); }
    .page-header-icon svg { width: 26px; height: 26px; color: #fff; }
    .page-header h1 { font-size: 1.6rem; font-weight: 700; color: #fff; margin: 0 0 6px 0; }
    .page-header p { font-size: 0.95rem; color: rgba(255,255,255,0.92); margin: 0; }
    .filter-bar { background: rgba(255,255,255,0.98); border-radius: 14px; padding: 18px 20px; margin-bottom: 20px; display: flex; align-items: center; gap: 14px; flex-wrap: wrap; box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
    .search-wrap { position: relative; flex: 1; min-width: 220px; }
    .search-wrap svg { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #94a3b8; }
    .search-wrap input { width: 100%; padding: 12px 16px 12px 44px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; outline: none; }
    .btn-filter { padding: 12px 22px; background: linear-gradient(135deg, var(--primary, #2230ce), #3d56f5); color: #fff; border: none; border-radius: 12px; font-size: 14px; font-weight: 600; cursor: pointer; }
    .btn-reset { padding: 12px 18px; background: #f1f5f9; color: #64748b; border-radius: 12px; font-size: 13px; text-decoration: none; border: 1px solid #e2e8f0; }
    .card { background: #fff; border-radius: 18px; box-shadow: 0 6px 24px rgba(0,0,0,0.08); overflow: hidden; }
    .table-info { padding: 14px 22px; font-size: 13px; color: #64748b; background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid #e2e8f0; }
    .pendaftaran-page table { width: 100%; border-collapse: collapse; }
    .pendaftaran-page td { vertical-align: middle; }
    .pendaftaran-page tbody tr:hover { background: #f8faff; }
    .td-names { font-weight: 600; color: #1e293b; font-size: 14px; }
    .td-names small { display: block; font-size: 12px; font-weight: 400; color: #64748b; margin-top: 2px; }
    .btn-detail { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; border-radius: 10px; background: linear-gradient(180deg, #f0f4ff 0%, #eef2ff 100%); color: #2129a7; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid #bfd0ff; margin-right: 8px; }
    .btn-setuju { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; border-radius: 10px; background: linear-gradient(135deg, #059669, #10b981); color: #fff; font-size: 13px; font-weight: 600; text-decoration: none; border: none; transition: opacity 0.2s, box-shadow 0.2s; }
    .btn-setuju:hover { opacity: 0.95; box-shadow: 0 4px 14px rgba(5,150,105,0.4); }
    .btn-detail:hover { background: #dce6ff; color: #1e2685; }
    .btn-detail svg, .btn-setuju svg { width: 15px; height: 15px; }
    .empty-state { text-align: center; padding: 64px 28px; color: #64748b; font-size: 15px; }
    .empty-state-icon { width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); color: #94a3b8; }
    .dashboard-table-footer { padding: 16px 22px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; background: #fafbfc; }
    .table-wrap { overflow-x: auto; }
    .pendaftaran-page thead th { padding: 12px 18px; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #2129a7; background: linear-gradient(180deg, #f0f4ff 0%, #eef2ff 100%); text-align: left; border-bottom: 1px solid #bfd0ff; }
    .pendaftaran-page tbody td { padding: 13px 18px; font-size: 13.5px; color: #374151; border-bottom: 1px solid #f1f5f9; }
    @media (max-width: 768px) { .hide-mobile { display: none !important; } }
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
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </div>
    <div>
        <h1>Pendaftaran Masuk</h1>
        <p>Pendaftaran baru yang menunggu persetujuan dan penentuan periode</p>
    </div>
</div>

<div class="filter-bar">
    <form method="GET" action="{{ route($routePrefix . '.pendaftaran.masuk') }}" style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;flex:1;">
        <div class="search-wrap">
            <label for="search" class="sr-only">Cari</label>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803a7.5 7.5 0 0010.607 10.607z"/></svg>
            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari nama pasangan atau email...">
        </div>
        <button type="submit" class="btn-filter">Cari</button>
        @if($hasFilter)
            <a href="{{ route($routePrefix . '.pendaftaran.masuk') }}" class="btn-reset">Reset</a>
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
            Menampilkan <strong>{{ $start }}–{{ $end }}</strong> dari <strong>{{ $pendaftaran->total() }}</strong> pendaftaran masuk
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:52px">No</th>
                        <th>Nama Pasangan</th>
                        <th class="hide-mobile">Email</th>
                        <th>Waktu / Tanggal</th>
                        <th style="width:200px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaran as $index => $item)
                    <tr>
                        <td style="color:#64748b;font-size:13px">{{ $start + $index }}</td>
                        <td>
                            <div class="td-names">
                                {{ $item->nama_pria }} &amp; {{ $item->nama_wanita }}
                            </div>
                        </td>
                        <td class="hide-mobile" style="color:#64748b;font-size:13px">{{ $item->email }}</td>
                        <td style="color:#64748b;font-size:13px">
                            {{ $item->created_at->format('d M Y, H:i') }}
                        </td>
                        <td>
                            <a href="{{ route($routePrefix . '.pendaftaran.show', $item->id) }}" class="btn-detail">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Detail
                            </a>
                            <a href="{{ route($routePrefix . '.pendaftaran.setuju', $item->id) }}" class="btn-setuju">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Setuju
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <p><strong>Tidak ada pendaftaran masuk</strong></p>
            <p class="hint">{{ $hasFilter ? 'Coba ubah kata kunci atau reset filter.' : 'Semua pendaftaran sudah diproses atau belum ada pendaftaran baru.' }}</p>
        </div>
    @endif
</div>

@endsection
