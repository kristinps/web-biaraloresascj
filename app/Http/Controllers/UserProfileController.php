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
        if ($user->isAdmin()) {
            return redirect()->route('dashboard.index');
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
        if ($user->isAdmin()) {
            return redirect()->route('dashboard.index');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama wajib diisi.',
        ]);

        // Hanya nama yang dapat diedit; email dan foto tidak dapat diubah
        $user->update(['name' => $request->name]);

        return redirect()->route('user.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function showPassword()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('dashboard.index');
        }

        return view('user.password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('dashboard.index');
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
