<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPernikahan;
use App\Models\PeriodePernikahan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /** Satu URL /dashboard untuk semua role; konten sesuai role */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return $this->admin($request);
        }

        return $this->user($request);
    }

    /** Dashboard untuk super_admin & admin: grafik data */
    public function admin(Request $request)
    {
        $totalPendaftaran = PendaftaranPernikahan::count();
        $pending = PendaftaranPernikahan::where('status', 'pending')->count();
        $proses = PendaftaranPernikahan::where('status', 'proses')->count();
        $selesai = PendaftaranPernikahan::where('status', 'selesai')->count();
        $periodeAktif = PeriodePernikahan::aktif()->count();
        $periodeTotal = PeriodePernikahan::count();

        $chartStatus = [
            'pending' => $pending,
            'proses'  => $proses,
            'selesai' => $selesai,
        ];
        $chartPembayaran = [
            'belum_bayar' => PendaftaranPernikahan::where('status_pembayaran', 'belum_bayar')->count(),
            'sudah_bayar' => PendaftaranPernikahan::where('status_pembayaran', 'sudah_bayar')->count(),
        ];

        return view('dashboard.admin', compact(
            'totalPendaftaran', 'pending', 'proses', 'selesai',
            'periodeAktif', 'periodeTotal', 'chartStatus', 'chartPembayaran'
        ));
    }

    /** Dashboard untuk user: pesan masuk & info */
    public function user(Request $request)
    {
        $user = $request->user();
        $pesan = $user->pesanDashboard()->paginate(10);
        $pendaftaran = $user->pendaftaranPernikahan()->with('periode')->latest()->get();

        return view('dashboard.user', compact('pesan', 'pendaftaran'));
    }
}
