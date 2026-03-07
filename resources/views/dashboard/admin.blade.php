@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data kursus pernikahan')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-serif font-bold text-white mb-2">Dashboard</h1>
    <p class="text-white/80 text-sm mb-8">Ringkasan data pendaftaran dan periode</p>

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

    <div class="mt-6 flex gap-4">
        <a href="{{ route('dashboard.pendaftaran.index') }}" class="bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-800 transition-colors">
            Lihat Pendaftaran
        </a>
        <a href="{{ route('dashboard.periode.index') }}" class="bg-white/90 text-primary-800 px-6 py-3 rounded-lg font-semibold hover:bg-white transition-colors border border-white/30">
            Manajemen Peserta
        </a>
    </div>
</div>
@endsection
