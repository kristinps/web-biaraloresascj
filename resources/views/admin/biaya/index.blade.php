@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Biaya Tambahan')
@section('page-title', 'Biaya Tambahan')
@section('page-subtitle', 'Kelola biaya tambahan per periode dan pantau status pembayaran peserta')

@push('styles')
<style>
    .biaya-page-header {
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .biaya-page-header-left h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }
    .biaya-page-header-left p {
        font-size: 0.9rem;
        color: #64748b;
        margin: 0;
    }
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 18px;
        border-radius: 999px;
        background: linear-gradient(135deg,#6366f1,#8b5cf6);
        color: #fff;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        box-shadow: 0 4px 14px rgba(99,102,241,0.35);
        transition: opacity .18s, transform .12s, box-shadow .18s;
    }
    .btn-primary:hover { opacity: .92; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(99,102,241,0.4); }
    .btn-primary svg { width: 16px; height: 16px; }

    .biaya-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.3fr) minmax(0, 1.9fr);
        gap: 20px;
        align-items: flex-start;
    }
    @media (max-width: 960px) {
        .biaya-grid { grid-template-columns: minmax(0, 1fr); }
    }

    .card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(15,23,42,0.04);
        overflow: hidden;
    }
    .card-header {
        padding: 14px 20px;
        border-bottom: 1px solid #e2e8f0;
        background: linear-gradient(135deg,#eff6ff,#eef2ff);
    }
    .card-header h2 {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .card-header p {
        font-size: 12px;
        color: #64748b;
        margin: 2px 0 0;
    }
    .card-body {
        padding: 16px 20px 18px;
    }

    .biaya-list-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .biaya-list-item:last-child { border-bottom: none; }
    .biaya-icon {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        background: linear-gradient(135deg,#22c55e,#4ade80);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
        box-shadow: 0 3px 8px rgba(34,197,94,0.35);
    }
    .biaya-icon svg { width: 18px; height: 18px; }
    .biaya-main {
        flex: 1;
        min-width: 0;
    }
    .biaya-main .nama {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    }
    .biaya-main .periode {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }
    .biaya-main .keterangan {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 4px;
    }
    .biaya-right {
        text-align: right;
        font-size: 12px;
        color: #64748b;
    }
    .biaya-right .nominal {
        font-weight: 700;
        color: #0f172a;
        font-size: 13px;
    }
    .badge-light {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        background: #f1f5f9;
        color: #64748b;
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 999px; background: #22c55e; }

    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        padding: 10px 14px;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #6b7280;
        background: linear-gradient(180deg,#f9fafb,#f3f4f6);
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }
    tbody td {
        padding: 10px 14px;
        font-size: 13px;
        color: #111827;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    tbody tr:hover { background: #f9fafb; }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .status-dot { width: 6px; height: 6px; border-radius: 999px; }
    .status-belum { background:#f8fafc;color:#475569; }
    .status-belum .status-dot { background:#94a3b8; }
    .status-menunggu { background:#fffbeb;color:#b45309; }
    .status-menunggu .status-dot { background:#f59e0b; }
    .status-lunas { background:#f0fdf4;color:#166534; }
    .status-lunas .status-dot { background:#22c55e; }
    .status-gagal { background:#fef2f2;color:#b91c1c; }
    .status-gagal .status-dot { background:#ef4444; }

    .table-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        background: #f1f5f9;
        color: #4f46e5;
        border: 1px solid #e5e7eb;
        transition: background .15s, color .15s, box-shadow .15s;
    }
    .table-action-btn:hover {
        background:#e0e7ff;
        border-color:#c7d2fe;
        box-shadow:0 2px 8px rgba(79,70,229,0.18);
    }
    .table-action-btn svg { width: 13px; height: 13px; }

    .empty-state {
        padding: 28px 20px;
        text-align: center;
        font-size: 13px;
        color: #94a3b8;
    }
</style>
@endpush

@section('content')
@php
    $routePrefix = $routePrefix ?? (request()->routeIs('dashboard.*') ? 'dashboard' : 'admin');
@endphp

<div class="biaya-page-header">
    <div class="biaya-page-header-left">
        <h1>Biaya Tambahan</h1>
        <p>Atur biaya tambahan per periode dan pantau pembayaran peserta.</p>
    </div>
    <div>
        <a href="{{ route($routePrefix . '.biaya.create') }}" class="btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah Biaya
        </a>
    </div>
</div>

<div class="biaya-grid">
    {{-- Daftar biaya tambahan --}}
    <div class="card">
        <div class="card-header">
            <h2>Daftar Biaya Tambahan</h2>
            <p>Semua biaya tambahan yang pernah dibuat per periode.</p>
        </div>
        <div class="card-body">
            @if($biayaTambahan->count() > 0)
                @foreach($biayaTambahan as $item)
                    <div class="biaya-list-item">
                        <div class="biaya-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 12v-2m0 2c-1.11 0-2.08-.402-2.599-1M21 12A9 9 0 113 12a9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="biaya-main">
                            <div class="nama">{{ $item->nama ?? 'Biaya Tambahan' }}</div>
                            <div class="periode">
                                @if($item->periode)
                                    Periode: {{ $item->periode->nama }}
                                @else
                                    Periode: <span style="font-style: italic; color:#9ca3af;">Tidak terikat periode</span>
                                @endif
                            </div>
                            @if($item->keterangan)
                                <div class="keterangan">{{ $item->keterangan }}</div>
                            @endif
                        </div>
                        <div class="biaya-right">
                            <div class="nominal">Rp {{ number_format($item->nominal, 0, ',', '.') }}</div>
                            <div style="margin-top:4px;">
                                <span class="badge-light">
                                    <span class="badge-dot"></span>
                                    Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    Belum ada biaya tambahan yang dibuat. Gunakan tombol <strong>Tambah Biaya</strong> di kanan atas.
                </div>
            @endif
        </div>
    </div>

    {{-- Tabel status tagihan peserta --}}
    <div class="card">
        <div class="card-header">
            <h2>Status Biaya per Peserta</h2>
            <p>Daftar peserta dan status pembayaran biaya tambahan.</p>
        </div>
        <div class="card-body">
            @if($tagihan->count() > 0)
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Peserta</th>
                                <th>Email</th>
                                <th>Periode</th>
                                <th>Biaya</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tagihan as $row)
                                @php
                                    $peserta = $row->pendaftaran;
                                    $biaya = $row->biaya;
                                    $periode = $biaya?->periode;
                                    $status = $row->status;
                                    $statusClass = match($status) {
                                        'lunas' => 'status-lunas',
                                        'menunggu' => 'status-menunggu',
                                        'gagal' => 'status-gagal',
                                        default => 'status-belum',
                                    };
                                    $statusLabel = match($status) {
                                        'lunas' => 'Lunas',
                                        'menunggu' => 'Menunggu',
                                        'gagal' => 'Gagal / Kedaluwarsa',
                                        default => 'Belum Bayar',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        {{ $peserta?->namaLengkap() ?? '-' }}
                                    </td>
                                    <td style="font-size:12.5px;color:#4b5563">
                                        {{ $peserta?->email ?? '-' }}
                                    </td>
                                    <td style="font-size:12.5px;color:#4b5563">
                                        {{ $periode?->nama ?? '-' }}
                                    </td>
                                    <td>
                                        <div style="font-weight:600">
                                            {{ $biaya?->nama ?? 'Biaya Tambahan' }}
                                        </div>
                                        <div style="font-size:12px;color:#6b7280">
                                            Rp {{ number_format($biaya->nominal ?? 0, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $statusClass }}">
                                            <span class="status-dot"></span>
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($peserta)
                                            <a href="{{ route($routePrefix . '.pendaftaran.show', $peserta->id) }}" class="table-action-btn">
                                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                Lihat Pendaftaran
                                            </a>
                                        @else
                                            <span style="font-size:12px;color:#9ca3af">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="margin-top:10px;font-size:12.5px;color:#94a3b8;display:flex;justify-content:flex-end;">
                    {{ $tagihan->links() }}
                </div>
            @else
                <div class="empty-state">
                    Belum ada tagihan biaya tambahan yang dibuat.
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

