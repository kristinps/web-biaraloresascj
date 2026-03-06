<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPernikahan;
use App\Models\PeriodePernikahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $periodeAktif = PeriodePernikahan::periodeAktif();

        $stats = [
            'total'       => PendaftaranPernikahan::count(),
            'lunas'       => PendaftaranPernikahan::where('status_pembayaran', 'lunas')->count(),
            'menunggu'    => PendaftaranPernikahan::where('status_pembayaran', 'menunggu')->count(),
            'belum_bayar' => PendaftaranPernikahan::where('status_pembayaran', 'belum_bayar')->count(),
        ];

        $statsPeriodeAktif = null;
        if ($periodeAktif) {
            $q = fn() => $periodeAktif->pendaftaran();
            $statsPeriodeAktif = [
                'total'       => $q()->count(),
                'lunas'       => $q()->where('status_pembayaran', 'lunas')->count(),
                'menunggu'    => $q()->where('status_pembayaran', 'menunggu')->count(),
                'belum_bayar' => $q()->where('status_pembayaran', 'belum_bayar')->count(),
            ];
        }

        $pendaftaran = PendaftaranPernikahan::with('periode')->latest()->paginate(10);

        $totalPeriode = PeriodePernikahan::count();

        // ── Chart: Tren pendaftaran 12 bulan terakhir ──
        $rawBulan = PendaftaranPernikahan::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as bulan, COUNT(*) as total")
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $chartBulanLabels = [];
        $chartBulanData   = [];
        for ($i = 11; $i >= 0; $i--) {
            $key = now()->subMonths($i)->format('Y-m');
            $chartBulanLabels[] = now()->subMonths($i)->format('M Y');
            $chartBulanData[]   = (int) ($rawBulan[$key] ?? 0);
        }

        // ── Chart: Pendaftaran per Periode ──
        $periodeChart = PeriodePernikahan::withCount([
            'pendaftaran',
            'pendaftaran as pendaftaran_lunas_count'    => fn($q) => $q->where('status_pembayaran', 'lunas'),
            'pendaftaran as pendaftaran_menunggu_count' => fn($q) => $q->where('status_pembayaran', 'menunggu'),
            'pendaftaran as pendaftaran_belum_count'    => fn($q) => $q->where('status_pembayaran', 'belum_bayar'),
        ])->latest()->take(8)->get();

        $chartPeriodeLabels  = $periodeChart->pluck('nama')->toArray();
        $chartPeriodeLunas   = $periodeChart->pluck('pendaftaran_lunas_count')->toArray();
        $chartPeriodeMenunggu= $periodeChart->pluck('pendaftaran_menunggu_count')->toArray();
        $chartPeriodeBelum   = $periodeChart->pluck('pendaftaran_belum_count')->toArray();

        return view('admin.dashboard', compact(
            'stats',
            'statsPeriodeAktif',
            'periodeAktif',
            'pendaftaran',
            'totalPeriode',
            'chartBulanLabels',
            'chartBulanData',
            'chartPeriodeLabels',
            'chartPeriodeLunas',
            'chartPeriodeMenunggu',
            'chartPeriodeBelum'
        ));
    }

    public function list(Request $request)
    {
        $query = PendaftaranPernikahan::with('periode')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pria', 'like', "%{$search}%")
                  ->orWhere('nama_wanita', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        if ($request->filled('periode')) {
            if ($request->periode === 'tanpa_periode') {
                $query->whereNull('periode_id');
            } else {
                $query->where('periode_id', $request->periode);
            }
        }

        $pendaftaran = $query->paginate(15);
        $periodeList = PeriodePernikahan::orderBy('status')->latest()->get();

        return view('admin.pendaftaran.index', compact('pendaftaran', 'periodeList'));
    }

    public function show($id)
    {
        $pendaftaran = PendaftaranPernikahan::with('periode')->findOrFail($id);
        $periodeList = PeriodePernikahan::aktif()->latest()->get();

        return view('admin.pendaftaran.show', compact('pendaftaran', 'periodeList'));
    }
}
