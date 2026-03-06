@extends('admin.layouts.app')

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

    .section-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        margin: 28px 0 12px;
    }
    .section-label:first-child { margin-top: 0; }

    .card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        overflow: hidden;
        margin-bottom: 8px;
    }

    .periode-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }
    .periode-item:last-child { border-bottom: none; }
    .periode-item:hover { background: #f8fafc; }

    .periode-icon {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .periode-icon.aktif  { background: linear-gradient(135deg,#22c55e,#4ade80); box-shadow: 0 4px 12px rgba(34,197,94,0.3); }
    .periode-icon.selesai { background: linear-gradient(135deg,#94a3b8,#cbd5e1); }
    .periode-icon svg { width: 22px; height: 22px; color: #fff; }

    .periode-info { flex: 1; min-width: 0; }
    .periode-info .nama {
        font-size: 15px; font-weight: 700; color: #1e293b;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .periode-info .meta {
        font-size: 12.5px; color: #64748b; margin-top: 3px;
    }

    .badge-status {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 99px;
        font-size: 12px; font-weight: 600; white-space: nowrap;
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .badge-aktif  { background: #f0fdf4; color: #15803d; }
    .badge-aktif .badge-dot  { background: #22c55e; }
    .badge-selesai { background: #f8fafc; color: #475569; }
    .badge-selesai .badge-dot { background: #94a3b8; }

    .count-pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 99px;
        background: #ede9fe; color: #6d28d9;
        font-size: 12px; font-weight: 600;
    }

    .actions-group {
        display: flex; gap: 6px; align-items: center; flex-shrink: 0;
    }
    .btn-action {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 13px; border-radius: 8px;
        font-size: 12.5px; font-weight: 600;
        text-decoration: none; transition: background 0.15s, color 0.15s;
        border: none; cursor: pointer; background: #f1f5f9; color: #475569;
    }
    .btn-action:hover { background: #e0e7ff; color: #4f46e5; }
    .btn-action.danger:hover { background: #fee2e2; color: #dc2626; }
    .btn-action.success { background: #f0fdf4; color: #15803d; }
    .btn-action.success:hover { background: #dcfce7; color: #166534; }
    .btn-action.warning { background: #fffbeb; color: #92400e; }
    .btn-action.warning:hover { background: #fef3c7; }
    .btn-action svg { width: 13px; height: 13px; }

    .empty-state {
        text-align: center; padding: 48px 24px; color: #94a3b8;
    }
    .empty-state svg { width: 48px; height: 48px; margin: 0 auto 14px; }
    .empty-state p { font-size: 14px; }

    .pagination-wrap {
        padding: 14px 24px;
        border-top: 1px solid #f1f5f9;
        display: flex; justify-content: flex-end;
    }
</style>
@endpush

@section('content')

<div class="page-actions">
    <a href="{{ route('admin.periode.create') }}" class="btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Buat Periode Baru
    </a>
</div>

{{-- Periode Aktif --}}
<div class="section-label">Periode Aktif</div>
<div class="card">
    @if($periodeAktif->count() > 0)
        @foreach($periodeAktif as $p)
        <div class="periode-item">
            <div class="periode-icon aktif">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
            </div>
            <div class="periode-info">
                <div class="nama">{{ $p->nama }}</div>
                <div class="meta">
                    Mulai: {{ $p->tanggal_mulai->format('d M Y') }}
                    @if($p->catatan)
                    &nbsp;·&nbsp; {{ Str::limit($p->catatan, 60) }}
                    @endif
                </div>
            </div>
            <span class="badge-status badge-aktif">
                <span class="badge-dot"></span>Aktif
            </span>
            <span class="count-pill">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
                {{ $p->pendaftaran_count }} pendaftar
            </span>
            <div class="actions-group">
                <a href="{{ route('admin.periode.show', $p) }}" class="btn-action">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Detail
                </a>
                <a href="{{ route('admin.periode.edit', $p) }}" class="btn-action">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('admin.periode.tutup', $p) }}" method="POST"
                      onsubmit="return confirm('Tutup periode {{ addslashes($p->nama) }}? Periode tidak akan menerima pendaftaran baru.')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-action warning">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                        Tutup Periode
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#cbd5e1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
            </svg>
            <p>Belum ada periode aktif. <a href="{{ route('admin.periode.create') }}" style="color:#6366f1;font-weight:600">Buat periode baru.</a></p>
        </div>
    @endif
</div>

{{-- Periode Selesai --}}
<div class="section-label" style="margin-top:32px">Periode Selesai / Arsip</div>
<div class="card">
    @if($periodeSelesai->count() > 0)
        @foreach($periodeSelesai as $p)
        <div class="periode-item">
            <div class="periode-icon selesai">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="periode-info">
                <div class="nama">{{ $p->nama }}</div>
                <div class="meta">
                    {{ $p->tanggal_mulai->format('d M Y') }}
                    @if($p->tanggal_selesai)
                    → {{ $p->tanggal_selesai->format('d M Y') }}
                    @endif
                </div>
            </div>
            <span class="badge-status badge-selesai">
                <span class="badge-dot"></span>Selesai
            </span>
            <span class="count-pill" style="background:#f1f5f9;color:#64748b">
                {{ $p->pendaftaran_count }} pendaftar
            </span>
            <div class="actions-group">
                <a href="{{ route('admin.periode.show', $p) }}" class="btn-action">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Detail
                </a>
                <form action="{{ route('admin.periode.buka', $p) }}" method="POST"
                      onsubmit="return confirm('Aktifkan kembali periode ini?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-action success">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                        Aktifkan
                    </button>
                </form>
                @if($p->pendaftaran_count === 0)
                <form action="{{ route('admin.periode.destroy', $p) }}" method="POST"
                      onsubmit="return confirm('Hapus periode ini secara permanen?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-action danger">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                        </svg>
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
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

@endsection
