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
            'lastName' => 'bail|required|string',
            'firstName' => 'bail|required|string',
            'middleName' => 'bail|string|nullable',
            'applicant_fio' => 'bail|required|string',
            'headLastName' => 'bail|required|string',
            'headFirstName' => 'bail|required|string',
            'headMiddleName' => 'bail|string|nullable',
            'head_fio' => 'bail|required|string',
            'HeadPosition' => 'bail|required|string',
            'company' => 'bail|required|string',
            'position' => 'bail|required|string',
            'department' => 'bail|required|string',
            'passportSerial' => 'bail|required|string|min:4|max:4',
            'passportNumber' => 'bail|required|string|min:6|max:6',
            'passportDate' => 'bail|required|string|min:10|max:10',
            'passportCode' => 'bail|required|string|min:6|max:6',
            'passportDivision' => 'bail|required|string',
            'gender' => 'bail|required|string|min:1|max:1',
            'birthDate' => 'bail|required|string|min:10|max:10',
            'inn' => 'bail|required|string|min:10|max:10',
            'personInn' => 'bail|required|string|min:12|max:12',
            'ogrn' => 'bail|required|string|min:13|max:15',
            'kpp' => 'bail|required|string|min:9|max:9',
            'snils' => 'bail|required|string|min:11|max:11',
            'email' => 'bail|required|email',
            'phone' => 'bail|required|string|min:10|max:10',
            'companyPhone' => 'bail|required|string|min:10|max:10',
            'region' => 'bail|required|numeric',
            'city' => 'bail|required|string',
            'address' => 'bail|required|string',
            'index' => 'bail|required|string',
            'offerJoining' => 'bail|required|boolean',
            'products' => 'bail|required|string',
        ];
    }
}
