@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Edit Periode')
@section('page-title', 'Edit Periode')
@section('page-subtitle', 'Ubah informasi periode kursus pernikahan')

@push('styles')
<style>
    .periode-edit-page .form-card {
        background: linear-gradient(135deg,
            rgba(99,102,241,0.14),
            rgba(139,92,246,0.10),
            rgba(56,189,248,0.08)
        );
        border-radius: 16px;
        border: 1px solid rgba(148,163,184,0.5);
        box-shadow: 0 8px 24px rgba(15,23,42,0.08);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 32px;
        max-width: 560px;
    }
    .periode-edit-page .form-group { margin-bottom: 22px; }
    .periode-edit-page .form-group label {
        display: block; font-size: 13.5px; font-weight: 600;
        color: #ffffff; margin-bottom: 7px;
    }
    .periode-edit-page .form-control {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid rgba(148,163,184,0.5); border-radius: 10px;
        font-size: 14px; color: #ffffff; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit; background: rgba(255,255,255,0.15);
    }
    .periode-edit-page .form-control::placeholder { color: rgba(255,255,255,0.6); }
    .periode-edit-page .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.25);
    }
    .periode-edit-page textarea.form-control { resize: vertical; min-height: 90px; }
    .periode-edit-page .is-invalid { border-color: #ef4444 !important; }
    .periode-edit-page .invalid-feedback { color: #fecaca; font-size: 12px; margin-top: 4px; }
    .periode-edit-page .form-actions {
        display: flex; gap: 10px; align-items: center; margin-top: 28px;
    }
    .periode-edit-page .btn-primary {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 22px;
        background: linear-gradient(135deg,#6366f1,#8b5cf6);
        color: #fff; border-radius: 10px;
        font-size: 14px; font-weight: 600;
        border: none; cursor: pointer;
        box-shadow: 0 4px 12px rgba(99,102,241,0.3);
        transition: opacity 0.2s;
    }
    .periode-edit-page .btn-primary:hover { opacity: 0.88; }
    .periode-edit-page .btn-secondary {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 18px;
        background: rgba(255,255,255,0.2); color: #ffffff;
        border-radius: 10px; font-size: 14px; font-weight: 600;
        text-decoration: none; transition: background 0.15s;
    }
    .periode-edit-page .btn-secondary:hover { background: rgba(99,102,241,0.4); color: #fff; }
</style>
@endpush

@section('content')
<div class="periode-edit-page">
<div class="form-card">
    <form action="{{ route($routePrefix . '.periode.update', $periode) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-group">
            <label for="nama">Nama Periode <span style="color:#ef4444">*</span></label>
            <input type="text" id="nama" name="nama"
                   class="form-control @error('nama') is-invalid @enderror"
                   value="{{ old('nama', $periode->nama) }}">
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tanggal_mulai">Waktu Mulai Periode <span style="color:#ef4444">*</span></label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                   class="form-control @error('tanggal_mulai') is-invalid @enderror"
                   value="{{ old('tanggal_mulai', $periode->tanggal_mulai->format('Y-m-d')) }}">
            @error('tanggal_mulai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tanggal_selesai">Waktu Akhir Periode</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                   class="form-control @error('tanggal_selesai') is-invalid @enderror"
                   value="{{ old('tanggal_selesai', $periode->tanggal_selesai?->format('Y-m-d')) }}">
            @error('tanggal_selesai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="catatan">Keterangan Periode</label>
            <textarea id="catatan" name="catatan"
                      class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan', $periode->catatan) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                </svg>
                Simpan
            </button>
            <a href="{{ route($routePrefix . '.periode.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
</div>
@endsection
