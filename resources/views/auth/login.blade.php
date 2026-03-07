@extends('layouts.app')

@section('title', 'Masuk - Biara Loresa SCJ')

@section('content')
<section class="relative min-h-screen flex items-center justify-center overflow-hidden py-16">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop"
             alt="Biara" class="w-full h-full object-cover">
        <div class="hero-overlay absolute inset-0"></div>
    </div>

    <div class="relative z-10 w-full max-w-md px-4">
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8">
            <div class="text-center mb-8">
                <div class="inline-flex w-16 h-16 bg-primary-700 rounded-full items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-serif font-bold text-gray-800">Masuk ke Dashboard</h1>
                <p class="text-gray-500 text-sm mt-1">Biara Loresa SCJ</p>
            </div>

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror"
                           placeholder="nama@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                           class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>
                <button type="submit" class="w-full bg-primary-700 text-white py-3 rounded-lg font-semibold hover:bg-primary-800 transition-colors">
                    Masuk
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="text-primary-700 font-medium hover:underline">Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</section>
@endsection
