<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranPernikahan extends Model
{
    protected $table = 'pendaftaran_pernikahan';

    protected $fillable = [
        'nama_pria', 'tempat_lahir_pria', 'tanggal_lahir_pria', 'nik_pria',
        'agama_pria', 'pekerjaan_pria', 'alamat_pria', 'nama_ayah_pria', 'nama_ibu_pria',
        'nama_wanita', 'tempat_lahir_wanita', 'tanggal_lahir_wanita', 'nik_wanita',
        'agama_wanita', 'pekerjaan_wanita', 'alamat_wanita', 'nama_ayah_wanita', 'nama_ibu_wanita',
        'tanggal_pernikahan', 'tempat_pernikahan',
        'email', 'nomor_hp',
        'ktp_pria', 'ktp_wanita',
        'surat_baptis_pria', 'surat_baptis_wanita',
        'surat_pengantar_kombas_pria', 'surat_pengantar_kombas_wanita',
        'status', 'catatan',
        'metode_pembayaran', 'bukti_pembayaran', 'status_pembayaran',
    ];

    protected $casts = [
        'tanggal_lahir_pria'   => 'date',
        'tanggal_lahir_wanita' => 'date',
        'tanggal_pernikahan'   => 'date',
    ];
}
