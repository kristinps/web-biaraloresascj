@extends('admin.layouts.app')

@section('title', 'Edit Periode')
@section('page-title', 'Edit Periode')
@section('page-subtitle', 'Ubah informasi periode kursus pernikahan')

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
        display: block; font-size: 13.5px; font-weight: 600;
        color: #374151; margin-bottom: 7px;
    }
    .form-control {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid #e2e8f0; border-radius: 10px;
        font-size: 14px; color: #1e293b; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit; background: #fff;
    }
    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    }
    textarea.form-control { resize: vertical; min-height: 90px; }
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
    <form action="{{ route('admin.periode.update', $periode) }}" method="POST">
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
            <label for="tanggal_mulai">Tanggal Mulai <span style="color:#ef4444">*</span></label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                   class="form-control @error('tanggal_mulai') is-invalid @enderror"
                   value="{{ old('tanggal_mulai', $periode->tanggal_mulai->format('Y-m-d')) }}">
            @error('tanggal_mulai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="catatan">Catatan (opsional)</label>
            <textarea id="catatan" name="catatan"
                      class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan', $periode->catatan) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                </svg>
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.periode.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
