@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Edit Sertifikat Kelulusan')
@section('page-title', 'Edit Sertifikat Kelulusan')
@section('page-subtitle', 'Perbarui nama atau file sertifikat kelulusan peserta')

@push('styles')
<style>
    .card {
        background:#fff;
        border-radius:16px;
        border:1px solid #e2e8f0;
        box-shadow:0 1px 4px rgba(0,0,0,0.04);
        padding:22px 24px;
        max-width:780px;
    }
    .meta-sub {
        font-size:13px;
        color:#6b7280;
        margin-bottom:16px;
    }
    .form-group {
        margin-bottom:16px;
    }
    .form-label {
        font-size:13px;
        font-weight:600;
        color:#374151;
        margin-bottom:4px;
        display:block;
    }
    .form-control {
        width:100%;
        border-radius:10px;
        border:1.5px solid #e2e8f0;
        padding:9px 11px;
        font-size:13.5px;
        color:#1e293b;
        outline:none;
        transition:border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        border-color:#6366f1;
        box-shadow:0 0 0 1px rgba(99,102,241,0.15);
    }
    .form-hint {
        font-size:12px;
        color:#94a3b8;
        margin-top:4px;
    }
    .error-text {
        font-size:12px;
        color:#dc2626;
        margin-top:4px;
    }
    .actions {
        margin-top:22px;
        display:flex;
        justify-content:flex-end;
        gap:10px;
    }
    .btn-secondary,
    .btn-primary {
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:9px 18px;
        border-radius:10px;
        font-size:13px;
        font-weight:600;
        border:none;
        cursor:pointer;
        text-decoration:none;
    }
    .btn-secondary {
        background:#f1f5f9;
        color:#475569;
    }
    .btn-secondary:hover { background:#e2e8f0; }
    .btn-primary {
        background:linear-gradient(135deg,#22c55e,#16a34a);
        color:#fff;
        box-shadow:0 4px 12px rgba(34,197,94,0.3);
    }
    .btn-primary:hover { opacity:0.95; }
    .btn-primary svg { width:16px;height:16px; }
</style>
@endpush

@section('content')

<div class="card">
    <div class="meta-sub">
        Peserta: <strong>{{ $surat->pendaftaran?->namaLengkap() ?? '-' }}</strong>
        @if($surat->pendaftaran)
            ({{ $surat->pendaftaran->email }})
        @endif
    </div>

    <form action="{{ route($routePrefix . '.sertifikat.update', $surat) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Nama Sertifikat</label>
            <input type="text" name="nama_surat" class="form-control" value="{{ old('nama_surat', $surat->nama_surat) }}" placeholder="Sertifikat Kelulusan Kursus Pernikahan">
            @error('nama_surat')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">File Sertifikat (opsional)</label>
            <input type="file" name="file" class="form-control">
            <div class="form-hint">Kosongkan jika tidak ingin mengganti file sertifikat. Maks. 5 MB, format PDF atau gambar.</div>
            @error('file')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="actions">
            <a href="{{ route($routePrefix . '.sertifikat.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection

