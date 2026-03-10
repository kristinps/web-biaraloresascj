@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Dokumen Pendaftaran')
@section('page-title', 'Dokumen Pendaftaran')
@section('page-subtitle', 'Semua data dokumen pendaftaran — setuju (✓) atau tolak (✗) dan kirim notifikasi email')

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
    .filter-bar select { padding: 12px 14px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; min-width: 180px; }
    .btn-filter { padding: 12px 22px; background: linear-gradient(135deg, var(--primary, #2230ce), #3d56f5); color: #fff; border: none; border-radius: 12px; font-size: 14px; font-weight: 600; cursor: pointer; }
    .btn-reset { padding: 12px 18px; background: #f1f5f9; color: #64748b; border-radius: 12px; font-size: 13px; text-decoration: none; border: 1px solid #e2e8f0; }
    .card { background: #fff; border-radius: 18px; box-shadow: 0 6px 24px rgba(0,0,0,0.08); overflow: hidden; }
    .table-info { padding: 14px 22px; font-size: 13px; color: #64748b; background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid #e2e8f0; }
    .dokumen-page table { width: 100%; border-collapse: collapse; }
    .dokumen-page td { vertical-align: middle; }
    .dokumen-page tbody tr:hover { background: #f8faff; }
    .td-names { font-weight: 600; color: #1e293b; font-size: 14px; }
    .td-names small { display: block; font-size: 12px; font-weight: 400; color: #64748b; margin-top: 2px; }
    .badge-dok { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 999px; font-size: 11.5px; font-weight: 600; }
    .badge-dok.lengkap { background: #f0fdf4; color: #15803d; }
    .badge-dok.tidak_lengkap { background: #fef2f2; color: #dc2626; }
    .badge-dok.sedang_diperiksa { background: #fffbeb; color: #b45309; }
    .badge-dok.belum_diperiksa { background: #f1f5f9; color: #475569; }
    .btn-detail { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 10px; background: linear-gradient(180deg, #f0f4ff 0%, #eef2ff 100%); color: #2129a7; font-size: 12.5px; font-weight: 600; text-decoration: none; border: 1px solid #bfd0ff; margin-right: 6px; }
    .btn-detail:hover { background: #dce6ff; color: #1e2685; }
    .btn-setuju { display: inline-flex; align-items: center; gap: 5px; padding: 8px 14px; border-radius: 10px; background: linear-gradient(135deg, #059669, #10b981); color: #fff; font-size: 12.5px; font-weight: 600; border: none; cursor: pointer; transition: opacity 0.2s, box-shadow 0.2s; }
    .btn-setuju:hover { opacity: 0.95; box-shadow: 0 4px 14px rgba(5,150,105,0.4); }
    .btn-tolak { display: inline-flex; align-items: center; gap: 5px; padding: 8px 14px; border-radius: 10px; background: linear-gradient(135deg, #dc2626, #ef4444); color: #fff; font-size: 12.5px; font-weight: 600; border: none; cursor: pointer; transition: opacity 0.2s; }
    .btn-tolak:hover { opacity: 0.95; }
    .btn-detail svg, .btn-setuju svg, .btn-tolak svg { width: 14px; height: 14px; }
    .aksi-cell { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
    .tolak-form { display: inline-flex; align-items: center; gap: 6px; flex-wrap: wrap; }
    .tolak-form input { padding: 6px 10px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 12px; width: 160px; }
    .empty-state { text-align: center; padding: 64px 28px; color: #64748b; font-size: 15px; }
    .empty-state-icon { width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); color: #94a3b8; }
    .dashboard-table-footer { padding: 16px 22px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; background: #fafbfc; }
    .table-wrap { overflow-x: auto; }
    .dokumen-page thead th { padding: 12px 18px; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #2129a7; background: linear-gradient(180deg, #f0f4ff 0%, #eef2ff 100%); text-align: left; border-bottom: 1px solid #bfd0ff; }
    .dokumen-page tbody td { padding: 12px 18px; font-size: 13px; color: #374151; border-bottom: 1px solid #f1f5f9; }
    .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }
    @media (max-width: 768px) { .hide-mobile { display: none !important; } .tolak-form input { width: 120px; } }
</style>
@endpush

@section('content')
@php
    $routePrefix = $routePrefix ?? (request()->routeIs('dashboard.*') ? 'dashboard' : 'admin');
    $hasFilter = request('search') || request('status_dokumen');
@endphp

<div class="page-header">
    <div class="page-header-icon">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
        </svg>
    </div>
    <div>
        <h1>Dokumen Pendaftaran</h1>
        <p>Setuju (✓) atau tolak (✗) dokumen. Setiap aksi mengirim email ke peserta.</p>
    </div>
</div>

@if(session('success'))
    <div class="toast toast-success" style="margin-bottom:16px">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="toast toast-error" style="margin-bottom:16px">{{ session('error') }}</div>
@endif

<div class="filter-bar">
    <form method="GET" action="{{ $routePrefix === 'dashboard' ? route('dashboard.pendaftaran.dokumen-list') : route('admin.pendaftaran.dokumen-list') }}" style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;flex:1;">
        <div class="search-wrap">
            <label for="search" class="sr-only">Cari</label>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803a7.5 7.5 0 0010.607 10.607z"/></svg>
            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari nama pasangan atau email...">
        </div>
        <select name="status_dokumen">
            <option value="">Semua status</option>
            <option value="belum_diperiksa" {{ request('status_dokumen') === 'belum_diperiksa' ? 'selected' : '' }}>Belum diperiksa</option>
            <option value="sedang_diperiksa" {{ request('status_dokumen') === 'sedang_diperiksa' ? 'selected' : '' }}>Sedang diperiksa</option>
            <option value="lengkap" {{ request('status_dokumen') === 'lengkap' ? 'selected' : '' }}>Dokumen diterima</option>
            <option value="tidak_lengkap" {{ request('status_dokumen') === 'tidak_lengkap' ? 'selected' : '' }}>Perlu perbaikan</option>
        </select>
        <button type="submit" class="btn-filter">Cari</button>
        @if($hasFilter)
            <a href="{{ $routePrefix === 'dashboard' ? route('dashboard.pendaftaran.dokumen-list') : route('admin.pendaftaran.dokumen-list') }}" class="btn-reset">Reset</a>
        @endif
    </form>
</div>

<div class="card dokumen-page">
    @if($pendaftaran->count() > 0)
        @php
            $start = ($pendaftaran->currentPage() - 1) * $pendaftaran->perPage() + 1;
            $end = min($pendaftaran->currentPage() * $pendaftaran->perPage(), $pendaftaran->total());
        @endphp
        <div class="table-info">
            Menampilkan <strong>{{ $start }}–{{ $end }}</strong> dari <strong>{{ $pendaftaran->total() }}</strong> dokumen pendaftaran
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">No</th>
                        <th>Pasangan</th>
                        <th class="hide-mobile">Email</th>
                        <th class="hide-mobile">Periode</th>
                        <th>Status Dokumen</th>
                        <th style="min-width:160px">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaran as $index => $item)
                    @php $sd = $item->status_dokumen ?? 'belum_diperiksa'; @endphp
                    <tr>
                        <td style="color:#64748b;font-size:13px">{{ $start + $index }}</td>
                        <td>
                            <div class="td-names">
                                {{ $item->nama_pria }} &amp; {{ $item->nama_wanita }}
                                <small>{{ $item->email }}</small>
                            </div>
                        </td>
                        <td class="hide-mobile" style="font-size:12.5px;color:#64748b">{{ $item->email }}</td>
                        <td class="hide-mobile" style="font-size:12.5px;color:#64748b">{{ $item->periode?->nama ?? '–' }}</td>
                        <td>
                            <span class="badge-dok {{ $sd }}">
                                @if($sd === 'lengkap') ✓ Diterima
                                @elseif($sd === 'tidak_lengkap') ✗ Perlu perbaikan
                                @elseif($sd === 'sedang_diperiksa') Sedang diperiksa
                                @else Belum diperiksa
                                @endif
                            </span>
                        </td>
                        <td>
                            <div class="aksi-cell">
                                <a href="{{ route($routePrefix . '.pendaftaran.show', $item->id) }}" class="btn-detail">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Detail
                                </a>
                            </div>
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
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </div>
            <p><strong>Tidak ada data dokumen</strong></p>
            <p class="hint">{{ $hasFilter ? 'Coba ubah filter atau reset.' : 'Belum ada pendaftaran dengan dokumen.' }}</p>
        </div>
    @endif
</div>

@endsection
