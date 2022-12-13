<?php

namespace App\Http\Resources\RemoteGeneration;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\RemoteGeneration\RgClient */
class RgClientShowResource extends JsonResource
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
            'email' => $this->email,
            'group' => $this->group,
            'note' => $this->note,
        ];
    }
}
