@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Absensi Kursus — ' . $periode->nama)
@section('page-title', 'Absensi & Status Kursus')
@section('page-subtitle', $periode->nama)

@push('styles')
<style>
    .back-link { display:inline-flex;align-items:center;gap:7px;font-size:13.5px;font-weight:600;color:#64748b;text-decoration:none;margin-bottom:20px;transition:color 0.2s; }
    .back-link:hover { color:#6366f1; }
    .back-link svg { width:16px;height:16px; }

    .legend { display:flex;gap:16px;flex-wrap:wrap;padding:12px 16px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;margin-bottom:20px;font-size:12.5px;color:#374151; }
    .legend-item { display:flex;align-items:center;gap:6px; }
    .legend-box { width:28px;height:20px;border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700; }
    .lb-tm { background:#eff6ff;border:1.5px solid #bfdbfe;color:#1d4ed8; }
    .lb-zm { background:#f0fdf4;border:1.5px solid #bbf7d0;color:#15803d; }

    .card { background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.04);margin-bottom:24px; }
    .card-header { padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap; }
    .card-header h2 { font-size:14px;font-weight:700;color:#1e293b; }

    .save-btn { display:inline-flex;align-items:center;gap:7px;padding:9px 20px;border-radius:9px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:13px;font-weight:600;border:none;cursor:pointer;transition:opacity 0.2s; }
    .save-btn:hover { opacity:0.88; }
    .save-btn svg { width:14px;height:14px; }

    .table-wrap { overflow-x: auto; }
    /* Tema beranda dari layout; override khusus untuk grid absensi */
    table.absensi { min-width: 600px; }
    .dashboard-banner-inner table.absensi thead th { text-align: center; padding: 10px 12px; white-space: nowrap; }
    .dashboard-banner-inner table.absensi thead th.th-peserta { text-align: left; min-width: 180px; }
    .dashboard-banner-inner table.absensi tbody td { padding: 10px 12px; text-align: center; font-size: 13px; }
    .dashboard-banner-inner table.absensi td.td-peserta { text-align: left; }

    .peserta-name  { font-size:13px;font-weight:600;color:#1e293b; }
    .peserta-email { font-size:11.5px;color:#94a3b8; }

    .cb-wrap { display:flex;flex-direction:column;align-items:center;gap:4px; }
    .cb-tm { width:18px;height:18px;cursor:pointer;accent-color:#3b82f6; }
    .cb-zm { width:18px;height:18px;cursor:pointer;accent-color:#22c55e; }

    .materi-col-head { font-size:11px;font-weight:700;color:#374151;max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap; }
    .materi-col-date { font-size:10px;color:#94a3b8;margin-top:2px; }

    .status-badge { display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:6px;font-size:11px;font-weight:600; }
    .sb-dot { width:5px;height:5px;border-radius:50%; }
    .sb-lulus   { background:#f0fdf4;color:#15803d; } .sb-lulus .sb-dot   { background:#22c55e; }
    .sb-tidak   { background:#fef2f2;color:#dc2626; } .sb-tidak .sb-dot   { background:#ef4444; }
    .sb-jadwal  { background:#eff6ff;color:#1d4ed8; } .sb-jadwal .sb-dot  { background:#3b82f6; }
    .sb-berlang { background:#fffbeb;color:#b45309; } .sb-berlang .sb-dot { background:#f59e0b; }
    .sb-belum   { background:#f8fafc;color:#475569; } .sb-belum .sb-dot   { background:#94a3b8; }

    .btn-pindah { display:inline-flex;align-items:center;gap:4px;padding:4px 9px;border-radius:6px;background:#fef3c7;color:#92400e;font-size:11px;font-weight:600;border:none;cursor:pointer;transition:background 0.15s; }
    .btn-pindah:hover { background:#fde68a; }
    .btn-pindah svg { width:11px;height:11px; }

    .empty-state { text-align:center;padding:48px 24px;color:#94a3b8; }
    .empty-state svg { width:48px;height:48px;margin:0 auto 14px; }

    .modal-overlay { display:none;position:fixed;inset:0;z-index:200;background:rgba(0,0,0,0.45);align-items:center;justify-content:center; }
    .modal-overlay.open { display:flex; }
    .modal-box { background:#fff;border-radius:18px;width:100%;max-width:420px;margin:20px;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden; }
    .modal-head { padding:16px 20px;display:flex;align-items:center;gap:9px;border-bottom:1px solid #f1f5f9; }
    .modal-head h3 { font-size:14px;font-weight:700;color:#1e293b; }
    .close-btn { margin-left:auto;background:none;border:none;cursor:pointer;color:#94a3b8;padding:4px;border-radius:6px; }
    .close-btn:hover { color:#475569; }
    .close-btn svg { width:17px;height:17px; }
    .modal-body { padding:20px; }
    .modal-body label { display:block;font-size:12.5px;font-weight:600;color:#374151;margin-bottom:6px; }
    .modal-body select { width:100%;padding:9px 12px;border-radius:9px;border:1.5px solid #e2e8f0;font-size:13.5px;color:#1e293b;outline:none; }
    .modal-body select:focus { border-color:#6366f1; }
    .modal-footer { padding:14px 20px;background:#f8fafc;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;gap:8px; }
    .btn-cancel { padding:7px 16px;border-radius:8px;background:#f1f5f9;color:#475569;font-size:13px;font-weight:600;border:none;cursor:pointer; }
    .btn-ok     { padding:7px 18px;border-radius:8px;color:#fff;font-size:13px;font-weight:600;border:none;cursor:pointer; }
</style>
@endpush

@section('content')

<a href="{{ route($routePrefix . '.periode.show', $periode) }}" class="back-link">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    Kembali ke Periode
</a>

<div class="legend">
    <span style="font-weight:600;color:#374151">Keterangan:</span>
    <span class="legend-item"><span class="legend-box lb-tm">TM</span> Hadir Tatap Muka</span>
    <span class="legend-item"><span class="legend-box lb-zm">Z</span> Hadir Zoom</span>
    <span style="font-size:12px;color:#94a3b8;margin-left:auto">Centang dua checkbox per materi. Simpan setelah selesai mengisi.</span>
</div>

@if($materiList->isEmpty() || $pesertaList->isEmpty())
<div class="card">
    <div class="empty-state">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#cbd5e1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p>
            @if($materiList->isEmpty())
                Belum ada materi kursus. <a href="{{ route($routePrefix . '.materi.index', $periode) }}" style="color:#6366f1">Tambah materi terlebih dahulu.</a>
            @else
                Belum ada peserta dalam periode ini.
            @endif
        </p>
    </div>
</div>
@else

<div class="card">
    <div class="card-header">
        <h2>Grid Kehadiran — {{ $pesertaList->count() }} Peserta × {{ $materiList->count() }} Materi</h2>
        <button form="form-absensi" type="submit" class="save-btn">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 21l-4.5-4.5V3.75m9 0H7.5m9 0a1.5 1.5 0 013 0v15a1.5 1.5 0 01-3 0m-9-15a1.5 1.5 0 00-3 0v15a1.5 1.5 0 003 0"/></svg>
            Simpan Absensi
        </button>
    </div>
    <form id="form-absensi" action="{{ route($routePrefix . '.kehadiran.update', $periode) }}" method="POST">
        @csrf
        <div class="table-wrap">
            <table class="absensi">
                <thead>
                    <tr>
                        <th class="th-peserta">Peserta</th>
                        @foreach($materiList as $materi)
                        <th>
                            <div class="materi-col-head" title="{{ $materi->judul }}">{{ $materi->urutan }}. {{ Str::limit($materi->judul, 14) }}</div>
                            @if($materi->tanggal_pelaksanaan)<div class="materi-col-date">{{ $materi->tanggal_pelaksanaan->format('d/m') }}</div>@endif
                            <div style="display:flex;gap:8px;justify-content:center;margin-top:4px;font-size:9px;color:#94a3b8">
                                <span style="color:#3b82f6">TM</span><span style="color:#22c55e">Zm</span>
                            </div>
                        </th>
                        @endforeach
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesertaList as $peserta)
                    <tr>
                        <td class="td-peserta">
                            <div class="peserta-name">{{ $peserta->nama_pria }}</div>
                            <div class="peserta-email">&amp; {{ $peserta->nama_wanita }}</div>
                            <div class="peserta-email">{{ $peserta->email }}</div>
                        </td>
                        @foreach($materiList as $materi)
                        @php $k = $kehadiranMap[$peserta->id][$materi->id] ?? null; @endphp
                        <td>
                            <div class="cb-wrap">
                                <input type="checkbox" class="cb-tm" name="tatap_{{ $peserta->id }}_{{ $materi->id }}" {{ $k && $k->hadir_tatap_muka ? 'checked' : '' }} title="Hadir Tatap Muka">
                                <input type="checkbox" class="cb-zm" name="zoom_{{ $peserta->id }}_{{ $materi->id }}"  {{ $k && $k->hadir_zoom       ? 'checked' : '' }} title="Hadir Zoom">
                            </div>
                        </td>
                        @endforeach
                        <td>
                            @php $sk = $peserta->status_kursus ?? 'belum_dijadwalkan'; @endphp
                            @if($sk === 'lulus')   <span class="status-badge sb-lulus"><span class="sb-dot"></span>Lulus</span>
                            @elseif($sk === 'tidak_lulus') <span class="status-badge sb-tidak"><span class="sb-dot"></span>Tidak Lulus</span>
                            @elseif($sk === 'terjadwal')   <span class="status-badge sb-jadwal"><span class="sb-dot"></span>Terjadwal</span>
                            @elseif($sk === 'sedang_berjalan') <span class="status-badge sb-berlang"><span class="sb-dot"></span>Berlangsung</span>
                            @else <span class="status-badge sb-belum"><span class="sb-dot"></span>Belum</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn-pindah"
                                onclick="openStatusModal({{ $peserta->id }}, '{{ addslashes($peserta->nama_pria) }} & {{ addslashes($peserta->nama_wanita) }}', '{{ $sk }}')">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Status
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
</div>
@endif

{{-- Modal: Update Status & Pindah Jadwal --}}
<div class="modal-overlay" id="modal-status">
    <div class="modal-box">
        <div class="modal-head">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:17px;height:17px;color:#6366f1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <h3 id="modal-peserta-nama">Status Kursus</h3>
            <button class="close-btn" onclick="closeModal('modal-status')"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form id="form-status" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div style="margin-bottom:14px">
                    <label>Status Kursus</label>
                    <select name="status_kursus" id="modal-status-select">
                        <option value="terjadwal">Terjadwal</option>
                        <option value="sedang_berjalan">Sedang Berjalan</option>
                        <option value="lulus">✅ Lulus</option>
                        <option value="tidak_lulus">❌ Tidak Lulus</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modal-status')">Batal</button>
                <button type="submit" class="btn-ok" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">Simpan Status</button>
            </div>
        </form>
        <div style="padding:0 20px 20px">
            <div style="border-top:1px dashed #e2e8f0;padding-top:16px">
                <p style="font-size:12.5px;font-weight:600;color:#374151;margin-bottom:10px">Pindahkan ke Periode Lain (jika tidak lulus)</p>
                <form id="form-pindah" method="POST">
                    @csrf
                    @method('PUT')
                    <div style="display:flex;gap:8px">
                        <select name="periode_id_baru" style="flex:1;padding:8px 10px;border-radius:8px;border:1.5px solid #e2e8f0;font-size:13px;color:#374151;outline:none">
                            <option value="">— Pilih Periode Baru —</option>
                            @foreach(\App\Models\PeriodePernikahan::aktif()->latest()->get() as $p)
                                @if($p->id !== $periode->id)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="submit" class="btn-ok" style="background:linear-gradient(135deg,#f59e0b,#d97706)">Pindah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openStatusModal(id, nama, currentStatus) {
    document.getElementById('modal-peserta-nama').textContent = nama;
    document.getElementById('form-status').action = '{{ $routePrefix === "dashboard" ? url("dashboard/pendaftaran") : url("pendaftaran") }}/' + id + '/status-kursus';
    document.getElementById('form-pindah').action  = '{{ $routePrefix === "dashboard" ? url("dashboard/pendaftaran") : url("pendaftaran") }}/' + id + '/pindah-jadwal';
    var sel = document.getElementById('modal-status-select');
    for (var i = 0; i < sel.options.length; i++) {
        sel.options[i].selected = (sel.options[i].value === currentStatus);
    }
    document.getElementById('modal-status').classList.add('open');
}
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(function(el) {
    el.addEventListener('click', function(e) { if (e.target === el) el.classList.remove('open'); });
});
</script>
@endpush

@endsection
