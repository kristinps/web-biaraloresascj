@extends('layouts.app')
@section('title', 'Pendaftaran Kursus Pernikahan - Biara Loresa SCJ')
@section('content')

{{-- ▓▓▓▓▓▓▓▓▓▓  HERO  ▓▓▓▓▓▓▓▓▓▓ --}}
<section class="relative overflow-hidden home-enter" data-home-animate>
    <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full" style="border:50px solid rgba(255,255,255,.06)"></div>
    <div class="absolute -bottom-16 -left-16 w-72 h-72 rounded-full" style="border:40px solid rgba(255,255,255,.05)"></div>
    <div class="relative max-w-5xl mx-auto px-6 sm:px-10 py-14 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center gap-6">
            <div class="w-20 h-20 rounded-3xl flex items-center justify-center flex-shrink-0 shadow-2xl" style="background:rgba(255,255,255,.15);backdrop-filter:blur(8px)">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-primary-200 text-xs font-bold uppercase tracking-widest mb-2 home-enter" data-delay="1" data-home-animate>
                    Biara Loresa SCJ · Kalimantan Timur
                </p>
                <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight home-enter" data-delay="2" data-home-animate>
                    Pendaftaran Kursus Pernikahan
                </h1>
                <p class="text-primary-100 text-sm mt-2 max-w-xl opacity-90 home-enter" data-delay="3" data-home-animate>
                    Persiapkan sakramen pernikahan Anda bersama kami. Isi semua data dengan lengkap dan benar.
                </p>
            </div>
        </div>
        <div class="mt-8 flex flex-wrap gap-3 home-enter" data-delay="4" data-home-animate>
            <span class="inline-flex items-center gap-2 text-white text-xs font-semibold px-4 py-2 rounded-full home-glass-card">
                <span class="step-pill-circle">1</span>
                Biodata Mempelai
            </span>
            <span class="inline-flex items-center gap-2 text-white text-xs font-semibold px-4 py-2 rounded-full home-glass-card">
                <span class="step-pill-circle">2</span>
                Rencana &amp; Kontak
            </span>
            <span class="inline-flex items-center gap-2 text-white text-xs font-semibold px-4 py-2 rounded-full home-glass-card">
                <span class="step-pill-circle">3</span>
                Upload Dokumen
            </span>
            <span class="inline-flex items-center gap-2 text-xs font-semibold px-4 py-2 rounded-full home-glass-card text-amber-200">
                <span class="step-pill-circle step-pill-circle-active">4</span>
                Pembayaran QRIS →
            </span>
        </div>
    </div>
</section>

{{-- ▓▓▓▓▓▓▓▓▓▓  BODY  ▓▓▓▓▓▓▓▓▓▓ --}}
<div class="py-16 home-enter" data-home-animate>
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

    @if($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-5">
        <p class="font-bold text-red-700 text-sm mb-2">Harap perbaiki isian berikut:</p>
        <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-amber-50 border-l-4 border-amber-500 rounded-xl p-5">
        <p class="font-bold text-amber-800 text-sm">{{ session('error') }}</p>
        <p class="text-amber-700 text-xs mt-1">Data pendaftaran Anda telah tersimpan. Silakan <a href="{{ route('user.pembayaran') }}" class="underline font-semibold">masuk ke dashboard</a> untuk menyelesaikan pembayaran via QRIS, atau hubungi admin.</p>
    </div>
    @endif

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 rounded-xl p-5">
        <p class="font-bold text-green-700 text-sm">{{ session('success') }}</p>
    </div>
    @endif

    <form action="{{ route('kursus-pernikahan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
    @csrf

    {{-- ══════════════════════════════════════════════════════
         STEP 1 · BIODATA
    ══════════════════════════════════════════════════════ --}}
    <section class="home-enter" data-home-animate data-delay="1">
        <div class="flex items-center gap-3 mb-6">
            <span class="step-circle shadow-lg flex-shrink-0">1</span>
            <h2 class="text-xl font-extrabold text-white">Biodata Mempelai</h2>
            <div class="flex-1 h-px bg-white/10"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- ━━━ KARTU PRIA ━━━ --}}
            <div class="home-glass-card rounded-2xl overflow-hidden">
                <div class="px-6 py-5 flex items-center gap-4 bg-gradient-to-r from-blue-700 to-sky-500">
                    <div class="w-11 h-11 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-extrabold text-base">Calon Mempelai Pria</h3>
                        <p class="text-blue-200 text-xs mt-0.5">Data diri calon suami</p>
                    </div>
                </div>
                <div class="p-6 space-y-5">
                    {{-- Nama --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_pria" value="{{ old('nama_pria') }}" placeholder="Sesuai KTP"
                            class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('nama_pria') ? 'border-red-400 bg-red-50' : '' }}">
                        @error('nama_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    {{-- TTL --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="tempat_lahir_pria" value="{{ old('tempat_lahir_pria') }}" placeholder="Kota / kabupaten lahir"
                                class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('tempat_lahir_pria') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('tempat_lahir_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir_pria" value="{{ old('tanggal_lahir_pria') }}"
                                class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('tanggal_lahir_pria') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('tanggal_lahir_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    {{-- NIK & Agama --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">NIK <span class="text-red-500">*</span></label>
                            <input type="text" name="nik_pria" value="{{ old('nik_pria') }}" maxlength="16" placeholder="16 digit"
                                class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('nik_pria') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('nik_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Agama <span class="text-red-500">*</span></label>
                            <select name="agama_pria"
                                class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
                                @foreach(['Katolik','Protestan','Islam','Hindu','Buddha','Konghucu'] as $a)
                                <option value="{{ $a }}" {{ old('agama_pria','Katolik')===$a?'selected':'' }}>{{ $a }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Pekerjaan --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Pekerjaan <span class="text-red-500">*</span></label>
                        <input type="text" name="pekerjaan_pria" value="{{ old('pekerjaan_pria') }}" placeholder="Pekerjaan saat ini"
                            class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('pekerjaan_pria') ? 'border-red-400 bg-red-50' : '' }}">
                        @error('pekerjaan_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    {{-- Ortu --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Ayah <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_ayah_pria" value="{{ old('nama_ayah_pria') }}" placeholder="Nama lengkap ayah kandung"
                                class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('nama_ayah_pria') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('nama_ayah_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Ibu <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_ibu_pria" value="{{ old('nama_ibu_pria') }}" placeholder="Nama lengkap ibu kandung"
                                class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('nama_ibu_pria') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('nama_ibu_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    {{-- Alamat --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat_pria" rows="3" placeholder="Jl. Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota"
                            class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all resize-none {{ $errors->has('alamat_pria') ? 'border-red-400 bg-red-50' : '' }}">{{ old('alamat_pria') }}</textarea>
                        @error('alamat_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ━━━ KARTU WANITA ━━━ --}}
            <div class="home-glass-card rounded-2xl overflow-hidden">
                <div class="px-6 py-5 flex items-center gap-4 bg-gradient-to-r from-rose-700 to-pink-500">
                    <div class="w-11 h-11 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-extrabold text-base">Calon Mempelai Wanita</h3>
                        <p class="text-rose-100 text-xs mt-0.5">Data diri calon istri</p>
                    </div>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_wanita" value="{{ old('nama_wanita') }}" placeholder="Sesuai KTP"
                            class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('nama_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                        @error('nama_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="tempat_lahir_wanita" value="{{ old('tempat_lahir_wanita') }}" placeholder="Kota / kabupaten lahir"
                                class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('tempat_lahir_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('tempat_lahir_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir_wanita" value="{{ old('tanggal_lahir_wanita') }}"
                                class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('tanggal_lahir_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('tanggal_lahir_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">NIK <span class="text-red-500">*</span></label>
                            <input type="text" name="nik_wanita" value="{{ old('nik_wanita') }}" maxlength="16" placeholder="16 digit"
                                class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('nik_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('nik_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Agama <span class="text-red-500">*</span></label>
                            <select name="agama_wanita"
                                class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all">
                                @foreach(['Katolik','Protestan','Islam','Hindu','Buddha','Konghucu'] as $a)
                                <option value="{{ $a }}" {{ old('agama_wanita','Katolik')===$a?'selected':'' }}>{{ $a }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Pekerjaan <span class="text-red-500">*</span></label>
                        <input type="text" name="pekerjaan_wanita" value="{{ old('pekerjaan_wanita') }}" placeholder="Pekerjaan saat ini"
                            class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('pekerjaan_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                        @error('pekerjaan_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Ayah <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_ayah_wanita" value="{{ old('nama_ayah_wanita') }}" placeholder="Nama lengkap ayah kandung"
                                class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('nama_ayah_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('nama_ayah_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Ibu <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_ibu_wanita" value="{{ old('nama_ibu_wanita') }}" placeholder="Nama lengkap ibu kandung"
                                class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('nama_ibu_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('nama_ibu_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat_wanita" rows="3" placeholder="Jl. Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota"
                            class="form-control w-full rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all resize-none {{ $errors->has('alamat_wanita') ? 'border-red-400 bg-red-50' : '' }}">{{ old('alamat_wanita') }}</textarea>
                        @error('alamat_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════
         STEP 2 · RENCANA & KONTAK
    ══════════════════════════════════════════════════════ --}}
    <section class="home-enter" data-home-animate data-delay="2">
        <div class="flex items-center gap-3 mb-6">
            <span class="step-circle shadow-lg flex-shrink-0">2</span>
            <h2 class="text-xl font-extrabold text-white">Rencana Pernikahan &amp; Kontak</h2>
            <div class="flex-1 h-px bg-white/10"></div>
        </div>
        <div class="home-glass-card rounded-2xl p-6 sm:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="rounded-2xl p-5 bg-white/5 border border-white/20">
                    <p class="text-xs font-bold uppercase tracking-widest mb-3 text-primary-200">📅 Tanggal Pernikahan <span class="text-red-500">*</span></p>
                    <input type="date" name="tanggal_pernikahan" value="{{ old('tanggal_pernikahan') }}"
                        class="form-control w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-primary-300 focus:outline-none focus:ring-2 focus:ring-amber-300 transition-all {{ $errors->has('tanggal_pernikahan') ? 'ring-2 ring-red-400' : '' }}">
                    @error('tanggal_pernikahan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="rounded-2xl p-5 bg-white/5 border border-white/20">
                    <p class="text-xs font-bold uppercase tracking-widest mb-3 text-primary-200">⛪ Tempat Pernikahan <span class="text-red-500">*</span></p>
                    <input type="text" name="tempat_pernikahan" value="{{ old('tempat_pernikahan') }}" placeholder="Nama gereja / kapel"
                        class="form-control w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-primary-300 focus:outline-none focus:ring-2 focus:ring-amber-300 transition-all {{ $errors->has('tempat_pernikahan') ? 'ring-2 ring-red-400' : '' }}">
                    @error('tempat_pernikahan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="rounded-2xl p-5 bg-white/5 border border-white/20">
                    <p class="text-xs font-bold uppercase tracking-widest mb-3 text-primary-200">✉️ Alamat Email <span class="text-red-500">*</span></p>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com"
                        class="form-control w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-primary-300 focus:outline-none focus:ring-2 focus:ring-sky-300 transition-all {{ $errors->has('email') ? 'ring-2 ring-red-400' : '' }}">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="rounded-2xl p-5 bg-white/5 border border-white/20">
                    <p class="text-xs font-bold uppercase tracking-widest mb-3 text-primary-200">📱 Nomor HP / WhatsApp <span class="text-red-500">*</span></p>
                    <input type="tel" name="nomor_hp" value="{{ old('nomor_hp') }}" placeholder="08xx-xxxx-xxxx"
                        class="form-control w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-primary-300 focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all {{ $errors->has('nomor_hp') ? 'ring-2 ring-red-400' : '' }}">
                    @error('nomor_hp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════
         STEP 3 · UPLOAD DOKUMEN
    ══════════════════════════════════════════════════════ --}}
    <section class="home-enter" data-home-animate data-delay="3">
        <div class="flex items-center gap-3 mb-6">
            <span class="step-circle shadow-lg flex-shrink-0">3</span>
            <h2 class="text-xl font-extrabold text-white">Upload Dokumen Pendukung</h2>
            <div class="flex-1 h-px bg-white/10"></div>
        </div>

        <div class="rounded-xl px-5 py-3.5 flex items-center gap-3 mb-6 bg-white/5 border border-white/20 blur-card">
            <svg class="w-5 h-5 flex-shrink-0 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-primary-100">Format: <strong>JPG, PNG</strong> atau <strong>PDF</strong> · Maks. <strong>1 GB</strong> per file · Upload untuk kedua calon mempelai.</p>
        </div>

        <div class="space-y-5">

            {{-- ─── KTP ─── --}}
            <div class="home-glass-card rounded-2xl overflow-hidden">
                <div class="flex items-center gap-4 px-6 py-4 border-b border-white/10 bg-white/5">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 bg-white/10">🪪</div>
                    <div class="flex-1">
                        <h4 class="font-bold text-white">KTP</h4>
                        <p class="text-xs text-primary-200">Kartu Tanda Penduduk</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-white/10 text-primary-100">Wajib</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2" style="divide-color:#f3f4f6">
                    <div class="p-6" style="border-right:1.5px solid #f3f4f6">
                        <p class="text-xs font-bold mb-3 text-primary-200">● Calon Pria</p>
                        <label id="lbl-ktp-pria" class="upload-zone" style="border-color:rgba(148,163,184,0.6);background:rgba(15,23,42,0.7)">
                            <input type="file" name="ktp_pria" accept=".jpg,.jpeg,.png,.pdf" class="sr-only" onchange="picked(this,'ktp-pria')">
                            <div id="ktp-pria-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2 bg-white/10">
                                <svg class="w-6 h-6" fill="none" stroke="#60a5fa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <p id="ktp-pria-text" class="text-xs font-semibold text-primary-100">Klik untuk pilih file</p>
                            <p class="text-xs text-primary-300 mt-1">JPG · PNG · PDF</p>
                        </label>
                        @error('ktp_pria')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                    <div class="p-6">
                        <p class="text-xs font-bold mb-3 text-primary-200">● Calon Wanita</p>
                        <label id="lbl-ktp-wanita" class="upload-zone" style="border-color:rgba(248,113,113,0.6);background:rgba(24,24,27,0.7)">
                            <input type="file" name="ktp_wanita" accept=".jpg,.jpeg,.png,.pdf" class="sr-only" onchange="picked(this,'ktp-wanita')">
                            <div id="ktp-wanita-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2 bg-white/10">
                                <svg class="w-6 h-6" fill="none" stroke="#fb7185" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <p id="ktp-wanita-text" class="text-xs font-semibold text-primary-100">Klik untuk pilih file</p>
                            <p class="text-xs text-primary-300 mt-1">JPG · PNG · PDF</p>
                        </label>
                        @error('ktp_wanita')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ─── Foto 3x4 ─── --}}
            <div class="home-glass-card rounded-2xl overflow-hidden">
                <div class="flex items-center gap-4 px-6 py-4 border-b border-white/10 bg-white/5">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 bg-white/10">📷</div>
                    <div class="flex-1">
                        <h4 class="font-bold text-white">Pas Foto Terbaru</h4>
                        <p class="text-xs text-primary-200">Ukuran 3×4 cm · Latar belakang bebas · Format JPG/PNG</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-white/10 text-primary-100">Wajib</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2" style="divide-color:#f3f4f6">
                    <div class="p-6" style="border-right:1.5px solid #f3f4f6">
                        <p class="text-xs font-bold mb-3 text-primary-200">● Calon Pria</p>
                        {{-- Preview area foto pria --}}
                        <div id="foto-pria-preview-wrap" class="hidden mb-3 flex justify-center">
                            <div class="relative inline-block">
                                <img id="foto-pria-preview" src="" alt="Preview foto pria"
                                    class="rounded-lg object-cover shadow border-2 border-blue-200"
                                    style="width:96px;height:128px">
                                <span class="absolute -top-2 -right-2 bg-green-500 text-white text-xs rounded-full px-1.5 py-0.5 font-bold">3×4</span>
                            </div>
                        </div>
                        <label id="lbl-foto-pria" class="upload-zone" style="border-color:rgba(148,163,184,0.6);background:rgba(15,23,42,0.7)">
                            <input type="file" name="foto_pria" accept=".jpg,.jpeg,.png" class="sr-only" onchange="pickedFoto(this,'foto-pria')">
                            <div id="foto-pria-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2 bg-white/10">
                                <svg class="w-6 h-6" fill="none" stroke="#3b82f6" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <p id="foto-pria-text" class="text-xs font-semibold text-primary-100">Klik untuk pilih foto</p>
                            <p class="text-xs text-primary-300 mt-1">JPG · PNG · Ukuran 3×4</p>
                        </label>
                        @error('foto_pria')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                    <div class="p-6">
                        <p class="text-xs font-bold mb-3 text-primary-200">● Calon Wanita</p>
                        {{-- Preview area foto wanita --}}
                        <div id="foto-wanita-preview-wrap" class="hidden mb-3 flex justify-center">
                            <div class="relative inline-block">
                                <img id="foto-wanita-preview" src="" alt="Preview foto wanita"
                                    class="rounded-lg object-cover shadow border-2 border-rose-200"
                                    style="width:96px;height:128px">
                                <span class="absolute -top-2 -right-2 bg-green-500 text-white text-xs rounded-full px-1.5 py-0.5 font-bold">3×4</span>
                            </div>
                        </div>
                        <label id="lbl-foto-wanita" class="upload-zone" style="border-color:rgba(248,113,113,0.6);background:rgba(24,24,27,0.7)">
                            <input type="file" name="foto_wanita" accept=".jpg,.jpeg,.png" class="sr-only" onchange="pickedFoto(this,'foto-wanita')">
                            <div id="foto-wanita-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2 bg-white/10">
                                <svg class="w-6 h-6" fill="none" stroke="#f43f5e" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <p id="foto-wanita-text" class="text-xs font-semibold text-primary-100">Klik untuk pilih foto</p>
                            <p class="text-xs text-primary-300 mt-1">JPG · PNG · Ukuran 3×4</p>
                        </label>
                        @error('foto_wanita')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ─── Surat Baptis ─── --}}
            <div class="home-glass-card rounded-2xl overflow-hidden">
                <div class="flex items-center gap-4 px-6 py-4 border-b border-white/10 bg-white/5">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 bg-white/10">✝️</div>
                    <div class="flex-1">
                        <h4 class="font-bold text-white">Surat Baptis</h4>
                        <p class="text-xs text-primary-200">Surat keterangan baptis dari paroki</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-white/10 text-primary-100">Wajib</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2" style="divide-color:#f3f4f6">
                    <div class="p-6" style="border-right:1.5px solid #f3f4f6">
                        <p class="text-xs font-bold mb-3 text-primary-200">● Calon Pria</p>
                        <label id="lbl-baptis-pria" class="upload-zone" style="border-color:rgba(148,163,184,0.6);background:rgba(15,23,42,0.7)">
                            <input type="file" name="surat_baptis_pria" accept=".jpg,.jpeg,.png,.pdf" class="sr-only" onchange="picked(this,'baptis-pria')">
                            <div id="baptis-pria-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2 bg-white/10">
                                <svg class="w-6 h-6" fill="none" stroke="#3b82f6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <p id="baptis-pria-text" class="text-xs font-semibold text-primary-100">Klik untuk pilih file</p>
                            <p class="text-xs text-primary-300 mt-1">JPG · PNG · PDF</p>
                        </label>
                        @error('surat_baptis_pria')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                    <div class="p-6">
                        <p class="text-xs font-bold mb-3 text-primary-200">● Calon Wanita</p>
                        <label id="lbl-baptis-wanita" class="upload-zone" style="border-color:rgba(248,113,113,0.6);background:rgba(24,24,27,0.7)">
                            <input type="file" name="surat_baptis_wanita" accept=".jpg,.jpeg,.png,.pdf" class="sr-only" onchange="picked(this,'baptis-wanita')">
                            <div id="baptis-wanita-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2 bg-white/10">
                                <svg class="w-6 h-6" fill="none" stroke="#f43f5e" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <p id="baptis-wanita-text" class="text-xs font-semibold text-primary-100">Klik untuk pilih file</p>
                            <p class="text-xs text-primary-300 mt-1">JPG · PNG · PDF</p>
                        </label>
                        @error('surat_baptis_wanita')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ─── Surat Pengantar Kombas ─── --}}
            <div class="home-glass-card rounded-2xl overflow-hidden">
                <div class="flex items-center gap-4 px-6 py-4 border-b border-white/10 bg-white/5">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 bg-white/10">📋</div>
                    <div class="flex-1">
                        <h4 class="font-bold text-white">Surat Pengantar Kombas</h4>
                        <p class="text-xs text-primary-200">Komisi Keluarga / Komisi Keagamaan</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-white/10 text-primary-100">Wajib</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2" style="divide-color:#f3f4f6">
                    <div class="p-6" style="border-right:1.5px solid #f3f4f6">
                        <p class="text-xs font-bold mb-3 text-primary-200">● Calon Pria</p>
                        <label id="lbl-kombas-pria" class="upload-zone" style="border-color:rgba(148,163,184,0.6);background:rgba(15,23,42,0.7)">
                            <input type="file" name="surat_pengantar_kombas_pria" accept=".jpg,.jpeg,.png,.pdf" class="sr-only" onchange="picked(this,'kombas-pria')">
                            <div id="kombas-pria-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2 bg-white/10">
                                <svg class="w-6 h-6" fill="none" stroke="#3b82f6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <p id="kombas-pria-text" class="text-xs font-semibold text-primary-100">Klik untuk pilih file</p>
                            <p class="text-xs text-primary-300 mt-1">JPG · PNG · PDF</p>
                        </label>
                        @error('surat_pengantar_kombas_pria')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                    <div class="p-6">
                        <p class="text-xs font-bold mb-3 text-primary-200">● Calon Wanita</p>
                        <label id="lbl-kombas-wanita" class="upload-zone" style="border-color:rgba(248,113,113,0.6);background:rgba(24,24,27,0.7)">
                            <input type="file" name="surat_pengantar_kombas_wanita" accept=".jpg,.jpeg,.png,.pdf" class="sr-only" onchange="picked(this,'kombas-wanita')">
                            <div id="kombas-wanita-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2 bg-white/10">
                                <svg class="w-6 h-6" fill="none" stroke="#f43f5e" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <p id="kombas-wanita-text" class="text-xs font-semibold text-primary-100">Klik untuk pilih file</p>
                            <p class="text-xs text-primary-300 mt-1">JPG · PNG · PDF</p>
                        </label>
                        @error('surat_pengantar_kombas_wanita')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════
         TOMBOL LANJUT KE PEMBAYARAN
    ══════════════════════════════════════════════════════ --}}
    <div class="home-glass-card rounded-2xl px-6 py-5">
        {{-- Info langkah berikutnya --}}
        <div class="flex items-start gap-3 mb-5 p-4 rounded-xl bg-white/5 border border-white/20">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="font-semibold text-sm text-primary-100">Setelah mengisi formulir ini, Anda akan diarahkan ke halaman pembayaran QRIS</p>
                <p class="text-xs mt-0.5 text-primary-200">Total pembayaran: <strong>Rp 350.000</strong> · dibayar melalui QRIS (GoPay, OVO, DANA, ShopeePay, dll.)</p>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-400 text-center sm:text-left">
                🔒 Data bersifat rahasia dan hanya digunakan untuk keperluan kursus pernikahan Biara Loresa SCJ.
            </p>
            <button type="submit" id="btn-submit" disabled
                class="w-full sm:w-auto flex items-center justify-center gap-2 font-bold text-sm px-10 py-3.5 rounded-xl shadow-lg transition-all"
                style="background:#d1d5db;color:#9ca3af;cursor:not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <span id="btn-submit-text">Lengkapi semua data terlebih dahulu</span>
            </button>
        </div>
    </div>

    </form>
</div>
</div>

<style>
.upload-zone {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 1.5rem 1rem;
    border: 2px dashed;
    border-radius: 1rem;
    cursor: pointer;
    transition: all .2s;
    /* Samakan warna dengan input biasa */
    background: rgba(167, 185, 226, 0.45) !important;
}
.upload-zone:hover { filter: brightness(.97); }
.upload-zone.done  { background:#f0fdf4 !important; border-color:#4ade80 !important; border-style:solid !important; }

/* Input style disamakan dengan halaman login */
.form-control {
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
.form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.12);
}
.form-control::placeholder {
    color: rgba(255, 255, 255, 0.85);
}

/* Semua teks di dalam kartu form dibuat putih, KECUALI isi field */
.home-glass-card,
.home-glass-card label,
.home-glass-card p,
.home-glass-card span {
    color: #ffffff;
}

/* Teks yang diketik di input/textarea/select dibuat hitam agar jelas terbaca */
.home-glass-card input,
.home-glass-card textarea,
.home-glass-card select {
    color: #111827;
}

/* Bar informasi dokumen dengan efek blur */
.blur-card {
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
}

/* Lingkaran nomor step dengan efek blur dan tanpa warna solid */
.step-circle {
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 9999px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 0.875rem;
    color: #ffffff;
    background: rgba(15, 23, 42, 0);
    border: 1px solid rgba(248, 250, 252, 0.86);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
}

/* Lingkaran kecil pada pill step di hero */
.step-pill-circle {
    width: 1.25rem;
    height: 1.25rem;
    border-radius: 9999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 800;
    background: #ffffff;
    color: #111827 !important;
}
.step-pill-circle-active {
    background:rgb(255, 255, 255);
    color: #1f2937 !important;
}
</style>

<script>
// ── Validasi form real-time ──────────────────────────────────
const REQUIRED_FIELDS = [
    'nama_pria','tempat_lahir_pria','tanggal_lahir_pria','nik_pria',
    'agama_pria','pekerjaan_pria','alamat_pria','nama_ayah_pria','nama_ibu_pria',
    'nama_wanita','tempat_lahir_wanita','tanggal_lahir_wanita','nik_wanita',
    'agama_wanita','pekerjaan_wanita','alamat_wanita','nama_ayah_wanita','nama_ibu_wanita',
    'tanggal_pernikahan','tempat_pernikahan','email','nomor_hp',
];

const btn     = document.getElementById('btn-submit');
const btnText = document.getElementById('btn-submit-text');

function checkForm() {
    let allFilled = true;
    let emptyCount = 0;

    REQUIRED_FIELDS.forEach(name => {
        const el = document.querySelector(`[name="${name}"]`);
        if (!el || el.value.trim() === '') {
            allFilled = false;
            emptyCount++;
        }
    });

    // Validasi NIK harus 16 digit
    const nikPria   = document.querySelector('[name="nik_pria"]');
    const nikWanita = document.querySelector('[name="nik_wanita"]');
    if (nikPria   && nikPria.value.trim().length > 0   && nikPria.value.trim().length !== 16) allFilled = false;
    if (nikWanita && nikWanita.value.trim().length > 0 && nikWanita.value.trim().length !== 16) allFilled = false;

    // Validasi email sederhana
    const emailEl = document.querySelector('[name="email"]');
    if (emailEl && emailEl.value.trim() && !emailEl.value.includes('@')) allFilled = false;

    if (allFilled) {
        btn.disabled = false;
        btn.style.background  = 'linear-gradient(135deg,#1e2685,#7c3aed,#be185d)';
        btn.style.color       = '#fff';
        btn.style.cursor      = 'pointer';
        btn.classList.add('active:scale-95','hover:opacity-90');
        btnText.textContent = 'Kirim data · Lanjut ke Pembayaran QRIS';
    } else {
        btn.disabled = true;
        btn.style.background  = '#d1d5db';
        btn.style.color       = '#9ca3af';
        btn.style.cursor      = 'not-allowed';
        btn.classList.remove('active:scale-95','hover:opacity-90');
        const s = emptyCount === 1 ? '' : '';
        btnText.textContent = `Lengkapi semua data (${emptyCount} kolom belum diisi)`;
    }
}

// Pasang listener ke semua field wajib
REQUIRED_FIELDS.forEach(name => {
    const el = document.querySelector(`[name="${name}"]`);
    if (el) el.addEventListener('input', checkForm);
    if (el) el.addEventListener('change', checkForm);
});

// Jalankan sekali saat load (jika ada old values dari validasi server)
document.addEventListener('DOMContentLoaded', checkForm);

// Session keepalive: panggil setiap 10 menit agar sesi tidak habis saat mengisi formulir lama
(function keepSessionAlive() {
    var url = @json(route('session.keepalive'));
    setInterval(function() {
        fetch(url, { method: 'GET', credentials: 'same-origin', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } }).catch(function() {});
    }, 10 * 60 * 1000);
})();

// ── Upload foto (dengan preview gambar) ─────────────────────
function pickedFoto(input, id) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const name = file.name.length > 22 ? file.name.slice(0,20)+'…' : file.name;
    const lbl  = document.getElementById('lbl-' + id);
    const icon = document.getElementById(id + '-icon');
    const text = document.getElementById(id + '-text');
    const previewWrap = document.getElementById(id + '-preview-wrap');
    const previewImg  = document.getElementById(id + '-preview');

    lbl.classList.add('done');
    icon.style.background = '#dcfce7';
    icon.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="#22c55e" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>';
    text.style.color = '#15803d';
    text.textContent = '✓ ' + name;

    const reader = new FileReader();
    reader.onload = function(e) {
        previewImg.src = e.target.result;
        previewWrap.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

// ── Upload dokumen ───────────────────────────────────────────
function picked(input, id) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const name = file.name.length > 22 ? file.name.slice(0,20)+'…' : file.name;
    const lbl  = document.getElementById('lbl-' + id);
    const icon = document.getElementById(id + '-icon');
    const text = document.getElementById(id + '-text');

    lbl.classList.add('done');
    icon.style.background = '#dcfce7';
    icon.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="#22c55e" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>';
    text.style.color = '#15803d';
    text.textContent = '✓ ' + name;
}
</script>

@endsection
