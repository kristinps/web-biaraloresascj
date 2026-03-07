<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.register')
            ->with('success', 'Anda telah berhasil keluar.');
    }

    public function showRegister()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.pendaftaran.index');
        }

        return view('admin.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
            'name.required'                  => 'Nama lengkap wajib diisi.',
            'name.max'                       => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required'                 => 'Alamat email wajib diisi.',
            'email.email'                    => 'Format email tidak valid.',
            'email.unique'                   => 'Email sudah terdaftar, gunakan email lain.',
            'password.required'              => 'Kata sandi wajib diisi.',
            'password.min'                   => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'             => 'Konfirmasi kata sandi tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'is_admin' => true,
        ]);

        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice')
            ->with('verification_email', $user->email)
            ->with('success', 'Akun berhasil dibuat! Email verifikasi telah dikirim ke ' . $user->email . '.');
    }

    // ─── Email Verification ───────────────────────────────────────────────────

    public function showVerifyEmail(Request $request)
    {
        $email = session('verification_email')
            ?? ($request->user() ? $request->user()->email : null);

        return view('admin.verify-email', compact('email'));
    }

    public function verifyEmail(Request $request, string $id, string $hash)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('verification.notice')
                ->with('error', 'Tautan verifikasi tidak valid atau sudah kadaluwarsa. Silakan minta tautan baru.');
        }

        $user = User::findOrFail($id);

        if (! hash_equals($hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('verification.notice')
                ->with('error', 'Tautan verifikasi tidak valid.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('admin.register')
                ->with('success', 'Email Anda sudah diverifikasi sebelumnya.');
        }

        $user->markEmailAsVerified();

        return redirect()->route('admin.register')
            ->with('success', 'Email berhasil diverifikasi! Akun Anda telah aktif.');
    }

    public function resendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && ! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return back()
            ->with('verification_email', $request->email)
            ->with('success', 'Jika email tersebut terdaftar dan belum diverifikasi, tautan aktivasi baru telah dikirim.');
    }
}
