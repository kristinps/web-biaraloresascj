<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BiayaTagihan extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'biaya_tagihan';

    protected $fillable = [
        'biaya_id',
        'pendaftaran_id',
        'status',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'qris_url',
        'qris_expired_at',
    ];

    protected $casts = [
        'qris_expired_at' => 'datetime',
    ];

    public function biaya()
    {
        return $this->belongsTo(Biaya::class, 'biaya_id');
    }

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranPernikahan::class, 'pendaftaran_id');
    }
}

