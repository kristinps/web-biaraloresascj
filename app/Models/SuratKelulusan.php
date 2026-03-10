<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SuratKelulusan extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'surat_kelulusan';

    protected $fillable = ['pendaftaran_id', 'file', 'nama_surat'];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranPernikahan::class, 'pendaftaran_id');
    }
}
