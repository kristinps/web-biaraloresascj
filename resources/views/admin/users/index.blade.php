@extends('admin.layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('page-subtitle', 'Kelola akun administrator sistem')

@push('styles')
<style>
    .filter-bar {
        background:#fff; border:1px solid #e2e8f0; border-radius:14px;
        padding:16px 20px; margin-bottom:20px;
        display:flex; align-items:center; gap:12px; flex-wrap:wrap;
        box-shadow:0 1px 4px rgba(0,0,0,.04);
    }
    .search-wrap { position:relative; flex:1; min-width:220px; }
    .search-wrap svg { position:absolute; left:12px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:#94a3b8; pointer-events:none; }
    .search-wrap input { width:100%; padding:9px 14px 9px 38px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13.5px; font-family:'Inter',sans-serif; outline:none; color:#374151; transition:border-color .2s,box-shadow .2s; }
    .search-wrap input:focus { border-color:#1e2685; box-shadow:0 0 0 3px rgba(30,38,133,.1); }
    select.filter-select { padding:9px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13.5px; font-family:'Inter',sans-serif; outline:none; color:#374151; background:#fff; cursor:pointer; }
    select.filter-select:focus { border-color:#1e2685; }
    .btn-primary { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; background:linear-gradient(135deg,#1e2685,#2b3fe8); color:#fff; border:none; border-radius:10px; font-size:13.5px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; text-decoration:none; box-shadow:0 4px 12px rgba(30,38,133,.3); transition:opacity .2s; }
    .btn-primary:hover { opacity:.88; }
    .btn-primary svg { width:15px; height:15px; }
    .btn-filter { padding:9px 18px; background:linear-gradient(135deg,#1e2685,#2b3fe8); color:#fff; border:none; border-radius:10px; font-size:13.5px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; }
    .btn-reset { padding:9px 14px; background:#f1f5f9; color:#64748b; border-radius:10px; font-size:13.5px; font-weight:500; text-decoration:none; }

    .card { background:#fff; border-radius:16px; border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,.04); overflow:hidden; }
    table { width:100%; border-collapse:collapse; }
    thead th { padding:12px 18px; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#94a3b8; background:#f8fafc; text-align:left; border-bottom:1px solid #f1f5f9; white-space:nowrap; }
    tbody tr { border-bottom:1px solid #f8fafc; transition:background .15s; }
    tbody tr:hover { background:#f8fafc; }
    tbody tr:last-child { border-bottom:none; }
    td { padding:13px 18px; font-size:13.5px; color:#374151; vertical-align:middle; }

    .user-avatar { width:38px; height:38px; border-radius:10px; background:linear-gradient(135deg,#1e2685,#2b3fe8); display:flex; align-items:center; justify-content:center; font-size:15px; font-weight:700; color:#fff; flex-shrink:0; }
    .user-info { display:flex; align-items:center; gap:12px; }
    .user-info .name { font-weight:600; color:#1e293b; font-size:13.5px; }
    .user-info .email { font-size:12px; color:#94a3b8; margin-top:1px; }

    .badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:99px; font-size:12px; font-weight:600; white-space:nowrap; }
    .badge-dot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }
    .badge-blue { background:#eff6ff; color:#1d4ed8; }
    .badge-blue .badge-dot { background:#3b82f6; }
    .badge-slate { background:#f8fafc; color:#475569; }
    .badge-slate .badge-dot { background:#94a3b8; }

    .action-btns { display:flex; align-items:center; gap:6px; }
    .btn-edit { display:inline-flex; align-items:center; gap:4px; padding:6px 12px; border-radius:8px; background:#f0f9ff; color:#0369a1; font-size:12.5px; font-weight:600; text-decoration:none; transition:background .15s; }
    .btn-edit:hover { background:#e0f2fe; }
    .btn-edit svg { width:13px; height:13px; }
    .btn-del { display:inline-flex; align-items:center; gap:4px; padding:6px 12px; border-radius:8px; background:#fef2f2; color:#dc2626; font-size:12.5px; font-weight:600; border:none; cursor:pointer; font-family:'Inter',sans-serif; transition:background .15s; }
    .btn-del:hover { background:#fee2e2; }
    .btn-del svg { width:13px; height:13px; }

    .self-badge { font-size:11px; background:#f0fdf4; color:#15803d; padding:2px 8px; border-radius:99px; font-weight:600; margin-left:6px; }

    .empty-state { text-align:center; padding:56px 24px; color:#94a3b8; }
    .empty-state svg { width:48px; height:48px; margin:0 auto 14px; }
    .pagination-wrap { padding:16px 20px; border-top:1px solid #f1f5f9; display:flex; justify-content:flex-end; }

    @media (max-width:768px) { .hide-mobile { display:none; } }

    /* Modal konfirmasi hapus */
    .modal-backdrop { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:200; align-items:center; justify-content:center; padding:16px; }
    .modal-backdrop.show { display:flex; }
    .modal { background:#fff; border-radius:16px; padding:28px 28px 24px; max-width:400px; width:100%; box-shadow:0 20px 60px rgba(0,0,0,.2); }
    .modal h3 { font-size:17px; font-weight:700; color:#1e293b; margin-bottom:8px; }
    .modal p { font-size:13.5px; color:#64748b; margin-bottom:24px; line-height:1.6; }
    .modal-actions { display:flex; gap:10px; justify-content:flex-end; }
    .btn-cancel { padding:9px 18px; background:#f1f5f9; color:#475569; border:none; border-radius:9px; font-size:13.5px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; }
    .btn-confirm-del { padding:9px 18px; background:#dc2626; color:#fff; border:none; border-radius:9px; font-size:13.5px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; }
</style>
@endpush

@section('content')

<div class="filter-bar">
    <form method="GET" action="https://admin.biaraloresa.my.id/users"
          style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;flex:1">
        <div class="search-wrap">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau email...">
        </div>
        <select name="role" class="filter-select">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
            <option value="user"  {{ request('role') === 'user' ? 'selected' : '' }}>Pengguna Biasa</option>
        </select>
        <button type="submit" class="btn-filter">Filter</button>
        @if(request('search') || request('role'))
            <a href="https://admin.biaraloresa.my.id/users" class="btn-reset">Reset</a>
        @endif
    </form>
    <a href="https://admin.biaraloresa.my.id/users/create" class="btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Tambah Pengguna
    </a>
</div>

<div class="card">
    @if($users->count() > 0)
        <div style="overflow-x:auto">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pengguna</th>
                        <th class="hide-mobile">Role</th>
                        <th class="hide-mobile">Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $i => $user)
                    <tr>
                        <td style="color:#94a3b8;font-size:13px">{{ $users->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <div>
                                    <div class="name">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                            <span class="self-badge">Anda</span>
                                        @endif
                                    </div>
                                    <div class="email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="hide-mobile">
                            @if($user->is_admin)
                                <span class="badge badge-blue"><span class="badge-dot"></span>Administrator</span>
                            @else
                                <span class="badge badge-slate"><span class="badge-dot"></span>Pengguna Biasa</span>
                            @endif
                        </td>
                        <td class="hide-mobile" style="color:#64748b;font-size:13px">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="https://admin.biaraloresa.my.id/users/{{ $user->id }}/edit" class="btn-edit">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
                                    </svg>
                                    Edit
                                </a>
                                @if($user->id !== auth()->id())
                                    <button type="button" class="btn-del"
                                            onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                        Hapus
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap">
            {{ $users->appends(request()->query())->links() }}
        </div>
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:#cbd5e1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
            </svg>
            <p>Tidak ada pengguna ditemukan.</p>
        </div>
    @endif
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal-backdrop" id="del-modal">
    <div class="modal">
        <h3>Hapus Pengguna</h3>
        <p id="del-msg">Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
            <form id="del-form" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm-del">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    document.getElementById('del-msg').textContent =
        'Apakah Anda yakin ingin menghapus pengguna "' + name + '"? Tindakan ini tidak dapat dibatalkan.';
    document.getElementById('del-form').action =
        'https://admin.biaraloresa.my.id/users/' + id;
    document.getElementById('del-modal').classList.add('show');
}
function closeModal() {
    document.getElementById('del-modal').classList.remove('show');
}
document.getElementById('del-modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endpush
