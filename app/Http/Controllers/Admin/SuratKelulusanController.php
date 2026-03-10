<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPernikahan;
use App\Models\PeriodePernikahan;
use App\Models\SuratKelulusan;
use App\Notifications\SuratKelulusanNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKelulusanController extends Controller
{
    public function index(Request $request)
    {
        $routePrefix = 'dashboard';

        $periodeId = $request->get('periode_id');

        $periodeList = PeriodePernikahan::orderByDesc('tanggal_mulai')->get();

        $query = SuratKelulusan::query()
            ->with(['pendaftaran.periode'])
            ->orderByDesc('created_at');

        if ($periodeId) {
            $query->whereHas('pendaftaran', function ($q) use ($periodeId) {
                $q->where('periode_id', $periodeId);
            });
        }

        $suratList = $query->paginate(15)->withQueryString();

        return view('admin.sertifikat.index', compact('routePrefix', 'suratList', 'periodeList', 'periodeId'));
    }

    public function create()
    {
        $routePrefix = 'dashboard';

        $periodeList = PeriodePernikahan::orderByDesc('tanggal_mulai')->get();

        $pendaftaranList = PendaftaranPernikahan::with('periode')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.sertifikat.create', compact('routePrefix', 'periodeList', 'pendaftaranList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pendaftaran_id' => ['required', 'exists:pendaftaran_pernikahan,id'],
            'nama_surat'     => ['nullable', 'string', 'max:255'],
            'file'           => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $pendaftaran = PendaftaranPernikahan::with('periode')->findOrFail($data['pendaftaran_id']);

        $path = $request->file('file')->store('sertifikat', 'public');

        $surat = SuratKelulusan::updateOrCreate(
            ['pendaftaran_id' => $pendaftaran->id],
            [
                'file'       => $path,
                'nama_surat' => $data['nama_surat'] ?: 'Sertifikat Kelulusan - ' . $pendaftaran->namaLengkap(),
            ]
        );

        $pendaftaran->notify(new SuratKelulusanNotification($pendaftaran, $surat));

        return redirect()
            ->route('dashboard.sertifikat.index')
            ->with('success', 'Sertifikat kelulusan berhasil disimpan dan email pemberitahuan telah dikirim ke peserta.');
    }

    public function show(SuratKelulusan $surat)
    {
        $routePrefix = 'dashboard';
        $surat->load('pendaftaran.periode');

        return view('admin.sertifikat.show', compact('routePrefix', 'surat'));
    }

    public function edit(SuratKelulusan $surat)
    {
        $routePrefix = 'dashboard';

        $surat->load('pendaftaran.periode');

        return view('admin.sertifikat.edit', compact('routePrefix', 'surat'));
    }

    public function update(Request $request, SuratKelulusan $surat)
    {
        $data = $request->validate([
            'nama_surat' => ['nullable', 'string', 'max:255'],
            'file'       => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($request->hasFile('file')) {
            if ($surat->file && Storage::disk('public')->exists($surat->file)) {
                Storage::disk('public')->delete($surat->file);
            }

            $data['file'] = $request->file('file')->store('sertifikat', 'public');
        }

        $surat->update($data);

        return redirect()
            ->route('dashboard.sertifikat.index')
            ->with('success', 'Sertifikat kelulusan berhasil diperbarui.');
    }

    public function destroy(SuratKelulusan $surat)
    {
        if ($surat->file && Storage::disk('public')->exists($surat->file)) {
            Storage::disk('public')->delete($surat->file);
        }

        $surat->delete();

        return redirect()
            ->route('dashboard.sertifikat.index')
            ->with('success', 'Sertifikat kelulusan berhasil dihapus.');
    }
}

