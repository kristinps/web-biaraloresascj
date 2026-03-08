<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPernikahan;
use App\Models\PeriodePernikahan;
use App\Notifications\JadwalKursusNotification;
use App\Notifications\JadwalSelanjutnyaNotification;
use App\Notifications\PindahJadwalNotification;
use App\Notifications\SertifikatLulusNotification;
use Illuminate\Http\Request;

class KursusController extends Controller
{
    public function kirimJadwal(Request $request, PeriodePernikahan $periode)
    {
        $request->validate(['pesan' => ['nullable', 'string', 'max:3000']]);
        $peserta = $periode->pendaftaran()->get();
        if ($peserta->isEmpty()) return back()->with('error', 'Tidak ada peserta dalam periode ini.');
        foreach ($peserta as $p) {
            $p->update(['status_kursus' => 'terjadwal']);
            $p->notify(new JadwalKursusNotification($periode, $p, $request->pesan ?? ''));
        }
        return back()->with('success', "Jadwal kursus berhasil dikirim ke {$peserta->count()} peserta.");
    }

    public function kirimSertifikat(Request $request, PeriodePernikahan $periode)
    {
        $request->validate(['pesan' => ['nullable', 'string', 'max:3000']]);
        $pesertaLulus = $periode->pendaftaran()->where('status_kursus', 'lulus')->get();
        if ($pesertaLulus->isEmpty()) return back()->with('error', 'Tidak ada peserta yang berstatus lulus dalam periode ini.');
        foreach ($pesertaLulus as $p) $p->notify(new SertifikatLulusNotification($periode, $p, $request->pesan ?? ''));
        return back()->with('success', "Sertifikat kelulusan berhasil dikirim ke {$pesertaLulus->count()} peserta lulus.");
    }

    public function kirimJadwalSelanjutnya(Request $request, PeriodePernikahan $periode)
    {
        $request->validate(['pesan' => ['required', 'string', 'max:5000']]);
        $pesertaLulus = $periode->pendaftaran()->where('status_kursus', 'lulus')->get();
        if ($pesertaLulus->isEmpty()) return back()->with('error', 'Tidak ada peserta yang berstatus lulus dalam periode ini.');
        foreach ($pesertaLulus as $p) $p->notify(new JadwalSelanjutnyaNotification($periode, $p, $request->pesan));
        return back()->with('success', "Jadwal kegiatan selanjutnya berhasil dikirim ke {$pesertaLulus->count()} peserta lulus.");
    }

    public function pindahJadwal(Request $request, PendaftaranPernikahan $pendaftaran)
    {
        $request->validate(['periode_id_baru' => ['required', 'exists:periode_pernikahan,id']]);
        $periodeBaru = PeriodePernikahan::findOrFail($request->periode_id_baru);
        $pendaftaran->update(['periode_id' => $request->periode_id_baru, 'status_kursus' => 'terjadwal']);
        $pendaftaran->notify(new PindahJadwalNotification($pendaftaran, $periodeBaru));
        return back()->with('success', 'Peserta berhasil dipindahkan ke periode baru. Email notifikasi telah dikirim ke peserta.');
    }
}
