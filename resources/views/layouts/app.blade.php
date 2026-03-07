<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Biara Loresa SCJ - Serikat Imam-imam Hati Kudus Yesus">
    <title>@yield('title', 'Biara Loresa SCJ')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('logo-192.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-overlay { background: linear-gradient(135deg, rgba(30,38,133,0.85) 0%, rgba(61,86,245,0.6) 100%); }
        .nav-sticky { backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
        .scj-cross { filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3)); }
    </style>
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-white/95 nav-sticky shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-primary-700 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white scj-cross" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-primary-800 leading-tight text-sm">Biara Loresa</div>
                        <div class="text-xs text-gold-500 font-semibold tracking-widest">SCJ</div>
                    </div>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link text-sm {{ request()->routeIs('home') ? 'text-primary-700 font-semibold' : '' }}">Beranda</a>
                    <a href="{{ route('profil') }}" class="nav-link text-sm {{ request()->routeIs('profil') ? 'text-primary-700 font-semibold' : '' }}">Profil</a>
                    <a href="{{ route('berita') }}" class="nav-link text-sm {{ request()->routeIs('berita*') ? 'text-primary-700 font-semibold' : '' }}">Berita</a>
                    <a href="{{ route('galeri') }}" class="nav-link text-sm {{ request()->routeIs('galeri') ? 'text-primary-700 font-semibold' : '' }}">Galeri</a>
                    <a href="{{ route('kursus-pernikahan') }}" class="nav-link text-sm {{ request()->routeIs('kursus-pernikahan*') ? 'text-rose-600 font-semibold' : 'text-rose-500' }} flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z"/></svg>
                        <span>Kursus Nikah</span>
                    </a>
                    <a href="{{ route('kontak') }}" class="bg-primary-700 text-white text-sm px-4 py-2 rounded-lg hover:bg-primary-800 transition-colors font-medium">Kontak</a>
                </div>

                {{-- Mobile Hamburger --}}
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="md:hidden hidden pb-4 border-t border-gray-100 mt-2 pt-4">
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('home') }}" class="nav-link text-sm px-2 py-1">Beranda</a>
                    <a href="{{ route('profil') }}" class="nav-link text-sm px-2 py-1">Profil</a>
                    <a href="{{ route('berita') }}" class="nav-link text-sm px-2 py-1">Berita</a>
                    <a href="{{ route('galeri') }}" class="nav-link text-sm px-2 py-1">Galeri</a>
                    <a href="{{ route('kursus-pernikahan') }}" class="nav-link text-sm px-2 py-1 text-rose-500">Kursus Nikah</a>
                    <a href="{{ route('kontak') }}" class="nav-link text-sm px-2 py-1">Kontak</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-white">Biara Loresa SCJ</div>
                            <div class="text-xs text-gold-400 font-semibold tracking-widest">Serikat Imam-imam Hati Kudus Yesus</div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        "Hati Kudus Yesus Kristus menjadi kekuatan kami dalam pelayanan dan pewartaan Injil kepada semua orang."
                    </p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h3 class="font-semibold text-white mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-sm hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('profil') }}" class="text-sm hover:text-white transition-colors">Profil Komunitas</a></li>
                        <li><a href="{{ route('berita') }}" class="text-sm hover:text-white transition-colors">Berita & Kegiatan</a></li>
                        <li><a href="{{ route('galeri') }}" class="text-sm hover:text-white transition-colors">Galeri Foto</a></li>
                        <li><a href="{{ route('kursus-pernikahan') }}" class="text-sm hover:text-white transition-colors">Kursus Pernikahan</a></li>
                        <li><a href="{{ route('kontak') }}" class="text-sm hover:text-white transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h3 class="font-semibold text-white mb-4">Informasi Kontak</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start space-x-2">
                            <svg class="w-5 h-5 text-primary-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-gray-400">Jl. Biara Loresa No. 1, Kecamatan Damai, Kalimantan Timur</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-primary-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span class="text-gray-400">+62 (0541) 123-456</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-primary-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-gray-400">info@biaraloresa-scj.org</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-10 pt-6 text-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} Biara Loresa SCJ. Seluruh hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
