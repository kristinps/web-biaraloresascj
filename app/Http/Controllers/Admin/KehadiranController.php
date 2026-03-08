<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KehadiranKursus;
use App\Models\PendaftaranPernikahan;
use App\Models\PeriodePernikahan;
use App\Notifications\AbsensiDisimpanNotification;
use App\Notifications\StatusKursusBerubahNotification;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index(PeriodePernikahan $periode)
    {
        $materiList  = $periode->materi()->get();
        $pesertaList = $periode->pendaftaran()->get();
        $kehadiranMap = [];
        if ($materiList->isNotEmpty() && $pesertaList->isNotEmpty()) {
            $records = KehadiranKursus::whereIn('pendaftaran_id', $pesertaList->pluck('id'))
                ->whereIn('materi_kursus_id', $materiList->pluck('id'))->get();
            foreach ($records as $k) {
                $kehadiranMap[$k->pendaftaran_id][$k->materi_kursus_id] = $k;
            }
        }
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        return view('admin.kehadiran.index', compact('periode', 'materiList', 'pesertaList', 'kehadiranMap', 'routePrefix'));
    }

    public function updateBulk(Request $request, PeriodePernikahan $periode)
    {
        $materiList  = $periode->materi()->pluck('id');
        $pesertaList = $periode->pendaftaran()->pluck('id');
        foreach ($pesertaList as $pendaftaranId) {
            foreach ($materiList as $materiId) {
                KehadiranKursus::updateOrCreate(
                    ['pendaftaran_id' => $pendaftaranId, 'materi_kursus_id' => $materiId],
                    [
                        'hadir_tatap_muka' => $request->boolean("tatap_{$pendaftaranId}_{$materiId}"),
                        'hadir_zoom'       => $request->boolean("zoom_{$pendaftaranId}_{$materiId}"),
                    ]
                );
            }
        }
        $peserta = $periode->pendaftaran()->get();
        foreach ($peserta as $p) {
            $p->notify(new AbsensiDisimpanNotification($periode));
        }
        return back()->with('success', 'Data kehadiran berhasil disimpan. Email notifikasi telah dikirim ke ' . $peserta->count() . ' peserta.');
    }

    public function updateStatusKursus(Request $request, PendaftaranPernikahan $pendaftaran)
    {
        $request->validate(['status_kursus' => ['required', 'in:terjadwal,sedang_berjalan,lulus,tidak_lulus']]);
        $pendaftaran->update(['status_kursus' => $request->status_kursus]);
        $pendaftaran->notify(new StatusKursusBerubahNotification($pendaftaran, $request->status_kursus));
        return back()->with('success', 'Status kursus peserta berhasil diperbarui. Email notifikasi telah dikirim ke peserta.');
    }
}
