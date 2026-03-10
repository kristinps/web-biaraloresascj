<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PeriodePernikahan extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'periode_pernikahan';

    protected $fillable = ['nama', 'tanggal_mulai', 'tanggal_selesai', 'status', 'catatan'];

    protected $casts = ['tanggal_mulai' => 'date', 'tanggal_selesai' => 'date'];

    public function pendaftaran() { return $this->hasMany(PendaftaranPernikahan::class, 'periode_id'); }
    public function materi() { return $this->hasMany(MateriKursus::class, 'periode_id')->orderBy('urutan'); }
    public function scopeAktif($query) { return $query->where('status', 'aktif'); }
    public function scopeSelesai($query) { return $query->where('status', 'selesai'); }
    public function isAktif(): bool { return $this->status === 'aktif'; }
    public static function periodeAktif(): ?self { return static::aktif()->latest()->first(); }
}
