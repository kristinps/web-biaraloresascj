@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'layouts.dashboard')

@section('title', 'Biaya Tambahan')
@section('page-title', 'Biaya Tambahan')
@section('page-subtitle', 'Daftar biaya tambahan yang perlu Anda bayar per periode')

@push('styles')
<style>
    .biaya-page {
        max-width: 900px;
    }
    .biaya-header {
        margin-bottom: 18px;
    }
    .biaya-header h2 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }
    .biaya-header p {
        font-size: 13px;
        color: #6b7280;
        margin: 0;
    }

    .biaya-card {
        background: rgba(255,255,255,0.96);
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 18px rgba(15,23,42,0.08);
        padding: 18px 18px 16px;
        margin-bottom: 16px;
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }
    .biaya-left-icon {
        width: 40px;
        height: 40px;
        border-radius: 14px;
        background: linear-gradient(135deg,#6366f1,#8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
        box-shadow: 0 8px 20px rgba(79,70,229,0.4);
    }
    .biaya-left-icon svg { width: 20px; height: 20px; }

    .biaya-main {
        flex: 1;
        min-width: 0;
    }
    .biaya-main-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
    }
    .biaya-main-title h3 {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }
    .biaya-main-title .periode-pill {
        display: inline-flex;
        align-items: center;
        padding: 4px 11px;
        border-radius: 999px;
        background: #eef2ff;
        color: #3730a3;
        font-size: 11.5px;
        font-weight: 600;
    }
    .biaya-main-info {
        margin-top: 4px;
        font-size: 13px;
        color: #4b5563;
    }
    .biaya-main-info strong {
        font-weight: 700;
        color: #111827;
    }
    .biaya-main-ket {
        margin-top: 6px;
        font-size: 12.5px;
        color: #6b7280;
    }

    .biaya-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
        min-width: 150px;
    }
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

    .btn-bayar {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 15px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
        background: linear-gradient(135deg,#22c55e,#16a34a);
        color: #fff !important;
        box-shadow: 0 4px 14px rgba(34,197,94,0.35);
        transition: opacity .18s, transform .12s, box-shadow .18s;
    }
    .btn-bayar:hover { opacity:.94; transform:translateY(-1px); box-shadow:0 6px 18px rgba(34,197,94,0.45); }
    .btn-bayar svg { width: 14px; height: 14px; }

    .hint-text {
        font-size: 11.5px;
        color: #9ca3af;
        max-width: 260px;
        text-align: right;
    }

    .empty-state {
        margin-top: 18px;
        padding: 40px 22px;
        border-radius: 18px;
        border: 1px dashed rgba(148,163,184,0.6);
        background: rgba(15,23,42,0.02);
        text-align: center;
        color: #6b7280;
        font-size: 13.5px;
    }
    .empty-state strong { color:#111827; }
    .empty-icon {
        width: 46px;
        height: 46px;
        border-radius: 16px;
        margin: 0 auto 10px;
        background: linear-gradient(135deg,#eef2ff,#e0f2fe);
        display:flex;
        align-items:center;
        justify-content:center;
        color:#4f46e5;
    }
    .empty-icon svg { width: 22px; height: 22px; }

    @media (max-width: 768px) {
        .biaya-card { flex-direction: row; }
        .biaya-right { align-items: flex-start; margin-top: 8px; }
        .hint-text { text-align: left; }
    }
</style>
@endpush

@section('content')
<div class="biaya-page">
    <div class="biaya-header">
        <h2>Biaya Tambahan</h2>
        <p>Jika ada biaya tambahan dari admin, tagihan akan muncul di sini. Klik tombol Bayar untuk melihat QRIS.</p>
    </div>

    @if($tagihanBiaya->count() > 0)
        @foreach($tagihanBiaya as $item)
            @php
                $biaya = $item->biaya;
                $periode = $biaya?->periode;
                $status = $item->status;
                $statusClass = match($status) {
                    'lunas' => 'status-lunas',
                    'menunggu' => 'status-menunggu',
                    'gagal' => 'status-gagal',
                    default => 'status-belum',
                };
                $statusLabel = match($status) {
                    'lunas' => 'Lunas',
                    'menunggu' => 'Menunggu Konfirmasi',
                    'gagal' => 'Gagal / Kedaluwarsa',
                    default => 'Belum Dibayar',
                };
            @endphp
            <div class="biaya-card">
                <div class="biaya-left-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 12v-2m0 2c-1.11 0-2.08-.402-2.599-1M21 12A9 9 0 113 12a9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="biaya-main">
                    <div class="biaya-main-title">
                        <h3>{{ $biaya?->nama ?? 'Biaya Tambahan' }}</h3>
                        @if($periode)
                            <span class="periode-pill">{{ $periode->nama }}</span>
                        @endif
                    </div>
                    <div class="biaya-main-info">
                        Jumlah biaya: <strong>Rp {{ number_format($biaya->nominal ?? 0, 0, ',', '.') }}</strong>
                    </div>
                    @if($biaya?->keterangan)
                        <div class="biaya-main-ket">
                            {{ $biaya->keterangan }}
                        </div>
                    @endif
                </div>
                <div class="biaya-right">
                    <span class="status-badge {{ $statusClass }}">
                        <span class="status-dot"></span>
                        {{ $statusLabel }}
                    </span>
                    @if($status !== 'lunas')
                        <a href="{{ route('dashboard.user.biaya.show', $item->id) }}" class="btn-bayar">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 12v-2m0 2c-1.11 0-2.08-.402-2.599-1M21 12A9 9 0 113 12a9 9 0 0118 0z"/>
                            </svg>
                            Bayar / Lihat QRIS
                        </a>
                        <div class="hint-text">
                            Tekan tombol ini untuk membuka halaman QRIS. Scan menggunakan aplikasi e-wallet atau mobile banking Anda.
                        </div>
                    @else
                        <div class="hint-text">
                            Pembayaran biaya tambahan ini sudah kami terima. Terima kasih.
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 12v-2m0 2c-1.11 0-2.08-.402-2.599-1M21 12A9 9 0 113 12a9 9 0 0118 0z"/>
                </svg>
            </div>
            <p><strong>Belum ada biaya tambahan.</strong></p>
            <p style="margin-top:4px;">Jika admin menetapkan biaya tambahan untuk periode kursus Anda, informasi akan tampil di halaman ini.</p>
        </div>
    @endif
</div>
@endsection
