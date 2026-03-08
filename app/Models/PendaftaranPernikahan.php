<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PendaftaranPernikahan extends Model
{
    use Notifiable;

    protected $table = 'pendaftaran_pernikahan';

    protected $fillable = [
        'user_id',
        'periode_id',
        'nama_pria', 'tempat_lahir_pria', 'tanggal_lahir_pria', 'nik_pria',
        'agama_pria', 'pekerjaan_pria', 'alamat_pria', 'nama_ayah_pria', 'nama_ibu_pria',
        'nama_wanita', 'tempat_lahir_wanita', 'tanggal_lahir_wanita', 'nik_wanita',
        'agama_wanita', 'pekerjaan_wanita', 'alamat_wanita', 'nama_ayah_wanita', 'nama_ibu_wanita',
        'tanggal_pernikahan', 'tempat_pernikahan',
        'email', 'nomor_hp',
        'ktp_pria', 'ktp_wanita',
        'foto_pria', 'foto_wanita',
        'surat_baptis_pria', 'surat_baptis_wanita',
        'surat_pengantar_kombas_pria', 'surat_pengantar_kombas_wanita',
        'status', 'catatan',
        'status_dokumen', 'catatan_dokumen', 'status_kursus',
        'status_pembayaran', 'midtrans_order_id', 'midtrans_snap_token', 'midtrans_transaction_id',
        'qris_url', 'qris_expired_at', 'email_konfirmasi_pembayaran_sent_at',
    ];

    protected $casts = [
        'tanggal_lahir_pria'   => 'date',
        'tanggal_lahir_wanita' => 'date',
        'tanggal_pernikahan'   => 'date',
        'qris_expired_at'      => 'datetime',
        'email_konfirmasi_pembayaran_sent_at' => 'datetime',
    ];

    public function routeNotificationForMail($notification): string
    {
        return $this->email;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodePernikahan::class, 'periode_id');
    }

    public function kehadiran()
    {
        return $this->hasMany(KehadiranKursus::class, 'pendaftaran_id');
    }

    public function namaLengkap(): string
    {
        return $this->nama_pria . ' & ' . $this->nama_wanita;
    }
}
