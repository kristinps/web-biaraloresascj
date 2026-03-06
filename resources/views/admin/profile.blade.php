@extends('admin.layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun dan keamanan')

@push('styles')
<style>
    .profile-grid {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 900px) {
        .profile-grid { grid-template-columns: 1fr; }
    }

    /* ─── Card ─── */
    .card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .card-header {
        padding: 18px 24px 14px;
        border-bottom: 1px solid #f1f5f9;
    }
    .card-header h2 {
        font-size: 15px; font-weight: 700; color: #1e293b;
    }
    .card-header p {
        font-size: 12.5px; color: #94a3b8; margin-top: 3px;
    }
    .card-body { padding: 24px; }

    /* ─── Photo card ─── */
    .photo-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }
    .photo-circle {
        position: relative;
        width: 120px; height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .photo-circle img {
        width: 100%; height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
    .photo-initial {
        font-size: 42px; font-weight: 800; color: #fff;
        line-height: 1;
    }
    .photo-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.45);
        display: flex; align-items: center; justify-content: center;
        opacity: 0;
        transition: opacity 0.2s;
        cursor: pointer;
        border-radius: 50%;
    }
    .photo-circle:hover .photo-overlay { opacity: 1; }
    .photo-overlay svg { width: 28px; height: 28px; color: #fff; }

    .photo-name {
        font-size: 16px; font-weight: 700; color: #1e293b; text-align: center;
    }
    .photo-email {
        font-size: 13px; color: #64748b; text-align: center; margin-top: -8px;
    }
    .photo-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        color: #15803d; font-size: 11.5px; font-weight: 600;
        padding: 4px 10px; border-radius: 99px;
    }
    .photo-badge svg { width: 12px; height: 12px; }

    /* Upload area */
    .upload-zone {
        border: 2px dashed #c7d2fe;
        border-radius: 12px;
        padding: 18px 16px;
        text-align: center;
        background: #f8faff;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        width: 100%;
    }
    .upload-zone:hover { border-color: #6366f1; background: #eef2ff; }
    .upload-zone.dragover { border-color: #6366f1; background: #eef2ff; }
    .upload-zone svg { width: 28px; height: 28px; color: #6366f1; margin: 0 auto 8px; }
    .upload-zone .uz-title {
        font-size: 13.5px; font-weight: 600; color: #1e293b; margin-bottom: 2px;
    }
    .upload-zone .uz-sub {
        font-size: 12px; color: #94a3b8;
    }
    #photo-preview-wrap { display: none; margin-top: 12px; }
    #photo-preview-wrap img {
        width: 80px; height: 80px; border-radius: 50%;
        object-fit: cover; border: 2px solid #6366f1;
        display: block; margin: 0 auto 8px;
    }
    #photo-preview-name { font-size: 12px; color: #64748b; text-align: center; }

    .btn-delete-photo {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 12.5px; font-weight: 600; color: #dc2626;
        background: #fef2f2; border: 1px solid #fecaca;
        padding: 6px 14px; border-radius: 8px;
        cursor: pointer; transition: background 0.15s;
        width: 100%; justify-content: center;
        text-decoration: none;
    }
    .btn-delete-photo:hover { background: #fee2e2; }
    .btn-delete-photo svg { width: 13px; height: 13px; }

    /* ─── Form elements ─── */
    .form-group { margin-bottom: 20px; }
    .form-group:last-of-type { margin-bottom: 0; }
    label {
        display: block; font-size: 13px; font-weight: 600;
        color: #374151; margin-bottom: 7px;
    }
    .input-wrap { position: relative; }
    .input-wrap .input-icon {
        position: absolute; left: 13px; top: 50%;
        transform: translateY(-50%); color: #94a3b8;
        width: 17px; height: 17px; pointer-events: none;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%; background: #f8fafc;
        border: 1.5px solid #e2e8f0; border-radius: 10px;
        color: #1e293b; font-size: 14px;
        font-family: 'Inter', sans-serif;
        padding: 11px 13px 11px 42px;
        outline: none;
        transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    }
    input:focus {
        border-color: #6366f1; background: #fff;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }
    input.is-invalid {
        border-color: #f87171;
        box-shadow: 0 0 0 3px rgba(248,113,113,0.1);
    }
    input[readonly], input[disabled] {
        background: #f1f5f9; color: #94a3b8; cursor: not-allowed;
    }
    .field-error {
        font-size: 12px; color: #dc2626; margin-top: 5px;
        display: flex; align-items: center; gap: 5px;
    }
    .field-hint {
        font-size: 12px; color: #94a3b8; margin-top: 5px;
        display: flex; align-items: center; gap: 5px;
    }

    /* Eye toggle */
    .eye-btn {
        position: absolute; right: 13px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #94a3b8; padding: 4px; transition: color 0.2s;
    }
    .eye-btn:hover { color: #6366f1; }
    .eye-btn svg { width: 16px; height: 16px; }
    input.has-eye { padding-right: 42px; }

    /* Password strength */
    .strength-bar {
        display: grid; grid-template-columns: repeat(5,1fr); gap: 4px;
        margin-top: 8px;
    }
    .strength-bar span {
        height: 4px; border-radius: 2px; background: #e2e8f0;
        transition: background 0.25s;
    }
    .strength-label { font-size: 11.5px; color: #94a3b8; margin-top: 4px; }

    /* Buttons */
    .btn-primary {
        display: inline-flex; align-items: center; justify-content: center; gap: 7px;
        padding: 11px 24px; border: none; border-radius: 10px;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: #fff; font-size: 14px; font-weight: 700;
        font-family: 'Inter', sans-serif; cursor: pointer;
        box-shadow: 0 4px 14px rgba(99,102,241,0.35);
        transition: opacity 0.2s, transform 0.15s;
    }
    .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
    .btn-primary:active { transform: translateY(0); }
    .btn-primary svg { width: 15px; height: 15px; }

    .btn-secondary {
        display: inline-flex; align-items: center; justify-content: center; gap: 7px;
        padding: 11px 24px; border: 1.5px solid #e2e8f0; border-radius: 10px;
        background: #f8fafc; color: #475569;
        font-size: 14px; font-weight: 600;
        font-family: 'Inter', sans-serif; cursor: pointer;
        transition: background 0.15s, border-color 0.15s;
    }
    .btn-secondary:hover { background: #f1f5f9; border-color: #cbd5e1; }
    .btn-secondary svg { width: 15px; height: 15px; }

    /* Tabs */
    .tabs {
        display: flex; gap: 4px;
        border-bottom: 2px solid #f1f5f9;
        margin-bottom: 24px;
    }
    .tab-btn {
        display: flex; align-items: center; gap: 6px;
        padding: 10px 16px;
        font-size: 13.5px; font-weight: 600; color: #64748b;
        background: none; border: none; cursor: pointer;
        border-bottom: 2px solid transparent; margin-bottom: -2px;
        transition: color 0.2s, border-color 0.2s;
        border-radius: 8px 8px 0 0;
    }
    .tab-btn:hover { color: #6366f1; }
    .tab-btn.active { color: #6366f1; border-bottom-color: #6366f1; }
    .tab-btn svg { width: 15px; height: 15px; }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* Divider */
    .form-divider {
        border: none; border-top: 1px solid #f1f5f9;
        margin: 20px 0;
    }

    /* Section label */
    .section-label {
        font-size: 11px; font-weight: 700; letter-spacing: 1px;
        text-transform: uppercase; color: #94a3b8; margin-bottom: 16px;
    }

    @media (max-width: 640px) {
        .form-row { flex-direction: column; }
    }
</style>
@endpush

@section('content')

<div class="profile-grid">

    {{-- ─── LEFT: Foto Profil ─── --}}
    <div style="display:flex;flex-direction:column;gap:20px">

        {{-- Photo card --}}
        <div class="card">
            <div class="card-header">
                <h2>Foto Profil</h2>
                <p>Tampil di sidebar dan header panel</p>
            </div>
            <div class="card-body">
                <div class="photo-wrap">

                    {{-- Current photo --}}
                    <div class="photo-circle" id="photo-circle" onclick="document.getElementById('photo-input').click()">
                        @if($user->profile_photo)
                            <img src="{{ $user->profilePhotoUrl() }}" alt="{{ $user->name }}" id="current-photo">
                        @else
                            <span class="photo-initial" id="photo-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                        <div class="photo-overlay">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/>
                            </svg>
                        </div>
                    </div>

                    <div>
                        <div class="photo-name">{{ $user->name }}</div>
                        <div class="photo-email">{{ $user->email }}</div>
                    </div>

                    <span class="photo-badge">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd"/>
                        </svg>
                        Administrator
                    </span>
                </div>

                <hr class="form-divider">

                {{-- Upload form --}}
                <form method="POST" action="{{ route('admin.profile.photo') }}" enctype="multipart/form-data" id="photo-form">
                    @csrf

                    <div class="upload-zone" id="upload-zone"
                         onclick="document.getElementById('photo-input').click()"
                         ondragover="event.preventDefault();this.classList.add('dragover')"
                         ondragleave="this.classList.remove('dragover')"
                         ondrop="handleDrop(event)">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                        </svg>
                        <div class="uz-title">Klik atau seret foto ke sini</div>
                        <div class="uz-sub">JPG, PNG, WEBP — maks. 2 MB</div>
                    </div>

                    <input type="file" id="photo-input" name="photo" accept="image/jpeg,image/jpg,image/png,image/webp"
                           style="display:none" onchange="previewPhoto(this)">

                    <div id="photo-preview-wrap">
                        <img id="photo-preview-img" src="" alt="Preview">
                        <div id="photo-preview-name"></div>
                    </div>

                    @error('photo')
                        <div class="field-error" style="margin-top:8px">
                            <svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;flex-shrink:0">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror

                    <div style="margin-top:14px;display:flex;gap:10px;flex-wrap:wrap">
                        <button type="submit" class="btn-primary" style="flex:1" id="upload-btn" disabled>
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                            </svg>
                            Simpan Foto
                        </button>
                    </div>
                </form>

                @if($user->profile_photo)
                    <div style="margin-top:10px">
                        <form method="POST" action="{{ route('admin.profile.photo.delete') }}"
                              onsubmit="return confirm('Hapus foto profil?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-photo">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                                Hapus Foto
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>

    </div>

    {{-- ─── RIGHT: Info & Password ─── --}}
    <div class="card">
        <div class="card-header">
            <h2>Pengaturan Akun</h2>
            <p>Perbarui informasi profil dan keamanan akun</p>
        </div>
        <div class="card-body">

            {{-- Tabs --}}
            <div class="tabs">
                <button class="tab-btn {{ session('tab') === 'password' ? '' : 'active' }}"
                        onclick="switchTab('info', this)">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                    Informasi Akun
                </button>
                <button class="tab-btn {{ session('tab') === 'password' ? 'active' : '' }}"
                        onclick="switchTab('password', this)">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                    Ubah Kata Sandi
                </button>
            </div>

            {{-- Tab: Info --}}
            <div class="tab-panel {{ session('tab') === 'password' ? '' : 'active' }}" id="tab-info">

                <div class="section-label">Data Diri</div>

                <form method="POST" action="{{ route('admin.profile.info') }}" novalidate>
                    @csrf

                    {{-- Nama --}}
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <div class="input-wrap">
                            <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   placeholder="Nama lengkap Anda"
                                   autocomplete="name">
                        </div>
                        @error('name')
                            <div class="field-error">
                                <svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;flex-shrink:0">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Email (read-only) --}}
                    <div class="form-group">
                        <label for="email">
                            Alamat Email
                            <span style="font-size:11px;font-weight:500;color:#94a3b8;margin-left:6px">
                                (tidak dapat diubah)
                            </span>
                        </label>
                        <div class="input-wrap">
                            <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                            <input type="email" id="email" value="{{ $user->email }}"
                                   readonly style="padding-right:42px">
                            <span style="position:absolute;right:13px;top:50%;transform:translateY(-50%)">
                                <svg fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                </svg>
                            </span>
                        </div>
                        <div class="field-hint">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px;flex-shrink:0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                            </svg>
                            Email digunakan sebagai identitas login dan tidak dapat diubah.
                        </div>
                    </div>

                    {{-- Status verifikasi --}}
                    <div style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:20px">
                        @if($user->hasVerifiedEmail())
                            <svg fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span style="font-size:13px;color:#15803d;font-weight:500">Email terverifikasi</span>
                        @else
                            <svg fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                            </svg>
                            <span style="font-size:13px;color:#b45309;font-weight:500">Email belum diverifikasi</span>
                        @endif
                    </div>

                    <div style="display:flex;gap:10px;flex-wrap:wrap">
                        <button type="submit" class="btn-primary">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tab: Password --}}
            <div class="tab-panel {{ session('tab') === 'password' ? 'active' : '' }}" id="tab-password">

                <div class="section-label">Ganti Kata Sandi</div>

                <form method="POST" action="{{ route('admin.profile.password') }}" novalidate>
                    @csrf

                    {{-- Current password --}}
                    <div class="form-group">
                        <label for="current_password">Kata Sandi Saat Ini</label>
                        <div class="input-wrap">
                            <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                            <input type="password" id="current_password" name="current_password"
                                   placeholder="••••••••"
                                   class="has-eye {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                                   autocomplete="current-password">
                            <button type="button" class="eye-btn" onclick="toggleEye('current_password','eye-curr')" id="eye-curr-btn" aria-label="Tampilkan">
                                <svg id="eye-curr" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="field-error">
                                <svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;flex-shrink:0">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- New password --}}
                    <div class="form-group">
                        <label for="password">Kata Sandi Baru</label>
                        <div class="input-wrap">
                            <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                            <input type="password" id="password" name="password"
                                   placeholder="Min. 8 karakter"
                                   class="has-eye {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   autocomplete="new-password"
                                   oninput="checkStrength(this.value)">
                            <button type="button" class="eye-btn" onclick="toggleEye('password','eye-new')" id="eye-new-btn" aria-label="Tampilkan">
                                <svg id="eye-new" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="strength-bar" id="strength-bar">
                            <span></span><span></span><span></span><span></span><span></span>
                        </div>
                        <div class="strength-label" id="strength-label"></div>
                        @error('password')
                            <div class="field-error" style="margin-top:6px">
                                <svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;flex-shrink:0">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Confirm password --}}
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                        <div class="input-wrap">
                            <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   placeholder="Ulangi kata sandi baru"
                                   class="has-eye {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                   autocomplete="new-password">
                            <button type="button" class="eye-btn" onclick="toggleEye('password_confirmation','eye-conf')" id="eye-conf-btn" aria-label="Tampilkan">
                                <svg id="eye-conf" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="field-error">
                                <svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;flex-shrink:0">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div style="display:flex;gap:10px;flex-wrap:wrap">
                        <button type="submit" class="btn-primary">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    // ─── Tab switching
    function switchTab(name, btn) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + name).classList.add('active');
    }

    // ─── Eye toggle
    function toggleEye(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        const show  = input.type === 'password';
        input.type  = show ? 'text' : 'password';
        icon.innerHTML = show
            ? `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>`
            : `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
    }

    // ─── Password strength
    function checkStrength(val) {
        const bars  = document.querySelectorAll('#strength-bar span');
        const label = document.getElementById('strength-label');
        let score = 0;
        if (val.length >= 8)              score++;
        if (val.length >= 12)             score++;
        if (/[A-Z]/.test(val))            score++;
        if (/[0-9]/.test(val))            score++;
        if (/[^A-Za-z0-9]/.test(val))    score++;
        const colors = ['#f87171','#fb923c','#facc15','#4ade80','#22c55e'];
        const labels = ['Sangat Lemah','Lemah','Cukup','Kuat','Sangat Kuat'];
        bars.forEach((b, i) => {
            b.style.background = i < score ? colors[score - 1] : '#e2e8f0';
        });
        label.textContent = val.length ? labels[score - 1] || '' : '';
        label.style.color = score > 0 ? colors[score - 1] : '#94a3b8';
    }

    // ─── Photo preview
    function previewPhoto(input) {
        const previewWrap = document.getElementById('photo-preview-wrap');
        const previewImg  = document.getElementById('photo-preview-img');
        const previewName = document.getElementById('photo-preview-name');
        const uploadBtn   = document.getElementById('upload-btn');

        if (input.files && input.files[0]) {
            const file   = input.files[0];
            const reader = new FileReader();
            reader.onload = e => {
                previewImg.src = e.target.result;
                previewName.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                previewWrap.style.display = 'block';
                uploadBtn.disabled = false;

                // Update big circle preview
                const circle = document.getElementById('photo-circle');
                const existing = circle.querySelector('img#current-photo');
                const initial  = circle.querySelector('.photo-initial');
                if (initial) initial.style.display = 'none';
                if (existing) {
                    existing.src = e.target.result;
                } else {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview';
                    img.id  = 'current-photo';
                    img.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:50%;z-index:1';
                    circle.insertBefore(img, circle.firstChild);
                }
            };
            reader.readAsDataURL(file);
        }
    }

    function handleDrop(e) {
        e.preventDefault();
        document.getElementById('upload-zone').classList.remove('dragover');
        const dt = e.dataTransfer;
        if (dt.files.length) {
            const input = document.getElementById('photo-input');
            input.files = dt.files;
            previewPhoto(input);
        }
    }
</script>
@endpush
