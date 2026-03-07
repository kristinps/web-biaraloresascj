<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPernikahan;
use App\Models\SuratKelulusan;
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
        return view('user.biaya');
    }

    public function sertifikat()
    {
        $pendaftaranList = $this->getPendaftaranList();
        return view('user.sertifikat', compact('pendaftaranList'));
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
