<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
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
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: #1e293b; min-height: 100vh; display: flex; overflow-x: hidden; }
        .sidebar {
            width: var(--sidebar-w); min-height: 100vh; min-height: 100dvh; position: fixed; top: 0; left: 0; z-index: 100;
            background: #1e2685;
            display: flex; flex-direction: column; transition: transform 0.3s ease;
            max-width: 85vw;
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
        .main { margin-left: var(--sidebar-w); flex: 1; min-height: 100vh; min-width: 0; display: flex; flex-direction: column; }
        .content { flex: 1; padding: 28px; min-width: 0; overflow-x: hidden; }
        .dashboard-banner-wrap {
            position: relative; min-height: 100vh; min-height: 100dvh; margin: -28px; padding: 28px; overflow-x: hidden; overflow-y: auto;
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
        .menu-toggle { display: none; position: fixed; top: 12px; right: 12px; left: auto; z-index: 102; width: 44px; height: 44px; border-radius: 12px; border: none; cursor: pointer; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.15); align-items: center; justify-content: center; transition: opacity 0.2s, visibility 0.2s; }
        .menu-toggle.menu-toggle-hidden { visibility: hidden; opacity: 0; pointer-events: none; }
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 99;
            opacity: 0;
            transition: opacity 0.25s ease;
        }
        .sidebar-overlay.open { display: block; opacity: 1; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); box-shadow: 4px 0 24px rgba(0,0,0,0.15); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .menu-toggle { display: flex; }
            .content { padding: 16px 12px; padding-top: 56px; }
            .dashboard-banner-wrap { margin: -16px -12px; margin-top: -56px; padding: 16px 12px; padding-top: 56px; }
            .dashboard-banner-inner .card { border-radius: 14px; }
            .dashboard-banner-inner thead th { padding: 10px 14px; font-size: 11px; }
            .dashboard-banner-inner tbody td { padding: 10px 14px; font-size: 13px; }
            .dashboard-banner-inner .table-wrap table { min-width: 520px; }
        }
        @media (min-width: 769px) and (max-width: 1024px) {
            .content { padding: 22px 20px; }
            .dashboard-banner-wrap { margin: -22px -20px; padding: 22px 20px; }
        }
        @media (min-width: 1280px) {
            .dashboard-banner-inner { max-width: 1280px; }
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
        .dashboard-banner-inner .table-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 -1px;
        }
        .dashboard-banner-inner .table-wrap table { min-width: 640px; }
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
    {{-- Style halaman dashboard user (peserta) --}}
    <style>
        .dashboard-user-content { width: 100%; min-width: 0; padding-top: 1.5rem; }
        @media (min-width: 640px) { .dashboard-user-content { padding-top: 2rem; } }
        .dashboard-user-header { margin-bottom: 1.5rem; }
        .dashboard-user-title { font-family: ui-serif, Georgia, serif; font-weight: 700; color: #fff; font-size: clamp(1.25rem, 4vw, 1.5rem); line-height: 1.3; margin-bottom: 0.25rem; }
        .dashboard-user-subtitle { color: rgba(255,255,255,0.8); font-size: 0.875rem; margin-bottom: 1rem; }
        .dashboard-user-actions { display: flex; flex-wrap: wrap; gap: 0.75rem; }
        .dashboard-user-btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; text-decoration: none; transition: background 0.2s, color 0.2s; }
        .dashboard-user-btn-icon { width: 1rem; height: 1rem; flex-shrink: 0; }
        .dashboard-user-btn-secondary { background: rgba(255,255,255,0.95); color: #1e2685; border: 1px solid rgba(255,255,255,0.3); }
        .dashboard-user-btn-secondary:hover { background: #fff; }
        .dashboard-user-btn-primary { background: #2230ce; color: #fff; border: 1px solid rgba(255,255,255,0.2); }
        .dashboard-user-btn-primary:hover { background: #1e2685; }
        .dashboard-user-card { background: rgba(255,255,255,0.95); border-radius: 0.75rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.2); overflow: hidden; }
        .dashboard-user-card--mt { margin-top: 2rem; }
        .dashboard-user-card-header { padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; }
        @media (min-width: 640px) { .dashboard-user-card-header { padding: 1rem 1.5rem; } }
        .dashboard-user-card-title { font-family: ui-serif, Georgia, serif; font-weight: 700; color: #1f2937; font-size: 1.125rem; }
        .dashboard-user-card-desc { font-size: 0.875rem; color: #6b7280; margin-top: 0.125rem; }
        .dashboard-user-card-body { }
        .dashboard-user-card-footer { padding: 0.75rem 1.25rem; border-top: 1px solid #f1f5f9; }
        @media (min-width: 640px) { .dashboard-user-card-footer { padding: 0.75rem 1.5rem; } }
        .dashboard-user-message { padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; }
        .dashboard-user-message:last-child { border-bottom: none; }
        @media (min-width: 640px) { .dashboard-user-message { padding: 1rem 1.5rem; } }
        .dashboard-user-message--unread { background: rgba(34, 48, 206, 0.06); }
        .dashboard-user-message-inner { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; }
        .dashboard-user-message-content { flex: 1; min-width: 0; }
        .dashboard-user-message-title { font-weight: 600; color: #1f2937; font-size: 0.9375rem; }
        .dashboard-user-message-text { font-size: 0.875rem; color: #4b5563; margin-top: 0.25rem; line-height: 1.5; word-break: break-word; }
        .dashboard-user-message-meta { font-size: 0.75rem; color: #9ca3af; margin-top: 0.5rem; }
        .dashboard-user-badge { flex-shrink: 0; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background: #e0e7ff; color: #3730a3; }
        .dashboard-user-empty { padding: 3rem 1.25rem; text-align: center; color: #6b7280; font-size: 0.875rem; }
        @media (min-width: 640px) { .dashboard-user-empty { padding: 3rem 1.5rem; } }
        .dashboard-user-list { list-style: none; }
        .dashboard-user-list-item { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 0.5rem 1rem; padding: 0.75rem 1.25rem; border-bottom: 1px solid #f1f5f9; }
        .dashboard-user-list-item:last-child { border-bottom: none; }
        @media (min-width: 640px) { .dashboard-user-list-item { padding: 0.75rem 1.5rem; } }
        .dashboard-user-list-name { font-weight: 500; color: #1f2937; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        @media (max-width: 479px) { .dashboard-user-list-name { white-space: normal; } }
        .dashboard-user-list-meta { font-size: 0.875rem; color: #6b7280; flex-shrink: 0; }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true" onclick="closeSidebar()"></div>
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
            <a href="{{ route('dashboard.periode.index') }}" class="nav-item {{ request()->routeIs('dashboard.periode.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                Periode
            </a>
            <a href="{{ route('dashboard.pendaftaran.index') }}" class="nav-item {{ request()->routeIs('dashboard.pendaftaran.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Pendaftaran
            </a>
        @else
            <div class="nav-section">Menu Peserta</div>
            <a href="{{ route('dashboard.index') }}" class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('user.status-pendaftaran') }}" class="nav-item {{ request()->routeIs('user.status-pendaftaran') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
                </svg>
                Status Pendaftaran
            </a>
            <a href="{{ route('user.dokumen') }}" class="nav-item {{ request()->routeIs('user.dokumen') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
                Kelengkapan Dokumen
            </a>
            <a href="{{ route('user.jadwal-materi') }}" class="nav-item {{ request()->routeIs('user.jadwal-materi') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
                Jadwal Materi
            </a>
            <a href="{{ route('user.pembayaran') }}" class="nav-item {{ request()->routeIs('user.pembayaran') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5h6m-6-2.25h3m-3.75 3V6.75m9 0V9m0 0v2.25m0-4.5V9"/>
                </svg>
                Pembayaran Pendaftaran
            </a>
            <a href="{{ route('user.biaya') }}" class="nav-item {{ request()->routeIs('user.biaya') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Biaya Pendaftaran
            </a>
            <a href="{{ route('user.sertifikat') }}" class="nav-item {{ request()->routeIs('user.sertifikat') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                </svg>
                Sertifikat
            </a>
            <a href="{{ route('user.profil') }}" class="nav-item {{ request()->routeIs('user.profil') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
                Profil
            </a>
        @endif
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
    <button class="menu-toggle" id="menuToggleBtn" onclick="toggleSidebar()" aria-label="Buka menu">☰</button>
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
               
                @yield('content')
            </div>
        </div>
    </main>
</div>
@stack('scripts')
<script>
function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var btn = document.getElementById('menuToggleBtn');
    sidebar.classList.toggle('open');
    if (overlay) overlay.classList.toggle('open', sidebar.classList.contains('open'));
    document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
    if (btn) btn.classList.toggle('menu-toggle-hidden', sidebar.classList.contains('open'));
}
function closeSidebar() {
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var btn = document.getElementById('menuToggleBtn');
    sidebar.classList.remove('open');
    if (overlay) overlay.classList.remove('open');
    document.body.style.overflow = '';
    if (btn) btn.classList.remove('menu-toggle-hidden');
}
</script>
</body>
</html>
