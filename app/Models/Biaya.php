<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biaya extends Model
{
    protected $table = 'biaya';

    protected $fillable = ['jenis', 'nominal', 'keterangan', 'periode_id', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function periode()
    {
        return $this->belongsTo(PeriodePernikahan::class, 'periode_id');
    }
}
