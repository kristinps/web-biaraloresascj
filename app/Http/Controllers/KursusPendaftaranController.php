<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPernikahan;
use Illuminate\Http\Request;

class KursusPendaftaranController extends Controller
{
    public function index()
    {
        return view('kursus-pernikahan.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pria'            => 'required|string|max:255',
            'tempat_lahir_pria'    => 'required|string|max:255',
            'tanggal_lahir_pria'   => 'required|date',
            'nik_pria'             => 'required|string|size:16',
            'agama_pria'           => 'required|string|max:50',
            'pekerjaan_pria'       => 'required|string|max:255',
            'alamat_pria'          => 'required|string',
            'nama_ayah_pria'       => 'required|string|max:255',
            'nama_ibu_pria'        => 'required|string|max:255',

            'nama_wanita'          => 'required|string|max:255',
            'tempat_lahir_wanita'  => 'required|string|max:255',
            'tanggal_lahir_wanita' => 'required|date',
            'nik_wanita'           => 'required|string|size:16',
            'agama_wanita'         => 'required|string|max:50',
            'pekerjaan_wanita'     => 'required|string|max:255',
            'alamat_wanita'        => 'required|string',
            'nama_ayah_wanita'     => 'required|string|max:255',
            'nama_ibu_wanita'      => 'required|string|max:255',

            'tanggal_pernikahan'   => 'required|date|after:today',
            'tempat_pernikahan'    => 'required|string|max:255',
            'email'                => 'required|email|max:255',
            'nomor_hp'             => 'required|string|max:20',

            'ktp_pria'                     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp_wanita'                   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_baptis_pria'            => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_baptis_wanita'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_pengantar_kombas_pria'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_pengantar_kombas_wanita'=> 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'metode_pembayaran'            => 'required|string|max:100',
            'bukti_pembayaran'             => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'nik_pria.size'                => 'NIK calon pria harus 16 digit.',
            'nik_wanita.size'              => 'NIK calon wanita harus 16 digit.',
            'tanggal_pernikahan.after'     => 'Tanggal pernikahan harus setelah hari ini.',
        ]);

        $dokumenFields = [
            'ktp_pria', 'ktp_wanita',
            'surat_baptis_pria', 'surat_baptis_wanita',
            'surat_pengantar_kombas_pria', 'surat_pengantar_kombas_wanita',
            'bukti_pembayaran',
        ];

        foreach ($dokumenFields as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('dokumen-pernikahan', 'public');
            }
        }

        $pendaftaran = PendaftaranPernikahan::create($validated);

        return redirect()->route('kursus-pernikahan.sukses', ['id' => $pendaftaran->id])
            ->with('success', 'Pendaftaran kursus pernikahan berhasil dikirim!');
    }

    public function sukses(Request $request, $id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);
        return view('kursus-pernikahan.sukses', compact('pendaftaran'));
    }
}
