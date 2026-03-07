@extends('layouts.app')

@section('title', 'Beranda - Biara Loresa SCJ')

@section('content')

{{-- Hero Section --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop" 
             alt="Biara" class="w-full h-full object-cover">
        <div class="hero-overlay absolute inset-0"></div>
    </div>
    <div class="relative z-10 text-center text-white px-4 max-w-4xl mx-auto">
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-2 border-white/50">
                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/>
                </svg>
            </div>
        </div>
        <p class="text-gold-400 font-semibold tracking-widest uppercase text-sm mb-3">Serikat Imam-imam Hati Kudus Yesus</p>
        <h1 class="text-5xl md:text-7xl font-serif font-bold mb-6 leading-tight">
            Biara Loresa<br>
            <span class="text-gold-400">SCJ</span>
        </h1>
        <p class="text-lg md:text-xl text-white/90 mb-10 max-w-2xl mx-auto leading-relaxed">
            Bersumber dari kasih Hati Kudus Yesus, kami hadir untuk melayani, 
            mendampingi, dan mewartakan Injil kepada semua orang.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
           
            
            @auth
                <a href="{{ route('user.dashboard') }}" class="border-2 border-white/80 text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition-colors inline-flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>
            @else
                <a href="{{ route('user.login') }}" class="border-2 border-white/80 text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition-colors inline-flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Login
                </a>
            @endauth
        </div>
    </div>
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white/60 animate-bounce">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</section>

{{-- Spiritualitas Cards --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-primary-600 font-semibold tracking-widest uppercase text-sm mb-2">Spiritualitas Kami</p>
            <h2 class="section-title">Landasan Hidup SCJ</h2>
            <p class="section-subtitle max-w-2xl mx-auto">
                Kehidupan komunitas kami dibangun di atas tiga pilar utama yang bersumber dari kasih Hati Kudus Yesus
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-primary-50 to-blue-50 hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="font-serif font-bold text-xl text-gray-800 mb-3">Kasih Hati Kudus</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Menghayati kasih Yesus yang tak terbatas sebagai sumber kekuatan 
                    dan inspirasi dalam seluruh hidup dan pelayanan.
                </p>
            </div>
            <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-amber-50 to-yellow-50 hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="font-serif font-bold text-xl text-gray-800 mb-3">Persaudaraan</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Membangun komunitas yang penuh kasih, saling mendukung, 
                    dan hidup bersama sebagai saudara dalam Kristus.
                </p>
            </div>
            <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-green-50 to-emerald-50 hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                </div>
                <h3 class="font-serif font-bold text-xl text-gray-800 mb-3">Misi & Pelayanan</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Mewartakan Injil Kristus dengan penuh semangat kepada 
                    semua orang, terutama yang paling membutuhkan.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Tentang Kami --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1529070538774-1843cb3265df?w=700&h=500&fit=crop" 
                     alt="Komunitas SCJ" class="w-full rounded-2xl shadow-xl">
                <div class="absolute -bottom-6 -right-6 bg-primary-700 text-white p-6 rounded-xl shadow-lg hidden md:block">
                    <div class="text-3xl font-bold">25+</div>
                    <div class="text-sm text-primary-200">Tahun Berdiri</div>
                </div>
            </div>
            <div>
                <p class="text-primary-600 font-semibold tracking-widest uppercase text-sm mb-2">Tentang Kami</p>
                <h2 class="section-title">Komunitas Biara Loresa SCJ</h2>
                <p class="text-gray-600 mb-5 leading-relaxed">
                    Biara Loresa SCJ adalah komunitas religius dari Serikat Imam-imam Hati Kudus Yesus 
                    (Sacerdotes Cordis Jesu - SCJ) yang berdiri sejak tahun 1999. Berlokasi di Kalimantan Timur, 
                    komunitas ini menjadi pusat pembinaan dan pelayanan pastoral di wilayah tersebut.
                </p>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    SCJ didirikan oleh Pater Leon Dehon pada tahun 1878 di Perancis. Spiritualitas kongregasi 
                    berpusat pada Hati Kudus Yesus sebagai simbol kasih Allah yang tak terbatas, serta 
                    persembahan diri kepada Tuhan melalui hidup yang penuh kasih dan pelayanan.
                </p>
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-white rounded-xl p-4 text-center shadow-sm">
                        <div class="text-2xl font-bold text-primary-700">15</div>
                        <div class="text-sm text-gray-500 mt-1">Anggota Komunitas</div>
                    </div>
                    <div class="bg-white rounded-xl p-4 text-center shadow-sm">
                        <div class="text-2xl font-bold text-primary-700">8</div>
                        <div class="text-sm text-gray-500 mt-1">Paroki Dilayani</div>
                    </div>
                </div>
                <a href="{{ route('profil') }}" class="btn-primary">
                    Baca Selengkapnya
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Jadwal Harian --}}
<section class="py-20 bg-primary-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-primary-300 font-semibold tracking-widest uppercase text-sm mb-2">Kehidupan Komunitas</p>
            <h2 class="text-3xl font-serif font-bold text-white mb-4">Jadwal Harian Komunitas</h2>
            <p class="text-primary-200 text-lg">Ritme kehidupan doa dan pelayanan komunitas kami sehari-hari</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $jadwal = [
                ['waktu' => '05:00', 'kegiatan' => 'Ibadat Laudes (Doa Pagi)', 'ikon' => '🌅'],
                ['waktu' => '06:30', 'kegiatan' => 'Perayaan Ekaristi', 'ikon' => '✝️'],
                ['waktu' => '07:30', 'kegiatan' => 'Sarapan Pagi & Lectio Divina', 'ikon' => '📖'],
                ['waktu' => '08:30', 'kegiatan' => 'Kegiatan Pastoral & Karya', 'ikon' => '🤝'],
                ['waktu' => '12:00', 'kegiatan' => 'Ibadat Siang & Makan Siang', 'ikon' => '☀️'],
                ['waktu' => '14:00', 'kegiatan' => 'Karya Apostolik', 'ikon' => '📚'],
                ['waktu' => '17:30', 'kegiatan' => 'Ibadat Vesper (Doa Sore)', 'ikon' => '🌄'],
                ['waktu' => '20:00', 'kegiatan' => 'Doa Malam & Istrahat', 'ikon' => '🌙'],
            ];
            @endphp
            @foreach($jadwal as $item)
            <div class="bg-primary-700/50 backdrop-blur-sm border border-primary-600 rounded-xl p-5 hover:bg-primary-600/50 transition-colors">
                <div class="text-2xl mb-2">{{ $item['ikon'] }}</div>
                <div class="text-gold-400 font-bold text-lg mb-1">{{ $item['waktu'] }}</div>
                <div class="text-primary-100 text-sm">{{ $item['kegiatan'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Kursus Pernikahan --}}
<section class="py-20 bg-white relative overflow-hidden">
    {{-- Dekorasi latar --}}
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full opacity-5" style="background:radial-gradient(circle,#3d56f5,transparent);transform:translate(30%,-30%)"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full opacity-5" style="background:radial-gradient(circle,#be185d,transparent);transform:translate(-30%,30%)"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

        {{-- Heading --}}
        <div class="text-center mb-14">
            <span class="inline-flex items-center gap-2 bg-rose-50 text-rose-600 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full mb-4">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                Program Pastoral
            </span>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-gray-800 mb-4">Kursus Pernikahan</h2>
            <p class="text-gray-500 max-w-2xl mx-auto leading-relaxed">
                Biara Loresa SCJ menyelenggarakan kursus pernikahan sebagai persiapan rohani 
                bagi pasangan yang hendak menerima Sakramen Pernikahan.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- Kiri: Penjelasan --}}
            <div class="space-y-6">
                <p class="text-gray-600 leading-relaxed text-base">
                    Kursus ini dirancang untuk membantu pasangan memahami makna dan tanggung jawab 
                    pernikahan Katolik secara menyeluruh — mulai dari dimensi rohani, komunikasi, 
                    hingga peran keluarga dalam Gereja dan masyarakat.
                </p>

                {{-- Highlight materi --}}
                <div class="space-y-3">
                    @foreach([
                        ['✝️','Makna Sakramen Pernikahan','Mendalami pernikahan sebagai perjanjian kudus di hadapan Tuhan dan Gereja.'],
                        ['💬','Komunikasi & Keluarga','Membangun relasi yang sehat, saling menghormati, dan penuh kasih dalam keluarga.'],
                        ['👶','Tanggung Jawab Orang Tua','Peran suami–istri dalam mendidik anak dalam iman dan nilai-nilai Kristiani.'],
                        ['🤝','Pastoral Keluarga','Keterlibatan keluarga dalam kehidupan menggereja dan pelayanan bersama.'],
                    ] as [$icon, $judul, $desc])
                    <div class="flex items-start gap-4 bg-gray-50 rounded-xl p-4 hover:bg-primary-50 transition-colors">
                        <span class="text-2xl flex-shrink-0 mt-0.5">{{ $icon }}</span>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">{{ $judul }}</p>
                            <p class="text-gray-500 text-xs mt-0.5 leading-relaxed">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Kanan: Info box + CTA --}}
            <div class="space-y-5">

                {{-- Jadwal & Syarat --}}
                <div class="rounded-2xl overflow-hidden shadow-md border border-gray-100">
                    <div class="px-6 py-4 text-white font-bold text-sm" style="background:linear-gradient(135deg,#1e2685,#3d56f5)">
                        📋 Informasi Pendaftaran
                    </div>
                    <div class="bg-white divide-y divide-gray-50">
                        @foreach([
                            ['Waktu Kursus',   '3 hari (Jumat–Minggu)'],
                            ['Tempat',         'Biara Loresa SCJ, Kecamatan Damai'],
                            ['Biaya',          'Rp 350.000 / pasang (termasuk modul)'],
                            ['Peserta',        'Calon mempelai pria & wanita'],
                            ['Pendaftaran',    'Minimal 2 bulan sebelum pernikahan'],
                        ] as [$label, $nilai])
                        <div class="flex items-center justify-between px-6 py-3.5">
                            <span class="text-sm text-gray-500">{{ $label }}</span>
                            <span class="text-sm font-semibold text-gray-800 text-right max-w-[55%]">{{ $nilai }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Syarat dokumen --}}
                <div class="rounded-2xl p-5 border border-amber-200" style="background:#fffbeb">
                    <p class="text-xs font-bold uppercase tracking-widest text-amber-700 mb-3">📄 Dokumen yang Diperlukan</p>
                    <ul class="space-y-1.5">
                        @foreach(['KTP kedua calon mempelai','Surat Baptis dari paroki asal','Surat Pengantar Kombas (Komisi Keluarga)','Bukti pembayaran pendaftaran'] as $dok)
                        <li class="flex items-center gap-2 text-sm text-amber-900">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $dok }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Tombol daftar --}}
                <a href="{{ route('kursus-pernikahan') }}"
                    class="flex items-center justify-center gap-3 w-full text-white font-bold py-4 px-6 rounded-2xl shadow-lg hover:opacity-90 active:scale-95 transition-all text-base"
                    style="background:linear-gradient(135deg,#1e2685 0%,#3d56f5 50%,#be185d 100%)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Daftar Kursus Pernikahan Sekarang
                </a>

                <p class="text-center text-xs text-gray-400">
                    Pertanyaan? Hubungi kami di
                    <a href="{{ route('kontak') }}" class="text-primary-600 font-semibold hover:underline">halaman kontak</a>
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Berita Terbaru --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-12">
            <div>
                <p class="text-primary-600 font-semibold tracking-widest uppercase text-sm mb-2">Informasi Terkini</p>
                <h2 class="section-title mb-0">Berita & Kegiatan</h2>
            </div>
            <a href="{{ route('berita') }}" class="hidden md:flex items-center text-primary-700 font-semibold hover:text-primary-800 transition-colors">
                Lihat Semua
                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($beritaTerbaru as $berita)
            <article class="card group">
                <div class="overflow-hidden">
                    <img src="{{ $berita['gambar'] }}" alt="{{ $berita['judul'] }}" 
                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <span class="inline-block bg-primary-100 text-primary-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">
                        {{ $berita['kategori'] }}
                    </span>
                    <h3 class="font-serif font-bold text-lg text-gray-800 mb-2 group-hover:text-primary-700 transition-colors">
                        {{ $berita['judul'] }}
                    </h3>
                    <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ $berita['ringkasan'] }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-xs">{{ $berita['tanggal'] }}</span>
                        <a href="{{ route('berita.show', $berita['id']) }}" class="text-primary-700 text-sm font-semibold hover:text-primary-800 flex items-center">
                            Baca
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        <div class="text-center mt-8 md:hidden">
            <a href="{{ route('berita') }}" class="btn-outline">Lihat Semua Berita</a>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-20 bg-gradient-to-br from-primary-900 via-primary-800 to-primary-700 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-serif font-bold mb-5">
            Tertarik Mengenal Lebih Jauh?
        </h2>
        <p class="text-primary-200 text-lg mb-10 max-w-2xl mx-auto">
            Kami dengan senang hati menyambut siapapun yang ingin mengenal kehidupan biara, 
            atau yang merasa terpanggil untuk mengikuti jejak SCJ.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('kontak') }}" class="bg-white text-primary-800 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Hubungi Kami
            </a>
            <a href="{{ route('galeri') }}" class="border-2 border-white/60 text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition-colors">
                Lihat Galeri
            </a>
        </div>
    </div>
</section>

@endsection
