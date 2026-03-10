<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Biaya extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'biaya';

    protected $fillable = ['jenis', 'nama', 'nominal', 'keterangan', 'periode_id', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function periode()
    {
        return $this->belongsTo(PeriodePernikahan::class, 'periode_id');
    }

    public function tagihan()
    {
        return $this->hasMany(BiayaTagihan::class, 'biaya_id');
    }
}
