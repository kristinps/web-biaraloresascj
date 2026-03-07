@extends('layouts.app')
@section('title', 'Buat Password Baru — Biara Loresa SCJ')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            <div class="text-center mb-8">
                <div class="w-14 h-14 bg-primary-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <h1 class="text-xl font-bold text-gray-900">Buat Password Baru</h1>
                <p class="text-sm text-gray-500 mt-1">Masukkan email yang terdaftar (email dari konfirmasi pembayaran). Kami akan mengirim tautan untuk mengatur kata sandi.</p>
            </div>

            @if(session('status'))
                <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 text-sm">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700 text-sm">
                    @foreach($errors->all() as $e) {{ $e }} @endforeach
                </div>
            @endif

            <form method="POST" action="{{ url('/lupa-password') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           placeholder="email@contoh.com" required autofocus>
                </div>
                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition-colors">
                    Kirim Tautan Buat Password
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection
