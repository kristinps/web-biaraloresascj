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
        $periodeAktifCount = PeriodePernikahan::aktif()->count();
        $periodeSelesaiCount = PeriodePernikahan::selesai()->count();
        $periodeTotal = PeriodePernikahan::count();

        $pesertaTanpaPeriode = PendaftaranPernikahan::whereNull('periode_id')->count();
        $pesertaPeriodeAktif = PendaftaranPernikahan::whereHas('periode', fn ($q) => $q->aktif())->count();
        $pesertaPeriodeSelesai = PendaftaranPernikahan::whereHas('periode', fn ($q) => $q->selesai())->count();

        $chartStatus = [
            'pending' => $pending,
            'proses'  => $proses,
            'selesai' => $selesai,
        ];
        $chartPembayaran = [
            'belum_bayar' => PendaftaranPernikahan::where('status_pembayaran', 'belum_bayar')->count(),
            'sudah_bayar' => PendaftaranPernikahan::where('status_pembayaran', 'sudah_bayar')->count(),
        ];

        $chartPeriodePeserta = [
            'labels' => ['Tanpa Periode', 'Periode Aktif', 'Periode Selesai'],
            'values' => [$pesertaTanpaPeriode, $pesertaPeriodeAktif, $pesertaPeriodeSelesai],
        ];

        // Grafik 2: jumlah peserta aktif per periode aktif
        $periodeAktifList = PeriodePernikahan::aktif()
            ->withCount('pendaftaran')
            ->orderBy('tanggal_mulai')
            ->get();
        $chartPesertaPerPeriodeAktif = [
            'labels' => $periodeAktifList->pluck('nama')->toArray(),
            'values' => $periodeAktifList->pluck('pendaftaran_count')->toArray(),
        ];

        // Grafik 3: jumlah peserta selesai per periode selesai
        $periodeSelesaiList = PeriodePernikahan::selesai()
            ->withCount('pendaftaran')
            ->orderBy('tanggal_selesai')
            ->get();
        $chartPesertaPerPeriodeSelesai = [
            'labels' => $periodeSelesaiList->pluck('nama')->toArray(),
            'values' => $periodeSelesaiList->pluck('pendaftaran_count')->toArray(),
        ];

        // Grafik lingkaran: jumlah periode aktif (satu slice per periode aktif)
        $chartPeriodeAktif = [
            'labels' => $periodeAktifList->pluck('nama')->toArray(),
            'values' => array_fill(0, $periodeAktifList->count(), 1),
        ];

        // Grafik lingkaran: jumlah periode selesai (satu slice per periode selesai)
        $chartPeriodeSelesai = [
            'labels' => $periodeSelesaiList->pluck('nama')->toArray(),
            'values' => array_fill(0, $periodeSelesaiList->count(), 1),
        ];

        return view('dashboard.admin', compact(
            'totalPendaftaran', 'pending', 'proses', 'selesai',
            'periodeAktifCount', 'periodeSelesaiCount', 'periodeTotal',
            'pesertaTanpaPeriode', 'pesertaPeriodeAktif', 'pesertaPeriodeSelesai',
            'chartStatus', 'chartPembayaran', 'chartPeriodePeserta',
            'chartPesertaPerPeriodeAktif', 'chartPesertaPerPeriodeSelesai',
            'chartPeriodeAktif', 'chartPeriodeSelesai'
        ));
    }

    /** Halaman pilih periode untuk kelola materi (admin) */
    public function materiPilihPeriode()
    {
        $periodeAktif = PeriodePernikahan::aktif()->withCount(['materi', 'pendaftaran'])->latest()->get();
        $periodeSelesai = PeriodePernikahan::selesai()->withCount(['materi', 'pendaftaran'])->latest()->take(10)->get();

        return view('dashboard.materi-periode', compact('periodeAktif', 'periodeSelesai'));
    }

    /** Halaman pilih periode untuk kelola kehadiran (admin) */
    public function kehadiranPilihPeriode()
    {
        $periodeAktif = PeriodePernikahan::aktif()->withCount(['materi', 'pendaftaran'])->latest()->get();
        $periodeSelesai = PeriodePernikahan::selesai()->withCount(['materi', 'pendaftaran'])->latest()->take(10)->get();

        return view('dashboard.kehadiran-periode', compact('periodeAktif', 'periodeSelesai'));
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
