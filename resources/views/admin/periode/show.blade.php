@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', $periode->nama)
@section('page-title', $periode->nama)
@section('page-subtitle', 'Detail pendaftaran dalam periode ini')

@push('styles')
<style>
    .periode-show-page .periode-meta {
        background: linear-gradient(135deg, rgba(99,102,241,0.14), rgba(139,92,246,0.10), rgba(56,189,248,0.08));
        border-radius:14px; border:1px solid rgba(148,163,184,0.5);
        padding:18px 22px; display:flex; align-items:center; gap:14px;
        margin-bottom:24px; box-shadow:0 8px 24px rgba(15,23,42,0.08);
        backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    }
    .pi-icon { width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .pi-icon.aktif   { background:linear-gradient(135deg,#22c55e,#4ade80);box-shadow:0 4px 10px rgba(34,197,94,0.3); }
    .pi-icon.selesai { background:linear-gradient(135deg,#94a3b8,#cbd5e1); }
    .pi-icon svg { width:22px;height:22px;color:#fff; }
    .periode-show-page .pi-name  { font-size:16px;font-weight:700;color:#ffffff; }
    .periode-show-page .pi-dates { font-size:12.5px;color:rgba(255,255,255,0.9);margin-top:3px; }

    .badge-status { display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:99px;font-size:12px;font-weight:600; }
    .badge-dot { width:6px;height:6px;border-radius:50%; }
    .periode-show-page .badge-aktif  { background:rgba(34,197,94,0.35);color:#bbf7d0; } .badge-aktif .badge-dot  { background:#22c55e; }
    .periode-show-page .badge-selesai { background:rgba(148,163,184,0.35);color:#e2e8f0; } .badge-selesai .badge-dot { background:#94a3b8; }

    .stats-grid { display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:14px;margin-bottom:24px; }
    .periode-show-page .stat-card {
        background: linear-gradient(135deg, rgba(99,102,241,0.14), rgba(139,92,246,0.10), rgba(56,189,248,0.08));
        border-radius:14px; border:1px solid rgba(148,163,184,0.5);
        padding:18px 20px; box-shadow:0 8px 24px rgba(15,23,42,0.08);
        backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    }
    .periode-show-page .stat-card .val { font-size:26px;font-weight:800;color:#ffffff; }
    .periode-show-page .stat-card .lbl { font-size:12.5px;color:rgba(255,255,255,0.9);margin-top:3px;font-weight:500; }

    /* Batch action buttons */
    .batch-grid { display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;margin-bottom:24px; }
    .batch-btn {
        display:flex;align-items:center;gap:10px;padding:14px 16px;border-radius:12px;
        text-decoration:none;font-size:13px;font-weight:600;cursor:pointer;border:none;
        box-shadow:0 2px 8px rgba(0,0,0,0.08);transition:transform 0.15s,box-shadow 0.15s;
    }
    .batch-btn:hover { transform:translateY(-2px);box-shadow:0 6px 18px rgba(0,0,0,0.12); }
    .batch-btn svg { width:18px;height:18px;flex-shrink:0; }
    .btn-label { line-height:1.25; }
    .btn-label small { display:block;font-size:11px;font-weight:400;opacity:0.8; }
    .bb-blue   { background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff; }
    .bb-green  { background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff; }
    .bb-purple { background:linear-gradient(135deg,#8b5cf6,#6d28d9);color:#fff; }
    .bb-amber  { background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff; }
    .bb-teal   { background:linear-gradient(135deg,#14b8a6,#0d9488);color:#fff; }

    .periode-show-page .card {
        background: linear-gradient(135deg, rgba(99,102,241,0.14), rgba(139,92,246,0.10), rgba(56,189,248,0.08));
        border-radius:16px; border:1px solid rgba(148,163,184,0.5);
        box-shadow:0 8px 24px rgba(15,23,42,0.08); overflow:hidden;
        backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    }
    .periode-show-page .card-header { padding:18px 24px 14px; border-bottom:1px solid rgba(148,163,184,0.35); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
    .periode-show-page .card-header h2 { font-size:15px; font-weight:700; color:#ffffff; }

    table { width:100%; border-collapse:collapse; }
    td { vertical-align:middle; }
    .periode-show-page .card table th,
    .periode-show-page .card table td { color:#ffffff; border-bottom:1px solid rgba(148,163,184,0.35); padding:12px 16px; }
    .periode-show-page .card table thead th { background:rgba(99,102,241,0.15); font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; }
    .periode-show-page .card table tbody tr:hover { background:rgba(255,255,255,0.06); }
    .periode-show-page .td-num { color:#c7d2fe; font-weight:700; font-size:13px; }
    .periode-show-page .td-names { font-weight:600; color:#ffffff; }
    .periode-show-page .td-names small { display:block; font-size:12px; font-weight:400; color:rgba(255,255,255,0.8); }

    .badge { display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:99px;font-size:12px;font-weight:600; }
    .badge-dot2 { width:5px;height:5px;border-radius:50%; }
    .periode-show-page .badge-green  { background:rgba(34,197,94,0.35);color:#bbf7d0; } .badge-green .badge-dot2  { background:#22c55e; }
    .periode-show-page .badge-amber  { background:rgba(245,158,11,0.35);color:#fef3c7; } .badge-amber .badge-dot2  { background:#f59e0b; }
    .periode-show-page .badge-slate  { background:rgba(148,163,184,0.35);color:#e2e8f0; } .badge-slate .badge-dot2  { background:#94a3b8; }
    .periode-show-page .badge-red    { background:rgba(239,68,68,0.35);color:#fecaca; } .badge-red .badge-dot2    { background:#ef4444; }
    .periode-show-page .badge-blue   { background:rgba(59,130,246,0.35);color:#bfdbfe; } .badge-blue .badge-dot2   { background:#3b82f6; }

    .periode-show-page .btn-detail { display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:8px;background:rgba(255,255,255,0.2);color:#ffffff;font-size:12.5px;font-weight:600;text-decoration:none;transition:background 0.15s; }
    .periode-show-page .btn-detail:hover { background:rgba(99,102,241,0.5); color:#fff; }
    .btn-detail svg { width:13px;height:13px; }

    .periode-show-page .empty-state { text-align:center; padding:48px 24px; color:rgba(255,255,255,0.9); }
    .empty-state svg { width:48px;height:48px;margin:0 auto 14px; }
    .periode-show-page .empty-state p { font-size:14px; color:rgba(255,255,255,0.9); }

    .periode-show-page .pagination-wrap,
    .periode-show-page .dashboard-table-footer { padding:14px 24px; border-top:1px solid rgba(148,163,184,0.35); display:flex; justify-content:flex-end; }
    .periode-show-page .pagination-wrap a,
    .periode-show-page .pagination-wrap span,
    .periode-show-page .dashboard-table-footer a,
    .periode-show-page .dashboard-table-footer span { color:#ffffff !important; }

    .periode-show-page .btn-back { display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9px;background:rgba(255,255,255,0.2);color:#ffffff;font-size:13px;font-weight:600;text-decoration:none;transition:background 0.15s;margin-bottom:20px; }
    .periode-show-page .btn-back:hover { background:rgba(99,102,241,0.4); color:#fff; }
    .btn-back svg { width:14px;height:14px; }

    .periode-show-page .section-aksi-label { font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.6px; color:rgba(255,255,255,0.9); margin-bottom:10px; }

    /* Modal */
    .modal-overlay { display:none;position:fixed;inset:0;z-index:200;background:rgba(0,0,0,0.45);align-items:center;justify-content:center; }
    .modal-overlay.open { display:flex; }
    .modal-box { background:#fff;border-radius:18px;width:100%;max-width:480px;margin:20px;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden; }
    .modal-head { padding:18px 22px;display:flex;align-items:center;gap:9px;border-bottom:1px solid #f1f5f9; }
    .modal-head h3 { font-size:15px;font-weight:700;color:#1e293b; }
    .close-btn { margin-left:auto;background:none;border:none;cursor:pointer;color:#94a3b8;padding:4px;border-radius:6px; }
    .close-btn:hover { color:#475569; }
    .close-btn svg { width:18px;height:18px; }
    .modal-body { padding:22px; }
    .modal-body textarea { width:100%;padding:10px 13px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13.5px;color:#1e293b;font-family:inherit;outline:none;transition:border-color 0.2s;resize:vertical;min-height:100px; }
    .modal-body textarea:focus { border-color:#6366f1; }
    .modal-body label { display:block;font-size:12.5px;font-weight:600;color:#374151;margin-bottom:6px; }
    .modal-footer { padding:16px 22px;background:#f8fafc;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;gap:10px; }
    .btn-cancel { padding:8px 18px;border-radius:8px;background:#f1f5f9;color:#475569;font-size:13px;font-weight:600;border:none;cursor:pointer; }
    .btn-submit-modal { padding:8px 20px;border-radius:8px;font-size:13px;font-weight:600;border:none;cursor:pointer;color:#fff; }
</style>
@endpush

@section('content')
<div class="periode-show-page">
<a href="{{ route($routePrefix . '.periode.index') }}" class="btn-back">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
    </svg>
    Kembali
</a>

{{-- Periode info --}}
<div class="periode-meta">
    <div class="pi-icon {{ $periode->status }}">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
        </svg>
    </div>
    <div>
        <div class="pi-name">{{ $periode->nama }}</div>
        <div class="pi-dates">
            Mulai: {{ $periode->tanggal_mulai->format('d M Y') }}
            @if($periode->tanggal_selesai) &nbsp;·&nbsp; Selesai: {{ $periode->tanggal_selesai->format('d M Y') }} @endif
            @if($periode->catatan) &nbsp;·&nbsp; {{ $periode->catatan }} @endif
        </div>
    </div>
    <span class="badge-status badge-{{ $periode->status }}" style="margin-left:auto">
        <span class="badge-dot"></span>{{ ucfirst($periode->status) }}
    </span>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card"><div class="val" style="color:#6366f1">{{ $stats['total'] }}</div><div class="lbl">Total Pendaftar</div></div>
    <div class="stat-card"><div class="val" style="color:#22c55e">{{ $stats['lunas'] }}</div><div class="lbl">Lunas</div></div>
    <div class="stat-card"><div class="val" style="color:#f59e0b">{{ $stats['menunggu'] }}</div><div class="lbl">Menunggu Pembayaran</div></div>
    <div class="stat-card"><div class="val" style="color:#94a3b8">{{ $stats['belum_bayar'] }}</div><div class="lbl">Belum Bayar</div></div>
</div>

{{-- Aksi Batch per Periode --}}
<div style="margin-bottom:24px">
    <div class="section-aksi-label">
        Aksi Kursus (berlaku untuk semua peserta dalam periode ini)
    </div>
    <div class="batch-grid">
        <button onclick="openModal('modal-jadwal')" class="batch-btn bb-blue">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            <div class="btn-label">Kirim Jadwal Kursus<small>Email ke semua peserta</small></div>
        </button>
        <a href="{{ route($routePrefix . '.materi.index', $periode) }}" class="batch-btn bb-purple">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/></svg>
            <div class="btn-label">Kelola Materi Kursus<small>Tambah materi & kirim ke peserta</small></div>
        </a>
        <a href="{{ route($routePrefix . '.kehadiran.index', $periode) }}" class="batch-btn bb-amber">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="btn-label">Absensi & Status Kursus<small>Kelola kehadiran peserta</small></div>
        </a>
        <button onclick="openModal('modal-sertifikat')" class="batch-btn bb-green">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg>
            <div class="btn-label">Kirim Sertifikat Lulus<small>Hanya peserta berstatus lulus</small></div>
        </button>
        <button onclick="openModal('modal-jadsel')" class="batch-btn bb-teal">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
            <div class="btn-label">Kirim Jadwal Selanjutnya<small>Informasi kegiatan berikutnya</small></div>
        </button>
    </div>
</div>

{{-- Modal: Kirim Jadwal Kursus --}}
<div class="modal-overlay" id="modal-jadwal">
    <div class="modal-box">
        <div class="modal-head">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;color:#3b82f6"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            <h3>Kirim Jadwal Kursus</h3>
            <button class="close-btn" onclick="closeModal('modal-jadwal')"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form action="{{ route($routePrefix . '.kursus.kirim-jadwal', $periode) }}" method="POST">
            @csrf
            <div class="modal-body">
                <p style="font-size:13px;color:#64748b;margin-bottom:14px">Email jadwal kursus akan dikirim ke <strong>{{ $stats['total'] }} peserta</strong>. Status kursus akan berubah menjadi <strong>Terjadwal</strong>.</p>
                <label>Informasi Tambahan (opsional)</label>
                <textarea name="pesan" placeholder="Contoh: Kursus dilaksanakan di Aula Biara Loresa SCJ&#10;Peserta diharapkan membawa dokumen asli."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modal-jadwal')">Batal</button>
                <button type="submit" class="btn-submit-modal" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">Kirim Sekarang</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal: Kirim Sertifikat --}}
<div class="modal-overlay" id="modal-sertifikat">
    <div class="modal-box">
        <div class="modal-head">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;color:#22c55e"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg>
            <h3>Kirim Sertifikat Kelulusan</h3>
            <button class="close-btn" onclick="closeModal('modal-sertifikat')"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form action="{{ route($routePrefix . '.kursus.kirim-sertifikat', $periode) }}" method="POST">
            @csrf
            <div class="modal-body">
                <p style="font-size:13px;color:#64748b;margin-bottom:14px">Email sertifikat hanya dikirim ke peserta berstatus <strong>Lulus</strong>.</p>
                <label>Pesan Tambahan (opsional)</label>
                <textarea name="pesan" placeholder="Contoh: Sertifikat dapat diambil mulai tanggal ..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modal-sertifikat')">Batal</button>
                <button type="submit" class="btn-submit-modal" style="background:linear-gradient(135deg,#22c55e,#16a34a)">Kirim Sertifikat</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal: Kirim Jadwal Selanjutnya --}}
<div class="modal-overlay" id="modal-jadsel">
    <div class="modal-box">
        <div class="modal-head">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;color:#14b8a6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
            <h3>Kirim Jadwal Kegiatan Selanjutnya</h3>
            <button class="close-btn" onclick="closeModal('modal-jadsel')"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form action="{{ route($routePrefix . '.kursus.kirim-jadwal-selanjutnya', $periode) }}" method="POST">
            @csrf
            <div class="modal-body">
                <p style="font-size:13px;color:#64748b;margin-bottom:14px">Dikirim ke peserta berstatus <strong>Lulus</strong>.</p>
                <label>Informasi Jadwal Selanjutnya <span style="color:#ef4444">*</span></label>
                <textarea name="pesan" required placeholder="Contoh:&#10;• Pemberkatan Pernikahan&#10;  Jadwal: Sabtu, 15 Maret 2026 pukul 09.00 WIB&#10;  Tempat: Kapel Biara Loresa SCJ"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modal-jadsel')">Batal</button>
                <button type="submit" class="btn-submit-modal" style="background:linear-gradient(135deg,#14b8a6,#0d9488)">Kirim Informasi</button>
            </div>
        </form>
    </div>
</div>

{{-- Tabel pendaftaran --}}
<div class="card">
    <div class="card-header">
        <h2>Daftar Pendaftaran</h2>
    </div>
    @if($pendaftaran->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pasangan</th>
                        <th>Tgl. Daftar</th>
                        <th>Dokumen</th>
                        <th>Status Kursus</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaran as $item)
                    <tr>
                        <td class="td-num">#{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="td-names">
                                {{ $item->nama_pria }} &amp; {{ $item->nama_wanita }}
                                <small>{{ $item->email }}</small>
                            </div>
                        </td>
                        <td style="color:rgba(255,255,255,0.85);font-size:13px">{{ $item->created_at->format('d M Y') }}</td>
                        <td>
                            @php $sd = $item->status_dokumen ?? 'belum_diperiksa'; @endphp
                            @if($sd === 'lengkap')
                                <span class="badge badge-green"><span class="badge-dot2"></span>Lengkap</span>
                            @elseif($sd === 'tidak_lengkap')
                                <span class="badge badge-red"><span class="badge-dot2"></span>Tidak Lengkap</span>
                            @else
                                <span class="badge badge-amber"><span class="badge-dot2"></span>Belum Periksa</span>
                            @endif
                        </td>
                        <td>
                            @php $sk = $item->status_kursus ?? 'belum_dijadwalkan'; @endphp
                            @if($sk === 'lulus')
                                <span class="badge badge-green"><span class="badge-dot2"></span>Lulus</span>
                            @elseif($sk === 'tidak_lulus')
                                <span class="badge badge-red"><span class="badge-dot2"></span>Tidak Lulus</span>
                            @elseif($sk === 'terjadwal')
                                <span class="badge badge-blue"><span class="badge-dot2"></span>Terjadwal</span>
                            @elseif($sk === 'sedang_berjalan')
                                <span class="badge badge-amber"><span class="badge-dot2"></span>Berlangsung</span>
                            @else
                                <span class="badge badge-slate"><span class="badge-dot2"></span>Belum Dijadwalkan</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route($routePrefix . '.pendaftaran.show', $item->id) }}" class="btn-detail">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($pendaftaran->hasPages())
        <div class="dashboard-table-footer">{{ $pendaftaran->links() }}</div>
        @endif
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#cbd5e1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
            <p>Belum ada pendaftaran dalam periode ini.</p>
        </div>
    @endif
</div>
</div>

@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(function(el) {
    el.addEventListener('click', function(e) { if (e.target === el) el.classList.remove('open'); });
});
</script>
@endpush

@endsection
