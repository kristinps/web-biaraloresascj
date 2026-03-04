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
        ], [
            // Pria
            'nama_pria.required'                  => 'Nama lengkap calon pria wajib diisi.',
            'tempat_lahir_pria.required'           => 'Tempat lahir calon pria wajib diisi.',
            'tanggal_lahir_pria.required'          => 'Tanggal lahir calon pria wajib diisi.',
            'tanggal_lahir_pria.date'              => 'Format tanggal lahir calon pria tidak valid.',
            'nik_pria.required'                    => 'NIK calon pria wajib diisi.',
            'nik_pria.size'                        => 'NIK calon pria harus tepat 16 digit.',
            'agama_pria.required'                  => 'Agama calon pria wajib diisi.',
            'pekerjaan_pria.required'              => 'Pekerjaan calon pria wajib diisi.',
            'alamat_pria.required'                 => 'Alamat calon pria wajib diisi.',
            'nama_ayah_pria.required'              => 'Nama ayah calon pria wajib diisi.',
            'nama_ibu_pria.required'               => 'Nama ibu calon pria wajib diisi.',
            // Wanita
            'nama_wanita.required'                 => 'Nama lengkap calon wanita wajib diisi.',
            'tempat_lahir_wanita.required'         => 'Tempat lahir calon wanita wajib diisi.',
            'tanggal_lahir_wanita.required'        => 'Tanggal lahir calon wanita wajib diisi.',
            'tanggal_lahir_wanita.date'            => 'Format tanggal lahir calon wanita tidak valid.',
            'nik_wanita.required'                  => 'NIK calon wanita wajib diisi.',
            'nik_wanita.size'                      => 'NIK calon wanita harus tepat 16 digit.',
            'agama_wanita.required'                => 'Agama calon wanita wajib diisi.',
            'pekerjaan_wanita.required'            => 'Pekerjaan calon wanita wajib diisi.',
            'alamat_wanita.required'               => 'Alamat calon wanita wajib diisi.',
            'nama_ayah_wanita.required'            => 'Nama ayah calon wanita wajib diisi.',
            'nama_ibu_wanita.required'             => 'Nama ibu calon wanita wajib diisi.',
            // Pernikahan & Kontak
            'tanggal_pernikahan.required'          => 'Tanggal rencana pernikahan wajib diisi.',
            'tanggal_pernikahan.date'              => 'Format tanggal pernikahan tidak valid.',
            'tanggal_pernikahan.after'             => 'Tanggal pernikahan harus setelah hari ini.',
            'tempat_pernikahan.required'           => 'Tempat rencana pernikahan wajib diisi.',
            'email.required'                       => 'Alamat email wajib diisi.',
            'email.email'                          => 'Format alamat email tidak valid.',
            'nomor_hp.required'                    => 'Nomor HP/WhatsApp wajib diisi.',
            // Dokumen
            'ktp_pria.mimes'                       => 'KTP calon pria harus berformat JPG, PNG, atau PDF.',
            'ktp_pria.max'                         => 'Ukuran file KTP calon pria maksimal 2 MB.',
            'ktp_wanita.mimes'                     => 'KTP calon wanita harus berformat JPG, PNG, atau PDF.',
            'ktp_wanita.max'                       => 'Ukuran file KTP calon wanita maksimal 2 MB.',
            'surat_baptis_pria.mimes'              => 'Surat baptis calon pria harus berformat JPG, PNG, atau PDF.',
            'surat_baptis_pria.max'                => 'Ukuran file surat baptis calon pria maksimal 2 MB.',
            'surat_baptis_wanita.mimes'            => 'Surat baptis calon wanita harus berformat JPG, PNG, atau PDF.',
            'surat_baptis_wanita.max'              => 'Ukuran file surat baptis calon wanita maksimal 2 MB.',
            'surat_pengantar_kombas_pria.mimes'    => 'Surat pengantar kombas calon pria harus berformat JPG, PNG, atau PDF.',
            'surat_pengantar_kombas_pria.max'      => 'Ukuran file surat pengantar kombas calon pria maksimal 2 MB.',
            'surat_pengantar_kombas_wanita.mimes'  => 'Surat pengantar kombas calon wanita harus berformat JPG, PNG, atau PDF.',
            'surat_pengantar_kombas_wanita.max'    => 'Ukuran file surat pengantar kombas calon wanita maksimal 2 MB.',
        ]);

        $dokumenFields = [
            'ktp_pria', 'ktp_wanita',
            'surat_baptis_pria', 'surat_baptis_wanita',
            'surat_pengantar_kombas_pria', 'surat_pengantar_kombas_wanita',
        ];

        foreach ($dokumenFields as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('dokumen-pernikahan', 'public');
            }
        }

        $validated['status_pembayaran'] = 'belum_bayar';
        $pendaftaran = PendaftaranPernikahan::create($validated);

        return redirect()->route('pembayaran.show', ['id' => $pendaftaran->id])
            ->with('success', 'Biodata berhasil disimpan. Silakan selesaikan pembayaran.');
    }

    public function sukses(Request $request, $id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);
        return view('kursus-pernikahan.sukses', compact('pendaftaran'));
    }
}
