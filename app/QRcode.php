<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QRcode extends Model
{
    //
    protected $table = 'qrcode';
    protected $fillable = ['linkqr_id','qrcode','status'];

    public function linkqr()
    {
        return $this->belongsTo(Linkqr::class);
    }
}
