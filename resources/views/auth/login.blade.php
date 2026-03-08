@extends('layouts.app')

@section('title', 'Masuk - Biara Loresa SCJ')

@section('content')
<style>
    .login-card {
        background: #ffffff;
        box-shadow: 0 20px 50px -12px rgba(0,0,0,0.15), 0 0 0 1px rgba(0,0,0,0.06);
    }
    .login-input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(34, 48, 206, 0.25);
        border-color: transparent;
    }
    .login-btn {
        transition: box-shadow 0.2s ease, transform 0.15s ease;
    }
    .login-btn:hover {
        box-shadow: 0 8px 20px -4px rgba(34, 48, 206, 0.35);
        transform: translateY(-1px);
    }
    .login-back:hover { color: #1e2685; }
</style>
<section class="relative overflow-hidden py-10 px-6 sm:px-12">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop" alt="" class="w-full h-full object-cover">
        <div class="hero-overlay absolute inset-0"></div>
    </div>

    <div class="relative z-10 mx-auto" style="width: min(380px, calc(100% - 3rem));">
        <div class="login-card rounded-2xl overflow-hidden">
            <div class="px-8 pt-8 pb-6 text-center border-b border-gray-100">
                <div class="inline-flex w-14 h-14 bg-primary-700 rounded-full items-center justify-center mb-4 mt-3 shadow-md">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/></svg>
                </div>
                <h1 class="text-xl font-serif font-bold text-gray-800">Masuk ke Dashboard</h1>
                <p class="text-primary-600 font-medium text-sm mt-1">Biara Loresa SCJ</p>
            </div>

            <div class="p-6 sm:p-8">
                @if(session('error'))
                    <div class="mb-5 p-4 bg-red-50 border border-red-100 rounded-xl text-red-700 text-sm flex items-start gap-3">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if(session('success'))
                    <div class="mb-5 p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-800 text-sm flex items-start gap-3">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                               class="login-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50/70 text-gray-900 placeholder-gray-400 text-sm focus:bg-white transition-colors @error('email') border-red-400 @enderror"
                               placeholder="nama@email.com">
                        @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi</label>
                        <input type="password" id="password" name="password" required
                               class="login-input w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50/70 text-gray-900 placeholder-gray-400 text-sm focus:bg-white transition-colors @error('password') border-red-400 @enderror"
                               placeholder="••••••••">
                        @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="remember" name="remember" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 w-4 h-4">
                        <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
                    </div>
                    <button type="submit" class="login-btn w-full bg-primary-700 text-white py-3 rounded-xl font-semibold hover:bg-primary-800 text-sm inline-flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Masuk
                    </button>
                </form>

                <div class="mt-6 pt-5 border-t border-gray-100">
                    <a href="{{ route('home') }}" class="login-back flex items-center justify-center gap-2 text-sm text-primary-600 font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
