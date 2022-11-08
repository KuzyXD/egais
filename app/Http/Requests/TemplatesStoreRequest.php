<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class TemplatesStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => 'bail|required|numeric|min:1|max:3',
            'identificationKind' => 'bail|required|numeric|min:0|max:1',
            'BasisOfActs' => 'bail|required_if:type,3|string',
            'lastName' => 'bail|required|string',
            'firstName' => 'bail|required|string',
            'middleName' => 'bail|string|nullable',
            'headLastName' => 'bail|required_if:type,3|string',
            'headFirstName' => 'bail|required_if:type,3|string',
            'headMiddleName' => 'bail|string|nullable',
            'HeadPosition' => 'bail|required_if:type,3|string',
            'company' => 'bail|required_if:type,3|string',
            'position' => 'bail|required_if:type,3|string',
            'department' => 'bail|required_if:type,3|string',
            'passportSerial' => 'bail|required|string|min:4|max:4',
            'passportNumber' => 'bail|required|string|min:6|max:6',
            'passportDate' => 'bail|required|string|min:10|max:10',
            'passportCode' => 'bail|required|string|min:6|max:6',
            'passportDivision' => 'bail|required|string',
            'gender' => 'bail|required|string|min:1|max:1',
            'birthDate' => 'bail|required|string|min:10|max:10',
            'inn' => 'bail|required|string|min:10|max:10',
            'personInn' => 'bail|required_if:type,3|string|min:12|max:12',
            'ogrn' => 'bail|required_unless:type,1|string|min:13|max:15',
            'kpp' => 'bail|required_if:type,3|string|min:9|max:9',
            'snils' => 'bail|required|string|min:11|max:11',
            'email' => 'bail|required|email',
            'phone' => 'bail|required|string|min:10|max:10',
            'companyPhone' => 'bail|required_unless:type,1|string|min:10|max:10',
            'region' => 'bail|required|numeric',
            'city' => 'bail|required_unless:type,2|string',
            'address' => 'bail|required_if:type,3|string',
            'index' => 'bail|required_if:type,3|string',
            'offerJoining' => 'bail|required|boolean',
            'products' => 'bail|required|string',
        ];
    }
}
