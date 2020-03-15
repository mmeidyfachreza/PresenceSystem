<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    //
    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }
}
