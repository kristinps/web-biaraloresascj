<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPernikahan;
use App\Models\PeriodePernikahan;
use App\Notifications\StatusKursusBerubahNotification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function list(Request $request)
    {
        $query = PendaftaranPernikahan::whereNull('periode_id')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pria', 'like', "%{$search}%")
                  ->orWhere('nama_wanita', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pendaftaran = $query->paginate(15);

        // Data periode untuk select di modal tombol Centang
        $periodes = PeriodePernikahan::aktif()->orderByDesc('tanggal_mulai')->get();

        // Data periode untuk ringkasan di bagian bawah halaman
        $periodeAktif = PeriodePernikahan::aktif()
            ->withCount('pendaftaran')
            ->with(['pendaftaran' => function ($q) {
                $q->latest()->take(10);
            }])
            ->latest()
            ->get();

        $periodeSelesai = PeriodePernikahan::selesai()
            ->withCount('pendaftaran')
            ->latest()
            ->take(10)
            ->get();

        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        return view('admin.pendaftaran.index', compact(
            'pendaftaran',
            'routePrefix',
            'periodeAktif',
            'periodeSelesai',
            'periodes'
        ));
    }

    /** Assign periode ke pendaftaran (tombol Centang) */
    public function assignPeriode(Request $request, $id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);
        if ($pendaftaran->periode_id) {
            $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';
            return redirect()->route($routePrefix . '.pendaftaran.index')
                ->with('error', 'Pendaftaran ini sudah memiliki periode.');
        }

        $request->validate([
            'periode_id' => 'required|exists:periode_pernikahan,id',
        ], [
            'periode_id.required' => 'Pilih periode untuk peserta.',
            'periode_id.exists'   => 'Periode tidak valid.',
        ]);

        $pendaftaran->update([
            'periode_id'    => $request->periode_id,
            'status_kursus' => 'terjadwal',
        ]);

        $pendaftaran->notify(new StatusKursusBerubahNotification($pendaftaran, 'terjadwal'));

        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';
        return redirect()->route($routePrefix . '.pendaftaran.index')
            ->with('success', 'Periode berhasil dipilih. Peserta terdaftar pada periode yang dipilih dan email notifikasi telah dikirim.');
    }

    /** Daftar pendaftaran masuk (status menunggu persetujuan admin) */
    public function listMasuk(Request $request)
    {
        $query = PendaftaranPernikahan::where('status_kursus', 'menunggu')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pria', 'like', "%{$search}%")
                  ->orWhere('nama_wanita', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pendaftaran = $query->paginate(15);
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        return view('admin.pendaftaran.masuk', compact('pendaftaran', 'routePrefix'));
    }

    public function show($id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';
        $periodes = !$pendaftaran->periode_id
            ? \App\Models\PeriodePernikahan::aktif()->orderByDesc('tanggal_mulai')->get()
            : collect();

        return view('admin.pendaftaran.show', compact('pendaftaran', 'routePrefix', 'periodes'));
    }

    /** Form pilih periode untuk menyetujui pendaftaran */
    public function showSetuju($id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);
        if (($pendaftaran->status_kursus ?? '') !== 'menunggu') {
            return redirect()->route(request()->routeIs('dashboard.*') ? 'dashboard.pendaftaran.masuk' : 'admin.pendaftaran.masuk')
                ->with('error', 'Pendaftaran ini sudah diproses.');
        }
        $periodes = PeriodePernikahan::aktif()->orderByDesc('tanggal_mulai')->get();
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        return view('admin.pendaftaran.setuju', compact('pendaftaran', 'periodes', 'routePrefix'));
    }

    /** Simpan persetujuan: pilih periode & ubah status jadi terdaftar (terjadwal) */
    public function setuju(Request $request, $id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);
        if (($pendaftaran->status_kursus ?? '') !== 'menunggu') {
            return redirect()->route(request()->routeIs('dashboard.*') ? 'dashboard.pendaftaran.masuk' : 'admin.pendaftaran.masuk')
                ->with('error', 'Pendaftaran ini sudah diproses.');
        }

        $request->validate([
            'periode_id' => 'required|exists:periode_pernikahan,id',
        ], [
            'periode_id.required' => 'Pilih periode untuk peserta.',
            'periode_id.exists'   => 'Periode tidak valid.',
        ]);

        $pendaftaran->update([
            'periode_id'     => $request->periode_id,
            'status_kursus'  => 'terjadwal',
        ]);

        $pendaftaran->notify(new StatusKursusBerubahNotification($pendaftaran, 'terjadwal'));

        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';
        return redirect()->route($routePrefix . '.pendaftaran.masuk')
            ->with('success', 'Pendaftaran disetujui. Peserta terdaftar pada periode yang dipilih dan email notifikasi telah dikirim.');
    }
}
