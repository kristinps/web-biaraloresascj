@extends('layouts.app')
@section('title', 'Login — Biara Loresa SCJ')

@section('content')
<section class="min-h-[calc(100vh-12rem)] flex items-center justify-center px-4 py-12 bg-gradient-to-b from-gray-50 to-white">
    <div class="w-full max-w-[420px]">
        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/80 border border-gray-100 overflow-hidden">
            {{-- Header card --}}
            <div class="bg-gradient-to-br from-primary-800 via-primary-700 to-primary-600 px-8 py-8 text-center">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/30">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/></svg>
                </div>
                <h1 class="text-xl font-serif font-bold text-white tracking-tight">Login</h1>
                <p class="text-white/80 text-sm mt-1">Akses dashboard peserta</p>
            </div>

            <div class="p-8">
                @if(session('status'))
                    <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 text-emerald-800 text-sm border border-emerald-100">{{ session('status') }}</div>
                @endif
                @if(session('success'))
                    <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 text-emerald-800 text-sm border border-emerald-100">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="mb-5 p-3.5 rounded-xl bg-red-50 text-red-700 text-sm border border-red-100">
                        @foreach($errors->all() as $e) {{ $e }} @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ url('/login') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors"
                               placeholder="nama@email.com" required autofocus>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi</label>
                        <input type="password" id="password" name="password"
                               class="w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors"
                               placeholder="••••••••" required>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 size-4">
                        <label for="remember" class="ml-2.5 text-sm text-gray-600">Ingat saya</label>
                    </div>
                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3.5 rounded-xl transition-all focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        Masuk
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                    <a href="{{ url('/lupa-password') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        Lupa kata sandi? Buat password baru
                    </a>
                </div>
            </div>
        </div>

        <p class="text-center mt-6">
            <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">← Kembali ke Beranda</a>
        </p>
    </div>
</section>
@endsection
