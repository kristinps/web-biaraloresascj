@extends('layouts.app')
@section('title', 'Pembayaran Berhasil - Kursus Pernikahan')

@section('content')
<style>
    /* ─── Keyframes ─── */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(24px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.85); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes bounceIn {
        0% { opacity: 0; transform: scale(0.3); }
        50% { transform: scale(1.05); }
        70% { transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }
    @keyframes pulse-soft {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.03); opacity: 0.95; }
    }
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    @keyframes checkmark-draw {
        0% { stroke-dashoffset: 30; }
        100% { stroke-dashoffset: 0; }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes glow {
        0%, 100% { box-shadow: 0 8px 24px rgba(34,197,94,0.35); }
        50% { box-shadow: 0 8px 32px rgba(34,197,94,0.55); }
    }
    @keyframes glow-white {
        0%, 100% { box-shadow: 0 0 0 0 rgba(255,255,255,0.3); }
        50% { box-shadow: 0 0 24px 8px rgba(255,255,255,0.2); }
    }
    @keyframes dot-pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(1.2); }
    }

    /* ─── Kelas animasi (stagger) ─── */
    .anim-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
    .anim-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    .anim-scale-in { animation: scaleIn 0.5s ease-out forwards; }
    .anim-bounce-in { animation: bounceIn 0.7s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards; }
    .anim-slide-left { animation: slideInLeft 0.5s ease-out forwards; }
    .anim-slide-right { animation: slideInRight 0.5s ease-out forwards; }

    .anim-delay-1 { animation-delay: 0.1s; opacity: 0; }
    .anim-delay-2 { animation-delay: 0.2s; opacity: 0; }
    .anim-delay-3 { animation-delay: 0.3s; opacity: 0; }
    .anim-delay-4 { animation-delay: 0.4s; opacity: 0; }
    .anim-delay-5 { animation-delay: 0.5s; opacity: 0; }
    .anim-delay-6 { animation-delay: 0.6s; opacity: 0; }
    .anim-delay-7 { animation-delay: 0.7s; opacity: 0; }
    .anim-delay-8 { animation-delay: 0.8s; opacity: 0; }
    .anim-delay-9 { animation-delay: 0.9s; opacity: 0; }
    .anim-delay-10 { animation-delay: 1s; opacity: 0; }
    .anim-delay-11 { animation-delay: 1.1s; opacity: 0; }
    .anim-delay-12 { animation-delay: 1.2s; opacity: 0; }

    .sukses-icon-wrap {
        animation: bounceIn 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards,
                   pulse-soft 2s ease-in-out 1s infinite;
    }
    .sukses-icon-glow {
        animation: glow 2s ease-in-out infinite;
    }
    .check-path {
        stroke-dasharray: 30;
        stroke-dashoffset: 30;
        animation: checkmark-draw 0.6s ease-out 0.4s forwards;
    }
    .float-slow { animation: float 3s ease-in-out infinite; }
    .btn-hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    }
    .status-dot {
        animation: dot-pulse 1.5s ease-in-out infinite;
    }
    .row-reveal { opacity: 0; }
    .row-reveal.animate { animation: fadeInUp 0.4s ease-out forwards; }
</style>
{{-- Hero (tema beranda) --}}
<section class="relative py-16 md:py-20 overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop" alt="" class="w-full h-full object-cover">
        <div class="hero-overlay absolute inset-0"></div>
    </div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 text-center text-white">
        <div class="opacity-0 sukses-icon-wrap flex justify-center mb-5">
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-2 border-white/50" style="animation: glow-white 2s ease-in-out infinite;">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path class="check-path" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>
        <p class="text-gold-400 font-semibold tracking-widest uppercase text-sm mb-2 anim-fade-in-up anim-delay-1">Kursus Pernikahan</p>
        <h1 class="text-4xl md:text-5xl font-serif font-bold mb-3 anim-fade-in-up anim-delay-2">
            Pembayaran <span class="text-gold-400">Berhasil</span>
        </h1>
        <p class="text-lg text-white/90 max-w-xl mx-auto anim-fade-in-up anim-delay-3">
            Pendaftaran kursus pernikahan Anda telah tercatat. Konfirmasi dan jadwal akan dikirim ke email dan WhatsApp.
        </p>
    </div>
</section>

{{-- Konten: Invoice, Data, Akun --}}
<section class="py-12 md:py-16 bg-gray-50/80">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <p class="text-primary-600 font-semibold tracking-widest uppercase text-xs mb-1.5">Bukti Pendaftaran</p>
            <h2 class="text-2xl font-serif font-bold text-gray-800 mb-1">Invoice &amp; Data Pendaftaran</h2>
            <p class="text-gray-500 text-sm">Simpan informasi berikut sebagai arsip</p>
        </div>

        <div class="space-y-5">
            {{-- Card Invoice --}}
            <div class="rounded-2xl overflow-hidden bg-white shadow-sm border border-gray-100 card-hover anim-fade-in-up anim-delay-4">
                <div class="px-6 py-4 bg-gradient-to-r from-primary-700 to-primary-600 text-white">
                    <h3 class="font-semibold text-sm flex items-center gap-2"><span>📋</span> Invoice Pembayaran</h3>
                </div>
                <div class="divide-y divide-gray-50">
                    <div class="flex items-center justify-between px-6 py-3.5 row-reveal" data-delay="0">
                        <span class="text-sm text-gray-500">No. Invoice</span>
                        <span class="text-sm font-semibold text-gray-800 font-mono">{{ $pendaftaran->midtrans_order_id ?: 'INV-' . str_pad($pendaftaran->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex items-center justify-between px-6 py-3.5 row-reveal" data-delay="1">
                        <span class="text-sm text-gray-500">Tanggal</span>
                        <span class="text-sm font-medium text-gray-800">{{ $pendaftaran->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                    </div>
                    <div class="flex items-center justify-between px-6 py-3.5 row-reveal" data-delay="2">
                        <span class="text-sm text-gray-500">Total Pembayaran</span>
                        <span class="text-lg font-bold text-primary-600">Rp 350.000</span>
                    </div>
                    <div class="flex items-center justify-between px-6 py-3.5 row-reveal" data-delay="3">
                        <span class="text-sm text-gray-500">Status</span>
                        @if($pendaftaran->status_pembayaran === 'lunas')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 status-dot"></span> Lunas
                        </span>
                        @elseif($pendaftaran->status_pembayaran === 'menunggu')
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">Menunggu</span>
                        @else
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-600">Belum Bayar</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Card Data Pendaftaran --}}
            <div class="rounded-2xl overflow-hidden bg-white shadow-sm border border-gray-100 card-hover anim-fade-in-up anim-delay-6">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-semibold text-gray-800">Data Pendaftaran</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Ringkasan data yang terdaftar</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="row-reveal" data-delay="0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-primary-600 mb-1">Calon Mempelai</p>
                        <p class="font-medium text-gray-800">{{ $pendaftaran->nama_pria }} &amp; {{ $pendaftaran->nama_wanita }}</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="row-reveal" data-delay="1">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Email</p>
                            <p class="text-sm text-gray-800">{{ $pendaftaran->email }}</p>
                        </div>
                        <div class="row-reveal" data-delay="2">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">No. HP / WhatsApp</p>
                            <p class="text-sm text-gray-800">{{ $pendaftaran->nomor_hp }}</p>
                        </div>
                    </div>
                    <div class="row-reveal" data-delay="3">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Tanggal Pernikahan</p>
                        <p class="text-sm text-gray-800">{{ $pendaftaran->tanggal_pernikahan?->translatedFormat('d F Y') ?? '-' }}</p>
                    </div>
                    <div class="row-reveal" data-delay="4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Tempat Pernikahan</p>
                        <p class="text-sm text-gray-800">{{ $pendaftaran->tempat_pernikahan ?? '-' }}</p>
                    </div>
                    @if($pendaftaran->periode)
                    <div class="pt-4 border-t border-gray-100 row-reveal" data-delay="5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Periode Kursus</p>
                        <p class="text-sm text-gray-800">{{ $pendaftaran->periode->nama ?? $pendaftaran->periode->tanggal_mulai?->translatedFormat('F Y') ?? 'Periode ' . $pendaftaran->periode_id }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Card Informasi Akun --}}
            <div class="rounded-2xl overflow-hidden bg-white shadow-sm border border-emerald-100 card-hover anim-fade-in-up anim-delay-7">
                <div class="px-6 py-4 border-b border-emerald-100 bg-emerald-50/50">
                    <h3 class="font-semibold text-gray-800">Informasi Akun Login</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Gunakan untuk akses dashboard peserta</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="row-reveal" data-delay="0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700 mb-1">Email login</p>
                        <p class="text-sm font-medium text-gray-800 font-mono">{{ $pendaftaran->email }}</p>
                    </div>
                    @if($akun_password)
                    <div class="row-reveal" data-delay="1">
                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700 mb-1">Kata sandi</p>
                        <p class="text-sm font-semibold text-gray-800 font-mono tracking-wide bg-gray-50 px-3 py-2 rounded-xl border border-gray-100">{{ $akun_password }}</p>
                        <p class="text-xs text-gray-500 mt-1.5">Simpan kata sandi ini. Juga telah dikirim ke email Anda.</p>
                    </div>
                    @else
                    <div class="row-reveal" data-delay="1">
                        <p class="text-sm text-gray-600">Kata sandi telah dikirim ke email Anda saat pendaftaran.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-12 md:py-16 bg-gradient-to-br from-primary-800 via-primary-700 to-primary-600 text-white">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <h2 class="text-2xl md:text-3xl font-serif font-bold mb-2 anim-fade-in anim-delay-9">Langkah Selanjutnya</h2>
        <p class="text-white/80 text-sm md:text-base mb-8 max-w-md mx-auto">
            Konfirmasi dan jadwal kursus akan dikirim ke email dan WhatsApp Anda.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}" class="btn-hover-lift bg-white text-primary-800 px-6 py-3 rounded-xl font-semibold text-sm hover:bg-gray-50 transition-all inline-flex items-center justify-center gap-2 anim-scale-in anim-delay-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <a href="{{ url('/dashboard') }}" class="btn-hover-lift border-2 border-white/50 text-white px-6 py-3 rounded-xl font-semibold text-sm hover:bg-white/10 transition-all inline-flex items-center justify-center gap-2 anim-scale-in anim-delay-11">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Dashboard
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var rows = document.querySelectorAll('.row-reveal');
    rows.forEach(function(el, i) {
        var delay = parseInt(el.getAttribute('data-delay') || 0, 10) * 80;
        setTimeout(function() {
            el.classList.add('animate');
        }, 600 + delay);
    });
});
</script>
@endsection
