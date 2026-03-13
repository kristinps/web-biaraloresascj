<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Notifications\Notifiable;

class PendaftaranPernikahan extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
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
        'status_dokumen', 'catatan_dokumen', 'perbaikan_dokumen_user', 'dokumen_status_verifikasi', 'status_kursus',
        'status_pembayaran', 'midtrans_order_id', 'midtrans_snap_token', 'midtrans_transaction_id',
        'qris_url', 'qris_expired_at', 'email_konfirmasi_pembayaran_sent_at', 'plain_password_for_email',
    ];

    protected $hidden = [
        'plain_password_for_email',
    ];

    protected $casts = [
        'dokumen_status_verifikasi' => 'array',
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

    /** Daftar field dokumen dengan label */
    public static function dokumenFields(): array
    {
        return [
            'ktp_pria' => 'KTP Calon Pria',
            'ktp_wanita' => 'KTP Calon Wanita',
            'foto_pria' => 'Foto Calon Pria',
            'foto_wanita' => 'Foto Calon Wanita',
            'surat_baptis_pria' => 'Surat Baptis Pria',
            'surat_baptis_wanita' => 'Surat Baptis Wanita',
            'surat_pengantar_kombas_pria' => 'Surat Pengantar Kombas Pria',
            'surat_pengantar_kombas_wanita' => 'Surat Pengantar Kombas Wanita',
        ];
    }

    /**
     * Status verifikasi dokumen per field.
     *
     * true  => dokumen sudah dinyatakan diterima admin
     * false => belum dinyatakan diterima (sedang diperiksa / perlu perbaikan / belum ada file)
     */
    public function getStatusDokumen(string $field): bool
    {
        $status = $this->dokumen_status_verifikasi[$field] ?? null;
        return filter_var($status, FILTER_VALIDATE_BOOLEAN);
    }
}
