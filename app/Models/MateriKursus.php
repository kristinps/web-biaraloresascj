<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MateriKursus extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'materi_kursus';

    protected $fillable = [
        'periode_id', 'judul', 'nama_pemateri', 'deskripsi', 'file_materi', 'zoom_link',
        'tanggal_pelaksanaan', 'urutan', 'terkirim_materi', 'terkirim_zoom',
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
        'terkirim_materi'     => 'boolean',
        'terkirim_zoom'       => 'boolean',
    ];

    public function periode() { return $this->belongsTo(PeriodePernikahan::class, 'periode_id'); }
    public function kehadiran() { return $this->hasMany(KehadiranKursus::class, 'materi_kursus_id'); }
}
