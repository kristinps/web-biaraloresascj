@extends('layouts.app')

@section('title', 'Masuk - Biara Loresa SCJ')

@section('content')
<style>
    .login-page {
        font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-card {
        background: linear-gradient(135deg,
            rgba(99,102,241,0.14),
            rgba(139,92,246,0.10),
            rgba(56,189,248,0.08)
        );
        border-radius: 16px;
        border: 1px solid rgba(148,163,184,0.5);
        box-shadow: 0 18px 45px rgba(15,23,42,0.14);
        overflow: hidden;
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
    }
    .login-card .form-card { padding: 32px; }
    .login-card .form-group { margin-bottom: 22px; }
    .login-card .form-group label {
        display: block;
        font-size: 13.5px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 7px;
    }
    .login-card .form-control {
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
    .login-card .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.12);
    }
    .login-card .form-control::placeholder { color: rgba(255, 255, 255, 0.85); }
    .login-card .form-control::-webkit-input-placeholder { color: rgba(255, 255, 255, 0.85); }
    .login-card .form-control::-moz-placeholder { color: rgba(255, 255, 255, 0.85); }
    .login-card .form-control:-ms-input-placeholder { color: rgba(255, 255, 255, 0.85); }
    .login-card .is-invalid { border-color: #ef4444 !important; }
    .login-card .invalid-feedback { color: #ef4444; font-size: 12px; margin-top: 4px; }
    .login-card .form-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        align-items: stretch;
        margin-top: 28px;
    }
    .login-card .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px 24px;
        background: linear-gradient(135deg,#6366f1,#8b5cf6);
        color: #fff;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(99,102,241,0.3);
        transition: opacity 0.2s;
    }
    .login-card .btn-primary:hover { opacity: 0.88; }
    .login-card .form-actions .back-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 4px;
        color: rgba(255, 255, 255, 0.9);
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.2s, opacity 0.2s;
    }
    .login-card .form-actions .back-link:hover {
        color: #fff;
        opacity: 1;
        text-decoration: underline;
    }
    .login-card .login-header {
        padding: 24px 32px;
        text-align: center;
        border-bottom: 1px solid rgba(148,163,184,0.4);
    }
    .login-card .login-header h1 { color: #ffffff; font-size: 1.25rem; font-weight: 600; }
    .login-card .login-header p { color: rgba(255,255,255,0.9); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.22em; margin-top: 4px; }
    .login-card .alert-error {
        margin-bottom: 20px;
        padding: 12px 14px;
        background: rgba(239,68,68,0.15);
        border: 1px solid rgba(239,68,68,0.4);
        border-radius: 10px;
        color: #fecaca;
        font-size: 13px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    .login-card .alert-success {
        margin-bottom: 20px;
        padding: 12px 14px;
        background: rgba(34,197,94,0.15);
        border: 1px solid rgba(34,197,94,0.4);
        border-radius: 10px;
        color: #bbf7d0;
        font-size: 13px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    .login-card .remember-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 22px;
    }
    .login-card .remember-row label { margin-bottom: 0; font-weight: 600; color: rgba(255,255,255,0.98); }
    .login-card .remember-row input[type="checkbox"] {
        width: 1rem;
        height: 1rem;
        border-radius: 4px;
        accent-color: #6366f1;
    }
    .login-card .login-footer {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid rgba(148,163,184,0.4);
        text-align: center;
    }
    .login-card .login-footer a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: rgba(255,255,255,0.95);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .login-card .login-footer a:hover { opacity: 0.85; }
    @media (min-width: 640px) {
        .login-shell { width: min(420px, calc(100% - 3rem)); }
    }
    @media (max-width: 639px) {
        .login-shell { width: min(100%, calc(100% - 2.25rem)); }
    }
</style>
<section class="login-page relative overflow-hidden py-10 px-6 sm:px-12">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop" alt="" class="w-full h-full object-cover">
        <div class="hero-overlay absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-700/75 to-indigo-700/80"></div>
    </div>

    <div class="relative z-10 mx-auto login-shell">
        <div class="login-card overflow-hidden">
            <div class="login-header">
                <div class="inline-flex w-14 h-14 rounded-full items-center justify-center mb-4 shadow-md" style="background: linear-gradient(135deg,#6366f1,#8b5cf6);">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/></svg>
                </div>
                <h1 class="text-xl font-semibold tracking-wide">Masuk ke Dashboard</h1>
                <p class="font-medium">Biara Loresa SCJ</p>
            </div>

            <div class="form-card">
                @if(session('error'))
                    <div class="alert-error">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert-success">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email <span style="color:#ef4444">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="nama@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Kata Sandi <span style="color:#ef4444">*</span></label>
                        <input type="password" id="password" name="password" required
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="remember-row">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Masuk
                        </button>
                        <a href="{{ route('home') }}" class="back-link">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
