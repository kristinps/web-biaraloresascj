@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'layouts.dashboard')

@section('title', 'Pendaftaran Kursus Pernikahan')
@section('page-title', 'Pendaftaran Kursus Pernikahan')
@section('page-subtitle', 'Lengkapi dan cek kembali data calon mempelai.')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #2563eb;
        --primary-soft: #dbeafe;
        --accent: #f97316;
        --accent-soft: #fff7ed;
        --danger: #ef4444;
        --success: #16a34a;
        --text-main: #0f172a;
        --text-muted: #6b7280;
        --card-bg: rgba(255, 255, 255, 0.98);
        --border-subtle: rgba(148, 163, 184, 0.25);
        --radius-xl: 1.25rem;
    }

    .pendaftaran-page {
        min-height: calc(100vh - 180px);
        background: radial-gradient(circle at top left, #e0f2fe 0, rgba(224, 242, 254, 0) 45%),
                    radial-gradient(circle at bottom right, #e9d5ff 0, rgba(233, 213, 255, 0) 45%),
                    linear-gradient(135deg, #1d4ed8, #7c3aed);
        padding: 1.75rem 1.5rem 2.5rem;
        border-radius: 1.5rem;
        position: relative;
        overflow: hidden;
        font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .pendaftaran-page::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.18) 0, transparent 55%),
            radial-gradient(circle at 80% 80%, rgba(15, 23, 42, 0.25) 0, transparent 60%);
        opacity: 0.7;
        mix-blend-mode: soft-light;
        pointer-events: none;
    }

    .pendaftaran-inner {
        position: relative;
        z-index: 1;
        max-width: 960px;
        margin: 0 auto;
        color: var(--text-main);
    }

    .pendaftaran-header {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.75rem;
        color: #e5e7eb;
    }

    .pendaftaran-header-main h1 {
        font-size: 1.5rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        margin-bottom: 0.25rem;
    }

    .pendaftaran-header-main p {
        font-size: 0.9rem;
        color: #e5e7eb;
        opacity: 0.9;
    }

    .pendaftaran-header-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.35rem;
        font-size: 0.8rem;
    }

    .pendaftaran-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.75rem;
        border-radius: 999px;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(148, 163, 184, 0.6);
        font-size: 0.75rem;
    }

    .pendaftaran-pill span:first-child {
        font-size: 0.9rem;
    }

    .pendaftaran-card-shell {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.18), rgba(15, 23, 42, 0.06));
        border-radius: var(--radius-xl);
        padding: 1.1rem;
        border: 1px solid rgba(148, 163, 184, 0.35);
        box-shadow:
            0 26px 60px rgba(15, 23, 42, 0.6),
            0 0 0 1px rgba(148, 163, 184, 0.28);
    }

    .pendaftaran-main-card {
        background: var(--card-bg);
        border-radius: calc(var(--radius-xl) - 0.35rem);
        padding: 1.5rem 1.75rem 1.6rem;
        box-shadow: 0 18px 44px rgba(15, 23, 42, 0.16);
        border: 1px solid var(--border-subtle);
        position: relative;
        overflow: hidden;
    }

    .pendaftaran-main-card::before {
        content: '';
        position: absolute;
        inset-inline: 0;
        top: 0;
        height: 4px;
        background: linear-gradient(90deg, #22d3ee, #6366f1, #f97316);
        opacity: 0.85;
    }

    .pendaftaran-subhead {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 0.85rem;
        margin-bottom: 1.35rem;
    }

    .pendaftaran-subhead-text {
        max-width: 60%;
    }

    .pendaftaran-subhead-title {
        font-size: 0.9rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #4b5563;
        margin-bottom: 0.35rem;
    }

    .pendaftaran-subhead-desc {
        font-size: 0.8rem;
        color: #6b7280;
    }

    .pendaftaran-subhead-meta {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        font-size: 0.8rem;
        align-items: flex-end;
        text-align: right;
    }

    .pendaftaran-meta-row {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.3rem 0.7rem;
        border-radius: 999px;
        background: var(--primary-soft);
        color: #1d4ed8;
        font-weight: 500;
    }

    .pendaftaran-meta-row svg {
        width: 14px;
        height: 14px;
    }

    .pendaftaran-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr);
        align-items: stretch;
        gap: 1.4rem;
    }

    .pendaftaran-person-card {
        background: #f9fafb;
        border-radius: 1rem;
        padding: 1rem 1.1rem 1.05rem;
        box-shadow: 0 12px 26px rgba(15, 23, 42, 0.12);
        border: 1px solid rgba(209, 213, 219, 0.9);
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .pendaftaran-person-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #6b7280;
        margin-bottom: 0.15rem;
    }

    .pendaftaran-person-name {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 0.1rem;
    }

    .pendaftaran-person-field {
        font-size: 0.8rem;
        color: #4b5563;
    }

    .pendaftaran-person-field span {
        color: #6b7280;
        font-weight: 500;
        margin-right: 0.25rem;
    }

    .pendaftaran-heart-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 0.75rem;
    }

    .pendaftaran-heart {
        width: 3rem;
        height: 3rem;
        border-radius: 999px;
        background: radial-gradient(circle at 30% 20%, #fee2e2 0, #fecaca 35%, #fb7185 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 16px 32px rgba(248, 113, 113, 0.6);
    }

    .pendaftaran-heart svg {
        width: 20px;
        height: 20px;
        fill: #ffffff;
    }

    .pendaftaran-footer {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 0.8rem;
        margin-top: 1.4rem;
        align-items: center;
        font-size: 0.8rem;
        color: #6b7280;
    }

    .pendaftaran-footer-main {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .pendaftaran-footer-main svg {
        width: 15px;
        height: 15px;
        color: #4b5563;
    }

    .pendaftaran-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        border: 1px solid rgba(37, 99, 235, 0.23);
        background: linear-gradient(135deg, #dbeafe, #e0f2fe);
        color: #1d4ed8;
    }

    .pendaftaran-status-dot {
        width: 7px;
        height: 7px;
        border-radius: 999px;
        background: #22c55e;
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.2);
    }

    .pendaftaran-actions {
        margin-top: 1.2rem;
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    .btn-outline-soft,
    .btn-primary-gradient {
        border-radius: 999px;
        font-size: 0.8rem;
        padding: 0.55rem 1.15rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border: none;
        cursor: pointer;
        transition: transform 0.12s ease, box-shadow 0.12s ease, background 0.15s ease, color 0.15s ease;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-outline-soft {
        background: rgba(15, 23, 42, 0.03);
        border: 1px solid rgba(148, 163, 184, 0.7);
        color: #0f172a;
    }

    .btn-outline-soft:hover {
        background: rgba(15, 23, 42, 0.08);
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.18);
    }

    .btn-primary-gradient {
        background: linear-gradient(135deg, #1d4ed8, #6366f1);
        color: #f9fafb;
        box-shadow: 0 12px 28px rgba(37, 99, 235, 0.5);
    }

    .btn-primary-gradient:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 34px rgba(37, 99, 235, 0.7);
    }

    .btn-primary-gradient svg,
    .btn-outline-soft svg {
        width: 14px;
        height: 14px;
    }

    @media (max-width: 768px) {
        .pendaftaran-page {
            padding: 1.4rem 1.1rem 2rem;
            border-radius: 1.25rem;
        }

        .pendaftaran-main-card {
            padding: 1.25rem 1.2rem 1.4rem;
        }

        .pendaftaran-subhead {
            flex-direction: column;
        }

        .pendaftaran-subhead-text {
            max-width: 100%;
        }

        .pendaftaran-subhead-meta {
            align-items: flex-start;
            text-align: left;
        }

        .pendaftaran-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 0.9rem;
        }

        .pendaftaran-heart-wrap {
            order: -1;
            padding: 0.25rem 0;
        }
    }

    @media (max-width: 480px) {
        .pendaftaran-header {
            margin-bottom: 1.25rem;
        }

        .pendaftaran-header-main h1 {
            font-size: 1.25rem;
        }
    }
</style>
@endpush

@section('content')
<div class="pendaftaran-page">
    <div class="pendaftaran-inner">
        <div class="pendaftaran-header">
            <div class="pendaftaran-header-main">
                <h1>Pendaftaran Kursus Pernikahan</h1>
                <p>Pastikan seluruh data calon mempelai telah terisi dengan benar sebelum melanjutkan.</p>
            </div>
            <div class="pendaftaran-header-meta">
                <div class="pendaftaran-pill">
                    <span>📘</span>
                    <span>Kursus Pra-Nikah Paroki</span>
                </div>
                <div class="pendaftaran-pill">
                    <span>⏱</span>
                    <span>Estimasi waktu pengisian ± 5 menit</span>
                </div>
            </div>
        </div>

        <div class="pendaftaran-card-shell">
            <div class="pendaftaran-main-card">
                <div class="pendaftaran-subhead">
                    <div class="pendaftaran-subhead-text">
                        <div class="pendaftaran-subhead-title">Data Pendaftaran</div>
                        <div class="pendaftaran-subhead-desc">
                            Mohon isi data calon mempelai pria dan wanita sesuai kartu identitas resmi.
                        </div>
                    </div>
                    <div class="pendaftaran-subhead-meta">
                        <div class="pendaftaran-meta-row">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M7 2a1 1 0 0 0-1 1v1H5a3 3 0 0 0-3 3v11a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3h-1V3a1 1 0 1 0-2 0v1H9V3A1 1 0 0 0 8 2Zm-2 6h14a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1Z"/>
                            </svg>
                            <span>Periode Januari 2026</span>
                        </div>
                        <div class="pendaftaran-status-badge">
                            <span class="pendaftaran-status-dot"></span>
                            <span>Status: PROSES</span>
                        </div>
                    </div>
                </div>

                <div class="pendaftaran-grid">
                    <div class="pendaftaran-person-card">
                        <div class="pendaftaran-person-label">Calon Mempelai Pria</div>
                        <div class="pendaftaran-person-name"><strong>Budi Santoso</strong></div>
                        <div class="pendaftaran-person-field">
                            <span>NIK</span> 317101501890001
                        </div>
                        <div class="pendaftaran-person-field">
                            <span>TTL</span> Jakarta, 30 Desember 1991
                        </div>
                        <div class="pendaftaran-person-field">
                            <span>Pekerjaan</span> Karyawan Swasta
                        </div>
                        <div class="pendaftaran-person-field">
                            <span>Alamat</span> Jl. Sudirman No. 45, Jakarta Pusat
                        </div>
                    </div>

                    <div class="pendaftaran-heart-wrap" aria-hidden="true">
                        <div class="pendaftaran-heart">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12.001 4.529c2.349-2.35 6.157-2.35 8.506 0 2.35 2.35 2.35 6.157 0 8.507l-7.07 7.07a1 1 0 0 1-1.414 0l-7.07-7.07c-2.35-2.35-2.35-6.157 0-8.507 2.35-2.35 6.157-2.35 8.507 0Z" />
                            </svg>
                        </div>
                    </div>

                    <div class="pendaftaran-person-card">
                        <div class="pendaftaran-person-label">Calon Mempelai Wanita</div>
                        <div class="pendaftaran-person-name"><strong>Dewi Lestari</strong></div>
                        <div class="pendaftaran-person-field">
                            <span>NIK</span> 3201015502920002
                        </div>
                        <div class="pendaftaran-person-field">
                            <span>TTL</span> Bandung, 17 Maret 1996
                        </div>
                        <div class="pendaftaran-person-field">
                            <span>Pekerjaan</span> Guru
                        </div>
                        <div class="pendaftaran-person-field">
                            <span>Alamat</span> Jl. Merdeka No. 12, Bandung
                        </div>
                    </div>
                </div>

                <div class="pendaftaran-footer">
                    <div class="pendaftaran-footer-main">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M6 2a1 1 0 0 0-1 1v1H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1V3a1 1 0 1 0-2 0v1H8V3A1 1 0 0 0 7 2Zm-2 8h16v8H4v-8Z"/>
                        </svg>
                        <span>
                            Rencana pernikahan: <strong>31 Januari 2026</strong> di
                            <strong>Gereja Katedral Jakarta</strong>
                        </span>
                    </div>
                    <div>
                        <span class="pendaftaran-status-badge">
                            <span class="pendaftaran-status-dot"></span>
                            <span>Pengajuan Jadwal Terkonfirmasi</span>
                        </span>
                    </div>
                </div>

                <div class="pendaftaran-actions">
                    <button type="button" class="btn-outline-soft">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 5a1 1 0 0 1 1 1v5h4a1 1 0 1 1 0 2h-5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
                            <path d="M6.343 6.343a7.5 7.5 0 1 0 10.607 10.607 1 1 0 0 1 1.414 1.414A9.5 9.5 0 1 1 4.93 4.93a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        Simpan draft
                    </button>
                    <button type="submit" class="btn-primary-gradient">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M4 4.75 19.25 12 4 19.25 4 14l8-2-8-2z"/>
                        </svg>
                        Lanjutkan pendaftaran
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

