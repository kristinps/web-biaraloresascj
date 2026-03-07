@extends('user.layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola data akun dan foto pasangan Anda')

@push('styles')
<style>
    /* Background seperti beranda: gambar + overlay */
    .profil-bg {
        margin: -28px; padding: 16px;
        min-height: auto; position: relative; overflow: hidden;
    }
    .profil-bg .profil-bg-image {
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background-image: url('https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop');
        background-size: cover; background-position: center; background-repeat: no-repeat;
    }
    .profil-bg .profil-bg-overlay {
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(30,38,133,0.88) 0%, rgba(61,86,245,0.75) 100%);
    }
    @media (max-width: 768px) {
        .profil-bg { margin: -20px -16px; padding: 12px 16px; }
    }

    .profil-page { max-width: 420px; margin: 0 auto; position: relative; z-index: 10; }
    .profil-page .card {
        background: #fff; border-radius: 0.75rem; overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: 1px solid #e5e7eb;
    }
    .profil-page .card-body { padding: 1rem 1.25rem; }

    .profil-title {
        font-family: Georgia, 'Times New Roman', serif; font-size: 1.25rem; font-weight: 700; color: #1e293b;
        margin: 0 0 0.25rem 0; padding-bottom: 0.5rem; border-bottom: 1px solid #e5e7eb;
    }

    .form-row {
        display: flex; flex-direction: column; gap: 0; margin-bottom: 0.75rem;
    }
    .form-group {
        margin-bottom: 0.75rem;
    }
    .form-group:last-of-type { margin-bottom: 0; }
    .form-group label {
        display: block; font-size: 0.75rem; font-weight: 600; color: #334155; margin-bottom: 0.375rem;
    }
    .form-group input[type="text"],
    .form-group input[type="email"] {
        width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem;
        font-size: 0.875rem; color: #1e293b; background: #fff; box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-group input::placeholder { color: #94a3b8; }
    .form-group input:focus {
        outline: none; border-color: #2230ce; box-shadow: 0 0 0 2px rgba(34,48,206,0.12);
    }
    .form-group .err { margin-top: 0.25rem; }

    .foto-bar {
        font-size: 0.6875rem; font-weight: 600; color: #475569;
        margin: 0.5rem 0 0.5rem; padding-bottom: 0.375rem; border-bottom: 1px solid #e2e8f0;
    }
    .foto-bar strong { color: #1e40af; }

    .foto-pasangan-wrap {
        padding: 0.75rem; border-radius: 0.5rem; background: #f0f4ff;
        border: 1px solid #bfd0ff; display: flex; align-items: flex-start; justify-content: center; gap: 0.75rem; flex-wrap: wrap;
    }
    .foto-pasangan-item { text-align: center; flex: 1; min-width: 80px; }
    .foto-pasangan-item .label {
        font-size: 0.625rem; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 0.375rem;
        color: #2230ce; text-transform: uppercase;
    }

    .upload-zone {
        display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;
        padding: 0.5rem; border: 2px dashed #bfd0ff; border-radius: 0.375rem; cursor: pointer; transition: all 0.2s;
        min-height: 72px; background: #fff;
    }
    .upload-zone:hover { border-color: #2230ce; background: #f0f4ff; }
    .upload-zone .icon-wrap {
        width: 2rem; height: 2rem; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        margin-bottom: 0.25rem; background: #dce6ff;
    }
    .upload-zone .icon-wrap svg { width: 1rem; height: 1rem; color: #2230ce; }
    .upload-zone .text { font-size: 0.6875rem; font-weight: 600; color: #2b3fe8; }
    .upload-zone .hint { font-size: 0.625rem; color: #6080ff; margin-top: 0.125rem; }
    .upload-zone input[type="file"] { position: absolute; width: 0; height: 0; opacity: 0; pointer-events: none; }

    .foto-preview-wrap { position: relative; display: inline-block; }
    .foto-preview-wrap img {
        width: 64px; height: 85px; object-fit: cover; display: block;
        border: 2px solid #bfd0ff; box-shadow: 0 2px 8px rgba(34,48,206,0.1); border-radius: 0.375rem;
    }
    .foto-preview-wrap::after {
        content: ''; position: absolute; inset: -3px; border: 1px solid rgba(240,193,75,0.5);
        border-radius: 0.5rem; pointer-events: none;
    }
    .foto-preview-wrap .size-badge {
        position: absolute; top: -6px; right: -6px; background: #f0c14b; color: #1e2685;
        font-size: 0.5rem; font-weight: 700; padding: 2px 5px; border-radius: 0.25rem; z-index: 3;
    }
    .foto-preview-wrap .change-link {
        position: absolute; width: 100%; height: 100%; top: 0; left: 0; cursor: pointer; z-index: 2;
    }
    .foto-preview-wrap .change-link:hover ~ img { box-shadow: 0 0 0 2px #2230ce; }
    .foto-preview-wrap img { position: relative; z-index: 1; }

    .btn-row { margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; }
    .profil-page .btn-primary {
        display: inline-flex; align-items: center; padding: 0.4rem 0.75rem;
        background: #2230ce; color: #fff; border: none; border-radius: 0.375rem;
        font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: background 0.2s;
    }
    .profil-page .btn-primary:hover { background: #2129a7; }
    .profil-page .btn-secondary { font-size: 0.75rem; font-weight: 600; color: #2b3fe8; text-decoration: none; }
    .profil-page .btn-secondary:hover { color: #1e2685; text-decoration: underline; }
    .err { font-size: 0.75rem; color: #dc2626; margin-top: 0.25rem; display: block; }
</style>
@endpush

@section('content')
<div class="profil-bg">
    <div class="profil-bg-image" aria-hidden="true"></div>
    <div class="profil-bg-overlay" aria-hidden="true"></div>
    <div class="profil-page">
    <div class="card">
        <div class="card-body">
            <h2 class="profil-title">Profil Saya</h2>
            <form method="POST" action="{{ route('user.profil.update') }}" enctype="multipart/form-data" id="form-profil">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus placeholder="Masukkan nama lengkap Anda">
                        @error('name') <span class="err">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="contoh@email.com">
                        @error('email') <span class="err">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="foto-bar"><strong>Pas Foto</strong> — Pria & Wanita</div>
                <div class="foto-pasangan-wrap">
                    <div class="foto-pasangan-item">
                        <p class="label">Calon Mempelai Pria</p>
                        @if(!empty($fotoPriaUrl))
                            <div class="foto-preview-wrap pria" id="wrap_foto_pria">
                                <label class="change-link" for="foto_pria" title="Klik untuk ganti foto" aria-label="Ganti foto"></label>
                                <img src="{{ $fotoPriaUrl }}" alt="Foto calon mempelai pria" id="preview_foto_pria">
                                <span class="size-badge">3×4</span>
                            </div>
                            <input type="file" id="foto_pria" name="foto_pria" accept="image/jpeg,image/jpg,image/png" style="display:none">
                        @else
                            <label for="foto_pria" class="upload-zone" id="label_foto_pria">
                                <input type="file" id="foto_pria" name="foto_pria" accept="image/jpeg,image/jpg,image/png">
                                <div class="icon-wrap"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                                <span class="text">Pilih foto</span>
                                <span class="hint">3×4 cm</span>
                            </label>
                            <div class="foto-preview-wrap pria" id="wrap_foto_pria" style="display:none">
                                <label class="change-link" for="foto_pria" title="Klik untuk ganti foto" aria-label="Ganti foto"></label>
                                <img src="" alt="Preview foto calon mempelai pria" id="preview_foto_pria" style="width:64px;height:85px;object-fit:cover;border-radius:0.375rem;border:2px solid #bfd0ff">
                                <span class="size-badge">3×4</span>
                            </div>
                        @endif
                        @error('foto_pria') <span class="err">{{ $message }}</span> @enderror
                    </div>
                    <div class="foto-pasangan-item">
                        <p class="label">Calon Mempelai Wanita</p>
                        @if(!empty($fotoWanitaUrl))
                            <div class="foto-preview-wrap wanita" id="wrap_foto_wanita">
                                <label class="change-link" for="foto_wanita" title="Klik untuk ganti foto" aria-label="Ganti foto"></label>
                                <img src="{{ $fotoWanitaUrl }}" alt="Foto calon mempelai wanita" id="preview_foto_wanita">
                                <span class="size-badge">3×4</span>
                            </div>
                            <input type="file" id="foto_wanita" name="foto_wanita" accept="image/jpeg,image/jpg,image/png" style="display:none">
                        @else
                            <label for="foto_wanita" class="upload-zone" id="label_foto_wanita">
                                <input type="file" id="foto_wanita" name="foto_wanita" accept="image/jpeg,image/jpg,image/png">
                                <div class="icon-wrap"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                                <span class="text">Pilih foto</span>
                                <span class="hint">3×4 cm</span>
                            </label>
                            <div class="foto-preview-wrap wanita" id="wrap_foto_wanita" style="display:none">
                                <label class="change-link" for="foto_wanita" title="Klik untuk ganti foto" aria-label="Ganti foto"></label>
                                <img src="" alt="Preview foto calon mempelai wanita" id="preview_foto_wanita" style="width:64px;height:85px;object-fit:cover;border-radius:0.375rem;border:2px solid #bfd0ff">
                                <span class="size-badge">3×4</span>
                            </div>
                        @endif
                        @error('foto_wanita') <span class="err">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('user.password') }}" class="btn-secondary">Ubah kata sandi</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script>
(function() {
    var form = document.getElementById('form-profil');
    if (!form) return;

    function setupPhoto(inputId, labelId, wrapId, previewId) {
        var input = document.getElementById(inputId);
        var label = document.getElementById(labelId);
        var wrap = document.getElementById(wrapId);
        var preview = document.getElementById(previewId);
        if (!input || !preview) return;

        input.addEventListener('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    if (label) label.style.display = 'none';
                    if (wrap) wrap.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    setupPhoto('foto_pria', 'label_foto_pria', 'wrap_foto_pria', 'preview_foto_pria');
    setupPhoto('foto_wanita', 'label_foto_wanita', 'wrap_foto_wanita', 'preview_foto_wanita');
})();
</script>
@endpush
@endsection
