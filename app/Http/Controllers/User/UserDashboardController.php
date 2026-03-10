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
        $pendaftaranList = $this->getPendaftaranList();
        return view('user.status-pendaftaran', compact('pendaftaranList'));
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
    public function submitPerbaikanDokumen(Request $request, int $id)
    {
        $user = Auth::user();
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);
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

        return redirect()->route('dashboard.user.dokumen')
            ->with('success', 'Perbaikan dokumen telah dikirim. Admin akan memeriksa kembali.');
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
