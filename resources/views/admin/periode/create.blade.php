@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Buat Periode Baru')
@section('page-title', 'Buat Periode Baru')
@section('page-subtitle', 'Tambahkan periode/batch kursus persiapan pernikahan baru')

@push('styles')
<style>
    .card {
        background: linear-gradient(135deg,
            rgba(99,102,241,0.14),
            rgba(139,92,246,0.10),
            rgba(56,189,248,0.08)
        );
        border-radius: 16px;
        border: 1px solid rgba(148,163,184,0.5);
        box-shadow: 0 18px 45px rgba(15,23,42,0.14);
        overflow: hidden;
        margin-bottom: 8px;
        backdrop-filter: blur(14px);
    }
    .form-card {
        padding: 32px;
        max-width: 560px;
    }
    .form-group { margin-bottom: 22px; }
    .form-group label {
        display: block;
        font-size: 13.5px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 7px;
    }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        color: #ffffff;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background-color 0.2s;
        font-family: inherit;
        background: rgba(167, 185, 226, 0.45);
    }
    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.12);
    }
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.85);
    }
    .form-control::-webkit-input-placeholder { color: rgba(255, 255, 255, 0.85); }
    .form-control::-moz-placeholder { color: rgba(255, 255, 255, 0.85); }
    .form-control:-ms-input-placeholder { color: rgba(255, 255, 255, 0.85); }
    textarea.form-control { resize: vertical; min-height: 90px; }
    .form-hint { font-size: 12px; color: rgba(248,250,252,0.8); margin-top: 5px; }
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

    /* Desktop: hanya kotak (card) di tengah, isi & ukuran card tidak berubah */
    @media (min-width: 768px) {
        .dashboard-user-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 120px);
        }
        .dashboard-user-content .dashboard-user-header {
            margin-bottom: 24px;
            width: 100%;
            max-width: 560px;
        }
        .dashboard-user-content .card.form-card {
            width: 100%;
            max-width: 560px;
            margin-left: auto;
            margin-right: auto;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-user-content">
    <header class="dashboard-user-header">
        <h1 class="dashboard-user-title">Buat Periode Baru</h1>
    </header>

    <div class="card form-card">
        <form action="{{ route($routePrefix . '.periode.store') }}" method="POST">
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
                <label for="tanggal_mulai">Waktu Mulai Periode <span style="color:#ef4444">*</span></label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                       class="form-control @error('tanggal_mulai') is-invalid @enderror"
                       value="{{ old('tanggal_mulai', date('Y-m-d')) }}">
                @error('tanggal_mulai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_selesai">Waktu Akhir Periode</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                       class="form-control @error('tanggal_selesai') is-invalid @enderror"
                       value="{{ old('tanggal_selesai') }}">
                @error('tanggal_selesai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-hint">Opsional. Kosongkan jika periode belum berakhir.</div>
            </div>

            <div class="form-group">
                <label for="catatan">Keterangan Periode</label>
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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
                <a href="{{ route($routePrefix . '.periode.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
