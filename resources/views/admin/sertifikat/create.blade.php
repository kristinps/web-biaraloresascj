@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Tambah Sertifikat Kelulusan')
@section('page-title', 'Tambah Sertifikat Kelulusan')
@section('page-subtitle', 'Upload file sertifikat dan pilih peserta yang menerima')

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
    .form-grid {
        display:grid;
        grid-template-columns:1.2fr 2fr;
        gap:20px 24px;
    }
    .form-label {
        font-size:13px;
        font-weight:600;
        color:#374151;
        margin-bottom:4px;
        display:block;
    }
    .form-label span {
        color:#ef4444;
    }
    .form-control,
    .form-select {
        width:100%;
        border-radius:10px;
        border:1.5px solid #e2e8f0;
        padding:9px 11px;
        font-size:13.5px;
        color:#1e293b;
        outline:none;
        transition:border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus,
    .form-select:focus {
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
        margin-top:24px;
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
    <form action="{{ route($routePrefix . '.sertifikat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
            <div>
                <label class="form-label">Nama Sertifikat</label>
                <p class="form-hint">Opsional. Kosongkan bila ingin menggunakan nama otomatis berdasarkan nama peserta.</p>
            </div>
            <div>
                <input type="text" name="nama_surat" class="form-control" value="{{ old('nama_surat') }}" placeholder="Contoh: Sertifikat Kelulusan Kursus Pernikahan">
                @error('nama_surat')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label">Periode Pendaftaran</label>
                <p class="form-hint">Digunakan sebagai referensi ketika memilih peserta (tidak wajib dipilih).</p>
            </div>
            <div>
                <select class="form-select" id="periode-select">
                    <option value="">Pilih salah satu (opsional)</option>
                    @foreach($periodeList as $periode)
                        <option value="{{ $periode->id }}">{{ $periode->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label">Peserta Penerima <span>*</span></label>
                <p class="form-hint">Pilih peserta yang akan menerima sertifikat kelulusan.</p>
            </div>
            <div>
                <select name="pendaftaran_id" id="pendaftaran-select" class="form-select" required>
                    <option value="">Pilih peserta...</option>
                    @foreach($pendaftaranList as $p)
                        <option value="{{ $p->id }}" data-periode="{{ $p->periode_id }}" {{ old('pendaftaran_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->namaLengkap() }} — {{ $p->email }} @if($p->periode) ({{ $p->periode->nama }}) @endif
                        </option>
                    @endforeach
                </select>
                @error('pendaftaran_id')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label">File Sertifikat <span>*</span></label>
                <p class="form-hint">Upload file sertifikat (PDF atau gambar, maks. 5 MB).</p>
            </div>
            <div>
                <input type="file" name="file" class="form-control" required>
                @error('file')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="actions">
            <a href="{{ route($routePrefix . '.sertifikat.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Simpan & Kirim Email
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    (function() {
        const periodeSelect = document.getElementById('periode-select');
        const pesertaSelect = document.getElementById('pendaftaran-select');

        if (!periodeSelect || !pesertaSelect) return;

        periodeSelect.addEventListener('change', function () {
            const periodeId = this.value;
            Array.from(pesertaSelect.options).forEach(function (opt) {
                if (!opt.value) return;
                const pId = opt.getAttribute('data-periode');
                opt.hidden = periodeId && pId !== periodeId;
            });
        });
    })();
</script>
@endpush

@endsection

