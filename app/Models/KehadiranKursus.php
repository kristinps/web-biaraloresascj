<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class KehadiranKursus extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
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
