<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class presensiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'status' => true,
            'jam_hadir' => $this->jam_hadir,
            'jam_pulang' => $this->jam_pulang,
            'durasi_kerja' => $this->durasi_kerja,
            'validasi' => $this->validasi,
        ];
    }
}
