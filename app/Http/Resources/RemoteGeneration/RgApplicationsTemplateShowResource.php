<?php

namespace App\Http\Resources\RemoteGeneration;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\RemoteGeneration\RgApplicationsTemplate */
class RgApplicationsTemplateShowResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type == 1 ? 'Физ. лицо' : ($this->type == 2 ? 'ИП' : 'Юр. лицо'),
            'applicant_fio' => $this->applicant_fio,
            'head_fio' => $this->head_fio,
            'products' => $this->products,
            'created_by' => $this->manager->fio,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
