@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Tambah Biaya Tambahan')
@section('page-title', 'Tambah Biaya Tambahan')
@section('page-subtitle', 'Buat biaya tambahan untuk peserta pada periode tertentu')

@push('styles')
<style>
    .form-page {
        max-width: 720px;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        margin-bottom: 18px;
        transition: color .18s;
    }
    .back-link:hover { color: #4f46e5; }
    .back-link svg { width: 16px; height: 16px; }

    .card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 6px rgba(15,23,42,0.04);
        overflow: hidden;
    }
    .card-header {
        padding: 16px 22px;
        border-bottom: 1px solid #e2e8f0;
        background: linear-gradient(135deg,#eef2ff,#e0f2fe);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-header-icon {
        width: 32px;
        height: 32px;
        border-radius: 999px;
        background: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }
    .card-header-icon svg { width: 18px; height: 18px; }
    .card-header h2 {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }
    .card-header p {
        font-size: 12px;
        color: #6b7280;
        margin: 0;
    }
    .card-body {
        padding: 18px 22px 20px;
    }

    .form-group { margin-bottom: 14px; }
    .form-label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 5px;
    }
    .form-input, .form-select, .form-textarea {
        width: 100%;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        padding: 9px 12px;
        font-size: 13.5px;
        color: #111827;
        outline: none;
        transition: border-color .18s, box-shadow .18s;
        font-family: inherit;
        background-color: #fff;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
    }
    .form-textarea {
        min-height: 80px;
        resize: vertical;
    }
    .form-hint {
        font-size: 11.5px;
        color: #9ca3af;
        margin-top: 2px;
    }
    .error-text {
        font-size: 11.5px;
        color: #dc2626;
        margin-top: 4px;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 18px;
        border-radius: 999px;
        border: none;
        background: linear-gradient(135deg,#22c55e,#16a34a);
        color: #fff;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(34,197,94,0.3);
        transition: opacity .18s, transform .12s, box-shadow .18s;
    }
    .btn-submit:hover { opacity: .94; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(34,197,94,0.38); }
    .btn-submit svg { width: 16px; height: 16px; }
</style>
@endpush

@section('content')
@php
    $routePrefix = $routePrefix ?? (request()->routeIs('dashboard.*') ? 'dashboard' : 'admin');
@endphp

<div class="form-page">
    <a href="{{ route($routePrefix . '.biaya.index') }}" class="back-link">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0 7.5-7.5M3 12h18"/>
        </svg>
        Kembali ke Halaman Biaya
    </a>

    <div class="card">
        <div class="card-header">
            <div class="card-header-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 12v-2m0 2c-1.11 0-2.08-.402-2.599-1M21 12A9 9 0 113 12a9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h2>Tambah Biaya Tambahan</h2>
                <p>Biaya ini akan dibuat untuk semua peserta yang terdaftar pada periode yang dipilih.</p>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route($routePrefix . '.biaya.store') }}">
                @csrf

                <div class="form-group">
                    <label for="nama" class="form-label">Nama Biaya</label>
                    <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama') }}" required>
                    <div class="form-hint">Contoh: Biaya tambahan akomodasi, Biaya modul cetak, dll.</div>
                    @error('nama')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nominal" class="form-label">Jumlah Biaya (Rp)</label>
                    <input type="number" id="nominal" name="nominal" class="form-input" value="{{ old('nominal') }}" min="1000" step="500" required>
                    <div class="form-hint">Masukkan angka tanpa titik. Contoh: 150000.</div>
                    @error('nominal')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="periode_id" class="form-label">Periode</label>
                    <select id="periode_id" name="periode_id" class="form-select" required>
                        <option value="">Pilih periode...</option>
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->id }}" @selected(old('periode_id') == $periode->id)>
                                {{ $periode->nama }} (mulai {{ $periode->tanggal_mulai?->format('d M Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('periode_id')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                    <textarea id="keterangan" name="keterangan" class="form-textarea" rows="3" placeholder="Tambahan informasi yang akan tampil di dashboard peserta...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top:16px;display:flex;justify-content:flex-end;">
                    <button type="submit" class="btn-submit">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Simpan & Kirim Notifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

