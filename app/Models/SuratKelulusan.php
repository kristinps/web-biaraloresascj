<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKelulusan extends Model
{
    protected $table = 'surat_kelulusan';

    protected $fillable = ['pendaftaran_id', 'file', 'nama_surat'];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranPernikahan::class, 'pendaftaran_id');
    }
}
