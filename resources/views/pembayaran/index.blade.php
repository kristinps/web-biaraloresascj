@extends('layouts.app')

@section('title', 'Pembayaran QRIS - Kursus Pernikahan')

@section('content')
<div class="min-h-screen py-12 px-4" style="background:linear-gradient(135deg,#f0f4ff 0%,#fff0f6 100%)">
    <div class="max-w-md mx-auto">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4 shadow-lg"
                 style="background:linear-gradient(135deg,#1e2685,#be185d)">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.24M16.24 12l1.07-1.07M12 12l-1.07 1.07M12 12V8.93"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-1">Pembayaran QRIS</h1>
            <p class="text-gray-500 text-sm">Kursus Pernikahan · Biara Loresa SCJ</p>
        </div>

        {{-- Alert error --}}
        @if(session('error'))
        <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="text-red-700 text-sm">{{ session('error') }}</p>
        </div>
        @endif

        @if(isset($qris_error) && $qris_error)
        <div class="mb-5 p-4 bg-amber-50 border border-amber-200 rounded-2xl">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-amber-800 text-sm flex-1">{{ $qris_error }}</p>
            </div>
            <a href="{{ route('pembayaran.show', $pendaftaran->id) }}"
               class="mt-3 inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl font-semibold text-sm transition-all active:scale-[0.98]"
               style="background:linear-gradient(135deg,#1e2685,#be185d);color:white;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Coba lagi
            </a>
        </div>
        @endif

        {{-- Card utama --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

            {{-- Gradient top bar --}}
            <div class="h-1.5" style="background:linear-gradient(90deg,#1e2685,#7c3aed,#be185d)"></div>

            <div class="p-6">

                {{-- Info pendaftar --}}
                <div class="flex items-center gap-3 mb-5 p-3 rounded-xl" style="background:#f5f3ff">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                         style="background:#ede9fe">
                        <svg class="w-4 h-4" style="color:#7c3aed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-gray-400">Calon Mempelai</p>
                        <p class="text-sm font-semibold text-gray-800 truncate">
                            {{ $pendaftaran->nama_pria }} &amp; {{ $pendaftaran->nama_wanita }}
                        </p>
                    </div>
                 
                </div>

                {{-- Total --}}
                <div class="flex items-center justify-between mb-5 px-4 py-3 rounded-xl"
                     style="background:linear-gradient(135deg,#faf5ff,#f5f3ff);border:1.5px solid #e9d5ff">
                    <span class="text-sm font-medium text-gray-600">Total Pembayaran</span>
                    <span class="text-xl font-extrabold" style="color:#7c3aed">Rp 350.000</span>
                </div>

                {{-- QR Code --}}
                <div class="text-center mb-5">
                 
                    @if($pendaftaran->qris_url)
                    <div class="relative inline-block">
                        {{-- Border dekoratif --}}
                        <div class="absolute -inset-2 rounded-2xl opacity-30"
                             style="background:linear-gradient(135deg,#1e2685,#7c3aed,#be185d)"></div>
                        <div id="qr-container" class="relative bg-white rounded-xl p-4 shadow-lg">
                            {{-- QR Image diambil melalui proxy server kita --}}
                            <img src="{{ route('pembayaran.qr-image', $pendaftaran->id) }}"
                                 alt="QR Code QRIS Pembayaran"
                                 class="w-60 h-60 mx-auto object-contain"
                                 id="qr-image"
                                 onerror="this.style.display='none'; document.getElementById('qr-fallback').style.display='flex';">
                            <div id="qr-fallback" style="display:none"
                                 class="w-60 h-60 flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <p class="text-xs text-center">QR Code tidak tersedia.<br/>Coba muat ulang halaman.</p>
                            </div>
                            {{-- Overlay regenerasi --}}
                            <div id="qr-overlay" style="display:none"
                                 class="absolute inset-0 bg-white/90 rounded-xl flex flex-col items-center justify-center z-10">
                                <svg class="w-8 h-8 animate-spin mb-2" style="color:#7c3aed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <p class="text-xs font-semibold" style="color:#7c3aed">Memuat QR baru…</p>
                            </div>
                        </div>
                    </div>

                    {{-- Label QRIS --}}
                    <div class="mt-3 inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold"
                         style="background:#ecfdf5;color:#065f46;border:1.5px solid #6ee7b7">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        QRIS · Semua e-wallet &amp; mobile banking
                    </div>
                    @elseif(isset($snap_token) && $snap_token && isset($snap_client_key) && $snap_client_key)
                    {{-- Fallback: tampilkan QRIS via Midtrans Snap --}}
                    <div id="snap-qris-container" class="space-y-3">
                        <p class="text-xs text-gray-500">QRIS ditampilkan melalui Midtrans. Klik tombol di bawah untuk membuka halaman pembayaran.</p>
                        <button type="button" id="btn-bayar-midtrans"
                            class="w-full py-3.5 px-6 rounded-2xl font-bold text-white text-sm shadow-md transition-all active:scale-95 hover:opacity-90 flex items-center justify-center gap-2"
                            style="background:linear-gradient(135deg,#1e2685 0%,#7c3aed 50%,#be185d 100%)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.24M16.24 12l1.07-1.07M12 12l-1.07 1.07M12 12V8.93"/>
                            </svg>
                            Tampilkan QR Code Midtrans (QRIS)
                        </button>
                    </div>
                    @else
                    <div class="w-56 h-56 mx-auto flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-200 text-gray-400">
                        <svg class="w-10 h-10 mb-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <p class="text-xs text-center">Memuat QR Code…</p>
                    </div>
                    @endif
                </div>

                {{-- Panduan singkat --}}
                <div class="rounded-xl p-4 mb-5 text-xs" style="background:#fffbeb;border:1.5px solid #fde68a">
                    <p class="font-bold text-amber-700 mb-2">Cara Pembayaran:</p>
                    <ol class="space-y-1 text-amber-600 list-decimal list-inside">
                        <li>Buka aplikasi GoPay, OVO, DANA, ShopeePay, atau mobile banking</li>
                        <li>Pilih menu <strong>Scan QR / QRIS</strong></li>
                        <li>Scan kode QR di atas</li>
                        <li>Konfirmasi pembayaran <strong>Rp 350.000</strong></li>
                        <li>Klik tombol <strong>"Saya Sudah Bayar"</strong> di bawah</li>
                    </ol>
                </div>

                {{-- Tombol cek status --}}
                <button id="btn-check-status"
                    onclick="cekStatusPembayaran()"
                    class="w-full py-3.5 px-6 rounded-2xl font-bold text-white text-sm shadow-md transition-all active:scale-95 hover:opacity-90 flex items-center justify-center gap-2"
                    style="background:linear-gradient(135deg,#1e2685 0%,#7c3aed 50%,#be185d 100%)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span id="btn-check-text">Saya Sudah Bayar — Cek Status</span>
                </button>

                {{-- Status result --}}
                <div id="status-result" class="mt-3 hidden"></div>

                {{-- Masa berlaku --}}
                <p id="expiry-label" class="text-center text-xs text-gray-400 mt-3">
                    @if($pendaftaran->qris_expired_at)
                    QR berlaku hingga: <strong>{{ $pendaftaran->qris_expired_at->locale('id')->isoFormat('D MMM YYYY, HH:mm') }} WIB</strong>
                    &nbsp;·&nbsp;<span id="countdown" class="font-mono"></span>
                    @endif
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <p class="text-center text-xs text-gray-400 mt-5">
            Pembayaran diproses aman oleh <strong class="text-gray-600">Midtrans</strong> ·
            <a href="{{ route('kontak') }}" class="underline hover:text-gray-600">Butuh bantuan?</a>
        </p>

    </div>
</div>

@if(isset($snap_token) && $snap_token && isset($snap_client_key) && $snap_client_key)
<script type="text/javascript" src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ $snap_client_key }}"></script>
@endif

<script>
const statusUrl = @json(route('pembayaran.status', $pendaftaran->id));
const newQrUrl  = @json(route('pembayaran.new-qr', $pendaftaran->id));
const finishUrl = @json(route('kursus-pernikahan.sukses', $pendaftaran->id));
const csrfToken = @json(csrf_token());

let expiryDate   = @json($pendaftaran->qris_expired_at?->toIso8601String());
let polling      = null;
let countdownInt = null;
let regenerating = false;

// ── Countdown timer ────────────────────────────────────────────────────────
function startCountdown() {
    clearInterval(countdownInt);
    if (!expiryDate) return;

    const el = document.getElementById('countdown');
    countdownInt = setInterval(() => {
        const diff = Math.floor((new Date(expiryDate) - Date.now()) / 1000);
        if (!el) return;
        if (diff <= 0) {
            el.textContent = '(kedaluwarsa)';
            el.style.color = '#dc2626';
            clearInterval(countdownInt);
            return;
        }
        const h = Math.floor(diff / 3600);
        const m = Math.floor((diff % 3600) / 60);
        const s = diff % 60;
        el.textContent = h > 0
            ? `(${h}j ${String(m).padStart(2,'0')}m ${String(s).padStart(2,'0')}d)`
            : `(${String(m).padStart(2,'0')}m ${String(s).padStart(2,'0')}d)`;
        el.style.color = diff < 300 ? '#dc2626' : '#6b7280';
    }, 1000);
}

// ── Auto-regenerate QR tanpa reload halaman ────────────────────────────────
async function regenerateQr() {
    if (regenerating) return;
    regenerating = true;

    const overlay   = document.getElementById('qr-overlay');
    const statusRes = document.getElementById('status-result');
    const btn       = document.getElementById('btn-check-status');
    const btnText   = document.getElementById('btn-check-text');

    if (overlay) overlay.style.display = 'flex';
    if (btn) btn.disabled = true;
    if (btnText) btnText.textContent = 'Memuat QR baru…';

    try {
        const res  = await fetch(newQrUrl, {
            method:  'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        });
        const data = await res.json();

        if (data.status === 'lunas') {
            window.location.href = data.redirect_url || finishUrl;
            return;
        }

        if (data.success) {
            const img = document.getElementById('qr-image');
            if (img) {
                img.style.display = 'block';
                img.src = data.qr_image_url;
                const fb = document.getElementById('qr-fallback');
                if (fb) fb.style.display = 'none';
            }

            expiryDate = data.expired_at;
            const expiryLabel = document.getElementById('expiry-label');
            if (expiryLabel) {
                expiryLabel.innerHTML = `QR berlaku hingga: <strong>${data.expired_label} WIB</strong> &nbsp;·&nbsp;<span id="countdown" class="font-mono"></span>`;
            }
            startCountdown();

            if (statusRes) {
                statusRes.className = 'mt-3 p-3 rounded-xl text-sm text-center hidden';
                statusRes.textContent = '';
            }
        } else {
            showStatusMsg('error', '⚠ Gagal membuat QR baru. Coba lagi.');
        }
    } catch {
        showStatusMsg('error', '⚠ Koneksi gagal saat memuat QR baru.');
    } finally {
        if (overlay) overlay.style.display = 'none';
        if (btn) btn.disabled = false;
        if (btnText) btnText.textContent = 'Saya Sudah Bayar — Cek Status';
        regenerating = false;
    }
}

// ── Tampilkan pesan status ─────────────────────────────────────────────────
function showStatusMsg(type, text) {
    const el = document.getElementById('status-result');
    if (!el) return;

    const styles = {
        success: { bg: '#ecfdf5', color: '#065f46', border: '1.5px solid #6ee7b7' },
        warning: { bg: '#fffbeb', color: '#92400e', border: '1.5px solid #fde68a' },
        error:   { bg: '#fef2f2', color: '#991b1b', border: '1.5px solid #fecaca' },
        neutral: { bg: '#f3f4f6', color: '#374151', border: '1.5px solid #e5e7eb' },
    };
    const s = styles[type] || styles.neutral;
    el.className   = 'mt-3 p-3 rounded-xl text-sm text-center';
    el.style.background = s.bg;
    el.style.color      = s.color;
    el.style.border     = s.border;
    el.textContent = text;
    el.classList.remove('hidden');
}

// ── Tombol "Saya Sudah Bayar" ──────────────────────────────────────────────
async function cekStatusPembayaran() {
    const btn     = document.getElementById('btn-check-status');
    const btnText = document.getElementById('btn-check-text');
    btn.disabled     = true;
    btnText.textContent = 'Mengecek status…';

    try {
        const res  = await fetch(statusUrl);
        const data = await res.json();
        await handleStatus(data);
    } catch {
        showStatusMsg('error', '⚠ Gagal memeriksa status. Coba lagi.');
        btn.disabled = false;
        btnText.textContent = 'Cek Status Lagi';
    }
}

// ── Handler status terpusat ────────────────────────────────────────────────
async function handleStatus(data) {
    const btn     = document.getElementById('btn-check-status');
    const btnText = document.getElementById('btn-check-text');

    if (data.status === 'lunas') {
        clearInterval(polling);
        clearInterval(countdownInt);
        showStatusMsg('success', '✓ Pembayaran berhasil dikonfirmasi! Mengalihkan…');
        setTimeout(() => { window.location.href = data.redirect_url || finishUrl; }, 1500);
        return;
    }

    if (data.status === 'pending' || data.status === 'menunggu') {
        showStatusMsg('warning', '⏳ Pembayaran belum terkonfirmasi. Silakan scan QR terlebih dahulu.');
        btn.disabled = false;
        btnText.textContent = 'Cek Status Lagi';
        return;
    }

    if (data.status === 'expire' || data.status === 'cancel' || data.status === 'deny' || data.status === 'gagal') {
        showStatusMsg('warning', '🔄 QR kedaluwarsa atau dibatalkan. Membuat QR baru secara otomatis…');
        await regenerateQr();
        return;
    }

    // belum_bayar / unknown
    showStatusMsg('neutral', 'Belum ada pembayaran yang masuk. Silakan scan QR di atas.');
    btn.disabled = false;
    btnText.textContent = 'Cek Status Lagi';
}

// ── Auto-poll setiap 5 detik ───────────────────────────────────────────────
function startPolling() {
    polling = setInterval(async () => {
        if (regenerating) return;
        try {
            const res  = await fetch(statusUrl);
            const data = await res.json();

            if (data.status === 'lunas') {
                clearInterval(polling);
                clearInterval(countdownInt);
                window.location.href = data.redirect_url || finishUrl;
                return;
            }

            if (data.status === 'expire' || data.status === 'cancel' || data.status === 'deny') {
                clearInterval(polling);
                await regenerateQr();
                startPolling();
            }
        } catch { /* abaikan error jaringan sementara */ }
    }, 5000);
}

startPolling();
startCountdown();

@if(isset($snap_token) && $snap_token && isset($snap_client_key) && $snap_client_key)
(function() {
    const snapToken = @json($snap_token);
    document.getElementById('btn-bayar-midtrans')?.addEventListener('click', function() {
        if (typeof snap !== 'undefined') {
            snap.pay(snapToken);
        } else {
            alert('Midtrans belum siap. Silakan muat ulang halaman.');
        }
    });
})();
@endif
</script>
@endsection