@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil - Biara Loresa SCJ')

@section('content')

<section class="min-h-[70vh] flex items-center justify-center py-16 bg-gray-50">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        {{-- Success Icon --}}
        <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-6">
            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h1 class="text-3xl md:text-4xl font-serif font-bold text-gray-800 mb-3">Pendaftaran Berhasil!</h1>
        <p class="text-gray-500 mb-8 text-lg">Terima kasih, pendaftaran kursus pernikahan Anda telah kami terima.</p>

        {{-- Summary Card --}}
        <div class="bg-white rounded-2xl shadow-md p-8 text-left space-y-5 mb-8">
            <h2 class="text-lg font-bold text-gray-700 border-b border-gray-100 pb-3">Ringkasan Pendaftaran</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400 font-medium mb-0.5">Nomor Pendaftaran</p>
                    <p class="font-bold text-primary-700 text-lg">#{{ str_pad($pendaftaran->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div>
                    <p class="text-gray-400 font-medium mb-0.5">Status</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                        Menunggu Konfirmasi
                    </span>
                </div>
                <div>
                    <p class="text-gray-400 font-medium mb-0.5">Calon Mempelai Pria</p>
                    <p class="font-semibold text-gray-800">{{ $pendaftaran->nama_pria }}</p>
                </div>
                <div>
                    <p class="text-gray-400 font-medium mb-0.5">Calon Mempelai Wanita</p>
                    <p class="font-semibold text-gray-800">{{ $pendaftaran->nama_wanita }}</p>
                </div>
                <div>
                    <p class="text-gray-400 font-medium mb-0.5">Rencana Pernikahan</p>
                    <p class="font-semibold text-gray-800">{{ $pendaftaran->tanggal_pernikahan->translatedFormat('d F Y') ?? $pendaftaran->tanggal_pernikahan->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-400 font-medium mb-0.5">Tempat Pernikahan</p>
                    <p class="font-semibold text-gray-800">{{ $pendaftaran->tempat_pernikahan }}</p>
                </div>
                <div>
                    <p class="text-gray-400 font-medium mb-0.5">Email Kontak</p>
                    <p class="font-semibold text-gray-800">{{ $pendaftaran->email }}</p>
                </div>
                <div>
                    <p class="text-gray-400 font-medium mb-0.5">Nomor HP</p>
                    <p class="font-semibold text-gray-800">{{ $pendaftaran->nomor_hp }}</p>
                </div>
            </div>
        </div>

        {{-- Next Steps --}}
        <div class="bg-primary-50 border border-primary-100 rounded-2xl p-6 text-left mb-8">
            <h3 class="font-bold text-primary-800 mb-3 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Langkah Selanjutnya</span>
            </h3>
            <ol class="space-y-2 text-sm text-primary-700 list-decimal list-inside">
                <li>Tim sekretariat kami akan menghubungi Anda dalam <strong>3–5 hari kerja</strong> via email atau WhatsApp.</li>
                <li>Harap simpan nomor pendaftaran Anda sebagai referensi komunikasi.</li>
                <li>Jika ada pertanyaan, silakan hubungi kami melalui halaman <a href="{{ route('kontak') }}" class="underline font-semibold">Kontak</a>.</li>
            </ol>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('kursus-pernikahan') }}"
                class="inline-flex items-center justify-center space-x-2 border border-primary-600 text-primary-700 py-3 px-6 rounded-xl font-semibold hover:bg-primary-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Daftar Lagi</span>
            </a>
            <a href="{{ route('home') }}"
                class="inline-flex items-center justify-center space-x-2 bg-primary-700 text-white py-3 px-6 rounded-xl font-semibold hover:bg-primary-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </div>
</section>

@endsection
