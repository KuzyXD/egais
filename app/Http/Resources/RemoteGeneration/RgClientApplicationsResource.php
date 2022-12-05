<?php

namespace App\Http\Resources\RemoteGeneration;

use App\Enums\TranslatedStatuses;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\RemoteGeneration\RgApplications */
class RgClientApplicationsResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => TranslatedStatuses::from($this->status)->value,
            'comment' => $this->comment,
            'serial_number_certificate' => $this->serial_number_certificate,
            'certificate_produced_at' => $this->certificate_produced_at,
            'certificate_finished_at' => $this->certificate_finished_at,
            'replace_serial_key' => $this->replace_serial_key,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
