@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'layouts.dashboard')

@section('title', 'Jadwal Materi')
@section('page-title', 'Jadwal Materi')
@section('page-subtitle', 'Jadwal materi kursus pernikahan per periode')

@push('styles')
<style>
    .jadwal-materi-page {
        min-height: calc(100vh - 56px);
        background: linear-gradient(165deg, #eef2ff 0%, #f5f3ff 35%, #faf5ff 60%, #f1f5f9 100%);
        margin: -28px;
        padding: 28px;
        position: relative;
    }
    .jadwal-materi-page::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(ellipse 80% 50% at 50% -20%, rgba(99, 102, 241, 0.1), transparent),
                    radial-gradient(ellipse 60% 40% at 100% 50%, rgba(139, 92, 246, 0.06), transparent),
                    radial-gradient(ellipse 50% 30% at 0% 80%, rgba(99, 102, 241, 0.05), transparent);
        pointer-events: none;
    }

    .jadwal-materi-page .page-header {
        position: relative;
        margin-bottom: 24px;
    }
    .jadwal-materi-page .page-header h1 {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.02em;
        margin: 0 0 4px 0;
    }
    .jadwal-materi-page .page-header p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    .jadwal-materi-section {
        position: relative;
        max-width: 880px;
    }

    .jadwal-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        border: 1px solid rgba(99, 102, 241, 0.1);
        box-shadow: 0 4px 20px rgba(99, 102, 241, 0.06), 0 1px 3px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-bottom: 20px;
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .jadwal-card:hover {
        border-color: rgba(99, 102, 241, 0.18);
        box-shadow: 0 8px 28px rgba(99, 102, 241, 0.08), 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .jadwal-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.04) 0%, rgba(139, 92, 246, 0.03) 100%);
    }
    .jadwal-card-header .periode-tag {
        display: inline-flex;
        padding: 5px 12px;
        border-radius: 999px;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.16), rgba(139, 92, 246, 0.12));
        color: #4f46e5;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 10px;
        border: 1px solid rgba(99, 102, 241, 0.18);
    }
    .jadwal-card-header h2 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px 0;
    }
    .jadwal-card-header .periode-date {
        font-size: 12.5px;
        color: #64748b;
        margin: 0;
    }

    .jadwal-materi-list {
        padding: 16px 24px 20px;
    }
    .materi-item {
        padding: 16px 18px;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        background: #fafbff;
        margin-bottom: 12px;
        transition: background 0.2s, border-color 0.2s;
    }
    .materi-item:last-child { margin-bottom: 0; }
    .materi-item:hover {
        background: #f8fafc;
        border-color: #e2e8f0;
    }

    .materi-item-top {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 8px;
    }
    .materi-item .judul {
        font-weight: 600;
        color: #1e293b;
        font-size: 15px;
        line-height: 1.35;
        flex: 1;
        min-width: 0;
    }
    .materi-item-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        flex-shrink: 0;
    }
    .materi-item-actions .btn-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #4f46e5;
        text-decoration: none;
        font-weight: 500;
        padding: 8px 14px;
        border-radius: 10px;
        background: rgba(99, 102, 241, 0.1);
        border: 1px solid rgba(99, 102, 241, 0.15);
        transition: background 0.2s, color 0.2s, border-color 0.2s;
    }
    .materi-item-actions .btn-link:hover {
        background: rgba(99, 102, 241, 0.18);
        color: #4338ca;
        border-color: rgba(99, 102, 241, 0.25);
    }
    .materi-item-actions .btn-link svg { width: 14px; height: 14px; flex-shrink: 0; }

    .materi-item-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px 20px;
        font-size: 12.5px;
        color: #64748b;
    }
    .materi-item-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .materi-item-desc {
        font-size: 12.5px;
        color: #64748b;
        margin-top: 8px;
        line-height: 1.45;
    }

    .jadwal-empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #64748b;
        font-size: 14px;
        line-height: 1.5;
    }
    .jadwal-empty-state p { margin: 0; }
    .jadwal-empty-state .cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
        padding: 12px 22px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .jadwal-empty-state .cta-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        color: #fff;
    }

    .materi-empty-inline {
        padding: 28px 20px;
        text-align: center;
        font-size: 13px;
        color: #64748b;
        background: #f8fafc;
        border-radius: 12px;
        margin: 0 24px 20px;
        border: 1px dashed #e2e8f0;
    }

    @media (max-width: 768px) {
        .jadwal-materi-page { margin: -20px -16px; padding: 20px 16px; }
        .jadwal-materi-page .page-header h1 { font-size: 19px; }
        .jadwal-card-header, .jadwal-materi-list { padding-left: 18px; padding-right: 18px; }
        .materi-item { padding: 14px; }
        .materi-item-top { flex-direction: column; align-items: stretch; }
        .materi-item-actions { justify-content: flex-start; }
        .materi-empty-inline { margin-left: 18px; margin-right: 18px; }
    }
</style>
@endpush

@section('content')
<div class="jadwal-materi-page">
    <header class="page-header">
        <h1>Jadwal Materi</h1>
        <p>Jadwal materi kursus pernikahan per periode — siap Anda ikuti</p>
    </header>

    <div class="jadwal-materi-section">
        @if($pendaftaranList->count() > 0)
            @php $shownPeriode = []; @endphp
            @foreach($pendaftaranList as $item)
                @if($item->periode && !in_array($item->periode->id, $shownPeriode))
                    @php $shownPeriode[] = $item->periode->id; @endphp
                    @php
                        $periode = $item->periode;
                        $materiTerkirim = ($periode->materi ?? collect())->where('terkirim_materi', true);
                    @endphp
                    <article class="jadwal-card">
                        <div class="jadwal-card-header">
                            <span class="periode-tag">{{ $periode->nama }}</span>
                            <h2>Jadwal materi</h2>
                            <p class="periode-date">
                                @if($periode->tanggal_mulai && $periode->tanggal_selesai)
                                    {{ $periode->tanggal_mulai->locale('id')->isoFormat('D MMM YYYY') }} – {{ $periode->tanggal_selesai->locale('id')->isoFormat('D MMM YYYY') }}
                                @else
                                    Jadwal periode ini
                                @endif
                            </p>
                        </div>
                        <div class="jadwal-materi-list">
                            @forelse($materiTerkirim as $m)
                                <div class="materi-item">
                                    <div class="materi-item-top">
                                        <h3 class="judul">{{ $m->judul }}</h3>
                                        <div class="materi-item-actions">
                                            @if($m->zoom_link)
                                                <a href="{{ $m->zoom_link }}" target="_blank" rel="noopener" class="btn-link">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                    Link Zoom
                                                </a>
                                            @endif
                                            @if($m->file_materi)
                                                <a href="{{ asset('storage/'.$m->file_materi) }}" target="_blank" rel="noopener" class="btn-link">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    Materi
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="materi-item-meta">
                                        @if($m->nama_pemateri)
                                            <span>👤 {{ $m->nama_pemateri }}</span>
                                        @endif
                                        @if($m->tanggal_pelaksanaan)
                                            <span>📅 {{ $m->tanggal_pelaksanaan->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                                        @endif
                                    </div>
                                    @if($m->deskripsi)
                                        <p class="materi-item-desc">{{ Str::limit($m->deskripsi, 150) }}</p>
                                    @endif
                                </div>
                            @empty
                                <div class="materi-empty-inline">Belum ada materi yang dikirim untuk periode ini.</div>
                            @endforelse
                        </div>
                    </article>
                @endif
            @endforeach
            @if(empty($shownPeriode))
                <div class="jadwal-card">
                    <div class="jadwal-empty-state">
                        <p>Belum ada periode dengan jadwal materi. Setelah pendaftaran Anda ditetapkan ke suatu periode, jadwal akan muncul di sini.</p>
                    </div>
                </div>
            @endif
        @else
            <div class="jadwal-card">
                <div class="jadwal-empty-state">
                    <p>Belum ada data pendaftaran.</p>
                    <a href="{{ route('kursus-pernikahan') }}" class="cta-btn">Daftar Kursus Pernikahan</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
