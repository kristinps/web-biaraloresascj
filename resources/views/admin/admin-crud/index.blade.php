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
    <div class="bg-white/95 rounded-xl shadow-lg border border-white/20 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100 border-b border-gray-200">
                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Nama</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Email</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Role</th>
                    <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr class="border-b border-gray-100 hover:bg-gray-50/50">
                    <td class="py-3 px-4 font-medium text-gray-800">{{ $admin->name }}</td>
                    <td class="py-3 px-4 text-gray-600">{{ $admin->email }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-0.5 rounded text-xs font-medium {{ $admin->role === 'super_admin' ? 'bg-amber-100 text-amber-800' : 'bg-primary-100 text-primary-800' }}">
                            {{ $admin->role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-right">
                        <a href="{{ route('dashboard.admin-crud.edit', $admin) }}" class="text-primary-700 font-medium text-sm hover:underline">Edit</a>
                        @if(auth()->id() !== $admin->id)
                        <form action="{{ route('dashboard.admin-crud.destroy', $admin) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Hapus admin ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 font-medium text-sm hover:underline">Hapus</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-100">
            {{ $admins->links() }}
        </div>
    </div>
</div>
@endsection
