<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\RemoteGeneration\RgApplicationsTemplate */
class ApplicationCreateResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->type == 3) {
            return [
                'BasisOfActs' => $this->BasisOfActs,
                'identificationKind' => $this->identificationKind,
                'type' => $this->type,
                'firstName' => $this->firstName,
                'middleName' => $this->middleName,
                'lastName' => $this->lastName,
                'headLastName' => $this->headLastName,
                'headFirstName' => $this->headFirstName,
                'headMiddleName' => $this->headMiddleName,
                'HeadPosition' => $this->HeadPosition,
                'company' => $this->company,
                'position' => $this->position,
                'department' => $this->department,
                'passportSerial' => $this->passportSerial,
                'passportNumber' => $this->passportNumber,
                'passportDate' => $this->passportDate,
                'passportCode' => $this->passportCode,
                'passportDivision' => $this->passportDivision,
                'gender' => $this->gender,
                'birthDate' => $this->birthDate,
                'inn' => $this->inn,
                'personInn' => $this->personInn,
                'ogrn' => $this->ogrn,
                'kpp' => $this->kpp,
                'snils' => $this->snils,
                'email' => $this->email,
                'phone' => $this->phone,
                'companyPhone' => $this->companyPhone,
                'countryId' => $this->countryId,
                'regionLaw' => $this->region,
                'cityLaw' => $this->city,
                'addressLaw' => $this->address,
                'index' => $this->index,
                'offerJoining' => $this->offerJoining,
                'products' => explode(',', $this->products),
            ];
        }

    }
}
