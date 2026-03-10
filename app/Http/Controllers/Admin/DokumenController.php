<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPernikahan;
use App\Notifications\DokumenStatusNotification;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    /** Halaman list semua dokumen pendaftaran dengan tombol setuju/tolak */
    public function listDokumen(Request $request)
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

        if ($request->filled('status_dokumen')) {
            $query->where('status_dokumen', $request->status_dokumen);
        }

        $pendaftaran = $query->paginate(15);
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        return view('admin.pendaftaran.dokumen', compact('pendaftaran', 'routePrefix'));
    }

    /** Admin klik centang: setuju dokumen → status diterima (lengkap), kirim email */
    public function setuju($id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);

        $pendaftaran->update([
            'status_dokumen' => 'lengkap',
            'catatan_dokumen' => null,
        ]);

        $pendaftaran->notify(new DokumenStatusNotification($pendaftaran, ''));

        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';
        return redirect()->route($routePrefix . '.pendaftaran.dokumen-list')
            ->with('success', 'Dokumen diterima. Email notifikasi telah dikirim ke ' . $pendaftaran->email . '.');
    }

    /** Admin klik silang: tolak dokumen → status tidak lengkap, kirim email */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'catatan_dokumen' => ['nullable', 'string', 'max:2000'],
        ]);

        $pendaftaran = PendaftaranPernikahan::findOrFail($id);

        $pendaftaran->update([
            'status_dokumen'  => 'tidak_lengkap',
            'catatan_dokumen' => $request->catatan_dokumen,
        ]);

        $pendaftaran->notify(new DokumenStatusNotification(
            $pendaftaran,
            $request->catatan_dokumen ?? 'Mohon lengkapi atau perbaiki dokumen sesuai catatan.'
        ));

        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';
        return redirect()->route($routePrefix . '.pendaftaran.dokumen-list')
            ->with('success', 'Dokumen ditolak. Email notifikasi telah dikirim ke ' . $pendaftaran->email . '.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_dokumen'  => ['required', 'in:belum_diperiksa,sedang_diperiksa,lengkap,tidak_lengkap'],
            'catatan_dokumen' => ['nullable', 'string', 'max:2000'],
            'kirim_email'     => ['nullable', 'boolean'],
        ]);

        $pendaftaran = PendaftaranPernikahan::findOrFail($id);

        $pendaftaran->update([
            'status_dokumen'  => $request->status_dokumen,
            'catatan_dokumen' => $request->catatan_dokumen,
        ]);

        $pendaftaran->notify(new DokumenStatusNotification(
            $pendaftaran,
            $request->catatan_dokumen ?? ''
        ));

        $label = match ($request->status_dokumen) {
            'lengkap'          => 'Dokumen dinyatakan lengkap (diterima)',
            'tidak_lengkap'    => 'Dokumen dinyatakan tidak lengkap',
            'sedang_diperiksa' => 'Status dokumen: sedang diperiksa',
            default            => 'Status dokumen diperbarui',
        };

        return back()->with('success', $label . ' Email notifikasi telah dikirim ke peserta.');
    }
}
