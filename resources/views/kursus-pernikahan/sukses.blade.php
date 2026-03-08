@extends('layouts.app')
@section('title', 'Pembayaran Berhasil - Kursus Pernikahan')

@section('content')
<style>
    /* Animasi */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes bounceIn { 0% { opacity: 0; transform: scale(0.3); } 70% { transform: scale(1.02); } 100% { opacity: 1; transform: scale(1); } }
    @keyframes checkDraw { 0% { stroke-dashoffset: 30; } 100% { stroke-dashoffset: 0; } }
    .anim-fade-up { animation: fadeInUp 0.5s ease-out forwards; }
    .delay-1 { animation-delay: 0.1s; opacity: 0; }
    .delay-2 { animation-delay: 0.2s; opacity: 0; }
    .delay-3 { animation-delay: 0.3s; opacity: 0; }
    .sukses-hero-icon { animation: bounceIn 0.6s ease-out forwards; opacity: 0; }
    .check-path { stroke-dasharray: 30; stroke-dashoffset: 30; animation: checkDraw 0.4s ease-out 0.2s forwards; }
    /* Tema */
    .sukses-hero-overlay { background: linear-gradient(160deg, rgba(30,38,133,0.92) 0%, rgba(61,86,245,0.78) 100%); }
    .card-header-primary { background: linear-gradient(135deg, #1e2685 0%, #3d56f5 100%); }
    .card-header-success { background: linear-gradient(135deg, #047857 0%, #059669 100%); }
    .ribbon-lunas { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
</style>

{{-- Hero ringkas --}}
<section class="relative py-16 md:py-20 flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop" alt="" class="w-full h-full object-cover">
        <div class="sukses-hero-overlay absolute inset-0"></div>
    </div>
    <div class="relative z-10 text-center text-white px-4 max-w-2xl mx-auto">
        <div class="sukses-hero-icon flex justify-center mb-5">
            <div class="w-20 h-20 bg-white/10 backdrop-blur rounded-full flex items-center justify-center border-2 border-amber-400/80">
                <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path class="check-path" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
        <p class="text-amber-400 font-semibold tracking-widest uppercase text-xs mb-2 anim-fade-up delay-1">Kursus Pernikahan</p>
        <h1 class="text-3xl md:text-4xl font-serif font-bold mb-2 leading-tight anim-fade-up delay-2">Pembayaran <span class="text-amber-400">Berhasil</span></h1>
        <p class="text-white/90 text-sm md:text-base anim-fade-up delay-3">Pendaftaran telah tercatat dan pembayaran kami terima.</p>
    </div>
</section>

{{-- Invoice & info login (format card) --}}
<section class="py-10 md:py-12 bg-gray-50">
    <div class="max-w-2xl mx-auto px-4">
        <h2 class="text-center text-lg font-semibold text-gray-800 mb-5">Invoice Pembayaran</h2>

        {{-- Card: kumpulan item invoice --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200/80 overflow-hidden mb-4">
            <div class="card-header-primary px-5 py-3.5 text-white font-semibold flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Invoice Pembayaran
                </span>
                @if($pendaftaran->status_pembayaran === 'lunas')
                <span class="ribbon-lunas px-3 py-1 text-xs font-bold uppercase rounded-lg">Lunas</span>
                @endif
            </div>
            <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-gray-500 text-xs font-medium uppercase tracking-wide mb-1">No. Invoice</p>
                    <p class="text-gray-800 font-mono text-sm break-all">{{ $pendaftaran->midtrans_order_id ?: 'KURSUS-' . $pendaftaran->id . '-' . $pendaftaran->created_at->timestamp }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-gray-500 text-xs font-medium uppercase tracking-wide mb-1">Tanggal</p>
                    <p class="text-gray-800 text-sm">{{ $pendaftaran->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-gray-500 text-xs font-medium uppercase tracking-wide mb-1">Total Pembayaran</p>
                    <p class="text-primary-600 font-semibold">Rp {{ number_format(350000, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p class="text-gray-500 text-xs font-medium uppercase tracking-wide mb-1">Status</p>
                    @if($pendaftaran->status_pembayaran === 'lunas')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Lunas</span>
                    @elseif($pendaftaran->status_pembayaran === 'menunggu')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">Menunggu</span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-600">Belum Bayar</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Card: informasi login --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200/80 overflow-hidden">
            <div class="card-header-success px-5 py-3.5 text-white font-semibold flex items-center gap-2">
                <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Informasi Login
            </div>
            <div class="p-4">
                <div class="bg-emerald-50/50 rounded-xl p-4 border border-emerald-100 flex items-start gap-3">
                    <span class="flex-shrink-0 w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <p class="text-gray-700 text-sm pt-1">Kami telah menginformasikan akun pendaftaran ke email yang terdaftar.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Langkah selanjutnya & CTA --}}
<section class="relative py-12 md:py-16 text-white overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop" alt="" class="w-full h-full object-cover">
        <div class="sukses-hero-overlay absolute inset-0"></div>
    </div>
    <div class="relative z-10 max-w-xl mx-auto px-4 text-center space-y-6">
        <h2 class="text-lg font-semibold">Langkah Selanjutnya</h2>
        <p class="text-white/95 text-sm leading-relaxed max-w-md mx-auto">Mohon tunggu konfirmasi dari admin melalui email dan WhatsApp yang telah terdaftar.</p>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-white text-primary-800 px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-gray-100 transition-colors shadow">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Beranda
        </a>
    </div>
</section>

@endsection
