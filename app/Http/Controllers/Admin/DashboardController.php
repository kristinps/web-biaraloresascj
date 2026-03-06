<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPernikahan;
use App\Models\PeriodePernikahan;
use Illuminate\Http\Request;

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

        return view('admin.dashboard', compact(
            'stats',
            'statsPeriodeAktif',
            'periodeAktif',
            'pendaftaran',
            'totalPeriode'
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
