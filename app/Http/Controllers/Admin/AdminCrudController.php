<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminCrudController extends Controller
{
    public function index()
    {
        $admins = User::whereIn('role', [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN])
            ->orderBy('role')
            ->orderBy('name')
            ->paginate(15);
        return view('admin.admin-crud.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admin-crud.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role'     => ['required', 'in:super_admin,admin'],
        ], [
            'name.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'role.required'  => 'Role wajib dipilih.',
            'role.in'       => 'Role tidak valid.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('dashboard.admin-crud.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if (! in_array($user->role, [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN], true)) {
            abort(404);
        }
        return view('admin.admin-crud.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (! in_array($user->role, [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN], true)) {
            abort(404);
        }
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role'     => ['required', 'in:super_admin,admin'],
        ], [
            'name.required'  => 'Nama wajib diisi.',
            'email.unique'   => 'Email sudah digunakan akun lain.',
            'role.in'       => 'Role tidak valid.',
        ]);

        $data = ['name' => $request->name, 'email' => $request->email, 'role' => $request->role];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);

        return redirect()->route('dashboard.admin-crud.index')
            ->with('success', 'Data admin berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        if (! in_array($user->role, [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN], true)) {
            abort(404);
        }
        $user->delete();
        return redirect()->route('dashboard.admin-crud.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}
