@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'user.layouts.app')

@section('title', 'Sertifikat')
@section('page-title', 'Sertifikat')
@section('page-subtitle', 'Status sertifikat kelulusan kursus pernikahan')

@push('styles')
<style>
    .card { background:#fff; border-radius:16px; border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,0.04); overflow:hidden; margin-bottom:20px; }
    .card-header { padding:20px 24px; border-bottom:1px solid #f1f5f9; }
    .card-header h2 { font-size:15.5px; font-weight:700; color:#1e293b; }
    .card-header p { font-size:12.5px; color:#94a3b8; margin-top:2px; }
    .cert-item { padding:20px 24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; border-bottom:1px solid #f1f5f9; }
    .cert-item:last-child { border-bottom:none; }
    .cert-item.lulus { background:linear-gradient(90deg,#f0fdf4 0%, transparent 100%); }
    .badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:99px; font-size:12px; font-weight:600; }
    .badge-green { background:#f0fdf4; color:#15803d; }
    .badge-slate { background:#f8fafc; color:#475569; }
    .empty-state { text-align:center; padding:56px 24px; color:#94a3b8; }
    .info-box { background:#eff6ff; border:1px solid #bfdbfe; border-radius:12px; padding:16px 20px; font-size:14px; color:#1e40af; margin-top:12px; }
    .btn-download { display:inline-flex; align-items:center; gap:8px; padding:10px 18px; background:linear-gradient(135deg,#15803d,#16a34a); color:#fff; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; margin-top:12px; box-shadow:0 2px 8px rgba(21,128,61,0.3); transition:transform 0.2s, box-shadow 0.2s; }
    .btn-download:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(21,128,61,0.4); color:#fff; }
    .btn-download svg { width:18px; height:18px; flex-shrink:0; }
</style>
@endpush

@section('content')
@if($pendaftaranList->count() > 0)
    <div class="card">
        <div class="card-header">
            <h2>Status Sertifikat</h2>
            <p>Sertifikat kelulusan dapat diambil di kantor Biara Loresa SCJ setelah status kursus Lulus.</p>
        </div>
        @foreach($pendaftaranList as $item)
        <div class="cert-item {{ $item->status_kursus === 'lulus' ? 'lulus' : '' }}">
            <div>
                <strong style="color:#1e293b;font-size:15px">{{ $item->nama_pria }} &amp; {{ $item->nama_wanita }}</strong>
                <div style="font-size:12.5px;color:#64748b;margin-top:2px">
                    {{ $item->periode ? $item->periode->nama : '—' }} · {{ $item->tanggal_pernikahan ? $item->tanggal_pernikahan->locale('id')->isoFormat('D MMM YYYY') : '—' }}
                </div>
            </div>
            <div>
                @if($item->status_kursus === 'lulus')
                    <span class="badge badge-green">Lulus — Sertifikat tersedia</span>
                    <a href="{{ route($userRoutePrefix . '.sertifikat.download', $item) }}" class="btn-download">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download Sertifikat
                    </a>
                    <div class="info-box">
                        Anda juga dapat mengambil sertifikat fisik di kantor Biara Loresa SCJ. Hubungi kami untuk jadwal pengambilan.
                    </div>
                @else
                    <span class="badge badge-slate">{{ $item->status_kursus ? ucfirst(str_replace('_', ' ', $item->status_kursus)) : 'Belum terjadwal' }}</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="card">
        <div class="empty-state">
            <p>Belum ada data pendaftaran.</p>
            <a href="{{ route('kursus-pernikahan') }}" style="display:inline-flex;align-items:center;gap:6px;margin-top:14px;padding:8px 16px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none">Daftar Kursus Pernikahan</a>
        </div>
    </div>
@endif
@endsection
