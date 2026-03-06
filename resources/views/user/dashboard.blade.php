@extends('layouts.app')
@section('title', 'Dashboard — Biara Loresa SCJ')

@section('content')
{{-- Header --}}
<section class="bg-white border-b border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-sm text-gray-500">Halo, <span class="font-medium text-gray-700">{{ $user->name }}</span></p>
                </div>
            </div>
            <form method="POST" action="{{ url('/logout') }}" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-sm font-medium hover:bg-gray-50 hover:border-gray-300 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</section>

<div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-800 text-sm border border-emerald-100">{{ session('success') }}</div>
    @endif

    @if($pendaftaranList->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-10 md:p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-800 mb-1">Belum ada pendaftaran</h2>
                <p class="text-gray-500 text-sm mb-6 max-w-sm mx-auto">Data pendaftaran kursus pernikahan untuk email ini belum ada.</p>
                <a href="{{ route('kursus-pernikahan') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary-600 text-white text-sm font-medium hover:bg-primary-700 transition-colors">
                    Daftar Kursus Pernikahan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    @else
        <p class="text-sm text-gray-500 mb-6">Data pendaftaran kursus pernikahan Anda.</p>
        <div class="space-y-4">
            @foreach($pendaftaranList as $p)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md hover:border-gray-200 transition-all">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-1.5">
                                    <span class="text-xs font-mono font-semibold text-primary-600 bg-primary-50 px-2.5 py-1 rounded-lg">#{{ str_pad($p->id, 6, '0', STR_PAD_LEFT) }}</span>
                                    @if($p->status_pembayaran === 'lunas')
                                        <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Lunas</span>
                                    @elseif($p->status_pembayaran === 'menunggu')
                                        <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">Menunggu</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-600">Belum Bayar</span>
                                    @endif
                                </div>
                                <h2 class="text-lg font-bold text-gray-900 truncate">{{ $p->nama_pria }} & {{ $p->nama_wanita }}</h2>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    {{ $p->tanggal_pernikahan->locale('id')->isoFormat('D MMMM YYYY') }} · {{ $p->tempat_pernikahan }}
                                </p>
                                @if($p->periode)
                                    <p class="text-xs text-gray-400 mt-1.5">Periode: {{ $p->periode->nama }}</p>
                                @endif
                            </div>
                            <a href="{{ route('kursus-pernikahan.sukses', $p->id) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-primary-600 text-white text-sm font-medium hover:bg-primary-700 transition-colors flex-shrink-0 w-full sm:w-auto">
                                Lihat Detail
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
