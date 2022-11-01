<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class TemplatesUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => 'bail|nullable|numeric|min:1|max:3',
            'lastName' => 'bail|nullable|string',
            'firstName' => 'bail|nullable|string',
            'middleName' => 'bail|string|nullable',
            'applicant_fio' => 'bail|nullable|string',
            'headLastName' => 'bail|nullable|string',
            'headFirstName' => 'bail|nullable|string',
            'headMiddleName' => 'bail|string|nullable',
            'head_fio' => 'bail|nullable|string',
            'HeadPosition' => 'bail|nullable|string',
            'company' => 'bail|nullable|string',
            'position' => 'bail|nullable|string',
            'department' => 'bail|nullable|string',
            'passportSerial' => 'bail|nullable|string|min:4|max:4',
            'passportNumber' => 'bail|nullable|string|min:6|max:6',
            'passportDate' => 'bail|nullable|string|min:10|max:10',
            'passportCode' => 'bail|nullable|string|min:6|max:6',
            'passportDivision' => 'bail|nullable|string',
            'gender' => 'bail|nullable|string|min:1|max:1',
            'birthDate' => 'bail|nullable|string|min:10|max:10',
            'inn' => 'bail|nullable|string|min:10|max:10',
            'personInn' => 'bail|nullable|string|min:12|max:12',
            'ogrn' => 'bail|nullable|string|min:13|max:15',
            'kpp' => 'bail|nullable|string|min:9|max:9',
            'snils' => 'bail|nullable|string|min:11|max:11',
            'email' => 'bail|nullable|email',
            'phone' => 'bail|nullable|string|min:10|max:10',
            'companyPhone' => 'bail|nullable|string|min:10|max:10',
            'region' => 'bail|nullable|numeric',
            'city' => 'bail|nullable|string',
            'address' => 'bail|nullable|string',
            'index' => 'bail|nullable|string',
            'offerJoining' => 'bail|nullable|boolean',
            'products' => 'bail|nullable|string',
        ];
    }
}
