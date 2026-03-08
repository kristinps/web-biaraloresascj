@extends('layouts.dashboard')

@section('title', 'Dashboard Peserta')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Pesan dan informasi dari admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-serif font-bold text-white mb-2">Dashboard</h1>
    <p class="text-white/80 text-sm mb-4">Pesan masuk dan informasi dari admin / super admin</p>
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-white/95 text-primary-800 px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-white transition-colors border border-white/30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Beranda
        </a>
        <a href="{{ route('kursus-pernikahan') }}" class="inline-flex items-center gap-2 bg-primary-700 text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-primary-800 transition-colors border border-white/20">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
            Kursus Pernikahan
        </a>
    </div>

    <div class="bg-white/95 rounded-xl shadow-lg border border-white/20 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-serif font-bold text-gray-800">Pesan Masuk</h2>
            <p class="text-sm text-gray-500 mt-0.5">Semua pemberitahuan dari admin</p>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($pesan as $p)
                <div class="px-6 py-4 {{ $p->dibaca_at ? '' : 'bg-primary-50/50' }}">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-800">{{ $p->judul }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($p->isi, 200) }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ $p->created_at->locale('id')->diffForHumans() }}</p>
                        </div>
                        @if(!$p->dibaca_at)
                            <span class="flex-shrink-0 px-2 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">Baru</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-500">
                    <p>Belum ada pesan.</p>
                </div>
            @endforelse
        </div>
        @if($pesan->hasPages())
            <div class="px-6 py-3 border-t border-gray-100">
                {{ $pesan->links() }}
            </div>
        @endif
    </div>

    @if($pendaftaran->isNotEmpty())
    <div class="mt-8 bg-white/95 rounded-xl shadow-lg border border-white/20 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-serif font-bold text-gray-800">Status Pendaftaran Anda</h2>
        </div>
        <ul class="divide-y divide-gray-100">
            @foreach($pendaftaran->take(5) as $p)
                <li class="px-6 py-3 flex justify-between items-center">
                    <span class="font-medium text-gray-800">{{ $p->nama_pria }} & {{ $p->nama_wanita }}</span>
                    <span class="text-sm text-gray-500">{{ $p->periode?->nama ?? '—' }} · {{ $p->status }}</span>
                </li>
            @endforeach
        </ul>
        <div class="px-6 py-3 border-t border-gray-100">
            <a href="{{ route('dashboard.user.status-pendaftaran') }}" class="text-primary-700 font-semibold text-sm hover:underline">Lihat semua →</a>
        </div>
    </div>
    @endif
</div>
@endsection
