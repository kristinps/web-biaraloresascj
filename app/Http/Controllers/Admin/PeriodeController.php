<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodePernikahan;
use App\Models\PendaftaranPernikahan;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodeAktif  = PeriodePernikahan::aktif()->withCount('pendaftaran')->latest()->get();
        $periodeSelesai = PeriodePernikahan::selesai()->withCount('pendaftaran')->latest()->paginate(10);

        return view('admin.periode.index', compact('periodeAktif', 'periodeSelesai'));
    }

    public function create()
    {
        return view('admin.periode.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'catatan'       => 'nullable|string',
        ]);

        PeriodePernikahan::create([
            'nama'          => $request->nama,
            'tanggal_mulai' => $request->tanggal_mulai,
            'catatan'       => $request->catatan,
            'status'        => 'aktif',
        ]);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode baru berhasil dibuat.');
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

        return view('admin.periode.show', compact('periode', 'pendaftaran', 'stats'));
    }

    public function edit(PeriodePernikahan $periode)
    {
        return view('admin.periode.edit', compact('periode'));
    }

    public function update(Request $request, PeriodePernikahan $periode)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'catatan'       => 'nullable|string',
        ]);

        $periode->update([
            'nama'          => $request->nama,
            'tanggal_mulai' => $request->tanggal_mulai,
            'catatan'       => $request->catatan,
        ]);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode berhasil diperbarui.');
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

        return redirect()->route('admin.periode.index')
            ->with('success', "Periode \"{$periode->nama}\" berhasil ditutup.");
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

        return redirect()->route('admin.periode.index')
            ->with('success', "Periode \"{$periode->nama}\" berhasil diaktifkan kembali.");
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

        $periode->delete();

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode berhasil dihapus.');
    }
}
