@extends('user.layouts.app')

@section('title', 'Status Pendaftaran')
@section('page-title', 'Status Pendaftaran')
@section('page-subtitle', 'Status tiap pendaftaran kursus pernikahan Anda')

@push('styles')
<style>
    /* Tema beranda: background gambar + overlay seperti hero beranda */
    .status-pendaftaran-wrap {
        position: relative;
        min-height: calc(100vh - 56px);
        margin: -28px;
        padding: 28px;
        overflow: hidden;
    }
    .status-pendaftaran-wrap::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url('https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop');
        background-size: cover;
        background-position: center;
        z-index: 0;
    }
    .status-pendaftaran-wrap::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(30,38,133,0.88) 0%, rgba(61,86,245,0.65) 100%);
        z-index: 1;
    }
    .status-pendaftaran-wrap .status-pendaftaran-inner { position: relative; z-index: 2; }

    .card { background:#fff; border-radius:16px; border:1px solid rgba(255,255,255,0.2); box-shadow:0 4px 24px rgba(0,0,0,0.12); overflow:hidden; }
    .card-header { padding:20px 24px; border-bottom:1px solid #f1f5f9; }
    .card-header h2 { font-size:15.5px; font-weight:700; color:#1e293b; }
    .card-header p { font-size:12.5px; color:#94a3b8; margin-top:2px; }
    table { width:100%; border-collapse:collapse; }
    thead th { padding:12px 20px; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#94a3b8; background:#f8fafc; text-align:left; border-bottom:1px solid #f1f5f9; }
    tbody tr { border-bottom:1px solid #f8fafc; }
    tbody tr:hover { background:#f8fafc; }
    td { padding:14px 20px; font-size:13.5px; color:#374151; vertical-align:middle; }
    .badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:99px; font-size:12px; font-weight:600; }
    .badge-dot { width:6px; height:6px; border-radius:50%; }
    .badge-green { background:#f0fdf4; color:#15803d; }
    .badge-amber { background:#fffbeb; color:#b45309; }
    .badge-slate { background:#f8fafc; color:#475569; }
    .badge-blue { background:#eff6ff; color:#1d4ed8; }
    .empty-state { text-align:center; padding:56px 24px; color:#94a3b8; }
    .btn-detail { display:inline-flex; align-items:center; gap:5px; padding:6px 13px; border-radius:8px; background:#f1f5f9; color:#475569; font-size:12.5px; font-weight:600; text-decoration:none; transition:background 0.15s, color 0.15s; }
    .btn-detail:hover { background:#e0e7ff; color:#4f46e5; }
    @media (max-width:768px) { .hide-mobile { display:none; } .status-pendaftaran-wrap { margin: -20px -16px; padding: 20px 16px; } }
</style>
@endpush

@section('content')
<div class="status-pendaftaran-wrap">
    <div class="status-pendaftaran-inner">
<div class="card">
    <div class="card-header">
        <h2>Status Pendaftaran</h2>
        <p>Ringkasan status pendaftaran, pembayaran, dokumen, dan kursus per periode</p>
    </div>
    @if($pendaftaranList->count() > 0)
        <div style="overflow-x:auto">
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
                        <td style="color:#6366f1;font-weight:700">#{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <strong style="color:#1e293b">{{ $item->nama_pria }} &amp; {{ $item->nama_wanita }}</strong>
                            <small style="display:block;font-size:12px;color:#94a3b8">{{ $item->tanggal_pernikahan ? $item->tanggal_pernikahan->locale('id')->isoFormat('D MMM YYYY') : '—' }}</small>
                        </td>
                        <td class="hide-mobile">
                            @if($item->periode)
                                <span style="display:inline-flex;align-items:center;padding:3px 9px;border-radius:99px;background:#ede9fe;color:#6d28d9;font-size:12px;font-weight:600">{{ $item->periode->nama }}</span>
                            @else — @endif
                        </td>
                        <td>
                            @if($item->status_pembayaran === 'lunas')
                                <span class="badge badge-green"><span class="badge-dot" style="background:#22c55e"></span>Lunas</span>
                            @elseif($item->status_pembayaran === 'menunggu')
                                <span class="badge badge-amber"><span class="badge-dot" style="background:#f59e0b"></span>Menunggu</span>
                            @else
                                <span class="badge badge-slate"><span class="badge-dot" style="background:#94a3b8"></span>Belum Bayar</span>
                            @endif
                        </td>
                        <td class="hide-mobile">
                            @if($item->status_dokumen === 'lengkap')
                                <span class="badge badge-green"><span class="badge-dot" style="background:#22c55e"></span>Lengkap</span>
                            @elseif($item->status_dokumen === 'revisi')
                                <span class="badge badge-amber"><span class="badge-dot" style="background:#f59e0b"></span>Revisi</span>
                            @else
                                <span class="badge badge-slate"><span class="badge-dot" style="background:#94a3b8"></span>Belum dicek</span>
                            @endif
                        </td>
                        <td class="hide-mobile">
                            @if($item->status_kursus === 'lulus')
                                <span class="badge badge-green"><span class="badge-dot" style="background:#22c55e"></span>Lulus</span>
                            @elseif($item->status_kursus === 'sedang_berjalan')
                                <span class="badge badge-blue"><span class="badge-dot" style="background:#3b82f6"></span>Sedang berjalan</span>
                            @elseif($item->status_kursus === 'terjadwal')
                                <span class="badge badge-amber"><span class="badge-dot" style="background:#f59e0b"></span>Terjadwal</span>
                            @else
                                <span class="badge badge-slate"><span class="badge-dot" style="background:#94a3b8"></span>—</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('kursus-pernikahan.sukses', $item->id) }}" class="btn-detail">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <p>Belum ada data pendaftaran.</p>
            <a href="{{ route('kursus-pernikahan') }}" style="display:inline-flex;align-items:center;gap:6px;margin-top:14px;padding:8px 16px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none">Daftar Kursus Pernikahan</a>
        </div>
    @endif
</div>
    </div>
</div>
@endsection
