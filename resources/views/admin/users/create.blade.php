@extends('admin.layouts.app')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')
@section('page-subtitle', 'Buat akun pengguna baru')

@push('styles')
<style>
    .back-link { display:inline-flex; align-items:center; gap:7px; font-size:13.5px; font-weight:600; color:#64748b; text-decoration:none; margin-bottom:20px; transition:color .2s; }
    .back-link:hover { color:#1e2685; }
    .back-link svg { width:16px; height:16px; }

    .form-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,.04); max-width:640px; }
    .form-card-head { padding:18px 24px; background:linear-gradient(135deg,#1e2685,#2b3fe8); display:flex; align-items:center; gap:10px; }
    .form-card-head svg { width:18px; height:18px; color:rgba(255,255,255,.8); }
    .form-card-head h3 { font-size:14px; font-weight:700; color:#fff; }
    .form-body { padding:28px 24px; }

    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
    @media (max-width:600px) { .form-row { grid-template-columns:1fr; } }

    .form-group { margin-bottom:20px; }
    .form-group:last-child { margin-bottom:0; }
    label { display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:7px; }
    label span { color:#ef4444; margin-left:2px; }
    .input-wrap { position:relative; }
    .input-icon { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#94a3b8; width:17px; height:17px; pointer-events:none; }
    input[type="text"], input[type="email"], input[type="password"] {
        width:100%; background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:10px;
        color:#1e293b; font-size:14px; font-family:'Inter',sans-serif;
        padding:11px 13px 11px 42px; outline:none;
        transition:border-color .2s,background .2s,box-shadow .2s;
    }
    input::placeholder { color:#cbd5e1; }
    input:focus { border-color:#1e2685; background:#fff; box-shadow:0 0 0 3px rgba(30,38,133,.1); }
    input.is-invalid { border-color:#f87171; box-shadow:0 0 0 3px rgba(248,113,113,.1); }
    .field-error { font-size:12.5px; color:#dc2626; margin-top:6px; display:flex; align-items:center; gap:5px; }
    .field-hint { font-size:12px; color:#94a3b8; margin-top:5px; }

    /* Password eye */
    .eye-btn { position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#94a3b8; padding:4px; transition:color .2s; }
    .eye-btn:hover { color:#1e2685; }
    .eye-btn svg { width:17px; height:17px; }
    input.has-eye { padding-right:42px; }

    /* Toggle role */
    .role-toggle { display:flex; gap:12px; }
    .role-option { flex:1; }
    .role-option input[type="radio"] { display:none; }
    .role-option label {
        display:flex; align-items:center; gap:10px;
        padding:12px 16px; border:1.5px solid #e2e8f0; border-radius:10px;
        cursor:pointer; transition:border-color .2s,background .2s;
        font-weight:500; font-size:13.5px; color:#475569;
    }
    .role-option input:checked + label {
        border-color:#1e2685; background:#eff6ff; color:#1e2685;
    }
    .role-option label .role-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .role-icon-admin { background:linear-gradient(135deg,#1e2685,#2b3fe8); }
    .role-icon-user  { background:linear-gradient(135deg,#64748b,#94a3b8); }
    .role-option label .role-icon svg { width:17px; height:17px; color:#fff; }
    .role-option label .role-text .rtitle { font-weight:700; font-size:13px; }
    .role-option label .role-text .rdesc { font-size:11.5px; color:#94a3b8; margin-top:1px; }
    .role-option input:checked + label .role-text .rdesc { color:#60a5fa; }

    .form-footer { padding:20px 24px; border-top:1px solid #f1f5f9; display:flex; align-items:center; justify-content:flex-end; gap:10px; }
    .btn-submit { display:inline-flex; align-items:center; gap:7px; padding:10px 22px; background:linear-gradient(135deg,#1e2685,#2b3fe8); color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif; box-shadow:0 4px 14px rgba(30,38,133,.35); transition:opacity .2s,transform .15s; }
    .btn-submit:hover { opacity:.9; transform:translateY(-1px); }
    .btn-submit svg { width:16px; height:16px; }
    .btn-back-footer { display:inline-flex; align-items:center; gap:6px; padding:10px 18px; background:#f1f5f9; color:#475569; border:none; border-radius:10px; font-size:14px; font-weight:600; text-decoration:none; transition:background .15s; }
    .btn-back-footer:hover { background:#e2e8f0; }
</style>
@endpush

@section('content')

<a href="https://admin.biaraloresa.my.id/users" class="back-link">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
    </svg>
    Kembali ke Daftar Pengguna
</a>

<div class="form-card">
    <div class="form-card-head">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
        </svg>
        <h3>Data Pengguna Baru</h3>
    </div>

    <form method="POST" action="https://admin.biaraloresa.my.id/users">
        @csrf
        <div class="form-body">

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nama Lengkap <span>*</span></label>
                    <div class="input-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               placeholder="Nama lengkap"
                               class="{{ $errors->has('name') ? 'is-invalid' : '' }}" required>
                    </div>
                    @error('name') <div class="field-error"><svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;flex-shrink:0"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email <span>*</span></label>
                    <div class="input-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               placeholder="email@example.com"
                               class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required>
                    </div>
                    @error('email') <div class="field-error"><svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;flex-shrink:0"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Kata Sandi <span>*</span></label>
                    <div class="input-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                        <input type="password" id="password" name="password" placeholder="Min. 8 karakter"
                               class="has-eye {{ $errors->has('password') ? 'is-invalid' : '' }}" required>
                        <button type="button" class="eye-btn" onclick="togglePwd('password','eye1')">
                            <svg id="eye1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="field-hint">Minimal 8 karakter, kombinasi huruf besar, kecil & angka.</div>
                    @error('password') <div class="field-error"><svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;flex-shrink:0"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi <span>*</span></label>
                    <div class="input-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               placeholder="Ulangi kata sandi" class="has-eye" required>
                        <button type="button" class="eye-btn" onclick="togglePwd('password_confirmation','eye2')">
                            <svg id="eye2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Hak Akses <span>*</span></label>
                <div class="role-toggle">
                    <div class="role-option">
                        <input type="radio" id="role-admin" name="is_admin" value="1"
                               {{ old('is_admin', '1') === '1' ? 'checked' : '' }}>
                        <label for="role-admin">
                            <div class="role-icon role-icon-admin">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                                </svg>
                            </div>
                            <div class="role-text">
                                <div class="rtitle">Administrator</div>
                                <div class="rdesc">Akses penuh ke panel admin</div>
                            </div>
                        </label>
                    </div>
                    <div class="role-option">
                        <input type="radio" id="role-user" name="is_admin" value="0"
                               {{ old('is_admin') === '0' ? 'checked' : '' }}>
                        <label for="role-user">
                            <div class="role-icon role-icon-user">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                </svg>
                            </div>
                            <div class="role-text">
                                <div class="rtitle">Pengguna Biasa</div>
                                <div class="rdesc">Tidak bisa login ke admin</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-footer">
            <a href="https://admin.biaraloresa.my.id/users" class="btn-back-footer">Batal</a>
            <button type="submit" class="btn-submit">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Simpan Pengguna
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
const eyeState = {};
function togglePwd(inputId, iconId) {
    eyeState[inputId] = !eyeState[inputId];
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    input.type  = eyeState[inputId] ? 'text' : 'password';
    icon.innerHTML = eyeState[inputId]
        ? `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>`
        : `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
}
</script>
@endpush
