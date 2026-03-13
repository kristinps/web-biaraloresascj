<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Biara Loresa SCJ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w: 260px;
            --indigo: #6366f1;
            --indigo-dark: #4f46e5;
            --purple: #8b5cf6;
            --bg: #f1f5f9;
            --surface: #ffffff;
            --border: #e2e8f0;
            --text: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        /* ─── Sidebar ─── */
        .sidebar {
            width: var(--sidebar-w);
            background: #1e2685;
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }
        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-brand .brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px; height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--indigo), var(--purple));
            box-shadow: 0 6px 16px rgba(99,102,241,0.4);
            margin-bottom: 12px;
        }
        .sidebar-brand .brand-icon svg { width: 22px; height: 22px; color: #fff; }
        .sidebar-brand h2 {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            line-height: 1.3;
        }
        .sidebar-brand p {
            font-size: 11.5px;
            color: rgba(255,255,255,0.45);
            margin-top: 2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }
        .nav-section {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: rgba(255,255,255,0.3);
            padding: 12px 12px 6px;
            margin-top: 4px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,0.65);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.18s, color 0.18s;
            margin-bottom: 2px;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(99,102,241,0.35), rgba(139,92,246,0.25));
            color: #fff;
            font-weight: 600;
        }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(255,255,255,0.06);
        }
        .sidebar-user .avatar {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--indigo), var(--purple));
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .sidebar-user .info { flex: 1; min-width: 0; }
        .sidebar-user .info .name {
            font-size: 13px; font-weight: 600; color: #fff;
            overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }
        .sidebar-user .info .role {
            font-size: 11px; color: rgba(255,255,255,0.4);
        }
        .logout-btn {
            background: none; border: none; cursor: pointer;
            color: rgba(255,255,255,0.4); padding: 4px;
            transition: color 0.2s; border-radius: 6px;
        }
        .logout-btn:hover { color: #f87171; }
        .logout-btn svg { width: 16px; height: 16px; }

        /* ─── Main (full cover) ─── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-width: 0;
            width: 100%;
            min-height: 100vh;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: auto;
        }

        /* ─── Content (full cover) ─── */
        .content {
            flex: 1;
            min-height: 100%;
            padding: 40px 28px 28px;
        }

        /* ─── Full banner background (semua halaman dashboard) ─── */
        .dashboard-banner-wrap {
            position: relative;
            min-height: 100vh;
            margin: -28px;
            padding: 28px;
            overflow: hidden;
        }
        .dashboard-banner-wrap::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 0;
        }
        .dashboard-banner-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(30,38,133,0.88) 0%, rgba(61,86,245,0.65) 100%);
            z-index: 1;
        }
        .dashboard-banner-inner {
            position: relative;
            z-index: 2;
        }

        /* ─── Toast alert ─── */
        .toast {
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 13.5px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .toast-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
        }
        .toast-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }
        .toast svg { width: 17px; height: 17px; flex-shrink: 0; }

        /* ─── Mobile menu toggle (floating) ─── */
        .menu-toggle-fab {
            display: none;
            position: fixed;
            top: 12px;
            right: 12px;
            left: auto;
            z-index: 60;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            background: var(--surface);
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            align-items: center;
            justify-content: center;
            color: var(--text);
            transition: opacity 0.2s, visibility 0.2s;
        }
        .menu-toggle-fab.menu-toggle-hidden { visibility: hidden; opacity: 0; pointer-events: none; }
        .menu-toggle-fab svg { width: 22px; height: 22px; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; min-height: 100vh; height: auto; }
            .menu-toggle-fab { display: flex; }
            .content { padding: 32px 16px 20px; min-height: auto; }
            .dashboard-banner-wrap { margin: -20px -16px; padding: 20px 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
            </svg>
        </div>
        <h2>Biara Loresa SCJ</h2>
        <p>Dashboard Peserta</p>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Menu Utama</div>

        <a href="{{ route('user.status-pendaftaran') }}"
           class="nav-item {{ request()->routeIs('user.status-pendaftaran') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
            </svg>
            Status Pendaftaran
        </a>

        <!-- <a href="{{ route('user.dokumen') }}"
           class="nav-item {{ request()->routeIs('user.dokumen') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
            </svg>
            Kelengkapan Dokumen
        </a> -->

        <!-- <a href="{{ route('user.jadwal-materi') }}"
           class="nav-item {{ request()->routeIs('user.jadwal-materi') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
            </svg>
            Jadwal Materi
        </a> -->

        <!-- <a href="{{ route('user.pembayaran') }}"
           class="nav-item {{ request()->routeIs('user.pembayaran') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5h6m-6-2.25h3m-3.75 3V6.75m9 0V9m0 0v2.25m0-4.5V9"/>
            </svg>
            Pembayaran Pendaftaran
        </a> -->
<!-- 
        <a href="{{ route('user.biaya') }}"
           class="nav-item {{ request()->routeIs('user.biaya') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Biaya Pendaftaran
        </a>

        <a href="{{ route('user.sertifikat') }}"
           class="nav-item {{ request()->routeIs('user.sertifikat') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
            </svg>
            Sertifikat
        </a> -->

        <!-- <div class="nav-section">Akun</div>

        <a href="{{ route('user.profil') }}"
           class="nav-item {{ request()->routeIs('user.profil') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0V21h-15v-.75z"/>
            </svg>
            Profil Saya
        </a>

        <a href="{{ route('user.password') }}"
           class="nav-item {{ request()->routeIs('user.password') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
            </svg>
            Ubah Password
        </a> -->
<!-- 
        <div class="nav-section">Aksi</div>

        <a href="{{ route('kursus-pernikahan') }}" class="nav-item">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Daftar Kursus Pernikahan
        </a>

        <a href="{{ route('home') }}" class="nav-item" target="_blank">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
            Beranda
        </a> -->
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
            <div class="info">
                <div class="name">{{ auth()->user()->name ?? 'Peserta' }}</div>
                <div class="role">Peserta Kursus</div>
            </div>
            <form method="POST" action="{{ route('user.logout') }}">
                @csrf
                <button type="submit" class="logout-btn" title="Keluar">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- Main --}}
<div class="main">
    <button class="menu-toggle-fab" id="menuToggleBtn" onclick="toggleSidebar()" aria-label="Buka menu">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
        </svg>
    </button>
    <main class="content">
        <div class="dashboard-banner-wrap">
            <div class="dashboard-banner-inner">
                @if(session('success'))
                    <div class="toast toast-success">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="toast toast-error">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </main>
</div>

<script>
function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    var btn = document.getElementById('menuToggleBtn');
    if (sidebar) sidebar.classList.toggle('open');
    if (btn) btn.classList.toggle('menu-toggle-hidden', sidebar && sidebar.classList.contains('open'));
}
</script>
@stack('scripts')
</body>
</html>
