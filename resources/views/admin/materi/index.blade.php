@extends(request()->routeIs('dashboard.*') ? 'layouts.dashboard' : 'admin.layouts.app')

@section('title', 'Materi Kursus — ' . $periode->nama)
@section('page-title', 'Materi Kursus')
@section('page-subtitle', $periode->nama)

@push('styles')
<style>
    .back-link { display:inline-flex;align-items:center;gap:7px;font-size:13.5px;font-weight:600;color:#64748b;text-decoration:none;margin-bottom:20px;transition:color 0.2s; }
    .back-link:hover { color:#6366f1; }
    .back-link svg { width:16px;height:16px; }

    .page-grid { display:grid;grid-template-columns:340px 1fr;gap:20px;align-items:start; }
    @media (max-width:900px) { .page-grid { grid-template-columns:1fr; } }

    .panel { background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.04); }
    .panel-head { padding:16px 20px;display:flex;align-items:center;gap:9px;border-bottom:1px solid #f1f5f9; }
    .panel-head h2 { font-size:14px;font-weight:700;color:#1e293b; }
    .panel-head svg { width:17px;height:17px;color:#6366f1; }
    .panel-body { padding:20px; }

    .form-group { margin-bottom:14px; }
    .form-label { display:block;font-size:12.5px;font-weight:600;color:#374151;margin-bottom:5px; }
    .form-input,.form-textarea { width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13.5px;color:#1e293b;background:#fff;outline:none;transition:border-color 0.2s;font-family:inherit; }
    .form-input:focus,.form-textarea:focus { border-color:#6366f1; }
    .form-textarea { resize:vertical;min-height:72px; }
    .form-hint { font-size:11.5px;color:#94a3b8;margin-top:4px; }

    .btn-primary { width:100%;padding:10px;border-radius:9px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:13.5px;font-weight:600;border:none;cursor:pointer;transition:opacity 0.2s;display:flex;align-items:center;justify-content:center;gap:7px; }
    .btn-primary:hover { opacity:0.88; }
    .btn-primary svg { width:15px;height:15px; }

    .materi-item { border:1px solid #e2e8f0;border-radius:13px;padding:16px 18px;margin-bottom:12px;background:#fff;transition:box-shadow 0.15s; }
    .materi-item:hover { box-shadow:0 4px 12px rgba(0,0,0,0.07); }
    .materi-header { display:flex;align-items:flex-start;gap:12px; }
    .materi-num { width:32px;height:32px;border-radius:8px;flex-shrink:0;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:#fff; }
    .materi-title { font-size:14px;font-weight:700;color:#1e293b; }
    .materi-date  { font-size:12px;color:#64748b;margin-top:2px; }

    .badge-sent { display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:6px;font-size:11px;font-weight:600; }
    .bs-yes { background:#f0fdf4;color:#15803d; }
    .bs-no  { background:#f8fafc;color:#94a3b8; }

    .materi-desc { font-size:12.5px;color:#64748b;margin-top:8px;line-height:1.5; }

    .action-btn { display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:600;border:none;cursor:pointer;text-decoration:none;transition:opacity 0.15s; }
    .action-btn:hover { opacity:0.8; }
    .action-btn svg { width:12px;height:12px; }
    .ab-indigo { background:#ede9fe;color:#6d28d9; }
    .ab-blue   { background:#eff6ff;color:#1d4ed8; }
    .ab-slate  { background:#f8fafc;color:#475569; }
    .ab-red    { background:#fef2f2;color:#dc2626; }

    .zoom-chip { display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:7px;background:#eff6ff;color:#1d4ed8;font-size:12px;font-weight:600;text-decoration:none; }
    .zoom-chip:hover { background:#dbeafe; }
    .file-chip { display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:7px;background:#fef3c7;color:#b45309;font-size:12px;font-weight:600;text-decoration:none; }
    .file-chip:hover { background:#fde68a; }

    .empty-state { text-align:center;padding:40px 20px;color:#94a3b8; }
    .empty-state svg { width:44px;height:44px;margin:0 auto 12px; }

    .modal-overlay { display:none;position:fixed;inset:0;z-index:200;background:rgba(0,0,0,0.45);align-items:center;justify-content:center; }
    .modal-overlay.open { display:flex; }
    .modal-box { background:#fff;border-radius:18px;width:100%;max-width:520px;margin:20px;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden;max-height:90vh;overflow-y:auto; }
    .modal-head { padding:18px 22px;display:flex;align-items:center;gap:9px;border-bottom:1px solid #f1f5f9;position:sticky;top:0;background:#fff;z-index:1; }
    .modal-head h3 { font-size:15px;font-weight:700;color:#1e293b; }
    .close-btn { margin-left:auto;background:none;border:none;cursor:pointer;color:#94a3b8;padding:4px;border-radius:6px; }
    .close-btn:hover { color:#475569; }
    .close-btn svg { width:18px;height:18px; }
    .modal-body { padding:22px; }
    .modal-footer { padding:16px 22px;background:#f8fafc;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;gap:10px;position:sticky;bottom:0; }
    .btn-cancel { padding:8px 18px;border-radius:8px;background:#f1f5f9;color:#475569;font-size:13px;font-weight:600;border:none;cursor:pointer; }
    .btn-save   { padding:8px 20px;border-radius:8px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:13px;font-weight:600;border:none;cursor:pointer; }
</style>
@endpush

@section('content')

<a href="{{ route($routePrefix . '.periode.show', $periode) }}" class="back-link">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    Kembali ke Periode
</a>

<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:20px">
    <p style="font-size:13px;color:#64748b">
        <strong>{{ $jumlahPeserta }} peserta</strong> terdaftar. Email materi/zoom dikirim ke semua peserta sekaligus.
    </p>
    <a href="{{ route($routePrefix . '.kehadiran.index', $periode) }}"
       style="display:inline-flex;align-items:center;gap:6px;padding:9px 16px;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Kelola Absensi
    </a>
</div>

<div class="page-grid">
    {{-- Form Tambah --}}
    <div class="panel">
        <div class="panel-head">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <h2>Tambah Materi Baru</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route($routePrefix . '.materi.store', $periode) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Urutan / Sesi ke- <span style="color:#ef4444">*</span></label>
                    <input type="number" name="urutan" class="form-input" value="{{ $materiList->count() + 1 }}" min="1" max="99" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Judul Materi <span style="color:#ef4444">*</span></label>
                    <input type="text" name="judul" class="form-input" placeholder="Contoh: Komunikasi dalam Pernikahan" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Pemateri <span style="color:#ef4444">*</span></label>
                    <input type="text" name="nama_pemateri" class="form-input" placeholder="Nama lengkap pemateri" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-textarea" placeholder="Deskripsi singkat materi..."></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal_pelaksanaan" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">File Materi</label>
                    <input type="file" name="file_materi" class="form-input" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip">
                    <p class="form-hint">Format: PDF, DOC, DOCX, PPT, PPTX, ZIP. Maks 20MB.</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Link Zoom</label>
                    <input type="url" name="zoom_link" class="form-input" placeholder="https://zoom.us/j/...">
                </div>
                <button type="submit" class="btn-primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Tambah Materi
                </button>
            </form>
        </div>
    </div>

    {{-- Daftar Materi --}}
    <div class="panel">
        <div class="panel-head">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/></svg>
            <h2>Daftar Materi ({{ $materiList->count() }})</h2>
        </div>
        <div class="panel-body" style="padding:16px">
            @if($materiList->isEmpty())
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#cbd5e1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/></svg>
                    <p>Belum ada materi. Tambahkan di form kiri.</p>
                </div>
            @else
                @foreach($materiList as $materi)
                <div class="materi-item">
                    <div class="materi-header">
                        <div class="materi-num">{{ $materi->urutan }}</div>
                        <div style="flex:1;min-width:0">
                            <div class="materi-title">{{ $materi->judul }}</div>
                            @if($materi->nama_pemateri)
                            <div class="materi-date">Pemateri: {{ $materi->nama_pemateri }}</div>
                            @endif
                            @if($materi->tanggal_pelaksanaan)
                            <div class="materi-date">{{ $materi->tanggal_pelaksanaan->translatedFormat('d F Y') }}</div>
                            @endif
                            <div style="display:flex;gap:6px;margin-top:5px;flex-wrap:wrap">
                                <span class="badge-sent {{ $materi->terkirim_materi ? 'bs-yes' : 'bs-no' }}">
                                    {{ $materi->terkirim_materi ? '✓ Materi terkirim' : '○ Materi belum kirim' }}
                                </span>
                                <span class="badge-sent {{ $materi->terkirim_zoom ? 'bs-yes' : 'bs-no' }}">
                                    {{ $materi->terkirim_zoom ? '✓ Zoom terkirim' : '○ Zoom belum kirim' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @if($materi->deskripsi)
                    <div class="materi-desc">{{ $materi->deskripsi }}</div>
                    @endif
                    <div style="display:flex;gap:8px;margin-top:10px;flex-wrap:wrap">
                        @if($materi->file_materi)
                        <a href="{{ asset('storage/' . $materi->file_materi) }}" target="_blank" class="file-chip">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            Lihat File
                        </a>
                        @endif
                        @if($materi->zoom_link)
                        <a href="{{ $materi->zoom_link }}" target="_blank" class="zoom-chip">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/></svg>
                            Link Zoom
                        </a>
                        @endif
                    </div>
                    <div style="display:flex;gap:6px;margin-top:12px;flex-wrap:wrap;border-top:1px solid #f1f5f9;padding-top:12px">
                        <form action="{{ route($routePrefix . '.materi.kirim', $materi) }}" method="POST" onsubmit="return confirm('Kirim email materi ini ke {{ $jumlahPeserta }} peserta?')">
                            @csrf
                            <button type="submit" class="action-btn ab-indigo">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                Kirim Materi
                            </button>
                        </form>
                        @if($materi->zoom_link)
                        <form action="{{ route($routePrefix . '.materi.kirim-zoom', $materi) }}" method="POST" onsubmit="return confirm('Kirim link Zoom ini ke {{ $jumlahPeserta }} peserta?')">
                            @csrf
                            <button type="submit" class="action-btn ab-blue">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/></svg>
                                Kirim Zoom
                            </button>
                        </form>
                        @endif
                        <button class="action-btn ab-slate" onclick="openEditModal({{ $materi->id }})">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                            Edit
                        </button>
                        <form action="{{ route($routePrefix . '.materi.destroy', $materi) }}" method="POST" onsubmit="return confirm('Hapus materi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn ab-red">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Edit Modal --}}
                <div class="modal-overlay" id="modal-edit-{{ $materi->id }}">
                    <div class="modal-box">
                        <div class="modal-head">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:17px;height:17px;color:#6366f1"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                            <h3>Edit Materi: {{ $materi->judul }}</h3>
                            <button class="close-btn" onclick="closeModal('modal-edit-{{ $materi->id }}')"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </div>
                        <form action="{{ route($routePrefix . '.materi.update', $materi) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="modal-body">
                                <div class="form-group"><label class="form-label">Urutan / Sesi ke-</label><input type="number" name="urutan" class="form-input" value="{{ $materi->urutan }}" min="1" max="99" required></div>
                                <div class="form-group"><label class="form-label">Judul Materi</label><input type="text" name="judul" class="form-input" value="{{ $materi->judul }}" required></div>
                                <div class="form-group"><label class="form-label">Nama Pemateri</label><input type="text" name="nama_pemateri" class="form-input" value="{{ $materi->nama_pemateri }}" required></div>
                                <div class="form-group"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-textarea">{{ $materi->deskripsi }}</textarea></div>
                                <div class="form-group"><label class="form-label">Tanggal Pelaksanaan</label><input type="date" name="tanggal_pelaksanaan" class="form-input" value="{{ $materi->tanggal_pelaksanaan?->format('Y-m-d') }}"></div>
                                <div class="form-group">
                                    <label class="form-label">Ganti File Materi (kosongkan jika tidak ganti)</label>
                                    <input type="file" name="file_materi" class="form-input" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip">
                                    @if($materi->file_materi)<p class="form-hint">File saat ini: <a href="{{ asset('storage/'.$materi->file_materi) }}" target="_blank" style="color:#6366f1">Lihat file</a></p>@endif
                                </div>
                                <div class="form-group"><label class="form-label">Link Zoom</label><input type="url" name="zoom_link" class="form-input" value="{{ $materi->zoom_link }}" placeholder="https://zoom.us/j/..."></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn-cancel" onclick="closeModal('modal-edit-{{ $materi->id }}')">Batal</button>
                                <button type="submit" class="btn-save">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function openEditModal(id) { document.getElementById('modal-edit-' + id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(function(el) {
    el.addEventListener('click', function(e) { if (e.target === el) el.classList.remove('open'); });
});
</script>
@endpush

@endsection
