<?php

namespace App\Http\Resources\RemoteGeneration;

use App\Enums\TranslatedStatuses;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\RemoteGeneration\RgApplications */
class RgApplicationResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ac_id' => $this->ac_id,
            'status' => TranslatedStatuses::from($this->status)->value,
            'pin_code' => $this->pin_code,
            'comment' => $this->comment,
            'template_id' => $this->template_id,
            'store_number' => $this->store_number,
            'action_type' => $this->action_type,
            'serial_number_certificate' => $this->serial_number_certificate,
            'certificate_produced_at' => $this->certificate_produced_at,
            'certificate_finished_at' => $this->certificate_finished_at,
            'replace_serial_key' => $this->replace_serial_key,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
