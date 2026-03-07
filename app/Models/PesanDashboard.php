<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesanDashboard extends Model
{
    protected $table = 'pesan_dashboard';

    protected $fillable = ['user_id', 'dari_user_id', 'judul', 'isi', 'dibaca_at'];

    protected $casts = ['dibaca_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dariUser()
    {
        return $this->belongsTo(User::class, 'dari_user_id');
    }
}
