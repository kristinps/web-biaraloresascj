@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Sertifikat Kelulusan')
@section('page-title', 'Sertifikat Kelulusan')
@section('page-subtitle', 'Kelola sertifikat kelulusan peserta berdasarkan periode pendaftaran')

@push('styles')
<style>
    .page-actions {
        display:flex;
        justify-content:flex-end;
        margin-bottom:24px;
    }
    .btn-primary {
        display:inline-flex;
        align-items:center;
        gap:7px;
        padding:10px 20px;
        background:linear-gradient(135deg,#22c55e,#16a34a);
        color:#fff;
        border-radius:10px;
        font-size:14px;
        font-weight:600;
        text-decoration:none;
        box-shadow:0 4px 12px rgba(34,197,94,0.3);
        transition:opacity 0.2s;
    }
    .btn-primary:hover { opacity:0.9; }
    .btn-primary svg { width:16px;height:16px; }

    .card {
        background:#fff;
        border-radius:16px;
        border:1px solid #e2e8f0;
        box-shadow:0 1px 4px rgba(0,0,0,0.04);
        overflow:hidden;
    }
    .card-header {
        padding:18px 24px 14px;
        border-bottom:1px solid #f1f5f9;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        flex-wrap:wrap;
    }
    .card-header h2 {
        font-size:15px;
        font-weight:700;
        color:#1e293b;
    }
    .filter-row {
        display:flex;
        align-items:center;
        gap:8px;
        flex-wrap:wrap;
    }
    .filter-row select {
        border-radius:9px;
        border:1px solid #e2e8f0;
        padding:7px 10px;
        font-size:13px;
        color:#1e293b;
    }
    .filter-row button {
        border-radius:9px;
        border:none;
        padding:7px 12px;
        font-size:13px;
        font-weight:600;
        cursor:pointer;
    }
    .btn-filter {
        background:#eff6ff;
        color:#1d4ed8;
    }
    .btn-reset {
        background:#f1f5f9;
        color:#475569;
    }

    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; }
    thead th {
        padding:12px 18px;
        font-size:11.5px;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:0.05em;
        color:#2129a7;
        background:linear-gradient(180deg,#f0f4ff 0%,#eef2ff 100%);
        text-align:left;
        border-bottom:1px solid #bfd0ff;
        white-space:nowrap;
    }
    tbody tr { border-bottom:1px solid #f1f5f9; transition:background 0.15s; }
    tbody tr:hover { background:#f8fafc; }
    tbody td {
        padding:13px 18px;
        font-size:13.5px;
        color:#374151;
        vertical-align:middle;
    }
    .td-names { font-weight:600; color:#1e293b; }
    .td-names small { display:block; font-size:12px; font-weight:400; color:#94a3b8; }

    .badge-periode {
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:4px 10px;
        border-radius:999px;
        font-size:12px;
        font-weight:600;
        background:#f0f9ff;
        color:#0369a1;
    }
    .badge-dot {
        width:6px;
        height:6px;
        border-radius:999px;
        background:#0ea5e9;
    }

    .table-actions {
        display:flex;
        flex-wrap:wrap;
        gap:6px;
    }
    .btn-action {
        display:inline-flex;
        align-items:center;
        gap:5px;
        padding:6px 13px;
        border-radius:8px;
        font-size:12.5px;
        font-weight:600;
        text-decoration:none;
        border:1px solid #bfd0ff;
        background:#f0f4ff;
        color:#2129a7;
        transition:background 0.15s,color 0.15s;
    }
    .btn-action:hover { background:#dce6ff; color:#1e2685; }
    .btn-action svg { width:13px;height:13px; }
    .btn-danger {
        background:#fef2f2;
        border-color:#fecaca;
        color:#dc2626;
    }
    .btn-danger:hover {
        background:#fee2e2;
        color:#b91c1c;
    }

    .empty-state {
        text-align:center;
        padding:48px 24px;
        color:#94a3b8;
    }
    .empty-state svg { width:48px;height:48px;margin:0 auto 14px; }
    .empty-state p { font-size:14px; }

    .pagination-wrap {
        padding:14px 20px;
        border-top:1px solid #f1f5f9;
        display:flex;
        justify-content:flex-end;
    }
</style>
@endpush

@section('content')

<div class="page-actions">
    <a href="{{ route($routePrefix . '.sertifikat.create') }}" class="btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Tambah Sertifikat
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Daftar Sertifikat Kelulusan</h2>
        <form method="GET" class="filter-row">
            <select name="periode_id">
                <option value="">Semua Periode</option>
                @foreach($periodeList as $periode)
                    <option value="{{ $periode->id }}" {{ (string)$periodeId === (string)$periode->id ? 'selected' : '' }}>
                        {{ $periode->nama }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn-filter">Filter</button>
            @if(request()->has('periode_id') && request('periode_id') !== null && request('periode_id') !== '')
                <a href="{{ route($routePrefix . '.sertifikat.index') }}" class="btn-reset">Reset</a>
            @endif
        </form>
    </div>

    @if($suratList->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Peserta</th>
                        <th>Email</th>
                        <th>Periode</th>
                        <th>Download Sertifikat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($suratList as $surat)
                    <tr>
                        <td>{{ $surat->id }}</td>
                        <td class="td-names">
                            {{ $surat->pendaftaran?->namaLengkap() ?? '-' }}
                            <small>ID Pendaftaran: #{{ str_pad($surat->pendaftaran_id,5,'0',STR_PAD_LEFT) }}</small>
                        </td>
                        <td>{{ $surat->pendaftaran?->email ?? '-' }}</td>
                        <td>
                            @if($surat->pendaftaran && $surat->pendaftaran->periode)
                                <span class="badge-periode">
                                    <span class="badge-dot"></span>
                                    {{ $surat->pendaftaran->periode->nama }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($surat->file)
                                <a href="{{ route('dashboard.user') }}" target="_blank">
                                    Unduh Sertifikat
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route($routePrefix . '.sertifikat.show', $surat) }}" class="btn-action">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Detail
                                </a>
                                <a href="{{ route($routePrefix . '.sertifikat.edit', $surat) }}" class="btn-action">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route($routePrefix . '.sertifikat.destroy', $surat) }}" method="POST" onsubmit="return confirm('Hapus sertifikat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-danger">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($suratList->hasPages())
        <div class="pagination-wrap">
            {{ $suratList->links() }}
        </div>
        @endif
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
            </svg>
            <p>Belum ada sertifikat yang dibuat.</p>
        </div>
    @endif
</div>

@endsection

