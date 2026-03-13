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

    /**
     * Setuju satu dokumen (per field) → tandai sebagai diterima, kirim email.
     */
    public function setujuPerDokumen(Request $request, PendaftaranPernikahan $pendaftaran, string $field)
    {
        $fields = PendaftaranPernikahan::dokumenFields();
        if (!isset($fields[$field])) {
            abort(404);
        }

        $status = $pendaftaran->dokumen_status_verifikasi ?? [];
        $status[$field] = true;

        // Hitung ulang status_dokumen global: jika semua field yang ada filenya sudah true → lengkap
        $allTrue = true;
        foreach (array_keys($fields) as $f) {
            if (!empty($pendaftaran->$f)) {
                if (!filter_var($status[$f] ?? false, FILTER_VALIDATE_BOOLEAN)) {
                    $allTrue = false;
                    break;
                }
            }
        }

        $pendaftaran->dokumen_status_verifikasi = $status;
        $pendaftaran->status_dokumen = $allTrue ? 'lengkap' : ($pendaftaran->status_dokumen ?: 'sedang_diperiksa');
        $pendaftaran->save();

        $label = $fields[$field];
        $pesan = "Dokumen \"{$label}\" telah diterima oleh admin.";
        $pendaftaran->notify(new DokumenStatusNotification($pendaftaran, $pesan));

        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';
        return redirect()
            ->route($routePrefix . '.pendaftaran.show', $pendaftaran->id)
            ->with('success', 'Dokumen "' . $label . '" diterima. Email notifikasi telah dikirim ke peserta.');
    }

    /**
     * Tolak satu dokumen (per field) → tandai sebagai ditolak, kirim email.
     */
    public function tolakPerDokumen(Request $request, PendaftaranPernikahan $pendaftaran, string $field)
    {
        $fields = PendaftaranPernikahan::dokumenFields();
        if (!isset($fields[$field])) {
            abort(404);
        }

        $status = $pendaftaran->dokumen_status_verifikasi ?? [];
        $status[$field] = false;

        // Hitung ulang status_dokumen global: jika ada yang false → tidak_lengkap
        $hasFalse = false;
        $allTrue = true;
        foreach (array_keys($fields) as $f) {
            if (!empty($pendaftaran->$f)) {
                $val = filter_var($status[$f] ?? false, FILTER_VALIDATE_BOOLEAN);
                if (!$val) {
                    $hasFalse = true;
                    $allTrue = false;
                }
            }
        }

        if ($hasFalse) {
            $pendaftaran->status_dokumen = 'tidak_lengkap';
        } elseif ($allTrue) {
            $pendaftaran->status_dokumen = 'lengkap';
        } else {
            $pendaftaran->status_dokumen = $pendaftaran->status_dokumen ?: 'sedang_diperiksa';
        }
        $pendaftaran->dokumen_status_verifikasi = $status;
        $pendaftaran->save();

        $label = $fields[$field];
        $pesan = "Dokumen \"{$label}\" tidak diterima. Silakan perbaiki atau unggah ulang sesuai petunjuk admin.";
        $pendaftaran->notify(new DokumenStatusNotification($pendaftaran, $pesan));

        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';
        return redirect()
            ->route($routePrefix . '.pendaftaran.show', $pendaftaran->id)
            ->with('success', 'Dokumen "' . $label . '" ditolak. Email notifikasi telah dikirim ke peserta.');
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

    /** Update status verifikasi per dokumen (✔/✖) */
    public function updateStatusPerDokumen(Request $request, $id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);
        $fields = PendaftaranPernikahan::dokumenFields();
        $status = [];

        foreach (array_keys($fields) as $field) {
            $val = $request->input("dokumen_status.{$field}");
            $status[$field] = $val === '1' || $val === 'true';
        }

        $pendaftaran->update(['dokumen_status_verifikasi' => $status]);

        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';
        return redirect()->route($routePrefix . '.pendaftaran.show', $id)
            ->with('success', 'Status dokumen berhasil disimpan.');
    }
}
