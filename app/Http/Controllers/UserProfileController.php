<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPernikahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password as PasswordRule;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
        }

        // Pakai foto dari user; kalau belum ada, ambil dari pendaftaran terakhir (pas foto saat daftar)
        $fotoPriaUrl = $user->fotoPriaUrl();
        $fotoWanitaUrl = $user->fotoWanitaUrl();
        if (! $fotoPriaUrl || ! $fotoWanitaUrl) {
            $pendaftaran = PendaftaranPernikahan::where('email', $user->email)->orderByDesc('created_at')->first();
            if ($pendaftaran) {
                if (! $fotoPriaUrl && $pendaftaran->foto_pria) {
                    $fotoPriaUrl = asset('storage/' . $pendaftaran->foto_pria);
                }
                if (! $fotoWanitaUrl && $pendaftaran->foto_wanita) {
                    $fotoWanitaUrl = asset('storage/' . $pendaftaran->foto_wanita);
                }
            }
        }

        return view('user.profil', [
            'user'         => $user,
            'fotoPriaUrl'  => $fotoPriaUrl,
            'fotoWanitaUrl'=> $fotoWanitaUrl,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
        }

        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'foto_pria'  => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'foto_wanita'=> ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ], [
            'name.required'   => 'Nama wajib diisi.',
            'email.required'  => 'Email wajib diisi.',
            'email.unique'    => 'Email ini sudah digunakan akun lain.',
            'foto_pria.image'   => 'Foto calon pria harus berupa gambar.',
            'foto_pria.mimes'   => 'Foto calon pria harus JPG atau PNG.',
            'foto_pria.max'     => 'Foto calon pria maksimal 2 MB.',
            'foto_wanita.image' => 'Foto calon wanita harus berupa gambar.',
            'foto_wanita.mimes' => 'Foto calon wanita harus JPG atau PNG.',
            'foto_wanita.max'   => 'Foto calon wanita maksimal 2 MB.',
        ]);

        $data = $request->only('name', 'email');

        if ($request->hasFile('foto_pria')) {
            if ($user->foto_pria) {
                Storage::disk('public')->delete($user->foto_pria);
            }
            $data['foto_pria'] = $request->file('foto_pria')->store('profil-pasangan', 'public');
        }

        if ($request->hasFile('foto_wanita')) {
            if ($user->foto_wanita) {
                Storage::disk('public')->delete($user->foto_wanita);
            }
            $data['foto_wanita'] = $request->file('foto_wanita')->store('profil-pasangan', 'public');
        }

        $user->update($data);

        return redirect()->route('user.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function showPassword()
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
        }

        return view('user.password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
        }

        $request->validate([
            'password_current' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', PasswordRule::defaults()],
        ], [
            'password_current.required'      => 'Kata sandi saat ini wajib diisi.',
            'password_current.current_password' => 'Kata sandi saat ini tidak sesuai.',
            'password.required'             => 'Kata sandi baru wajib diisi.',
            'password.confirmed'             => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.password')->with('success', 'Kata sandi berhasil diubah.');
    }
}
