@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'user.layouts.app')

@section('title', 'Ubah Kata Sandi')
@section('page-title', 'Ubah Kata Sandi')
@section('page-subtitle', 'Reset password akun dashboard Anda')

@push('styles')
<style>
.card{background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.04);overflow:hidden;max-width:480px;}
.card-body{padding:24px;}
.form-group{margin-bottom:18px;}
.form-group label{display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;}
.form-group input{width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:9px;font-size:14px;}
.btn-primary{display:inline-flex;align-items:center;gap:6px;padding:10px 20px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border:none;border-radius:9px;font-size:14px;font-weight:600;cursor:pointer;}
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route($userRoutePrefix . '.password.update') }}">
            @csrf
            <div class="form-group">
                <label for="password_current">Kata sandi saat ini</label>
                <input type="password" id="password_current" name="password_current" required autocomplete="current-password">
                @error('password_current')<span style="font-size:12px;color:#dc2626;display:block;margin-top:4px">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password">Kata sandi baru</label>
                <input type="password" id="password" name="password" required autocomplete="new-password">
                @error('password')<span style="font-size:12px;color:#dc2626;display:block;margin-top:4px">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi kata sandi baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn-primary">Ubah Kata Sandi</button>
        </form>
    </div>
</div>
<p style="margin-top:20px;font-size:13px;color:#64748b">
    <a href="{{ route($userRoutePrefix . '.profil') }}" style="color:#6366f1;font-weight:600;text-decoration:none">Kembali ke Profil</a>
</p>
@endsection
