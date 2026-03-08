@extends('layouts.dashboard')

@section('title', 'Kelola Admin')
@section('page-title', 'CRUD Admin')
@section('page-subtitle', 'Kelola akun admin dan super admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-serif font-bold text-white">Daftar Admin</h1>
        <a href="{{ route('dashboard.admin-crud.create') }}" class="bg-white/90 text-primary-800 px-4 py-2 rounded-lg font-semibold hover:bg-white transition-colors">+ Tambah Admin</a>
    </div>
    <div class="card overflow-hidden">
        <div class="table-wrap">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-left">Nama</th>
                        <th class="text-left">Email</th>
                        <th class="text-left">Role</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                    <tr>
                        <td class="font-medium text-gray-800">{{ $admin->name }}</td>
                        <td class="text-gray-600">{{ $admin->email }}</td>
                        <td>
                            <span class="px-2 py-0.5 rounded text-xs font-medium {{ $admin->role === 'super_admin' ? 'bg-amber-100 text-amber-800' : 'bg-primary-100 text-primary-800' }}">
                                {{ $admin->role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                            </span>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('dashboard.admin-crud.edit', $admin) }}" class="table-action-btn">Edit</a>
                            @if(auth()->id() !== $admin->id)
                            <form action="{{ route('dashboard.admin-crud.destroy', $admin) }}" method="POST" class="inline" onsubmit="return confirm('Hapus admin ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="table-action-btn-danger">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="dashboard-table-footer">
            {{ $admins->links() }}
        </div>
    </div>
</div>
@endsection
