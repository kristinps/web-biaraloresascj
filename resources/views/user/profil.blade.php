@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'layouts.dashboard')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola data akun dan foto pasangan Anda')

@push('styles')
<style>
    /* Background mengikuti tema dashboard */
    .profil-bg {
        margin: -28px;
        padding: 20px 28px 28px;
        position: relative;
        overflow: hidden;
        min-height: auto;
    }
    .profil-bg .profil-bg-image {
        position: absolute; inset: 0;
        background-image: url('https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop');
        background-size: cover; background-position: center;
    }
    .profil-bg .profil-bg-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(30,38,133,0.88) 0%, rgba(61,86,245,0.78) 100%);
    }
    @media (max-width: 768px) {
        .profil-bg { margin: -20px -16px; padding: 16px; }
    }

    .profil-page {
        position: relative;
        z-index: 10;
        max-width: 760px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .profil-card {
        background: #ffffff;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 15px -5px rgba(15,23,42,0.25);
        overflow: hidden;
    }
    .profil-card-header {
        padding: 16px 20px 10px;
        border-bottom: 1px solid #e5e7eb;
    }
    .profil-card-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }
    .profil-card-subtitle {
        font-size: 0.8rem;
        color: #64748b;
    }
    .profil-card-body {
        padding: 16px 20px 20px;
    }

    /* Kartu profil pasangan: dua lingkaran + ikon hati di tengah */
    .couple-photos-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 26px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }
    .couple-photo-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        min-width: 120px;
    }
    .couple-photo-label {
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #2230ce;
    }
    .avatar-circle {
        width: 110px;
        height: 110px;
        border-radius: 999px;
        overflow: hidden;
        position: relative;
        border: 3px solid #e2e8f0;
        box-shadow: 0 4px 14px rgba(15,23,42,0.25);
        background: radial-gradient(circle at 30% 20%, #fef3c7, #2563eb);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .avatar-initial {
        font-size: 2.2rem;
        font-weight: 800;
        color: #ffffff;
    }
    .avatar-circle.male {
        background: radial-gradient(circle at 30% 20%, #dbeafe, #1d4ed8);
    }
    .avatar-circle.female {
        background: radial-gradient(circle at 30% 20%, #fee2e2, #db2777);
    }

    .heart-between {
        width: 54px;
        height: 54px;
        border-radius: 999px;
        background: linear-gradient(135deg, #f97316, #ec4899);
        box-shadow: 0 4px 16px rgba(251,113,133,0.55);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .heart-between svg {
        width: 26px;
        height: 26px;
        color: #fefce8;
    }

    .couple-names-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0,1fr));
        gap: 12px;
        margin-bottom: 10px;
    }
    @media (max-width: 640px) {
        .couple-names-row {
            grid-template-columns: minmax(0,1fr);
        }
    }
    .name-block {
        text-align: center;
        padding: 6px 8px;
        background: #f8fafc;
        border-radius: 0.75rem;
        border: 1px solid #e2e8f0;
    }
    .name-block-title {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 2px;
    }
    .name-block-main {
        font-size: 0.86rem;
        font-weight: 600;
        color: #0f172a;
    }
    .name-block-sub {
        font-size: 0.72rem;
        color: #6b7280;
        margin-top: 1px;
    }

    .profil-form-grid {
        display: grid;
        grid-template-columns: minmax(0,1.4fr) minmax(0,1.2fr);
        gap: 14px;
        margin-top: 10px;
    }
    @media (max-width: 768px) {
        .profil-form-grid { grid-template-columns: minmax(0,1fr); }
    }

    .form-group {
        margin-bottom: 10px;
    }
    .form-group:last-of-type { margin-bottom: 0; }
    .form-label {
        display: block;
        font-size: 0.78rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 4px;
    }
    .form-label span.muted {
        font-size: 0.7rem;
        font-weight: 500;
        color: #94a3b8;
        margin-left: 4px;
    }
    .form-control {
        width: 100%;
        padding: 8px 10px;
        border-radius: 0.5rem;
        border: 1px solid #cbd5e1;
        font-size: 0.85rem;
        color: #0f172a;
        background: #ffffff;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: #2230ce;
        box-shadow: 0 0 0 2px rgba(34,48,206,0.13);
        background: #f9fafb;
    }
    .form-control[readonly],
    .form-control[disabled] {
        background: #f1f5f9;
        color: #64748b;
        cursor: not-allowed;
    }
    .err {
        font-size: 0.75rem;
        color: #dc2626;
        margin-top: 3px;
        display: block;
    }
    .form-hint {
        font-size: 0.72rem;
        color: #94a3b8;
        margin-top: 2px;
    }

    .profil-actions {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: flex-end;
    }
    .btn-primary-small {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        font-size: 0.82rem;
        font-weight: 600;
        border-radius: 999px;
        border: none;
        cursor: pointer;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        box-shadow: 0 3px 8px rgba(79,70,229,0.35);
        transition: opacity 0.2s, transform 0.1s;
    }
    .btn-primary-small:hover {
        opacity: 0.94;
        transform: translateY(-1px);
    }

    /* Kartu ubah password di halaman profil */
    .password-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0,1fr));
        gap: 10px;
    }
    @media (max-width: 640px) {
        .password-grid {
            grid-template-columns: minmax(0,1fr);
        }
    }
    .password-grid .form-group {
        margin-bottom: 0;
    }
    .password-actions {
        margin-top: 14px;
        display: flex;
        justify-content: flex-end;
    }
    .btn-primary-password {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 18px;
        font-size: 0.84rem;
        font-weight: 600;
        border-radius: 0.75rem;
        border: none;
        cursor: pointer;
        background: linear-gradient(135deg, #0ea5e9, #6366f1);
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(14,165,233,0.35);
        transition: opacity 0.2s, transform 0.1s;
    }
    .btn-primary-password:hover {
        opacity: 0.95;
        transform: translateY(-1px);
    }
</style>
@endpush

@section('content')
<div class="profil-bg">
    <div class="profil-bg-image" aria-hidden="true"></div>
    <div class="profil-bg-overlay" aria-hidden="true"></div>

    <div class="profil-page">
        {{-- KARTU 1: PROFIL + DUA LINGKARAN FOTO --}}
        <div class="profil-card">
            <div class="profil-card-header">
                <div class="profil-card-title">Kartu Profil</div>
                <div class="profil-card-subtitle">
                    Foto pasangan, nama akun, dan email terdaftar.
                </div>
            </div>
            <div class="profil-card-body">
                {{-- Dua lingkaran foto: pria & wanita, dengan ikon hati di tengah --}}
                <div class="couple-photos-row">
                    <div class="couple-photo-item">
                        <div class="couple-photo-label">Calon Mempelai Pria</div>
                        <div class="avatar-circle male">
                            @if(!empty($fotoPriaUrl))
                                <img src="{{ $fotoPriaUrl }}" alt="Foto calon mempelai pria">
                            @else
                                <span class="avatar-initial">P</span>
                            @endif
                        </div>
                    </div>

                    <div class="heart-between" aria-hidden="true">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 3 12.904 3 10.125 3 7.5 4.714 5.25 7.125 5.25 8.8 5.25 10.07 6.21 10.91 7.27c.84-1.06 2.11-2.02 3.785-2.02 2.412 0 4.125 2.25 4.125 4.875 0 2.779-1.688 5.235-3.989 7.382a25.18 25.18 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.003-.003.002a.75.75 0 01-.704 0l-.003-.002z"/>
                        </svg>
                    </div>

                    <div class="couple-photo-item">
                        <div class="couple-photo-label">Calon Mempelai Wanita</div>
                        <div class="avatar-circle female">
                            @if(!empty($fotoWanitaUrl))
                                <img src="{{ $fotoWanitaUrl }}" alt="Foto calon mempelai wanita">
                            @else
                                <span class="avatar-initial">W</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Nama & data lain di bawah masing-masing foto (placeholder, diisi dari data pendaftaran bila tersedia) --}}
                <div class="couple-names-row">
                    <div class="name-block">
                        <div class="name-block-title">Calon Mempelai Pria</div>
                        <div class="name-block-main">
                            {{ $pendaftaranPriaNama ?? '—' }}
                        </div>
                        <div class="name-block-sub">
                            {{ $pendaftaranPriaInfo ?? 'Data pendaftaran pria' }}
                        </div>
                    </div>
                    <div class="name-block">
                        <div class="name-block-title">Calon Mempelai Wanita</div>
                        <div class="name-block-main">
                            {{ $pendaftaranWanitaNama ?? '—' }}
                        </div>
                        <div class="name-block-sub">
                            {{ $pendaftaranWanitaInfo ?? 'Data pendaftaran wanita' }}
                        </div>
                    </div>
                </div>

                {{-- Form nama & email akun --}}
                <form method="POST" action="{{ route($userRoutePrefix . '.profil.update') }}">
                    @csrf
                    <div class="profil-form-grid">
                        <div>
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Akun (peserta)</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control"
                                    value="{{ old('name', $user->name) }}"
                                    placeholder="Masukkan nama lengkap Anda"
                                    required
                                    autofocus
                                >
                                @error('name')
                                    <span class="err">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label class="form-label">
                                    Email Terdaftar
                                    <span class="muted">(tidak dapat diubah)</span>
                                </label>
                                <input
                                    type="email"
                                    class="form-control"
                                    value="{{ $user->email }}"
                                    readonly
                                    disabled
                                >
                                <p class="form-hint">Email ini dipakai untuk login dan notifikasi.</p>
                            </div>
                        </div>
                    </div>

                    <div class="profil-actions">
                        <button type="submit" class="btn-primary-small">
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- KARTU 2: UBAH PASSWORD DI HALAMAN PROFIL --}}
        <div class="profil-card">
            <div class="profil-card-header">
                <div class="profil-card-title">Ubah Password</div>
                <div class="profil-card-subtitle">
                    Ganti password akun Anda dengan aman.
                </div>
            </div>
            <div class="profil-card-body">
                <form method="POST" action="{{ route($userRoutePrefix . '.password.update') }}">
                    @csrf
                    <div class="password-grid">
                        <div class="form-group">
                            <label for="password_current" class="form-label">Password lama</label>
                            <input
                                type="password"
                                id="password_current"
                                name="password_current"
                                class="form-control"
                                autocomplete="current-password"
                                required
                            >
                            @error('password_current')
                                <span class="err">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password baru</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                autocomplete="new-password"
                                required
                            >
                            @error('password')
                                <span class="err">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Konfirmasi password baru</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                autocomplete="new-password"
                                required
                            >
                        </div>
                    </div>
                    <div class="password-actions">
                        <button type="submit" class="btn-primary-password">
                            Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
