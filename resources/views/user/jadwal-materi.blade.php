@extends('user.layouts.app')

@section('title', 'Jadwal Materi')
@section('page-title', 'Jadwal Materi')
@section('page-subtitle', 'Jadwal materi kursus pernikahan per periode')

@push('styles')
<style>
    .card { background:#fff; border-radius:16px; border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,0.04); overflow:hidden; margin-bottom:20px; }
    .card-header { padding:20px 24px; border-bottom:1px solid #f1f5f9; }
    .card-header h2 { font-size:15.5px; font-weight:700; color:#1e293b; }
    .card-header p { font-size:12.5px; color:#94a3b8; margin-top:2px; }
    .periode-tag { display:inline-flex; padding:3px 9px; border-radius:99px; background:#ede9fe; color:#6d28d9; font-size:12px; font-weight:600; margin-bottom:8px; }
    .materi-list { padding:16px 24px; }
    .materi-item { padding:14px 0; border-bottom:1px solid #f1f5f9; display:flex; flex-wrap:wrap; align-items:center; gap:10px; }
    .materi-item:last-child { border-bottom:none; }
    .materi-item .judul { font-weight:600; color:#1e293b; font-size:14px; }
    .materi-item .tanggal { font-size:13px; color:#64748b; }
    .materi-item .link { font-size:12px; color:#6366f1; text-decoration:none; }
    .materi-item .link:hover { text-decoration:underline; }
    .empty-state { text-align:center; padding:56px 24px; color:#94a3b8; }
</style>
@endpush

@section('content')
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
                    @forelse(($item->periode->materi ?? collect()) as $m)
                    <div class="materi-item">
                        <div style="flex:1;min-width:0">
                            <div class="judul">{{ $m->judul }}</div>
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
                            <a href="{{ asset('storage/'.$m->file_materi) }}" target="_blank" rel="noopener" class="link">Materi</a>
                        @endif
                    </div>
                    @empty
                    <div class="empty-state" style="padding:32px 0">
                        <p>Jadwal materi untuk periode ini belum diunggah.</p>
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
            <a href="{{ route('kursus-pernikahan') }}" style="display:inline-flex;align-items:center;gap:6px;margin-top:14px;padding:8px 16px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none">Daftar Kursus Pernikahan</a>
        </div>
    </div>
@endif
@endsection
