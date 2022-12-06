<?php

namespace App\Http\Resources\RemoteGeneration;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\RemoteGeneration\RgApplicationsTemplate */
class RgUrDnGenerationResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'dn' => [
                '2.5.4.4' => $this->lastName,
                '2.5.4.42' => trim($this->firstName . ' ' . $this->middleName),
                '2.5.4.12' => $this->position,
                '2.5.4.3' => $this->company,
                '2.5.4.10' => $this->company,
                '2.5.4.11' => $this->department,
                '2.5.4.6' => 'RU',
                '2.5.4.8' => $this->region > 10 ? strval($this->region) : '0' . strval($this->region),
                '2.5.4.7' => $this->city,
                '2.5.4.9' => $this->address,
                '1.2.643.100.1' => $this->ogrn,
                '1.2.643.100.3' => $this->snils,
                '1.2.643.3.131.1.1' => $this->personInn,
                '1.2.643.100.4' => $this->inn,
                '1.2.840.113549.1.9.1' => $this->email,
            ],
            'IdentificationKind' => $this->identificationKind,
        ];
    }
}
