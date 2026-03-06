@extends('admin.layouts.app')

@section('title', 'Buat Periode Baru')
@section('page-title', 'Buat Periode Baru')
@section('page-subtitle', 'Tambahkan periode/batch kursus persiapan pernikahan baru')

@push('styles')
<style>
    .form-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        padding: 32px;
        max-width: 560px;
    }
    .form-group { margin-bottom: 22px; }
    .form-group label {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 7px;
    }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        color: #1e293b;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
        background: #fff;
    }
    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    }
    textarea.form-control { resize: vertical; min-height: 90px; }
    .form-hint { font-size: 12px; color: #94a3b8; margin-top: 5px; }
    .is-invalid { border-color: #ef4444 !important; }
    .invalid-feedback { color: #ef4444; font-size: 12px; margin-top: 4px; }

    .form-actions {
        display: flex; gap: 10px; align-items: center; margin-top: 28px;
    }
    .btn-primary {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 22px;
        background: linear-gradient(135deg,#6366f1,#8b5cf6);
        color: #fff; border-radius: 10px;
        font-size: 14px; font-weight: 600;
        border: none; cursor: pointer;
        box-shadow: 0 4px 12px rgba(99,102,241,0.3);
        transition: opacity 0.2s;
    }
    .btn-primary:hover { opacity: 0.88; }
    .btn-secondary {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 18px;
        background: #f1f5f9; color: #475569;
        border-radius: 10px; font-size: 14px; font-weight: 600;
        text-decoration: none; transition: background 0.15s;
    }
    .btn-secondary:hover { background: #e2e8f0; }
</style>
@endpush

@section('content')
<div class="form-card">
    <form action="{{ route('admin.periode.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nama">Nama Periode <span style="color:#ef4444">*</span></label>
            <input type="text" id="nama" name="nama"
                   class="form-control @error('nama') is-invalid @enderror"
                   value="{{ old('nama') }}"
                   placeholder="cth: Periode I 2026 / Batch Januari–Maret 2026">
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tanggal_mulai">Tanggal Mulai <span style="color:#ef4444">*</span></label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                   class="form-control @error('tanggal_mulai') is-invalid @enderror"
                   value="{{ old('tanggal_mulai', date('Y-m-d')) }}">
            @error('tanggal_mulai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="catatan">Catatan (opsional)</label>
            <textarea id="catatan" name="catatan"
                      class="form-control @error('catatan') is-invalid @enderror"
                      placeholder="Informasi tambahan tentang periode ini...">{{ old('catatan') }}</textarea>
            @error('catatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Buat Periode
            </button>
            <a href="{{ route('admin.periode.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
