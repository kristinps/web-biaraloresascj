@extends('layouts.app')
@section('title', 'Sesi Habis - Biara Loresa SCJ')
@section('content')

<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="max-w-lg w-full text-center">
        {{-- Icon & pesan --}}
        <div class="rounded-3xl p-8 sm:p-10 shadow-2xl border border-gray-200/80" style="background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);">
            <div class="w-20 h-20 mx-auto rounded-2xl flex items-center justify-center mb-6" style="background: linear-gradient(135deg, #fef3c7, #fde68a);">
                <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-2">Sesi Habis</h1>
            <p class="text-gray-600 text-sm sm:text-base leading-relaxed mb-6">
                Halaman atau formulir yang Anda isi sudah tidak valid (token kedaluwarsa). Ini sering terjadi jika halaman dibiarkan terbuka terlalu lama. Silakan muat ulang halaman dan isi formulir kembali.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('kursus-pernikahan') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-semibold text-white shadow-lg transition transform hover:scale-[1.02] active:scale-[0.98]" style="background: linear-gradient(135deg, #1e2685, #7c3aed, #be185d);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    Formulir Kursus Pernikahan
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-semibold text-gray-700 bg-white border-2 border-gray-300 hover:border-primary-500 hover:text-primary-700 transition">
                    Beranda
                </a>
            </div>
        </div>
        <p class="mt-6 text-xs text-gray-500">
            Jika masalah berulang, coba gunakan jendela atau tab baru dan isi formulir tanpa menunda terlalu lama.
        </p>
    </div>
</div>

@endsection
