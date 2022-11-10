<?php

namespace App\Http\Resources\RemoteGeneration;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\RemoteGeneration\RgApplicationsTemplate */
class RgApplicationsTemplateResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'BasisOfActs' => $this->BasisOfActs,
            'identificationKind' => $this->identificationKind,
            'created_by' => $this->manager->fio,
            'type' => $this->type,
            'firstName' => $this->firstName,
            'middleName' => $this->middleName,
            'lastName' => $this->lastName,
            'applicant_fio' => $this->applicant_fio,
            'headLastName' => $this->headLastName,
            'headFirstName' => $this->headFirstName,
            'headMiddleName' => $this->headMiddleName,
            'head_fio' => $this->head_fio,
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
            'region' => $this->region,
            'city' => $this->city,
            'address' => $this->address,
            'index' => $this->index,
            'offerJoining' => $this->offerJoining,
            'products' => $this->products,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
