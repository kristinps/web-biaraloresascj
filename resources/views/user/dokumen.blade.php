@extends('user.layouts.app')

@section('title', 'Kelengkapan Dokumen')
@section('page-title', 'Kelengkapan Dokumen')
@section('page-subtitle', 'Status dan kelengkapan dokumen tiap pendaftaran')

@push('styles')
<style>
    .card { background:#fff; border-radius:16px; border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,0.04); overflow:hidden; margin-bottom:20px; }
    .card-header { padding:20px 24px; border-bottom:1px solid #f1f5f9; }
    .card-header h2 { font-size:15.5px; font-weight:700; color:#1e293b; }
    .card-header p { font-size:12.5px; color:#94a3b8; margin-top:2px; }
    .doc-list { padding:20px 24px; }
    .doc-item { display:flex; align-items:center; justify-content:space-between; padding:12px 0; border-bottom:1px solid #f1f5f9; }
    .doc-item:last-child { border-bottom:none; }
    .doc-name { font-size:14px; color:#1e293b; font-weight:500; }
    .badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:99px; font-size:12px; font-weight:600; }
    .badge-green { background:#f0fdf4; color:#15803d; }
    .badge-amber { background:#fffbeb; color:#b45309; }
    .badge-slate { background:#f8fafc; color:#475569; }
    .empty-state { text-align:center; padding:56px 24px; color:#94a3b8; }
    .periode-tag { display:inline-flex; padding:3px 9px; border-radius:99px; background:#ede9fe; color:#6d28d9; font-size:12px; font-weight:600; margin-bottom:8px; }
</style>
@endpush

@section('content')
@if($pendaftaranList->count() > 0)
    @foreach($pendaftaranList as $item)
    <div class="card">
        <div class="card-header">
            <span class="periode-tag">{{ $item->periode ? $item->periode->nama : 'Tanpa periode' }}</span>
            <h2>{{ $item->nama_pria }} &amp; {{ $item->nama_wanita }}</h2>
            <p>
                Status dokumen:
                @if($item->status_dokumen === 'lengkap')
                    <span class="badge badge-green">Lengkap</span>
                @elseif($item->status_dokumen === 'revisi')
                    <span class="badge badge-amber">Perlu revisi</span>
                    @if($item->catatan_dokumen) — {{ Str::limit($item->catatan_dokumen, 60) }} @endif
                @else
                    <span class="badge badge-slate">Belum dicek</span>
                @endif
            </p>
        </div>
        <div class="doc-list">
            @php
                $docs = [
                    ['label' => 'KTP Calon Mempelai Pria', 'val' => $item->ktp_pria],
                    ['label' => 'KTP Calon Mempelai Wanita', 'val' => $item->ktp_wanita],
                    ['label' => 'Foto Pria', 'val' => $item->foto_pria],
                    ['label' => 'Foto Wanita', 'val' => $item->foto_wanita],
                    ['label' => 'Surat Baptis Pria', 'val' => $item->surat_baptis_pria],
                    ['label' => 'Surat Baptis Wanita', 'val' => $item->surat_baptis_wanita],
                    ['label' => 'Surat Pengantar Kombas Pria', 'val' => $item->surat_pengantar_kombas_pria],
                    ['label' => 'Surat Pengantar Kombas Wanita', 'val' => $item->surat_pengantar_kombas_wanita],
                ];
            @endphp
            @foreach($docs as $d)
            <div class="doc-item">
                <span class="doc-name">{{ $d['label'] }}</span>
                @if($d['val'])
                    <span class="badge badge-green">✓ Terunggah</span>
                @else
                    <span class="badge badge-slate">Belum</span>
                @endif
            </div>
            @endforeach
        </div>
        <div style="padding:0 24px 20px">
            <a href="{{ route('kursus-pernikahan.sukses', $item->id) }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#f1f5f9;color:#475569;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none">Lihat detail pendaftaran</a>
        </div>
    </div>
    @endforeach
@else
    <div class="card">
        <div class="empty-state">
            <p>Belum ada data pendaftaran.</p>
            <a href="{{ route('kursus-pernikahan') }}" style="display:inline-flex;align-items:center;gap:6px;margin-top:14px;padding:8px 16px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none">Daftar Kursus Pernikahan</a>
        </div>
    </div>
@endif
@endsection
