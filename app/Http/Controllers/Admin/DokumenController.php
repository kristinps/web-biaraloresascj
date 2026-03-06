<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPernikahan;
use App\Notifications\DokumenStatusNotification;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status_dokumen'  => ['required', 'in:belum_diperiksa,lengkap,tidak_lengkap'],
            'catatan_dokumen' => ['nullable', 'string', 'max:2000'],
            'kirim_email'     => ['nullable', 'boolean'],
        ]);

        $pendaftaran = PendaftaranPernikahan::findOrFail($id);

        $pendaftaran->update([
            'status_dokumen'  => $request->status_dokumen,
            'catatan_dokumen' => $request->catatan_dokumen,
        ]);

        if ($request->boolean('kirim_email')) {
            $pendaftaran->notify(new DokumenStatusNotification(
                $pendaftaran,
                $request->catatan_dokumen ?? ''
            ));
        }

        $label = match ($request->status_dokumen) {
            'lengkap'       => 'Dokumen dinyatakan lengkap',
            'tidak_lengkap' => 'Dokumen dinyatakan tidak lengkap',
            default         => 'Status dokumen diperbarui',
        };

        $suffix = $request->boolean('kirim_email') ? ' dan email notifikasi telah dikirim.' : '.';

        return back()->with('success', $label . $suffix);
    }
}
