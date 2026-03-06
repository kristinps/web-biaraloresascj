<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriKursus extends Model
{
    protected $table = 'materi_kursus';

    protected $fillable = [
        'periode_id', 'judul', 'deskripsi', 'file_materi', 'zoom_link',
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
