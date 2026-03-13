@extends('layouts.app')

@section('title', 'Kontak - Biara Loresa SCJ')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 home-enter" data-home-animate>
    <header class="kontak-page-header home-enter" data-home-animate data-delay="1">
            <p class="kontak-page-badge">Hubungi Kami</p>
            <h1 class="kontak-page-title">Kontak</h1>
            <p class="kontak-page-subtitle">Kami dengan senang hati siap mendengar dan membantu Anda</p>
        </header>

        @if(session('success'))
        <div class="kontak-toast kontak-toast-success">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <div class="kontak-grid home-enter" data-home-animate data-delay="2">
            {{-- Info Kontak --}}
            <div class="kontak-info-col">
                <h2 class="kontak-section-title">Informasi Kontak</h2>

                <div class="kontak-stat-card card">
                    <div class="kontak-stat-icon kontak-stat-icon-addr" aria-hidden="true"></div>
                    <div class="kontak-stat-body">
                        <span class="kontak-stat-label">Alamat</span>
                        <span class="kontak-stat-value">
                            Jl. Biara Loresa No. 1<br>
                            Kecamatan Damai, Kutai Barat<br>
                            Kalimantan Timur 75562
                        </span>
                    </div>
                </div>

                <div class="kontak-stat-card card">
                    <div class="kontak-stat-icon kontak-stat-icon-phone" aria-hidden="true"></div>
                    <div class="kontak-stat-body">
                        <span class="kontak-stat-label">Telepon</span>
                        <span class="kontak-stat-value">
                            +62 (0541) 123-456<br>
                            +62 812-3456-7890 (WhatsApp)
                        </span>
                    </div>
                </div>

                <div class="kontak-stat-card card">
                    <div class="kontak-stat-icon kontak-stat-icon-email" aria-hidden="true"></div>
                    <div class="kontak-stat-body">
                        <span class="kontak-stat-label">Email</span>
                        <span class="kontak-stat-value">
                            info@biaraloresa-scj.org<br>
                            sekretariat@biaraloresa-scj.org
                        </span>
                    </div>
                </div>

                <div class="kontak-stat-card card">
                    <div class="kontak-stat-icon kontak-stat-icon-time" aria-hidden="true"></div>
                    <div class="kontak-stat-body">
                        <span class="kontak-stat-label">Jam Sekretariat</span>
                        <span class="kontak-stat-value">
                            Senin - Jumat: 08.00 - 16.00<br>
                            Sabtu: 08.00 - 12.00
                        </span>
                    </div>
                </div>
            </div>

            {{-- Form Kontak --}}
            <div class="kontak-form-col home-enter" data-home-animate data-delay="3">
                <div class="kontak-form-card card">
                    <h2 class="kontak-form-title">Kirim Pesan</h2>
                    <p class="kontak-form-desc">Isi formulir di bawah ini dan kami akan merespons secepatnya.</p>

                    <form action="{{ route('kontak.store') }}" method="POST" class="kontak-form space-y-6">
                        @csrf
                        <div class="kontak-form-row">
                            <div>
                                <label for="nama" class="kontak-label">
                                    Nama Lengkap <span class="text-red-400">*</span>
                                </label>
                                <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                                    class="kontak-input @error('nama') kontak-input-error @enderror"
                                    placeholder="Nama Anda">
                                @error('nama')
                                <p class="kontak-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="kontak-label">
                                    Email <span class="text-red-400">*</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="kontak-input @error('email') kontak-input-error @enderror"
                                    placeholder="email@contoh.com">
                                @error('email')
                                <p class="kontak-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="subjek" class="kontak-label">
                                Subjek <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="subjek" name="subjek" value="{{ old('subjek') }}"
                                class="kontak-input @error('subjek') kontak-input-error @enderror"
                                placeholder="Subjek pesan Anda">
                            @error('subjek')
                            <p class="kontak-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="pesan" class="kontak-label">
                                Pesan <span class="text-red-400">*</span>
                            </label>
                            <textarea id="pesan" name="pesan" rows="6"
                                class="kontak-input kontak-textarea @error('pesan') kontak-input-error @enderror"
                                placeholder="Tulis pesan Anda di sini...">{{ old('pesan') }}</textarea>
                            @error('pesan')
                            <p class="kontak-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="kontak-submit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            <span>Kirim Pesan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
</div>

@push('styles')
<style>
/* Header */
.kontak-page-header {
    text-align: center;
    padding: 2rem 0 2.5rem;
}
.kontak-page-badge {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: rgba(255,255,255,0.7);
    margin-bottom: 0.5rem;
}
.kontak-page-title {
    font-size: 2.25rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
}
.kontak-page-subtitle {
    color: rgba(255,255,255,0.85);
    margin-top: 0.75rem;
    max-width: 32rem;
    margin-left: auto;
    margin-right: auto;
}

/* Toast (success) */
.kontak-toast {
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 0.875rem;
    margin-bottom: 1.5rem;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    max-width: 100%;
    background: rgba(255,255,255,0.96);
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.kontak-toast-success {
    background: rgba(240,253,244,0.98);
    border-color: #bbf7d0;
    color: #15803d;
}
.kontak-toast-success svg {
    color: #16a34a;
}

/* Grid */
.kontak-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}
@media (min-width: 1024px) {
    .kontak-grid {
        grid-template-columns: 1fr 2fr;
        gap: 1.5rem;
    }
}

/* Info column */
.kontak-info-col {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.kontak-section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 0.25rem 0;
}

/* Stat cards: glass dari layout */
.kontak-stat-card {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.25rem;
    border-radius: 12px;
}
.kontak-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    flex-shrink: 0;
}
.kontak-stat-icon-addr { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.kontak-stat-icon-phone { background: linear-gradient(135deg, #10b981, #059669); }
.kontak-stat-icon-email { background: linear-gradient(135deg, #6366f1, #4f46e5); }
.kontak-stat-icon-time { background: linear-gradient(135deg, #f59e0b, #d97706); }
.kontak-stat-body {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    min-width: 0;
}
.kontak-stat-label {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: rgba(255,255,255,0.85);
}
.kontak-stat-value {
    font-size: 0.875rem;
    color: #ffffff;
    line-height: 1.5;
}

/* Form card: glass dari layout */
.kontak-form-card {
    padding: 1.75rem;
    border-radius: 16px;
}
.kontak-form-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 0.25rem 0;
}
.kontak-form-desc {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.8);
    margin-bottom: 1.5rem;
}

/* Form elements */
.kontak-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}
@media (max-width: 768px) {
    .kontak-form-row { grid-template-columns: 1fr; }
}
.kontak-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: rgba(255,255,255,0.95);
    margin-bottom: 0.5rem;
}
.kontak-input {
    width: 100%;
    border: 1px solid rgba(148,163,184,0.5);
    border-radius: 12px;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    background: rgba(255,255,255,0.95);
    color: #1e293b;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.kontak-input::placeholder {
    color: #94a3b8;
}
.kontak-input:focus {
    outline: none;
    border-color: rgba(99,102,241,0.8);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
}
.kontak-input-error {
    border-color: #f87171;
}
.kontak-textarea {
    resize: none;
}
.kontak-error {
    font-size: 0.75rem;
    color: #fca5a5;
    margin-top: 0.25rem;
}
.kontak-submit {
    width: 100%;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff;
    padding: 0.875rem 1.25rem;
    border-radius: 12px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: opacity 0.2s, transform 0.1s;
}
.kontak-submit:hover {
    opacity: 0.95;
}
.kontak-submit:active {
    transform: scale(0.99);
}
</style>
@endpush

@endsection
