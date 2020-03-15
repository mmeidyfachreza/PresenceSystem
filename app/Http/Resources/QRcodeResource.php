<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QRcodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'qrcode' => $this->qrcode,
            // 'name' => $this->name,
            // 'email' => $this->email,
        ];
    }
}
