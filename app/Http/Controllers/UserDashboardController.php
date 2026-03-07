<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPernikahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    private function getPendaftaranForUser()
    {
        return PendaftaranPernikahan::where('email', Auth::user()->email)->with('periode')->orderByDesc('created_at')->get();
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
        }

        $pendaftaranList = $this->getPendaftaranForUser();

        $baseQuery = PendaftaranPernikahan::where('email', $user->email);
        $stats = [
            'total'       => (clone $baseQuery)->count(),
            'lunas'       => (clone $baseQuery)->where('status_pembayaran', 'lunas')->count(),
            'menunggu'    => (clone $baseQuery)->where('status_pembayaran', 'menunggu')->count(),
            'belum_bayar' => (clone $baseQuery)->where('status_pembayaran', 'belum_bayar')->count(),
        ];

        return view('user.dashboard', [
            'user' => $user,
            'pendaftaranList' => $pendaftaranList,
            'stats' => $stats,
        ]);
    }

    public function statusPendaftaran()
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
        }
        $pendaftaranList = PendaftaranPernikahan::where('email', $user->email)->with('periode')->orderByDesc('created_at')->get();
        return view('user.status-pendaftaran', ['pendaftaranList' => $pendaftaranList]);
    }

    public function dokumen()
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
        }
        $pendaftaranList = PendaftaranPernikahan::where('email', $user->email)->with('periode')->orderByDesc('created_at')->get();
        return view('user.dokumen', ['pendaftaranList' => $pendaftaranList]);
    }

    public function jadwalMateri()
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
        }
        $pendaftaranList = PendaftaranPernikahan::where('email', $user->email)->with(['periode.materi'])->orderByDesc('created_at')->get();
        return view('user.jadwal-materi', ['pendaftaranList' => $pendaftaranList]);
    }

    public function sertifikat()
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
        }
        $pendaftaranList = PendaftaranPernikahan::where('email', $user->email)->with('periode')->orderByDesc('created_at')->get();
        return view('user.sertifikat', ['pendaftaranList' => $pendaftaranList]);
    }

    public function pembayaran()
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
        }
        $pendaftaranList = PendaftaranPernikahan::where('email', $user->email)->with('periode')->orderByDesc('created_at')->get();
        return view('user.pembayaran', ['pendaftaranList' => $pendaftaranList]);
    }

    public function biaya()
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
        }
        return view('user.biaya');
    }
}
