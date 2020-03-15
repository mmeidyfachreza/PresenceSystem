<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\presensiResource;
use App\Karyawan;
use App\Presensi;
use Carbon\Carbon;

class presensiController extends Controller
{
    //
    public function getUpdate($id)
    {
        # code...

        $karyawan = Karyawan::find($id);
        $mytime = Carbon::now();
        $presensi = Presensi::where('karyawan_id', '=', $karyawan->id)->Where('tanggal', '=', $mytime->toDateString())->first();
        if ($presensi) {


            // return response()->json([
            //     'data'=>'selesai'
            // ]);
            return new presensiResource($presensi);
             //return response()->json($presensi);
        }

        return response()->json([
            'data'=>'selesai'
        ]);

        // return response()->json([
        //     'data'=>['status'=>'false']
        // ]);
    }

    public function simpan(Request $request)
    {
        //
        $data = $request->validate([
            'longitude' => 'required',
            'latitude' => 'required'
        ]);

        $mytime = Carbon::now();
        if (!$presensi = Presensi::where('karyawan_id', '=', $request->id)->Where('tanggal', '=', $mytime->toDateString())->first()) {
            Presensi::insert([
                'karyawan_id' => $request->id,
                'tanggal' => $mytime->toDateString(),
                'jam_hadir'=>$mytime->toTimeString(),
                'latitude'=>$request->latitude,
                'longitude'=>$request->longitude,
                'validasi'=>'tidak'
            ]);
        }

        return response()->json([
            'jam_hadir'=>$mytime->toTimeString(),
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
        ]);

    }
}
