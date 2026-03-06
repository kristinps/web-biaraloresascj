<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class UserAuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->is_admin) {
                return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
            }
            return redirect()->to(url('/dashboard'));
        }
        return view('user.login', ['success' => $request->session()->get('success')]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau kata sandi tidak sesuai.',
            ])->withInput($request->only('email'));
        }

        $user = Auth::user();

        if ($user->is_admin) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Untuk akun administrator, gunakan halaman login admin: admin.biaraloresa.my.id/login',
            ])->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        return redirect()->intended(url('/dashboard'))
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to(url('/'))->with('success', 'Anda telah berhasil keluar.');
    }

    public function showForgotPassword()
    {
        return view('user.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email'], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->where('is_admin', false)->first();
        if (! $user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar sebagai peserta. Pastikan Anda menggunakan email yang sama dengan pendaftaran kursus.',
            ])->withInput($request->only('email'));
        }

        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Tautan untuk mengatur kata sandi baru telah dikirim ke email Anda.');
        }

        return back()->withErrors(['email' => __($status)])->withInput($request->only('email'));
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('user.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->to(url('/login'))->with('status', 'Kata sandi berhasil diatur. Silakan login.');
        }

        return back()->withErrors(['email' => __($status)])->withInput($request->only('email'));
    }
}
