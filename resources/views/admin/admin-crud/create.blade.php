@extends('layouts.dashboard')

@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Admin')

@section('content')
<div class="max-w-md mx-auto">
    <a href="{{ route('dashboard.admin-crud.index') }}" class="inline-flex items-center text-white/90 text-sm mb-6 hover:underline">
        ← Kembali
    </a>
    <div class="bg-white/95 rounded-xl shadow-lg border border-white/20 p-6">
        <h2 class="font-serif font-bold text-gray-800 mb-4">Tambah Admin Baru</h2>
        <form action="{{ route('dashboard.admin-crud.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500">
                    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500">
                    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500">
                    @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2 rounded-lg border border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500">
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-primary-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-primary-800">Simpan</button>
                <a href="{{ route('dashboard.admin-crud.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
