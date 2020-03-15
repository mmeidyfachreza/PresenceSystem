<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    //
    protected $dates = ['tanggal'];
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
