@extends('layouts.app')
@section('title', 'Pendaftaran Kursus Pernikahan - Biara Loresa SCJ')
@section('content')

{{-- ▓▓▓▓▓▓▓▓▓▓  HERO  ▓▓▓▓▓▓▓▓▓▓ --}}
<div class="relative overflow-hidden" style="background:linear-gradient(135deg,#1e2685 0%,#3d56f5 50%,#be185d 100%)">
    <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full" style="border:50px solid rgba(255,255,255,.06)"></div>
    <div class="absolute -bottom-16 -left-16 w-72 h-72 rounded-full" style="border:40px solid rgba(255,255,255,.05)"></div>
    <div class="relative max-w-5xl mx-auto px-6 sm:px-10 py-14">
        <div class="flex flex-col sm:flex-row sm:items-center gap-6">
            <div class="w-20 h-20 rounded-3xl flex items-center justify-center flex-shrink-0 shadow-2xl" style="background:rgba(255,255,255,.15);backdrop-filter:blur(8px)">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-2">Biara Loresa SCJ · Kalimantan Timur</p>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight">Pendaftaran Kursus Pernikahan</h1>
                <p class="text-blue-100 text-sm mt-2 max-w-xl opacity-90">Persiapkan sakramen pernikahan Anda bersama kami. Isi semua data dengan lengkap dan benar.</p>
            </div>
        </div>
        <div class="mt-8 flex flex-wrap gap-3">
            <span class="inline-flex items-center gap-2 text-white text-xs font-semibold px-4 py-2 rounded-full" style="background:rgba(255,255,255,.15)">
                <span class="w-5 h-5 rounded-full bg-white text-blue-800 text-xs font-bold flex items-center justify-center">1</span>
                Biodata Mempelai
            </span>
            <span class="inline-flex items-center gap-2 text-white text-xs font-semibold px-4 py-2 rounded-full" style="background:rgba(255,255,255,.15)">
                <span class="w-5 h-5 rounded-full bg-white text-blue-800 text-xs font-bold flex items-center justify-center">2</span>
                Rencana &amp; Kontak
            </span>
            <span class="inline-flex items-center gap-2 text-white text-xs font-semibold px-4 py-2 rounded-full" style="background:rgba(255,255,255,.15)">
                <span class="w-5 h-5 rounded-full bg-white text-blue-800 text-xs font-bold flex items-center justify-center">3</span>
                Upload Dokumen
            </span>
            <span class="inline-flex items-center gap-2 text-white text-xs font-semibold px-4 py-2 rounded-full" style="background:rgba(255,255,255,.15)">
                <span class="w-5 h-5 rounded-full bg-white text-blue-800 text-xs font-bold flex items-center justify-center">4</span>
                Pembayaran
            </span>
        </div>
    </div>
</div>

{{-- ▓▓▓▓▓▓▓▓▓▓  BODY  ▓▓▓▓▓▓▓▓▓▓ --}}
<div class="bg-gray-100 py-10">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

    @if($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-5">
        <p class="font-bold text-red-700 text-sm mb-2">Harap perbaiki isian berikut:</p>
        <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('kursus-pernikahan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
    @csrf

    {{-- ══════════════════════════════════════════════════════
         STEP 1 · BIODATA
    ══════════════════════════════════════════════════════ --}}
    <section>
        <div class="flex items-center gap-3 mb-6">
            <span class="w-9 h-9 rounded-full text-white text-sm font-extrabold flex items-center justify-center shadow-lg flex-shrink-0" style="background:#2230ce">1</span>
            <h2 class="text-xl font-extrabold text-gray-800">Biodata Mempelai</h2>
            <div class="flex-1 h-px bg-gray-300"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- ━━━ KARTU PRIA ━━━ --}}
            <div class="rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-5 flex items-center gap-4" style="background:linear-gradient(135deg,#1d4ed8,#3b82f6)">
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
                <div class="bg-white p-6 space-y-5">
                    {{-- Nama --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_pria" value="{{ old('nama_pria') }}" placeholder="Sesuai KTP"
                            style="background:#eff6ff;border:1.5px solid #bfdbfe"
                            class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('nama_pria') ? 'border-red-400 bg-red-50' : '' }}">
                        @error('nama_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    {{-- TTL --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="tempat_lahir_pria" value="{{ old('tempat_lahir_pria') }}"
                                style="background:#eff6ff;border:1.5px solid #bfdbfe"
                                class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('tempat_lahir_pria') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('tempat_lahir_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir_pria" value="{{ old('tanggal_lahir_pria') }}"
                                style="background:#eff6ff;border:1.5px solid #bfdbfe"
                                class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('tanggal_lahir_pria') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('tanggal_lahir_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    {{-- NIK & Agama --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">NIK <span class="text-red-500">*</span></label>
                            <input type="text" name="nik_pria" value="{{ old('nik_pria') }}" maxlength="16" placeholder="16 digit"
                                style="background:#eff6ff;border:1.5px solid #bfdbfe"
                                class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('nik_pria') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('nik_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Agama <span class="text-red-500">*</span></label>
                            <select name="agama_pria"
                                style="background:#eff6ff;border:1.5px solid #bfdbfe"
                                class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
                                @foreach(['Katolik','Protestan','Islam','Hindu','Buddha','Konghucu'] as $a)
                                <option value="{{ $a }}" {{ old('agama_pria','Katolik')===$a?'selected':'' }}>{{ $a }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Pekerjaan --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Pekerjaan <span class="text-red-500">*</span></label>
                        <input type="text" name="pekerjaan_pria" value="{{ old('pekerjaan_pria') }}"
                            style="background:#eff6ff;border:1.5px solid #bfdbfe"
                            class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('pekerjaan_pria') ? 'border-red-400 bg-red-50' : '' }}">
                        @error('pekerjaan_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    {{-- Ortu --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Ayah <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_ayah_pria" value="{{ old('nama_ayah_pria') }}"
                                style="background:#eff6ff;border:1.5px solid #bfdbfe"
                                class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('nama_ayah_pria') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('nama_ayah_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Ibu <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_ibu_pria" value="{{ old('nama_ibu_pria') }}"
                                style="background:#eff6ff;border:1.5px solid #bfdbfe"
                                class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all {{ $errors->has('nama_ibu_pria') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('nama_ibu_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    {{-- Alamat --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat_pria" rows="3" placeholder="Jl. Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota"
                            style="background:#eff6ff;border:1.5px solid #bfdbfe"
                            class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all resize-none {{ $errors->has('alamat_pria') ? 'border-red-400 bg-red-50' : '' }}">{{ old('alamat_pria') }}</textarea>
                        @error('alamat_pria')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ━━━ KARTU WANITA ━━━ --}}
            <div class="rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-5 flex items-center gap-4" style="background:linear-gradient(135deg,#be123c,#f43f5e)">
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
                <div class="bg-white p-6 space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_wanita" value="{{ old('nama_wanita') }}" placeholder="Sesuai KTP"
                            style="background:#fff1f2;border:1.5px solid #fecdd3"
                            class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('nama_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                        @error('nama_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="tempat_lahir_wanita" value="{{ old('tempat_lahir_wanita') }}"
                                style="background:#fff1f2;border:1.5px solid #fecdd3"
                                class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('tempat_lahir_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('tempat_lahir_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir_wanita" value="{{ old('tanggal_lahir_wanita') }}"
                                style="background:#fff1f2;border:1.5px solid #fecdd3"
                                class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('tanggal_lahir_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('tanggal_lahir_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">NIK <span class="text-red-500">*</span></label>
                            <input type="text" name="nik_wanita" value="{{ old('nik_wanita') }}" maxlength="16" placeholder="16 digit"
                                style="background:#fff1f2;border:1.5px solid #fecdd3"
                                class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('nik_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('nik_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Agama <span class="text-red-500">*</span></label>
                            <select name="agama_wanita"
                                style="background:#fff1f2;border:1.5px solid #fecdd3"
                                class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all">
                                @foreach(['Katolik','Protestan','Islam','Hindu','Buddha','Konghucu'] as $a)
                                <option value="{{ $a }}" {{ old('agama_wanita','Katolik')===$a?'selected':'' }}>{{ $a }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Pekerjaan <span class="text-red-500">*</span></label>
                        <input type="text" name="pekerjaan_wanita" value="{{ old('pekerjaan_wanita') }}"
                            style="background:#fff1f2;border:1.5px solid #fecdd3"
                            class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('pekerjaan_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                        @error('pekerjaan_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Ayah <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_ayah_wanita" value="{{ old('nama_ayah_wanita') }}"
                                style="background:#fff1f2;border:1.5px solid #fecdd3"
                                class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('nama_ayah_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('nama_ayah_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Ibu <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_ibu_wanita" value="{{ old('nama_ibu_wanita') }}"
                                style="background:#fff1f2;border:1.5px solid #fecdd3"
                                class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all {{ $errors->has('nama_ibu_wanita') ? 'border-red-400 bg-red-50' : '' }}">
                            @error('nama_ibu_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat_wanita" rows="3" placeholder="Jl. Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota"
                            style="background:#fff1f2;border:1.5px solid #fecdd3"
                            class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:bg-white transition-all resize-none {{ $errors->has('alamat_wanita') ? 'border-red-400 bg-red-50' : '' }}">{{ old('alamat_wanita') }}</textarea>
                        @error('alamat_wanita')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════
         STEP 2 · RENCANA & KONTAK
    ══════════════════════════════════════════════════════ --}}
    <section>
        <div class="flex items-center gap-3 mb-6">
            <span class="w-9 h-9 rounded-full text-white text-sm font-extrabold flex items-center justify-center shadow-lg flex-shrink-0" style="background:#d97706">2</span>
            <h2 class="text-xl font-extrabold text-gray-800">Rencana Pernikahan &amp; Kontak</h2>
            <div class="flex-1 h-px bg-gray-300"></div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="rounded-2xl p-5" style="background:#fffbeb;border:1.5px solid #fde68a">
                    <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color:#92400e">📅 Tanggal Pernikahan <span class="text-red-500">*</span></p>
                    <input type="date" name="tanggal_pernikahan" value="{{ old('tanggal_pernikahan') }}"
                        class="w-full bg-white rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 transition-all {{ $errors->has('tanggal_pernikahan') ? 'ring-2 ring-red-400' : 'focus:ring-amber-400' }}"
                        style="border:1.5px solid #fde68a">
                    @error('tanggal_pernikahan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="rounded-2xl p-5" style="background:#fffbeb;border:1.5px solid #fde68a">
                    <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color:#92400e">⛪ Tempat Pernikahan <span class="text-red-500">*</span></p>
                    <input type="text" name="tempat_pernikahan" value="{{ old('tempat_pernikahan') }}" placeholder="Nama gereja / kapel"
                        class="w-full bg-white rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 transition-all {{ $errors->has('tempat_pernikahan') ? 'ring-2 ring-red-400' : 'focus:ring-amber-400' }}"
                        style="border:1.5px solid #fde68a">
                    @error('tempat_pernikahan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="rounded-2xl p-5" style="background:#f0f9ff;border:1.5px solid #bae6fd">
                    <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color:#075985">✉️ Alamat Email <span class="text-red-500">*</span></p>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com"
                        class="w-full bg-white rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 transition-all {{ $errors->has('email') ? 'ring-2 ring-red-400' : 'focus:ring-sky-400' }}"
                        style="border:1.5px solid #bae6fd">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="rounded-2xl p-5" style="background:#f0fdf4;border:1.5px solid #bbf7d0">
                    <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color:#14532d">📱 Nomor HP / WhatsApp <span class="text-red-500">*</span></p>
                    <input type="tel" name="nomor_hp" value="{{ old('nomor_hp') }}" placeholder="08xx-xxxx-xxxx"
                        class="w-full bg-white rounded-xl px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 transition-all {{ $errors->has('nomor_hp') ? 'ring-2 ring-red-400' : 'focus:ring-green-400' }}"
                        style="border:1.5px solid #bbf7d0">
                    @error('nomor_hp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════
         STEP 3 · UPLOAD DOKUMEN
    ══════════════════════════════════════════════════════ --}}
    <section>
        <div class="flex items-center gap-3 mb-6">
            <span class="w-9 h-9 rounded-full text-white text-sm font-extrabold flex items-center justify-center shadow-lg flex-shrink-0" style="background:#059669">3</span>
            <h2 class="text-xl font-extrabold text-gray-800">Upload Dokumen Pendukung</h2>
            <div class="flex-1 h-px bg-gray-300"></div>
        </div>

        <div class="rounded-xl px-5 py-3.5 flex items-center gap-3 mb-6" style="background:#ecfdf5;border:1.5px solid #6ee7b7">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="#059669" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm" style="color:#065f46">Format: <strong>JPG, PNG</strong> atau <strong>PDF</strong> · Maks. <strong>2 MB</strong> per file · Upload untuk kedua calon mempelai.</p>
        </div>

        <div class="space-y-5">

            {{-- ─── KTP ─── --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="flex items-center gap-4 px-6 py-4" style="background:#f5f3ff;border-bottom:1.5px solid #ede9fe">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0" style="background:#ede9fe">🪪</div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">KTP</h4>
                        <p class="text-xs text-gray-500">Kartu Tanda Penduduk</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 rounded-full" style="background:#ede9fe;color:#6d28d9">Wajib</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2" style="divide-color:#f3f4f6">
                    <div class="p-6" style="border-right:1.5px solid #f3f4f6">
                        <p class="text-xs font-bold mb-3" style="color:#1d4ed8">● Calon Pria</p>
                        <label id="lbl-ktp-pria" class="upload-zone" style="border-color:#bfdbfe;background:#eff6ff" onclick="return false">
                            <input type="file" name="ktp_pria" accept=".jpg,.jpeg,.png,.pdf" class="sr-only" onchange="picked(this,'ktp-pria')">
                            <div id="ktp-pria-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2" style="background:#dbeafe">
                                <svg class="w-6 h-6" fill="none" stroke="#3b82f6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <p id="ktp-pria-text" class="text-xs font-semibold" style="color:#2563eb">Klik untuk pilih file</p>
                            <p class="text-xs text-gray-400 mt-1">JPG · PNG · PDF</p>
                        </label>
                        @error('ktp_pria')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                    <div class="p-6">
                        <p class="text-xs font-bold mb-3" style="color:#be123c">● Calon Wanita</p>
                        <label id="lbl-ktp-wanita" class="upload-zone" style="border-color:#fecdd3;background:#fff1f2" onclick="return false">
                            <input type="file" name="ktp_wanita" accept=".jpg,.jpeg,.png,.pdf" class="sr-only" onchange="picked(this,'ktp-wanita')">
                            <div id="ktp-wanita-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2" style="background:#ffe4e6">
                                <svg class="w-6 h-6" fill="none" stroke="#f43f5e" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <p id="ktp-wanita-text" class="text-xs font-semibold" style="color:#e11d48">Klik untuk pilih file</p>
                            <p class="text-xs text-gray-400 mt-1">JPG · PNG · PDF</p>
                        </label>
                        @error('ktp_wanita')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ─── Surat Baptis ─── --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="flex items-center gap-4 px-6 py-4" style="background:#faf5ff;border-bottom:1.5px solid #e9d5ff">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0" style="background:#e9d5ff">✝️</div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">Surat Baptis</h4>
                        <p class="text-xs text-gray-500">Surat keterangan baptis dari paroki</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 rounded-full" style="background:#e9d5ff;color:#7e22ce">Wajib</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2" style="divide-color:#f3f4f6">
                    <div class="p-6" style="border-right:1.5px solid #f3f4f6">
                        <p class="text-xs font-bold mb-3" style="color:#1d4ed8">● Calon Pria</p>
                        <label id="lbl-baptis-pria" class="upload-zone" style="border-color:#bfdbfe;background:#eff6ff" onclick="return false">
                            <input type="file" name="surat_baptis_pria" accept=".jpg,.jpeg,.png,.pdf" class="sr-only" onchange="picked(this,'baptis-pria')">
                            <div id="baptis-pria-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2" style="background:#dbeafe">
                                <svg class="w-6 h-6" fill="none" stroke="#3b82f6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <p id="baptis-pria-text" class="text-xs font-semibold" style="color:#2563eb">Klik untuk pilih file</p>
                            <p class="text-xs text-gray-400 mt-1">JPG · PNG · PDF</p>
                        </label>
                        @error('surat_baptis_pria')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                    <div class="p-6">
                        <p class="text-xs font-bold mb-3" style="color:#be123c">● Calon Wanita</p>
                        <label id="lbl-baptis-wanita" class="upload-zone" style="border-color:#fecdd3;background:#fff1f2" onclick="return false">
                            <input type="file" name="surat_baptis_wanita" accept=".jpg,.jpeg,.png,.pdf" class="sr-only" onchange="picked(this,'baptis-wanita')">
                            <div id="baptis-wanita-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2" style="background:#ffe4e6">
                                <svg class="w-6 h-6" fill="none" stroke="#f43f5e" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <p id="baptis-wanita-text" class="text-xs font-semibold" style="color:#e11d48">Klik untuk pilih file</p>
                            <p class="text-xs text-gray-400 mt-1">JPG · PNG · PDF</p>
                        </label>
                        @error('surat_baptis_wanita')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ─── Surat Pengantar Kombas ─── --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="flex items-center gap-4 px-6 py-4" style="background:#f0fdf4;border-bottom:1.5px solid #bbf7d0">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0" style="background:#bbf7d0">📋</div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">Surat Pengantar Kombas</h4>
                        <p class="text-xs text-gray-500">Komisi Keluarga / Komisi Keagamaan</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 rounded-full" style="background:#bbf7d0;color:#14532d">Wajib</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2" style="divide-color:#f3f4f6">
                    <div class="p-6" style="border-right:1.5px solid #f3f4f6">
                        <p class="text-xs font-bold mb-3" style="color:#1d4ed8">● Calon Pria</p>
                        <label id="lbl-kombas-pria" class="upload-zone" style="border-color:#bfdbfe;background:#eff6ff" onclick="return false">
                            <input type="file" name="surat_pengantar_kombas_pria" accept=".jpg,.jpeg,.png,.pdf" class="sr-only" onchange="picked(this,'kombas-pria')">
                            <div id="kombas-pria-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2" style="background:#dbeafe">
                                <svg class="w-6 h-6" fill="none" stroke="#3b82f6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <p id="kombas-pria-text" class="text-xs font-semibold" style="color:#2563eb">Klik untuk pilih file</p>
                            <p class="text-xs text-gray-400 mt-1">JPG · PNG · PDF</p>
                        </label>
                        @error('surat_pengantar_kombas_pria')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                    <div class="p-6">
                        <p class="text-xs font-bold mb-3" style="color:#be123c">● Calon Wanita</p>
                        <label id="lbl-kombas-wanita" class="upload-zone" style="border-color:#fecdd3;background:#fff1f2" onclick="return false">
                            <input type="file" name="surat_pengantar_kombas_wanita" accept=".jpg,.jpeg,.png,.pdf" class="sr-only" onchange="picked(this,'kombas-wanita')">
                            <div id="kombas-wanita-icon" class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2" style="background:#ffe4e6">
                                <svg class="w-6 h-6" fill="none" stroke="#f43f5e" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <p id="kombas-wanita-text" class="text-xs font-semibold" style="color:#e11d48">Klik untuk pilih file</p>
                            <p class="text-xs text-gray-400 mt-1">JPG · PNG · PDF</p>
                        </label>
                        @error('surat_pengantar_kombas_wanita')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════
         STEP 4 · PEMBAYARAN
    ══════════════════════════════════════════════════════ --}}
    <section>
        <div class="flex items-center gap-3 mb-6">
            <span class="w-9 h-9 rounded-full text-white text-sm font-extrabold flex items-center justify-center shadow-lg flex-shrink-0" style="background:#7c3aed">4</span>
            <h2 class="text-xl font-extrabold text-gray-800">Pembayaran Pendaftaran</h2>
            <div class="flex-1 h-px bg-gray-300"></div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

            {{-- Info Biaya --}}
            <div class="px-6 py-5 flex items-center gap-4" style="background:linear-gradient(135deg,#7c3aed,#a855f7)">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-2xl flex-shrink-0">💳</div>
                <div>
                    <h3 class="text-white font-extrabold text-base">Informasi Biaya Kursus</h3>
                    <p class="text-purple-200 text-xs mt-0.5">Lakukan pembayaran sebelum mengirim formulir</p>
                </div>
            </div>

            {{-- Rincian biaya --}}
            <div class="p-6">
                <div class="rounded-2xl overflow-hidden mb-6" style="border:1.5px solid #e9d5ff">
                    <div class="grid grid-cols-2 text-sm" style="background:#faf5ff">
                        <div class="px-5 py-3 font-semibold text-gray-600 border-b" style="border-color:#e9d5ff">Keterangan</div>
                        <div class="px-5 py-3 font-semibold text-gray-600 border-b border-l" style="border-color:#e9d5ff">Jumlah</div>
                        <div class="px-5 py-3 text-gray-700 border-b" style="border-color:#e9d5ff">Biaya Kursus Pernikahan</div>
                        <div class="px-5 py-3 font-bold border-b border-l" style="color:#7c3aed;border-color:#e9d5ff">Rp 300.000</div>
                        <div class="px-5 py-3 text-gray-700 border-b" style="border-color:#e9d5ff">Materi &amp; Modul</div>
                        <div class="px-5 py-3 font-bold border-b border-l" style="color:#7c3aed;border-color:#e9d5ff">Rp 50.000</div>
                        <div class="px-5 py-3 font-extrabold text-gray-800" style="background:#f3e8ff">Total</div>
                        <div class="px-5 py-3 font-extrabold border-l text-lg" style="background:#f3e8ff;color:#7c3aed;border-color:#e9d5ff">Rp 350.000</div>
                    </div>
                </div>

                {{-- Rekening tujuan --}}
                <p class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-3">Rekening Tujuan Transfer</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
                    @foreach([
                        ['🏦','BRI','123-456-789-0','a.n. Biara Loresa SCJ'],
                        ['🏦','BCA','987-654-321-0','a.n. Biara Loresa SCJ'],
                        ['🏦','Mandiri','111-222-333-4','a.n. Biara Loresa SCJ'],
                    ] as [$icon,$bank,$rek,$an])
                    <div class="rounded-xl p-4 text-center" style="background:#faf5ff;border:1.5px solid #e9d5ff">
                        <p class="text-xl mb-1">{{ $icon }}</p>
                        <p class="font-extrabold text-gray-800 text-sm">{{ $bank }}</p>
                        <p class="font-mono font-bold mt-1 text-base" style="color:#7c3aed">{{ $rek }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $an }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Metode Pembayaran --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Metode Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <select name="metode_pembayaran"
                            class="w-full rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 transition-all {{ $errors->has('metode_pembayaran') ? 'ring-2 ring-red-400' : '' }}"
                            style="background:#faf5ff;border:1.5px solid #e9d5ff;focus:ring-purple-400">
                            <option value="">-- Pilih metode --</option>
                            <option value="Transfer BRI"     {{ old('metode_pembayaran')==='Transfer BRI'     ?'selected':'' }}>Transfer BRI</option>
                            <option value="Transfer BCA"     {{ old('metode_pembayaran')==='Transfer BCA'     ?'selected':'' }}>Transfer BCA</option>
                            <option value="Transfer Mandiri" {{ old('metode_pembayaran')==='Transfer Mandiri' ?'selected':'' }}>Transfer Mandiri</option>
                            <option value="Tunai"            {{ old('metode_pembayaran')==='Tunai'            ?'selected':'' }}>Tunai (bayar di tempat)</option>
                        </select>
                        @error('metode_pembayaran')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Upload Bukti --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Bukti Pembayaran <span class="text-gray-400 font-normal normal-case">(jika transfer)</span>
                        </label>
                        <label id="lbl-bukti" class="upload-zone" style="border-color:#e9d5ff;background:#faf5ff;padding:.85rem 1rem" onclick="return false">
                            <input type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf"
                                class="sr-only" onchange="picked(this,'bukti')">
                            <div id="bukti-icon" class="w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-1.5" style="background:#f3e8ff">
                                <svg class="w-5 h-5" fill="none" stroke="#9333ea" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                            </div>
                            <p id="bukti-text" class="text-xs font-semibold" style="color:#9333ea">Klik untuk pilih file</p>
                            <p class="text-xs text-gray-400 mt-0.5">JPG · PNG · PDF · maks. 2 MB</p>
                        </label>
                        @error('bukti_pembayaran')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="mt-4 rounded-xl flex items-start gap-3 px-4 py-3" style="background:#fef9c3;border:1.5px solid #fde68a">
                    <span class="text-lg flex-shrink-0">⚠️</span>
                    <p class="text-xs" style="color:#92400e">
                        Untuk pembayaran <strong>tunai</strong>, bukti pembayaran tidak perlu diunggah.
                        Pembayaran dapat dilakukan langsung di sekretariat Biara Loresa SCJ saat kursus berlangsung.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════
         TOMBOL KIRIM
    ══════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl shadow-lg px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-xs text-gray-400 text-center sm:text-left">
            🔒 Data bersifat rahasia dan hanya digunakan untuk keperluan kursus pernikahan Biara Loresa SCJ.
        </p>
        <button type="submit"
            class="w-full sm:w-auto flex items-center justify-center gap-2 text-white font-bold text-sm px-10 py-3.5 rounded-xl shadow-lg transition-all active:scale-95"
            style="background:linear-gradient(135deg,#2230ce,#3d56f5)">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
            </svg>
            Kirim Pendaftaran
        </button>
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
}
.upload-zone:hover { filter: brightness(.97); }
.upload-zone.done  { background:#f0fdf4 !important; border-color:#4ade80 !important; border-style:solid !important; }
</style>

<script>
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

    // re-attach input agar label click tetap bekerja
    lbl.onclick = null;
    lbl.querySelector('input').click;
}
document.querySelectorAll('.upload-zone').forEach(lbl => {
    lbl.onclick = () => lbl.querySelector('input[type=file]').click();
});
</script>

@endsection
