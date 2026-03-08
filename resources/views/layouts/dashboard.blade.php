<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Biara Loresa SCJ</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --sidebar-w: 260px;
            --primary: #2230ce;
            --primary-light: #3d56f5;
            --gold: #f0c14b;
            --hero-overlay: linear-gradient(135deg, rgba(30,38,133,0.88) 0%, rgba(61,86,245,0.65) 100%);
        }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: #1e293b; min-height: 100vh; display: flex; }
        .sidebar {
            width: var(--sidebar-w); min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100;
            background: #1e2685;
            display: flex; flex-direction: column; transition: transform 0.3s ease;
        }
        .sidebar-brand { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand .brand-icon {
            width: 42px; height: 42px; border-radius: 12px;
            background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;
            margin-bottom: 10px;
        }
        .sidebar-brand .brand-icon svg { width: 22px; height: 22px; color: #fff; }
        .sidebar-brand h2 { font-size: 15px; font-weight: 700; color: #fff; }
        .sidebar-brand p { font-size: 11px; color: rgba(255,255,255,0.6); margin-top: 2px; }
        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
        .nav-section { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(255,255,255,0.4); padding: 10px 12px 4px; }
        .nav-item {
            display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px;
            color: rgba(255,255,255,0.8); font-size: 14px; font-weight: 500; text-decoration: none;
            transition: background 0.2s, color 0.2s; margin-bottom: 2px;
        }
        .nav-item:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .nav-item.logout-btn-nav:hover { background: rgba(248,113,113,0.25); color: #fca5a5; }
        .nav-item.active { background: rgba(255,255,255,0.2); color: #fff; font-weight: 600; }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-footer { padding: 16px 12px; border-top: 1px solid rgba(255,255,255,0.1); }
        .sidebar-user { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; background: rgba(255,255,255,0.08); }
        .sidebar-user .avatar {
            width: 36px; height: 36px; border-radius: 10px; background: var(--gold); color: #1e2685;
            display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; flex-shrink: 0;
        }
        .sidebar-user .info { flex: 1; min-width: 0; }
        .sidebar-user .name { font-size: 13px; font-weight: 600; color: #fff; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .sidebar-user .role { font-size: 11px; color: rgba(255,255,255,0.5); }
        .logout-btn { background: none; border: none; cursor: pointer; color: rgba(255,255,255,0.5); padding: 4px; border-radius: 6px; }
        .logout-btn:hover { color: #f87171; }
        .main { margin-left: var(--sidebar-w); flex: 1; min-height: 100vh; display: flex; flex-direction: column; }
        .content { flex: 1; padding: 28px; }
        .dashboard-banner-wrap {
            position: relative; min-height: 100vh; min-height: 100dvh; margin: -28px; padding: 28px; overflow: hidden;
        }
        .dashboard-banner-wrap::before {
            content: ''; position: absolute; inset: 0;
            background-image: url('https://images.unsplash.com/photo-1438032005730-c779502df39b?w=1920&h=1080&fit=crop');
            background-size: cover; background-position: center; background-repeat: no-repeat; z-index: 0;
        }
        .dashboard-banner-wrap::after { content: ''; position: absolute; inset: 0; background: var(--hero-overlay); z-index: 1; }
        .dashboard-banner-inner { position: relative; z-index: 2; }
        .toast {
            border-radius: 10px; padding: 12px 16px; font-size: 13px; margin-bottom: 16px;
            display: inline-flex; align-items: center; gap: 10px; max-width: 100%;
            background: rgba(255,255,255,0.96); border: 1px solid rgba(0,0,0,0.06);
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .toast svg { width: 18px; height: 18px; flex-shrink: 0; }
        .toast-success { background: rgba(240,253,244,0.98); border-color: #bbf7d0; color: #15803d; }
        .toast-success svg { color: #16a34a; }
        .toast-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
        .menu-toggle { display: none; position: fixed; top: 12px; left: 12px; z-index: 60; width: 44px; height: 44px; border-radius: 12px; border: none; cursor: pointer; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.15); align-items: center; justify-content: center; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .menu-toggle { display: flex; }
            .content { padding: 20px 16px; }
            .dashboard-banner-wrap { margin: -20px -16px; padding: 20px 16px; }
        }
    </style>
    @stack('styles')
    {{-- Tema beranda: tabel di setiap halaman wajib mengikuti style halaman beranda --}}
    <style>
        .dashboard-banner-inner .card {
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        .dashboard-banner-inner table { width: 100%; border-collapse: collapse; }
        .dashboard-banner-inner thead th {
            padding: 12px 18px;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #2129a7;
            background: linear-gradient(180deg, #f0f4ff 0%, #eef2ff 100%);
            text-align: left;
            border-bottom: 1px solid #bfd0ff;
        }
        .dashboard-banner-inner tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
        .dashboard-banner-inner tbody tr:hover { background: #f8faff; }
        .dashboard-banner-inner tbody tr:last-child { border-bottom: none; }
        .dashboard-banner-inner tbody td {
            padding: 13px 18px;
            font-size: 13.5px;
            color: #374151;
            vertical-align: middle;
        }
        .dashboard-banner-inner .table-wrap { overflow-x: auto; }
        .dashboard-banner-inner .pagination-wrap,
        .dashboard-banner-inner .dashboard-table-footer {
            padding: 14px 20px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: flex-end;
        }
        /* Tombol aksi di semua tabel - tema beranda */
        .dashboard-banner-inner tbody td:last-child {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }
        .dashboard-banner-inner tbody td:last-child.text-right {
            justify-content: flex-end;
        }
        .dashboard-banner-inner .table-action-btn,
        .dashboard-banner-inner tbody .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
            background: #f0f4ff;
            color: #2129a7;
            border: 1px solid #bfd0ff;
        }
        .dashboard-banner-inner .table-action-btn:hover,
        .dashboard-banner-inner tbody .btn-detail:hover {
            background: #dce6ff;
            color: #1e2685;
        }
        .dashboard-banner-inner .table-action-btn svg,
        .dashboard-banner-inner tbody .btn-detail svg {
            width: 14px;
            height: 14px;
        }
        .dashboard-banner-inner .table-action-btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        .dashboard-banner-inner .table-action-btn-danger:hover {
            background: #fee2e2;
            color: #b91c1c;
        }
        .dashboard-banner-inner .table-action-btn-danger svg {
            width: 14px;
            height: 14px;
        }
        .dashboard-banner-inner tbody .btn-bayar {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            background: linear-gradient(135deg, #2230ce, #3d56f5);
            color: #fff !important;
            border: none;
            transition: opacity 0.2s, box-shadow 0.2s;
        }
        .dashboard-banner-inner tbody .btn-bayar:hover {
            opacity: 0.92;
            box-shadow: 0 4px 12px rgba(34, 48, 206, 0.35);
        }
        .dashboard-banner-inner tbody .btn-pindah {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid #fcd34d;
            background: #fffbeb;
            color: #b45309;
            transition: background 0.2s, color 0.2s;
        }
        .dashboard-banner-inner tbody .btn-pindah:hover {
            background: #fef3c7;
            color: #92400e;
        }
        .dashboard-banner-inner tbody .btn-pindah svg {
            width: 12px;
            height: 12px;
        }
        .dashboard-banner-inner tbody .table-action-link {
            font-size: 12.5px;
            font-weight: 600;
            color: #2129a7;
            text-decoration: none;
            padding: 6px 0;
            transition: color 0.2s;
        }
        .dashboard-banner-inner tbody .table-action-link:hover {
            color: #1e2685;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/></svg>
        </div>
        <h2>Biara Loresa SCJ</h2>
        <p>Dashboard</p>
    </div>
    <nav class="sidebar-nav">
        @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
            <div class="nav-section">Menu Admin</div>
            <a href="{{ route('dashboard.index') }}" class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('dashboard.pendaftaran.index') }}" class="nav-item {{ request()->routeIs('dashboard.pendaftaran.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                Pendaftaran
            </a>
            <a href="{{ route('dashboard.periode.index') }}" class="nav-item {{ request()->routeIs('dashboard.periode.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Manajemen Peserta
            </a>
            <a href="{{ route('dashboard.materi.periode-list') }}" class="nav-item {{ request()->routeIs('dashboard.materi.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Materi
            </a>
            <a href="{{ route('dashboard.kehadiran.periode-list') }}" class="nav-item {{ request()->routeIs('dashboard.kehadiran.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Kehadiran
            </a>
            @if(auth()->user()->isSuperAdmin())
            <div class="nav-section">Super Admin</div>
            <a href="{{ route('dashboard.admin-crud.index') }}" class="nav-item {{ request()->routeIs('dashboard.admin-crud.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                CRUD Admin
            </a>
            @endif
        @else
            <div class="nav-section">Menu Peserta</div>
            <a href="{{ route('dashboard.index') }}" class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('dashboard.user.status-pendaftaran') }}" class="nav-item {{ request()->routeIs('dashboard.user.status-pendaftaran') ? 'active' : '' }}">Status Pendaftaran</a>
            <a href="{{ route('dashboard.user.dokumen') }}" class="nav-item {{ request()->routeIs('dashboard.user.dokumen') ? 'active' : '' }}">Status Dokumen</a>
            <a href="{{ route('dashboard.user.jadwal-materi') }}" class="nav-item {{ request()->routeIs('dashboard.user.jadwal-materi') ? 'active' : '' }}">Jadwal Materi</a>
            <a href="{{ route('dashboard.user.biaya') }}" class="nav-item {{ request()->routeIs('dashboard.user.biaya') ? 'active' : '' }}">Biaya</a>
            <a href="{{ route('dashboard.user.sertifikat') }}" class="nav-item {{ request()->routeIs('dashboard.user.sertifikat') ? 'active' : '' }}">Surat Kelulusan</a>
            <div class="nav-section">Akun</div>
            <a href="{{ route('dashboard.user.profil') }}" class="nav-item {{ request()->routeIs('dashboard.user.profil') ? 'active' : '' }}">Profil</a>
            <a href="{{ route('dashboard.user.password') }}" class="nav-item {{ request()->routeIs('dashboard.user.password') ? 'active' : '' }}">Ubah Sandi</a>
        @endif
        <div class="nav-section">Umum</div>
        <a href="{{ route('home') }}" class="nav-item" target="_blank">Beranda</a>
        <div class="nav-section">Akun</div>
        <form method="POST" action="{{ route('logout') }}" class="block">
            @csrf
            <button type="submit" class="nav-item logout-btn-nav w-full text-left cursor-pointer border-0 bg-transparent" style="font-size:14px;color:rgba(255,255,255,0.8);padding:10px 12px;border-radius:10px;display:flex;align-items:center;gap:10px;margin-bottom:2px;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
            <div class="info">
                <div class="name">{{ auth()->user()->name ?? 'User' }}</div>
                <div class="role">{{ auth()->user()->role === 'super_admin' ? 'Super Admin' : (auth()->user()->role === 'admin' ? 'Admin' : 'Peserta') }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn" title="Keluar">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </div>
</aside>

<div class="main">
    <button class="menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')" aria-label="Menu">☰</button>
    <main class="content">
        <div class="dashboard-banner-wrap">
            <div class="dashboard-banner-inner">
                @if(session('success'))
                    <div class="toast toast-success" role="alert">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="toast toast-error">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                        {{ session('error') }}
                    </div>
                @endif
                {{-- Bar atas: nama user + tombol Logout (semua role: admin, super_admin, peserta) --}}
                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                    <p class="text-white/90 text-sm font-medium">
                        Hai, <span class="font-semibold text-white">{{ auth()->user()->name ?? 'User' }}</span>
                    </p>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-white text-primary-800 hover:bg-gray-50 transition-colors shadow-md border border-white/40">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
                @yield('content')
            </div>
        </div>
    </main>
</div>
@stack('scripts')
</body>
</html>
