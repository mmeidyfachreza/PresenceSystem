<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Linkqr extends Model
{
    //
    protected $table = 'linkqr';
    protected $fillable = [
        'link',
        'nama',
        'no_hp',
        'jabatan',
        'nama_p',
        'alamat_p',
        'email',
        'tanggal',
        'user_id',
        'status',
        'latitude',
        'longitude',
        'permintaan',
        'mulai',
        'selesa'
    ];

    public function qrcode()
    {
        return $this->hasMany(QRcode::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
