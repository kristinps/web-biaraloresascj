<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'Dashboard') — Admin Biara Loresa SCJ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w: 260px;
            --header-h: 64px;
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
            overflow-x: hidden;
        }

        /* ─── Sidebar ─── */
        .sidebar {
            width: var(--sidebar-w);
            max-width: 85vw;
            background: #1e2685;
            min-height: 100vh;
            min-height: 100dvh;
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
        .nav-badge {
            margin-left: auto;
            background: var(--indigo);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 99px;
        }

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

        /* ─── Main ─── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ─── Header ─── */
        .header {
            height: var(--header-h);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .header-left h1 {
            font-size: 17px;
            font-weight: 700;
            color: var(--text);
        }
        .header-left p {
            font-size: 12.5px;
            color: var(--text-muted);
            margin-top: 1px;
        }
        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .header-avatar {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--indigo), var(--purple));
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: #fff;
        }

        /* ─── Content ─── */
        .content {
            flex: 1;
            padding: 28px;
            min-width: 0;
        }

        .content-inner {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
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

        /* ─── Mobile toggle ─── */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text);
            padding: 6px;
            transition: opacity 0.2s, visibility 0.2s;
        }
        .menu-toggle.menu-toggle-hidden { visibility: hidden; opacity: 0; pointer-events: none; }
        .menu-toggle svg { width: 22px; height: 22px; }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.45);
            z-index: 90;
            opacity: 0;
            transition: opacity 0.25s ease;
        }
        .sidebar-overlay.open {
            display: block;
            opacity: 1;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table-wrap table {
            min-width: 640px;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); box-shadow: 4px 0 24px rgba(15,23,42,0.35); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .menu-toggle { display: flex; }
            .content { padding: 20px 16px; }
            .header { padding: 0 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()" aria-hidden="true"></div>

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
        <p>Panel Administrator</p>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Kursus Pernikahan</div>

        <a href="{{ route('admin.pendaftaran.index') }}"
           class="nav-item {{ request()->routeIs('admin.pendaftaran.index') || request()->routeIs('admin.pendaftaran.show') || request()->routeIs('admin.pendaftaran.masuk') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
            </svg>
            Daftar Pendaftaran
        </a>
        <a href="{{ route('admin.pendaftaran.dokumen-list') }}"
           class="nav-item {{ request()->routeIs('admin.pendaftaran.dokumen-list') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
            </svg>
            Dokumen Pendaftaran
        </a>

        <div class="nav-section">Sistem</div>

        <a href="{{ url('/') }}" class="nav-item" target="_blank">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
            </svg>
            Lihat Website
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="info">
                <div class="name">{{ auth()->user()->name }}</div>
                <div class="role">Administrator</div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
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
    <header class="header">
        <div style="display:flex;align-items:center;gap:12px">
            <div class="header-left">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>@yield('page-subtitle', 'Panel Administrator Biara Loresa SCJ')</p>
            </div>
        </div>
        <div class="header-right" style="display:flex;align-items:center;gap:12px">
            <button class="menu-toggle" id="menuToggleBtn" onclick="toggleSidebar()" aria-label="Buka menu">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>
            <div class="header-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        </div>
    </header>

    <main class="content">
        <div class="content-inner">
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
    </main>
</div>

<script>
function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var btn = document.getElementById('menuToggleBtn');
    if (!sidebar) return;
    var isOpen = sidebar.classList.toggle('open');
    if (overlay) overlay.classList.toggle('open', isOpen);
    document.body.style.overflow = isOpen ? 'hidden' : '';
    if (btn) btn.classList.toggle('menu-toggle-hidden', isOpen);
}
</script>
@stack('scripts')
</body>
</html>
