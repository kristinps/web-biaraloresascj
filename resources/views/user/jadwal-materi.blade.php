@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'user.layouts.app')

@section('title', 'Jadwal Materi')
@section('page-title', 'Jadwal Materi')
@section('page-subtitle', 'Jadwal materi kursus pernikahan per periode')

@push('styles')
<style>
    /* Background sesuai tema (indigo/purple) */
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
        background: radial-gradient(ellipse 80% 50% at 50% -20%, rgba(99, 102, 241, 0.12), transparent),
                    radial-gradient(ellipse 60% 40% at 100% 50%, rgba(139, 92, 246, 0.08), transparent),
                    radial-gradient(ellipse 50% 30% at 0% 80%, rgba(99, 102, 241, 0.06), transparent);
        pointer-events: none;
    }

    .jadwal-materi-page .page-header {
        position: relative;
        margin-bottom: 28px;
    }
    .jadwal-materi-page .page-header h1 {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.02em;
    }
    .jadwal-materi-page .page-header p {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
    }

    /* Tempat / area jadwal materi */
    .jadwal-materi-section {
        position: relative;
        max-width: 900px;
    }
    .card {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(10px);
        border-radius: 18px;
        border: 1px solid rgba(99, 102, 241, 0.12);
        box-shadow: 0 4px 24px rgba(99, 102, 241, 0.06), 0 1px 3px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-bottom: 22px;
        transition: box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .card:hover {
        border-color: rgba(99, 102, 241, 0.2);
        box-shadow: 0 8px 32px rgba(99, 102, 241, 0.1), 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    .card-header {
        padding: 22px 26px;
        border-bottom: 1px solid rgba(241, 245, 249, 0.9);
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.04) 0%, rgba(139, 92, 246, 0.03) 100%);
    }
    .card-header h2 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }
    .card-header p {
        font-size: 12.5px;
        color: #64748b;
        margin-top: 4px;
    }
    .periode-tag {
        display: inline-flex;
        padding: 5px 12px;
        border-radius: 999px;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.18), rgba(139, 92, 246, 0.14));
        color: #4f46e5;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 10px;
        border: 1px solid rgba(99, 102, 241, 0.2);
    }
    .materi-list {
        padding: 18px 26px;
    }
    .materi-item {
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
    }
    .materi-item:last-child {
        border-bottom: none;
    }
    .materi-item .judul {
        font-weight: 600;
        color: #1e293b;
        font-size: 14px;
    }
    .materi-item .tanggal {
        font-size: 13px;
        color: #64748b;
    }
    .materi-item .link {
        font-size: 12px;
        color: #6366f1;
        text-decoration: none;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 8px;
        background: rgba(99, 102, 241, 0.08);
        transition: background 0.2s, color 0.2s;
    }
    .materi-item .link:hover {
        background: rgba(99, 102, 241, 0.16);
        color: #4f46e5;
    }
    .empty-state {
        text-align: center;
        padding: 56px 24px;
        color: #64748b;
        font-size: 14px;
    }
    .empty-state .cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 16px;
        padding: 10px 20px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .empty-state .cta-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        color: #fff;
    }

    @media (max-width: 768px) {
        .jadwal-materi-page { margin: -20px -16px; padding: 20px 16px; }
        .jadwal-materi-page .page-header h1 { font-size: 19px; }
        .card-header, .materi-list { padding-left: 18px; padding-right: 18px; }
    }
</style>
@endpush

@section('content')
<div class="jadwal-materi-page">
    <div class="page-header">
        <h1>Jadwal Materi</h1>
        <p>Jadwal materi kursus pernikahan per periode — siap Anda ikuti</p>
    </div>

    <div class="jadwal-materi-section">
        @if($pendaftaranList->count() > 0)
            @php
                $shownPeriode = [];
            @endphp
            @foreach($pendaftaranList as $item)
                @if($item->periode && !in_array($item->periode->id, $shownPeriode))
                    @php $shownPeriode[] = $item->periode->id; @endphp
                    <div class="card">
                        <div class="card-header">
                            <span class="periode-tag">{{ $item->periode->nama }}</span>
                            <h2>Jadwal Materi — {{ $item->periode->nama }}</h2>
                            <p>Periode {{ $item->periode->tanggal_mulai ? $item->periode->tanggal_mulai->locale('id')->isoFormat('D MMM YYYY') : '' }} s.d. {{ $item->periode->tanggal_selesai ? $item->periode->tanggal_selesai->locale('id')->isoFormat('D MMM YYYY') : '' }}</p>
                        </div>
                        <div class="materi-list">
                            @php
                                $materiTerkirim = ($item->periode->materi ?? collect())->where('terkirim_materi', true);
                            @endphp
                            @forelse($materiTerkirim as $m)
                            <div class="materi-item">
                                <div style="flex:1;min-width:0">
                                    <div class="judul">{{ $m->judul }}</div>
                                    @if($m->nama_pemateri)
                                        <div class="tanggal">👤 Pemateri: {{ $m->nama_pemateri }}</div>
                                    @endif
                                    @if($m->tanggal_pelaksanaan)
                                        <div class="tanggal">📅 {{ $m->tanggal_pelaksanaan->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</div>
                                    @endif
                                    @if($m->deskripsi)
                                        <div style="font-size:12.5px;color:#64748b;margin-top:4px">{{ Str::limit($m->deskripsi, 120) }}</div>
                                    @endif
                                </div>
                                @if($m->zoom_link)
                                    <a href="{{ $m->zoom_link }}" target="_blank" rel="noopener" class="link">🔗 Link Zoom</a>
                                @endif
                                @if($m->file_materi)
                                    <a href="{{ asset('storage/'.$m->file_materi) }}" target="_blank" rel="noopener" class="link">📄 Materi</a>
                                @endif
                            </div>
                            @empty
                            <div class="empty-state" style="padding:32px 0">
                                <p>Belum ada materi yang dikirim untuk periode ini.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                @endif
            @endforeach
            @if(empty($shownPeriode))
                <div class="card">
                    <div class="empty-state">
                        <p>Belum ada periode dengan jadwal materi. Setelah pendaftaran Anda ditetapkan ke suatu periode, jadwal akan muncul di sini.</p>
                    </div>
                </div>
            @endif
        @else
            <div class="card">
                <div class="empty-state">
                    <p>Belum ada data pendaftaran.</p>
                    <a href="{{ route('kursus-pernikahan') }}" class="cta-btn">Daftar Kursus Pernikahan</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
