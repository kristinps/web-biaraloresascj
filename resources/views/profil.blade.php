@extends('layouts.app')

@section('title', 'Profil - Biara Loresa SCJ')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 home-enter" data-home-animate>
    <div class="profil-content">

            {{-- Header halaman --}}
            <header class="profil-header home-enter" data-home-animate data-delay="1">
                <p class="profil-header-label">Siapa Kami</p>
                <h1 class="profil-header-title">Profil Komunitas</h1>
                <p class="profil-header-subtitle">Mengenal lebih dekat Biara Loresa SCJ dan misi pelayanannya</p>
            </header>

            {{-- Section: Sejarah --}}
            <section class="profil-section home-enter" data-home-animate data-delay="2">
                <div class="profil-grid profil-grid--2">
                    <div class="profil-card">
                        <p class="profil-card-label">Sejarah</p>
                        <h2 class="profil-card-title">Berdirinya Biara Loresa SCJ</h2>
                        <div class="profil-body">
                            <p>
                                Biara Loresa SCJ didirikan pada tahun 1999 sebagai bagian dari ekspansi misi
                                Serikat Imam-imam Hati Kudus Yesus (SCJ) di Kalimantan. Nama "Loresa" diambil
                                dari salah satu tokoh setempat yang berjasa dalam perkembangan Gereja Katolik
                                di wilayah ini.
                            </p>
                            <p>
                                Kongregasi SCJ sendiri didirikan oleh Pater Leon Dehon pada tahun 1878 di
                                Saint-Quentin, Perancis. Spiritualitas kongregasi berpusat pada Hati Kudus
                                Yesus yang menjadi simbol kasih Allah yang tak terbatas bagi umat manusia.
                            </p>
                            <p>
                                Sejak berdiri, Biara Loresa SCJ telah menjadi pusat pembinaan calon-calon
                                imam dan bruder SCJ, serta pusat pelayanan pastoral bagi umat Katolik
                                di wilayah Kalimantan Timur dan sekitarnya.
                            </p>
                        </div>
                    </div>
                    <div class="profil-card profil-card--image">
                        <div class="profil-image-wrap">
                            <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=700&h=500&fit=crop"
                                 alt="Sejarah Biara" class="profil-image">
                            <span class="profil-badge">Sejak 1999</span>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Section: Visi & Misi --}}
            <section class="profil-section home-enter" data-home-animate data-delay="3">
                <header class="profil-section-header">
                    <p class="profil-section-label">Arah Pelayanan</p>
                    <h2 class="profil-section-title">Visi & Misi</h2>
                </header>
                <div class="profil-grid profil-grid--2">
                    <div class="profil-card">
                        <div class="profil-card-head">
                            <span class="profil-card-icon profil-card-icon--blue" aria-hidden="true"></span>
                            <h3 class="profil-card-title profil-card-title--inline">Visi</h3>
                        </div>
                        <p class="profil-body">
                            Menjadi komunitas religius yang hidup sungguh-sungguh dari kasih Hati Kudus Yesus,
                            menjadi tanda kasih Allah yang nyata di tengah masyarakat, dan mewartakan keselamatan
                            Kristus kepada semua orang tanpa terkecuali.
                        </p>
                    </div>
                    <div class="profil-card">
                        <div class="profil-card-head">
                            <span class="profil-card-icon profil-card-icon--green" aria-hidden="true"></span>
                            <h3 class="profil-card-title profil-card-title--inline">Misi</h3>
                        </div>
                        <ul class="profil-list">
                            <li>Membina calon imam dan bruder SCJ yang berkualitas dan bersemangat misionaris</li>
                            <li>Melayani umat melalui karya pastoral di paroki-paroki dan wilayah terpencil</li>
                            <li>Menjalankan karya sosial untuk membantu masyarakat yang membutuhkan</li>
                            <li>Membangun dialog dan kerjasama antar umat beragama</li>
                        </ul>
                    </div>
                </div>
            </section>

            {{-- Section: Pimpinan --}}
            <section class="profil-section home-enter" data-home-animate data-delay="4">
                <header class="profil-section-header">
                    <p class="profil-section-label">Kepemimpinan</p>
                    <h2 class="profil-section-title">Pimpinan Komunitas</h2>
                    <p class="profil-section-desc">Para imam yang memimpin dan melayani komunitas Biara Loresa SCJ</p>
                </header>
                <div class="profil-grid profil-grid--pimpinan">
                    @foreach($pimpinan as $person)
                    <div class="profil-card profil-card--pimpinan">
                        <div class="profil-pimpinan-photo-wrap">
                            <img src="{{ $person['foto'] }}" alt="{{ $person['nama'] }}" class="profil-pimpinan-photo">
                            <span class="profil-pimpinan-badge" aria-hidden="true">
                                <svg class="profil-pimpinan-badge-icon" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/>
                                </svg>
                            </span>
                        </div>
                        <h3 class="profil-card-title profil-card-title--center">{{ $person['nama'] }}</h3>
                        <p class="profil-pimpinan-role">{{ $person['jabatan'] }}</p>
                    </div>
                    @endforeach
                </div>
            </section>

            {{-- Section: Fasilitas --}}
            <section class="profil-section home-enter" data-home-animate data-delay="5">
                <header class="profil-section-header">
                    <p class="profil-section-label">Sarana & Prasarana</p>
                    <h2 class="profil-section-title">Fasilitas Biara</h2>
                </header>
                <div class="profil-grid profil-grid--fasilitas">
                    @php
                    $fasilitas = [
                        ['nama' => 'Kapel', 'ikon' => '⛪'],
                        ['nama' => 'Perpustakaan', 'ikon' => '📚'],
                        ['nama' => 'Taman Meditasi', 'ikon' => '🌿'],
                        ['nama' => 'Aula Serbaguna', 'ikon' => '🏛️'],
                        ['nama' => 'Asrama', 'ikon' => '🏠'],
                        ['nama' => 'Lapangan Olahraga', 'ikon' => '⚽'],
                    ];
                    @endphp
                    @foreach($fasilitas as $item)
                    <div class="profil-card profil-card--fasilitas">
                        <span class="profil-fasilitas-icon" aria-hidden="true">{{ $item['ikon'] }}</span>
                        <span class="profil-fasilitas-label">{{ $item['nama'] }}</span>
                    </div>
                    @endforeach
                </div>
            </section>

    </div>
</div>

@push('styles')
<style>
/* ---- Layout: padding/radius untuk .profil-card (glass dari layout) ---- */
.profil-card { padding: 1.25rem; border-radius: 1rem; }
.profil-content {
    display: flex;
    flex-direction: column;
    gap: 2.5rem;
}

/* ---- Page header ---- */
.profil-header {
    margin-bottom: 0.5rem;
}
.profil-header-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #ffffff;
    margin: 0 0 0.25rem 0;
}
.profil-header-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 0.5rem 0;
}
.profil-header-subtitle {
    font-size: 0.95rem;
    color: rgba(255,255,255,0.9);
    margin: 0;
}

/* ---- Section ---- */
.profil-section {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}
.profil-section-header {
    text-align: center;
}
.profil-section-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #ffffff;
    margin: 0 0 0.25rem 0;
}
.profil-section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 0.25rem 0;
}
.profil-section-desc {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.85);
    margin: 0;
}

/* ---- Grid ---- */
.profil-grid {
    display: grid;
    gap: 1.25rem;
}
.profil-grid--2 {
    grid-template-columns: 1fr 1fr;
}
.profil-grid--pimpinan {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    max-width: 900px;
    margin: 0 auto;
}
.profil-grid--fasilitas {
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
}

/* ---- Card (base): glass dari layout; di sini hanya tipografi ---- */
.profil-card-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #ffffff;
    margin: 0 0 0.5rem 0;
}
.profil-card-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 1rem 0;
}
.profil-card-title--inline { margin-bottom: 0; }
.profil-card-title--center { text-align: center; margin-bottom: 0.25rem; }
.profil-card-head {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}
.profil-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    flex-shrink: 0;
}
.profil-card-icon--blue { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.profil-card-icon--green { background: linear-gradient(135deg, #10b981, #059669); }

/* ---- Card: body & list ---- */
.profil-body {
    color: rgba(255,255,255,0.95);
    font-size: 0.95rem;
    line-height: 1.7;
    margin: 0;
}
.profil-body p + p { margin-top: 1rem; }
.profil-list {
    list-style: none;
    padding: 0;
    margin: 0;
    color: rgba(255,255,255,0.95);
    font-size: 0.95rem;
    line-height: 1.7;
}
.profil-list li {
    position: relative;
    padding-left: 1.25rem;
    margin-bottom: 0.5rem;
}
.profil-list li:last-child { margin-bottom: 0; }
.profil-list li::before {
    content: '✦';
    position: absolute;
    left: 0;
    color: rgba(139, 92, 246, 0.9);
}

/* ---- Card: image ---- */
.profil-card--image { padding: 0; overflow: hidden; }
.profil-image-wrap {
    position: relative;
    display: block;
}
.profil-image {
    display: block;
    width: 100%;
    height: auto;
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.profil-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: rgba(30, 38, 133, 0.9);
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
}

/* ---- Card: pimpinan ---- */
.profil-card--pimpinan {
    text-align: center;
    padding: 1.5rem;
}
.profil-pimpinan-photo-wrap {
    position: relative;
    display: inline-block;
    margin-bottom: 0.75rem;
}
.profil-pimpinan-photo {
    width: 8rem;
    height: 8rem;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(148,163,184,0.5);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.profil-pimpinan-badge {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 2rem;
    height: 2rem;
    background: #4f46e5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255,255,255,0.9);
}
.profil-pimpinan-badge-icon { width: 1rem; height: 1rem; color: #fff; }
.profil-pimpinan-role {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.85);
    margin: 0;
}

/* ---- Card: fasilitas ---- */
.profil-card--fasilitas {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.profil-fasilitas-icon {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    line-height: 1;
}
.profil-fasilitas-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #ffffff;
}

/* ---- Responsive ---- */
@media (max-width: 768px) {
    .profil-content { gap: 2rem; }
    .profil-grid--2,
    .profil-grid--pimpinan { grid-template-columns: 1fr; }
    .profil-grid--fasilitas { grid-template-columns: repeat(2, 1fr); }
    .profil-grid--pimpinan { max-width: 100%; }
}
</style>
@endpush
@endsection
