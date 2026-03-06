@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil - Biara Loresa SCJ')

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&display=swap" rel="stylesheet">
<style>
    .font-playfair { font-family: 'Playfair Display', Georgia, serif; }
    .font-cormorant { font-family: 'Cormorant Garamond', Georgia, serif; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(32px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @keyframes floatPetal {
        0%   { transform: translateY(0) rotate(0deg) translateX(0); opacity: 1; }
        50%  { transform: translateY(-50vh) rotate(180deg) translateX(30px); opacity: 0.8; }
        100% { transform: translateY(-100vh) rotate(360deg) translateX(-20px); opacity: 0; }
    }
    @keyframes ringBounce {
        0%, 100% { transform: translateY(0) rotate(-8deg); }
        50%       { transform: translateY(-8px) rotate(8deg); }
    }
    @keyframes drawLine {
        from { stroke-dashoffset: 300; }
        to   { stroke-dashoffset: 0; }
    }
    @keyframes glowPulse {
        0%, 100% { box-shadow: 0 0 20px rgba(212, 175, 118, 0.3), 0 0 40px rgba(212, 175, 118, 0.1); }
        50%       { box-shadow: 0 0 30px rgba(212, 175, 118, 0.5), 0 0 60px rgba(212, 175, 118, 0.2); }
    }
    @keyframes shimmerGold {
        0%   { background-position: -200% center; }
        100% { background-position: 200% center; }
    }

    .petal { position: fixed; pointer-events: none; animation: floatPetal linear forwards; z-index: 9999; }
    .animate-fade-up   { animation: fadeUp 0.7s cubic-bezier(.22,1,.36,1) both; }
    .animate-fade-in   { animation: fadeIn 0.8s ease both; }
    .animate-ring      { animation: ringBounce 3s ease-in-out infinite; }
    .animate-glow      { animation: glowPulse 3s ease-in-out infinite; }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-500 { animation-delay: 0.5s; }
    .delay-600 { animation-delay: 0.6s; }

    .gold-shimmer {
        background: linear-gradient(90deg, #b8860b, #d4af76, #f5e6a3, #d4af76, #b8860b);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmerGold 4s linear infinite;
    }

    .sukses-page-bg {
        background:
            radial-gradient(ellipse at 15% 0%,   rgba(252, 231, 243, 0.7) 0%, transparent 55%),
            radial-gradient(ellipse at 85% 5%,   rgba(237, 233, 254, 0.6) 0%, transparent 55%),
            radial-gradient(ellipse at 50% 100%, rgba(254, 243, 199, 0.5) 0%, transparent 60%),
            linear-gradient(160deg, #fefce8 0%, #fff1f2 40%, #f5f3ff 100%);
    }

    .couple-card {
        background: linear-gradient(135deg, #fff8f0 0%, #fff 50%, #fff8f5 100%);
        border: 1px solid rgba(212, 175, 118, 0.25);
    }

    .reg-banner {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4c1d95 80%, #6b21a8 100%);
        position: relative;
        overflow: hidden;
    }
    .reg-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .ornament-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #d4af76;
    }
    .ornament-divider::before,
    .ornament-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(212, 175, 118, 0.5), transparent);
    }

    .step-connector {
        position: absolute;
        left: 20px;
        top: 44px;
        bottom: -10px;
        width: 2px;
        background: linear-gradient(to bottom, rgba(212,175,118,0.6), rgba(212,175,118,0.1));
    }

    .data-row {
        display: flex;
        align-items: flex-start;
        padding: 14px 0;
        border-bottom: 1px solid rgba(212, 175, 118, 0.12);
    }
    .data-row:last-child { border-bottom: none; }

    .couple-name-display {
        background: linear-gradient(135deg, rgba(255,248,240,0.9), rgba(255,255,255,0.95), rgba(255,248,245,0.9));
    }

    .svg-check {
        stroke-dasharray: 300;
        stroke-dashoffset: 300;
        animation: drawLine 0.8s cubic-bezier(.22,1,.36,1) 0.4s forwards;
    }

    .check-circle {
        transform-origin: center;
        animation: fadeUp 0.5s ease 0.2s both;
    }

    .watermark-text {
        position: absolute;
        font-family: 'Playfair Display', serif;
        font-size: 10rem;
        font-weight: 700;
        color: rgba(212,175,118,0.04);
        pointer-events: none;
        user-select: none;
        white-space: nowrap;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-15deg);
    }
</style>
@endpush

@section('content')

<div id="petal-container" class="fixed inset-0 pointer-events-none z-50 overflow-hidden"></div>

<section class="sukses-page-bg min-h-[85vh] py-16 relative overflow-hidden">

    {{-- Background decorative circles --}}
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full opacity-20 pointer-events-none"
         style="background: radial-gradient(circle, #fbcfe8, transparent 70%)"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full opacity-20 pointer-events-none"
         style="background: radial-gradient(circle, #ddd6fe, transparent 70%)"></div>
    <div class="absolute top-1/3 -right-20 w-64 h-64 rounded-full opacity-10 pointer-events-none"
         style="background: radial-gradient(circle, #fde68a, transparent 70%)"></div>

    <div class="max-w-xl w-full mx-auto px-4 sm:px-6 relative z-10">

        {{-- ── HERO ── --}}
        <div class="text-center mb-10 animate-fade-up">

            {{-- Rings decoration --}}
            <div class="flex items-center justify-center gap-3 mb-6">
                <span class="text-3xl animate-ring" style="animation-delay: 0s; display:inline-block;">💍</span>
                <div class="check-circle relative w-20 h-20 flex-shrink-0">
                    <div class="absolute inset-0 rounded-full animate-glow"
                         style="background: linear-gradient(135deg, #d4af76, #b8860b);">
                    </div>
                    <div class="relative w-full h-full rounded-full flex items-center justify-center"
                         style="background: linear-gradient(135deg, #c9954a 0%, #d4af76 50%, #f0d090 100%);">
                        <svg class="w-10 h-10" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.5"
                             stroke-linecap="round" stroke-linejoin="round">
                            <polyline class="svg-check" points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                </div>
                <span class="text-3xl animate-ring" style="animation-delay: 0.4s; display:inline-block;">💍</span>
            </div>

            <h1 class="font-playfair text-4xl md:text-5xl font-bold mb-3 gold-shimmer tracking-wide">
                Pendaftaran Berhasil
            </h1>
            <p class="font-cormorant text-xl text-slate-500 italic tracking-wide">
                Selamat! Perjalanan indah Anda dimulai di sini.
            </p>
        </div>

        {{-- ── REGISTRATION NUMBER BANNER ── --}}
        <div class="animate-fade-up delay-100 mb-6">
            <div class="reg-banner rounded-2xl p-6 text-center shadow-xl animate-glow">
                <p class="text-purple-300 text-xs font-semibold uppercase tracking-[0.2em] mb-2">Nomor Pendaftaran</p>
                <p class="font-playfair text-white text-5xl font-bold tracking-widest mb-3">
                    #{{ str_pad($pendaftaran->id, 6, '0', STR_PAD_LEFT) }}
                </p>
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-5 py-2">
                    <span class="w-2 h-2 rounded-full bg-amber-300 animate-pulse flex-shrink-0"></span>
                    <span class="text-amber-200 text-sm font-medium">Menunggu Konfirmasi</span>
                </div>
                <div class="mt-3 h-px" style="background: linear-gradient(90deg, transparent, rgba(212,175,118,0.5), transparent)"></div>
                <p class="text-purple-300/70 text-xs mt-3 font-light">Tim kami akan segera menghubungi Anda</p>
            </div>
        </div>

        {{-- ── COUPLE NAMES DISPLAY ── --}}
        <div class="animate-fade-up delay-200 mb-6">
            <div class="couple-card rounded-2xl shadow-md overflow-hidden">
                <div class="couple-name-display px-6 py-8 text-center">
                    <div class="ornament-divider mb-5 mx-4">
                        <span class="font-playfair text-xs tracking-[0.3em] text-amber-600 uppercase">Calon Pengantin</span>
                    </div>

                    <div class="flex items-center justify-center gap-4 flex-wrap">
                        <div class="text-center">
                            <div class="w-12 h-12 rounded-full bg-blue-50 border-2 border-blue-100 flex items-center justify-center mx-auto mb-2">
                                <span class="text-xl">👤</span>
                            </div>
                            <p class="font-playfair text-2xl font-semibold text-slate-800 capitalize">{{ $pendaftaran->nama_pria }}</p>
                            <p class="text-xs text-blue-400 font-medium tracking-widest uppercase mt-1">Pria</p>
                        </div>

                        <div class="flex flex-col items-center gap-1 px-2">
                            <div class="text-amber-400 text-xl">✦</div>
                            <span class="font-cormorant text-3xl italic text-amber-500 font-light">&amp;</span>
                            <div class="text-amber-400 text-xl">✦</div>
                        </div>

                        <div class="text-center">
                            <div class="w-12 h-12 rounded-full bg-pink-50 border-2 border-pink-100 flex items-center justify-center mx-auto mb-2">
                                <span class="text-xl">👤</span>
                            </div>
                            <p class="font-playfair text-2xl font-semibold text-slate-800 capitalize">{{ $pendaftaran->nama_wanita }}</p>
                            <p class="text-xs text-pink-400 font-medium tracking-widest uppercase mt-1">Wanita</p>
                        </div>
                    </div>

                    <div class="ornament-divider mt-5 mx-4">
                        <span class="text-amber-400 text-sm">⛪</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── DETAIL PENDAFTARAN ── --}}
        <div class="animate-fade-up delay-300 mb-6">
            <div class="bg-white rounded-2xl shadow-md border border-amber-50 overflow-hidden">

                <div class="px-6 py-4 border-b border-amber-50"
                     style="background: linear-gradient(135deg, #fffbf0, #fff9f5)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background: linear-gradient(135deg, #d4af76, #b8860b)">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <p class="font-playfair font-semibold text-slate-700">Ringkasan Pendaftaran</p>
                    </div>
                </div>

                <div class="px-6 divide-y divide-amber-50/80">
                    <div class="data-row gap-4">
                        <span class="w-8 text-center flex-shrink-0 text-lg mt-0.5">📅</span>
                        <div>
                            <p class="text-xs text-slate-400 font-medium tracking-wide uppercase mb-0.5">Rencana Pernikahan</p>
                            <p class="font-semibold text-slate-700">{{ $pendaftaran->tanggal_pernikahan->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="data-row gap-4">
                        <span class="w-8 text-center flex-shrink-0 text-lg mt-0.5">⛪</span>
                        <div>
                            <p class="text-xs text-slate-400 font-medium tracking-wide uppercase mb-0.5">Tempat Pernikahan</p>
                            <p class="font-semibold text-slate-700">{{ $pendaftaran->tempat_pernikahan }}</p>
                        </div>
                    </div>
                    <div class="data-row gap-4">
                        <span class="w-8 text-center flex-shrink-0 text-lg mt-0.5">✉️</span>
                        <div>
                            <p class="text-xs text-slate-400 font-medium tracking-wide uppercase mb-0.5">Email Kontak</p>
                            <p class="font-semibold text-slate-700 break-all">{{ $pendaftaran->email }}</p>
                        </div>
                    </div>
                    <div class="data-row gap-4">
                        <span class="w-8 text-center flex-shrink-0 text-lg mt-0.5">📱</span>
                        <div>
                            <p class="text-xs text-slate-400 font-medium tracking-wide uppercase mb-0.5">Nomor WhatsApp</p>
                            <p class="font-semibold text-slate-700">{{ $pendaftaran->nomor_hp }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── LANGKAH SELANJUTNYA ── --}}
        <div class="animate-fade-up delay-400 mb-8">
            <div class="bg-white rounded-2xl shadow-md border border-amber-50 overflow-hidden">

                <div class="px-6 py-4 border-b border-amber-50"
                     style="background: linear-gradient(135deg, #fffbf0, #fff9f5)">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background: linear-gradient(135deg, #d4af76, #b8860b)">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <p class="font-playfair font-semibold text-slate-700">Langkah Selanjutnya</p>
                    </div>
                </div>

                <div class="px-6 py-5">
                    <div class="space-y-5">
                        @php
                        $steps = [
                            [
                                'icon' => '📞',
                                'text' => 'Tim sekretariat kami akan menghubungi Anda dalam <strong class="text-amber-700">3–5 hari kerja</strong> via email atau WhatsApp untuk konfirmasi jadwal kursus.',
                            ],
                            [
                                'icon' => '📋',
                                'text' => 'Siapkan dokumen <strong class="text-amber-700">asli dan fotokopi</strong>: KTP, Surat Baptis, dan Surat Pengantar Kombas untuk diserahkan saat pelaksanaan kursus.',
                            ],
                            [
                                'icon' => '🔖',
                                'text' => 'Simpan nomor pendaftaran <strong class="text-amber-700">#'. str_pad($pendaftaran->id, 6, '0', STR_PAD_LEFT) .'</strong> sebagai referensi. Ada pertanyaan? <a href="'. route('kontak') .'" class="text-indigo-600 font-semibold underline decoration-dotted hover:text-indigo-800">Hubungi kami</a>.',
                            ],
                        ];
                        @endphp

                        @foreach($steps as $i => $step)
                        <div class="flex items-start gap-4">
                            <div class="relative flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-base shadow-sm border border-amber-100"
                                     style="background: linear-gradient(135deg, #fffbf0, #fef3c7);">
                                    {{ $step['icon'] }}
                                </div>
                                <div class="absolute -top-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-white text-xs font-bold"
                                     style="background: linear-gradient(135deg, #d4af76, #b8860b); font-size: 10px;">
                                    {{ $i + 1 }}
                                </div>
                            </div>
                            <p class="text-sm text-slate-600 leading-relaxed pt-2">{!! $step['text'] !!}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ── ACTION BUTTONS ── --}}
        <div class="animate-fade-up delay-500 flex flex-col sm:flex-row gap-3 justify-center mb-12">
            <a href="{{ route('kursus-pernikahan') }}"
               class="group inline-flex items-center justify-center gap-2 border-2 py-3 px-8 rounded-xl font-semibold text-sm transition-all duration-300 hover:shadow-lg"
               style="border-color: #d4af76; color: #92740e; background: transparent;"
               onmouseover="this.style.background='linear-gradient(135deg,#fffbf0,#fef3c7)'"
               onmouseout="this.style.background='transparent'">
                <svg class="w-4 h-4 transition-transform group-hover:rotate-90 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Daftar Lagi
            </a>
            <a href="{{ route('home') }}"
               class="group inline-flex items-center justify-center gap-2 text-white py-3 px-8 rounded-xl font-semibold text-sm transition-all duration-300 hover:shadow-xl hover:scale-[1.03]"
               style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%);">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        {{-- ── QUOTE ── --}}
        <div class="animate-fade-up delay-600 text-center pb-4">
            <div class="ornament-divider mb-4 mx-8">
                <span class="text-amber-300 text-base">✦</span>
            </div>
            <p class="font-cormorant text-slate-500 text-xl italic leading-relaxed">
                "Apa yang telah dipersatukan Allah,<br>janganlah diceraikan manusia."
            </p>
            <p class="text-slate-400 text-xs mt-2 tracking-widest uppercase font-medium">— Markus 10:9</p>
        </div>

    </div>
</section>

@push('scripts')
<script>
(function () {
    const petals = ['🌸','🌺','✿','❀','🌷','💐'];
    const container = document.getElementById('petal-container');

    function spawnPetal() {
        const el = document.createElement('div');
        el.classList.add('petal');
        const petal = petals[Math.floor(Math.random() * petals.length)];
        el.textContent = petal;
        const size = 14 + Math.random() * 14;
        const left = 5 + Math.random() * 90;
        const delay = Math.random() * 3;
        const duration = 4 + Math.random() * 4;
        el.style.cssText = `
            font-size: ${size}px;
            left: ${left}%;
            bottom: -40px;
            animation-delay: ${delay}s;
            animation-duration: ${duration}s;
            opacity: 0.85;
        `;
        container.appendChild(el);
        setTimeout(() => el.remove(), (delay + duration + 0.5) * 1000);
    }

    for (let i = 0; i < 30; i++) spawnPetal();
    setTimeout(() => { for (let i = 0; i < 20; i++) spawnPetal(); }, 2000);
    setTimeout(() => { for (let i = 0; i < 15; i++) spawnPetal(); }, 5000);
})();
</script>
@endpush

@endsection
