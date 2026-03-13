<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPernikahan;
use App\Models\SuratKelulusan;
use App\Models\BiayaTagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    protected function getPendaftaranList()
    {
        $user = Auth::user();
        return PendaftaranPernikahan::where('email', $user->email)
            ->with('periode')
            ->orderByDesc('created_at')
            ->get();
    }

    public function statusPendaftaran()
    {
        $pendaftaran = $this->getPendaftaranList()->first();
        return view('user.status-pendaftaran', compact('pendaftaran'));
    }

    public function dokumen()
    {
        $pendaftaranList = $this->getPendaftaranList();
        return view('user.dokumen', compact('pendaftaranList'));
    }

    public function jadwalMateri()
    {
        $pendaftaranList = $this->getPendaftaranList();
        return view('user.jadwal-materi', compact('pendaftaranList'));
    }

    public function pembayaran()
    {
        $pendaftaranList = $this->getPendaftaranList();
        $pembayaranCtrl = app(\App\Http\Controllers\PembayaranController::class);
        foreach ($pendaftaranList as $p) {
            if ($p->status_pembayaran !== 'lunas') {
                try {
                    $pembayaranCtrl->ensureQrisForDisplay($p);
                    $p->refresh();
                } catch (\Exception $e) {
                    // Abaikan error, tampilkan tombol Bayar/Cek QRIS
                }
            }
        }
        return view('user.pembayaran', compact('pendaftaranList'));
    }

    public function biaya()
    {
        $pendaftaranList = $this->getPendaftaranList();
        $pendaftaranIds = $pendaftaranList->pluck('id');

        $tagihanBiaya = BiayaTagihan::with(['biaya.periode', 'pendaftaran'])
            ->whereIn('pendaftaran_id', $pendaftaranIds)
            ->orderByDesc('created_at')
            ->get();

        return view('user.biaya', compact('pendaftaranList', 'tagihanBiaya'));
    }

    public function sertifikat()
    {
        $pendaftaranList = $this->getPendaftaranList();
        return view('user.sertifikat', compact('pendaftaranList'));
    }

    /** User kirim perbaikan dokumen (setelah admin tolak) → status jadi sedang_diperiksa */
    public function submitPerbaikanDokumen(Request $request, PendaftaranPernikahan $pendaftaran)
    {
        $user = Auth::user();
        if ($pendaftaran->email !== $user->email) {
            abort(403);
        }

        $request->validate([
            'perbaikan_dokumen' => ['required', 'string', 'max:2000'],
        ], [
            'perbaikan_dokumen.required' => 'Isi deskripsi perbaikan atau data yang dilengkapi.',
        ]);

        $pendaftaran->update([
            'perbaikan_dokumen_user' => $request->perbaikan_dokumen,
            'status_dokumen'         => 'sedang_diperiksa',
        ]);

        return redirect()->route('dashboard.user')
            ->with('success', 'Perbaikan dokumen telah dikirim. Admin akan memeriksa kembali.');
    }

    /** User update status dokumen per item (✔/✖) */
    public function updateDokumenStatus(Request $request, PendaftaranPernikahan $pendaftaran)
    {
        $user = Auth::user();
        if ($pendaftaran->email !== $user->email) {
            abort(403);
        }

        $fields = PendaftaranPernikahan::dokumenFields();
        $status = [];
        foreach (array_keys($fields) as $field) {
            $val = $request->input("dokumen_status.{$field}");
            $status[$field] = $val === '1' || $val === 'true';
        }

        $pendaftaran->update(['dokumen_status_verifikasi' => $status]);

        return redirect()->route('user.dokumen')
            ->with('success', 'Status dokumen berhasil disimpan.');
    }

    /** User upload file dokumen per field (saat status ✖) */
    public function uploadDokumen(Request $request, PendaftaranPernikahan $pendaftaran)
    {
        $user = Auth::user();
        if ($pendaftaran->email !== $user->email) {
            abort(403);
        }

        $fields = PendaftaranPernikahan::dokumenFields();
        $field = $request->input('field');
        if (!isset($fields[$field])) {
            return redirect()->route('user.dokumen')->with('error', 'Field dokumen tidak valid.');
        }

        $mimes = in_array($field, ['foto_pria', 'foto_wanita']) ? 'jpg,jpeg,png' : 'jpg,jpeg,png,pdf';
        $request->validate([
            'file' => ['required', 'file', "mimes:{$mimes}", 'max:1048576'],
        ], [
            'file.required' => 'Pilih file terlebih dahulu.',
            'file.mimes'    => 'Format file harus ' . (str_contains($mimes, 'pdf') ? 'JPG, PNG, atau PDF' : 'JPG atau PNG') . '.',
            'file.max'      => 'Ukuran file maksimal 1 GB.',
        ]);

        $path = $request->file('file')->store('dokumen-pernikahan', 'public');

        // Reset status verifikasi khusus field ini supaya kembali "sedang diperiksa"
        $status = $pendaftaran->dokumen_status_verifikasi ?? [];
        if (array_key_exists($field, $status)) {
            unset($status[$field]);
        }

        $pendaftaran->update([
            $field                     => $path,
            'status_dokumen'           => 'sedang_diperiksa',
            'dokumen_status_verifikasi'=> $status ?: null,
        ]);

        return redirect()->route('user.dokumen')
            ->with('success', 'File dokumen berhasil diunggah.');
    }

    public function downloadSertifikat(PendaftaranPernikahan $pendaftaran)
    {
        $user = Auth::user();
        if ($pendaftaran->email !== $user->email) {
            abort(404);
        }
        $surat = SuratKelulusan::where('pendaftaran_id', $pendaftaran->id)->first();
        if (!$surat || !$surat->file) {
            abort(404);
        }
        $path = storage_path('app/public/' . $surat->file);
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->download($path, $surat->nama_surat ?: 'sertifikat.pdf');
    }
}
