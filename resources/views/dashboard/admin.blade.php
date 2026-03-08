@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data kursus pernikahan')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-serif font-bold text-white mb-2">Dashboard</h1>
    <p class="text-white/80 text-sm mb-4">Ringkasan data pendaftaran dan periode</p>
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-white/95 text-primary-800 px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-white transition-colors border border-white/30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Beranda
        </a>
        <a href="{{ route('kursus-pernikahan') }}" class="inline-flex items-center gap-2 bg-primary-700 text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-primary-800 transition-colors border border-white/20">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
            Kursus Pernikahan
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white/95 rounded-xl p-5 shadow-lg border border-white/20">
            <div class="text-3xl font-bold text-primary-800">{{ $totalPendaftaran }}</div>
            <div class="text-sm text-gray-600 mt-1">Total Pendaftaran</div>
        </div>
        <div class="bg-white/95 rounded-xl p-5 shadow-lg border border-white/20">
            <div class="text-3xl font-bold text-amber-600">{{ $pending }}</div>
            <div class="text-sm text-gray-600 mt-1">Pending</div>
        </div>
        <div class="bg-white/95 rounded-xl p-5 shadow-lg border border-white/20">
            <div class="text-3xl font-bold text-blue-600">{{ $proses }}</div>
            <div class="text-sm text-gray-600 mt-1">Proses</div>
        </div>
        <div class="bg-white/95 rounded-xl p-5 shadow-lg border border-white/20">
            <div class="text-3xl font-bold text-green-600">{{ $selesai }}</div>
            <div class="text-sm text-gray-600 mt-1">Selesai</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white/95 rounded-xl p-6 shadow-lg border border-white/20">
            <h2 class="font-serif font-bold text-lg text-gray-800 mb-4">Status Pendaftaran</h2>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Pending</span>
                    <span class="font-semibold">{{ $chartStatus['pending'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Proses</span>
                    <span class="font-semibold">{{ $chartStatus['proses'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Selesai</span>
                    <span class="font-semibold">{{ $chartStatus['selesai'] }}</span>
                </div>
            </div>
        </div>
        <div class="bg-white/95 rounded-xl p-6 shadow-lg border border-white/20">
            <h2 class="font-serif font-bold text-lg text-gray-800 mb-4">Status Pembayaran</h2>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Belum Bayar</span>
                    <span class="font-semibold">{{ $chartPembayaran['belum_bayar'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Sudah Bayar</span>
                    <span class="font-semibold">{{ $chartPembayaran['sudah_bayar'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex flex-wrap gap-4">
        <a href="{{ route('dashboard.pendaftaran.index') }}" class="bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-800 transition-colors">
            Lihat Pendaftaran
        </a>
        <a href="{{ route('dashboard.periode.index') }}" class="bg-white/90 text-primary-800 px-6 py-3 rounded-lg font-semibold hover:bg-white transition-colors border border-white/30">
            Manajemen Peserta
        </a>
        <a href="{{ route('dashboard.materi.periode-list') }}" class="bg-white/90 text-primary-800 px-6 py-3 rounded-lg font-semibold hover:bg-white transition-colors border border-white/30">
            Materi Kursus
        </a>
        <a href="{{ route('dashboard.kehadiran.periode-list') }}" class="bg-white/90 text-primary-800 px-6 py-3 rounded-lg font-semibold hover:bg-white transition-colors border border-white/30">
            Kehadiran
        </a>
    </div>
</div>
@endsection
