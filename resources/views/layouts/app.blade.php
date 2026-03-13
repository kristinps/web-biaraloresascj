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
        .scj-cross { filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3)); }
        /* Navbar glass - gaya dashboard admin */
        .nav-glass {
            background: linear-gradient(135deg, rgba(99,102,241,0.14), rgba(139,92,246,0.10), rgba(56,189,248,0.08));
            border-bottom: 1px solid rgba(148,163,184,0.5);
            box-shadow: 0 8px 24px rgba(15,23,42,0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        /* Semua halaman publik: teks nav terang (style sama seperti home) */
        body.public-page .nav-glass .nav-link,
        body.public-page .nav-glass .font-bold.text-primary-800 { color: rgba(255,255,255,0.9) !important; }
        body.public-page .nav-glass .text-gold-500 { color: #f0c14b !important; }
        body.public-page .nav-glass .nav-link:hover { color: #fff !important; }
        body.public-page .nav-glass .text-primary-700 { color: #fff !important; }
        body.public-page .nav-glass #mobile-menu-btn svg { color: #fff; }
        body.public-page .nav-glass #mobile-menu { border-color: rgba(255,255,255,0.2); }
        body.public-page .nav-glass #mobile-menu .nav-link { color: rgba(255,255,255,0.9); }
        body.public-page .nav-glass a.border-2 { border-color: rgba(255,255,255,0.6) !important; color: #fff !important; }
        body.public-page .nav-glass a.border-2:hover { border-color: #fff !important; background: rgba(255,255,255,0.1) !important; color: #fff !important; }

        /* ========== Style global (dari home) – semua halaman ========== */
        body.public-page {
            background: transparent;
            min-height: 100vh;
        }
        body.public-page::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -2;
        }
        body.public-page::after {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(30,38,133,0.88) 0%, rgba(61,86,245,0.65) 100%);
            z-index: -1;
        }
        .site-content-wrap {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .site-content-wrap > main { flex: 1; }

        /* Glass card – dipakai di home, profil, kontak, dll */
        .home-glass-card,
        .site-glass-card,
        .profil-card,
        .kontak-stat-card,
        .kontak-form-card {
            background: linear-gradient(135deg, rgba(99,102,241,0.14), rgba(139,92,246,0.10), rgba(56,189,248,0.08));
            border: 1px solid rgba(148,163,184,0.5);
            box-shadow: 0 8px 24px rgba(15,23,42,0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .home-btn-primary {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            background: linear-gradient(135deg, #2230ce, #3d56f5);
            color: #fff;
            text-decoration: none;
            transition: opacity 0.2s, box-shadow 0.2s;
        }
        .home-btn-primary:hover { opacity: 0.92; box-shadow: 0 4px 12px rgba(34, 48, 206, 0.35); color: #fff; }
        .home-btn-outline {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            border: 2px solid rgba(255,255,255,0.6);
            color: #fff;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }
        .home-btn-outline:hover { background: rgba(255,255,255,0.1); color: #fff; }
        /* Footer satu style untuk semua halaman */
        .site-footer {
            border-top: 1px solid rgba(148,163,184,0.4);
            background: linear-gradient(135deg, rgba(99,102,241,0.12), rgba(139,92,246,0.08), rgba(56,189,248,0.06));
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        /* Animasi masuk & keluar global (dipakai di home, profil, galeri, kontak, dll) */
        @keyframes homeFadeSlideIn {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes homeFadeSlideOut {
            from { opacity: 1; transform: translateY(0); }
            to   { opacity: 0; transform: translateY(-16px); }
        }
        .home-enter {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.55s ease-out, transform 0.55s ease-out;
        }
        .home-enter.animated-in {
            opacity: 1;
            transform: translateY(0);
        }
        .home-enter.animated-out {
            opacity: 0;
            transform: translateY(-16px);
            transition: opacity 0.4s ease-in, transform 0.4s ease-in;
        }
        .home-enter[data-delay="1"] { transition-delay: 0.08s; }
        .home-enter[data-delay="2"] { transition-delay: 0.16s; }
        .home-enter[data-delay="3"] { transition-delay: 0.24s; }
        .home-enter[data-delay="4"] { transition-delay: 0.32s; }
        .home-enter[data-delay="5"] { transition-delay: 0.4s; }
        .home-enter[data-delay="6"] { transition-delay: 0.48s; }
        .home-enter[data-delay="7"] { transition-delay: 0.56s; }
        .home-enter[data-delay="8"] { transition-delay: 0.64s; }
    </style>
    @stack('styles')
</head>
<body class="{{ request()->routeIs('login') ? 'bg-gray-50' : 'public-page' }}">

    {{-- Navbar (hidden on login) - transparan glass seperti dashboard admin --}}
    @unless(request()->routeIs('login'))
    <nav class="nav-glass sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-primary-700 rounded-full flex items-center justify-center flex-shrink-0">
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
                    <a href="{{ route('home') }}" class="nav-link text-sm text-gray-600 hover:text-primary-600 {{ request()->routeIs('home') ? 'text-primary-700 font-semibold' : '' }}">Beranda</a>
                    <a href="{{ route('profil') }}" class="nav-link text-sm text-gray-600 hover:text-primary-600 {{ request()->routeIs('profil') ? 'text-primary-700 font-semibold' : '' }}">Profil</a>
                    <a href="{{ route('berita') }}" class="nav-link text-sm text-gray-600 hover:text-primary-600 {{ request()->routeIs('berita*') ? 'text-primary-700 font-semibold' : '' }}">Berita</a>
                    <a href="{{ route('galeri') }}" class="nav-link text-sm text-gray-600 hover:text-primary-600 {{ request()->routeIs('galeri') ? 'text-primary-700 font-semibold' : '' }}">Galeri</a>
                    <a href="{{ route('kursus-pernikahan') }}" class="nav-link text-sm text-rose-500 hover:text-rose-600 {{ request()->routeIs('kursus-pernikahan*') ? 'text-rose-600 font-semibold' : '' }} flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z"/></svg>
                        <span>Kursus Nikah</span>
                    </a>
                    @auth
                        <a href="{{ route('dashboard.index') }}" class="bg-primary-700 text-white text-sm px-4 py-2 rounded-lg hover:bg-primary-800 transition-colors font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-primary-700 text-white text-sm px-4 py-2 rounded-lg hover:bg-primary-800 transition-colors font-medium">Login</a>
                    @endauth
                    <a href="{{ route('kontak') }}" class="border-2 border-primary-700 text-primary-700 text-sm px-4 py-2 rounded-lg hover:bg-primary-600 hover:text-white hover:border-primary-600 transition-colors font-medium">Kontak</a>
                </div>

                {{-- Mobile Hamburger --}}
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-white/10 transition-colors">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="md:hidden hidden pb-4 border-t border-gray-200 mt-2 pt-4">
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('home') }}" class="nav-link text-sm px-2 py-1">Beranda</a>
                    <a href="{{ route('profil') }}" class="nav-link text-sm px-2 py-1">Profil</a>
                    <a href="{{ route('berita') }}" class="nav-link text-sm px-2 py-1">Berita</a>
                    <a href="{{ route('galeri') }}" class="nav-link text-sm px-2 py-1">Galeri</a>
                    <a href="{{ route('kursus-pernikahan') }}" class="nav-link text-sm px-2 py-1 text-rose-500">Kursus Nikah</a>
                    @auth
                        <a href="{{ route('dashboard.index') }}" class="block px-2 py-2 rounded-lg bg-primary-700 text-white text-sm font-medium text-center hover:bg-primary-800">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block px-2 py-2 rounded-lg bg-primary-700 text-white text-sm font-medium text-center hover:bg-primary-800">Login</a>
                    @endauth
                    <a href="{{ route('kontak') }}" class="nav-link text-sm px-2 py-1">Kontak</a>
                </div>
            </div>
        </div>
    </nav>
    @endunless

    {{-- Main Content – satu wrapper agar background sama di semua halaman --}}
    <div class="site-content-wrap">
        <main>
            @yield('content')
        </main>

        {{-- Footer satu style untuk semua halaman (kecuali login) --}}
        @unless(request()->routeIs('login'))
        <footer class="site-footer">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0 border border-white/30">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-white text-sm">Biara Loresa SCJ</span>
                    </a>
                    <div class="flex items-center gap-6 text-sm">
                        <span class="text-white/60 text-xs">&copy; {{ date('Y') }} Biara Loresa SCJ</span>
                    </div>
                </div>
            </div>
        </footer>
        @endunless
    </div>

    <script>
        var btn = document.getElementById('mobile-menu-btn');
        if (btn) {
            btn.addEventListener('click', function() {
                var menu = document.getElementById('mobile-menu');
                if (menu) menu.classList.toggle('hidden');
            });
        }
    </script>
    <script>
        (function() {
            var els = document.querySelectorAll('[data-home-animate]');
            if (!els.length) return;
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    var el = entry.target;
                    if (entry.isIntersecting) {
                        el.classList.add('animated-in');
                        el.classList.remove('animated-out');
                    } else {
                        el.classList.add('animated-out');
                        el.classList.remove('animated-in');
                    }
                });
            }, { rootMargin: '0px 0px -8% 0px', threshold: 0 });
            els.forEach(function(el) { observer.observe(el); });
        })();
    </script>
</body>
</html>
