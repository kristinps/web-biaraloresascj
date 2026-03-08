@extends('layouts.dashboard')

@section('title', 'Kehadiran Kursus')
@section('page-title', 'Kehadiran Kursus')
@section('page-subtitle', 'Pilih periode untuk mengelola absensi peserta')

@push('styles')
<style>
    .section-label { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; margin: 28px 0 12px; }
    .section-label:first-child { margin-top: 0; }
    .card { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.04); overflow: hidden; margin-bottom: 8px; }
    .periode-item { display: flex; align-items: center; gap: 16px; padding: 18px 24px; border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
    .periode-item:last-child { border-bottom: none; }
    .periode-item:hover { background: #f8fafc; }
    .periode-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .periode-icon.aktif { background: linear-gradient(135deg,#f59e0b,#fbbf24); box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
    .periode-icon.selesai { background: linear-gradient(135deg,#94a3b8,#cbd5e1); }
    .periode-icon svg { width: 22px; height: 22px; color: #fff; }
    .periode-info { flex: 1; min-width: 0; }
    .periode-info .nama { font-size: 15px; font-weight: 700; color: #1e293b; }
    .periode-info .meta { font-size: 12.5px; color: #64748b; margin-top: 3px; }
    .btn-kehadiran { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: linear-gradient(135deg,#f59e0b,#d97706); color: #fff; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; transition: opacity 0.2s; }
    .btn-kehadiran:hover { opacity: 0.9; color: #fff; }
    .btn-kehadiran svg { width: 16px; height: 16px; }
    .empty-state { text-align: center; padding: 48px 24px; color: #94a3b8; }
</style>
@endpush

@section('content')

<div class="section-label">Periode Aktif</div>
<div class="card">
    @if($periodeAktif->count() > 0)
        @foreach($periodeAktif as $p)
        <div class="periode-item">
            <div class="periode-icon aktif">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <div class="periode-info">
                <div class="nama">{{ $p->nama }}</div>
                <div class="meta">{{ $p->materi_count }} materi · {{ $p->pendaftaran_count }} peserta</div>
            </div>
            <a href="{{ route('dashboard.kehadiran.index', $p) }}" class="btn-kehadiran">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Kelola Kehadiran
            </a>
        </div>
        @endforeach
    @else
        <div class="empty-state">
            <p>Belum ada periode aktif. <a href="{{ route('dashboard.periode.index') }}" style="color:#6366f1;font-weight:600">Buat periode</a> terlebih dahulu.</p>
        </div>
    @endif
</div>

<div class="section-label">Periode Selesai</div>
<div class="card">
    @if($periodeSelesai->count() > 0)
        @foreach($periodeSelesai as $p)
        <div class="periode-item">
            <div class="periode-icon selesai">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="periode-info">
                <div class="nama">{{ $p->nama }}</div>
                <div class="meta">{{ $p->materi_count }} materi · {{ $p->pendaftaran_count }} peserta</div>
            </div>
            <a href="{{ route('dashboard.kehadiran.index', $p) }}" class="btn-kehadiran">Kelola Kehadiran</a>
        </div>
        @endforeach
    @else
        <div class="empty-state"><p>Belum ada periode selesai.</p></div>
    @endif
</div>

@endsection
