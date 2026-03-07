@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'user.layouts.app')

@section('title', 'Status Pendaftaran')
@section('page-title', 'Status Pendaftaran')
@section('page-subtitle', 'Status tiap pendaftaran kursus pernikahan Anda')

@push('styles')
<style>
    /* Card estetik: glass-style, shadow halus (background full banner dari layout) */
    .status-pendaftaran-wrap .card {
        background: rgba(255,255,255,0.98);
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.4);
        box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 2px 8px rgba(30,38,133,0.08);
        overflow: hidden;
        backdrop-filter: blur(8px);
    }
    /* Header kartu dengan strip tema + ikon */
    .status-pendaftaran-wrap .card-header {
        padding: 24px 28px;
        border-bottom: 1px solid #eef2ff;
        background: linear-gradient(135deg, #f8faff 0%, #fff 50%);
        border-top: 4px solid #2230ce;
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }
    .status-pendaftaran-wrap .card-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #2230ce, #3d56f5);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 6px 20px rgba(34,48,206,0.3);
    }
    .status-pendaftaran-wrap .card-header-icon svg { width: 24px; height: 24px; color: #fff; }
    .status-pendaftaran-wrap .card-header h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e2685;
        letter-spacing: -0.02em;
        margin-bottom: 4px;
    }
    .status-pendaftaran-wrap .card-header p {
        font-size: 13px;
        color: #64748b;
        line-height: 1.45;
    }
    /* Tabel estetik */
    .status-pendaftaran-wrap .table-wrap {
        overflow-x: auto;
        border-radius: 0 0 20px 20px;
    }
    .status-pendaftaran-wrap table { width: 100%; border-collapse: collapse; }
    .status-pendaftaran-wrap thead th {
        padding: 14px 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #1e2685;
        background: linear-gradient(180deg, #eef2ff 0%, #f0f4ff 100%);
        text-align: left;
        border-bottom: 2px solid #c7d2fe;
    }
    .status-pendaftaran-wrap thead th:first-child { padding-left: 28px; border-radius: 0; }
    .status-pendaftaran-wrap tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s ease;
    }
    .status-pendaftaran-wrap tbody tr:nth-child(even) { background: #fafbff; }
    .status-pendaftaran-wrap tbody tr:hover { background: #f0f4ff !important; }
    .status-pendaftaran-wrap tbody td {
        padding: 16px 20px;
        font-size: 13.5px;
        color: #334155;
        vertical-align: middle;
    }
    .status-pendaftaran-wrap tbody td:first-child { padding-left: 28px; }
    .status-pendaftaran-wrap .td-id {
        color: #2230ce;
        font-weight: 700;
        font-size: 13px;
        font-variant-numeric: tabular-nums;
    }
    .status-pendaftaran-wrap .td-couple strong { color: #1e293b; font-weight: 600; }
    .status-pendaftaran-wrap .td-couple small { display: block; font-size: 12px; color: #64748b; margin-top: 2px; }
    /* Badge estetik: lebih rounded, shadow tipis */
    .status-pendaftaran-wrap .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }
    .status-pendaftaran-wrap .badge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .status-pendaftaran-wrap .badge-green { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #166534; border: 1px solid rgba(34,197,94,0.2); }
    .status-pendaftaran-wrap .badge-green .badge-dot { background: #16a34a; }
    .status-pendaftaran-wrap .badge-amber { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #b45309; border: 1px solid rgba(245,158,11,0.2); }
    .status-pendaftaran-wrap .badge-amber .badge-dot { background: #d97706; }
    .status-pendaftaran-wrap .badge-slate { background: linear-gradient(135deg, #f1f5f9, #e2e8f0); color: #475569; border: 1px solid rgba(148,163,184,0.2); }
    .status-pendaftaran-wrap .badge-slate .badge-dot { background: #64748b; }
    .status-pendaftaran-wrap .badge-blue { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1d4ed8; border: 1px solid rgba(59,130,246,0.2); }
    .status-pendaftaran-wrap .badge-blue .badge-dot { background: #2563eb; }
    .status-pendaftaran-wrap .periode-pill {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        border-radius: 999px;
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        color: #3730a3;
        font-size: 12px;
        font-weight: 600;
    }
    /* Tombol Detail estetik */
    .status-pendaftaran-wrap .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 10px;
        background: linear-gradient(135deg, #f0f4ff, #e0e7ff);
        color: #2230ce;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid #c7d2fe;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(34,48,206,0.08);
    }
    .status-pendaftaran-wrap .btn-detail:hover {
        background: linear-gradient(135deg, #2230ce, #3d56f5);
        color: #fff;
        border-color: #2230ce;
        box-shadow: 0 4px 12px rgba(34,48,206,0.25);
        transform: translateY(-1px);
    }
    .status-pendaftaran-wrap .btn-detail svg { width: 14px; height: 14px; }
    /* Empty state */
    .status-pendaftaran-wrap .empty-state {
        text-align: center;
        padding: 56px 28px;
        color: #64748b;
    }
    .status-pendaftaran-wrap .empty-state .empty-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .status-pendaftaran-wrap .empty-state .empty-icon svg { width: 28px; height: 28px; color: #6366f1; }
    .status-pendaftaran-wrap .empty-state p { font-size: 14px; margin-bottom: 0; }
    .status-pendaftaran-wrap .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #2230ce, #3d56f5);
        color: #fff;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 6px 20px rgba(34,48,206,0.35);
        transition: all 0.2s ease;
    }
    .status-pendaftaran-wrap .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(34,48,206,0.4); opacity: 0.95; }
    @media (max-width: 768px) {
        .hide-mobile { display: none; }
        .status-pendaftaran-wrap { margin: -20px -16px; padding: 20px 16px; }
        .status-pendaftaran-wrap .card-header { padding: 20px 20px; flex-direction: column; gap: 12px; }
        .status-pendaftaran-wrap .card-header-icon { width: 44px; height: 44px; }
        .status-pendaftaran-wrap .card-header-icon svg { width: 22px; height: 22px; }
        .status-pendaftaran-wrap tbody td:first-child, .status-pendaftaran-wrap thead th:first-child { padding-left: 20px; }
    }
</style>
@endpush

@section('content')
<div class="status-pendaftaran-wrap">
<div class="card">
    <div class="card-header">
        <div class="card-header-icon">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
            </svg>
        </div>
        <div>
            <h2>Status Pendaftaran</h2>
            <p>Ringkasan status pendaftaran, pembayaran, dokumen, dan kursus per periode</p>
        </div>
    </div>
    @if($pendaftaranList->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pasangan</th>
                        <th class="hide-mobile">Periode</th>
                        <th>Status Pembayaran</th>
                        <th class="hide-mobile">Status Dokumen</th>
                        <th class="hide-mobile">Status Kursus</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaranList as $item)
                    <tr>
                        <td class="td-id">#{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="td-couple">
                            <strong>{{ $item->nama_pria }} &amp; {{ $item->nama_wanita }}</strong>
                            <small>{{ $item->tanggal_pernikahan ? $item->tanggal_pernikahan->locale('id')->isoFormat('D MMM YYYY') : '—' }}</small>
                        </td>
                        <td class="hide-mobile">
                            @if($item->periode)
                                <span class="periode-pill">{{ $item->periode->nama }}</span>
                            @else — @endif
                        </td>
                        <td>
                            @if($item->status_pembayaran === 'lunas')
                                <span class="badge badge-green"><span class="badge-dot"></span>Lunas</span>
                            @elseif($item->status_pembayaran === 'menunggu')
                                <span class="badge badge-amber"><span class="badge-dot"></span>Menunggu</span>
                            @else
                                <span class="badge badge-slate"><span class="badge-dot"></span>Belum Bayar</span>
                            @endif
                        </td>
                        <td class="hide-mobile">
                            @php $sd = $item->status_dokumen ?? 'belum_diperiksa'; @endphp
                            @if($sd === 'lengkap')
                                <span class="badge badge-green"><span class="badge-dot"></span>Lengkap</span>
                            @elseif($sd === 'tidak_lengkap')
                                <span class="badge badge-amber"><span class="badge-dot"></span>Tidak lengkap</span>
                            @else
                                <span class="badge badge-slate"><span class="badge-dot"></span>Belum dicek</span>
                            @endif
                        </td>
                        <td class="hide-mobile">
                            @if($item->status_kursus === 'lulus')
                                <span class="badge badge-green"><span class="badge-dot"></span>Lulus</span>
                            @elseif($item->status_kursus === 'sedang_berjalan')
                                <span class="badge badge-blue"><span class="badge-dot"></span>Sedang berjalan</span>
                            @elseif($item->status_kursus === 'terjadwal')
                                <span class="badge badge-amber"><span class="badge-dot"></span>Terjadwal</span>
                            @else
                                <span class="badge badge-slate"><span class="badge-dot"></span>—</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('kursus-pernikahan.sukses', $item->id) }}" class="btn-detail">
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
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
            </div>
            <p>Belum ada data pendaftaran.</p>
            <a href="{{ route('kursus-pernikahan') }}" class="btn-cta">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Daftar Kursus Pernikahan
            </a>
        </div>
    @endif
</div>
</div>
@endsection
