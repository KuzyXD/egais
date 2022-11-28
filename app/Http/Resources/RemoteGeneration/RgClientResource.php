<?php

namespace App\Http\Resources\RemoteGeneration;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\RemoteGeneration\RgClient */
class RgClientResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fio' => $this->fio,
            'certificate_serial_number' => $this->certificate_serial_number,
            'certificate_expire_to_date' => $this->certificate_expire_to_date,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
