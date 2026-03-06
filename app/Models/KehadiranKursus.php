<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KehadiranKursus extends Model
{
    protected $table = 'kehadiran_kursus';

    protected $fillable = [
        'pendaftaran_id', 'materi_kursus_id', 'hadir_tatap_muka', 'hadir_zoom', 'catatan',
    ];

    protected $casts = [
        'hadir_tatap_muka' => 'boolean',
        'hadir_zoom'       => 'boolean',
    ];

    public function pendaftaran() { return $this->belongsTo(PendaftaranPernikahan::class, 'pendaftaran_id'); }
    public function materi() { return $this->belongsTo(MateriKursus::class, 'materi_kursus_id'); }
}
