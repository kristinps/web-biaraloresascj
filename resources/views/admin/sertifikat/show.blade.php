@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Detail Sertifikat Kelulusan')
@section('page-title', 'Detail Sertifikat Kelulusan')
@section('page-subtitle', 'Informasi lengkap sertifikat kelulusan peserta')

@push('styles')
<style>
    .card {
        background:#fff;
        border-radius:16px;
        border:1px solid #e2e8f0;
        box-shadow:0 1px 4px rgba(0,0,0,0.04);
        padding:22px 24px;
        max-width:880px;
    }
    .meta-grid {
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:16px 24px;
        margin-bottom:20px;
    }
    .meta-label {
        font-size:12.5px;
        text-transform:uppercase;
        letter-spacing:0.06em;
        color:#94a3b8;
        margin-bottom:3px;
    }
    .meta-value {
        font-size:14px;
        color:#111827;
        font-weight:600;
    }
    .meta-sub {
        font-size:12.5px;
        color:#6b7280;
        margin-top:2px;
    }
    .badge-periode {
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:4px 10px;
        border-radius:999px;
        font-size:12px;
        font-weight:600;
        background:#f0f9ff;
        color:#0369a1;
    }
    .badge-dot { width:6px;height:6px;border-radius:999px;background:#0ea5e9; }

    .preview-box {
        margin-top:18px;
        border-radius:14px;
        border:1px dashed #cbd5e1;
        padding:16px 18px;
        background:#f8fafc;
    }
    .preview-actions {
        display:flex;
        flex-wrap:wrap;
        gap:10px;
        margin-top:10px;
    }
    .btn-primary,
    .btn-secondary {
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:8px 16px;
        border-radius:10px;
        font-size:13px;
        font-weight:600;
        text-decoration:none;
        border:none;
        cursor:pointer;
    }
    .btn-secondary {
        background:#f1f5f9;
        color:#475569;
    }
    .btn-secondary:hover { background:#e2e8f0; }
    .btn-primary {
        background:linear-gradient(135deg,#22c55e,#16a34a);
        color:#fff;
        box-shadow:0 4px 10px rgba(34,197,94,0.35);
    }
    .btn-primary:hover { opacity:0.95; }
    .btn-primary svg,
    .btn-secondary svg { width:16px;height:16px; }
</style>
@endpush

@section('content')

<div class="card">
    <div class="meta-grid">
        <div>
            <div class="meta-label">Nama Peserta</div>
            <div class="meta-value">
                {{ $surat->pendaftaran?->namaLengkap() ?? '-' }}
            </div>
            @if($surat->pendaftaran)
                <div class="meta-sub">{{ $surat->pendaftaran->email }}</div>
            @endif
        </div>
        <div>
            <div class="meta-label">Periode</div>
            <div class="meta-value">
                @if($surat->pendaftaran && $surat->pendaftaran->periode)
                    <span class="badge-periode">
                        <span class="badge-dot"></span>
                        {{ $surat->pendaftaran->periode->nama }}
                    </span>
                @else
                    -
                @endif
            </div>
        </div>
        <div>
            <div class="meta-label">Nama Sertifikat</div>
            <div class="meta-value">{{ $surat->nama_surat ?: 'Sertifikat Kelulusan' }}</div>
        </div>
        <div>
            <div class="meta-label">Dibuat Pada</div>
            <div class="meta-value">{{ $surat->created_at?->format('d M Y H:i') }}</div>
        </div>
    </div>

    <div class="preview-box">
        <div class="meta-label" style="margin-bottom:6px">File Sertifikat</div>
        <div class="meta-sub">File disimpan di storage publik dan dapat diunduh oleh peserta melalui dashboard mereka.</div>

        <div class="preview-actions">
            <a href="{{ route('dashboard.user') }}" target="_blank" class="btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4-4 4m0 0-4-4m4 4V4"/>
                </svg>
                Download Sertifikat
            </a>
            <a href="{{ route($routePrefix . '.sertifikat.edit', $surat) }}" class="btn-secondary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
                </svg>
                Edit Sertifikat
            </a>
            <a href="{{ route($routePrefix . '.sertifikat.index') }}" class="btn-secondary">
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>

@endsection

