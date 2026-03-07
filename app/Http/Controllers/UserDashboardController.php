<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPernikahan;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function downloadSertifikat(PendaftaranPernikahan $pendaftaran)
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
        }
        if ($pendaftaran->email !== $user->email) {
            abort(403, 'Anda tidak berhak mengunduh sertifikat ini.');
        }
        if ($pendaftaran->status_kursus !== 'lulus') {
            return back()->with('error', 'Sertifikat hanya tersedia untuk peserta yang berstatus Lulus.');
        }
        $pendaftaran->load('periode');
        $pdf = Pdf::loadView('user.sertifikat-pdf', ['pendaftaran' => $pendaftaran])
            ->setPaper('a4', 'portrait');
        $filename = 'Sertifikat-' . \Str::slug($pendaftaran->nama_pria . '-' . $pendaftaran->nama_wanita) . '.pdf';
        return $pdf->download($filename);
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
