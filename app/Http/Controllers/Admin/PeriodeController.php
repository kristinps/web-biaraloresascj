<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodePernikahan;
use App\Models\PendaftaranPernikahan;
use App\Models\User;
use App\Notifications\PeriodeBaruNotification;
use App\Notifications\PeriodeBukaNotification;
use App\Notifications\PeriodeDiperbaruiNotification;
use App\Notifications\PeriodeDihapusNotification;
use App\Notifications\PeriodeTutupNotification;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodeAktif  = PeriodePernikahan::aktif()->withCount('pendaftaran')->latest()->get();
        $periodeSelesai = PeriodePernikahan::selesai()->withCount('pendaftaran')->latest()->paginate(10);
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        return view('admin.periode.index', compact('periodeAktif', 'periodeSelesai', 'routePrefix'));
    }

    public function create()
    {
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        return view('admin.periode.create', compact('routePrefix'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'catatan'       => 'nullable|string',
        ]);

        $periode = PeriodePernikahan::create([
            'nama'            => $request->nama,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->filled('tanggal_selesai') ? $request->tanggal_selesai : null,
            'catatan'         => $request->catatan,
            'status'          => 'aktif',
        ]);

        $admins = User::whereIn('role', [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN])->get();
        foreach ($admins as $admin) {
            $admin->notify(new PeriodeBaruNotification($periode));
        }

        return redirect()->route($this->periodeIndexRoute())
            ->with('success', 'Periode baru berhasil dibuat. Email notifikasi telah dikirim ke admin.');
    }

    public function show(PeriodePernikahan $periode)
    {
        $pendaftaran = $periode->pendaftaran()
            ->latest()
            ->paginate(15);

        $stats = [
            'total'       => $periode->pendaftaran()->count(),
            'lunas'       => $periode->pendaftaran()->where('status_pembayaran', 'lunas')->count(),
            'menunggu'    => $periode->pendaftaran()->where('status_pembayaran', 'menunggu')->count(),
            'belum_bayar' => $periode->pendaftaran()->where('status_pembayaran', 'belum_bayar')->count(),
        ];
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        return view('admin.periode.show', compact('periode', 'pendaftaran', 'stats', 'routePrefix'));
    }

    public function edit(PeriodePernikahan $periode)
    {
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        return view('admin.periode.edit', compact('periode', 'routePrefix'));
    }

    public function update(Request $request, PeriodePernikahan $periode)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'catatan'       => 'nullable|string',
        ]);

        $periode->update([
            'nama'            => $request->nama,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->filled('tanggal_selesai') ? $request->tanggal_selesai : null,
            'catatan'         => $request->catatan,
        ]);

        $peserta = $periode->pendaftaran()->get();
        foreach ($peserta as $p) {
            $p->notify(new PeriodeDiperbaruiNotification($periode));
        }

        return redirect()->route($this->periodeIndexRoute())
            ->with('success', 'Periode berhasil diperbarui. Email notifikasi telah dikirim ke ' . $peserta->count() . ' peserta.');
    }

    public function tutup(PeriodePernikahan $periode)
    {
        if ($periode->status === 'selesai') {
            return back()->with('error', 'Periode sudah ditutup sebelumnya.');
        }

        $periode->update([
            'status'          => 'selesai',
            'tanggal_selesai' => now()->toDateString(),
        ]);

        $peserta = $periode->pendaftaran()->get();
        foreach ($peserta as $p) {
            $p->notify(new PeriodeTutupNotification($periode));
        }

        return redirect()->route($this->periodeIndexRoute())
            ->with('success', "Periode \"{$periode->nama}\" berhasil ditutup. Email notifikasi telah dikirim ke " . $peserta->count() . " peserta.");
    }

    public function buka(PeriodePernikahan $periode)
    {
        if ($periode->status === 'aktif') {
            return back()->with('error', 'Periode sudah aktif.');
        }

        $periode->update([
            'status'          => 'aktif',
            'tanggal_selesai' => null,
        ]);

        $peserta = $periode->pendaftaran()->get();
        foreach ($peserta as $p) {
            $p->notify(new PeriodeBukaNotification($periode));
        }

        return redirect()->route($this->periodeIndexRoute())
            ->with('success', "Periode \"{$periode->nama}\" berhasil diaktifkan kembali. Email notifikasi telah dikirim ke " . $peserta->count() . " peserta.");
    }

    public function assignPendaftaran(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran_pernikahan,id',
            'periode_id'     => 'required|exists:periode_pernikahan,id',
        ]);

        PendaftaranPernikahan::findOrFail($request->pendaftaran_id)
            ->update(['periode_id' => $request->periode_id]);

        return back()->with('success', 'Pendaftaran berhasil dipindahkan ke periode yang dipilih.');
    }

    public function destroy(PeriodePernikahan $periode)
    {
        if ($periode->pendaftaran()->count() > 0) {
            return back()->with('error', 'Periode tidak dapat dihapus karena masih memiliki data pendaftaran.');
        }

        $namaPeriode = $periode->nama;
        $periode->delete();

        $admins = User::whereIn('role', [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN])->get();
        foreach ($admins as $admin) {
            $admin->notify(new PeriodeDihapusNotification($namaPeriode));
        }

        return redirect()->route($this->periodeIndexRoute())
            ->with('success', 'Periode berhasil dihapus. Email notifikasi telah dikirim ke admin.');
    }

    private function periodeIndexRoute(): string
    {
        return request()->routeIs('dashboard.*') ? 'dashboard.periode.index' : 'admin.periode.index';
    }
}
