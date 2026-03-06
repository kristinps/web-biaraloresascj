<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MateriKursus;
use App\Models\PeriodePernikahan;
use App\Notifications\MateriKursusNotification;
use App\Notifications\ZoomKursusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriKursusController extends Controller
{
    public function index(PeriodePernikahan $periode)
    {
        $materiList    = $periode->materi()->get();
        $jumlahPeserta = $periode->pendaftaran()->count();
        return view('admin.materi.index', compact('periode', 'materiList', 'jumlahPeserta'));
    }

    public function store(Request $request, PeriodePernikahan $periode)
    {
        $request->validate([
            'judul'               => ['required', 'string', 'max:255'],
            'deskripsi'           => ['nullable', 'string'],
            'file_materi'         => ['nullable', 'file', 'mimes:pdf,doc,docx,ppt,pptx,zip', 'max:20480'],
            'zoom_link'           => ['nullable', 'url', 'max:500'],
            'tanggal_pelaksanaan' => ['nullable', 'date'],
            'urutan'              => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $filePath = null;
        if ($request->hasFile('file_materi')) {
            $filePath = $request->file('file_materi')->store('materi-kursus', 'public');
        }

        $periode->materi()->create([
            'judul'               => $request->judul,
            'deskripsi'           => $request->deskripsi,
            'file_materi'         => $filePath,
            'zoom_link'           => $request->zoom_link,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'urutan'              => $request->urutan,
        ]);

        return back()->with('success', 'Materi kursus berhasil ditambahkan.');
    }

    public function update(Request $request, MateriKursus $materi)
    {
        $request->validate([
            'judul'               => ['required', 'string', 'max:255'],
            'deskripsi'           => ['nullable', 'string'],
            'file_materi'         => ['nullable', 'file', 'mimes:pdf,doc,docx,ppt,pptx,zip', 'max:20480'],
            'zoom_link'           => ['nullable', 'url', 'max:500'],
            'tanggal_pelaksanaan' => ['nullable', 'date'],
            'urutan'              => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $filePath = $materi->file_materi;
        if ($request->hasFile('file_materi')) {
            if ($filePath) Storage::disk('public')->delete($filePath);
            $filePath = $request->file('file_materi')->store('materi-kursus', 'public');
        }

        $materi->update([
            'judul'               => $request->judul,
            'deskripsi'           => $request->deskripsi,
            'file_materi'         => $filePath,
            'zoom_link'           => $request->zoom_link,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'urutan'              => $request->urutan,
        ]);

        return back()->with('success', 'Materi kursus berhasil diperbarui.');
    }

    public function destroy(MateriKursus $materi)
    {
        if ($materi->file_materi) Storage::disk('public')->delete($materi->file_materi);
        $periodeId = $materi->periode_id;
        $materi->delete();
        return redirect()->route('admin.materi.index', $periodeId)->with('success', 'Materi kursus berhasil dihapus.');
    }

    public function kirimMateri(MateriKursus $materi)
    {
        $peserta = $materi->periode->pendaftaran()->get();
        if ($peserta->isEmpty()) return back()->with('error', 'Tidak ada peserta dalam periode ini.');
        foreach ($peserta as $p) $p->notify(new MateriKursusNotification($materi, $p));
        $materi->update(['terkirim_materi' => true]);
        return back()->with('success', "Materi '{$materi->judul}' berhasil dikirim ke {$peserta->count()} peserta.");
    }

    public function kirimZoom(MateriKursus $materi)
    {
        if (!$materi->zoom_link) return back()->with('error', 'Link Zoom belum diisi untuk materi ini.');
        $peserta = $materi->periode->pendaftaran()->get();
        if ($peserta->isEmpty()) return back()->with('error', 'Tidak ada peserta dalam periode ini.');
        foreach ($peserta as $p) $p->notify(new ZoomKursusNotification($materi, $p));
        $materi->update(['terkirim_zoom' => true]);
        return back()->with('success', "Link Zoom '{$materi->judul}' berhasil dikirim ke {$peserta->count()} peserta.");
    }
}
