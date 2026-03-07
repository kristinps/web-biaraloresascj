@extends('user.layouts.app')

@section('title', 'Pembayaran Pendaftaran')
@section('page-title', 'Pembayaran Pendaftaran')
@section('page-subtitle', 'Status dan langkah pembayaran biaya pendaftaran')

@push('styles')
<style>
    .card { background:#fff; border-radius:16px; border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,0.04); overflow:hidden; }
    .card-header { padding:20px 24px; border-bottom:1px solid #f1f5f9; }
    .card-header h2 { font-size:15.5px; font-weight:700; color:#1e293b; }
    .card-header p { font-size:12.5px; color:#94a3b8; margin-top:2px; }
    table { width:100%; border-collapse:collapse; }
    thead th { padding:12px 20px; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#94a3b8; background:#f8fafc; text-align:left; border-bottom:1px solid #f1f5f9; }
    tbody tr { border-bottom:1px solid #f8fafc; }
    tbody tr:hover { background:#f8fafc; }
    td { padding:14px 20px; font-size:13.5px; color:#374151; vertical-align:middle; }
    .badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:99px; font-size:12px; font-weight:600; }
    .badge-green { background:#f0fdf4; color:#15803d; }
    .badge-amber { background:#fffbeb; color:#b45309; }
    .badge-slate { background:#f8fafc; color:#475569; }
    .btn-bayar { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff!important; border-radius:9px; font-size:13px; font-weight:600; text-decoration:none; }
    .btn-bayar:hover { opacity:0.9; }
    .empty-state { text-align:center; padding:56px 24px; color:#94a3b8; }
    @media (max-width:768px) { .hide-mobile { display:none; } }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Daftar Pembayaran</h2>
        <p>Status pembayaran tiap pendaftaran. Lunas = sudah dibayar dan dikonfirmasi.</p>
    </div>
    @if($pendaftaranList->count() > 0)
        <div style="overflow-x:auto">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pasangan</th>
                        <th class="hide-mobile">Periode</th>
                        <th>Biaya</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaranList as $item)
                    <tr>
                        <td style="color:#6366f1;font-weight:700">#{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <strong style="color:#1e293b">{{ $item->nama_pria }} &amp; {{ $item->nama_wanita }}</strong>
                        </td>
                        <td class="hide-mobile">{{ $item->periode ? $item->periode->nama : '—' }}</td>
                        <td><strong>Rp 350.000</strong></td>
                        <td>
                            @if($item->status_pembayaran === 'lunas')
                                <span class="badge badge-green">Lunas</span>
                            @elseif($item->status_pembayaran === 'menunggu')
                                <span class="badge badge-amber">Menunggu konfirmasi</span>
                            @else
                                <span class="badge badge-slate">Belum bayar</span>
                            @endif
                        </td>
                        <td>
                            @if($item->status_pembayaran === 'lunas')
                                <a href="{{ route('kursus-pernikahan.sukses', $item->id) }}" style="font-size:13px;color:#6366f1;font-weight:600;text-decoration:none">Lihat detail</a>
                            @else
                                <a href="{{ route('pembayaran.show', $item->id) }}" class="btn-bayar">Bayar / Cek QRIS</a>
                            @endif
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
@endsection
