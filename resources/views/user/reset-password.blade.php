@extends('layouts.app')
@section('title', 'Atur Kata Sandi — Biara Loresa SCJ')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            <div class="text-center mb-8">
                <h1 class="text-xl font-bold text-gray-900">Atur Kata Sandi Baru</h1>
                <p class="text-sm text-gray-500 mt-1">Masukkan kata sandi baru untuk akun Anda</p>
            </div>

            @if($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700 text-sm">
                    @foreach($errors->all() as $e) {{ $e }} @endforeach
                </div>
            @endif

            <form method="POST" action="{{ url('/password/reset') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email) }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
                    <input type="password" id="password" name="password"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           required autocomplete="new-password">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           required autocomplete="new-password">
                </div>
                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition-colors">
                    Simpan Kata Sandi
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection
