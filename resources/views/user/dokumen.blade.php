@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'user.layouts.app')

@section('title', 'Kelengkapan Dokumen')
@section('page-title', 'Kelengkapan Dokumen')
@section('page-subtitle', 'Status dan kelengkapan dokumen tiap pendaftaran')

@push('styles')
<style>
    .dokumen-page { max-width: 900px; }
    .dokumen-kotak {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        overflow: hidden;
        padding: 20px 24px;
    }
    .dokumen-summary {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .dokumen-summary-card {
        background: #f8fafc;
        border-radius: 10px;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .dokumen-summary-icon {
        width: 34px; height: 34px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .dokumen-summary-icon svg { width: 17px; height: 17px; color: #fff; }
    .dokumen-summary-icon.purple { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
    .dokumen-summary-icon.green { background: linear-gradient(135deg, #22c55e, #4ade80); }
    .dokumen-summary-icon.amber { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .dokumen-summary-body .val { font-size: 18px; font-weight: 800; color: #1e293b; line-height: 1; }
    .dokumen-summary-body .lbl { font-size: 11px; color: #64748b; margin-top: 0; font-weight: 500; }

    .doc-card {
        background: #fafbfc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        margin-bottom: 12px;
    }
    .doc-card:last-child { margin-bottom: 0; }
    .doc-card-header {
        padding: 12px 18px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px 12px;
    }
    .doc-card-periode {
        padding: 2px 8px;
        border-radius: 999px;
        background: #ede9fe;
        color: #5b21b6;
        font-size: 10.5px;
        font-weight: 700;
    }
    .doc-card-title { font-size: 15px; font-weight: 700; color: #1e293b; margin: 0; flex: 1; min-width: 120px; }
    .doc-card-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }
    .doc-card-status.lengkap { background: #f0fdf4; color: #15803d; }
    .doc-card-status.tidak_lengkap { background: #fffbeb; color: #b45309; }
    .doc-card-status.belum { background: #f1f5f9; color: #475569; }
    .doc-card-catatan {
        font-size: 11.5px;
        color: #64748b;
        width: 100%;
        margin: 2px 0 0;
    }

    .doc-list {
        padding: 8px 18px 12px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2px 16px;
    }
    .doc-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 6px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .doc-item:nth-last-child(-n+2) { border-bottom: none; }
    .doc-item-left {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
    }
    .doc-item-icon {
        width: 26px; height: 26px;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .doc-item-icon svg { width: 13px; height: 13px; }
    .doc-item-icon.uploaded { background: #f0fdf4; color: #16a34a; }
    .doc-item-icon.pending { background: #f1f5f9; color: #94a3b8; }
    .doc-name { font-size: 12.5px; color: #334155; font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .doc-badge {
        padding: 2px 8px;
        border-radius: 999px;
        font-size: 10.5px;
        font-weight: 600;
        flex-shrink: 0;
    }
    .doc-badge.uploaded { background: #f0fdf4; color: #15803d; }
    .doc-badge.pending { background: #f1f5f9; color: #64748b; }

    .doc-card-footer {
        padding: 8px 18px 12px;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .doc-card-footer .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: #fff;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
    }
    .doc-card-footer .btn-detail:hover {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        border-color: transparent;
    }
    .doc-card-footer .btn-detail svg { width: 14px; height: 14px; }

    .dokumen-empty {
        text-align: center;
        padding: 36px 24px;
    }
    .dokumen-empty-icon {
        width: 56px; height: 56px;
        margin: 0 auto 14px;
        border-radius: 14px;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
    }
    .dokumen-empty-icon svg { width: 26px; height: 26px; color: #94a3b8; }
    .dokumen-empty h3 { font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
    .dokumen-empty p { font-size: 13px; color: #64748b; margin-bottom: 16px; }
    .dokumen-empty .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: transform 0.15s, box-shadow 0.2s;
    }
    .dokumen-empty .btn-cta:hover { box-shadow: 0 4px 14px rgba(99,102,241,0.35); }

    @media (max-width: 640px) {
        .doc-list { grid-template-columns: 1fr; }
        .doc-item { border-bottom: 1px solid #f1f5f9; }
        .doc-item:nth-child(4n), .doc-item:nth-child(4n-1) { border-bottom: 1px solid #f1f5f9; }
        .doc-item:last-child { border-bottom: none; }
    }
    @media (max-width: 768px) {
        .dokumen-kotak { padding: 16px; }
        .doc-card-header, .doc-list, .doc-card-footer { padding-left: 14px; padding-right: 14px; }
    }
</style>
@endpush

@section('content')
<div class="dokumen-page">
    <div class="dokumen-kotak">
    @if($pendaftaranList->count() > 0)
        @php
            $total = $pendaftaranList->count();
            $lengkap = $pendaftaranList->where('status_dokumen', 'lengkap')->count();
            $tidakLengkap = $pendaftaranList->where('status_dokumen', 'tidak_lengkap')->count();
        @endphp
        <div class="dokumen-summary">
            <div class="dokumen-summary-card">
                <div class="dokumen-summary-icon purple">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <div class="dokumen-summary-body">
                    <div class="val">{{ $total }}</div>
                    <div class="lbl">Total Pendaftaran</div>
                </div>
            </div>
            <div class="dokumen-summary-card">
                <div class="dokumen-summary-icon green">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="dokumen-summary-body">
                    <div class="val">{{ $lengkap }}</div>
                    <div class="lbl">Dokumen Lengkap</div>
                </div>
            </div>
            <div class="dokumen-summary-card">
                <div class="dokumen-summary-icon amber">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L12.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </div>
                <div class="dokumen-summary-body">
                    <div class="val">{{ $tidakLengkap }}</div>
                    <div class="lbl">Perlu Dilengkapi</div>
                </div>
            </div>
        </div>

        @foreach($pendaftaranList as $item)
        <article class="doc-card">
            <div class="doc-card-header">
                <span class="doc-card-periode">{{ $item->periode ? $item->periode->nama : 'Tanpa periode' }}</span>
                <h2 class="doc-card-title">{{ $item->nama_pria }} &amp; {{ $item->nama_wanita }}</h2>
                @php $sd = $item->status_dokumen ?? 'belum_diperiksa'; @endphp
                <span class="doc-card-status {{ $sd === 'lengkap' ? 'lengkap' : ($sd === 'tidak_lengkap' ? 'tidak_lengkap' : 'belum') }}">
                    @if($sd === 'lengkap')
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Lengkap
                    @elseif($sd === 'tidak_lengkap')
                        Perlu dilengkapi
                    @else
                        Belum dicek
                    @endif
                </span>
                @if($sd === 'tidak_lengkap' && $item->catatan_dokumen)
                    <p class="doc-card-catatan">{{ Str::limit($item->catatan_dokumen, 80) }}</p>
                @endif
            </div>
            <div class="doc-list">
                @php
                    $docs = [
                        ['label' => 'KTP Pria', 'val' => $item->ktp_pria],
                        ['label' => 'KTP Wanita', 'val' => $item->ktp_wanita],
                        ['label' => 'Foto Pria', 'val' => $item->foto_pria],
                        ['label' => 'Foto Wanita', 'val' => $item->foto_wanita],
                        ['label' => 'Surat Baptis Pria', 'val' => $item->surat_baptis_pria],
                        ['label' => 'Surat Baptis Wanita', 'val' => $item->surat_baptis_wanita],
                        ['label' => 'Kombas Pria', 'val' => $item->surat_pengantar_kombas_pria],
                        ['label' => 'Kombas Wanita', 'val' => $item->surat_pengantar_kombas_wanita],
                    ];
                @endphp
                @foreach($docs as $d)
                <div class="doc-item">
                    <div class="doc-item-left">
                        <div class="doc-item-icon {{ $d['val'] ? 'uploaded' : 'pending' }}">
                            @if($d['val'])
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            @else
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            @endif
                        </div>
                        <span class="doc-name">{{ $d['label'] }}</span>
                    </div>
                    @if($d['val'])
                        <span class="doc-badge uploaded">✓</span>
                    @else
                        <span class="doc-badge pending">—</span>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="doc-card-footer">
                <a href="{{ route('kursus-pernikahan.sukses', $item->id) }}" class="btn-detail">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Lihat detail pendaftaran
                </a>
            </div>
        </article>
        @endforeach
    @else
        <div class="dokumen-empty">
            <div class="dokumen-empty-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </div>
            <h3>Belum ada data pendaftaran</h3>
            <p>Daftarkan diri Anda ke kursus pernikahan untuk mengelola dokumen dari dashboard.</p>
            <a href="{{ route('kursus-pernikahan') }}" class="btn-cta">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Daftar Kursus Pernikahan
            </a>
        </div>
    @endif
    </div>
</div>
@endsection
